<?php

	require_once 'controlsesion.php' ; 
	require_once 'clases_base.php' ;
	require_once 'clases_anexo.php' ;
	require_once 'clases_crono.php' ;
	require_once 'class_paginai.php' ;
	require_once 'clase_pagina_abm_rel.php' ;
	require_once 'clase_relacionj.php' ;	
	require_once 'clase_docente_del_crono.php' ;
	require_once 'clase_docente_para_asignar.php' ;
	
$Pagina = new Pagina_abm_rel() ;
$Pagina->pone_relacion( new Docente_del_crono() ) ;
$Pagina->pone_url_anterior( 'crono.php' ) ;
$Pagina->pone_titulo( 'Asignacion de Docentes' ) ;
$Pagina->leer_eventos() ;

 ?>
