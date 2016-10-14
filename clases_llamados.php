<?php

require_once 'clases_base.php' ;
require_once 'clase_entidadi.php' ;
require_once 'clase_relacioni.php' ;
require_once 'clase_establecimiento.php' ;
require_once 'clase_edicion_actual.php' ;
require_once 'clase_turno.php' ;
require_once 'clase_estado_capacitaciones.php' ;
require_once 'clase_programa.php' ;
require_once 'clase_parametro.php' ;
require_once 'clase_relacion_unica_obligatoria.php' ;
require_once 'clase_edicion_actual.php' ;

class Pagina_llam extends Paginai
{
	//cabecera_nav
	  public function __construct($texto1,$texto2)
  {
		$this->principio=new Principio($texto1);
		$this->cabecera=new cabecera_nav($texto1,$texto2); 
		$this->cuerpo=new Cuerpo();
		$this->pie=new Pie($texto2);
		$this->fin=new Fin();
		$this->formulario=new Formulario();
		$this->borde = true ;
  }
}

class capacitaciones_del_establecimiento extends relacioni {
	protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_cap_est_' ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Cronograma" ;
			$this->nombre_fisico_tabla = "capacitaciones" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Borrado 
			$this->borrar_sin_seleccion = true ;
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
			$this->lista_campos_lectura[]=array( 'nombre'=>'Turno_Id' 	, 'tipo'=>'fk'		, 'descripcion'=>'Turno' 										, 'clase'=>new Turno() ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Hora_Desde' , 'tipo'=>'time'	, 'descripcion'=>'Desde' 									, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Hora_Hasta' , 'tipo'=>'time'	, 'descripcion'=>'Hasta' 									, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Estado'	, 'tipo'=>'fk'		, 'descripcion'=>'Estado' 									, 'clase'=>new Estado_Capacitaciones() ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Matricula' 	, 'tipo'=>'number'	, 'descripcion'=>'Matrícula'							, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Divisiones' , 'tipo'=>'text'    , 'descripcion'=>'Divisiones'							, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Observaciones' , 'tipo'=>'text' , 'descripcion'=>'Observaciones'						, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Programa_Nro'			, 'tipo'=>'fk'	, 'descripcion'=>'Programa' 						, 'clase'=>new Programa() ) ;
			//
			//
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'Crono_Id' 	, 'tipo'=>'pk' 		, 'descripcion'=>'#' 											, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'NOMBRE' 			, 'tipo'=>'text' 	, 'descripcion'=>'Establecimiento' 									, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Fecha' 			, 'tipo'=>'date' 	, 'descripcion'=>'Fecha' 									, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Turno_Id' 	, 'tipo'=>'fk'	, 'descripcion'=>'Turno' 										, 'clase'=>new Turno() ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Hora_Desde' , 'tipo'=>'time'	, 'descripcion'=>'Desde' 									, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Hora_Hasta' , 'tipo'=>'time'	, 'descripcion'=>'Hasta' 									, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Estado'	, 'tipo'=>'fk'	, 'descripcion'=>'Estado' 									, 'clase'=>new Estado_Capacitaciones() ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Matricula' 	, 'tipo'=>'number'	, 'descripcion'=>'Mat.'							, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Divisiones' , 'tipo'=>'text'    , 'descripcion'=>'Divisiones'							, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Observaciones' , 'tipo'=>'text' , 'descripcion'=>'Observaciones'						, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Programa_Nro'			, 'tipo'=>'otro'	, 'descripcion'=>'Programa' 						, 'clase'=>NULL ) ;
		}
	protected function Carga_Sql_Lectura()
	{
		$this->strsql = " SELECT 	capacitaciones.Crono_Id, CAST(capacitaciones.Fecha AS DATE) AS Fecha, 
															capacitaciones.Turno_Id, 
															DATE_FORMAT( capacitaciones.Hora_Desde, '%H:%i' ) AS Hora_Desde,
															DATE_FORMAT( capacitaciones.Hora_Hasta, '%H:%i' ) AS Hora_Hasta, 
															capacitaciones.Estado, 
															capacitaciones.Matricula, 
															capacitaciones.Divisiones,
															capacitaciones.Observaciones,
															capacitaciones.Programa_Nro
															FROM capacitaciones LEFT JOIN escuelas_general ON escuelas_general.CUE = capacitaciones.CUE
															LEFT JOIN estado_capacitaciones ON estado_capacitaciones.Estado_Cod = capacitaciones.Estado
															LEFT JOIN turnos ON turnos.Turno_ID = capacitaciones.Turno_Id
															Where capacitaciones.Crono_Id = " .$this->id . "  "  ;
			
	}

