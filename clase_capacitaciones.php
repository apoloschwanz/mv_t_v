<?php

class Capacitaciones extends Entidadi {

	protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_capa_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'Crono_Id' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Identificador' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Fecha' 	, 'tipo'=>'text' 	, 'descripcion'=>'Fecha' , 'clase'=>NULL ) ;
			//$this->lista_campos_lista[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>new Entidadi() ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'Crono_id' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Identificador' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Fecha' 	, 'tipo'=>'text' 	, 'descripcion'=>'Fecha' , 'clase'=>NULL ) ;
			//$this->lista_campos_lectura[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>new Entidadi() ) ;
						
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Capacitaciones" ;
			$this->nombre_fisico_tabla = "capacitaciones" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					// by DZ 2015-08-14 - agregado lista de datos
			$this->cuenta = 15 ;																				// by DZ 2015-08-14 - agregado lista de datos		
			//
			// Acciones Extra para texto_mostrar_abm
			//$this->acciones[] = array( 'nombre'=>'okAsignarDte' , 'texto'=>'AsignarDte' ) ;
			//
			// Botones extra edicion
			$this->botones_extra_edicion = array();
			//$this->botones_extra_edicion[] = array( 'name'=> '_Rel1' ,
			//										'value'=>'Salir' ,
			//										'link'=>'salir.php' ) ; // '<input type="submit" name="'.$this->prefijo_campo.'_Rel1" value="Salir" autofocus>
	
		}
		protected function crear_vista_escuelas_capacitadas_global() 
		{
			$txt = "
					DROP VIEW vista_escuelas_capacitadas_global
					CREATE VIEW vista_escuelas_capacitadas_global as
					SELECT 
						anexo.CUE, 
						escuelas_general.NOMBRE, escuelas_general.Gestion_Tipo ,
						sum( anexo.Cantidad_de_Alumnos ) as Alumnos_Capacitados, 
						sum( anexo.Cantidad_de_Alumnos_Adicional ) as Extra_Capacitados, 
						sum( anexo.Cantidad_de_Docentes ) as Docentes_Capacitados 
					FROM anexo
						left JOIN escuelas_general ON
						anexo.CUE = escuelas_general.CUE
					WHERE anexo.Anexo_Nro
						not in (
								select capacitaciones.Anexo_Nro from capacitaciones 
									where capacitaciones.Programa_Nro = 5 
									and capacitaciones.Anexo_Nro is not null
								)
						and anexo.CUE is not null
						GROUP BY anexo.CUE
					" ;
		}
}

?>
