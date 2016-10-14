<?php
	require_once 'controlsesion.php' ; 
	require_once 'clases_base.php' ;
	require_once 'clase_entidadi.php' ;
	require_once 'clase_docente.php' ;
	//
	// Datos del Docente
	//
	$uid = $_SESSION['uid'] ;
	$Docente = new Docente() ;
	$Docente->Leer_x_mail($uid);
	$reg_dte = $Docente->Obtener_Registro() ;
	if ( $Docente->existe == false )
			{
			die( 'No hay docente registrados con el mail '.$uid) ; 
			}
	//
	// Armado de la Página
	//
	$Docente->pagina_pone_url_anterior( 'accueil.php' ) ;
	$Docente->pagina_pone_titulo( 'Datos del Docente' ) ;
	$Docente->pagina_edicion_leer_eventos() ;
?>
