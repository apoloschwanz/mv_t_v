<?php

class Entidadi extends Entidad  {
	protected $pagina_url_anterior ;
	protected $lista_campos_lista ;
	protected $lista_campos_lectura ;
	protected $pagina_titulo ;
	protected $okGrabaAgregar ;
	protected $okModificar ;
	protected $okGrabar  ;
	protected $okReleer  ;
	protected $okSalir ;
	protected $botones_extra_edicion ;
	public $okExportar ;
  // by DZ 2016-01-22 - protected $lista_campos_descrip ;																
	// by DZ 2016-01-22 - sacar ---- protected $lista_campos_tipo ;																	
	// by DZ 2016-01-22 - protected $lista_campos_nombre ;																
 		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_ent_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'id' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Identificador' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>NULL ) ;
			//$this->lista_campos_lista[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>new Entidadi() ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'id' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Identificador' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>NULL ) ;
			//$this->lista_campos_lectura[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>new Entidadi() ) ;
						
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Nombre de la_tabla" ;
			$this->nombre_fisico_tabla = "nombre_de_la_tabla" ;
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
			// Botones Extra para texto_mostrar_abm
			//$this->botones_extra_abm[] = array( 'nombre'=>$this->prefijo_campo.'_okExportar' , 'texto'=>'Exportar' ) ;
			
