<?php

class Observaciones_Encuesta extends entidad {
		protected function Carga_Sql_Lista()
	{
	$this->strsql = "SELECT observaciones_encuesta.Observacion_Nro, observaciones_encuesta.`Observación` 
									FROM  observaciones_encuesta
									ORDER BY observaciones_encuesta.`Observación`";
		$this->lista_campos_descrip=array() ;
		$this->lista_campos_tipo=array() ;
		$this->lista_campos_descrip[]='Observacion' ;
		$this->lista_campos_tipo[]='text' ; // 'pk' 'fk' 'other' 'text' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
	}
}

?>
