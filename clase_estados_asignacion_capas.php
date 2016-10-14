<?php

class Estados_asignacion_capas extends entidadi {
	protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_dte_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'Estado_Cod' 			, 'tipo'=>'pk' 		, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Estado' 	, 'tipo'=>'text' 	, 'descripcion'=>'Estado' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Red' 	, 'tipo'=>'otro' 	, 'descripcion'=>'Red' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Green' 	, 'tipo'=>'otro' 	, 'descripcion'=>'Green' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Blue' 	, 'tipo'=>'otro' 	, 'descripcion'=>'Blue' , 'clase'=>NULL ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'Estado_Cod' 			, 'tipo'=>'pk' 		, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Estado' 	, 'tipo'=>'text' 	, 'descripcion'=>'Estado' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Red' 	, 'tipo'=>'otro' 	, 'descripcion'=>'Red' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Green' 	, 'tipo'=>'otro' 	, 'descripcion'=>'Green' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Blue' 	, 'tipo'=>'otro' 	, 'descripcion'=>'Blue' , 'clase'=>NULL ) ;
						
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Docentes" ;
			$this->nombre_fisico_tabla = "docentes" ;
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
	
		}	
	protected function Carga_Sql_Lista () 
		{
			$this->strsql = "	SELECT 	Estado_Cod, 
										Estado, 
										Red, 
										Green, 
										Blue 
								FROM estados_asignacion_capas 
								LEFT JOIN colores 
									ON estados_asignacion_capas.Color_Cod = colores.Color_Cod" ;
		}
	

}

?>
