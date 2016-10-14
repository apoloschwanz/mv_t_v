<?php

require_once 'clase_enti_lite.php' ;

class vista_total_de_capacitaciones extends enti_lite 
{
	protected function Pone_Datos_Fijos_No_Heredables()
	{
		//
		//
		//
		// Nombre de la tabla
		$this->nombre_tabla = "Total de Capacitaciones" ;
		//
		$this->lista_campos_lectura[]=array( 	'nombre'=>'Cantidad_de_Capas' 			, 
												'tipo'=>'otro' 		, 
												'descripcion'=>'Capacitaciones' , 
												'clase'=>NULL ) ;
												
		$this->lista_campos_lectura[]=array( 	'nombre'=>'Cantidad_Alumnos_Capacitados' 			, 
												'tipo'=>'otro' 		, 
												'descripcion'=>'Alumnos' , 
												'clase'=>NULL ) ;
												
		$this->lista_campos_lectura[]=array( 	'nombre'=>'Cantidad_Adicional_Capacitados' 			, 
												'tipo'=>'otro' 		, 
												'descripcion'=>'Adicionales' , 
												'clase'=>NULL ) ;
												
		$this->lista_campos_lectura[]=array( 	'nombre'=>'Cantidad_Docentes_Capacitados' 			, 
												'tipo'=>'otro' 		, 
												'descripcion'=>'Docentes' , 
												'clase'=>NULL ) ;
												
		$this->lista_campos_lectura[]=array( 	'nombre'=>'Cantidad_de_Escuelas' 			, 
												'tipo'=>'otro' 		, 
												'descripcion'=>'Escuelas' , 
												'clase'=>NULL ) ;
												
		$this->lista_campos_lectura[]=array( 	'nombre'=>'Anio' 			, 
												'tipo'=>'otro' 		, 
												'descripcion'=>'Año' , 
												'clase'=>NULL ) ;
												
		$this->lista_campos_lectura[]=array( 	'nombre'=>'Mes' 			, 
												'tipo'=>'otro' 		, 
												'descripcion'=>'Mes' , 
												'clase'=>NULL ) ;
												
		$this->lista_campos_lectura[]=array( 	'nombre'=>'Gestion' 			, 
												'tipo'=>'otro' 		, 
												'descripcion'=>'Gestión' , 
												'clase'=>NULL ) ;
												
		$this->lista_campos_lectura[]=array( 	'nombre'=>'Edicion_Nro' 			, 
												'tipo'=>'otro' 		, 
												'descripcion'=>'Edición' , 
												'clase'=>NULL ) ;
												
		$this->lista_campos_lectura[]=array( 	'nombre'=>'Programa_Nro' 			, 
												'tipo'=>'otro' 		, 
												'descripcion'=>'Programa' , 
												'clase'=>NULL ) ;
		//
	}
	protected function Carga_Sql_Lista()
	{
		$this->strsql = "
							SELECT `Cantidad_de_Capas` ,
									`Cantidad_Alumnos_Capacitados` ,
									 `Cantidad_Adicional_Capacitados` ,
									  `Cantidad_Docentes_Capacitados` ,
									  `Cantidad_de_Escuelas` ,
									  `Anio` , 
									  `Mes` , 
									  `Gestion` , 
									  `Edicion_Nro` , 
									  `Programa_Nro`  
								FROM `vista_total_de_capacitaciones` ORDER BY
								Anio DESC ,`Edicion_Nro` DESC , Mes DESC , Programa_Nro " ;
	}
	protected function crear(){

			$this->strsql = " CREATE VIEW vista_total_de_capacitaciones as 
								
								SELECT 	`Cantidad_de_Capas`,
										`Cantidad_Alumnos_Capacitados`,
										`Cantidad_Adicional_Capacitados`,
										`Cantidad_Docentes_Capacitados`,
										`Cantidad_de_Escuelas` ,
										vista_cantidad_capacitaciones.`Anio`,
										vista_cantidad_capacitaciones.`Mes`,
										vista_cantidad_capacitaciones.`Gestion`,
										vista_cantidad_capacitaciones.`Edicion_Nro`,
										vista_cantidad_capacitaciones.`Programa_Nro`
								FROM `vista_cantidad_capacitaciones` 
								LEFT JOIN vista_cantidad_escuelas_capacitadas
								ON 
								vista_cantidad_capacitaciones.Edicion_Nro = vista_cantidad_escuelas_capacitadas.Edicion_Nro and
								vista_cantidad_capacitaciones.Programa_Nro = vista_cantidad_escuelas_capacitadas.Programa_Nro and
								vista_cantidad_capacitaciones.Gestion = vista_cantidad_escuelas_capacitadas.Gestion_Tipo and
								vista_cantidad_capacitaciones.Anio = vista_cantidad_escuelas_capacitadas.Anio and
								vista_cantidad_capacitaciones.Mes = vista_cantidad_escuelas_capacitadas.Mes
								ORDER BY 
									vista_cantidad_capacitaciones.Anio DESC,
									vista_cantidad_capacitaciones.Edicion_Nro DESC,
									vista_cantidad_capacitaciones.Mes DESC,
									vista_cantidad_capacitaciones.Programa_Nro,
									vista_cantidad_capacitaciones.Gestion
								" ;
								
								
			
							}
}
?>  
