<?php
	require_once 'controlsesion.php' ; 
	require_once 'clases_base.php' ;
	require_once 'clases_anexo.php' ;
	require_once 'clase_relacionj.php' ;
	require_once 'clase_turno_dia.php' ;	
	require_once 'clase_turnos_por_dia_del_docente.php';
	require_once 'clase_pagina_abm_rel.php' ;
	//
	// Datos del Docente
	//
	$uid = $_SESSION['uid'] ;
	$Docente = new Docente() ;
	$Docente->Leer_x_mail($uid);
	$reg_dte = $Docente->Obtener_Registro() ;
	if ( $Docente->existe == false )
			{
			echo 'Docente_Nro='.$reg_dte['Docente_Nro'] ;
			die( 'No hay docente registrados con el mail '.$uid) ; 
			}
	else
	$docente_nro = $reg_dte['Docente_Nro'] ;
	//
	// Armado de la Página
	//
	$pagina = new Pagina_abm_rel() ;
	$pagina->pone_relacion( new Turnos_por_dia_del_docente() ) ;
	$pagina->pone_url_anterior( 'datos_docente.php' ) ;
	$pagina->pone_titulo( 'Turnos del Docente' ) ;
	$pagina->pone_id_lado_uno($docente_nro);
	$pagina->leer_eventos() ;
?>
