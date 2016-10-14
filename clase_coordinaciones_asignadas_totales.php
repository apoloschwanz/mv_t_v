<?php

class Coordinaciones_Asignadas_Totales extends entidadi {
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
			$this->prefijo_campo = 'm_coordinas_asignadas_tot_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'Crono_Id' , 'tipo'=>'pk' 	, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Coordinador_Id' , 'tipo'=>'otro' 	, 'descripcion'=>'Coordinador' , 'clase'=>NULL ) ;
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
			
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'Capacitacion' , 'tipo'=>'pk' 	, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Coordinador_Id' , 'tipo'=>'otro' 	, 'descripcion'=>'Coordinador' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Fecha' , 'tipo'=>'date' 	, 'descripcion'=>'Fecha' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Turno' , 'tipo'=>'text' 	, 'descripcion'=>'T' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Hora_Desde' , 'tipo'=>'time' 	, 'descripcion'=>'Desde' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Hora_Hasta' , 'tipo'=>'time' 	, 'descripcion'=>'Hasta' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Estado' , 'tipo'=>'otro' 	, 'descripcion'=>'Asignación' , 'clase'=>NULL ) ;
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
			$this->nombre_tabla = "Asignacion de Coordinadores" ;
			$this->nombre_fisico_tabla = "coordinadores_de_la_capacitacion" ;
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
			$this->strsql = "SELECT coordinadores_de_la_capacitacion.Crono_Id , 
								coordinadores_de_la_capacitacion.Crono_Id as Capacitacion ,
								CAST(capacitaciones.Fecha AS DATE) AS Fecha, 
								capacitaciones.Turno_Id, 
								DATE_FORMAT( capacitaciones.Hora_Desde, '%H:%i' ) AS Hora_Desde, 
								DATE_FORMAT( capacitaciones.Hora_Hasta, '%H:%i' ) AS Hora_Hasta,  
								coordinadores_de_la_capacitacion.Control_Coordinador as Control ,
								capacitaciones.Matricula, 
								escuelas_general.NOMBRE ,
								escuelas_general.DOMICILIO, 
								escuelas_general.TIPO, 
								escuelas_general.COMUNA, 
								escuelas_general.BARRIO 
								FROM coordinadores_de_la_capacitacion 
								INNER JOIN capacitaciones ON coordinadores_de_la_capacitacion.Crono_Id = capacitaciones.Crono_Id
								LEFT JOIN escuelas_general ON capacitaciones.CUE = escuelas_general.CUE
								LEFT JOIN coordinadores ON coordinadores_de_la_capacitacion.Coordinador_Id = coordinadores.Coordinador_Id
								LEFT JOIN personas ON coordinadores.Persona_Id = personas.Persona_Id
											WHERE coordinadores_de_la_capacitacion.Crono_Id = '".$this->id_lado_uno."' 
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
								CAST(capacitaciones.Fecha AS DATE) AS Fecha, 
								capacitaciones.Turno_Id, 
								DATE_FORMAT( capacitaciones.Hora_Desde, '%H:%i' ) AS Hora_Desde, 
								DATE_FORMAT( capacitaciones.Hora_Hasta, '%H:%i' ) AS Hora_Hasta,  
								coordinadores_de_la_capacitacion.Control_Coordinador as Control ,
								capacitaciones.Matricula, 
								escuelas_general.NOMBRE ,
								escuelas_general.DOMICILIO, 
								escuelas_general.TIPO, 
								escuelas_general.COMUNA, 
								escuelas_general.BARRIO ,
								capacitaciones.Programa_Nro
								FROM coordinadores_de_la_capacitacion 
								INNER JOIN capacitaciones ON coordinadores_de_la_capacitacion.Crono_Id = capacitaciones.Crono_Id
								LEFT JOIN escuelas_general ON capacitaciones.CUE = escuelas_general.CUE
								LEFT JOIN coordinadores ON coordinadores_de_la_capacitacion.Coordinador_Id = coordinadores.Coordinador_Id
								LEFT JOIN personas ON coordinadores.Persona_Id = personas.Persona_Id
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
