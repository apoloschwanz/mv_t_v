<?php

class Turno extends Entidadi  {
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
			$this->lista_campos_lista[]=array( 'nombre'=>'Turno_ID' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Código de Turno' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Turno' 	, 'tipo'=>'text' 	, 'descripcion'=>'Turno' , 'clase'=>NULL ) ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Turnos" ;
			$this->nombre_fisico_tabla = "turnos" ;
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
		$this->strsql = " SELECT ".$this->lista_campos_lista[0]['nombre']." , ".$this->lista_campos_lista[1]['nombre']." 
															FROM ".$this->nombre_fisico_tabla."
															ORDER BY ".$this->lista_campos_lista[0]['nombre']." , ".$this->lista_campos_lista[1]['nombre']." "  ;
			
	}


}

?>
