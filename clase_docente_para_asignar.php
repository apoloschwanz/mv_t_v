<?php

class Docente_para_asignar extends Entidadi {
	protected $mail ;
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Docentes" ;
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
	$this->strsql = " SELECT docente.Docente_Nro, personas.`Apellido y Nombre`
										FROM docente 
										INNER JOIN personas 
										ON docente.Persona_Id = personas.Persona_Id 
										WHERE docente.Docente_Nro = '".$this->id."'" ;
	}
	protected function txtsqlSolicitantes($Crono_Id)
	{
		$txtsql = NULL;
		$txtOcupados = $this->txtsqlOcupados($Crono_Id);
		$txtsql = "SELECT solicitudes_de_asignacion_de_capacitacion.Docente_Nro, 
						solicitudes_de_asignacion_de_capacitacion.Crono_Id 
						FROM solicitudes_de_asignacion_de_capacitacion
						WHERE solicitudes_de_asignacion_de_capacitacion.Crono_Id = '$Crono_Id' 
						AND solicitudes_de_asignacion_de_capacitacion.Docente_Nro not in ( $txtOcupados )" 
						
						;
		return $txtsql ;
	}
	public function probar($Crono_Id)
	{
		// return $this->txtsqlCronoAAsignar($Crono_Id);
		// return $this->txtsqlDocentesComuna($Crono_Id);
		return $this->txtsqlDocentesDiaTurnoComuna($Crono_Id);
	}
	protected function txtsqlDocentesDiaTurnoComuna($Crono_Id)
	{
		$txtsql = NULL;
		$tsDiaTurno = $this->txtsqlDocentesDiaTurno($Crono_Id) ;
		$tsComuna = $this->txtsqlDocentesComuna($Crono_Id) ;
		$txtsql = " SELECT DISTINCT DT.Docente_Nro 
					FROM ( $tsDiaTurno ) as DT
					INNER JOIN ( $tsComuna ) as CM 
					on DT.Docente_Nro = CM.Docente_Nro " ;
		return $txtsql ;
	}
	protected function txtsqlDocentesDiaTurno($Crono_Id)
	{
		$txtsql = NULL;
		$txtsqlCronoAAsignar = $this->txtsqlCronoAAsignar($Crono_Id);
		$txtsql = " SELECT DISTINCT turnos_por_dia_del_docente.Docente_Nro 
					FROM turnos_por_dia_del_docente
					INNER JOIN  ( $txtsqlCronoAAsignar ) AS CA
					ON turnos_por_dia_del_docente.Turno_Id = CA.Turno_Id 
						AND turnos_por_dia_del_docente.Dia_Nro = CA.Dia_Nro " ;
		return $txtsql ;
	}
	protected function txtsqlDocentesComuna($Crono_Id)
	{
		$txtsql = NULL;
		$txtsqlCronoAAsignar = $this->txtsqlCronoAAsignar($Crono_Id);
		$txtsql = " SELECT DISTINCT comunas_x_docente.Docente_Nro FROM comunas_x_docente
					WHERE comunas_x_docente.Comuna_Nro in
					( SELECT COMUNA FROM ( $txtsqlCronoAAsignar ) AS CC   ) " ;
		return $txtsql;
	}
	protected function txtsqlOcupados($Crono_Id)
	{
		$txtsql = NULL;
		$txtSuperpuestas = $this->txtsqlCapasSuperpuestas($Crono_Id) ;
		$txtsql = "	SELECT docentes_de_la_capacitacion.Docente_Nro 
						FROM `docentes_de_la_capacitacion` 
						WHERE docentes_de_la_capacitacion.Crono_Id in ( $txtSuperpuestas ) " ;
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
		$txtsqlDiaTurnoComuna = $this->txtsqlDocentesDiaTurnoComuna($Crono_Id);
		$txtsqlOcupados = $this->txtsqlOcupados($Crono_Id);
		$txtsolicitantes = $this->txtsqlSolicitantes($Crono_Id) ;
		$estSol = 'P'  ; // $estSol = 'C'  ;
		$estSuge =  'P'  ; // $estSuge =  'S'  ;
		$this->strsql = "	SELECT docente.Docente_Nro,'Solicitan la capacitacion', personas.`Apellido y Nombre` , '".$estSol."', 'Solicitud Capacitador'
										FROM docente 
										INNER JOIN ( $txtsolicitantes ) as sol
										ON docente.Docente_Nro = sol.Docente_Nro
										INNER JOIN personas 
										ON docente.Persona_Id = personas.Persona_Id 
										WHERE docente.Activo=1 
							UNION ALL
							SELECT docente.Docente_Nro,'Disponibles ', personas.`Apellido y Nombre` , '".$estSuge."', 'Asignado por Coordinador'
										FROM docente
										INNER JOIN ( $txtsqlDiaTurnoComuna ) as dtc
										ON docente.Docente_Nro = dtc.Docente_Nro
										INNER JOIN personas 
										ON docente.Persona_Id = personas.Persona_Id 
										WHERE docente.Activo=1 
										AND docente.Docente_Nro not in ( SELECT OC.Docente_Nro from ( $txtsqlOcupados ) as OC ) 
										AND docente.Docente_Nro not in ( SELECT sl.Docente_Nro from ( $txtsolicitantes ) as sl )" ;
										//AND docente.Docente_Nro not in ( SELECT Docente_Nro from ( $txtsqlOcupados ) as OC )
										//AND docente.Docente_Nro not in ( $txtsolicitantes )
							// " 			;
		$this->lista_campos_descrip=array() ;
		$this->lista_campos_tipo=array() ;
		$this->lista_campos_descrip[]='Dcte. #' ;
		$this->lista_campos_descrip[]='Docente' ;
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
