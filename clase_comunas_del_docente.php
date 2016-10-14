<?php

class Comunas_del_Docente extends relacionj {

		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Lado Uno de la Relación
			$this->obj_lado_uno = new Docente() ;
			$this->nombre_id_lado_uno = 'Docente_Nro' ;
			//
			// Lado Muchos de la Relación
			$this->obj_lado_muchos = new Comunas() ;
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_comunas_del_dte_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'Comuna_Nro' , 'tipo'=>'pk' 	, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Comuna' , 'tipo'=>'otro' 	, 'descripcion'=>'Comuna' , 'clase'=>NULL ) ;

			
			
			//$this->lista_campos_lista[]=array( 'nombre'=>'Nombre' 	, 'tipo'=>'text' 	, 'descripcion'=>'Docente' , 'clase'=>NULL ) ;
			//$this->lista_campos_lista[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>new Entidadi() ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'	=>'Comuna_Nro' , 
												 'tipo'		=>'pk' 	, 
												 'descripcion'=>'#' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'	=>'Comuna' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Comuna' , 
												 'clase'=>NULL ) ;
			
			//
			// Lista de Campos
			$this->lista_campos_descrip=array() ;
			$this->lista_campos_tipo=array() ;
			$this->lista_campos_nombre=array() ;
			$this->lista_campos_descrip[]='Comuna #' ;
			$this->lista_campos_descrip[]='Comuna' ;
			$this->lista_campos_tipo[]='pk' ; // 'pk' 'fk' 'other' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password' 
			$this->lista_campos_tipo[]='otro';
			$this->lista_campos_nombre[]='Comuna_Nro' ;
			$this->lista_campos_nombre[]='Comuna' ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Comunas del Docente" ;
			$this->nombre_fisico_tabla = "comunas_x_docente" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					
			$this->cuenta = 15 ;																						
		}	
			protected function Carga_Sql_Lectura()
		{
		$this->strsql = "SELECT comunas_x_docente.Comuna_Nro, Comuna FROM `comunas_x_docente` 
							LEFT JOIN comunas
							ON comunas_x_docente.Comuna_Nro = comunas.COMUNA_Nro
							WHERE `Docente_Nro` = '".$this->id."' and comunas_x_docente.Comuna_Nro = '".$this->id_lado_uno."' " ;
		}
		protected function Carga_Sql_Lista()
		{
			//
			// Lista de Registros de la relacion
			$this->strsql = "SELECT comunas_x_docente.Comuna_Nro, Comuna FROM `comunas_x_docente` 
							LEFT JOIN comunas
							ON comunas_x_docente.Comuna_Nro = comunas.COMUNA_Nro
							WHERE `Docente_Nro` = '".$this->id_lado_uno."' " ;		
		}





}
?>
