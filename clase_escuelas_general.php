<?php

require_once 'clase_entidadj.php' ;
require_once 'clase_gestion_tipo.php' ;
require_once 'clase_tipos_de_establecimiento.php' ;

class escuelas_general extends entidadj {
	
	
 		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->clave_manual_activar() ; // La clave de la entidad se ingresa manualment
			$this->lista_campos_lista=array();
			
			$this->lista_campos_lista[]=new campo_entidad( 'CUE' 			, 'pk' 		, 'Codigo Estab.' , NULL ,true) ;
			$this->lista_campos_lista[0]->pone_busqueda() ;
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
			$this->lista_campos_lectura[]=new campo_entidad( 'Tipo_Estab_Nro' 	, 'fk' 	, 'Tipo' , new tipos_de_establecimiento() ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'DEPENDENCIA_FUNCIONAL' 	, 'text' 	, 'Dependencia Funcional'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Escuela_Ofertas' 	, 'text' 	, 'Ofertas'  ) ;
			$this->lista_campos_lectura[]=new campo_entidad( 'Escuela_Observaciones' 	, 'textarea' 	, 'Observaciones'  ) ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Establecimientos" ;
			$this->nombre_fisico_tabla = "escuelas_general" ;																		
			//
			//
		}	


		protected function arregla_tabla()
		{
			$this->strsql = "
							select llamados.CUE from llamados left join escuelas_general on llamados.CUE = escuelas_general.CUE
where escuelas_general.CUE is null

							select infraestructura.CUE from infraestructura left join escuelas_general on infraestructura.CUE = escuelas_general.CUE
where escuelas_general.CUE is null
			
							alter table anexo add FOREIGN KEY (CUE) REFERENCES escuelas_general(CUE)
							alter table capacitaciones add FOREIGN KEY (CUE) REFERENCES escuelas_general(CUE)
							alter table infraestructura add FOREIGN KEY (CUE) REFERENCES escuelas_general(CUE)
							alter table llamados add FOREIGN KEY (CUE) REFERENCES escuelas_general(CUE)
				
			
			" ;
		}

}

?>
