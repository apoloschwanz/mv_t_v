<?php

class enti_lite{
	protected $strsql ;
	protected $filtro_f_desde ;
	protected $filtro_f_hasta ;
	protected $filtro_gral ;
	protected $con_filtro_fecha ;
	protected $con_filtro_general ;
	protected $existe ;					
	protected $pagina_url_anterior ;
	protected $lista_campos_lista ;
	protected $lista_campos_lectura ;
	protected $botones_extra_lista ;
	protected $id;
	
	public function __construct()
	{
		//
		//
		$this->pagina_url_anterior = 'accueil.php' ;
		$this->existe = false ;
		$this->id = null ;
		//
		// Filtros
		$this->con_filtro_fecha = false;
		$this->con_filtro_general = false;		
		//
		// Prefijo campo
		$this->prefijo_campo = 'm_ent_' ;
		//
		// Lista de Campos
		//
		// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
		//								el tipo 'fk' espera que se defina una clase 
		$this->lista_campos_lista=array();
		$this->lista_campos_lectura=array();
		//$this->lista_campos_lectura[]=array( 	'nombre'=>'id' 			, 
		//										'tipo'=>'pk' 		, 
		//										'descripcion'=>'Identificador' , 
		//										'clase'=>NULL ) ;
			
		//
		// Nombre de la tabla
		$this->nombre_tabla = "Nombre de la_tabla" ;
		$this->nombre_fisico_tabla = "nombre_de_la_tabla" ;
		//
		// Nombre de la pagina
		$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
		//
		// Botones Extra
		$this->botones_extra_lista = array() ; 
		//
		// Paginacion
		$this->desde = 0 ;																					
		$this->cuenta = 15 ;	
		$this->Pone_Datos_Fijos_No_Heredables() ;																			
			
	}
	public function id()
		{
			return $this->id;
		}
	public function textoError()
		{
			return $this->textoError ;
		}
	public function hay_error()																			// by DZ 2016-01-22 - agrega seleeccion en clase relacion
		{
			return $this->error;
		}
	public function Leer()
	{ 
		$this->Carga_Sql_Lectura();		
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el select de lectura de".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
		$cn->cerrar();
		if ( $this->registro=mysqli_fetch_array($this->registros) )
			{
				$this->existe = true ;
				mysqli_data_seek ( $this->registros , 0 ) ;	
			}
		else
			{
				$this->existe = false ;
			}
		$this->Leer_Detalle();
	}
	public function leer_lista()
	{ 
		$this->Carga_Sql_Lista();		
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el select de la lista de ".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
		$cn->cerrar();
		if ( $this->registro=mysqli_fetch_array($this->registros) )
			{
				$this->existe = true ;
				mysqli_data_seek ( $this->registros , 0 ) ;
			}
		else
			{
				$this->existe = false ;
			}
		$this->Leer_Detalle();
	}
	protected function Leer_Detalle()
	{
		// Lee Otros registros relacionados
		//if ( ! is_null( $this->detalle ) )
		//	{
		//		$this->detalle->set_id_lado_uno($this->id) ;
		//		$this->detalle->leer_lista() ;
		//	}
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
	public function leer_filtros()
	{
		if ( $this->con_filtro_fecha )
		{
			if ( isset( $_REQUEST[$this->prefijo_campo.'filtro_f_desde'] ) )
				$this->filtro_f_desde = $_REQUEST[$this->prefijo_campo.'filtro_f_desde'] ;
			else
				$this->filtro_f_desde = date('Y-m-d');
			if ( isset( $_REQUEST[$this->prefijo_campo.'filtro_f_hasta'] ) )
				$this->filtro_f_hasta = $_REQUEST[$this->prefijo_campo.'filtro_f_hasta'] ;
			else
				$this->filtro_f_hasta = date('Y-m-d');
		}
		if ( $this->con_filtro_general )
		{
			if ( isset( $_REQUEST[$this->prefijo_campo.'filtro_general'] ) )
				$this->filtro_gral = $_REQUEST[$this->prefijo_campo.'filtro_general'] ;
			else
				$this->filtro_gral = "" ;
		}
			
	}
	public function texto_mostrar_lista()
		{
			$this->leer_filtros();
			$this->leer_lista();
			$cntcols = count($this->lista_campos_lectura)+1 ;
			$txt = '';
			$txt=$txt.'<table>';
			//
			// Filtros
			if ( $this->con_filtro_fecha or $this->con_filtro_general)
			{
				$txt .= '<tr>';
				$txt .= '<td colspan="'.$cntcols.'">';
				$txt .= '<table>' ;
				$txt .= '<tr>';
				$txt .= '<td style="border: none;">Filtros:</td>';
				$cpo = new Campo();
				if ( $this->con_filtro_fecha )
				{
					$cpo->pone_tipo( 'date' ) ;
					$txt .='<td>Fecha Desde:</td>';
					$cpo->pone_nombre( $this->prefijo_campo.'filtro_f_desde' ) ;
					$cpo->pone_valor( $this->filtro_f_desde ) ;
					$txt = $txt.$cpo->txtMostrarParaModificar() ;
					$txt .='<td>Fecha Hasta:</td>' ;
					$cpo->pone_nombre( $this->prefijo_campo.'filtro_f_hasta' ) ;
					$cpo->pone_valor( $this->filtro_f_hasta) ;
					$txt = $txt.$cpo->txtMostrarParaModificar() ;
					
				}
				if ( $this->con_filtro_general )
				{
					$cpo->pone_tipo( 'text' );
					$txt .='<td>Nombre:</td>';
					$cpo->pone_nombre( $this->prefijo_campo.'filtro_general' ) ;
					$cpo->pone_valor( $this->filtro_gral ) ;
					$txt = $txt.$cpo->txtMostrarParaModificar() ;
					
				}
				$txt .= '</td>';
				$txt .= '<td>' ;
				$txt .= '<input type="submit" value="Filtrar" name="'.$this->prefijo_campo.'_okFiltrar">' ;
				$txt .= '</td>';
				$txt .= '</tr>';
				$txt .='</table>';
				$txt .='</tr>';
			}
			$txt=$txt.'<tr>' ;
			for($i=0;$i<count($this->lista_campos_lectura);$i++)
				{
					$txt=$txt.'<th>';
          $txt=$txt.$this->lista_campos_lectura[$i]['descripcion'];
          $txt=$txt.'</th>';
				}
			$txt=$txt.'<th>Acción</th>';
			$txt=$txt.'</tr>';
			while ($this->existe == true and $reg=mysqli_fetch_array($this->registros,MYSQLI_NUM) )
				{
        	$txt=$txt.'<tr>';
			for($f=0;$f<count($reg);$f++)
						{
							$txt=$txt.'<td>';
		          $txt=$txt.$reg[$f];
		          $txt=$txt.'</td>';
						}
					$txt=$txt.'<td>' ;
					$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.'okVer=1">Ver</a>' ;
					foreach( $this->botones_extra_lista as $boton )
						{
							$txt=$txt.' <a href="'.$this->nombre_pagina.'?'.$this->prefijo_campo.'_Id='.$reg[0].'&'.$this->prefijo_campo.$accion['nombre'].'=1">'.$accion['texto'].'</a>' ;
						} 
					$txt=$txt.'</td>' ;
					$txt=$txt.'</tr>';
				}
			$txt=$txt.'</table>';
			return $txt;
		}

	public function mostrar_lista()
		{
			$hidden = '' ;
			$this->okSalir = $this->prefijo_campo.'_okSalir' ;
			$pagina = new Paginai($this->nombre_tabla ,$hidden.'<input type="submit" name="'.$this->okSalir.'" value="Salir" autofocus>') ;
			//
			// Muestra la cabecera
			$texto = $this->texto_mostrar_lista() ;
			$pagina->insertarCuerpo($texto);
			//
			// Grafica la página
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
		}
	public function pagina_lista_leer_eventos()
		{
		//
		// Varibales de accion
		//
		// Solicita releer
		$this->okReleer = $this->prefijo_campo.'_okReleer' ;
		$this->okSalir = $this->prefijo_campo.'_okSalir' ;
		//
		// Eventos
		//
		if ( isset($_POST[$this->okSalir] ) )
			{
			$this->ok_Salir() ;
			}
		elseif ( isset( $_POST[$this->okReleer] ) )
			{
				$this->mostrar_lista() ;
			}
		else
			{
				//
				// Eventos extra
				$linkextra = '' ;
				foreach ( $this->botones_extra_lista as $boton )
				{
					if ( isset($_POST[$this->prefijo_campo.$boton['name']]))
						$linkextra = $boton['link'] ;
				}
				if ( empty( $linkextra ) )					
					$this->mostrar_lista() ;
				else
					header('Location: '.$linkextra);
			}
		}
		protected function ok_salir()
		{
			header('Location: '.$this->pagina_url_anterior);

		}

}


?>
