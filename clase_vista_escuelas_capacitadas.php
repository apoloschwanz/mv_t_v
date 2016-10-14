<?php
class vista_escuelas_capacitadas
{
	protected function crear(){

			
								
								
			$this->strsql = " CREATE VIEW vista_escuelas_capacitadas as
								SELECT anexo.CUE , MAX( anexo.Fecha ) as Fecha_Cap, 
									anexo.Edicion_Nro, capacitaciones.Programa_Nro from anexo 
									left join capacitaciones
									on anexo.Anexo_Nro = capacitaciones.Anexo_Nro
									group by anexo.CUE , anexo.Edicion_Nro ,capacitaciones.Programa_Nro " ;
							}
}
?>  
