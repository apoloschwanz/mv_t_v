<?php

require_once 'clase_entidadj.php' ;

class tipos_de_establecimiento extends entidadj {
	protected function Pone_Datos_Fijos_No_Heredables()
	{
		$this->nombre_fisico_tabla = 'tipos_de_establecimiento' ;
		$this->nombre_tabla = 'Tipos de Establecimiento' ;
		$this->lista_campos_lista=array();
		$this->lista_campos_lista[]=new campo_entidad( 'Tipo_Estab_Nro' 			, 'pk' 		, 'Tipo de Establecimiento Nro.' ) ;
		$this->lista_campos_lista[]=new campo_entidad( 'Tipo_Estab' 	, 'text' 	, 'Tipo de Establecimiento'  ) ;
		$this->lista_campos_lista[1]->pone_busqueda() ;
		//
		//
		$this->lista_campos_lectura=array();
		$this->lista_campos_lectura[]=new campo_entidad( 'Tipo_Estab_Nro' 			, 'pk' 		, 'Tipo de Establecimiento Nro.'  ) ;
		$this->lista_campos_lectura[]=new campo_entidad( 'Tipo_Estab' 	, 'text' 	, 'Tipo de Establecimiento'  ) ;
	}
	protected function crea_tabla()
	{
		$this->strsql = "
				create table tipos_de_establecimiento
					( Tipo_Estab_Nro INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
						Tipo_Estab VARCHAR(50) ) DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci ;
						
				select escuelas_general.TIPO, COUNT(*) from escuelas_general
				GROUP BY escuelas_general.TIPO having COUNT(*) > 5 ;
				
				insert into tipos_de_establecimiento ( Tipo_Estab )
				select escuelas_general.TIPO from escuelas_general
				where escuelas_general.TIPO is not null
				GROUP BY escuelas_general.TIPO having COUNT(*) > 5 
				
		
				alter table escuelas_general add Tipo_Estab_Nro INT ;
				
				update escuelas_general set Tipo_Estab_Nro=(select Tipo_Estab_Nro from tipos_de_establecimiento where tipos_de_establecimiento.Tipo_Estab = escuelas_general.TIPO )
				
				
				select count(*) as cantidad, escuelas_general.tipo, escuelas_general.Tipo_Estab_Nro , tipos_de_establecimiento.tipo_estab from escuelas_general
				inner join tipos_de_establecimiento
					on escuelas_general.Tipo_Estab_Nro = tipos_de_establecimiento.Tipo_Estab_Nro
				group by escuelas_general.tipo, escuelas_general.Tipo_Estab_Nro
						" ;
		
	}
	
	
}

?>
