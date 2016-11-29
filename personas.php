<?php
	//
	// Control Sesion
	require_once 'controlsesion.php' ;
	//
	// Inclusion de clases 
	require_once 'class_paginai.php' ;
	//
	// Clase de la entidad
	require_once 'clase_personas.php' ;
	//
	// Instancia Entidad
	$pagina = new persona() ;
	
	//
	// Mustra Pagina Web de la entidad
	$pagina->mostrar_pagina_lista();
	
	
?>
