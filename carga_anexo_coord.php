<?php
	require_once 'controlsesion.php' ; 
	
	if ( isset($_POST['submitok']) )
		{
		carga_anexo_upd() ;
		}
	else
		{
		carga_anexo() ;
		}
?>


<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- Carga Anexo ------------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->


<?php
	function carga_anexo()
		{
?>
<!DOCTYPE html>
<html>
<head>
<title>Carga Anexo</title>
<link rel= "stylesheet" href= estilos.css>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
	require_once 'clases_base.php' ;
	require_once 'clases_anexo.php' ;
	
	//
	// Lee la Capacitación
	//
	$cn = $_REQUEST['m_nro_capa'];
	$an = $_REQUEST['m_nro_anexo'];
	$Anx = new Anexo() ;
	$Anx->Set_id($an);
	$Anx->Set_Capa_Nro($cn);
	//
	//	Si no existe el anexo.... agregarlo
	//
	//  Si existe leerlo.
	//
	//  Mostrarlo.........( con if pa que no lo vuelva a leer ? )
	//
	//  Aceptar Datos y pasar a pagina de validacion.
	//
	$Anx->Actualizar_Coord();
	if ( $Anx->Error == true )
		{
		$boton = "OK" ;
		//by DZ 2016-09-05 $pagina = "sel_capa.php" ;
		$pagina = "capacitaciones_asignadas_del_coordinador.php" ;
		//$pagina = "prueba_carga_anexo.php" ;
		}
		else
		{
		$boton = "Confirmar" ;
		$pagina = $_SERVER['PHP_SELF'] ; // by ZD_2015_12_04 "carga_anexo_upd.php" ;
		}
	// by ZD_2016_05_23 $pagina1=new Pagina('Carga Anexo','<input type="submit" name="submitok" value="'.$boton.'" autofocus>');
	$pagina1=new Pagina('Carga Anexo','<input type="submit" name="submitok" value="'.$boton.'" >');
	?>

<form method="post" action="<?php echo $pagina; ?>"> 
	<?php
	//
	// Dibuja Pagina
	//
	$pagina1->graficar_cabecera();
	//
	// Variables Ocultas
	//
	echo '<tr><td>' ;
	echo '<input type="hidden" name="m_nro_anexo" '.'value="'.$an.'">' ;
	echo '<input type="hidden" name="m_nro_capa" '.'value="'.$cn.'">' ;
	echo '</td></tr>' ;
	//
	// Anexo
	// 
	if ( $Anx->Error == true )
		{
		$Anx->Mostrar_Error() ;
		}
	else
		{
			$Anx->Mostrar_Coord();
		}
	$pagina1->graficar_pie();
	?>
</form>
</body>
</html>

<?php
	}
?>


<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- Actualizacion ----------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->



<?php
	function carga_anexo_upd()
		{
?>

<!DOCTYPE html>
<html>
<head>
<title>Carga Anexo</title>
<link rel= "stylesheet" href= estilos.css>

</head>
<body>
<?php
	require_once 'clases_base.php' ;
	require_once 'clases_anexo.php' ;
	
	//
	// Lee la Capacitación
	//
	$an = $_REQUEST['m_nro_anexo'];
	$Anx = new Anexo() ;
	$Anx->Set_id($an);
	
	//
	// Graba los datos
	//
	$Anx->Guardar();
	if ( $Anx->Error == true )
		{
		$boton = "Volver" ;
		$pagina = "marca_hecha_coord.php" ;
		}
		else
		{
		$boton = "Ok" ;
		$pagina = "capacitaciones_asignadas_del_coordinador.php" ;
		}
	$pagina1=new Pagina('Carga Anexo','<input type="submit" value="'.$boton.'" autofocus>');
	?>

<form method="post" action="<?php echo $pagina; ?>"> 
	<?php
	//
	// Dibuja Pagina
	//
	$pagina1->graficar_cabecera();
	if ( $Anx->Error == true )
		{
		$Anx->Mostrar_Error() ;
		}
	else
		{
			echo '<tr><td> Anexo Grabado </td></tr>' ;
		}
	$pagina1->graficar_pie();
	?>
</form>
</body>
</html>

<?php
	}
?>


