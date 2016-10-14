<?php
class relacionj extends entidadi {
		protected $id_lado_uno;
		protected $obj_lado_uno;
		protected $nombre_id_lado_uno;
		protected $obj_lado_muchos;
		protected $boton_modifica_relacion;
		//
		// Funciones a redefinir en clase heredada
		// 
		public function obtiene_prefijo_campo_lado_muchos()
		{
			return $this->obj_lado_muchos->obtiene_prefijo_campo() ;
		}
		public function devuelve_obj_lado_muchos()
		{
			return $this->obj_lado_muchos ;
		}
		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Lado Uno de la Relación
			$this->obj_lado_uno = new Entidad() ;
			//
			// Nombre del Id en la tabla de la ralacion
			$this->nombre_id_lado_uno = 'Nombre_del_campo_Id_en_la_tabla' ;
			//
			// Lado Muchos de la Relación
			$this->obj_lado_muchos = new Entidad() ;
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_rel_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'id' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Identificador' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>new Entidadi_de_la_fk() ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'id' 			, 'tipo'=>'pk' 		, 'descripcion'=>'Identificador' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'descrip' 	, 'tipo'=>'text' 	, 'descripcion'=>'Identificador' , 'clase'=>new Entidadi_de_la_fk() ) ;

			//
			// Lista de Campos
			foreach( $this->lista_campos_lista as $campo )
			{
				$this->lista_campos_descrip[]= $campo['descripcion'] ;
				$this->lista_campos_tipo[]= $campo['tipo'] ;
				$this->lista_campos_nombre[]= $campo['nombre'] ;
			}
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
			// Boton Modificar
			$this->boton_modifica_relacion = false ; // = true ;
		}	
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

		//
		// Funciones que no hace falta redefinir
		//
		public function texto_Ver_Lado_Uno ()
		{
			return $this->obj_lado_uno->texto_ver() ;
		}
		public function devuelve_id_lado_muchos_requested()
		{
			$nomid = $this->prefijo_campo.'_Id';
			if ( isset ( $_REQUEST[$nomid] ) )
			{
				$id = $_REQUEST[$nomid] ;
			}
			else
			{
				$id = NULL ;
			}
			return $id ;
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
	  public function Nombre_Post_Get_Id_Lado_Uno()
		{
			return $this->obj_lado_uno->prefijo_campo.'_Id' ;
		}
		public function __construct()
  	{
			$this->boton_modifica_relacion = false ;
			$this->existe = false ;
			$this->Pone_Datos_Fijos_No_Heredables() ; 									// by DZ 2015-08-14 - agregado lista de datos
  	}
		public function set_id_lado_uno ($id)
		{
			$this->id_lado_uno = $id ;
			$this->obj_lado_uno->id = $this->id_lado_uno ;
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
							if ( $this->boton_modifica_relacion )
							$txt=$txt.'<input type="submit" value="Modificar" name="'.$this->prefijo_campo.'_okModificar">';
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
							// borra la seleccion
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
