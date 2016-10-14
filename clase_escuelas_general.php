<?php

require_once 'clase_gestion_tipo.php' ;

class escuelas_general extends Entidadi  {
	
	
 		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_estab_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'CUE' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Codigo Estab.' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'CUE' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Codigo Estab.' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'CUE' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Codigo Estab.' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'NOMBRE' 	, 'tipo'=>'text' 	, 'descripcion'=>'Establecimiento' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'DOMICILIO' 	, 'tipo'=>'text' 	, 'descripcion'=>'Direccion' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'TELEFONO' 	, 'tipo'=>'text' 	, 'descripcion'=>'Teléfono' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Gestion_Tipo' 	, 'tipo'=>'text' 	, 'descripcion'=>'Gestión' , 'clase'=>NULL ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'CUE' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Codigo Estab.' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'NOMBRE' 	, 'tipo'=>'text' 	, 'descripcion'=>'Establecimiento' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'DOMICILIO' 	, 'tipo'=>'text' 	, 'descripcion'=>'Direccion' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'TELEFONO' 	, 'tipo'=>'text' 	, 'descripcion'=>'Teléfono' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Gestion_Tipo' 	, 'tipo'=>'fk' 	, 'descripcion'=>'Gestión' , 'clase'=>new gestion_tipo() ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'DEPENDENCIA_FUNCIONAL' 	, 'tipo'=>'text' 	, 'descripcion'=>'Dependencia Funcional' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Escuela_Ofertas' 	, 'tipo'=>'text' 	, 'descripcion'=>'Ofertas' , 'clase'=>NULL ) ;
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
			$this->con_filtro_fecha = false;
			$this->con_filtro_general = true;
			//
			//
		}	




}

?>