	protected function Carga_Sql_Lista()
	{
		$this->strsql = " SELECT capacitaciones.Crono_Id as Id, CONCAT(Red,',',Green,',',Blue), 
									capacitaciones.Crono_Id,
									escuelas_general.NOMBRE, 
									CAST(capacitaciones.Fecha AS DATE) AS Fecha, 
									capacitaciones.Turno_Id, 
									DATE_FORMAT( capacitaciones.Hora_Desde, '%H:%i' ) AS Hora_Desde,	DATE_FORMAT( capacitaciones.Hora_Hasta, '%H:%i' ) AS Hora_Hasta, 
									capacitaciones.Estado, 
									capacitaciones.Matricula, 
									capacitaciones.Divisiones,
									capacitaciones.Observaciones,
									programa.Programa,
									capacitaciones.Anexo_Nro
									FROM capacitaciones LEFT JOIN escuelas_general ON escuelas_general.CUE = capacitaciones.CUE
									LEFT JOIN estado_capacitaciones ON estado_capacitaciones.Estado_Cod = capacitaciones.Estado
									LEFT JOIN turnos ON turnos.Turno_ID = capacitaciones.Turno_Id
									LEFT JOIN programa on capacitaciones.Programa_Nro = programa.Programa_Nro 
									LEFT JOIN colores ON estado_capacitaciones.Color = colores.Color_Cod " ;
		$this->strsql .= ' WHERE capacitaciones.CUE'." = '" .$this->id_lado_uno ."' " ;
		$this->strsql .= ' AND '.$this->nombre_id_lado_uno_fijo." = '" .$this->id_lado_uno_fijo ."' " ;
									
	}
	public function pone_edicion_actual($pn_edicion)
	{
		$this->id_lado_uno_fijo = $pn_edicion ;
	}
	public function __construct ()
	{
		parent::__construct() ;
		$this->obj_lado_uno = new establecimiento_p_llamados() ;
		$this->nombre_id_lado_uno = 'CUE' ;
		$this->nombre_id_lado_uno_fijo = 'Edicion_Nro' ;
	}
	public function texto_agregar_okGrabar()
		{
			//$nomid = $this->prefijo_campo.'id';
			//$this->Set_id($_POST[$nomid]);
			$this->error= false ;
			//$this->Leer();
			//
			// Abre la conexión con la base de datos
			$cn=new Conexion();
			//
			// Arma lista de campos a agregar
			$lst_cmp = '';
			$lst_val = '';
			$i = 0 ;
			$lst_cmp = $this->nombre_id_lado_uno ;
			$lst_val = "'".$this->id_lado_uno."'" ;
			//
			// Periodo
			$lst_cmp .= ', '. $this->nombre_id_lado_uno_fijo ;
			$lst_val .= ", '".$this->id_lado_uno_fijo."' " ;
						
			foreach ( $this->lista_campos_lectura as $campo )
				{
					//
					// tipo de campo
					$tp = $campo['tipo'] ;
					//
					// tipos de camos validos
					if ( $tp != 'otro' and $tp != 'pk' )
						{
						//
						// Agrega coma
								$lst_cmp = $lst_cmp.', ' ;
								$lst_val = $lst_val.', ' ;
						//
						// Nombre de campo
						$nomCtrl = $this->prefijo_campo.'cpoNro'.$i.'_'  ;
						//
						// Valor a reemplazar en el campo
						if ( $tp == 'time' ) $valor = '1899-12-30 '.$_POST[$nomCtrl] ;
						else $valor = $_POST[$nomCtrl] ;
						//
						// Lista campos
						$lst_cmp = $lst_cmp. $campo['nombre'] ;
						//
						// Lista valores
						if ( empty( $valor ) )
							$lst_val .= 'NULL' ;
						else
							$lst_val .= "'".$valor."'" ;
						}
					$i++;
				}
			$strsql = ' INSERT INTO '.$this->nombre_fisico_tabla.' ( '.$lst_cmp.' )  VALUES ( '.$lst_val. ' ) ';
			//
			// Cierra la conexion
			$insertado = $cn->conexion->query($strsql) ;
			if ( $insertado ) 
				{ 
					$result = $cn->conexion->query('SELECT last_insert_id()');
					$reg = $result->fetch_array(MYSQLI_NUM);
					$this->id = $reg[0];
					$result->free();
				}
			else
				{
					// die( "Problemas en el insert de ".$this->nombre_tabla." : ".$cn->conexion->error.$strsql ) ;
					$this->error = true ;
					$this->textoError = "Problemas en el insert de ".$this->nombre_tabla." : ".$cn->conexion->error.' '.$strsql ;
				}
			$cn->cerrar();
		}	
		public function texto_actualizar_detalle ()
			{
				$this->error= false ;
				$this->obj_lado_uno->Leer();
				if ( $this->obj_lado_uno->existe == false )
				{ 
					$this->error = true ;
					$this->textoError = "El registro con Id ".$this->obj_lado_uno->id." no se encuentra en la base de datos " ;
				}
				//
				// Lee Lista
				$txt = '' ;
				if ( $this->error == false )
				{
					$this->leer_lista();
					$txt = '';
					$txt=$txt.'<table>';
					$txt=$txt.'<tr>' ;
					$cntcols = 1 ;
					foreach( $this->lista_campos_lista as $ta_campo )
					{
						$cntcols ++ ;
						$txt=$txt.'<td>';
				      $txt=$txt.$ta_campo['descripcion'];
				      $txt=$txt.'</td>';
					}
					$txt.='<td>Acción</td>';
					$txt=$txt.'</tr>';
					while ($this->existe == true and $reg=mysqli_fetch_array($this->registros,MYSQLI_NUM) )
						{
				    	
				    	$ts_color = $reg[1] ;
						$txt=$txt.'<tr style="background-color:rgb('.$ts_color.')">';
				    	//$txt=$txt.'<tr>';
				    	
				    	
				    	
						//	$txt=$txt.'<td>';
				  		//$txt=$txt.'<input type="checkbox" name="'.$this->prefijo_campo.'_Id'.$reg[0].'">';
				  		//$txt=$txt.'</td>';
				  		for($f=2;$f<count($reg)-1;$f++)
								{
									$txt=$txt.'<td>';
						      $txt=$txt.$reg[$f];
						      $txt=$txt.'</td>';
								}
							if ( $this->borrar_sin_seleccion )
							{
								$txt=$txt.'<td>' ;
								if( $reg[8] <> 'H' )
								{
									//$txt.='<button type="submit" value="'.$reg[0].'" name="'.$this->prefijo_campo.'_okBorrarUno">Borrar</button>';
									$txt.='<button type="submit" value="'.$reg[0].'" name="'.$this->okModificar.'" value="'.$reg[0].'">Modificar</button>';
								}
								$txt=$txt.'</td>' ;
							}
							$txt=$txt.'</tr>';
						}
					$txt=$txt.'<tr><td colspan="'.$cntcols.'">';
					$txt=$txt.'<input type="submit" value="Agregar" name="'.$this->prefijo_campo.'_okAgregar">';
					$txt=$txt.'</td></tr>'; 
					$txt=$txt.'</table>';
					}
					else
					{
						$txt=$txt.'<tr><td> '.$this->textoError.'</td></tr>' ; 
					}
					return $txt;
			}

		public function borrar_uno()
		{
			$this->error= false ;
			$this->obj_lado_uno->Leer();
			if ( $this->obj_lado_uno->existe == false )
			{ 
				$this->error = true ;
				$this->textoError = "El registro con Id: ".$this->obj_lado_uno->id." no se encuentra en la base de datos " ;
			}
			if ( ! $this->error )
			{
				// Borra el registro
				//
				// Abre conexion con la base de datos
				$cn=new Conexion();
				
				$this->strsql = "UPDATE ".$this->nombre_fisico_tabla ;
				$this->strsql .= " Set Estado = 'R' " ;
				$this->strsql .=" WHERE Crono_Id = '".$this->id."' " ;
				$ok = $cn->conexion->query($this->strsql) ;
				if ( ! $ok ) 	die("Problemas en el delete de ".$this->nombre_tabla." : ".$cn->conexion->error.$this->strsql );
				//
				// Cierra la conexion
				$cn->cerrar();
			}
		}

}

