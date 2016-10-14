<?php

include_once 'clase_establecimiento.php' ;
include_once 'clase_turno.php' ;
include_once 'clase_estado_capacitaciones.php' ;
include_once 'clase_programa.php' ;
include_once 'clase_parametro.php' ;


class crono extends entidadi {
	private $edicion;
	public function Pone_Edicion ($Edicion_Nro)
		{
			$this->edicion = $Edicion_Nro ;
		}
	protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_crono_' ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Cronograma" ;
			$this->nombre_fisico_tabla = "capacitaciones" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					// by DZ 2015-08-14 - agregado lista de datos
			$this->cuenta = 15 ;																				// by DZ 2015-08-14 - agregado lista de datos			
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'other' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'Crono_Id' 	, 'tipo'=>'pk' 		, 'descripcion'=>'#' 											, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Fecha' 			, 'tipo'=>'date' 	, 'descripcion'=>'Fecha' 									, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'CUE' 				, 'tipo'=>'fk' 		, 'descripcion'=>'Escuela'								, 'clase'=>new Establecimiento() ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Turno_Id' 	, 'tipo'=>'fk'		, 'descripcion'=>'Turno' 										, 'clase'=>new Turno() ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Hora_Desde' , 'tipo'=>'time'	, 'descripcion'=>'Desde' 									, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Hora_Hasta' , 'tipo'=>'time'	, 'descripcion'=>'Hasta' 									, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Estado'	, 'tipo'=>'fk'		, 'descripcion'=>'Estado' 									, 'clase'=>new Estado_Capacitaciones() ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Matricula' 	, 'tipo'=>'number'	, 'descripcion'=>'Matrícula'							, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'DOMICILIO'	, 'tipo'=>'otro'	, 'descripcion'=>'Direccion'							, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'TIPO'				, 'tipo'=>'otro'	, 'descripcion'=>'Tipo de Establecimiento', 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'COMUNA'			, 'tipo'=>'otro'	, 'descripcion'=>'Comuna' 								, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'BARRIO'			, 'tipo'=>'otro'	, 'descripcion'=>'Barrio' 								, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Programa_Nro'			, 'tipo'=>'fk'	, 'descripcion'=>'Programa' 						, 'clase'=>new Programa() ) ;
			//
			//
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'Crono_Id' 	, 'tipo'=>'pk' 		, 'descripcion'=>'#' 											, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Fecha' 			, 'tipo'=>'date' 	, 'descripcion'=>'Fecha' 									, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'CUE' 				, 'tipo'=>'fk' 		, 'descripcion'=>'Escuela'								, 'clase'=>new Establecimiento() ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Turno_Id' 	, 'tipo'=>'fk'	, 'descripcion'=>'Turno' 										, 'clase'=>new Turno() ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Hora_Desde' , 'tipo'=>'time'	, 'descripcion'=>'Desde' 									, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Hora_Hasta' , 'tipo'=>'time'	, 'descripcion'=>'Hasta' 									, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Estado_Cod'	, 'tipo'=>'fk'	, 'descripcion'=>'Estado' 									, 'clase'=>new Estado_Capacitaciones() ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Matricula' 	, 'tipo'=>'number'	, 'descripcion'=>'Mat.'							, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'DOMICILIO'	, 'tipo'=>'otro'	, 'descripcion'=>'Direccion'							, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'TIPO'				, 'tipo'=>'otro'	, 'descripcion'=>'Tipo', 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'COMUNA'			, 'tipo'=>'otro'	, 'descripcion'=>'Comuna' 								, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'BARRIO'			, 'tipo'=>'otro'	, 'descripcion'=>'Barrio' 								, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Programa_Nro'			, 'tipo'=>'otro'	, 'descripcion'=>'Programa' 						, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Anexo_Nro'			, 'tipo'=>'otro'	, 'descripcion'=>'Anexo' 						, 'clase'=>NULL ) ;
			//
			// Acciones Extra para texto_mostrar_abm
			$this->acciones[] = array( 'nombre'=>'okAsignarDte' , 'texto'=>'Asignar Docente' ) ;
			$this->acciones[] = array( 'nombre'=>'okAsignarCordo' , 'texto'=>'Asignar Coordinador' ) ;
			//
			// Botones Extra para texto_mostrar_abm
			$this->botones_extra_abm[] = array( 'nombre'=>$this->prefijo_campo.'_okExportar' , 'texto'=>'Exportar' ) ;
			//
			// Filtros
			$this->con_filtro_fecha = true;
			$this->con_filtro_general = true;
			//
		}


	public function exportar_a_archivo()
	{
		$stem = $this->prefijo_campo. date("Y-m-d-h_i_sa");
		$stem = 'cr_ono000';
		$archivo = tempnam( 'archivos', $stem ) ;
		$file = fopen($archivo,"w");
		//
		// Encabezado
		$ts_enc = "";
		foreach ( $this->lista_campos_lista as $campo )
		{
			//$ts_enc .= '"'.$campo['nombre'] . '"; ' ;
			$ts_enc .= $campo['nombre'] . '; ' ;
		}
		fwrite($file, $ts_enc . PHP_EOL );
		//
		// Recorre los registros
		$this->leer_filtros();
		$this->leer_lista();
		mysqli_data_seek ( $this->registros , 0 ) ;   
		while( $this->registro=mysqli_fetch_array($this->registros,MYSQLI_NUM) )
		{
			//*****-----//
			for($i=2;$i<count($this->registro);$i++)
			{
				$ts_valor = $this->registro[$i] ;
				$ts_valor = mb_convert_encoding($ts_valor, "Windows-1252","UTF-8");
				fwrite($file, '"'.$ts_valor.'";' ) ;
			}
			fwrite($file, PHP_EOL );
		}
   
		fwrite($file, "Generado el ".date("Y-m-d h:i:sa") . PHP_EOL);
		fclose($file);
		return $archivo ;
	}    

	public function texto_agregar_okGrabar()
		{
			parent::texto_agregar_okGrabar() ;
			if ( $this->error == false )
				{
					//
					// Agrega la Edicion
					//
					$cn=new Conexion();
					//
					$strsql = "UPDATE capacitaciones SET Edicion_Nro = '".$this->edicion."'  WHERE Crono_Id = '".$this->id."' " ;
					$result = $cn->conexion->query($strsql);
					if ( ! $result )
						{
							$this->error = true ;
							$this->textoError = "Problemas en el update de Edicion de ".$this->nombre_tabla." : ".$cn->conexion->error.' '.$strsql ;
						}
					$cn->cerrar();
				}
		}	
		//protected function Pone_nombre ()
	//	{
	//		$this->nombre_tabla = "Cronograma" ;
	//	}
	//protected function Pone_prefijo_campo ()												
	//	{
	//		$this->prefijo_campo = 'm_crono_' ;
	//	}	
	public function leer_filtros()
	{
		if ( $this->con_filtro_fecha )
		{
			if ( isset( $_REQUEST[$this->prefijo_campo.'filtro_f_desde'] ) )
				$this->filtro_f_desde = $_REQUEST[$this->prefijo_campo.'filtro_f_desde'] ;
			else
				$this->filtro_f_desde = date('Y-m-d');
			if ( isset( $_REQUEST[$this->prefijo_campo.'filtro_f_hasta'] ) )
				$this->filtro_f_hasta = $_REQUEST[$this->prefijo_campo.'filtro_f_hasta'] ;
			else
				{ 
					$ahora = new DateTime() ;
					$hasta = date_add($ahora, date_interval_create_from_date_string('11 days'));
					$this->filtro_f_hasta = $hasta->format('Y-m-d') ;//date('Y-m-d',$hasta);
				}
		}
		if ( $this->con_filtro_general )
		{
			if ( isset( $_REQUEST[$this->prefijo_campo.'filtro_general'] ) )
				$this->filtro_gral = $_REQUEST[$this->prefijo_campo.'filtro_general'] ;
			else
				$this->filtro_gral = "" ;
		}
		if ( $this->con_filtro_fecha or $this->con_filtro_general )
		{
			if ( isset( $_REQUEST[$this->prefijo_campo.'filtro_id'] ) )
				$this->filtro_id = $_REQUEST[$this->prefijo_campo.'filtro_id'] ;
			else
				$this->filtro_id = '' ;
		}
			
	}
	protected function Carga_Sql_Lectura()
	{
		$this->strsql = " SELECT 	capacitaciones.Crono_Id, CAST(capacitaciones.Fecha AS DATE) AS Fecha, 
															capacitaciones.CUE, capacitaciones.Turno_Id, 
															DATE_FORMAT( capacitaciones.Hora_Desde, '%H:%i' ) AS Hora_Desde,	DATE_FORMAT( capacitaciones.Hora_Hasta, '%H:%i' ) AS Hora_Hasta, 
															capacitaciones.Estado, 
															capacitaciones.Matricula, 
															escuelas_general.DOMICILIO, escuelas_general.TIPO, 
															escuelas_general.COMUNA, 
															escuelas_general.BARRIO,
															capacitaciones.Programa_Nro
															FROM capacitaciones LEFT JOIN escuelas_general ON escuelas_general.CUE = capacitaciones.CUE
															LEFT JOIN estado_capacitaciones ON estado_capacitaciones.Estado_Cod = capacitaciones.Estado
															LEFT JOIN turnos ON turnos.Turno_ID = capacitaciones.Turno_Id
															Where capacitaciones.Crono_Id = " .$this->id . "  "  ;
			
	}

	protected function Carga_Sql_Lista()
	{
		$this->strsql = " SELECT capacitaciones.Crono_Id as Id, estado_capacitaciones.Color, 
									capacitaciones.Crono_Id, CAST(capacitaciones.Fecha AS DATE) AS Fecha, 
									escuelas_general.NOMBRE, capacitaciones.Turno_Id, 
									DATE_FORMAT( capacitaciones.Hora_Desde, '%H:%i' ) AS Hora_Desde,	DATE_FORMAT( capacitaciones.Hora_Hasta, '%H:%i' ) AS Hora_Hasta, 
									capacitaciones.Estado, 
									capacitaciones.Matricula, 
									escuelas_general.DOMICILIO, escuelas_general.TIPO, 
									escuelas_general.COMUNA, 
									escuelas_general.BARRIO,
									programa.Programa,
									capacitaciones.Anexo_Nro
									FROM capacitaciones LEFT JOIN escuelas_general ON escuelas_general.CUE = capacitaciones.CUE
									LEFT JOIN estado_capacitaciones ON estado_capacitaciones.Estado_Cod = capacitaciones.Estado
									LEFT JOIN turnos ON turnos.Turno_ID = capacitaciones.Turno_Id
									LEFT JOIN programa on capacitaciones.Programa_Nro = programa.Programa_Nro
									Where " ;
									
		$filtro = " capacitaciones.Edicion_Nro = " .$this->edicion . " ";
		//
		// Si hay un id para filtrar
		$hay_id = false ;
		if ( isset( $_REQUEST[$this->prefijo_campo.'filtro_id'] ) )
		{
			if ( ! empty( $this->filtro_id and $this->filtro_id > 0 ) )
			{
				$hay_id = true ;
				$filtro .= " and capacitaciones.Crono_Id = '".$this->filtro_id."'" ;
			}
		}
		//
		// Si no hay id
		if ( ! $hay_id )
		{			 
			$filtro.= 	" AND capacitaciones.Fecha >='".$this->filtro_f_desde."' " ;
			$filtro.= 	" AND capacitaciones.Fecha <='".$this->filtro_f_hasta."' " ;
			if ( isset( $_REQUEST[$this->prefijo_campo.'filtro_general'] ) )
			{
				if( ! empty( $_REQUEST[$this->prefijo_campo.'filtro_general'] ) )
				{
				$filtro.= 	" AND ( escuelas_general.NOMBRE like '%".$this->filtro_gral."%' " ;
				$filtro.= 	" OR  escuelas_general.DOMICILIO like '%".$this->filtro_gral."%' " ;
				$filtro.= 	" OR  capacitaciones.Crono_Id like '%".$this->filtro_gral."%' ) " ;
				}
				
			}
		}
		$this->strsql.= $filtro  ;
		$this->strsql.=		" ORDER BY capacitaciones.Fecha, escuelas_general.NOMBRE, turnos.Turno_orden "  ;
			$this->lista_campos_descrip=array();
			foreach( $this->lista_campos_lista as $campo )
			{
				$this->lista_campos_descrip[] = $campo['descripcion'];
			}
			//$this->lista_campos_descrip[]='#' ;
			//$this->lista_campos_descrip[]='Fecha' ;
			//$this->lista_campos_descrip[]='Escuela' ;
			//$this->lista_campos_descrip[]='Turno' ;
			//$this->lista_campos_descrip[]='Desde' ;
			//$this->lista_campos_descrip[]='Hasta' ;
			//$this->lista_campos_descrip[]='Estado' ;
			//$this->lista_campos_descrip[]='Matrícula' ;
			//$this->lista_campos_descrip[]='Direccion' ;
			//$this->lista_campos_descrip[]='Tipo' ;
			//$this->lista_campos_descrip[]='Comuna' ;
			//$this->lista_campos_descrip[]='Barrio' ;
			//
			$this->lista_campos_tipo[0]='text' ; //'date' 'datetime' 'time' 'number' 'email' 'url' 'password' 
			$this->lista_campos_tipo[1]='text';

	}
	protected function Leer_Detalle_Lista($conexion)
	{
		//
		// Lee detalle para los elementos de la lista
		$this->tiene_lista_detalle = true ;
		$this->lista_detalle_enc_columnas = array( 'Docentes' , 'Coordinadores' ) ;
		mysqli_data_seek ( $this->registros , 0 ) ;
		while( $this->registro=mysqli_fetch_array($this->registros) )
			{
				//
				// Leer detalle para cada elemento de la lista
				//
				// Detalle Uno
				$this->strsql = " SELECT Estado_Asignacion as estado, `Apellido y Nombre` as profe
								FROM `docentes_de_la_capacitacion` 
								LEFT JOIN docente ON docentes_de_la_capacitacion.Docente_Nro = docente.Docente_Nro
								LEFT JOIN personas ON docente.Persona_Id = personas.Persona_Id
								WHERE Crono_Id = '".$this->registro['Crono_Id']."' " ;
				$regsdet=mysqli_query($conexion,$this->strsql) or
				die("Problemas en el select del detalle de ".$this->nombre_tabla.": ".mysqli_error($conexion). " <br><br> Sql= ".$this->strsql );
				$det1 = '<table class="lista_det">' ;
				while( $resdet = mysqli_fetch_array($regsdet) )
					$det1 .= '<tr><td>'.$resdet['estado'].'</td><td>'.$resdet['profe'].'</td></tr>' ;
				$det1 .= '</table>' ; 
				//
				// Detalle Dos
				$this->strsql = " SELECT personas.`Apellido y Nombre` as cordo
									FROM coordinadores_de_la_capacitacion
									LEFT JOIN coordinadores
									ON coordinadores_de_la_capacitacion.Coordinador_Id = coordinadores.Coordinador_Id
									LEFT JOIN personas
									ON coordinadores.Persona_Id = personas.Persona_Id
								WHERE Crono_Id = '".$this->registro['Crono_Id']."' " ;
				$regsdet=mysqli_query($conexion,$this->strsql) or
				die("Problemas en el select del detalle de ".$this->nombre_tabla.": ".mysqli_error($conexion). " <br><br> Sql= ".$this->strsql );
				$det2 = '<table class="lista_det">' ;
				while( $resdet = mysqli_fetch_array($regsdet) )
					$det2 .= '<tr><td>'.$resdet['cordo'].'</td></tr>' ;
				$det2 .= '</table>' ; 
				//
				// Junta los detalles
				$this->lista_detalle[] = array( $det1 , $det2 ) ;
			}
	}
	protected function modifica_trabla()
		{
			$this->strsql = ' ALTER TABLE capacitaciones ADD Programa_Nro INT ' ; 
		}

}


