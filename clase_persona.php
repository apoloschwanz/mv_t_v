<?php


class persona extends Entidadi {
	protected $mail ;
	protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_pers_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'Persona_Id' 			, 'tipo'=>'pk' 		, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Apellido y Nombre' 	, 'tipo'=>'text' 	, 'descripcion'=>'Persona' , 'clase'=>NULL ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'Persona_Id' 			, 'tipo'=>'pk' 		, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Apellido y Nombre' 	, 
													'tipo'=>'otro' 	, 
													'descripcion'=>'Nombre' , 
													'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'DNI' 	, 
													'tipo'=>'number' 	, 
													'descripcion'=>'Numero de Documento' , 
													'clase'=>NULL ) ;
			
													
						
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Docentes" ;
			$this->nombre_fisico_tabla = "personas" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					// by DZ 2015-08-14 - agregado lista de datos
			$this->cuenta = 15 ;																				// by DZ 2015-08-14 - agregado lista de datos		
			//
			// Acciones Extra para texto_mostrar_abm
			//$this->acciones[] = array( 'nombre'=>'okAsignarDte' , 'texto'=>'AsignarDte' ) ;
			//
			// Botones extra edicion
			$this->botones_extra_edicion = array();
			$this->botones_extra_edicion[] = array( 'name'=> '_Comunas' ,
										'value'=>'Comunas' ,
										'link'=>'comunas_del_docente.php' ) ; // '<input type="submit" name="'.$this->prefijo_campo.'_Rel1" value="Salir" autofocus>
			$this->botones_extra_edicion[] = array( 'name'=> '_DiasTurnos' ,
										'value'=>'Turnos' ,
										'link'=>'turnos_del_docente.php' ) ; // '<input type="submit" name="'.$this->prefijo_campo.'_Rel1" value="Salir" autofocus>


	
		}	
	protected function Carga_Sql_Lectura()
	{
	$this->strsql = " SELECT Persona_Id , `Apellido y Nombre` , DNI FROM `personas`   
										WHERE Persona_Id = '".$this->id."'" ;
	}
	protected function Carga_Sql_Lista()
	{
	$this->strsql = "SELECT Persona_Id , Apellido y Nombre , DNI FROM personas " ;
	}
	public function agregar($apeynom,$tel,$mail)
	{
		$this->existe = false ;
		$this->id = null ;
		//
		// Abre la conexion
		$cn=new Conexion();
		$this->strsql = "INSERT INTO personas ( `Apellido y Nombre` , Tel )
										VALUES 
										( 
										'".$apeynom."' ,
										'".$tel."' 
										)" ;
		$agregado = mysqli_query($cn->conexion,$this->strsql) ;
		if ( $agregado and mysqli_affected_rows($cn->conexion) == 1 )
		{
			$this->id = $cn->conexion->insert_id ;
			$this->existe = true ;
		}
		else
		{
			$cn->cerrar();
			die( 'Error al agregar persona ' ) ;
		}			
		//
		// Cierra la conexion
		$cn->cerrar();
	}
	private function actualiza_tabla()
	{
		$this->strsql = 'ALTER TABLE `personas` ADD PRIMARY KEY ( `Persona_Id` ) ;
						ALTER TABLE `personas` CHANGE `Teléfono` `Tel` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
						ALTER TABLE `personas` CHANGE `Persona_Id` `Persona_Id` INT(11) NOT NULL AUTO_INCREMENT; ' ;
	}
}
?>
