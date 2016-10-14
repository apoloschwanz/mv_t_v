<?php

	// ////////////////////////////
	// Alta de Llamado a un colegio
	// ////////////////////////////
	//
	// Clase: llamado 
	// Archivo clase: clases_llamados.php

	//
	// Inclusiones
	//
	require_once 'controlsesion.php' ; 		// Control de usuario, etc.
	require_once 'class_paginai.php' ;		// Armado de la pagina html.
	require_once 'clases_llamados.php' ;	// Clases relativas a llamados.

	//
	// Obetnción ID
	//
	// viene de llamados_resumen_capas.php y recibe el 
	// código único de establecimiento del collegio a llamar
	$ts_nombre_id = 'llamados_CUE_id' ;
	if( isset( $_GET[$ts_nombre_id] ) )
		$ts_CUE_id = $_GET[$ts_nombre_id] ;
	elseif( isset( $_POST[$ts_nombre_id] ) )
		$ts_CUE_id = $_POST[$ts_nombre_id] ;
	else
		$ts_CUE_id = $_POST['Falta CUE'] ;
	//
	//
	// Instancia Llamado
	$entidad = new llamado() ;
	//
	// Pagina a la que vuelve
	$entidad->pagina_pone_url_anterior('llamados_resumen_capas.php');
	//
	// Pone el CUE
	$entidad->set_id_lado_uno($ts_CUE_id);
	//
	// Mustra Pagina Web de la entidad
	$entidad->mostrar_pagina_alta();

?>
