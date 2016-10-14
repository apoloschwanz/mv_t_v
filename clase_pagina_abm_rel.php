<?php

class Pagina_abm_rel {
	protected $id_lado_uno ;
	protected $relacion ;
	protected $url_anterior ;
	protected $titulo ;
	public function pone_id_lado_uno( $idl1 )
	{
		$this->id_lado_uno = $idl1 ;
	}
	public function pone_titulo( $tit )
	{
		$this->titulo = $tit ;
	}
	public function pone_relacion( $rel )
	{
	//
	// $rel Tipo relacion i
	$this->relacion = $rel ; 
	}
	public function pone_url_anterior($url)
	{
		$this->url_anterior = $url ;
	}
	public function leer_eventos()
	{
		//
		// Busca Id del lado uno de la relacion
	if ( empty( $this->id_lado_uno ) )
	{
		//
		// Si no esta setado por la funcion pone_id_lado_uno
		//
		// Lo levanta del post o get
		$nomidl1 = $this->relacion->Nombre_Post_Get_Id_Lado_Uno() ;
		if ( isset ($_REQUEST[$nomidl1] ) )
		{
			$this->id_lado_uno = $_REQUEST[$nomidl1]  ;
		}
		else die('Id lado uno no se encuentra') ;
	}
	$idl1 = $this->id_lado_uno ;
	$this->relacion->set_id_lado_uno($idl1);
	//
	// Varibales de accion
	//
	// Solicita agregar detalles
	$okAgregarDetalle = $this->relacion->obtiene_prefijo_campo().'_okAgregar' ;
	//
	// Solicita borrar detalle
	$okBorrarDetalle = $this->relacion->obtiene_prefijo_campo().'_okBorrar' ;
	//
	// Selecciono detalles para agregar
	$okseleccion = $this->relacion->obtiene_prefijo_campo().'_okSelected'; 
	//
	// Solicita modifcar relacion
	$okmodifica_rel = $this->relacion->obtiene_prefijo_campo().'_okModificar';
	//
	// Verifica que exista el padre
	if ( ! $this->relacion->existe_lado_uno() ) die( 'No se encuentra registro lado uno con el id'.$idl1 );
	//
	// Eventos
	//
	if ( isset($_POST['okSalir'] ) )
		{
		$this->ok_Salir() ;
		}
	elseif ( isset( $_POST[$okseleccion] ) )
		{
			$this->relacion->agrega_seleccion() ;
			if( $this->relacion->hay_error() == true ) die ( $this->relacion->textoError() ) ;
			else $this->mostrar_abm_relacion() ;
		}
	elseif ( isset( $_POST[$okAgregarDetalle] ) )
		{
			$this->agregar_detalle() ;
		}
	elseif ( isset( $_POST[$okBorrarDetalle] ) )
		{
			$this->relacion->borrar_seleccion() ;
			if( $this->relacion->hay_error() == true ) die ( $this->relacion->textoError() ) ;
			else $this->mostrar_abm_relacion() ;
		}
	elseif ( isset( $_POST[$okmodifica_rel] ) )
		{
			$this->modifica_datos_relacion() ;
		}
	else
		{
			$this->mostrar_abm_relacion() ;
		}
	}
	//
	// Pagina Base
	//
	protected function modifica_datos_relacion()
	{
		$idl1 = $this->relacion->devuelve_id_lado_uno();
		$nomidl1 = $this->relacion->Nombre_Post_Get_Id_Lado_Uno() ;
		$hidden = '<input type="hidden" name="'.$nomidl1.'" value="'.$idl1.'" > ' ;
		$pagina = new Paginai($this->titulo,$hidden.'<input type="submit" name="okSalir" value="Salir" autofocus>') ;
		//
		// Muestra la cabecera
		$texto = $this->relacion->texto_Ver_Lado_Uno();
		$pagina->insertarCuerpo($texto);
		//
		// Muestra detalle 
		$texto = 'Funcion no habilitada ' ; // $this->relacion->texto_actualizar_datos_relacion();
		$pagina->insertarCuerpo($texto);
		//
		// Grafica la página
		$pagina->graficar_c_form($_SERVER['PHP_SELF']);
	}
	protected function mostrar_abm_relacion()
	{
		$idl1 = $this->relacion->devuelve_id_lado_uno();
		$nomidl1 = $this->relacion->Nombre_Post_Get_Id_Lado_Uno() ;
		$hidden = '<input type="hidden" name="'.$nomidl1.'" value="'.$idl1.'" > ' ;
		$pagina = new Paginai($this->titulo,$hidden.'<input type="submit" name="okSalir" value="Salir" autofocus>') ;
		//
		// Muestra la cabecera
		$texto = $this->relacion->texto_Ver_Lado_Uno();
		$pagina->insertarCuerpo($texto);
		//
		// Muestra detalle 
		$texto = $this->relacion->texto_actualizar_detalle();
		$pagina->insertarCuerpo($texto);
		//
		// Grafica la página
		$pagina->graficar_c_form($_SERVER['PHP_SELF']);
	}

	protected function agregar_detalle()
	{
		//
		// Levanta Datos del Id
		$idl1 = $this->relacion->devuelve_id_lado_uno();
		$nomidl1 = $this->relacion->Nombre_Post_Get_Id_Lado_Uno() ;
		$hidden = '<input type="hidden" name="'.$nomidl1.'" value="'.$idl1.'" > ' ;
		$pagina = new Paginai($this->titulo,$hidden.'<input type="submit" name="okSalir" value="Salir" autofocus>') ;
		//
		// Muestra la cabecera
		$texto = $this->relacion->texto_Ver_Lado_Uno();
		$pagina->insertarCuerpo($texto);
		//
		// Muestra seleccion de detalle
		$texto = $this->relacion->texto_Mostrar_Seleccion();
		$pagina->insertarCuerpo($texto);
		//
		// Grafica la página
		$pagina->graficar_c_form($_SERVER['PHP_SELF']);
	}
	protected function ok_salir()
	{
		$idl1 = $this->relacion->devuelve_id_lado_uno();
		$nomidl1 = $this->relacion->Nombre_Post_Get_Id_Lado_Uno() ;
		$hidden = '<input type="hidden" name="'.$nomidl1.'" value="'.$idl1.'" > ' ;
		$pagina = new Paginai($this->titulo,$hidden.'<input type="submit" value="OK" autofocus>') ;
		$texto = 'Edicion Finalizada';
		$pagina->insertarCuerpo($texto);
		$pagina->graficar_c_form($this->url_anterior);
		//
		// // Vuelve al inicio
		// header($this->url_anterior);

	}
		

}

?>
