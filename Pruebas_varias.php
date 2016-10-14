<?php
	require_once 'db.php';
	require_once 'clase_entidad.php' ;
	require_once 'clase_entidadi.php' ;
	require_once 'clase_docente.php';
	require_once 'clases_base.php';
	require_once 'class_paginai.php' ;
	require_once 'clase_docente_para_asignar.php ';
	$pagina = new Paginai('Prueba','<input type="submit" value="Refrescar" name="okSubmit">');
	$pagina->insertarCuerpo('Prueba');
	//
	// Prueba de clase_docente_para_asignar ;
	$pagina->insertarCuerpo('Docentes para asignar - Docentes Ocupados:');
	$obj = new Docente_para_asignar() ;
	$Crono_Id = 21368 ;
	//$txt = $obj->probar($Crono_Id);
	$dt = new DateTime();
	$txt = $dt->format('Y-m-d H:i:s') ;

	$pagina->insertarCuerpo($txt);
	
	$txt = ' Prueba de Insersion de Docente ' ;
	$pagina->insertarCuerpo($txt);
	//
	// Intenta insertar docente
	
	$dte = new Docente();
	$id_nuevo = $dte->Agrega_Docente('toulemonde'.substr(md5(time()),0,6).'@gmail.com','Monsieur Toulemonde','1111-4444',310);
	
	
	
	$txt = ' El id generado es '.$id_nuevo ;
	$pagina->insertarCuerpo($txt);
	
	
	$pagina->graficar_c_form($_SERVER['PHP_SELF']);
?>
