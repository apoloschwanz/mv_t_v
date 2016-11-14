<?php
class paginaj {
	protected $titulo ;
	protected $borde ;
	protected $clase_tabladet ;
	private $cuerpo;
	protected $pie;
	protected $accion ;
	public function graficar ()
	{
		require 'class_paginaj.view.php' ;
	}
	public function graficar_cuerpo()
	{
		if ( $this->borde == true )
			$this->clase_tabladet = 'tabladet' ;
		else
			$this->clase_tabladet = 'tabladetnb' ;
		$this->cuerpo->graficar();
	}
	public function graficar_c_form($accion = NULL )
	{
		if( ! $accion )
			$this->accion = $_SERVER['PHP_SELF'] ;
		else
			$this->accion = $accion ;
		require 'class_paginaj.form.view.php' ;
	}
}
?>
