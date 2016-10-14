<?php

class Turnos_por_dia_del_docente extends relacionj {

		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Lado Uno de la Relación
			$this->obj_lado_uno = new Docente() ;
			$this->nombre_id_lado_uno = 'Docente_Nro' ;
			//
			// Lado Muchos de la Relación
			$this->obj_lado_muchos = new Turno_dia() ;
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_turnos_p_dia_del_dte_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'	=>'TurnoDia_Id' , 
												 'tipo'		=>'pk' 	, 
												 'descripcion'=>'#' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'	=>'Dia_Nombre' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Día' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'	=>'Turno' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Turno' , 
												 'clase'=>NULL ) ;

			
			
			//$this->lista_campos_lista[]=array( 'nombre'=>'Nombre' 	, 'tipo'=>'text' 	, 'descripcion'=>'Docente' , 'clase'=>NULL ) ;
			//$this->lista_campos_lista[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>new Entidadi() ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'	=>'TurnoDia_Id' , 
												 'tipo'		=>'pk' 	, 
												 'descripcion'=>'#' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'	=>'Dia_Nombre' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Día' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'	=>'Turno' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Turno' , 
												 'clase'=>NULL ) ;
			
			//
			// Lista de Campos
			//$this->lista_campos_descrip=array() ;
			//$this->lista_campos_tipo=array() ;
			$this->lista_campos_nombre=array() ;
			//$this->lista_campos_descrip[]='Comuna #' ;
			//$this->lista_campos_descrip[]='Comuna' ;
			//$this->lista_campos_tipo[]='pk' ; // 'pk' 'fk' 'other' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password' 
			//$this->lista_campos_tipo[]='otro';
			//$this->lista_campos_nombre[]='Comuna_Nro' ;
			//$this->lista_campos_nombre[]='Comuna' ;
			
			foreach ( $this->lista_campos_lista as $campo ) 
			{
				$this->lista_campos_nombre[]=$campo['nombre'] ;
			}
			
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Turnos del Docente" ;
			$this->nombre_fisico_tabla = "turnos_por_dia_del_docente" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					
			$this->cuenta = 15 ;																						
		}	
			protected function Carga_Sql_Lectura()
		{
		$this->strsql = "SELECT turnos_por_dia_del_docente.TurnoDia_Id , dias_semana.Dia_Nombre , turnos.Turno
						FROM `turnos_por_dia_del_docente` 
						LEFT JOIN turno_dia
                        ON turnos_por_dia_del_docente.TurnoDia_Id = turno_dia.TurnoDia_Id
                        LEFT JOIN turnos
                        ON turno_dia.Turno_ID = turnos.Turno_ID
                        LEFT JOIN dias_semana
                        ON turno_dia.Dia_Nro = dias_semana.Dia_Nro
                        WHERE TurnoDia_Id = '".$this->id."' and Docente_Nro = '".$this->id_lado_uno."'
                        order by 
							turnos_por_dia_del_docente.Docente_Nro , 
							turnos_por_dia_del_docente.Dia_Nro , 
							turnos.Turno_orden " ;
		}
		protected function Carga_Sql_Lista()
		{
			//
			// Lista de Registros de la relacion
			$this->strsql = "SELECT turnos_por_dia_del_docente.TurnoDia_Id , dias_semana.Dia_Nombre , turnos.Turno
						FROM `turnos_por_dia_del_docente` 
						LEFT JOIN turno_dia
                        ON turnos_por_dia_del_docente.TurnoDia_Id = turno_dia.TurnoDia_Id
                        LEFT JOIN turnos
                        ON turno_dia.Turno_ID = turnos.Turno_ID
                        LEFT JOIN dias_semana
                        ON turno_dia.Dia_Nro = dias_semana.Dia_Nro
                        WHERE Docente_Nro = '".$this->id_lado_uno."'
                        order by 
							turnos_por_dia_del_docente.Docente_Nro , 
							turnos_por_dia_del_docente.Dia_Nro , 
							turnos.Turno_orden " ;		
		}

		public function agrega_seleccion()
		{
		//
		// Validaciones
		//
		$this->error= false ;
		$this->obj_lado_uno->Leer();
		if ( $this->obj_lado_uno->existe == false )
		{ 
			$this->error = true ;
			$this->textoError = "El registro con Id: ".$this->obj_lado_uno->id." no se encuentra en la base de datos " ;
		}
		//
		// Lista Capas
		//
		$regs = $this->obj_lado_muchos->Obtener_Lista();
		//
		// Abre conexion con la base de datos
		$cn=new Conexion();
			while ($this->obj_lado_uno->existe == true and $this->obj_lado_muchos->existe == true and $reg=mysqli_fetch_array($regs,MYSQLI_NUM) )		
				{ 
					$nom_check = $this->prefijo_campo.'_Id_Selected'.$reg[0] ;
					if (  isset($_REQUEST [$nom_check] ) )
						{ 
							//
							// Inserta la seleccion
							$strsql = "INSERT INTO ".$this->nombre_fisico_tabla." 
																 (".$this->nombre_id_lado_uno.", ".$this->lista_campos_lectura[0]['nombre'].", Turno_ID, Dia_Nro ) 
									SELECT ".$this->nombre_id_lado_uno.", datos_a_insertar.".$this->lista_campos_lectura[0]['nombre']."
									, turno_dia.Turno_ID, turno_dia.Dia_Nro  FROM 
									( SELECT '".$this->id_lado_uno."' as ".$this->nombre_id_lado_uno." ,
													 '".$reg[0]."' as ".$this->lista_campos_lectura[0]['nombre']." ) AS datos_a_insertar 
										LEFT JOIN turno_dia ON datos_a_insertar.TurnoDia_Id = turno_dia.TurnoDia_Id
									WHERE datos_a_insertar." .$this->lista_campos_lectura[0]['nombre']." NOT IN ( SELECT DISTINCT ".$this->lista_campos_lectura[0]['nombre']."
									FROM ".$this->nombre_fisico_tabla." WHERE ".$this->nombre_id_lado_uno." = '".$this->id_lado_uno."' ) "	;
							$insert = $cn->conexion->query($strsql) ;
							if (! $insert )
						die("Problemas en el insert de ".$this->nombre_tabla." : ".$cn->conexion->error.$strsql );
						}				
				}
			//
			// Cierra la conexion
			$cn->cerrar();

		}


	function crear_tabla ()
	{	
		//
		// Crea la tabla turnos dia
		$this->strsql = "CREATE TABLE turno_dia 
							( TurnoDia_Id int NOT NULL PRIMARY KEY AUTO_INCREMENT ,
								Turno_ID varchar(1) , 
								Dia_Nro tinyint )
							; 
						INSERT INTO turno_dia
							( Turno_ID, Dia_Nro )
							SELECT Turno_ID, Dia_Nro FROM dias_semana , turnos WHERE Dia_Nro > 1 and Dia_Nro < 7 and Turno_ID in ('M','T','N') order by Dia_Nro, Turno_orden
							;"
							;
							
		//
		// Arregla la talba turnos_por_dia_del_docente					
		$this->strsql = " ALTER TABLE turnos_por_dia_del_docente
							DROP PRIMARY KEY ;
							
							ALTER TABLE turnos_por_dia_del_docente
							ADD TurnoDia_Id int NOT NULL ;
							
						  
							update `turnos_por_dia_del_docente` 
								INNER JOIN turno_dia 
								on turno_dia.Turno_ID = turnos_por_dia_del_docente.Turno_ID 
								and turno_dia.Dia_Nro = turnos_por_dia_del_docente.Dia_Nro
								set turnos_por_dia_del_docente.TurnoDia_Id = turno_dia.TurnoDia_Id
							;
							ALTER TABLE turnos_por_dia_del_docente
						   ADD PRIMARY KEY (TurnoDia_ID, Docente_Nro) ;
						   
						   
						   ALTER TABLE turnos_por_dia_del_docente
							DROP FOREIGN KEY fk_PerOrders ;
						   
						   ALTER TABLE turnos_por_dia_del_docente
						   ADD FOREIGN KEY (TurnoDia_ID) REFERENCES Persons(TurnoDia_ID);
							
						" ;
	}
}
?>
