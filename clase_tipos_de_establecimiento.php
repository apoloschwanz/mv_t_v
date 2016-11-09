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
				
				alter table escuelas_general add FOREIGN KEY (Tipo_Estab_Nro) REFERENCES tipos_de_establecimiento(Tipo_Estab_Nro)
				
				update escuelas_general set Tipo_Estab_Nro=(select Tipo_Estab_Nro from tipos_de_establecimiento where tipos_de_establecimiento.Tipo_Estab = escuelas_general.TIPO )
				
				
				select count(*) as cantidad, escuelas_general.tipo, escuelas_general.Tipo_Estab_Nro , tipos_de_establecimiento.tipo_estab from escuelas_general
				inner join tipos_de_establecimiento
					on escuelas_general.Tipo_Estab_Nro = tipos_de_establecimiento.Tipo_Estab_Nro
				group by escuelas_general.tipo, escuelas_general.Tipo_Estab_Nro
						" ;
		
	}
	protected function asignacion_tipos()
	{
		$this->strsql = "
						-- 14 -- Escuelas de Nivel Medio públicas
						-- 15 -- Escuelas de Nivel Medio privadas
						-- 16 -- Centros Educativos Nivel Secundario (adultos)
						-- 17 -- Escuelas de Educación Especial (Nivel Medio y Formación Laboral)
						--  2 -- Centros Educativos Nivel Primario (adultos)
						--  8 -- Escuelas Primarias de Adultos
						-- 18 -- Programa Adolescencia
						--  4 Centros de Educación No Formal
			
			
			update escuelas_general set escuelas_general.Tipo_Estab_Nro = NULL
			
			--
			--  14 -- Escuelas de Nivel Medio públicas
			
			SELECT * FROM `escuelas_general` WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.NOMBRE like '%media%'
			and escuelas_general.Tipo_Estab_Nro is null
			
			UPDATE `escuelas_general` 
			SET escuelas_general.Tipo_Estab_Nro = 14
			WHERE escuelas_general.NOMBRE like '%media%'
			and escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.Tipo_Estab_Nro is null
			
			SELECT * FROM `escuelas_general` WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.DEPENDENCIA_FUNCIONAL like '%media%'
			and escuelas_general.Tipo_Estab_Nro is null
			
			UPDATE `escuelas_general` 
			SET escuelas_general.Tipo_Estab_Nro = 14
			WHERE
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.DEPENDENCIA_FUNCIONAL like '%media%'
			and escuelas_general.Tipo_Estab_Nro is null
			
			--
			--  16 -- Centros Educativos Nivel Secundario (adultos)
			
			SELECT * FROM `escuelas_general` WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.NOMBRE like '%cens%'
			and escuelas_general.Tipo_Estab_Nro is null
			
			UPDATE `escuelas_general` 
			SET escuelas_general.Tipo_Estab_Nro = 16
			WHERE
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.NOMBRE like '%cens%'
			and escuelas_general.Tipo_Estab_Nro is null
			
			--
			--  17 -- Escuelas de Educación Especial (Nivel Medio y Formación Laboral)
			
			SELECT * FROM `escuelas_general` WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.NOMBRE like '%especia%'
			and escuelas_general.Tipo_Estab_Nro is null
						
			UPDATE `escuelas_general` 
			SET escuelas_general.Tipo_Estab_Nro = 17
			 WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.NOMBRE like '%especia%'
			and escuelas_general.Tipo_Estab_Nro is null
						
			--
			--   2 -- Centros Educativos Nivel Primario (adultos)
			
			SELECT * FROM `escuelas_general` WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.NOMBRE like '%cenp%'
			and escuelas_general.Tipo_Estab_Nro is null
			
			
			UPDATE `escuelas_general` 
			SET escuelas_general.Tipo_Estab_Nro = 2
			 WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.NOMBRE like '%cenp%'
			and escuelas_general.Tipo_Estab_Nro is null
						
			SELECT * FROM `escuelas_general` WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.TIPO like '%cenp%'
			and escuelas_general.Tipo_Estab_Nro is null
			
			UPDATE `escuelas_general` 
			SET escuelas_general.Tipo_Estab_Nro = 2
			 WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.TIPO like '%cenp%'
			and escuelas_general.Tipo_Estab_Nro is null
			
			
			--
			--  8 -- Escuelas Primarias de Adultos	
			
			SELECT * FROM `escuelas_general` WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.NOMBRE like '%adul%'	
			and escuelas_general.Tipo_Estab_Nro is null	
			
			UPDATE `escuelas_general` 
			SET escuelas_general.Tipo_Estab_Nro = 8
			 WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.NOMBRE like '%adul%'	
			and escuelas_general.Tipo_Estab_Nro is null	
			
			
			SELECT * FROM `escuelas_general` WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.TIPO like '%primaria adultos%'	
			and escuelas_general.Tipo_Estab_Nro is null
			
			UPDATE `escuelas_general` 
			SET escuelas_general.Tipo_Estab_Nro = 8
			 WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.TIPO like '%primaria adultos%'	
			and escuelas_general.Tipo_Estab_Nro is null
			
			--
			--  18 -- Programa Adolescencia
			
			
			SELECT * FROM `escuelas_general` WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.NOMBRE like '%adolesc%'	
			and escuelas_general.Tipo_Estab_Nro is null	
			
			UPDATE `escuelas_general` 
			SET escuelas_general.Tipo_Estab_Nro = 18
			 WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.NOMBRE like '%adolesc%'	
			and escuelas_general.Tipo_Estab_Nro is null
			
			--
			--   4 Centros de Educación No Formal
			
			SELECT * FROM `escuelas_general` WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.TIPO like '%no formal%'	
			and escuelas_general.Tipo_Estab_Nro is null	
			
			UPDATE `escuelas_general` 
			SET escuelas_general.Tipo_Estab_Nro = 4
			 WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.TIPO like '%no formal%'	
			and escuelas_general.Tipo_Estab_Nro is null	
			
			SELECT * FROM `escuelas_general` WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.TIPO like '%ENF%'	
			and escuelas_general.Tipo_Estab_Nro is null
			
			UPDATE `escuelas_general` 
			SET escuelas_general.Tipo_Estab_Nro = 4
			 WHERE 
			escuelas_general.Gestion_Tipo = 'pública'
			and escuelas_general.TIPO like '%ENF%'	
			and escuelas_general.Tipo_Estab_Nro is null
			
						" ;
	
	}
	
}

?>
