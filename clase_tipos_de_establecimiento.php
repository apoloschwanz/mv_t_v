<?php

require_once 'clase_entidadj.php' ;

class tipos_de_establecimiento extends entidadj {
	protected function Pone_Datos_Fijos_No_Heredables()
	{
		$this->nombre_fisico_tabla = 'tipos_de_establecimiento' ;
		$this->nombre_tabla = 'Tipos de Establecimiento' ;
		$this->lista_campos_lista=array();
		$this->lista_campos_lista[]=new campo_entidad( 'Tipo_Estab_Nro' 			, 'pk' 		, 'Tipo de Establecimiento Nro.' ) ;
		$this->lista_campos_lista[]=new campo_entidad( 'Tipo_Estab' 	, 'text' 	, 'Tipo de Establecimiento'  ) ;
		$this->lista_campos_lista[1]->pone_busqueda() ;
		//
		//
		$this->lista_campos_lectura=array();
		$this->lista_campos_lectura[]=new campo_entidad( 'Tipo_Estab_Nro' 			, 'pk' 		, 'Tipo de Establecimiento Nro.'  ) ;
		$this->lista_campos_lectura[]=new campo_entidad( 'Tipo_Estab' 	, 'text' 	, 'Tipo de Establecimiento'  ) ;
	}
}

?>
