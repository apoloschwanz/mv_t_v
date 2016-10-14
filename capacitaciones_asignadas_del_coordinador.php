<?php

	require_once 'controlsesion.php' ; 
	require_once 'clases_base.php' ;
	require_once 'clases_anexo.php' ;
	require_once 'clases_crono.php' ;
	require_once 'class_paginai.php' ;
	require_once 'clase_pagina_abm_rel_cap_coord.php' ;
	require_once 'clase_relacionj.php' ;	
	require_once 'clase_capacitaciones.php';
	require_once 'clase_capacitaciones_asignadas_del_coordinador.php' ;
	require_once 'clase_coordinador_para_asignar.php' ;
	require_once 'clase_estados_asignacion_capas.php';
	//
	// Datos de la edicion
	//
	$edactual = new Edicion_Actual() ;
	if ( $edactual->existe )
		{
		$edcn = $edactual->Edicion_Actual_Nro ;
		}
	else 
		{
		die( 'Problemas al buscar edicion actual') ;
		}
	//
	// Datos del Coordinador
	//
	$uid = $_SESSION['uid'] ;
	$Cordo = new Coordinador_para_asignar() ;
	$Cordo->Leer_x_mail($uid);
	$reg_cdo = $Cordo->Obtener_Registro() ;
	if ( $Cordo->existe == false )
			{
			echo 'Coordinador_Id ='.$reg_cdo['Coordinador_Id'] ;
			die( 'No hay coordinadores registrados con el mail '.$uid) ; 
			}
	else
	$cordo_nro = $reg_cdo['Coordinador_Id'] ;
	//
	// Armado de la Página
	//
	$pagina = new Pagina_abm_rel_cap_coord() ;
	$pagina->pone_relacion( new Capacitaciones_Asignadas_del_Coordinador() ) ;
	$pagina->pone_url_anterior( 'accueil.php' ) ;
	$pagina->pone_titulo( 'Coordinaciones Asignadas' ) ;
	$pagina->pone_id_lado_uno($cordo_nro);
	$pagina->leer_eventos() ;
?>
