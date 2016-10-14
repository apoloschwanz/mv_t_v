<?php

class Capacitaciones_Asignadas_Totales extends entidadi {
		protected $edicion_actual ;
		public function __construct()
		{
			parent::__construct() ;
			$edactual = new Edicion_Actual() ;
			if ( $edactual->existe )
				{
				$this->edicion_actual = $edactual->Edicion_Actual_Nro ;
				}
				else 
				{
				die( 'Problemas al buscar edicion actual') ;
				}
			}
		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_capas_asignadas_tot_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'Crono_Id' , 'tipo'=>'pk' 	, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Docente' , 'tipo'=>'otro' 	, 'descripcion'=>'Docente' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Estado_Asignacion' , 'tipo'=>'otro' 	, 'descripcion'=>'Estado de la Asignación' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Fecha' , 'tipo'=>'date' 	, 'descripcion'=>'Fecha' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Turno' , 'tipo'=>'text' 	, 'descripcion'=>'T' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Hora_Desde' , 'tipo'=>'time' 	, 'descripcion'=>'Desde' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Hora_Hasta' , 'tipo'=>'time' 	, 'descripcion'=>'Hasta' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Estado' , 'tipo'=>'otro' 	, 'descripcion'=>'Asignación' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Control' , 'tipo'=>'text' 	, 'descripcion'=>'Obs.' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Matricula' , 'tipo'=>'otro' 	, 'descripcion'=>'Matrícula' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'NOMBRE' , 'tipo'=>'otro' 	, 'descripcion'=>'Escuela' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'	=>'DOMICILIO' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Domicilio' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'	=>'TIPO' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Tipo' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'	=>'COMUNA' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Comuna' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'	=>'BARRIO' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Barrio' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'	=>'Programa_Nro' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Programa' , 
												 'clase'=>NULL ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'Capacitacion' , 'tipo'=>'pk' 	, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Docente' , 'tipo'=>'otro' 	, 'descripcion'=>'Docente' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Estado_Asignacion' , 'tipo'=>'otro' 	, 'descripcion'=>'Estado de la Asignación' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Fecha' , 'tipo'=>'date' 	, 'descripcion'=>'Fecha' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Turno' , 'tipo'=>'text' 	, 'descripcion'=>'T' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Hora_Desde' , 'tipo'=>'time' 	, 'descripcion'=>'Desde' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Hora_Hasta' , 'tipo'=>'time' 	, 'descripcion'=>'Hasta' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Estado' , 'tipo'=>'otro' 	, 'descripcion'=>'Asignación' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Control' , 'tipo'=>'text' 	, 'descripcion'=>'Obs.' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Matricula' , 'tipo'=>'otro' 	, 'descripcion'=>'Matrícula' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'NOMBRE' , 'tipo'=>'otro' 	, 'descripcion'=>'Escuela' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'	=>'NOMBRE' , 
												 'tipo'		=>'text' 	, 
												 'descripcion'=>'Escuela' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'	=>'TIPO' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Tipo' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'	=>'COMUNA' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Comuna' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'	=>'BARRIO' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Barrio' , 
												 'clase'=>NULL ) ;
			
			//
			// Lista de Campos
			foreach( $this->lista_campos_lista as $campo )
			{
				$this->lista_campos_descrip[]= $campo['descripcion'] ;
				$this->lista_campos_tipo[]= $campo['tipo'] ;
				$this->lista_campos_nombre[]= $campo['nombre'] ;
			}
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Asignacion de Docente" ;
			$this->nombre_fisico_tabla = "docentes_de_la_capacitacion" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					
			$this->cuenta = 15 ;			
			// Acciones Extra para texto_mostrar_abm
			$this->acciones = array() ;
																						
		}	
			protected function Carga_Sql_Lectura()
		{
			$edactual = new Edicion_Actual() ;
			if ( $edactual->existe )
				{
				$this->edicion_actual = $edactual->Edicion_Actual_Nro ;
				}
			else
				{
					$this->edicion_actual = 0 ;
				}
			$this->strsql = "SELECT docentes_de_la_capacitacion.Crono_Id , 
								docentes_de_la_capacitacion.Crono_Id as Capacitacion ,
								CAST(capacitaciones.Fecha AS DATE) AS Fecha, 
								capacitaciones.Turno_Id, 
								DATE_FORMAT( capacitaciones.Hora_Desde, '%H:%i' ) AS Hora_Desde, 
								DATE_FORMAT( capacitaciones.Hora_Hasta, '%H:%i' ) AS Hora_Hasta,  
								estados_asignacion_capas.Estado,
								docentes_de_la_capacitacion.Control ,
								capacitaciones.Matricula, 
								escuelas_general.NOMBRE ,
								escuelas_general.DOMICILIO, 
								escuelas_general.TIPO, 
								escuelas_general.COMUNA, 
								escuelas_general.BARRIO 
								FROM `docentes_de_la_capacitacion` 
								INNER JOIN capacitaciones ON docentes_de_la_capacitacion.Crono_Id = capacitaciones.Crono_Id
								LEFT JOIN escuelas_general ON capacitaciones.CUE = escuelas_general.CUE
								LEFT JOIN docente ON docentes_de_la_capacitacion.Docente_Nro = docente.Docente_Nro
								LEFT JOIN personas ON docente.Persona_Id = personas.Persona_Id
								LEFT JOIN estados_asignacion_capas ON docentes_de_la_capacitacion.Estado_Asignacion = estados_asignacion_capas.Estado_Cod
											WHERE Crono_Id = '".$this->id_lado_uno."' 
													AND capacitaciones.Edicion_Nro = '".$this->edicion_actual."' " ;
		}
		protected function Carga_Sql_Lista()
		{
			//
			// Lista de Registros de la relacion
			$edactual = new Edicion_Actual() ;
			if ( $edactual->existe )
				{
				$this->edicion_actual = $edactual->Edicion_Actual_Nro ;
				}
			else
				{
					$this->edicion_actual = 0 ;
				}
			$this->strsql = "SELECT capacitaciones.Crono_Id, ' ' as filler , capacitaciones.Crono_Id as Capacitacion , personas.`Apellido y Nombre` as Docente,
								docentes_de_la_capacitacion.Estado_Asignacion ,
								CAST(capacitaciones.Fecha AS DATE) AS Fecha, 
								capacitaciones.Turno_Id, 
								DATE_FORMAT( capacitaciones.Hora_Desde, '%H:%i' ) AS Hora_Desde, 
								DATE_FORMAT( capacitaciones.Hora_Hasta, '%H:%i' ) AS Hora_Hasta,  
								estados_asignacion_capas.Estado, 
								docentes_de_la_capacitacion.Control ,
								capacitaciones.Matricula, 
								escuelas_general.NOMBRE ,
								escuelas_general.DOMICILIO, 
								escuelas_general.TIPO, 
								escuelas_general.COMUNA, 
								escuelas_general.BARRIO ,
								capacitaciones.Programa_Nro
								FROM capacitaciones 
								LEFT JOIN  `docentes_de_la_capacitacion` ON docentes_de_la_capacitacion.Crono_Id = capacitaciones.Crono_Id
								LEFT JOIN escuelas_general ON capacitaciones.CUE = escuelas_general.CUE
								LEFT JOIN docente ON docentes_de_la_capacitacion.Docente_Nro = docente.Docente_Nro
								LEFT JOIN personas ON docente.Persona_Id = personas.Persona_Id
								LEFT JOIN estados_asignacion_capas ON estados_asignacion_capas.Estado_Cod = docentes_de_la_capacitacion.Estado_Asignacion
								WHERE capacitaciones.Edicion_Nro = '".$this->edicion_actual."'  ORDER BY Docente, Fecha, Nombre, Hora_Desde" ;		
		}

		protected function ok_salir()
		{
			//$idl1 = $this->relacion->devuelve_id_lado_uno();
			//$nomidl1 = $this->relacion->Nombre_Post_Get_Id_Lado_Uno() ;
			//$hidden = '<input type="hidden" name="'.$nomidl1.'" value="'.$idl1.'" > ' ;
			//$pagina = new Paginai($this->titulo,$hidden.'<input type="submit" value="OK" autofocus>') ;
			//$texto = 'Edicion Finalizada';
			//$pagina->insertarCuerpo($texto);
			//$pagina->graficar_c_form($this->url_anterior);
			//
			// // Vuelve al inicio
			header('Location: accueil.php');

		}

				public function mostrar_lista_abm()
		{
			$hidden = '' ;
			$pagina = new Paginai($this->nombre_tabla ,$hidden.'<input type="submit" name="okSalir" value="Salir" autofocus>') ;
			//
			// Muestra la cabecera
			$texto = $this->texto_mostrar_abm() ;
			$pagina->insertarCuerpo($texto);
			//
			// Grafica la página
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
		}		


}
?>