class Solicitudes_de_Asignacion_de_Capacitacion extends Entidad {
	public function Carga_Sql_Capas_Solicitadas(){
		$this->strsql = "SELECT capacitaciones.Crono_Id, CAST(capacitaciones.Fecha AS DATE) AS Fecha, escuelas_general.NOMBRE, escuelas_general.DOMICILIO, capacitaciones.Turno_Id,
										 	CAST( capacitaciones.Hora_Desde AS TIME ) AS Hora_Desde, 
											CAST( capacitaciones.Hora_Hasta AS TIME ) AS Hora_Hasta, 
											docentes.Docente_Nro, personas.`Apellido y Nombre` AS Docente_Nom, docentes.EMAIL
FROM escuelas_general INNER JOIN ((solicitudes_de_asignacion_de_capacitacion INNER JOIN capacitaciones ON solicitudes_de_asignacion_de_capacitacion.Crono_Id = capacitaciones.Crono_Id) INNER JOIN (docentes INNER JOIN personas ON docentes.Persona_Id = personas.Persona_Id) ON solicitudes_de_asignacion_de_capacitacion.Docente_Nro = docentes.Docente_Nro) ON escuelas_general.CUE = capacitaciones.CUE
ORDER BY capacitaciones.Fecha, escuelas_general.NOMBRE, capacitaciones.Hora_Desde, capacitaciones.Hora_Hasta, personas.`Apellido y Nombre`" ;
		
	}
	protected function Carga_Sql_Lista()
		{
		$this->strsql = "SELECT solicitudes_de_asignacion_de_capacitacion.Docente_Nro, solicitudes_de_asignacion_de_capacitacion.Crono_Id, escuelas_general.NOMBRE, 
											escuelas_general.DOMICILIO, CAST(capacitaciones.Fecha AS DATE) AS Fecha, capacitaciones.Turno_Id, 
											CAST( capacitaciones.Hora_Desde AS TIME ) AS Hora_Desde , CAST( capacitaciones.Hora_Hasta AS TIME ) AS Hora_Hasta 
											FROM escuelas_general RIGHT JOIN solicitudes_de_asignacion_de_capacitacion LEFT JOIN capacitaciones ON 
											solicitudes_de_asignacion_de_capacitacion.Crono_Id = capacitaciones.Crono_Id  ON escuelas_general.CUE = capacitaciones.CUE 
											WHERE solicitudes_de_asignacion_de_capacitacion.Docente_Nro  = '".$this->id."'" ;
		}
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "SOLICITUD DE CAPACITACION" ;
		}
	protected function Pone_nombre_pag ()														// by DZ 2015-08-18 - agregado lista de datos
		{
			$this->nombre_pagina = 'sol_capa' ;
		}
	public function borrar_desde_abm()
		{
		$this->leer_lista();
		$cn=new Conexion();
		while ( $this->existe == true and $reg=mysqli_fetch_array($this->registros) )
				{
				$check = 'solicitudes_de_asignacion_de_capacitacion_idCornoId'.$reg['Crono_Id'] ;
				if ( isset( $_POST[$check] ))
					{
					$strsql = "DELETE FROM solicitudes_de_asignacion_de_capacitacion
													 WHERE Crono_Id = '".$reg['Crono_Id']."' AND Docente_Nro = '".$this->id."'" ;
					$cn->conexion->query($strsql) ;
					if ($cn->conexion->connect_error )
						{
								die("Problemas en el delete de solicitudes_de_asignacion_de_capacitacion : ".$cn->conexion->error.$strsql );
						}				
					}
				}
		//
		// Cierra la conexion
		$cn->cerrar();
		}
	public function texto_mostrar_abm()
  	{
			$txt = '';
			$txt=$txt.'<table>';
			$txt=$txt.'<tr><td>Docente Id </td><td>Capacitacion</td><td>Escuela</td><td>Direccion</td><td>Fecha</td><td>Turno</td><td>Hora Desde</td><td>Hora Hasta</td><td>Borrar</td></tr>';
			$cntcols = 11 ;
  		$this->leer_lista();
      while ($this->existe == true and $reg=mysqli_fetch_array($this->registros,MYSQLI_NUM) )
				{
        	$txt=$txt.'<tr>';
					for($f=0;$f<count($reg);$f++)
						{
							$txt=$txt.'<td>';
		          $txt=$txt.$reg[$f];
		          $txt=$txt.'</td>';
						}
					$txt=$txt.'<td>';
      		$txt=$txt.'<input type="checkbox" name="solicitudes_de_asignacion_de_capacitacion_idCornoId'.$reg[1].'">';
      		$txt=$txt.'</td>';
      		$txt=$txt.'</tr>';
				}
			if ( $this->existe == true )
				{ 
					$txt=$txt.'<tr><td colspan="'.$cntcols.'">';
    			$txt=$txt.'<input type="submit" value="Agregar" name="solicitudes_de_asignacion_de_capacitacion_okAgregar">';
    			$txt=$txt.'<input type="submit" value="Borrar" name="solicitudes_de_asignacion_de_capacitacion_okBorrar">';
    			$txt=$txt.'</td></tr>'; 
				}
			else
				{
					$txt=$txt.'<tr><td colspan="'.$cntcols.'">';
    			$txt=$txt.'<input type="submit" value="Agregar" name="solicitudes_de_asignacion_de_capacitacion_okAgregar">';
    			$txt=$txt.'</td></tr>'; 
				}
			$txt=$txt.'</table>';
			return $txt;
			}
}