class entidad_unica_obligatoria_de_un_colegio_edicion extends relacion_unica_obligatoria {
	public function pone_edicion_actual($pn_edicion)
	{
		$this->id_lado_uno_fijo = $pn_edicion ;
	}
	public function __construct ()
	{
		parent::__construct() ;
		$this->obj_lado_uno = new establecimiento_p_llamados() ;
		$this->nombre_id_lado_uno = 'CUE' ;
		$this->nombre_id_lado_uno_fijo = 'Edicion_Nro' ;
	}
	
		
}

class turno_del_establecimiento extends entidad_unica_obligatoria_de_un_colegio_edicion {
	protected $id_lado_uno_multivaluado ;
	protected $nombre_id_lado_uno_multivaluado ;
	public function __construct ()
	{
		parent::__construct() ;
		$this->nombre_id_lado_uno_multivaluado = 'Turno_Id' ;
	}
	protected function Pone_Datos_Fijos_No_Heredables()
	{	
		//
		// Prefijo campo
		$this->prefijo_campo = 'turn_de_los_estab'.$this->id_lado_uno_multivaluado.'_' ;
		//
		// Lista de Campos
		//
		// tipos:  'pk' 'fk' 'other' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
		//								el tipo 'fk' espera que se defina una clase 
		$this->lista_campos_lectura=array();
		$this->lista_campos_lectura[]=array( 'nombre'=>'Turno_Nro' 		, 'tipo'=>'pk' 		, 'descripcion'=>'#' , 'clase'=>NULL ) ;
		$this->lista_campos_lectura[]=array( 'nombre'=>'Nombre_Autoridad_Turno' 	, 'tipo'=>'text' 	, 'descripcion'=>'Nombre Autoridad del Turno' , 'clase'=>NULL ) ;
		$this->lista_campos_lectura[]=array( 'nombre'=>'Cargo_Autoridad_Turno' 	, 'tipo'=>'text' 	, 'descripcion'=>'Cargo Autoridad' , 'clase'=>NULL ) ;
		$this->lista_campos_lectura[]=array( 'nombre'=>'Persona_Refrerencia_Capacitacion' 	, 'tipo'=>'text' 	, 'descripcion'=>'Persona Referencia p/Capacitación' , 'clase'=>NULL ) ;
		$this->lista_campos_lectura[]=array( 'nombre'=>'Mail' 	, 'tipo'=>'text' 	, 'descripcion'=>'Mail' , 'clase'=>NULL ) ;
		$this->lista_campos_lectura[]=array( 'nombre'=>'Matricula' 	, 'tipo'=>'number' 	, 'descripcion'=>'Matrícula' , 'clase'=>NULL ) ;
		//
		// Nombre de la tabla
		$this->nombre_tabla = "Turnos de los Establecimintos" ;
		$this->nombre_fisico_tabla = "turnos_de_los_establecimientos" ;
		//
		// Nombre de la pagina
		$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
		//
		// Paginacion
		$this->desde = 0 ;																					// by DZ 2015-08-14 - agregado lista de datos
		$this->cuenta = 15 ;																				// by DZ 2015-08-14 - agregado lista de datos			
	}	
	protected function Carga_Sql_Lectura()
	{
		//
		// Modifica funcion de clase Entidad(relacion_unica_obligatoria.php)
		$this->strsql = ' SELECT ' ;
		$tf_primero = true ;
		foreach ( $this->lista_campos_lectura as $campo )
		{
			if ( $tf_primero )
			{
				$tf_primero = false;
				$ts_pk = $campo['nombre'] ;
			}
			else
				$this->strsql .= ' , ';
			$this->strsql .= $campo['nombre'] ;
		}
		$this->strsql .= ' FROM '.$this->nombre_fisico_tabla. ' ' ;
		$this->strsql .= ' WHERE '.$this->nombre_id_lado_uno." = '" .$this->id_lado_uno ."' " ;
		$this->strsql .= ' AND '.$this->nombre_id_lado_uno_fijo." = '" .$this->id_lado_uno_fijo ."' " ;
		$this->strsql .= ' AND '.$this->nombre_id_lado_uno_multivaluado. " = '" .$this->id_lado_uno_multivaluado ."' ";
	}
	protected function Carga_Sql_Agrega_Blanco()
	{
		$this->strsql = 'INSERT INTO '.$this->nombre_fisico_tabla. ' ' ;
		$this->strsql .= ' ( '.$this->nombre_id_lado_uno.' , ' ;
		$this->strsql .= $this->nombre_id_lado_uno_fijo. ' , ' ;
		$this->strsql .= $this->nombre_id_lado_uno_multivaluado. ' ) ' ;
		$this->strsql .= " VALUES ( '". $this->id_lado_uno."', " ;
		$this->strsql .= " '".$this->id_lado_uno_fijo ."', " ;
		$this->strsql .= " '".$this->id_lado_uno_multivaluado."' ) " ;
		
	}
	protected function modifica_tabla()
	{
		$strsql = " ALTER TABLE `turnos_de_los_establecimientos` CHANGE `Turno_Nro` `Turno_Nro` INT(11) NOT NULL AUTO_INCREMENT " ;
	}
}

class turno_maniana extends turno_del_establecimiento {
	public function __construct ()
	{
		$this->id_lado_uno_multivaluado = 'M' ;
		parent::__construct() ;
	}

}
class turno_tarde extends turno_del_establecimiento {
	public function __construct ()
	{
		$this->id_lado_uno_multivaluado = 'T' ;
		parent::__construct() ;
	}

}
class turno_noche extends turno_del_establecimiento {
	public function __construct ()
	{
		$this->id_lado_uno_multivaluado = 'N' ;
		parent::__construct() ;
	}

}
class infraestructura extends entidad_unica_obligatoria_de_un_colegio_edicion  {
	 	protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'infraestructura' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'other' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'Infraestructura_Nro' 		, 'tipo'=>'pk' 		, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Tiene_Salon' 	, 'tipo'=>'text' 	, 'descripcion'=>'Tiene Salon?' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Tiene_Proyector' 	, 'tipo'=>'text' 	, 'descripcion'=>'Tiene Proyector?' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Tiene_Audio' 	, 'tipo'=>'text' 	, 'descripcion'=>'Tiene Audio?' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Tiene_Notebook' 	, 'tipo'=>'text' 	, 'descripcion'=>'Tiene Notebook?' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Capacitad_Salon' 	, 'tipo'=>'text' 	, 'descripcion'=>'Capacidad del Salón' , 'clase'=>NULL ) ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Infraestructura" ;
			$this->nombre_fisico_tabla = "infraestructura" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					// by DZ 2015-08-14 - agregado lista de datos
			$this->cuenta = 15 ;																				// by DZ 2015-08-14 - agregado lista de datos			
		}	