			//
			// Botones extra edicion
			//$this->botones_extra_edicion[] = array( 'name'=> '_Rel1' ,
			//										'value'=>'Salir' ,
			//										'link'=>'salir.php' ) ; // '<input type="submit" name="'.$this->prefijo_campo.'_Rel1" value="Salir" autofocus>
			//
			// Filtros
			$this->con_filtro_fecha = false;
			$this->con_filtro_general = false;
			//
			//
		}
	protected function maneja_evento_accion_especial()
		{  
			$tts_aux = '<br>Selecciono accion especial: ' .  $this->accion_ok ;
				$tts_aux .= '<br> Para el Id : '.$this->id ;
				$tts_aux .= '<br> Modifique el evento maneja_evento_accion_especial ' ;
				die( $tts_aux ) ;
		}
		//
		// Funciones que no hace falta redefinir
		//
	public function __construct()
  	{
			//
			// Inicializacion de Variables
			$pagina_url_anterior = 'acceuil.php' ;
			$this->existe = false ;
			$this->botones_extra_edicion = array();
			$this->botones_extra_abm = array() ;
			$this->acciones = array() ;
			//$this->acciones[] = array( 'nombre'=>'okOtraAcc' , 'texto'=>'Otra Accion' ) ;
			$this->lista_detalle = array() ;
			$this->tiene_lista_detalle = false ; // se activa en rutina de lista detalle
			$this->lista_detalle_enc_columnas = array();
			//
			// Personalizacion de variables
			$this->Pone_Datos_Fijos_No_Heredables() ; // by DZ 2016-10-11
			//
			// Botones:
			$this->okSalir= $this->prefijo_campo. '_okSalir';
			$this->okReleer= $this->prefijo_campo. '_okReleer';
			$this->okGrabar= $this->prefijo_campo. '_okGrabar';
			$this->okModificar=$this->prefijo_campo. '_okModificar';
			$this->okGrabaAgregar= $this->prefijo_campo. '_okGrabaAgregar';
			$this->okExportar = $this->prefijo_campo. '_okExportar' ;
			//
			// Personalizacion de variables
			// by DZ 2015-08-15 $this->Pone_Datos_Fijos_No_Heredables() ; 									// by DZ 2015-08-14 - agregado lista de datos
  	}

	public function texto_actualizar_okGrabar()
		{
			$nomid = $this->prefijo_campo.'id';
			$this->Set_id($_POST[$nomid]);
			$this->error= false ;
			$this->Leer();
			if ( $this->existe == false )
			{ 
				$this->error = true ;
				$this->textoError = "El registro con Id: ".$this->id." no se encuentra en la base de datos " ;
			}
			if ($this->error == false )
			{
				//
				// Abre la conexión con la base de datos
				$cn=new Conexion();
				//
				// Arma lista de campos a actualizar
				$primerCampo = true;
				$where = 'false' ;
				$strsql = ' UPDATE '.$this->nombre_fisico_tabla.' SET ' ;
				$i = 0 ;
				foreach ( $this->lista_campos_lectura as $campo )
					{
						$tp = $campo['tipo'] ;
						if ( $tp == 'pk' )
							{
							$where = ' '.$campo['nombre']." = '".$this->id."' " ;
							}
						//
						// tipos de camos validos
						elseif ( $tp != 'otro' )
							{
							//
							// Agrega coma
							if ( $primerCampo == false )
								{
									$strsql = $strsql.', ' ;
								}
							else
								{
									$primerCampo = false ;
									
								}
							//
							// Nombre de campo
							$nomCtrl = $this->prefijo_campo.'cpoNro'.$i.'_'  ;
							//
							// Valor a reemplazar en el campo
							if ( $tp == 'time' ) $valor = '1899-12-30 '.$_POST[$nomCtrl] ;
							else $valor = $_POST[$nomCtrl] ;
							//
							// Instruccion set...
							if ( empty( $valor ) )
							$strsql .= $campo['nombre']. " = NULL " ;
							else
							$strsql .= $campo['nombre']. " = '".$valor."' " ;
							}
						$i++;
					}
				$strsql = $strsql.' WHERE '.$where.' ' ;
				//
				// Cierra la conexion
				$actualizado = $cn->conexion->query($strsql) ;
				if( ! $actualizado ) die( "Problemas en el update de ".$this->nombre_tabla." : ".$cn->conexion->error.$strsql ) ;
				$cn->cerrar();
			}
		}	
	public function texto_actualizar()
		{
			$this->error= false ;
			$cpo = new Campo();
			$this->Leer();
			if ( $this->existe == false )
			{ 
				$this->error = true ;
				$this->textoError = "El registro con Id: ".$this->id." no se encuentra en la base de datos " ;
			}
			//
			// Otra validacion
			//
			//if ($this->Error == false )
			//	{ 
			//		//.....validacion
			//		if ( condicion de error )
			//			{
			//			$this->Error = true;

			//			$this->TextoError = ' Texto del error ' ;
			//			}
			//		
			//	}
			if ( $this->error == true )
				{
					$txt = '<td>'.$this->textoError.'</td>';
				}
			else
				{
					//
					// Abre tabla
					$txt = '<table class="tablacampos">';
					if ( $reg=mysqli_fetch_array($this->registros,MYSQLI_NUM) )
						{
							$txt=$txt.'<tr>';
							$txt=$txt.'<td></td><td><input type="hidden" name="'.$this->prefijo_campo.'id" value="'.$this->id.'"></td>';
							$txt=$txt.'</tr>';
							for($i=0;$i<count($reg);$i++)
								{
									$txt=$txt.'<tr>';
									$txt=$txt.'<td>';
								  $txt=$txt.$this->lista_campos_lectura[$i]['descripcion'];
								  $txt=$txt.'</td>';
									$cpo->pone_nombre( $this->prefijo_campo.'cpoNro'.$i.'_' ) ;
									$cpo->pone_valor( $reg[$i] ) ;
									if( $this->lista_campos_lectura[$i]['tipo'] == 'pk' or $this->lista_campos_lectura[$i]['tipo'] == 'otro' )
										{ 
											$cpo->pone_tipo( 'text' ) ;
											$txt = $txt.$cpo->txtMostrarEtiqueta() ;
										}
									elseif( $this->lista_campos_lectura[$i]['tipo'] == 'fk' )
										{
											//
											// Lista de fk
											//
											$cpo->pone_tipo( 'select' ) ;
											$lista_fk = $this->lista_campos_lectura[$i]['clase']->Obtener_Lista() ;
											$cpo->pone_lista( $lista_fk ) ;
											$cpo->pone_posicion_codigo( 0 ) ;
											$cpo->pone_posicion_descrip( 1 ) ;
											$cpo->pone_mostar_nulo_en_si() ;
											$txt = $txt.$cpo->txtMostrarParaModificar() ;
										}
									else
										{ 
											$cpo->pone_tipo( $this->lista_campos_lectura[$i]['tipo'] ) ;
											$txt = $txt.$cpo->txtMostrarParaModificar() ;
											//$txt=$txt.'<input type="'.$this->lista_campos_tipo[$i].'" name="'.$nom_campo.'" value="'.$reg[$i].'">';
											//$txt=$txt.'</td>';
										}
									$txt=$txt.'</tr>';
								}
						}
					else
						{
							$txt=$txt.'<td> mysqli_fetch_array No encontro registro </td>';
						}
					//
					// Cierra tabla
					$txt = $txt.'</table>';
				}
				return $txt ;
		}
	public function texto_ver()
		{
			$this->error= false ;
			$cpo = new Campo();
			$this->Leer();
			if ( $this->existe == false )
			{ 
				$this->error = true ;
				$this->textoError = "El registro con Id: ".$this->id." no se encuentra en la base de datos " ;
			}
			//
			// Otra validacion
			//
			//if ($this->Error == false )
			//	{ 
			//		//.....validacion
			//		if ( condicion de error )
			//			{
			//			$this->Error = true;

			//			$this->TextoError = ' Texto del error ' ;
			//			}
			//		
			//	}
			if ( $this->error == true )
				{
					$txt = '<td>'.$this->textoError.'</td>';
				}
			else
				{
					//
					// Abre tabla
					$txt = '<table class="tablacampos">';
					if ( $reg=mysqli_fetch_array($this->registros,MYSQLI_NUM) )
						{
							$txt=$txt.'<tr>';
							$txt=$txt.'<td></td><td><input type="hidden" name="'.$this->prefijo_campo.'id" value="'.$this->id.'"></td>';
							$txt=$txt.'</tr>';
							for($i=0;$i<count($reg);$i++)
								{
									$txt=$txt.'<tr>';
									$txt=$txt.'<td>';
								  $txt=$txt.$this->lista_campos_lectura[$i]['descripcion'];
								  $txt=$txt.'</td>';
									$cpo->pone_nombre( $this->prefijo_campo.'cpoNro'.$i.'_' ) ;
									$cpo->pone_valor( $reg[$i] ) ;
									if( $this->lista_campos_lectura[$i]['tipo'] == 'pk' or $this->lista_campos_lectura[$i]['tipo'] == 'otro' )
										{ 
											$cpo->pone_tipo( 'text' ) ;
											$txt = $txt.$cpo->txtMostrarEtiqueta() ;
										}
									elseif( $this->lista_campos_lectura[$i]['tipo'] == 'fk' )
										{
											//
											// Lista de fk
											//
											$cpo->pone_tipo( 'select' ) ;
											$lista_fk = $this->lista_campos_lectura[$i]['clase']->Obtener_Lista() ;
											$cpo->pone_lista( $lista_fk ) ;
											$cpo->pone_posicion_codigo( 0 ) ;
											$cpo->pone_posicion_descrip( 1 ) ;
											$cpo->pone_mostar_nulo_en_si() ;
											$txt = $txt.$cpo->txtMostrarParaVer() ;
										}
									else
										{ 
											$cpo->pone_tipo( $this->lista_campos_lectura[$i]['tipo'] ) ;
											$txt = $txt.$cpo->txtMostrarParaVer() ;
										}
									$txt=$txt.'</tr>';
								}
						}
					else
						{
							$txt=$txt.'<td> mysqli_fetch_array No encontro registro </td>';
						}
					//
					// Cierra tabla
					$txt = $txt.'</table>';
				}
				return $txt ;
		}

	public function texto_agregar()
		{
			$this->error= false ;
			$cpo = new Campo();
			//
			// Abre tabla
			$txt = '<table>';
			for($i=1;$i<count($this->lista_campos_lectura);$i++)
				{
					$txt=$txt.'<tr>';
					$txt=$txt.'<td>';
				  $txt=$txt.$this->lista_campos_lectura[$i]['descripcion'];
				  $txt=$txt.'</td>';
					$cpo->pone_nombre( $this->prefijo_campo.'cpoNro'.$i.'_' ) ;
					$cpo->pone_valor( '' ) ;
					if( $this->lista_campos_lectura[$i]['tipo'] == 'pk' or $this->lista_campos_lectura[$i]['tipo'] == 'otro' )
						{ 
							//$cpo->pone_tipo( 'text' ) ;
							//$txt = $txt.$cpo->txtMostrarEtiqueta() ;
						}
					elseif( $this->lista_campos_lectura[$i]['tipo'] == 'fk' )
						{
							//
							// Lista de fk
							//
							$cpo->pone_tipo( 'select' ) ;
							$lista_fk = $this->lista_campos_lectura[$i]['clase']->Obtener_Lista() ;
							$cpo->pone_lista( $lista_fk ) ;
							$cpo->pone_posicion_codigo( 0 ) ;
							$cpo->pone_posicion_descrip( 1 ) ;
							$cpo->pone_mostar_nulo_en_si() ;
							$txt = $txt.$cpo->txtMostrarParaModificar() ;
						}
					else
						{ 
							$cpo->pone_tipo( $this->lista_campos_lectura[$i]['tipo'] ) ;
							$txt = $txt.$cpo->txtMostrarParaModificar() ;
							//$txt=$txt.'<input type="'.$this->lista_campos_tipo[$i].'" name="'.$nom_campo.'" value="'.$reg[$i].'">';
							//$txt=$txt.'</td>';
						}
					$txt=$txt.'</tr>';
				}
			//
			// Cierra tabla
			$txt = $txt.'</table>';
				return $txt ;
		}

		public function texto_agregar_okGrabar()
		{
			//$nomid = $this->prefijo_campo.'id';
			//$this->Set_id($_POST[$nomid]);
			$this->error= false ;
			//$this->Leer();
			//
			// Abre la conexión con la base de datos
			$cn=new Conexion();
			//
			// Arma lista de campos a agregar
			$lst_cmp = '';
			$lst_val = '';
			$primerCampo = true;
			$i = 0 ;
			foreach ( $this->lista_campos_lectura as $campo )
				{
					//
					// tipo de campo
					$tp = $campo['tipo'] ;
					//
					// tipos de camos validos
					if ( $tp != 'otro' and $tp != 'pk' )
						{
						//
						// Agrega coma
						if ( $primerCampo == false )
							{
								$lst_cmp = $lst_cmp.', ' ;
								$lst_val = $lst_val.', ' ;
							}
						else
							{
								$primerCampo = false ;
								
							}
						//
						// Nombre de campo
						$nomCtrl = $this->prefijo_campo.'cpoNro'.$i.'_'  ;
						//
						// Valor a reemplazar en el campo
						if ( $tp == 'time' ) $valor = '1899-12-30 '.$_POST[$nomCtrl] ;
						else $valor = $_POST[$nomCtrl] ;
						//
						// Lista campos
						$lst_cmp = $lst_cmp. $campo['nombre'] ;
						//
						// Lista valores
						$lst_val = $lst_val."'".$valor."'" ;
						}
					$i++;
				}
			$strsql = ' INSERT INTO '.$this->nombre_fisico_tabla.' ( '.$lst_cmp.' )  VALUES ( '.$lst_val. ' ) ';
			//
			// Cierra la conexion
			$insertado = $cn->conexion->query($strsql) ;
			if ( $insertado ) 
				{ 
					$result = $cn->conexion->query('SELECT last_insert_id()');
					$reg = $result->fetch_array(MYSQLI_NUM);
					$this->id = $reg[0];
					$result->free();
				}
			else
				{
					// die( "Problemas en el insert de ".$this->nombre_tabla." : ".$cn->conexion->error.$strsql ) ;
					$this->error = true ;
					$this->textoError = "Problemas en el insert de ".$this->nombre_tabla." : ".$cn->conexion->error.' '.$strsql ;
				}
			$cn->cerrar();
		}	
		public function pagina_pone_url_anterior($url)
		{
			$this->pagina_url_anterior = $url ;
		}
		public function pagina_pone_titulo($tit)
		{
			$this->pagina_titulo = $tit ;
		}
		public function pagina_edicion_leer_eventos()
		{
		//
		// Varibales de accion
		//
		// Solicita grabar
		$this->okGrabar = $this->prefijo_campo.'_okGrabar' ;
		//
		// Solicita releer
		$this->okReleer = $this->prefijo_campo.'_okReleer' ;
		$this->okSalir = $this->prefijo_campo.'_okSalir' ;
		//
		// Verifica que exista 
		$this->Leer();
		if ( ! $this->existe ) die( 'No se encuentra registro con el id '.$this->id );
		//
		// Eventos
		//
		if ( isset($_POST[$this->okSalir] ) )
			{
			$this->ok_Salir() ;
			}
		elseif ( isset( $_POST[$this->okGrabar] ) )
			{
				$this->texto_actualizar_okGrabar() ;
				if( $this->error ) die ( $this->relacion->textoError() ) ;
				else $this->mostrar_edicion() ;
			}
		elseif ( isset( $_POST[$this->okReleer] ) )
			{
				$this->mostrar_edicion() ;
			}
		else
			{
				//
				// Eventos extra
				$linkextra = '' ;
				foreach ( $this->botones_extra_edicion as $boton )
				{
					if ( isset($_POST[$this->prefijo_campo.$boton['name']]))
						$linkextra = $boton['link'] ;
				}
				if ( empty( $linkextra ) )					
					$this->mostrar_edicion() ;
				else
					header('Location: '.$linkextra);
			}
		}
		protected function ok_salir()
		{
			if( empty( $this->pagina_url_anterior ) )
						$ts_location = 'accueil.php';
			else
				$ts_location = $this->pagina_url_anterior ;
			header('Location: '.$ts_location);

		}
		protected function mostrar_edicion()
		{
			//
			// Botones extra
			$btn_extra = '' ;
			foreach ( $this->botones_extra_edicion as $boton )
			{
				$btn_extra.= '<input type = "submit" name="'.$this->prefijo_campo.$boton['name'].'" value="'.$boton['value'].'">'  ;
			}
			//
			// Muestra pantalla para editar datos
			$hidden = '<input type="hidden" name="'.$this->prefijo_campo.'_id'.'" value="'.$this->id.'" > ' ;
			$botones = '<input type="submit" name="'.$this->okSalir.'" value="Salir" autofocus>';
			$botones .= '<input type="submit" name="'.$this->okReleer.'" value="Revertir" >';
			$botones .= '<input type="submit" name="'.$this->okGrabar.'" value="Grabar" >';
			$botones .= $btn_extra ;
			$pagina = new Paginai($this->pagina_titulo,$hidden.$botones) ;
			$pagina->sinborde();
			//
			// Muestra la cabecera
			$texto = $this->texto_actualizar();
			$pagina->insertarCuerpo($texto);
			//
			// Grafica la página
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
		}
		//
		// Armado de Pagina
		//
		public function mostrar_pagina_lista()
		{  
			//
			// Acciones Especiales
			$this->accion_especial_seleccionada = false ;
			$this->accion_ok = '' ;
			foreach( $this->acciones as $accion )
			{
				$okAccionEspecial = $this->prefijo_campo.$accion['nombre'] ;
				if ( isset( $_REQUEST[$okAccionEspecial] ) )
				{
					$this->accion_especial_seleccionada = true ;
					$this->accion_ok = $accion['nombre'] ;
					$this->id = 0 ;
					$ts_nom_request_id = $this->prefijo_campo.'_Id' ; 
					if ( isset( $_REQUEST[$ts_nom_request_id] ) ) 
						$this->id =  $_REQUEST[$ts_nom_request_id] ;
						
				}
			}
			//
			// Acciones Clasicas 
			$okVer = $this->obtiene_prefijo_campo().'okVer' ;
			$okModificar = $this->obtiene_prefijo_campo().'okModificar' ;
			$okagregar = $this->obtiene_prefijo_campo().'_okAgregar' ;
			$okborrar  = $this->obtiene_prefijo_campo().'_okBorrar' ;
			//
			//
			if ( $this->accion_especial_seleccionada )
			{
				$this->maneja_evento_accion_especial();
			}
			elseif ( isset($_GET[$okModificar]) )
			{
				//
				// Edita
				$nomid = $this->obtiene_prefijo_campo().'_Id' ;
				$this->Set_id($_REQUEST[$nomid]) ;
				$this->mostrar_edicion();
				//muestra_modificar($Entidad) ;
			}
			elseif ( isset( $_POST[$this->okSalir] ) )
			{
				$this->ok_Salir() ;
			}
			elseif ( isset( $_POST[$this->okReleer] ) )
				die('dijo: Ok Reller !') ;
			elseif ( isset( $_POST[$this->okGrabar] ) )
			{
				// Graba Modificaciones
				$this->texto_actualizar_okGrabar();
				if ( $this->hay_error() == true ) $this->muestra_error() ;
				else $this->muestra_ok('Registro # '.$this->id().' actualizado') ;
			}
			elseif ( isset($_REQUEST['okSalir'] ) )
			{
				$this->ok_Salir() ;
			}
			else
			{
				$this->mostrar_lista_abm() ;
			}
		}

		public function mostrar_lista_abm()
		{
			$hidden = '' ;
			$pagina = new Paginai($this->nombre_tabla ,$hidden.'<input type="submit" name="okSalir" value="Salir" autofocus>') ;
			//
			// Muestra la cabecera
			$texto = $this->texto_mostrar_abm() ;
			$pagina->insertarCuerpo($texto);
			//
			// Grafica la página
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
		}
		protected function muestra_error() 
		{
			$hidden = '' ;
			$botones = '<input type="submit" name="'.$this->okSalir.'" value="Ok" autofocus>';
			$pagina = new Paginai($this->pagina_titulo,$hidden.$botones) ;
			$pagina->sinborde();
			//
			// Muestra el error
			$txt = 	$this->textoError ;
			$pagina->insertarCuerpo($txt);
			//
			// Grafica la página
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
		}
		protected function muestra_ok($ps_mje) 
		{
			$hidden = '' ;
			$botones = '<input type="submit" name="'.$this->okSalir.'" value="Ok" autofocus>';
			$pagina = new Paginai($this->pagina_titulo,$hidden.$botones) ;
			$pagina->sinborde();
			//
			// Muestra el error
			$txt = 	$ps_mje ;
			$pagina->insertarCuerpo($txt);
			//
			// Grafica la página
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
		
		}		
		public function exportar_a_archivo()
        {
			$stem = $this->prefijo_campo. date("Y-m-d-h_i_sa");
			$stem = 'c';
            $archivo = tempnam( 'archivos', $stem ) ;
            $file = fopen($archivo,"w");
            //
            // Encabezado
            $ts_enc = "";
            foreach ( $this->lista_campos_lista as $campo )
            {
                $ts_enc .= '"'.$campo['nombre'] . '"; ' ;
            }
            fwrite($file, $ts_enc . PHP_EOL );
            //
            // Recorre los registros
            $this->leer_filtros();
			$this->leer_lista();
            mysqli_data_seek ( $this->registros , 0 ) ;   
            while( $this->registro=mysqli_fetch_array($this->registros,MYSQLI_NUM) )
            {
                //*****-----//
                for($i=0;$i<count($this->registro);$i++)
                {
					$ts_valor = $this->registro[$i] ;
					$ts_valor = mb_convert_encoding($ts_valor, "Windows-1252","UTF-8");
					fwrite($file, '"'.$ts_valor.'";' ) ;
                }
                fwrite($file, PHP_EOL );
            }
       
            fwrite($file, "Generado el ".date("Y-m-d h:i:sa") . PHP_EOL);
            fclose($file);
            return $archivo ;
        }    
        public function bajar_archivo($ps_file_name)
        {
			// make sure it's a file before doing anything!
			if(is_file($ps_file_name)) {

				/*
					Do any processing you'd like here:
					1.  Increment a counter
					2.  Do something with the DB
					3.  Check user permissions
					4.  Anything you want!
				*/

				// required for IE
				if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}

				// get the file mime type using the file extension
				switch(strtolower(substr(strrchr($ps_file_name, '.'), 1))) {
					case 'pdf': $mime = 'application/pdf'; break;
					case 'zip': $mime = 'application/zip'; break;
					case 'jpeg':
					case 'jpg': $mime = 'image/jpg'; break;
					default: $mime = 'application/force-download';
				}
				header('Pragma: public'); 	// required
				header('Expires: 0');		// no cache
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($ps_file_name)).' GMT');
				header('Cache-Control: private',false);
				header('Content-Type: '.$mime);
				header('Content-Disposition: attachment; filename="'.basename($ps_file_name).'.csv"');
				header('Content-Transfer-Encoding: binary');
				//header('Content-type: text/plain; charset=utf-8');


				header('Content-Length: '.filesize($ps_file_name));	// provide file size
				header('Connection: close');
				readfile($ps_file_name);		// push it out
				exit();

			}
		}    
}
?>
