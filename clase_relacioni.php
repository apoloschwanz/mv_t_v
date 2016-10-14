<?php

class relacioni extends entidadi {
		protected $id_lado_uno;
		protected $obj_lado_uno;
		protected $nombre_id_lado_uno;
		protected $obj_lado_muchos;
		//
		// Funciones a redefinir en clase heredada
		// 
		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Lado Uno de la Relación
			$this->obj_lado_uno = new Entidad() ;
			$this->nombre_id_lado_uno = 'Nombre_del_campo_Id_en_la_tabla' ;
			//
			// Lado Muchos de la Relación
			$this->obj_lado_muchos = new Entidad() ;
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_rel_' ;
			//
			// Lista de Campos
			$this->lista_campos_descrip=array() ;
			$this->lista_campos_tipo=array() ;
			$this->lista_campos_nombre=array() ;
			$this->lista_campos_descrip[]='Identificador' ;
			$this->lista_campos_descrip[]='Descripcion de Entidad' ;
			$this->lista_campos_tipo[]='pk' ; // 'pk' 'fk' 'other' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password' 
			$this->lista_campos_tipo[]='text';
			$this->lista_campos_nombre[]='Crono_Id' ;
			$this->lista_campos_nombre[]='Descrip' ;
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
		}	
		
	protected function Carga_Sql_Lista()
	{
		$this->strsql = ' SELECT ' ;
		$tf_primero = true ;
		foreach ( $this->lista_campos_lista as $campo )
		{
			if ( $tf_primero )
			{
				$tf_primero = false;
			}
			else
				$this->strsql .= ' , ';
			$this->strsql .= $campo['nombre'] ;
		}
		$this->strsql .= ' FROM '.$this->nombre_fisico_tabla. ' ' ;
		$this->strsql .= ' WHERE '.$this->nombre_id_lado_uno." = '" .$this->id_lado_uno ."' " ;
		
	}