/*	public function texto_actualizar()
	{
		$txt = "aca va el texto actualizar de infraestructura con id_lado_uno = ".$this->id_lado_uno ;
		$txt .= '<br>' ;
		$txt .= ' y con id_lado_uno_fijo(edicion) = ' . $this->id_lado_uno_fijo ;
		$txt .= '<br>' ;
		$txt .= ' y con where ' ;
		$txt .= ' WHERE '.$this->nombre_id_lado_uno." = '" .$this->id_lado_uno ."' " ;
		$txt .= ' AND '.$this->nombre_id_lado_uno_fijo." = '" .$this->id_lado_uno_fijo ."' " ;
		return $txt  ;
	}
*/	

	
	
	protected function modifica_tabla()
	{
		$this->strsql = " ALTER TABLE infraestructura DROP PRIMARY KEY " ;
		$this->strsql = " ALTER TABLE infraestructura ADD Infraestructura_Nro INT PRIMARY KEY AUTO_INCREMENT " ;
			$this->strsql = " ALTER TABLE infraestructura ADD UNIQUE INDEX unico ( CUE , Edicion_Nro ) " ;
	}
}

class establecimiento_p_llamados extends Entidadi  {
 		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'llamados_CUE_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'other' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'CUE' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Codigo Estab.' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'NOMBRE' 	, 'tipo'=>'text' 	, 'descripcion'=>'Establecimiento' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'TELEFONO' 	, 'tipo'=>'text' 	, 'descripcion'=>'Teléfono' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'DOMICILIO' 	, 'tipo'=>'text' 	, 'descripcion'=>'Dirección' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Escuela_Observaciones' 	, 'tipo'=>'textarea' 	, 'descripcion'=>'Observaciones' , 'clase'=>NULL ) ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Establecimientos" ;
			$this->nombre_fisico_tabla = "escuelas_general" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					// by DZ 2015-08-14 - agregado lista de datos
			$this->cuenta = 15 ;																				// by DZ 2015-08-14 - agregado lista de datos			
		}	

}



class llamado extends relacioni {
		protected $o_maniana ;
		protected $o_tarde ;
		protected $o_noche ;
		protected $o_infraestructura ;
		protected $o_capacitaciones ;
		protected $edicion_actual;
 		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Lado Uno de la Relación
			$this->obj_lado_uno = new establecimiento_p_llamados() ;
			$this->nombre_id_lado_uno = 'CUE' ;
			//
			// Lado Muchos de la Relación
			$this->obj_lado_muchos = new Entidad() ;
			
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_llam_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'Llamado_Nro' 			, 'tipo'=>'pk' 		, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Fecha' 	, 'tipo'=>'date' 	, 'descripcion'=>'Fecha' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Persona_Contactada' 	, 'tipo'=>'text' 	, 'descripcion'=>'Persona Contactada' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Observacion' 	, 'tipo'=>'text' 	, 'descripcion'=>'Observación' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Quien_Contacto' 	, 'tipo'=>'text' 	, 'descripcion'=>'Operador' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Fecha_Rellamado' 	, 'tipo'=>'date' 	, 'descripcion'=>'Volver a Llamar' , 'clase'=>NULL ) ;
			
			//$this->lista_campos_lista[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>new Entidadi() ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'Llamado_Nro' 			, 'tipo'=>'pk' 		, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Fecha' 	, 'tipo'=>'date' 	, 'descripcion'=>'Fecha' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Persona_Contactada' 	, 'tipo'=>'text' 	, 'descripcion'=>'Persona Contactada' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Observacion' 	, 'tipo'=>'textarea' 	, 'descripcion'=>'Observación' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Quien_Contacto' 	, 'tipo'=>'text' 	, 'descripcion'=>'Operador' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Fecha_Rellamado' 	, 'tipo'=>'date' 	, 'descripcion'=>'Volver a Llamar' , 'clase'=>NULL ) ;
			
			
			//$this->lista_campos_lectura[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>new Entidadi() ) ;
						
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Llamados" ;
			$this->nombre_fisico_tabla = "llamados" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					// by DZ 2015-08-14 - agregado lista de datos
			$this->cuenta = 15 ;																				// by DZ 2015-08-14 - agregado lista de datos		
			//
			// Acciones Extra para texto_mostrar_abm
			//$this->acciones = array( 'nombre'=>'okAsignarDte' , 'texto'=>'AsignarDte' ) ;
			//
			// Botones extra edicion
			//$this->botones_extra_edicion[] = array( 'name'=> '_Rel1' ,
			//										'value'=>'Salir' ,
			//										'link'=>'salir.php' ) ; // '<input type="submit" name="'.$this->prefijo_campo.'_Rel1" value="Salir" autofocus>
			//
			// Filtros
			$this->con_filtro_fecha = true;
			$this->con_filtro_general = true;
			//
			//
			
			//
			// Edicion del Llamado
			$to_edicion_actual = new Edicion_Actual() ;
			$this->edicion_actual = $to_edicion_actual->Edicion_Actual_Nro ;
			
