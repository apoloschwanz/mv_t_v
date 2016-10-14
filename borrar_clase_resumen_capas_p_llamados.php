<?php

require_once 'clases_base.php' ;
require_once 'clase_entidadi.php' ;
require_once 'clase_establecimiento.php' ;
require_once 'clase_edicion_actual.php' ;
require_once 'clase_turno.php' ;
require_once 'clase_estado_capacitaciones.php' ;
require_once 'clase_programa.php' ;
require_once 'clase_parametro.php' ;


class resumen_capas_p_llamados extends entidadi {
	private $edicion;
	public function __construct()
	{
		parent::__construct() ;
		$ed = new edicion_actual();
		$this->edicion = $ed->Edicion_Actual_Nro ;
	}
	public function Pone_Edicion ($Edicion_Nro)
		{
			$this->edicion = $Edicion_Nro ;
		}
	protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_res_cpl_' ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Capacitaciones" ;
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
			$this->lista_campos_lectura[]=array( 'nombre'=>'CUE' 				, 'tipo'=>'fk' 		, 'descripcion'=>'Escuela'								, 'clase'=>new Establecimiento() ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Fecha' 			, 'tipo'=>'date' 	, 'descripcion'=>'Fecha' 									, 'clase'=>NULL ) ;
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
			$this->lista_campos_lista[]=array( 'nombre'=>'CUE' 				, 'tipo'=>'fk' 		, 'descripcion'=>'#'								, 'clase'=>new Establecimiento() ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'NOMBRE' 				, 'tipo'=>'fk' 		, 'descripcion'=>'Escuela'								, 'clase'=>new Establecimiento() ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Fecha' 			, 'tipo'=>'date' 	, 'descripcion'=>'Fecha' 									, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Turno_Id' 	, 'tipo'=>'fk'	, 'descripcion'=>'Turno' 										, 'clase'=>new Turno() ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Estado_Cod'	, 'tipo'=>'fk'	, 'descripcion'=>'Estado' 									, 'clase'=>new Estado_Capacitaciones() ) ;
			//
			// Acciones Extra para texto_mostrar_abm
			$this->acciones[] = array( 'nombre'=>'okLlamado' , 'texto'=>'Llamados!!!!!!!!' ) ;
			//$this->acciones[] = array( 'nombre'=>'okAsignarCordo' , 'texto'=>'Asignar Coordinador' ) ;
			//
			// Filtros
			$this->con_filtro_fecha = true;
			$this->con_filtro_general = true;
			//
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
					$hasta = date_add($ahora, date_interval_create_from_date_string('120 days'));
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
		$this->strsql = " 
							SELECT 
								escuelas_general.CUE,
								CONCAT(Red,',',Green,',',Blue) as Color, 
								escuelas_general.CUE as Id,
								escuelas_general.Nombre ,
								MIN( cc.Fecha ) as Fecha , 
								turnos.Turno ,
								estado_capacitaciones.Estado
							FROM escuelas_general 
							LEFT JOIN
								( SELECT
									capacitaciones.CUE,
									capacitaciones.Crono_Id, 
									capacitaciones.Fecha ,
									capacitaciones.Hora_Desde , 
									capacitaciones.Hora_Hasta , 
									capacitaciones.Turno_Id , 
									capacitaciones.Estado 
									FROM capacitaciones 
									WHERE capacitaciones.Edicion_Nro = " .$this->edicion . " " ;
		$this->strsql.= 	" AND capacitaciones.Fecha >='".$this->filtro_f_desde."' " ;
		$this->strsql.= 	" AND capacitaciones.Fecha <='".$this->filtro_f_hasta."' " ;
		$this->strsql.= 	" 	) as cc
							ON cc.CUE = Escuelas_General.CUE 
							LEFT JOIN estado_capacitaciones ON estado_capacitaciones.Estado_Cod = cc.Estado
							LEFT JOIN turnos ON turnos.Turno_ID = cc.Turno_Id
							LEFT JOIN colores ON estado_capacitaciones.Color = colores.Color_Cod	" ;
							
							
		if ( isset( $_REQUEST[$this->prefijo_campo.'filtro_general'] ) )
		{
			if( ! empty( $_REQUEST[$this->prefijo_campo.'filtro_general'] ) )
			{
			$this->strsql.= 	" AND  escuelas_general.NOMBRE like '%".$this->filtro_gral."%' " ;
			}
			
		}
		$this->strsql.= 	"GROUP BY escuelas_general.CUE,
										escuelas_general.Nombre ,
										turnos.Turno ,
								estado_capacitaciones.Estado
							ORDER BY MIN( cc.Fecha ) DESC, escuelas_general.Nombre
							
							" ;
		
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
		public function texto_mostrar_abm()
		{
			$this->leer_filtros();
			$this->leer_lista();
			$cntcols = count($this->lista_campos_descrip)+count($this->lista_detalle_enc_columnas)+2 ;
			$txt = '';
			$txt=$txt.'<table class="detalle_in">';
			//
			// Filtros
			if ( $this->con_filtro_fecha or $this->con_filtro_general)
			{
				$txt .= '<tr>';
				$txt .= '<td colspan="'.$cntcols.'">';
				$txt .= '<table>' ;
				$txt .= '<tr>';
				$txt .= '<td style="border: none;">Filtros:</td>';
				$cpo = new Campo();
				if ( $this->con_filtro_fecha )
				{
					$cpo->pone_tipo( 'date' ) ;
					$txt .='<td>Fecha Desde:</td>';
					$cpo->pone_nombre( $this->prefijo_campo.'filtro_f_desde' ) ;
					$cpo->pone_valor( $this->filtro_f_desde ) ;
					$txt = $txt.$cpo->txtMostrarParaModificar() ;
					$txt .='<td>Fecha Hasta:</td>' ;
					$cpo->pone_nombre( $this->prefijo_campo.'filtro_f_hasta' ) ;
					$cpo->pone_valor( $this->filtro_f_hasta) ;
					$txt = $txt.$cpo->txtMostrarParaModificar() ;
					
				}
				if ( $this->con_filtro_general )
				{
					$cpo->pone_tipo( 'text' );
					$txt .='<td>Nombre:</td>';
					$cpo->pone_nombre( $this->prefijo_campo.'filtro_general' ) ;
					$cpo->pone_valor( $this->filtro_gral ) ;
					$txt = $txt.$cpo->txtMostrarParaModificar() ;
					
				}
				if ( $this->con_filtro_fecha or $this->con_filtro_general )
				{
					$cpo->pone_tipo( 'number' );
					$txt .='<td>#:</td>';
					$cpo->pone_nombre( $this->prefijo_campo.'filtro_id' ) ;
					$cpo->pone_valor( $this->filtro_id ) ;
					$txt.= $cpo->txtMostrarParaModificar() ;
				}
				$txt .= '</td>';
				$txt .= '<td>' ;
				$txt .= '<input type="submit" value="Filtrar" name="'.$this->prefijo_campo.'_okFiltrar">' ;
				$txt .= '</td>';
				$txt .= '</tr>';
				$txt .='</table>';
				$txt .='</tr>';
			}
			//
			// Encabezados
			$txt=$txt.'<tr>' ;
			$txt=$txt.'<th> </th>';
			for($i=0;$i<count($this->lista_campos_descrip);$i++)
				{
				$txt=$txt.'<th>';
				$txt=$txt.$this->lista_campos_descrip[$i];
				$txt=$txt.'</th>';
				}
			//
			// Encabezados detalle
			foreach( $this->lista_detalle_enc_columnas as $tit )
				{
				$txt.='<th>';
				$txt.=$tit;
				$txt.='</th>';
				}
			$txt.='<th>Acciones</th>';
			$txt=$txt.'</tr>';
			//
			// Registros
			$numdet = 0 ;
			while ($this->existe == true and $reg=mysqli_fetch_array($this->registros,MYSQLI_NUM) )
				{
					$ts_color = $reg[1] ;
				$txt=$txt.'<tr style="background-color:rgb('.$ts_color.')">';
				$txt=$txt.'<td>';
				$txt=$txt.'<input type="checkbox" name="'.$this->prefijo_campo.'_Id'.$reg[0].'">';
				$txt=$txt.'</td>';
				//
				// Datos
				for($f=2;$f<count($reg);$f++)
					{
					$txt=$txt.'<td>';
					$txt=$txt.$reg[$f];
					$txt=$txt.'</td>';
					}
				//
				// Detalle
				//
				if ( $this->tiene_lista_detalle )
				{
					$arreglo_detalle = $this->lista_detalle[$numdet] ;
					foreach( $arreglo_detalle as $det )
					{
						$txt.='<td>';
						$txt.=$det;
						$txt.='</td>';
					}
					$numdet++;
				}
				
				// Acciones
				$txt=$txt.'<td>' ;
				foreach( $this->acciones as $accion )
					{
						$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.$accion['nombre'].'=1">'.$accion['texto'].'</a>' ;
					} 
					$txt=$txt.'</td>' ;
					$txt=$txt.'</tr>';
				}
			if ( $this->existe == true )
				{ 
					$txt=$txt.'<tr><td colspan="'.$cntcols.'">';
    			$txt=$txt.'<input type="submit" value="Agregar" name="'.$this->prefijo_campo.'_okAgregar">';
    			$txt=$txt.'<input type="submit" value="Borrar" name="'.$this->prefijo_campo.'_okBorrar">';
    			$txt=$txt.'</td></tr>'; 
				}
			else
				{
					$txt=$txt.'<tr><td colspan="'.$cntcols.'">';
    			$txt=$txt.'<input type="submit" value="Agregar" name="'.$this->prefijo_campo.'_okAgregar">';
    			$txt=$txt.'</td></tr>'; 
				}
			$txt=$txt.'</table>';
			return $txt;
		}

	protected function modifica_tabla()
		{
			$this->strsql = ' ALTER TABLE capacitaciones ADD Programa_Nro INT ' ; 
		}
	

}



?>
