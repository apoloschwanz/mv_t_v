<?php

class relacion extends entidad {
		protected $id_lado_uno;
		protected $obj_lado_uno;
		protected $nombre_id_lado_uno;
		protected $obj_lado_muchos;
		protected $borrar_sin_seleccion;
		//
		// Funciones a redefinir en clase heredada
		// 
		protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Lado Uno de la Relación
			$this->obj_lado_uno = new Entidad() ;
			$this->nombre_id_lado_uno = Nombre_Post_Get_Id_Lado_Uno() ;
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
			$this->lista_campos_nombre[]='Id' ;
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
		//
		// Funciones que no hace falta redefinir
		//
	  protected function Nombre_Post_Get_Id_Lado_Uno()
		{
			return $this->obj_lado_uno->prefijo_campo.'_Id' ;
		}
		public function __construct()
  	{
			$this->existe = false ;
			$this->borrar_sin_seleccion = false ;
			$this->Pone_Datos_Fijos_No_Heredables() ; 									// by DZ 2015-08-14 - agregado lista de datos
  	}
		public function set_id_lado_uno ($id)
		{
			$this->id_lado_uno = $id ;
			$this->obj_lado_uno->id = $this->id_lado_uno ;
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
						$txt=$txt.'<td>' ;
						if ( $this->borrar_sin_seleccion )
							{
								$txt.='<button type="submit" value="'.$reg[0].'" name="'.$this->prefijo_campo.'_okBorrarUno">Borrar</button>';
							}
						//$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.'okVer=1">Ver</a>' ;
						//$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.'okModificar=1">Modificar</a>' ;
						$txt=$txt.'</td>' ;
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


		public function texto_Mostrar_Seleccion_Sin_Boton ()
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
					
					// borrar if ( $this->error == false )
					// borrar {
					// borrar $txt=$txt.'<tr>';
					// borrar $txt=$txt.'<td colspan="'.$cntcols.'">';
					// borrar 	//$nom_check = $this->prefijo_campo.$reg[0].'okSelected' ;
					// borrar 	//$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$nom_check.'=1"></a>' ;
					// borrar 	$txt=$txt.'<input type="submit" value="Seleccionar" name="'.$this->prefijo_campo.'_okSelected">';
					// borrar 	$txt=$txt.'</td>' ;
					// borrar 	$txt=$txt.'</tr>';	
					// borrar 	}
					
					
					// Cierra la tabla
					$txt = $txt.'</table>' ;
					/* liberar el conjunto de resultados */
					if ( $this->obj_lado_muchos->existe == true ) {
		 				$registros->close(); }
					return $txt ;


			} 
			// Fin Function Mostrar Seleccion Sin Boton

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
									VALUES ('".$this->id_lado_uno."', '".$reg[0]."' )" ;
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
			//
			// Borra un de a un registro
			//
			$this->error= false ;
			$this->obj_lado_uno->Leer();
			if ( $this->obj_lado_uno->existe == false )
			{ 
				$this->error = true ;
				$this->textoError = "El registro con Id: ".$this->obj_lado_uno->id." no se encuentra en la base de datos " ;
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
			// 2016-02-10 dz while ($this->obj_lado_uno->existe == true and $this->obj_lado_muchos->existe == true and $reg=mysqli_fetch_array($regs,MYSQLI_NUM) )
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
