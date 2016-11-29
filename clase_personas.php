<?php

require_once 'clase_cargo.php' ;
require_once 'clase_organismo.php' ;
require_once 'clase_entidadj.php' ;


class persona extends entidadj {
	/*
	 * SELECT Persona_Id
	 * `Apellido y Nombre`
	 * Cuit_Prefijo
	 * DNI
	 * Cuit_Sufijo
	 * Cargo_Id
	 * Organismo_Id
	 * Sector
	 * Oficina
	 * Fecha_de_Nacimiento
	 * Observaciones
	 *  FROM `personas` WHERE 1
	 * 
	 * 
	 * */
	
 		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->clave_manual_activar() ; // La clave de la entidad se ingresa manualment
			$this->lista_campos_lista=array();
			
			$this->lista_campos_lista[]=new campo_entidad( 'Persona_Id' 			, 'pk' 		, '#' , NULL ,true) ;
			$this->lista_campos_lista[0]->pone_busqueda() ;
			$this->lista_campos_lista[]=new campo_entidad( '`Apellido y Nombre`' 	, 'text' 	, 'Nombre'  ) ;
			$this->lista_campos_lista[1]->pone_busqueda() ;
			$this->lista_campos_lista[]=new campo_entidad( 'DNI' 	, 'number' 	, 'Documento'  ) ;
			$this->lista_campos_lista[2]->pone_busqueda() ;
			$this->lista_campos_lista[]=new campo_entidad( 'Sector' 	, 'text' 	, 'Sector'  ) ;
			$this->lista_campos_lista[3]->pone_busqueda() ;
			$this->lista_campos_lista[]=new campo_entidad( 'Fecha_de_Nacimiento' 	, 'date' 	, 'F. de Nac.'  ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=new campo_entidad( 'Persona_Id' 			, 'pk' 		, 'Codigo Estab.'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Apellido y Nombre' 	, 'text' 	, 'Establecimiento'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Cuit_Prefijo' 	, 'text' 	, 'Direccion'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'DNI' 	, 'text' 	, 'Teléfono'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Cuit_Sufijo' 	, 'fk' 	, 'Gestión'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Cargo_Id' 	, 'fk' 	, 'Tipo' , new cargo() ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Organismo_Id' 	, 'text' 	, 'Dependencia Funcional' , new organismo()   ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Sector' 	, 'text' 	, 'Ofertas'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Oficina' 	, 'textarea' 	, 'Observaciones'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Fecha_de_Nacimiento' 	, 'textarea' 	, 'Observaciones'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Observaciones' 	, 'textarea' 	, 'Observaciones'  ) ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Personas" ;
			$this->nombre_fisico_tabla = "personas" ;																		
			//
			//
		}	

}

?>
