<?php
//
//
// Clase Rol - Usuario
class RolUsuario extends relacionj {
	public function  Pruebas()
	{
		echo '<br> Pruebas de RolUsuario' ;
		echo '<br> Pruega si el usuario docente tiene rol docente ';
		echo '<br> El rol docente tiene rol docente: '.$this->Tiene_Rol('docente','docente');
		echo '<br> Pruega si el usuario docente tiene rol noexiste ';
		echo '<br> El rol docente tiene rol noexiste: '.$this->Tiene_Rol('docente','noexiste');
		
	}
	public function  Tiene_Rol($usr,$rol )
	{
		$this->id_lado_uno = $usr ;
		$this->id = $rol ;
		$this->leer();
		return $this->existe ;
	}
	protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Lado Uno de la Relación
			$this->obj_lado_uno = new utilisateur() ;
			//
			// Nombre del Id en la tabla de la ralacion
			$this->nombre_id_lado_uno = 'userid' ;
			//
			// Lado Muchos de la Relación
			$this->obj_lado_muchos = NULL ;// aun no existe esa clase //new Entidad() ;
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_rolusu_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'userid' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Usuario' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'func_id' 	, 'tipo'=>'text' 	, 'descripcion'=>'Funcion' , 'clase'=>NULL ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'userid' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Usuario' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'func_id' 	, 'tipo'=>'text' 	, 'descripcion'=>'Funcion' , 'clase'=>NULL ) ;
			
			//
			// Lista de Campos
			$this->lista_campos_descrip=array() ;
			$this->lista_campos_tipo=array() ;
			$this->lista_campos_nombre=array() ;
			foreach( $this->lista_campos_lista as $campo )
			{
				$this->lista_campos_descrip[]= $campo['descripcion'] ;
				$this->lista_campos_tipo[]= $campo['tipo'] ;
				$this->lista_campos_nombre[]= $campo['nombre'] ;
			}
			
			$this->lista_campos_descrip[]='Identificador' ;
			$this->lista_campos_descrip[]='Descripcion de Entidad' ;
			$this->lista_campos_tipo[]='pk' ; // 'pk' 'fk' 'other' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password' 
			$this->lista_campos_tipo[]='text';
			$this->lista_campos_nombre[]='Crono_Id' ;
			$this->lista_campos_nombre[]='Descrip' ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Roles del Usuario" ;
			$this->nombre_fisico_tabla = "rolusuario" ;
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
		$this->strsql =  " SELECT userid, func_id FROM rolusuario ";
		$this->strsql .= 	" WHERE userid = '".$this->id_lado_uno."' " ; 
		$this->strsql .= 	" AND func_id = '".$this->id."' " ;
	}
	protected function Carga_Sql_Lista ()
	{
		$this->strsql = " SELECT userid, func_id FROM rolusuario
							LEFT JOIN user
                            ON rolusuario.userid = user.userid " ;
	}
	private function Crear_Tabla ()
	{
		//
		// Crea la tabla
		$this->strsql = " CREATE TABLE rolusuario ( 
							userid VARCHAR(100) NOT NULL ,
							func_id 	varchar(255) 	,
							hora_alta timestamp DEFAULT CURRENT_TIMESTAMP ,
							hora_mod  timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
							PRIMARY KEY( userid, func_id )
							) " ;
	}
}


?>
