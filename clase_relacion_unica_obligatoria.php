<?php
class relacion_unica_obligatoria extends relacioni {
// 
// Clase Relacion Única:
//
// Relacion entre dos entidades una de las cuales
// es fija, por ejemplo un año para una relacion
// que tiene un registro para cada año para una
// determinada entidad

protected $id_lado_uno_fijo ;
protected $nombre_id_lado_uno_fijo ;
	protected function Carga_Sql_Lectura()
	{
		//
		// Modifica funcion de clase Entidad(clase_entidad.php)
		$this->strsql = ' SELECT ' ;
		$tf_primero = true ;
		foreach ( $this->lista_campos_lectura as $campo )
		{
			if ( $tf_primero )
			{
				$tf_primero = false;
				$ts_pk = $campo['nombre'] ;
			}
			else
				$this->strsql .= ' , ';
			$this->strsql .= $campo['nombre'] ;
		}
		$this->strsql .= ' FROM '.$this->nombre_fisico_tabla. ' ' ;
		$this->strsql .= ' WHERE '.$this->nombre_id_lado_uno." = '" .$this->id_lado_uno ."' " ;
		$this->strsql .= ' AND '.$this->nombre_id_lado_uno_fijo." = '" .$this->id_lado_uno_fijo ."' " ;
	}
	protected function Carga_Sql_Agrega_Blanco()
	{
		$this->strsql = 'INSERT INTO '.$this->nombre_fisico_tabla. ' ' ;
		$this->strsql .= ' ( '.$this->nombre_id_lado_uno.' , ' ;
		$this->strsql .= $this->nombre_id_lado_uno_fijo. ' ) ' ;
		$this->strsql .= " VALUES ( '". $this->id_lado_uno."', " ;
		$this->strsql .= " '".$this->id_lado_uno_fijo . "' ) " ;
		
	}
	public function Leer_o_Agregar()
	{ 
		// Lee el registro y si no existe lo agrega
		$this->Carga_Sql_Lectura();		
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el select de lectura de".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
		if ( $this->registro=mysqli_fetch_array($this->registros) )
			{
				$this->existe = true ;
				mysqli_data_seek ( $this->registros , 0 ) ;	
			}
		else
			{
				//
				// Si el registro no existe lo agrega.
				$this->Carga_Sql_Agrega_Blanco() ;
				mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el insert de".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
				// Lee el registro insertado
				$this->Carga_Sql_Lectura();
				$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el select de lectura de".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
				if ( $this->registro=mysqli_fetch_array($this->registros) )
					{
						$this->existe = true ;
						mysqli_data_seek ( $this->registros , 0 ) ;	
					}	
				else
					{ $this->existe = false ; }
			}
		$this->Leer_Detalle();
		$cn->cerrar();
		//
		// Levanta el id
		$i = 0 ;
		foreach( $this->lista_campos_lectura as $campo)
			{ 
				if (  $campo['tipo'] == 'pk' )
				{
					$this->id = $this->registro[$i] ;
					break;
				}
				$i++ ;
			}
	}
	public function texto_actualizar()
		{
			$this->error= false ;
			//
			// Verifica que exista
			$cpo = new Campo();
			$this->Leer_o_Agregar();
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
							$txt=$txt.'<td></td><td><input type="hidden" name="'.$this->prefijo_campo.'id" value="'.$this->id.'">';
							/* //
							// Clave principal en la lista de campos
							if( $this->lista_campos_lectura[0]['tipo'] == 'pk' )
								{ 
									$txt.= '<input type="hidden" name="'.$this->prefijo_campo.'cpoNro0_" value="'.$reg[0].'">' ;
								} */
							$txt.= '</td>';			
							$txt=$txt.'</tr>';
							
							for($i=1;$i<count($reg);$i++)
								{
									$txt=$txt.'<tr>';
									$txt=$txt.'<td>';
								  $txt=$txt.$this->lista_campos_lectura[$i]['descripcion'];
								  $txt=$txt.'</td>';
									$cpo->pone_nombre( $this->prefijo_campo.'cpoNro'.$i.'_' ) ;
									$cpo->pone_valor( $reg[$i] ) ;
									//if( $this->lista_campos_lectura[$i]['tipo'] == 'pk' )
									//	{ 
									//		$txt = $txt.$cpo->txtMostrarOculto() ;
									//	}
									//elseif( $this->lista_campos_lectura[$i]['tipo'] == 'otro' )
									if( $this->lista_campos_lectura[$i]['tipo'] == 'otro' )
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
}
?>
