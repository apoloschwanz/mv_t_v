<?php

require_once 'clase_entidadj.php' ;

class cargo extends entidadj {
	protected function Pone_Datos_Fijos_No_Heredables()
	{
		$this->nombre_fisico_tabla = 'cargos' ;
		$this->nombre_tabla = 'Cargos' ;
		$this->lista_campos_lista=array();
		$this->lista_campos_lista[]=new campo_entidad( 'Cod_Cargo' 			, 'pk' 		, '#' ) ;
		$this->lista_campos_lista[]=new campo_entidad( 'Cargo' 	, 'text' 	, 'Cargo'  ) ;
		$this->lista_campos_lista[1]->pone_busqueda() ;
		//
		//
		$this->lista_campos_lectura=array();
		$this->lista_campos_lectura[]=new campo_entidad( 'Cod_Cargo' 			, 'pk' 		, '#' ) ;
		$this->lista_campos_lectura[]=new campo_entidad( 'Cargo' 	, 'text' 	, 'Cargo'  ) ;
	}

	
}

?>
