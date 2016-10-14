<?php
	//
	// Control Sesion
	require_once 'controlsesion.php' ;
	//
	// Inclusion de clases 
	require_once 'class_paginai.php' ;
	//
	// Clase de la entidad
	require_once 'clase_escuelas_general.php' ;
	//
	// Instancia Entidad
	$pagina = new escuelas_general() ;
	
	//
	// Mustra Pagina Web de la entidad
	$pagina->mostrar_pagina_lista();
	
	
?>
