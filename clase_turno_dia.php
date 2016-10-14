<?php
	class Turno_dia extends entidadi {
		
		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_turnodia_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'TurnoDia_Id' 			, 
												'tipo'=>'pk' 		, 
												'descripcion'=>'#' , 
												'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Dia_Nombre' 	, 
												'tipo'=>'otro' 	, 
												'descripcion'=>'Día' , 
												'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Turno' 	, 
												'tipo'=>'otro' 	, 
												'descripcion'=>'Turno' , 
												'clase'=>NULL ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'TurnoDia_Id' 			, 
													'tipo'=>'pk' 		, 
													'descripcion'=>'#' , 
													'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Dia_Nombre' 	, 
													'tipo'=>'otro' 	, 
													'descripcion'=>'Día' , 
													'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Turno' 	, 
													'tipo'=>'otro' 	, 
													'descripcion'=>'Turno' , 
													'clase'=>NULL ) ;
			
			
													
						
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Turnos por Dia" ;
			$this->nombre_fisico_tabla = "turno_dia" ;
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
			$this->botones_extra_edicion = NULL ;
			
		}

	protected function Carga_Sql_Lectura()
	{
	$this->strsql = " TurnoDia_Id, Dia_Nombre, turnos.Turno FROM turno_dia 
						LEFT JOIN dias_semana 
                        ON turno_dia.Dia_Nro = dias_semana.Dia_Nro
                        LEFT JOIN turnos
                        ON turno_dia.Turno_ID = turnos.Turno_ID
                        WHERE TurnoDia_Id = '".$this->id."'
                        ORDER by turno_dia.Dia_Nro , turnos.Turno_orden " ;
	}
	protected function Carga_Sql_Lista()
	{
	$this->strsql = "SELECT TurnoDia_Id, Dia_Nombre, turnos.Turno FROM turno_dia 
						LEFT JOIN dias_semana 
                        ON turno_dia.Dia_Nro = dias_semana.Dia_Nro
                        LEFT JOIN turnos
                        ON turno_dia.Turno_ID = turnos.Turno_ID
                        WHERE 1
                        ORDER by turno_dia.Dia_Nro , turnos.Turno_orden" ;

	
	}
		
		
		
		
	private function crear_tabla()
	{
		$this->strsql = " CREATE TABLE turno_dia 
							( TurnoDia_Id int NOT NULL PRIMARY KEY AUTO_INCREMENT ,
								Turno_ID varchar(1) , 
								Dia_Nro tinyint )
							; 
						INSERT INTO turno_dia
							( Turno_ID, Dia_Nro )
							SELECT Turno_ID, Dia_Nro FROM dias_semana , turnos WHERE Dia_Nro > 1 and Dia_Nro < 7 and Turno_ID in ('M','T','N') order by Dia_Nro, Turno_orden
							;
							";
	}
	
}
?>
