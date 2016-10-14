<?php
class vista_cantidad_escuelas_capacitadas
{
	protected function crear(){

			$this->strsql = " CREATE VIEW vista_cantidad_escuelas_capacitadas as 
								
								SELECT count( vista_escuelas_capacitadas.CUE ) as Cantidad_de_Escuelas , 
										escuelas_general.Gestion_Tipo , vista_escuelas_capacitadas.Programa_Nro ,
										MONTH( vista_escuelas_capacitadas.Fecha_Cap ) as Mes ,
										YEAR( vista_escuelas_capacitadas.Fecha_Cap ) as Anio ,
										vista_escuelas_capacitadas.Edicion_Nro
								FROM	
									vista_escuelas_capacitadas
								LEFT JOIN
									escuelas_general
								ON
										escuelas_general.CUE = vista_escuelas_capacitadas.CUE
								GROUP BY escuelas_general.Gestion_Tipo, 
										vista_escuelas_capacitadas.Programa_Nro ,
										MONTH( vista_escuelas_capacitadas.Fecha_Cap ) ,
										YEAR( vista_escuelas_capacitadas.Fecha_Cap ) ,
										Edicion_Nro 
								ORDER BY Anio DESC,Mes,Gestion_Tipo,Programa_Nro
								" ;
								
								
			
							}
}
?>  
