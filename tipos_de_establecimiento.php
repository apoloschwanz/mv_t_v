<?php
	//
	// Control Sesion
	require_once 'controlsesion.php' ;
	//
	// Inclusion de clases 
	require_once 'class_paginai.php' ;
	//
	// Clase de la entidad
	require_once 'clase_tipos_de_establecimiento.php' ;
	//
	// Instancia Entidad
	$pagina = new tipos_de_establecimiento() ;
	
	//
	// Mustra Pagina Web de la entidad
	$pagina->mostrar_pagina_lista();
	
	
?>