			//
			// Obejtos Relacionados
			$this->o_maniana = new turno_maniana() ;
			$this->o_tarde = new turno_tarde() ;
			$this->o_noche = new turno_noche() ;
			$this->o_infraestructura = new infraestructura() ;
			$this->o_capacitaciones = new capacitaciones_del_establecimiento() ;
			$this->o_maniana->pone_edicion_actual( $this->edicion_actual ) ;
			$this->o_tarde->pone_edicion_actual( $this->edicion_actual ) ;
			$this->o_noche->pone_edicion_actual( $this->edicion_actual ) ;
			$this->o_infraestructura->pone_edicion_actual( $this->edicion_actual ) ;
			$this->o_capacitaciones->pone_edicion_actual( $this->edicion_actual ) ;
		}
		protected function Carga_Sql_Lista()
		{
		$this->strsql = ' SELECT ' ;
		$tf_primero = true ;
		foreach ( $this->lista_campos_lista as $campo )
		{
			if ( $tf_primero )
			{
				$tf_primero = false;
				$ts_pk = $campo['nombre'] ;
				$this->strsql .= $campo['nombre'] ;
			}
			elseif( $campo['tipo'] == 'date' or $campo['tipo'] == 'DATE')
			{
				$this->strsql .= ' , ';
				$this->strsql .= 'CAST('.$campo['nombre'].' AS DATE ) AS '.$campo['nombre'] ;
			}
			else
			{
				$this->strsql .= ' , ';
				$this->strsql .= $campo['nombre'] ;
			}
		}
		$this->strsql .= ' FROM '.$this->nombre_fisico_tabla. ' ' ;
		$this->strsql .= ' WHERE '.$this->nombre_id_lado_uno." = '" .$this->id_lado_uno ."' " ;
		$this->strsql .= ' ORDER BY  Fecha Desc ' ;
		}
		protected function Carga_Sql_Lectura()
		{
		$this->strsql = ' SELECT ' ;
		$tf_primero = true ;
		foreach ( $this->lista_campos_lectura as $campo )
		{
			if ( $tf_primero )
			{
				$tf_primero = false;
				$ts_pk = $campo['nombre'] ;
				$this->strsql .= $campo['nombre'] ;
			}
			elseif( $campo['tipo'] == 'date' or $campo['tipo'] == 'DATE')
			{
				$this->strsql .= ' , ';
				$this->strsql .= 'CAST('.$campo['nombre'].' AS DATE ) AS '.$campo['nombre'] ;
			}
			else
			{
				$this->strsql .= ' , ';
				$this->strsql .= $campo['nombre'] ;
			}
				
		}
		$this->strsql .= ' FROM '.$this->nombre_fisico_tabla. ' ' ;
		$this->strsql .= ' WHERE '.$ts_pk." = '" .$this->id."' " ;
		}
		protected function control_cambios_llamado()
		{
			//
			// Graba los cambios del llamado
			$ts_estado_llamado = $_POST['_est_llamado'] ;
			//echo 'Estado del llamado '. $ts_estado_llamado ;
			if( $ts_estado_llamado == 'nuevo' )
			{
				//echo '<br> graba llamado nuevo';
				$this->texto_agregar_okGrabar(); 
			}
			elseif( $ts_estado_llamado == 'edicion' )
			{
				$this->texto_actualizar_okGrabar() ;
			}
			else
				die('Error en control cambos llamado en llamado(clases_llamados.php)') ;
			
			//
			// Graba los otros datos
			$this->o_maniana->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
			$this->o_tarde->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
			$this->o_noche->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
			$this->o_maniana->texto_actualizar_okGrabar() ;
			$this->o_tarde->texto_actualizar_okGrabar() ;
			$this->o_noche->texto_actualizar_okGrabar() ;
			//
			// Infraestructura
			$this->o_infraestructura->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
			$this->o_infraestructura->texto_actualizar_okGrabar() ;
				
		}
		public function mostrar_pagina_alta()
		{	
			//
			//
			$tf_muestra_alta = true ;
			//
			//
			$this->o_maniana->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
			$this->o_tarde->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
			$this->o_noche->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
			$this->o_capacitaciones->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				
			
			if ( isset( $_POST[$this->okSalir] ) )
			{
				$ts_estado_llamado = $_GET['_est_llamado'] ;
				if( $ts_estado_llamado == 'edicion' )
				{
					$this->texto_actualizar_okGrabar() ;
				}
				$this->ok_Salir() ;
			}
			//
			// Modifica Capacitacion
			elseif ( isset( $_POST[$this->o_capacitaciones->okModificar] ) )
			{
				$this->control_cambios_llamado(); // Graba las modificaciones del llamado
				$this->o_capacitaciones->Set_id($_POST[$this->o_capacitaciones->okModificar]);
				$pagina=new Paginai($this->nombre_tabla ,'<input type="hidden" name="__id_del_llamado_grabado" value="'.$this->id.'"><input type="submit" value="Grabar" name="'.$this->o_capacitaciones->okGrabar.'"><input type="submit" value="Salir" name="Volver">');
				$txt = $this->texto_Ver_Lado_Uno(); // establecimiento_p_llamados
				$pagina->insertarCuerpo($txt);
				$txt = $this->o_capacitaciones->texto_actualizar() ;
				$pagina->insertarCuerpo($txt);
				$pagina->graficar_c_form($_SERVER['PHP_SELF']);
			}
			elseif ( isset( $_POST[$this->o_capacitaciones->okGrabar] ) )
			{
				$this->Set_id( $_POST['__id_del_llamado_grabado'] ) ;
				$this->o_capacitaciones->texto_actualizar_okGrabar() ;
				if ( $this->o_capacitaciones->hay_error() == true )
				{ 
					$pagina=new Paginai($this->nombre_tabla ,'<input type="hidden" name="__id_del_llamado_grabado" value="'.$this->id.'"><input type="submit" value="OK" name="Volver">');
					$txt = $this->texto_Ver_Lado_Uno(); // establecimiento_p_llamados
					$pagina->insertarCuerpo($txt);
					$txt = $this->o_capacitaciones->textoError ;
					$pagina->insertarCuerpo($txt);
					$pagina->graficar_c_form($_SERVER['PHP_SELF']);
				}
				else 
				{
					$pagina=new Paginai($this->nombre_tabla ,'<input type="hidden" name="__id_del_llamado_grabado" value="'.$this->id.'"><input type="submit" value="OK" name="Volver">');
					$txt = $this->texto_Ver_Lado_Uno(); // establecimiento_p_llamados
					$pagina->insertarCuerpo($txt);
					$txt = 'Capacitación # '.$this->o_capacitaciones->id().' modificada' ;
					$pagina->insertarCuerpo($txt);
					$pagina->graficar_c_form($_SERVER['PHP_SELF']);
				}
			}
			//
			// Borrado capacitacion
			elseif ( isset( $_POST['m_cap_est__okBorrarUno'] ) )
			{
				$this->control_cambios_llamado(); // Graba las modificaciones del llamado
				$this->o_capacitaciones->Set_id($_POST['m_cap_est__okBorrarUno']);
				$this->o_capacitaciones->borrar_uno() ;
				$pagina=new Paginai($this->nombre_tabla ,'<input type="hidden" name="__id_del_llamado_grabado" value="'.$this->id.'"><input type="submit" value="OK" name="Volver">');
				$txt = $this->texto_Ver_Lado_Uno(); // establecimiento_p_llamados
				$pagina->insertarCuerpo($txt);
				$txt = 'Capacitación # '.$this->o_capacitaciones->id().' eliminada' ;
				$pagina->insertarCuerpo($txt);
				$pagina->graficar_c_form($_SERVER['PHP_SELF']);
			}
			//
			// Agregado Capacitacion
			elseif ( isset( $_POST['m_cap_est__okAgregar'] ) )
			{
				$this->control_cambios_llamado(); // Graba las modificaciones del llamado
				$pagina=new Paginai($this->nombre_tabla ,'<input type="hidden" name="__id_del_llamado_grabado" value="'.$this->id.'"><input type="submit" value="Grabar Alta" name="'.$this->o_capacitaciones->okGrabaAgregar.'"><input type="submit" value="Salir" name="Volver">');
				$txt = $this->texto_Ver_Lado_Uno(); // establecimiento_p_llamados
				$pagina->insertarCuerpo($txt);
				$txt = $this->o_capacitaciones->texto_agregar() ;
				$pagina->insertarCuerpo($txt);
				$pagina->graficar_c_form($_SERVER['PHP_SELF']);
			}
			elseif ( isset( $_POST[$this->o_capacitaciones->okGrabaAgregar] ) )
			{
				$this->Set_id( $_POST['__id_del_llamado_grabado'] ) ;
				$this->o_capacitaciones->texto_agregar_okGrabar();
				if ( $this->o_capacitaciones->hay_error() == true )
				{ 
					$pagina=new Paginai($this->nombre_tabla ,'<input type="hidden" name="__id_del_llamado_grabado" value="'.$this->id.'"><input type="submit" value="OK" name="Volver">');
					$txt = $this->texto_Ver_Lado_Uno(); // establecimiento_p_llamados
					$pagina->insertarCuerpo($txt);
					$txt = $this->o_capacitaciones->textoError ;
					$pagina->insertarCuerpo($txt);
					$pagina->graficar_c_form($_SERVER['PHP_SELF']);
				}
				else 
				{
					$pagina=new Paginai($this->nombre_tabla ,'<input type="hidden" name="__id_del_llamado_grabado" value="'.$this->id.'"><input type="submit" value="OK" name="Volver">');
					$txt = $this->texto_Ver_Lado_Uno(); // establecimiento_p_llamados
					$pagina->insertarCuerpo($txt);
					$txt = 'Capacitación # '.$this->o_capacitaciones->id().' agregada' ;
					$pagina->insertarCuerpo($txt);
					$pagina->graficar_c_form($_SERVER['PHP_SELF']);
				}
			}
			elseif ( isset( $_POST[$this->okGrabaAgregar] ) or isset( $_POST[$this->okGrabar] ) )
			{
				
				// Graba Modificaciones
				if (isset( $_POST[$this->okGrabaAgregar] ) )
				$this->texto_agregar_okGrabar();
				elseif( isset( $_POST[$this->okGrabar] ) )
				$this->texto_actualizar_okGrabar() ; 
				//
				// Graba datos relacionados
				//
				// Turnos
				$this->o_maniana->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				$this->o_tarde->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				$this->o_noche->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				$this->o_maniana->texto_actualizar_okGrabar() ;
				$this->o_tarde->texto_actualizar_okGrabar() ;
				$this->o_noche->texto_actualizar_okGrabar() ;
				//
				// Infraestructura
				$this->o_infraestructura->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				$this->o_infraestructura->texto_actualizar_okGrabar() ;
				//
				//
				if ( $this->hay_error() == true ) $this->muestra_error() ;
				else 
				{
					//
					// Arma la página para editar		
					$pagina=new Pagina_llam($this->nombre_tabla ,'<input type="submit" value="Grabar" name="'.$this->okGrabar.'"><input type="submit" value="Salir" name="'.$this->okSalir.'">');
					$txt = $this->texto_Ver_Lado_Uno(); // establecimiento_p_llamados
					$pagina->insertarCuerpo($txt);
					//
					// Llamado Recien Agregado
					$pagina->insertarCuerpo('Llamado Edición<input type="hidden" value="edicion" name="_est_llamado">');
					$txt = 	$this->texto_actualizar() ;
					$pagina->insertarCuerpo($txt);
					//
					// Turnos
					$txtm = $this->o_maniana->texto_actualizar() ;
					$txtt = $this->o_tarde->texto_actualizar() ;
					$txtn = $this->o_noche->texto_actualizar() ;
					$txt= '<table><tr><th>Maniana</th><th>Tarde</th><th>Noche</th></tr><tr><td>'.$txtm.'</td><td>'.$txtt.'</td><td>'.$txtn.'</td></tr></table>';
					$pagina->insertarCuerpo($txt);
					//
					// Capacitaciones
					$this->o_capacitaciones->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
					$txt = $this->o_capacitaciones->texto_actualizar_detalle() ;
					$pagina->insertarCuerpo($txt);
					//
					// Infraestructura
					$txt = $this->o_infraestructura->texto_actualizar() ;
					$pagina->insertarCuerpo($txt);
					
					//
					// Llamados anteriores
					$txt = $this->texto_mostrar_detalle() ; 
					$pagina->insertarCuerpo($txt);
					$pagina->graficar_c_form($_SERVER['PHP_SELF']);
					
				}
			}
			elseif (  isset ($_POST['Volver']) )
			//
			// Vuelve de una modificacion
			{
				//
				// Levanta el id del llamado
				$this->Set_id( $_POST['__id_del_llamado_grabado'] ) ;
				//
				// Turnos
				$this->o_maniana->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				$this->o_tarde->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				$this->o_noche->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				//
				// Infraestructura
				$this->o_infraestructura->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				//
				// Arma la página para editar		
				$pagina=new Pagina_llam($this->nombre_tabla ,'<input type="submit" value="Grabar" name="'.$this->okGrabar.'"><input type="submit" value="Salir" name="'.$this->okSalir.'">');
				$txt = $this->texto_Ver_Lado_Uno(); // establecimiento_p_llamados
				$pagina->insertarCuerpo($txt);
				//
				// Llamado Recien Agregado
				$pagina->insertarCuerpo('Llamado Edición<input type="hidden" value="edicion" name="_est_llamado">');
				$txt = 	$this->texto_actualizar() ;
				$pagina->insertarCuerpo($txt);
				//
				// Turnos
				$txtm = $this->o_maniana->texto_actualizar() ;
				$txtt = $this->o_tarde->texto_actualizar() ;
				$txtn = $this->o_noche->texto_actualizar() ;
				$txt= '<table><tr><th>Maniana</th><th>Tarde</th><th>Noche</th></tr><tr><td>'.$txtm.'</td><td>'.$txtt.'</td><td>'.$txtn.'</td></tr></table>';
				$pagina->insertarCuerpo($txt);
				//
				// Capacitaciones
				$this->o_capacitaciones->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				$txt = $this->o_capacitaciones->texto_actualizar_detalle() ;
				$pagina->insertarCuerpo($txt);
				//
				// Infraestructura
				$txt = $this->o_infraestructura->texto_actualizar() ;
				$pagina->insertarCuerpo($txt);
				
				//
				// Llamados anteriores
				$txt = $this->texto_mostrar_detalle() ; 
				$pagina->insertarCuerpo($txt);
				$pagina->graficar_c_form($_SERVER['PHP_SELF']);
			}
			else
			{
				//
				// Arma la página para agregar		
				$pagina=new Pagina_llam($this->nombre_tabla ,'<input type="submit" value="Grabar" name="'.$this->okGrabaAgregar.'"><input type="submit" value="Salir" name="'.$this->okSalir.'">');
				$txt = $this->texto_Ver_Lado_Uno(); // establecimiento_p_llamados
				$pagina->insertarCuerpo($txt);
				//
				// Llamado Nuevo
				$pagina->insertarCuerpo('Llamado Nuevo<input type="hidden" value="nuevo" name="_est_llamado">');
				$txt = 	$this->texto_agregar();
				$pagina->insertarCuerpo($txt);
				//
				// Turnos
				$this->o_maniana->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				$this->o_tarde->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				$this->o_noche->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				$txtm = $this->o_maniana->texto_actualizar() ;
				$txtt = $this->o_tarde->texto_actualizar() ;
				$txtn = $this->o_noche->texto_actualizar() ;
				$txt= '<table><tr><th>Maniana</th><th>Tarde</th><th>Noche</th></tr><tr><td>'.$txtm.'</td><td>'.$txtt.'</td><td>'.$txtn.'</td></tr></table>';
				$pagina->insertarCuerpo($txt);
				//
				// Capacitaciones
				$this->o_capacitaciones->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				$txt = $this->o_capacitaciones->texto_actualizar_detalle() ;
				$pagina->insertarCuerpo($txt);
				//
				// Infraestructura
				$this->o_infraestructura->set_id_lado_uno( $this->devuelve_id_lado_uno() ) ;
				$txt = $this->o_infraestructura->texto_actualizar() ;
				$pagina->insertarCuerpo($txt);
				//
				// Llamados anteriores
				$txt = $this->texto_mostrar_detalle() ; 
				$pagina->insertarCuerpo($txt);
				$pagina->graficar_c_form($_SERVER['PHP_SELF']);
			}
		}
		public function texto_agregar()
		{
			$this->error= false ;
			$cpo = new Campo();
			$this->obj_lado_uno->Leer();
			if ( $this->obj_lado_uno->existe == false )
			{ 
				$this->error = true ;
				$this->textoError = "El registro con Id ".$this->obj_lado_uno->id." no se encuentra en la base de datos " ;
			}
			//
			// Abre tabla
			$txt = '<table>';
			for($i=1;$i<count($this->lista_campos_lectura);$i++)
				{
					$txt=$txt.'<tr>';
					$txt=$txt.'<td>';
				  $txt=$txt.$this->lista_campos_lectura[$i]['descripcion'];
				  $txt=$txt.'</td>';
					$cpo->pone_nombre( $this->prefijo_campo.'cpoNro'.$i.'_' ) ;
					$cpo->pone_valor( '' ) ;
					if ( $this->lista_campos_lectura[$i]['nombre'] == 'Fecha' )
						{
							$cpo->pone_valor( date("Y-m-d") ) ;
							$cpo->pone_tipo( $this->lista_campos_lectura[$i]['tipo'] ) ;
							$txt = $txt.$cpo->txtMostrarParaModificar() ;
						}
					elseif ( $this->lista_campos_lectura[$i]['nombre'] == 'Quien_Contacto' )
						{
							$to_usu = new usuario_conectado() ;
							$ts_operador = $to_usu->unom() ;
							$cpo->pone_valor( $ts_operador ) ;
							$cpo->pone_tipo( $this->lista_campos_lectura[$i]['tipo'] ) ;
							$txt = $txt.$cpo->txtMostrarParaModificar() ;
						}
					elseif( $this->lista_campos_lectura[$i]['tipo'] == 'pk' or $this->lista_campos_lectura[$i]['tipo'] == 'otro' )
						{ 
							//$cpo->pone_tipo( 'text' ) ;
							//$txt = $txt.$cpo->txtMostrarEtiqueta() ;
						}
					elseif( $this->lista_campos_lectura[$i]['tipo'] == 'fk' )
						{
							//
							// Lista de fk
							//
							$cpo->pone_tipo( 'select' ) ;
							$lista_fk = $this->lista_campos_lectura[$i]['clase']->Obtener_Lista() ;
							$cpo->pone_lista( $lista_fk ) ;
							$cpo->pone_posicion_codigo( 0 ) ;
							$cpo->pone_posicion_descrip( 1 ) ;
							$cpo->pone_mostar_nulo_en_si() ;
							$txt = $txt.$cpo->txtMostrarParaModificar() ;
						}
					else
						{ 
							$cpo->pone_tipo( $this->lista_campos_lectura[$i]['tipo'] ) ;
							$txt = $txt.$cpo->txtMostrarParaModificar() ;
							//$txt=$txt.'<input type="'.$this->lista_campos_tipo[$i].'" name="'.$nom_campo.'" value="'.$reg[$i].'">';
							//$txt=$txt.'</td>';
						}
					$txt=$txt.'</tr>';
				}
			//
			// Cierra tabla
			$txt = $txt.'</table>';
				return $txt ;
		}




		protected function texto_mostrar_detalle ()
			{
				$this->error= false ;
				$this->obj_lado_uno->Leer();
				if ( $this->obj_lado_uno->existe == false )
				{ 
					$this->error = true ;
					$this->textoError = "El registro con Id ".$this->obj_lado_uno->id." no se encuentra en la base de datos " ;
				}
				//
				// Lee Lista
				$txt = '' ;
				if ( $this->error == false )
				{
					$this->leer_lista();
					$txt = '';
					$txt=$txt.'<table>';
					$txt.= '<tr><td colspan="6">LLAMADOS ANTERIORES</td></tr>';
					$txt=$txt.'<tr>' ;
					$txt=$txt.'<td> </td>';
					$cntcols = 0 ;
					foreach( $this->lista_campos_lista as $ta_campo )
					{
						$cntcols ++ ;
						if( $cntcols > 1 )
						{
							$txt=$txt.'<td>';
						  $txt=$txt.$ta_campo['descripcion'];
						  $txt=$txt.'</td>';
						}
					}
										
					/*$cntcols = count($this->lista_campos_descrip)+2 ;
					for($i=1;$i<count($this->lista_campos_descrip);$i++)
						{
							$txt=$txt.'<td>';
				      $txt=$txt.$this->lista_campos_descrip[$i];
				      $txt=$txt.'</td>';
						}
					*/
					$txt=$txt.'</tr>';
					while ($this->existe == true and $reg=mysqli_fetch_array($this->registros,MYSQLI_NUM) )
						{
				    	$txt=$txt.'<tr>';
							$txt=$txt.'<td>';
				  		//$txt=$txt.'<input type="checkbox" name="'.$this->prefijo_campo.'_Id'.$reg[0].'">';
				  		$txt=$txt.'</td>';
				  		for($f=1;$f<count($reg);$f++)
								{
									$txt=$txt.'<td>';
						      $txt=$txt.$reg[$f];
						      $txt=$txt.'</td>';
								}
							//$txt=$txt.'<td>' ;
							//$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.'okVer=1">Ver</a>' ;
							//$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.'okModificar=1">Modificar</a>' ;
							//$txt=$txt.'</td>' ;
							$txt=$txt.'</tr>';
						}
					/*if ( $this->existe == true )
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
						}*/
					$txt=$txt.'</table>';
					}
					else
					{
						$txt=$txt.'<tr><td> '.$this->textoError.'</td></tr>' ; 
					}
					return $txt;
			}

		protected function modifica_tabla()
		{
			$this->strsql = " ALTER TABLE llamados DROP PRIMARY KEY " ;
			
			$this->strsql = " ALTER TABLE llamados ADD Llamado_Nro INT PRIMARY KEY AUTO_INCREMENT " ;
			
			$this->strsql = " ALTER TABLE `llamados` CHANGE `Llamado` `Llamado` INT(11) NULL " ;
			
			$this->strsql = " ALTER TABLE `llamados` CHANGE `Observación` `Observacion` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL " ;
		}

}

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
			$this->acciones[] = array( 'nombre'=>'okLlamado' , 'texto'=>'Llamados' ) ;
			//$this->acciones[] = array( 'nombre'=>'okAsignarCordo' , 'texto'=>'Asignar Coordinador' ) ;
			//
			// Filtros
			$this->con_filtro_fecha = true;
			$this->con_filtro_general = true;
			//
		}
	protected function maneja_evento_accion_especial()
		{
			$ts_nombre_id = 'llamados_CUE_id' ;
			$ts_header = 'Location: alta_llamado.php' ;
			$ts_header .= '?' . $ts_nombre_id . '=' . $this->id ;
			header($ts_header) ;
		}

