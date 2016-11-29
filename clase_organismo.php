<?php

require_once 'clase_entidadj.php' ;
require_once 'clase_superorganismo.php' ;

class organismo extends entidadj {
	protected function Pone_Datos_Fijos_No_Heredables()
	{
		$this->nombre_fisico_tabla = 'organismo' ;
		$this->nombre_tabla = 'Organismo' ;
		$this->lista_campos_lista=array();
		$this->lista_campos_lista[]=new campo_entidad( 'Organismo_ID' 			, 'pk' 		, '#' ) ;
		$this->lista_campos_lista[]=new campo_entidad( 'Organismo' 	, 'text' 	, 'Organismo'  ) ;
		$this->lista_campos_lista[1]->pone_busqueda() ;
		//
		//
		$this->lista_campos_lectura=array();
		$this->lista_campos_lectura[]=new campo_entidad( 'Organismo_ID' 			, 'pk' 		, '#' ) ;
		$this->lista_campos_lectura[]=new campo_entidad( 'Organismo' 	, 'text' 	, 'Organismo'  ) ;
		$this->lista_campos_lectura[]=new campo_entidad( 'SuperOrganismo_Id' 	, 'text' 	, 'Super Organismo' , new superorganismo()  ) ;
	}

	
}

?>
