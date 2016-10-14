<?php

	require_once 'controlsesion.php' ; 
	require_once 'clases_base.php' ;
	require_once 'clases_anexo.php' ;
	require_once 'clases_crono.php' ;
	require_once 'class_paginai.php' ;
	require_once 'clase_pagina_abm_rel.php' ;
	require_once 'clase_relacionj.php' ;	
	//
	// Relacion Coordinador Crono (relacionj)
	require_once 'clase_coordinador_del_crono.php' ;
		//
		// Lado Uno de la Relacion (entidadi)
		require_once 'clase_coordinador_para_asignar.php' ;
	
	
	//
	// Prueba
	// var_dump( $_REQUEST ) ;
	//echo '<br> Procesa Id: '.$_REQUEST['m_crono__Id'].'<br>' ;
	//$clase_a_probar = new Coordinador_para_asignar();
	//echo $clase_a_probar->probar($_REQUEST['m_crono__Id']);
	//
	// Fin Prueba
	//die('Esto es solo una prueba') ;
	
	//
	// Pagina
	$Pagina = new Pagina_abm_rel() ;
	//
	// Coordinador - Crono
	$Pagina->pone_relacion( new Coordinador_del_crono() ) ;
	$Pagina->pone_url_anterior( 'crono.php' ) ;
	$Pagina->pone_titulo( 'Asignacion de Coordinadores' ) ;
	$Pagina->leer_eventos() ;

 ?>
