<?php

class Detalle_Observaciones_Encuesta extends relacion {

			protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Lado Uno de la Relación
			$this->obj_lado_uno = new Encuesta() ;
			$this->nombre_id_lado_uno = 'Nro_Encuesta' ;
			//
			// Lado Muchos de la Relación
			$this->obj_lado_muchos = new Observaciones_Encuesta() ;
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_detobsenc_' ;
			//
			// Lista de Campos
			$this->lista_campos_descrip=array() ;
			$this->lista_campos_tipo=array() ;
			$this->lista_campos_nombre=array() ;
			$this->lista_campos_descrip[]='Observacion_Nro' ;
			$this->lista_campos_descrip[]='Sistematización de Observaciones' ;
			$this->lista_campos_tipo[]='pk' ; // 'pk' 'fk' 'other' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password' 
			$this->lista_campos_tipo[]='other' ; 
			$this->lista_campos_nombre[]='Observacion_Nro' ;
			$this->lista_campos_nombre[]='`Observación`' ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "detalle_observaciones_encuestas" ;
			$this->nombre_fisico_tabla = "detalle_observaciones_encuestas" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					// by DZ 2015-08-14 - agregado lista de datos
			$this->cuenta = 15 ;																				// by DZ 2015-08-14 - agregado lista de datos			
			//
			// Borrado con link
			$this->borrar_sin_seleccion = true ;
		}	


	protected function Carga_Sql_Lista()
	{
	$this->strsql = "SELECT detalle_observaciones_encuestas.Observacion_Nro, observaciones_encuesta.`Observación` FROM detalle_observaciones_encuestas 
									LEFT JOIN observaciones_encuesta
									ON detalle_observaciones_encuestas.Observacion_Nro = observaciones_encuesta.Observacion_Nro
									 WHERE Nro_Encuesta = '".$this->id_lado_uno."'  
									ORDER BY observaciones_encuesta.`Observación`";		
	}
}

?>
