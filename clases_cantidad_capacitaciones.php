<?php

class vista_cantidad_capacitaciones_x_docente
{

	function crear_tabla()
	{
		$txt = "   create view vista_cantidad_capacitaciones_x_docente AS
		
		SELECT 	personas.`Apellido y Nombre`, 
					personas.Persona_Id, 
					docentes_de_los_anexos.Docente_Nro,
					Count(anexo.Anexo_Nro) AS Cantidad_de_Capacitaciones, 
					Month(anexo.Fecha) AS Mes, 
					Year(anexo.Fecha) AS Anio,
					anexo.Edicion_Nro,
					max(anexo.Anexo_Nro) as Ultimo_Anexo
					FROM docentes_de_los_anexos
					LEFT JOIN anexo ON anexo.Anexo_Nro = docentes_de_los_anexos.Anexo_Nro 
					LEFT JOIN docente ON docente.Docente_Nro = docentes_de_los_anexos.Docente_Nro
					LEFT JOIN personas ON docente.Persona_Id = personas.Persona_Id 
					WHERE anexo.Anexo_Nro not in (
							select capacitaciones.Anexo_Nro 
							from capacitaciones where capacitaciones.Estado = 'N'
                            and capacitaciones.Anexo_Nro is not null)
					GROUP BY personas.`Apellido y Nombre`, personas.Persona_Id, Month(anexo.Fecha)
					ORDER BY Year(anexo.Fecha) DESC, personas.`Apellido y Nombre`
					
					
					;
" ;


		$total_escuelas_2016 = " SELECT COUNT(CUE) , Gestion_Tipo , Edicion_Nro from 
								(
									SELECT anexo.CUE , 
										anexo.Edicion_Nro ,Gestion_Tipo
										from anexo
										left join escuelas_general
										on anexo.CUE = escuelas_general.CUE
										where Edicion_Nro = 2016  
										group by anexo.CUE, Edicion_Nro , Gestion_Tipo 
								) as Escuelas_Capacitadas
								group by Edicion_Nro, Gestion_Tipo
									
								" ;
		$total_alumnos_2016 = "
						
												
								
								sum( anexo.Cantidad_de_Alumnos ) as Cantidad_Alumnos_Capacitados , 
								escuelas_general.Gestion_Tipo as Gestion , 
								anexo.Edicion_Nro , capacitaciones.Programa_Nro
							From anexo 
							LEFT JOIN escuelas_general
							ON anexo.CUE = escuelas_general.CUE
							LEFT JOIN capacitaciones
							ON anexo.Anexo_Nro = capacitaciones.Anexo_Nro
							where anexo.Edicion_Nro = 2016
							GROUP BY  escuelas_general.Gestion_Tipo ,
							capacitaciones.Programa_Nro
							ORDER BY Gestion,Programa_Nro
							
							";
	}
}
?>
