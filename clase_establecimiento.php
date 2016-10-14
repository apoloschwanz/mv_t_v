<?php

class Establecimiento extends Entidadi  {
 		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_estab_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'other' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'CUE' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Codigo Estab.' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'NOMBRE' 	, 'tipo'=>'text' 	, 'descripcion'=>'Establecimiento' , 'clase'=>NULL ) ;
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
		//


			protected function Carga_Sql_Lista()
	{
		$this->strsql = " SELECT escuelas_general.CUE , escuelas_general.NOMBRE 
															FROM ".$this->nombre_fisico_tabla."
															ORDER BY escuelas_general.NOMBRE, escuelas_general.CUE "  ;
			
	}


}

?>
