<?php

class Capacitaciones_de_un_Anexo_p_Encuesta extends Entidad {
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Capacitaciones de un Anexo" ;
		}
	protected function Carga_Sql_Lista() //protected function Carga_Sql_Lectura()
		{
			$this->strsql = " SELECT 	capacitaciones.Anexo_Nro, 
										capacitaciones.Crono_Id , 
										capacitaciones.Programa_Nro , 
										programa.Programa 
									FROM capacitaciones 
									LEFT join programa 
										ON capacitaciones.Programa_Nro = programa.Programa_Nro 
									WHERE capacitaciones.Anexo_Nro = ".$this->id;
		}
}

?>
