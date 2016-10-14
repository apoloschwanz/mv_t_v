<?php
class gestion_tipo extends Entidadi
{
	protected function Pone_Datos_Fijos_No_Heredables()
	{
		$this->lista_campos_lista=array();
		$this->lista_campos_lista[]=array( 'nombre'=>'Gestion_Tipo' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Codigo Estab.' , 'clase'=>NULL ) ;
		$this->lista_campos_lista[]=array( 'nombre'=>'Gestion_Nombre' 	, 'tipo'=>'text' 	, 'descripcion'=>'Establecimiento' , 'clase'=>NULL ) ;
		//
		// Nombre de la tabla
		$this->nombre_tabla = "Tipo de Gestion" ;
		$this->nombre_fisico_tabla = "gestion_tipo" ;
	}
	protected function modifica_tabla()
	{
		$this->strsql = " RENAME TABLE  `gesti??n_tipo`  TO gestion_tipo ; " ;
		
		$this->strsql = " ALTER TABLE gestion_tipo CHANGE COLUMN `Gestión_Tipo` `Gestion_Tipo` VARCHAR(7) ; " ;
		 	 		
		$this->strsql = " ALTER TABLE gestion_tipo CHANGE COLUMN `Gestión_Nombre` `Gestion_Nombre` VARCHAR(55) ; " ;
		
	}
}
?>