/* DZ 2016-09-08 - luego de redefinir las mismas funciones en clase_entidad
	protected function Carga_Sql_Lectura()
	{
	$this->strsql = "SELECT campo1, campo2
			FROM Tabla 
			INNER JOIN Otra_Tabla 
			ON Tabla.FK = Otra_Tabla.PK
			WHERE Tabla.PK = " .$this->id ;
	}
	protected function Carga_Sql_Lista()
	{
	$this->strsql = "SELECT clave, color, campo1, campo2
			FROM Tabla 
			INNER JOIN Otra_Tabla 
			ON Tabla.FK = Otra_Tabla.PK
			LIMIT " .$this->desde.",".$this->cuenta ;		
	}
*/
		//
		// Funciones que no hace falta redefinir
		//
		public function texto_Ver_Lado_Uno ()
		{
			return $this->obj_lado_uno->texto_ver() ;
		}
		public function devuelve_id_lado_uno()
		{
			return $this->id_lado_uno ;
		}
		public function existe_lado_uno()
		{
		$this->obj_lado_uno->Leer();
		return $this->obj_lado_uno->existe ;
		}

		public function mostrar_pagina_alta()
		{	
			//
			//
			if ( isset( $_POST[$this->okSalir] ) )
			{
				$this->ok_Salir() ;
			}
			elseif ( isset( $_POST[$this->okGrabaAgregar] ) )
			{
				// Graba Modificaciones
				$this->texto_agregar_okGrabar();
				if ( $this->hay_error() == true ) $this->muestra_error() ;
				else $this->muestra_ok('Registro # '.$this->id().' agregado') ;
			}
			elseif ( isset($_REQUEST['okSalir'] ) )
			{
				$this->ok_Salir() ;
			}
			else
			{
				//
				// Arma la página para agregar		
				$pagina=new Paginai($this->nombre_tabla ,'<input type="submit" value="Grabar" name="'.$this->okGrabaAgregar.'"><input type="submit" value="Salir" name="'.$this->okSalir.'">');
				$txt = $this->texto_Ver_Lado_Uno();
				$pagina->insertarCuerpo($txt);
				
				$txt = 	$this->texto_agregar();
				$pagina->insertarCuerpo($txt);
				$pagina->graficar_c_form($_SERVER['PHP_SELF']);
				

			}
		}





	  public function Nombre_Post_Get_Id_Lado_Uno()
		{
			return $this->obj_lado_uno->prefijo_campo.'_Id' ;
		}
		public function __construct()
  	{
			$this->existe = false ;
			$this->Pone_Datos_Fijos_No_Heredables() ; 									// by DZ 2015-08-14 - agregado lista de datos
			//
			// Botones
			$this->okSalir= $this->prefijo_campo. '_okSalir';							// by DZ 2016-08-09
			$this->okReleer= $this->prefijo_campo. '_okReleer';
			$this->okGrabar= $this->prefijo_campo. '_okGrabar';
			$this->okModificar=$this->prefijo_campo. '_okModificar';
			$this->okGrabaAgregar= $this->prefijo_campo. '_okGrabaAgregar';
  	}
		public function set_id_lado_uno ($id)
		{
			$this->id_lado_uno = $id ;
			$this->obj_lado_uno->id = $this->id_lado_uno ;
		}


	protected function Asegurar_que_exista()
	{
		echo 'Asegura que exista en clase_relacioni.php'  ;
	}
	public function texto_agregar()
		{
			$this->error= false ;
			$cpo = new Campo();
			$this->obj_lado_uno->Leer();
			if ( $this->obj_lado_uno->existe == false )
			{ 
				$this->error = true ;
				$this->textoError = "El registro con Id ".$this->obj_lado_uno->id." no se encuentra en la base de datos " ;
			}
				
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
			$i = 0 ;
			$lst_cmp = $this->nombre_id_lado_uno ;
			$lst_val = "'".$this->id_lado_uno."'" ;
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
								$lst_cmp = $lst_cmp.', ' ;
								$lst_val = $lst_val.', ' ;
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
						if ( empty( $valor ) )
							$lst_val .= 'NULL' ;
						else
							$lst_val .= "'".$valor."'" ;
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



		public function texto_actualizar_detalle ()
			{
				$this->error= false ;
				$this->obj_lado_uno->Leer();
				if ( $this->obj_lado_uno->existe == false )
				{ 
					$this->error = true ;
					$this->textoError = "El registro con Id ".$this->obj_lado_uno->id." no se encuentra en la base de datos " ;
				}
				//
				// Lee Lista
				$txt = '' ;
				if ( $this->error == false )
				{
					$this->leer_lista();
					$txt = '';
					$txt=$txt.'<table>';
					$txt=$txt.'<tr>' ;
					$txt=$txt.'<td> </td>';
					$cntcols = count($this->lista_campos_descrip)+2 ;
					for($i=1;$i<count($this->lista_campos_descrip);$i++)
						{
							$txt=$txt.'<td>';
				      $txt=$txt.$this->lista_campos_descrip[$i];
				      $txt=$txt.'</td>';
						}
					$txt=$txt.'</tr>';
					while ($this->existe == true and $reg=mysqli_fetch_array($this->registros,MYSQLI_NUM) )
						{
				    	$txt=$txt.'<tr>';
							$txt=$txt.'<td>';
				  		$txt=$txt.'<input type="checkbox" name="'.$this->prefijo_campo.'_Id'.$reg[0].'">';
				  		$txt=$txt.'</td>';
				  		for($f=1;$f<count($reg);$f++)
								{
									$txt=$txt.'<td>';
						      $txt=$txt.$reg[$f];
						      $txt=$txt.'</td>';
								}
							if ( $this->borrar_sin_seleccion )
							{
								$txt=$txt.'<td>' ;
								$txt.='<button type="submit" value="'.$reg[0].'" name="'.$this->prefijo_campo.'_okBorrarUno">Borrar</button>';
								$txt=$txt.'</td>' ;
							}
						
							//$txt=$txt.'<td>' ;
							//$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.'okVer=1">Ver</a>' ;
							//$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.'okModificar=1">Modificar</a>' ;
							//$txt=$txt.'</td>' ;
							$txt=$txt.'</tr>';
						}
					if ( $this->existe == true )
						{ 
							$txt=$txt.'<tr><td colspan="'.$cntcols.'">';
							$txt=$txt.'<input type="submit" value="Agregar" name="'.$this->prefijo_campo.'_okAgregar">';
							$txt=$txt.'<input type="submit" value="Borrar" name="'.$this->prefijo_campo.'_okBorrar">';
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
						$txt=$txt.'<tr>' ;
						$txt=$txt.'<td> </td>';
						$cntcols = count($this->lista_campos_descrip)+2 ;
						for($i=1;$i<count($this->lista_campos_descrip);$i++)
							{
								$txt=$txt.'<td>';
						    $txt=$txt.$this->lista_campos_descrip[$i];
						    $txt=$txt.'</td>';
							}
						$txt=$txt.'</tr>';
						$registros = $this->obj_lado_muchos->Obtener_Lista();
					}
				while ($this->obj_lado_muchos->existe == true and $reg=mysqli_fetch_array($registros,MYSQLI_NUM) )
					{
		      	$txt=$txt.'<tr>';
						$txt=$txt.'<td>';
		    		$txt=$txt.'<input type="checkbox" name="'.$this->prefijo_campo.'_Id_Selected'.$reg[0].'">';
		    		$txt=$txt.'</td>';
		    		for($f=1;$f<count($reg);$f++)
							{
								$txt=$txt.'<td>';
				        $txt=$txt.$reg[$f];
				        $txt=$txt.'</td>';
							}
						//$txt=$txt.'<td>' ;
						////$nom_check = $this->prefijo_campo.$reg[0].'okSelected' ;
						////$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$nom_check.'=1"></a>' ;
						//$txt=$txt.'<input type="submit" value="Seleccionar" name="'.$this->prefijo_campo.'_okSelected">';
						//$txt=$txt.'</td>' ;
						$txt=$txt.'</tr>';
					}
					// Fin While 
					//
					if ( $this->error == false )
						{
						$txt=$txt.'<tr>';
						$txt=$txt.'<td colspan="'.$cntcols.'">';
						//$nom_check = $this->prefijo_campo.$reg[0].'okSelected' ;
						//$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$nom_check.'=1"></a>' ;
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
																 (".$this->nombre_id_lado_uno.", ".$this->lista_campos_nombre[0]." ) 
									SELECT ".$this->nombre_id_lado_uno.", ".$this->lista_campos_nombre[0]." FROM 
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
		public function borrar_uno()
		{
			$this->error= false ;
			$this->obj_lado_uno->Leer();
			if ( $this->obj_lado_uno->existe == false )
			{ 
				$this->error = true ;
				$this->textoError = "El registro con Id: ".$this->obj_lado_uno->id." no se encuentra en la base de datos " ;
			}
			if ( ! $this->error )
			{
				// Borra el registro
				//
				// Abre conexion con la base de datos
				$cn=new Conexion();
				
				$this->strsql = "DELETE FROM ".$this->nombre_fisico_tabla." 
														WHERE ".$this->lista_campos_nombre[0]." = '".$reg[0]."' " ;
				$ok = $cn->conexion->query($this->strsql) ;
				if ( ! $ok ) 	die("Problemas en el delete de ".$this->nombre_tabla." : ".$cn->conexion->error.$this->strsql );
				//
				// Cierra la conexion
				$cn->cerrar();
			}
		}
		public function borrar_seleccion()
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
		// 2016-02-10 dz $regs = $this->obj_lado_muchos->Obtener_Lista();
		$regs = $this->Obtener_Lista(); // 2016-02-10 dz
		//
		// Abre conexion con la base de datos
		$cn=new Conexion();
		// 2016-02-10 dz	while ($this->obj_lado_uno->existe == true and $this->obj_lado_muchos->existe == true and $reg=mysqli_fetch_array($regs,MYSQLI_NUM) )		
		while ($this->obj_lado_uno->existe == true and $this->existe == true and $reg=mysqli_fetch_array($regs,MYSQLI_NUM) ) // 2016-02-10 dz 
				{
					$nom_check = $this->prefijo_campo.'_Id'.$reg[0] ;
					if (  isset($_REQUEST [$nom_check] ) )
						{
							//
							// Inserta la seleccion
							$strsql = "DELETE FROM ".$this->nombre_fisico_tabla." 
														WHERE ".$this->nombre_id_lado_uno." = '".$this->id_lado_uno."'
														AND ".$this->lista_campos_nombre[0]." = '".$reg[0]."' " ;
							$ok = $cn->conexion->query($strsql) ;
							if ( ! $ok ) 	die("Problemas en el delete de ".$this->nombre_tabla." : ".$cn->conexion->error.$strsql );
						}				
				}
			//
			// Cierra la conexion
			$cn->cerrar();

		}



}


?>