/*	public function texto_agregar_okGrabar()
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
*/	
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
					$hasta = date_add($ahora, date_interval_create_from_date_string('29 days'));
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
									capacitaciones.Estado ,
									capacitaciones.Edicion_Nro
									FROM capacitaciones 
									WHERE capacitaciones.Edicion_Nro = " .$this->edicion . " " ;
		$this->strsql.= 	" AND capacitaciones.Estado <>'E' " ;
		$this->strsql.= 	" AND capacitaciones.Fecha >='".$this->filtro_f_desde."' " ;
		$this->strsql.= 	" AND capacitaciones.Fecha <='".$this->filtro_f_hasta."' " ;
		$this->strsql.= 	" 	) as cc
							ON cc.CUE = escuelas_general.CUE 
							LEFT JOIN estado_capacitaciones ON estado_capacitaciones.Estado_Cod = cc.Estado
							LEFT JOIN turnos ON turnos.Turno_ID = cc.Turno_Id
							LEFT JOIN colores ON estado_capacitaciones.Color = colores.Color_Cod	" ;
							
							
		if ( isset( $_REQUEST[$this->prefijo_campo.'filtro_general'] ) )
		{
			if( ! empty( $_REQUEST[$this->prefijo_campo.'filtro_general'] ) )
			{
			$this->strsql.= 	" WHERE  escuelas_general.NOMBRE like '%".$this->filtro_gral."%' " ;
			}
			
		}
		$this->strsql.= 	"GROUP BY escuelas_general.CUE,
										escuelas_general.Nombre ,
										turnos.Turno ,
								estado_capacitaciones.Estado
							ORDER BY cc.Edicion_Nro DESC, MIN( cc.Fecha ) ASC, escuelas_general.Nombre
							
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
		public function mostrar_lista_abm()
		{
			$hidden = '' ;
			$pagina = new Paginai($this->nombre_tabla ,$hidden.'<input type="submit" name="okSalir" value="Salir">') ;
			//
			// Muestra la cabecera
			$texto = $this->texto_mostrar_abm() ;
			$pagina->insertarCuerpo($texto);
			//
			// Grafica la página
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
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
			//$txt=$txt.'<th> </th>';
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
				//$txt=$txt.'<td>';
				//$txt=$txt.'<input type="checkbox" name="'.$this->prefijo_campo.'_Id'.$reg[0].'">';
				//$txt=$txt.'</td>';
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
			/*if ( $this->existe == true )
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
				*/
			$txt=$txt.'</table>';
			return $txt;
		}

	protected function modifica_tabla()
		{
			$this->strsql = ' ALTER TABLE capacitaciones ADD Programa_Nro INT ' ; 
		}
	

}



?>
