<?php
	//
	// Inclusion de clases
	require_once 'controlsesion.php' ; 
	require_once 'clases_base.php' ;
	require_once 'clases_anexo.php' ;
	require_once 'clases_crono.php' ;
	require_once 'class_paginai.php' ;
	//
	// Clase de la entidad
	require_once 'clase_coordinaciones_asignadas_totales.php' ;
	//
	// Instancia Entidad
	$pagina = new Coordinaciones_Asignadas_Totales() ;
	
	//
	// Mustra Pagina Web de la entidad
	$pagina->mostrar_pagina_lista();
	
	
?>
