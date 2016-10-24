<?php

require_once 'clase_entidadj.php' ;
require_once 'clase_gestion_tipo.php' ;

class escuelas_general extends entidadj {
	
	
 		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_estab_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			
			$this->lista_campos_lista[]=new campo_entidad( 'CUE' 			, 'pk' 		, 'Codigo Estab.' , NULL ,true) ;
			$this->lista_campos_lista[]=new campo_entidad( 'NOMBRE' 	, 'text' 	, 'Establecimiento'  ) ;
			$this->lista_campos_lista[1]->pone_busqueda() ;
			$this->lista_campos_lista[]=new campo_entidad( 'DOMICILIO' 	, 'text' 	, 'Direccion'  ) ;
			$this->lista_campos_lista[2]->pone_busqueda() ;
			$this->lista_campos_lista[]=new campo_entidad( 'TELEFONO' 	, 'text' 	, 'Teléfono'  ) ;
			$this->lista_campos_lista[]=new campo_entidad( 'Gestion_Tipo' 	, 'text' 	, 'Gestión'  ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=new campo_entidad( 'CUE' 			, 'pk' 		, 'Codigo Estab.'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'NOMBRE' 	, 'text' 	, 'Establecimiento'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'DOMICILIO' 	, 'text' 	, 'Direccion'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'TELEFONO' 	, 'text' 	, 'Teléfono'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Gestion_Tipo' 	, 'fk' 	, 'Gestión' , new gestion_tipo() ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'DEPENDENCIA_FUNCIONAL' 	, 'text' 	, 'Dependencia Funcional'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Escuela_Ofertas' 	, 'text' 	, 'Ofertas'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Escuela_Observaciones' 	, 'textarea' 	, 'Observaciones'  ) ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Establecimientos" ;
			$this->nombre_fisico_tabla = "escuelas_general" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					// by DZ 2015-08-14 - agregado lista de datos
			$this->cuenta = 15 ;																				// by DZ 2015-08-14 - agregado lista de datos		
			//
			// Acciones Extra para texto_mostrar_abm
			//$this->acciones = array( 'nombre'=>'okAsignarDte' , 'texto'=>'AsignarDte' ) ;
			//
			// Botones extra edicion
			//$this->botones_extra_edicion[] = array( 'name'=> '_Rel1' ,
			//										'value'=>'Salir' ,
			//										'link'=>'salir.php' ) ; // '<input type="submit" name="'.$this->prefijo_campo.'_Rel1" value="Salir" autofocus>
			//
			// Filtros
			$this->con_filtro_fecha = false;
			//
			//
		}	




}

?>
