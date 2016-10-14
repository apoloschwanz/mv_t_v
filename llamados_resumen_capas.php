<?php
	//
	// Control Sesion
	require_once 'controlsesion.php' ;
	//
	// Inclusion de clases 
	//require_once 'clases_base.php' ;
	//require_once 'clases_anexo.php' ;
	//require_once 'clases_crono.php' ;
	require_once 'class_paginai.php' ;
	//
	// Clase de la entidad
	require_once 'clases_llamados.php' ;
	//
	// Instancia Entidad
	$pagina = new resumen_capas_p_llamados() ;
	
	//
	// Mustra Pagina Web de la entidad
	$pagina->mostrar_pagina_lista();
	
	
?>
