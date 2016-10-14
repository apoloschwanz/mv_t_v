<?php
class Coordinador_para_asignar extends Entidadi {
	protected $mail ;
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Docentes" ;
		}
	protected function Carga_Sql_Lectura_x_Mail()
	{
	$this->strsql = " SELECT coordinadores.Coordinador_Id, 
							personas.`Apellido y Nombre`, 
							coordinadores.`Teléfono` , 
							coordinadores.Mail , 
							personas.DNI
										FROM coordinadores 
										INNER JOIN personas 
										ON coordinadores.persona_Id = personas.Persona_Id 
										WHERE coordinadores.Mail = '".$this->mail."'" ;
	}
	public function Leer_x_mail($mail)
	{ $this->mail = $mail ;
		$this->Carga_Sql_Lectura_x_Mail();		
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el select de ".$this->nombre_tabla." por mail : ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
		$cn->cerrar();
		if ( $this->registro=mysqli_fetch_array($this->registros) )
			{
				$this->existe = true ;
			}
		else
			{ 
				$this->existe = false ;
			}
		$this->Leer_Detalle();
	}
	protected function Carga_Sql_Lectura()
	{
	$this->strsql = " SELECT coordinadores.Coordinador_Id, personas.`Apellido y Nombre`
										FROM coordinadores 
										INNER JOIN personas 
										ON coordinadores.Persona_Id = personas.Persona_Id 
										WHERE coordinadores.Coordinador_Id = '".$this->id."'" ;
	}
	public function probar($Crono_Id)
	{
		$txt='';
		$txt.= ' <br><br> Crono a asignar: <br> ' ;
		$txt.= $this->txtsqlCronoAAsignar($Crono_Id);
		//
		$txt.= ' <br><br> Coordinadores de la Comuna: <br> ' ;
		$txt.= $this->txtsqlCordosComuna($Crono_Id);
		//
		$txt.= ' <br><br> Coordinadores Dia Turno: <br> ' ;
		$txt.= $this->txtsqlCordosDiaTurno($Crono_Id) ;
		//
		$txt.= ' <br><br> Coordinadores Dia Turno Comuna: <br> ' ;
		$txt.= $this->txtsqlCordosDiaTurnoComuna($Crono_Id);
		//
		$txt.= ' <br><br> Capas Superpuestas: <br> ' ;
		$txt.= $this->txtsqlCapasSuperpuestas($Crono_Id) ;
		//
		$txt.= ' <br><br> Ocupados: <br> ' ;
		$txt.= $this->txtsqlOcupados($Crono_Id) ;
		//
		$txt.= ' <br><br> Todo: <br> ' ;
		$this->Carga_Sql_Lista_x_Crono($Crono_Id);
		$txt.= $this->strsql ;
		return $txt ;
		
	}
	protected function txtsqlCordosDiaTurnoComuna($Crono_Id)
	{
		$txtsql = NULL;
		$tsDiaTurno = $this->txtsqlCordosDiaTurno($Crono_Id) ;
		$tsComuna = $this->txtsqlCordosComuna($Crono_Id) ;
		$txtsql = " SELECT DISTINCT DT.Coordinador_Id 
					FROM ( $tsDiaTurno ) as DT
					INNER JOIN ( $tsComuna ) as CM 
					on DT.Coordinador_Id = CM.Coordinador_Id " ;
		return $txtsql ;
	}
	protected function txtsqlCordosDiaTurno($Crono_Id)
	{
		$txtsql = NULL;
		$txtsqlCronoAAsignar = $this->txtsqlCronoAAsignar($Crono_Id);
		$txtsql = " SELECT DISTINCT turnos_del_coordinador.Coordinador_Id 
					FROM turnos_del_coordinador
					INNER JOIN  ( $txtsqlCronoAAsignar ) AS CA
					ON turnos_del_coordinador.Turno_Id = CA.Turno_Id " ;
						// AND turnos_por_dia_del_coordinador.Dia_Nro = CA.Dia_Nro " ;
						// Los cordinadores no tienen dia turno.... solo tiene turno (igual para todos los dias)
		return $txtsql ;
	}
	protected function txtsqlCordosComuna($Crono_Id)
	{
		$txtsql = NULL;
		$txtsqlCronoAAsignar = $this->txtsqlCronoAAsignar($Crono_Id);
		$txtsql = " SELECT DISTINCT comunas_x_coordinador.Coordinador_Id FROM comunas_x_coordinador
					WHERE comunas_x_coordinador.COMUNA_Nro in
					( SELECT COMUNA FROM ( $txtsqlCronoAAsignar ) AS CC   )  " ;
		return $txtsql;
	}
	protected function txtsqlOcupados($Crono_Id)
	{
		$txtsql = NULL;
		$txtSuperpuestas = $this->txtsqlCapasSuperpuestas($Crono_Id) ;
		$txtsql = "	SELECT coordinadores_de_la_capacitacion.Coordinador_Id 
						FROM coordinadores_de_la_capacitacion 
						WHERE coordinadores_de_la_capacitacion.Crono_Id in ( $txtSuperpuestas ) " ;
		return $txtsql;
	}
	protected function txtsqlCapasSuperpuestas($Crono_Id)
	{	
		$txtsql = NULL;
		$txtsqlCronoAAsignar = $this->txtsqlCronoAAsignar($Crono_Id);
		$txtsql = "	SELECT 	capacitaciones.Crono_ID
						FROM capacitaciones , ( $txtsqlCronoAAsignar ) as CAA
						WHERE capacitaciones.Fecha = CAA.Fecha
						AND ( capacitaciones.Hora_Desde <= CAA.Hora_Hasta and capacitaciones.Hora_Hasta >= CAA.Hora_Desde ) " ;
		return $txtsql;
	}
	protected function txtsqlCronoAAsignar($Crono_Id)
	{	
		$txtsql = NULL;
		$txtsql = "	SELECT 	capacitaciones.Crono_ID, capacitaciones.CUE, 
							capacitaciones.Fecha, capacitaciones.Hora_Desde, 
							capacitaciones.Hora_Hasta , capacitaciones.Turno_Id ,
							DAYOFWEEK(capacitaciones.Fecha) as Dia_Nro , escuelas_general.COMUNA
						FROM capacitaciones
						LEFT JOIN escuelas_general on capacitaciones.CUE = escuelas_general.CUE
						WHERE capacitaciones.Crono_Id = '$Crono_Id' " ;
		return $txtsql;
	}
	protected function Carga_Sql_Lista_x_Crono($Crono_Id)
	{	
		// Lista de Coordinadores
		//		que pueden en ese dia turno y comuna
		//    		<txtsqlDocentesDiaTurnoComuna>
		//				que estan para ese dia y turno
		//					<txtsqlDocentesDiaTurno>
		//						cuyo dia y turno coincide con los datos de la capacitacion
		//							<txtsqlCronoAAsignar>
		//
		//				y que estan para esa comuna
		//					<txtsqlDocentesComuna>
		//						cuya comuna coincide con los detos de la capacitacion
		//							<txtsqlCronoAAsignar>
		//
		//
		//
		//		y que aun no estan ocupados
		// 			<Ocupados>
		//     			los que estan en 
		//						<Capas Superpuestas>
		//							las que coinciden con 
		//								<txtsqlCronoAAsignar>
		
		$txtsqlDiaTurnoComuna = $this->txtsqlCordosDiaTurnoComuna($Crono_Id);
		$txtsqlOcupados = $this->txtsqlOcupados($Crono_Id);
		$estSuge =  'P'  ; // $estSuge =  'S'  ;
		$this->strsql = "	SELECT coordinadores.Coordinador_Id,'Disponibles ', personas.`Apellido y Nombre` , '".$estSuge."', 'Asignado por Coordinador'
										FROM coordinadores
										INNER JOIN ( $txtsqlDiaTurnoComuna ) as dtc
										ON coordinadores.Coordinador_Id = dtc.Coordinador_Id
										INNER JOIN personas 
										ON coordinadores.Persona_Id = personas.Persona_Id 
										WHERE coordinadores.Estado=1 
										AND coordinadores.Coordinador_Id not in ( SELECT OC.Coordinador_Id from ( $txtsqlOcupados ) as OC ) 
										" ;
							// " 			;
		$this->lista_campos_descrip=array() ;
		$this->lista_campos_tipo=array() ;
		$this->lista_campos_descrip[]='Coord. #' ;
		$this->lista_campos_descrip[]='Coordinador' ;
		$this->lista_campos_tipo[]='pk' ; // 'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password' 
		$this->lista_campos_tipo[]='otro';

	}
	public function Obtener_Lista_x_Crono($Crono_Id)
		{
			$this->leer_lista_x_crono($Crono_Id);
			if ( $this->existe == true )
				{
					mysqli_data_seek ( $this->registros , 0 ) ;
					return $this->registros;
				}
			else
				{ return null ;
				}
		}

	public function leer_lista_x_crono($Crono_Id)
	{ $this->Carga_Sql_Lista_x_Crono($Crono_Id);		
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el select de la lista de ".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
		$cn->cerrar();
		if ( $this->registro=mysqli_fetch_array($this->registros) )
			{
				$this->existe = true ;
				mysqli_data_seek ( $this->registros , 0 ) ;
			}
		else
			{
				$this->existe = false ;
			}
		$this->Leer_Detalle();
	}

}
?>