class Capas_Sin_Anexo {
	protected function Carga_Sql_Lista()
	{
		$this->strsql = " select capacitaciones.Crono_Id, 
									capacitaciones.Estado ,
									escuelas_general.NOMBRE ,
									CAST(capacitaciones.Fecha AS DATE) AS Fecha, 
									DATE_FORMAT( capacitaciones.Hora_Desde, '%H:%i' ) AS Hora_Desde,	
									DATE_FORMAT( capacitaciones.Hora_Hasta, '%H:%i' ) AS Hora_Hasta, 
									capacitaciones.Programa_Nro
							from capacitaciones
							left JOIN anexo on capacitaciones.Anexo_Nro = anexo.Anexo_Nro
							LEFT JOIN escuelas_general ON capacitaciones.CUE = escuelas_general.CUE
							where 	capacitaciones.Edicion_Nro = 2016 
									and month( capacitaciones.Fecha ) = 7 
									and anexo.Anexo_Nro is null 
							order by capacitaciones.Programa_Nro , capacitaciones.Crono_Id "  ;
	}


		
}

class Capas_a_Elegir_de_un_Rango extends Entidad {
	private $edicion;
	private $paraDocente;
	private $fechaMaxima ;
	public function Pone_Edicion ($Edicion_Nro)
		{
			$this->edicion = $Edicion_Nro ;
		}
	public function Pone_paraDocente($docente)
		{
			$this->paraDocente = $docente ;
		}
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Capas de un Rango" ;
		}
	protected function Carga_Sql_Lista()
	{
		$par = new parametro();
		$this->fechaMaxima = $par->Obtener_Parametro(1);
	$this->strsql = " SELECT capacitaciones.Fecha, escuelas_general.NOMBRE, 
														turnos.Turno_orden, capacitaciones.Turno_Id, 
														capacitaciones.Crono_Id, capacitaciones.Hora_Desde, 
														capacitaciones.Hora_Hasta, capacitaciones.Crono_Id AS Capacitacion_Nro, 
														capacitaciones.Estado, estado_capacitaciones.Color, 
														capacitaciones.Anexo_Nro, capacitaciones.CUE, 
														escuelas_general.TELEFONO, capacitaciones.Matricula, 
														escuelas_general.DOMICILIO, escuelas_general.TIPO, 
														escuelas_general.DEPENDENCIA_FUNCIONAL, escuelas_general.COMUNA, 
														escuelas_general.BARRIO, escuelas_general.`Total capacitaciones`, 
														escuelas_general.Inscripta 
														FROM capacitaciones LEFT JOIN escuelas_general ON escuelas_general.CUE = capacitaciones.CUE
														LEFT JOIN estado_capacitaciones ON estado_capacitaciones.Estado_Cod = capacitaciones.Estado
														LEFT JOIN turnos ON turnos.Turno_ID = capacitaciones.Turno_Id
														Where capacitaciones.Edicion_Nro = " .$this->edicion . " AND
																	( capacitaciones.Estado = 'C'  )  
																	AND capacitaciones.Fecha > DATE(NOW())
																	AND capacitaciones.Fecha <= CAST('".$this->fechaMaxima."' AS DATE)
																	AND capacitaciones.Programa_Nro = 1
																	AND capacitaciones.Crono_id not in 
																				( select distinct Crono_id 
																					from solicitudes_de_asignacion_de_capacitacion 
																					where Docente_Nro = '".$this->paraDocente."'  )

														GROUP BY 	capacitaciones.Fecha, escuelas_general.NOMBRE, 
																			turnos.Turno_orden, capacitaciones.Turno_Id, 
																			capacitaciones.Crono_Id, capacitaciones.Hora_Desde, 
																			capacitaciones.Hora_Hasta, capacitaciones.Crono_Id, 
																			capacitaciones.Version_Nro, capacitaciones.Estado, 
																			estado_capacitaciones.Color, capacitaciones.Anexo_Nro, 
																			capacitaciones.CUE, escuelas_general.TELEFONO, 
																			escuelas_general.DOMICILIO, escuelas_general.TIPO, 
																			escuelas_general.DEPENDENCIA_FUNCIONAL, escuelas_general.COMUNA, 
																			escuelas_general.BARRIO, escuelas_general.`Total capacitaciones`, 
																			capacitaciones.Matricula, escuelas_general.Inscripta
																			ORDER BY capacitaciones.Fecha, escuelas_general.NOMBRE, turnos.Turno_orden "  ;
	}

	public function txtMostrar ()
		{
			//
			// Variables
			//
			$txt = '' ;
			//
			// Lee lista de capacitaciones
			//
			$this->leer_lista();
			$regs = $this->Obtener_Lista() ;
			//
			// Abre tabla
			$txt = $txt.'<table>' ;
			if ( $this->existe == false )
				{
				$txt=$txt.'<tr><td> No hay capacitaciones para la edicion '.$this->edicion.'</td></tr>' ; 
				}
			else
				{
				$txt = $txt.'<tr>';
				$txt = $txt.'<th> # </th>';
				$txt = $txt.'<th> Escuela </th>';
				$txt = $txt.'<th> Fecha </th>';
				$txt = $txt.'<th> Turno </th>';
				$txt = $txt.'<th colspan = "2" > Horario </th>';
				$txt = $txt.'<th> Comuna </th>';
				$txt = $txt.'<th> Barrio </th>';
				$txt = $txt.'<th> Domicilio </th>';
				$txt = $txt.'<th> Seleccion </th>';
				$txt = $txt.'</tr>';
				}
			while ($this->existe == true and $reg=$regs->fetch_object() )
				{
					$txt = $txt.'<tr>';
					$pref_capa = 'm_cap_rango_cronoid'.$reg->Crono_Id ;
					$nom_check = $pref_capa.'_check' ;
					$txt = $txt.'<td>'.$reg->Crono_Id.'</td>' ;
					$txt = $txt.'<td>'.$reg->NOMBRE.'</td>' ;
					$fecha = new Fecha() ;
					$txt = $txt.'<td>'.$fecha->todmy($reg->Fecha).'</td>';
					$txt = $txt.'<td>'.$reg->Turno_Id.'</td>' ;
					$txt = $txt.'<td>'.$fecha->tohm($reg->Hora_Desde).'</td>' ;
					$txt = $txt.'<td>'.$fecha->tohm($reg->Hora_Hasta).'</td>' ;
					$txt = $txt.'<td>'.$reg->COMUNA.'</td>' ;
					$txt = $txt.'<td>'.$reg->BARRIO.'</td>' ;
					$txt = $txt.'<td>'.$reg->DOMICILIO.'</td>' ;
					$txt = $txt.'<td><input type="checkbox" name="'.$nom_check.'">elegir</td>';
					$txt = $txt.'</tr>';
				}
				// Fin While 
				//
				// Cierra la tabla
				$txt = $txt.'</table>' ;
				/* liberar el conjunto de resultados */
				if ( $this->existe == true ) {
   				$regs->close(); }
				return $txt ;
		} 
		// Fin Function Mostrar
		
}

?>
