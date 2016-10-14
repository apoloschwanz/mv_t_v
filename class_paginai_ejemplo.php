<?php
	$accion = $_SERVER['PHP_SELF'] ;
	$boton = "OK!!!";
	require_once 'clases_base.php' ;
	require_once 'class_paginai.php' ; 
	$pagina = new Paginai('Prueba de Clase','<input type="submit" name="submitok" value="'.$boton.'" autofocus>') ;
	$pagina->graficar_c_form($accion);
?>
