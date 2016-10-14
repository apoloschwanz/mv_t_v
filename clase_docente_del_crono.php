<?php

class Docente_del_crono extends relacionj {

		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Lado Uno de la Relación
			$this->obj_lado_uno = new Crono() ;
			$this->nombre_id_lado_uno = 'Crono_Id' ;
			//
			// Lado Muchos de la Relación
			$this->obj_lado_muchos = new Docente_para_asignar() ;
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_dtes_del_crono_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'Docente_Nro' 			, 'tipo'=>'pk' 		, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			//$this->lista_campos_lista[]=array( 'nombre'=>'Nombre' 	, 'tipo'=>'text' 	, 'descripcion'=>'Docente' , 'clase'=>NULL ) ;
			//$this->lista_campos_lista[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>new Entidadi() ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'id' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Identificador' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Docente' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'fk' 	, 'descripcion'=>'Estado' , 'clase'=>new Estado_Capacitaciones() ) ;
						$this->lista_campos_lectura[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'otro' 	, 'descripcion'=>'Origen' , 'clase'=>NULL ) ;

			//
			// Lista de Campos
			$this->lista_campos_descrip=array() ;
			$this->lista_campos_tipo=array() ;
			$this->lista_campos_nombre=array() ;
			$this->lista_campos_descrip[]='Docente #' ;
			$this->lista_campos_descrip[]='Docente' ;
			$this->lista_campos_descrip[]='Estado' ;
			$this->lista_campos_descrip[]='Origen';
			$this->lista_campos_tipo[]='pk' ; // 'pk' 'fk' 'other' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password' 
			$this->lista_campos_tipo[]='text';
			$this->lista_campos_nombre[]='Docente_Nro' ;
			$this->lista_campos_nombre[]='Nombre' ;
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Docentes de la Capacitación" ;
			$this->nombre_fisico_tabla = "docentes_de_la_capacitacion" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					
			$this->cuenta = 15 ;			
			//
			// Boton Modificar
			$this->boton_modifica_relacion = true ;																			
		}	
			protected function Carga_Sql_Lectura()
		{
		$this->strsql = "SELECT docentes_de_la_capacitacion.Docente_Nro ,
														`Apellido y Nombre` as Nombre 
											FROM `docentes_de_la_capacitacion` 
											LEFT JOIN docente ON docentes_de_la_capacitacion.Docente_Nro = docente.Docente_Nro
											LEFT JOIN personas ON docente.Persona_Id = personas.Persona_Id
											WHERE docentes_de_la_capacitacion.Docente_Nro = '".$this->id."' and Crono_Id = '".$this->id_lado_uno."' " ;
		}
		protected function Carga_Sql_Lista()
		{
		$this->strsql = "SELECT docentes_de_la_capacitacion.Docente_Nro , 
														`Apellido y Nombre` as Nombre , 
														Estado_Asignacion , 
														docentes_de_la_capacitacion.Control
														
											FROM `docentes_de_la_capacitacion` 
											LEFT JOIN docente ON docentes_de_la_capacitacion.Docente_Nro = docente.Docente_Nro
											LEFT JOIN personas ON docente.Persona_Id = personas.Persona_Id
											WHERE Crono_Id = '".$this->id_lado_uno."' " ;		
		}

		public function texto_Mostrar_Seleccion ()
			{

				//
				// Variables
				//
				$txt = '' ;
				$this->error= false ;
				$this->obj_lado_uno->Leer();
				if ( $this->obj_lado_uno->existe == false )
				{ 
					$this->error = true ;
					$this->textoError = "El registro con Id: ".$this->obj_lado_uno->id." no se encuentra en la base de datos " ;
				}
				//
				// Abre tabla
				$txt = $txt.'<table>' ;
				if ( $this->error == true )
					{
					$txt=$txt.'<tr><td> '.$this->textoError.'</td></tr>' ; 
					}
				else
					{
						//$txt=$txt.'<tr>' ;
						//$txt=$txt.'<td> </td>';
						$cntcols = 1 ;
						//for($i=1;$i<count($this->lista_campos_descrip);$i++)
						//	{
						//		$txt=$txt.'<td>';
						//    $txt=$txt.$this->lista_campos_descrip[$i];
						//    $txt=$txt.'</td>';
						//	}
						//$txt=$txt.'</tr>';
						$registros = $this->obj_lado_muchos->Obtener_Lista_x_Crono($this->obj_lado_uno->id() );
					}
				$Grupo = ' ' ;
				while ($this->obj_lado_muchos->existe == true and $reg=mysqli_fetch_array($registros,MYSQLI_NUM) )
				{
					if ( $Grupo != $reg[1] )
					{
						$Grupo = $reg[1] ; 
						$txt=$txt.'<tr><td colspan="2" >'.$Grupo.'</td></tr>' ;
					}
					$txt=$txt.'<tr>';
					$txt=$txt.'<td>';
		    		$txt=$txt.'<input type="checkbox" name="'.$this->prefijo_campo.'_Id_Selected'.$reg[0].'">';
		    		$txt=$txt.'</td>';
		    		for($f=2;$f<count($reg)-2;$f++)
							{
								$txt=$txt.'<td>';
				        $txt=$txt.$reg[$f];
				        $txt=$txt.'</td>';
							}
						$txt=$txt.'</tr>';
				}
					// Fin While 
					//
					if ( $this->error == false )
						{
						$txt=$txt.'<tr>';
						$txt=$txt.'<td colspan="'.$cntcols.'">';
						$txt=$txt.'<input type="submit" value="Seleccionar" name="'.$this->prefijo_campo.'_okSelected">';
						$txt=$txt.'</td>' ;
						$txt=$txt.'</tr>';	
						}
					// Cierra la tabla
					$txt = $txt.'</table>' ;
					/* liberar el conjunto de resultados */
					if ( $this->obj_lado_muchos->existe == true ) {
		 				$registros->close(); }
					return $txt ;


			} 
			// Fin Function Mostrar Seleccion

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
		$regs = $this->obj_lado_muchos->Obtener_Lista_x_Crono($this->obj_lado_uno->id() );
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
																 (".$this->nombre_id_lado_uno.", ".$this->lista_campos_nombre[0]." , Estado_Asignacion , Control  ) 
									SELECT ".$this->nombre_id_lado_uno.", ".$this->lista_campos_nombre[0]."
													, '".$reg[3]."' , '".$reg[4]."'  
									FROM 
									( SELECT '".$this->id_lado_uno."' as ".$this->nombre_id_lado_uno." ,
													 '".$reg[0]."' as ".$this->lista_campos_nombre[0]." ) AS datos_a_insertar 
									WHERE " .$this->lista_campos_nombre[0]." NOT IN ( SELECT DISTINCT ".$this->lista_campos_nombre[0]."
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

			public function texto_actualizar_detalle ()
			{	
				$txt = '' ;
				$this->error= false ;
				$cpo = new Campo();
				//
				// Verifica que exista el objeto del lado uno de la relacion
				$this->obj_lado_uno->Leer();
				if ( $this->obj_lado_uno->existe == false )
				{ 
					$this->error = true ;
					$this->textoError = "El registro con Id ".$this->obj_lado_uno->id." no se encuentra en la base de datos " ;
				}
				//
				// Lee Lista
				if ( $this->error == false )
				{
					//
					// Encabezado de la lista
					$txt=$txt.'<table>';
					$txt=$txt.'<tr>' ;
					$txt=$txt.'<td> </td>';
					$cntcols = count($this->lista_campos_lectura)+2 ;
					for($i=1;$i<count($this->lista_campos_lectura);$i++)
						{
							$txt=$txt.'<td>';
				      // 2016_02_12 by DZ $txt=$txt.$this->lista_campos_descrip[$i];
				      $txt=$txt.$this->lista_campos_lectura[$i]['descripcion'];
				      $txt=$txt.'</td>';
						}
					$txt=$txt.'</tr>';
					//
					// Lee detalle
					$this->leer_lista();
					while ($this->existe == true and $reg=mysqli_fetch_array($this->registros,MYSQLI_NUM) )
					{
				    	$txt=$txt.'<tr>';
				    	//
				    	// Casilla de seleccion
						$txt=$txt.'<td>';
				  		$txt=$txt.'<input type="checkbox" name="'.$this->prefijo_campo.'_Id'.$reg[0].'">';
				  		$txt=$txt.'</td>';
				  		//
				  		// Campos
				  		for($f=1;$f<count($reg);$f++)
						{
							$cpo->pone_valor( $reg[$f] ) ;
							if( $this->lista_campos_lectura[$f]['tipo'] == 'pk' or $this->lista_campos_lectura[$f]['tipo'] == 'otro' )
								{ 
									$cpo->pone_tipo( 'text' ) ;
									$txt = $txt.$cpo->txtMostrarEtiqueta() ;
								}
							elseif( $this->lista_campos_lectura[$f]['tipo'] == 'fk' )
								{
									//
									// Lista de fk
									//
									$cpo->pone_tipo( 'select' ) ;
									$lista_fk = $this->lista_campos_lectura[$f]['clase']->Obtener_Lista() ;
									$cpo->pone_lista( $lista_fk ) ;
									$cpo->pone_posicion_codigo( 0 ) ;
									$cpo->pone_posicion_descrip( 1 ) ;
									$cpo->pone_mostar_nulo_en_si() ;
									$txt = $txt.$cpo->txtMostrarParaVer() ;
								}
							else
								{ 
									$cpo->pone_tipo( $this->lista_campos_lectura[$f]['tipo'] ) ;
									$txt = $txt.$cpo->txtMostrarParaVer() ;
								}
							//$txt=$txt.'<td>';
							//$txt=$txt.$reg[$f];
							//$txt=$txt.'</td>';
						}
						$txt=$txt.'<td>' ;
						//$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.'okVer=1">Ver</a>' ;
						//$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.'okModificar=1">Modificar</a>' ;
						//$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.'okConfirmar=1">Confirmar</a>' ;
						$txt=$txt.'</td>' ;
						$txt=$txt.'</tr>';
					}
					if ( $this->existe == true )
						{ 
							$txt=$txt.'<tr><td colspan="'.$cntcols.'">';
							$txt=$txt.'<input type="submit" value="Agregar" name="'.$this->prefijo_campo.'_okAgregar">';
							$txt=$txt.'<input type="submit" value="Borrar" name="'.$this->prefijo_campo.'_okBorrar">';
							if ( $this->boton_modifica_relacion )
								$txt=$txt.'<input type="submit" value="Modificar Estado" name="'.$this->prefijo_campo.'_okModificar">';
							$txt=$txt.'</td></tr>'; 
						}
					else
						{
							$txt=$txt.'<tr><td colspan="'.$cntcols.'">';
							$txt=$txt.'<input type="submit" value="Agregar" name="'.$this->prefijo_campo.'_okAgregar">';
							$txt=$txt.'</td></tr>'; 
						}
					$txt=$txt.'</table>';
					}
					else
					{
						$txt=$txt.'<tr><td> '.$this->textoError.'</td></tr>' ; 
					}
					return $txt;
			}

}
?>
