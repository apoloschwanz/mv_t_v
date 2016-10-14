<?php
class Programa extends entidadi {
		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_prgma_' ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Programa" ;
			$this->nombre_fisico_tabla = "programa" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					// by DZ 2015-08-14 - agregado lista de datos
			$this->cuenta = 15 ;																				// by DZ 2015-08-14 - agregado lista de datos			
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'other' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'Programa_Nro'			, 'tipo'=>'pk'	, 'descripcion'=>'Programa Nro' 						, 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Programa'			, 'tipo'=>'text'	, 'descripcion'=>'Programa' 						, 'clase'=>NULL ) ;
			//
			//
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'Programa_Nro'			, 'tipo'=>'pk'	, 'descripcion'=>'Programa Nro' 						, 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Programa'			, 'tipo'=>'text'	, 'descripcion'=>'Programa' 						, 'clase'=>NULL ) ;
			//
			// Acciones Extra para texto_mostrar_abm
			//$this->acciones[] = array( 'nombre'=>'okAsignarDte' , 'texto'=>'Asignar Docente' ) ;
			//$this->acciones[] = array( 'nombre'=>'okAsignarCordo' , 'texto'=>'Asignar Coordinador' ) ;
		}

	protected function crear_tabla()
	{
		$this->strsql = ' CREATE TABLE programa ( Programa_Nro INT PRIMARY KEY ,
													Programa VARCHAR(35)  ) ' ;
		$this->strsql = " INSERT INTO programa ( Programa_Nro ,	Programa )
								VALUES ( 1 , 'Mi voto mi elección' ) , ( 2 , 'Participacion Ciudadana' ) " ;
	}
	protected function Carga_Sql_Lista ()
	{
		$this->strsql = ' SELECT Programa_Nro, Programa FROM ' . $this->nombre_fisico_tabla  ;
	}
	protected function Carga_Sql_Lectura()
	{
		$this->strsql = ' SELECT Programa_Nro , Programa From ' . $this->nombre_fisico_tabla . ' where Programa_Nro = '. $this->id ;
	}
}
?>
