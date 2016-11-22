<?php
class paginaj {
	protected $titulo ;
	protected $borde ;
	private $cuerpo;
	protected $pie;
	protected $accion ;
	protected $valores_ocultos ;
	protected function clase_tabladet() 
	{
		if ( $this->borde == true )
			$clase_tabladet = 'tabladet' ;
		else
			$clase_tabladet = 'tabladetnb' ;
		return $clase_tabladet ;
	}
	public function sinborde()
	{
		$this->borde = false ;
	}
	protected function pone_valor_oculto( $nombre,$valor )
	{	$tf_existe = false ;
		foreach ( $this->valores_ocultos as $valor )
		{
			if( $valor->nombre() == $nombre )
			{
				$this->valor = $valor ;
				$tf_existe = true ;
			}
		}
		if ( ! $tf_existe )
		{
			$this->valores_ocultos[] = new Campo($nombre,$valor,'hidden') ;
		}
		
	}
	protected function graficar_valores_ocultos()
	{
		$txt = NULL ;
		echo '<br> estos son los valores ocultos<br>';
		var_dump( $this->valores_ocultos ) ;
		echo '<br> fin de los valores ocultos, que ahora estan siendo mostrados <br>';
		$txt = ' <br> esta es la graficacion de valores ocultos <br>' ;
		foreach ($this->valores_ocultos as $valor )
		{
			$txt.= '<br> nombre : ' .$valor->nombre(). ' contiene el dato: '.$valor->valor() ;
		}
		return $txt ;
	}
	public function __construct($titulo = NULL,$pie = NULL)
	{
		$this->titulo = $titulo ;
		$this->pie = $pie ;
		$this->cuerpo=new Cuerpo();
		$this->borde = true ;
		$this->valores_ocultos = array();
	}
	public function graficar ()
	{
		require 'class_paginaj.view.php' ;
	}
	public function graficar_cuerpo()
	{
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
	public function insertarCuerpo($texto)
	{
		$this->cuerpo->insertarParrafo($texto);
	}
}
?>
