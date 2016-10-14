<?php

class func extends Entidadi {
	//
	// Funcion controlar funcion ( usuario  ) -> devuelve true o false
	public function controlar_funcion( $usuario )
	{
		$habilitado = false ;
		//
		// Si el usuario pertenece al grupo administradores
		$usr = new utilisateur() ;
		$usr->Set_id($usuario) ;
		$rolusuario = $usr->obtener_rol() ;
		if ( $rolusuario == 'admin' ) $habilitado = true ;
		if ( $usr->tiene_rol('admin')  ) $habilitado = true ; // BY DZ 2016_05_27 
		//
		// Lee el rol de la funcion
		$reg = $this->Obtener_Datos() ;
		
		//
		// Si la funcion no existe la agrega ?
		if ( ! $this->existe )
		{
			$cn=new Conexion();
			$this->strsql = "INSERT INTO funciones 
							( func_id , descrip , rol )
							VALUES
							('".$this->id."' , 'Auto' , NULL )" ;
			$texto = 'inserto con resultado '.mysqli_query($cn->conexion,$this->strsql) ;
			$cn->cerrar();
		}
		else
		{	
			//
			// Verifica si el usuario tiene el rol.
			if ( $usr->tiene_rol($reg['rol'])  )
			{
				//
				// Si el usuario tiene el rol
				$habilitado = true ;
			}
		}
		return $habilitado ;
	}
		
	protected function Pone_Datos_Fijos_No_Heredables()
	{	
		//
		// Prefijo campo
		$this->prefijo_campo = 'm_func_' ;
		//
		// Lista de Campos
		//
		// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
		//								el tipo 'fk' espera que se defina una clase 
		$this->lista_campos_lista=array();
		$this->lista_campos_lista[]=array( 'nombre'=>'func_id' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Código' , 'clase'=>NULL ) ;
		$this->lista_campos_lista[]=array( 'nombre'=>'func_id' 	, 'tipo'=>'otro' 	, 'descripcion'=>'Función' , 'clase'=>NULL ) ;
		$this->lista_campos_lista[]=array( 'nombre'=>'func_id' 	, 'tipo'=>'otro' 	, 'descripcion'=>'Función' , 'clase'=>NULL ) ;
		$this->lista_campos_lista[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Descripción' , 'clase'=>NULL ) ;
		$this->lista_campos_lista[]=array( 'nombre'=>'rol' 	, 'tipo'=>'text' 	, 'descripcion'=>'Rol' , 'clase'=>new rol() ) ;
		//
		//
		$this->lista_campos_lectura=array();
		$this->lista_campos_lectura[]=array( 'nombre'=>'func_id' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Función' , 'clase'=>NULL ) ;
		$this->lista_campos_lectura[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Descripción' , 'clase'=>NULL ) ;
		$this->lista_campos_lectura[]=array( 'nombre'=>'rol' 	, 'tipo'=>'text' 	, 'descripcion'=>'Rol' , 'clase'=>new rol() ) ;
					
		//
		// Nombre de la tabla
		$this->nombre_tabla = "Funciones" ;
		$this->nombre_fisico_tabla = "funciones" ;
		//
		// Nombre de la pagina
		$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
		//
		// Paginacion
		$this->desde = 0 ;																					
		$this->cuenta = 15 ;																						
		//
		// Acciones Extra para texto_mostrar_abm
		//$this->acciones = array( 'nombre'=>'okAsignarDte' , 'texto'=>'AsignarDte' ) ;
		$this->acciones = array() ;
		//
		// Filtros
		$this->con_filtro_general = true ;

	}
	/*
	protected function Carga_Sql_Lectura() ( usa la de la clase que extiende ) - DZ 2016-08-30
	{
	$this->strsql = "SELECT func_id, descrip , rol
			FROM funciones 
			WHERE func_id = '" .$this->id."' " ;
	}
	*/
	private function Crear_Tabla()
	{
		$this->strsql = "CREATE TABLE funciones
						( func_id varchar(255) NOT NULL PRIMARY KEY,
							descrip varchar(100) ,
							rol varchar(25) ) " ;
	}



}

class rol {
}

?>
