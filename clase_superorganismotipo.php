<?php

require_once 'clase_entidadj.php' ;

class superorganismotipo extends entidadj {
	protected function Pone_Datos_Fijos_No_Heredables()
	{
		$this->nombre_fisico_tabla = 'super_organismo' ;
		$this->nombre_tabla = 'Super-organismo' ;
		$this->lista_campos_lista=array();
		$this->lista_campos_lista[]=new campo_entidad( 'Id' 			, 'pk' 		, '#' ) ;
		$this->lista_campos_lista[]=new campo_entidad( 'SuperOrganismoTipo' 	, 'text' 	, 'Tipo de Superorganismo'  ) ;
		$this->lista_campos_lista[1]->pone_busqueda() ;
		//
		//
		$this->lista_campos_lectura=array();
		$this->lista_campos_lectura[]=new campo_entidad( 'Id' 			, 'pk' 		, '#' ) ;
		$this->lista_campos_lectura[]=new campo_entidad( 'SuperOrganismoTipo' 	, 'text' 	, 'Tipo de Superorganismo'  ) ;
	}

	
}

?>
