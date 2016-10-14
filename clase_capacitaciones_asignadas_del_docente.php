<?php

class Capacitaciones_Asignadas_del_Docente extends relacionj {
		protected $edicion_actual ;
		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Lado Uno de la Relación
			$this->obj_lado_uno = new Docente_para_asignar() ;
			$this->nombre_id_lado_uno = 'Docente_Nro' ;
			//
			// Lado Muchos de la Relación
			$this->obj_lado_muchos = new Capacitaciones() ;
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_capas_asignadas_del_dte_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'Crono_Id' , 'tipo'=>'pk' 	, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Capacitacion' , 'tipo'=>'otro' 	, 'descripcion'=>'Capacitacion' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Fecha' , 'tipo'=>'date' 	, 'descripcion'=>'Fecha' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Hora_Desde' , 'tipo'=>'time' 	, 'descripcion'=>'Desde' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Hora_Hasta' , 'tipo'=>'time' 	, 'descripcion'=>'Hasta' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Estado' , 'tipo'=>'otro' 	, 'descripcion'=>'Estado' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Matricula' , 'tipo'=>'number' 	, 'descripcion'=>'Matrícula' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'NOMBRE' , 'tipo'=>'text' 	, 'descripcion'=>'Escuela' , 'clase'=>NULL ) ;
			
			
			//$this->lista_campos_lista[]=array( 'nombre'=>'Nombre' 	, 'tipo'=>'text' 	, 'descripcion'=>'Docente' , 'clase'=>NULL ) ;
			//$this->lista_campos_lista[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>new Entidadi() ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'Crono_Id' , 'tipo'=>'pk' 	, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Estado_Asignacion' , 'tipo'=>'otro' 	, 'descripcion'=>'Estado de la Asignación' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Capacitacion' , 'tipo'=>'otro' 	, 'descripcion'=>'Capacitacion' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Fecha' , 'tipo'=>'date' 	, 'descripcion'=>'Fecha' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Turno' , 'tipo'=>'text' 	, 'descripcion'=>'T' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Hora_Desde' , 'tipo'=>'time' 	, 'descripcion'=>'Desde' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Hora_Hasta' , 'tipo'=>'time' 	, 'descripcion'=>'Hasta' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Estado' , 'tipo'=>'otro' 	, 'descripcion'=>'Asignación' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Control' , 'tipo'=>'text' 	, 'descripcion'=>'Obs.' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Matricula' , 'tipo'=>'otro' 	, 'descripcion'=>'Matrícula' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'NOMBRE' , 'tipo'=>'otro' 	, 'descripcion'=>'Escuela' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'	=>'NOMBRE' , 
												 'tipo'		=>'text' 	, 
												 'descripcion'=>'Escuela' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'	=>'TIPO' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Tipo' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'	=>'COMUNA' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Comuna' , 
												 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'	=>'BARRIO' , 
												 'tipo'		=>'otro' 	, 
												 'descripcion'=>'Barrio' , 
												 'clase'=>NULL ) ;
			
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
		}	
			protected function Carga_Sql_Lectura()
		{
			$edactual = new Edicion_Actual() ;
			if ( $edactual->existe )
				{
				$this->edicion_actual = $edactual->Edicion_Actual_Nro ;
				}
			else
				{
					$this->edicion_actual = 0 ;
				}
			$this->strsql = "SELECT docentes_de_la_capacitacion.Crono_Id , 
								docentes_de_la_capacitacion.Crono_Id as Capacitacion ,
								CAST(capacitaciones.Fecha AS DATE) AS Fecha, 
								capacitaciones.Turno_Id, 
								DATE_FORMAT( capacitaciones.Hora_Desde, '%H:%i' ) AS Hora_Desde, 
								DATE_FORMAT( capacitaciones.Hora_Hasta, '%H:%i' ) AS Hora_Hasta,  
								estados_asignacion_capas.Estado,
								docentes_de_la_capacitacion.Control ,
								capacitaciones.Matricula, 
								escuelas_general.NOMBRE ,
								escuelas_general.DOMICILIO, 
								escuelas_general.TIPO, 
								escuelas_general.COMUNA, 
								escuelas_general.BARRIO 
								FROM `docentes_de_la_capacitacion` 
								INNER JOIN capacitaciones ON docentes_de_la_capacitacion.Crono_Id = capacitaciones.Crono_Id
								LEFT JOIN escuelas_general ON capacitaciones.CUE = escuelas_general.CUE
								LEFT JOIN docente ON docentes_de_la_capacitacion.Docente_Nro = docente.Docente_Nro
								LEFT JOIN personas ON docente.Persona_Id = personas.Persona_Id
								LEFT JOIN estados_asignacion_capas ON docentes_de_la_capacitacion.Estado_Asignacion = estados_asignacion_capas.Estado_Cod
											WHERE docentes_de_la_capacitacion.Docente_Nro = '".$this->id."' and Crono_Id = '".$this->id_lado_uno."' 
													AND capacitaciones.Edicion_Nro = '".$this->edicion_actual."' " ;
		}
		protected function Carga_Sql_Lista()
		{
			//
			// Lista de Registros de la relacion
			$edactual = new Edicion_Actual() ;
			if ( $edactual->existe )
				{
				$this->edicion_actual = $edactual->Edicion_Actual_Nro ;
				}
			else
				{
					$this->edicion_actual = 0 ;
				}
			$this->strsql = "SELECT docentes_de_la_capacitacion.Crono_Id , 
								docentes_de_la_capacitacion.Estado_Asignacion ,
								docentes_de_la_capacitacion.Crono_Id as Capacitacion ,
								CAST(capacitaciones.Fecha AS DATE) AS Fecha, 
								capacitaciones.Turno_Id, 
								DATE_FORMAT( capacitaciones.Hora_Desde, '%H:%i' ) AS Hora_Desde, 
								DATE_FORMAT( capacitaciones.Hora_Hasta, '%H:%i' ) AS Hora_Hasta,  
								estados_asignacion_capas.Estado, 
								docentes_de_la_capacitacion.Control ,
								capacitaciones.Matricula, 
								escuelas_general.NOMBRE ,
								escuelas_general.DOMICILIO, 
								escuelas_general.TIPO, 
								escuelas_general.COMUNA, 
								escuelas_general.BARRIO 
								FROM `docentes_de_la_capacitacion` 
								INNER JOIN capacitaciones ON docentes_de_la_capacitacion.Crono_Id = capacitaciones.Crono_Id
								LEFT JOIN escuelas_general ON capacitaciones.CUE = escuelas_general.CUE
								LEFT JOIN docente ON docentes_de_la_capacitacion.Docente_Nro = docente.Docente_Nro
								LEFT JOIN personas ON docente.Persona_Id = personas.Persona_Id
								LEFT JOIN estados_asignacion_capas ON estados_asignacion_capas.Estado_Cod = docentes_de_la_capacitacion.Estado_Asignacion
								WHERE docentes_de_la_capacitacion.Docente_Nro  = '".$this->id_lado_uno."'  
													AND capacitaciones.Edicion_Nro = '".$this->edicion_actual."' " ;		
		}

		public function confirma_asignacion()
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
				// Id
				$nomid = $this->prefijo_campo.'_Id';
				if ( isset ( $_GET[$nomid] ) )
					{
						$id = $_GET[$nomid] ;
					}
				else
					{
						$this->error = true ;
						$this->textoError = " No se encuentra Id de registro a procesar " ;
					}
				//
				// Abre conexion con la base de datos
				$cn=new Conexion();
				// 2016-02-10 dz	while ($this->obj_lado_uno->existe == true and $this->obj_lado_muchos->existe == true and $reg=mysqli_fetch_array($regs,MYSQLI_NUM) )		
				if ($this->error == false ) 
						{							
							//
							// borra la seleccion
							$strsql = "UPDATE  ".$this->nombre_fisico_tabla." SET Estado_Asignacion = 'C' , Control = 'Confirmada por el Docente - ".date('d-m-Y H:i')." ' 
														WHERE ".$this->nombre_id_lado_uno." = '".$this->id_lado_uno."'
														AND Crono_Id = '".$id."' " ;
							$ok = $cn->conexion->query($strsql) ;
							if ( ! $ok ) 	die("Problemas en el update de ".$this->nombre_tabla." : ".$cn->conexion->error.$strsql );
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
					for($i=2;$i<count($this->lista_campos_lectura);$i++)
						{
							$txt=$txt.'<td>';
				      // 2016_02_12 by DZ $txt=$txt.$this->lista_campos_descrip[$i];
				      $txt=$txt.$this->lista_campos_lectura[$i]['descripcion'];
				      $txt=$txt.'</td>';
						}
					//
					// Columna acciones
					$txt=$txt.'<td>Accion</td>';
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
				  		for($f=2;$f<count($reg);$f++)
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
						//
						// Si es capa a confirmar
						if ( $reg[1] == 'S' )
						{
							$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.'okConfirmaAsignacion=1">Confirmar</a>' ;
						}
						//if ( $reg[3] <= date('Y-m-d') and  $reg[1] == 'C' )
						//{
						//	
						//	$txt=$txt.'<br> <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.'okHecha=1">Marcar como Hecha</a>' ;
						//}
						//$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.'okModificar=1">Modificar</a>' ;
						$txt=$txt.'</td>' ;
						//
						// Si ya esta hecha
						$txt=$txt.'</tr>';
					}
					$txt=$txt.'<tr><td colspan="'.$cntcols.'">';
					//$txt=$txt.'<input type="submit" value="Agregar" name="'.$this->prefijo_campo.'_okAgregar">';
					if ( $this->existe == true )
					{
						//$txt=$txt.'<input type="submit" value="Borrar" name="'.$this->prefijo_campo.'_okBorrar">';
					}
					$txt=$txt.'</td></tr>'; 
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
