<?php
	require_once 'controlsesion.php' ; 
	
	if ( isset($_POST['agregaprofok']) )
		{
		carga_prof_upd() ;
		}
	elseif ( isset($_POST['agregacordook']) )
		{
		carga_cordo_upd() ;
		}
	elseif ( isset($_POST['agregasacaok']) )
		{
		carga_saca_upd() ;
		}
	elseif ( isset($_POST['agregasaca']) )
		{
		carga_saca() ;
		}
	elseif ( isset($_GET['bajasacaok']) )
		{
		baja_saca_upd() ;
		}
	elseif ( isset($_GET['bajadocenteok']) )
		{
		baja_docente_upd() ;
		}
	elseif ( isset($_GET['bajacoordinadorok']) )
		{
		baja_coordinador_upd() ;
		}
	elseif ( isset($_POST['agregaprof']) )
		{
		carga_prof() ;
		}
	elseif ( isset($_POST['agregacordo']) )
		{
		carga_cordo() ;
		}
	elseif ( isset($_POST['submitok']) )
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
	$Anx->Actualizar();
	if ( $Anx->Error == true )
		{
		$boton = "OK" ;
		$pagina = "sel_capa.php" ;
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
			$Anx->Mostrar();
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
		$pagina = "carga_anexo.php" ;
		}
		else
		{
		$boton = "Ok" ;
		$pagina = "sel_capa.php" ;
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


<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- Carga Saca -------------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->


<?php
	function carga_saca()
		{
?>
<!DOCTYPE html>
<html>
<head>
<title>Agrega Saca</title>
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
	$Anx->Guardar() ;
	if ( $Anx->Error == true )
		{
		$boton = "Volver" ;
		$pagina = "carga_anexo.php" ;
		$pagina1=new Pagina('Carga Anexo','<input type="submit" value="'.$boton.'" autofocus>');
		}
		else
		{
		$boton = "Confirmar" ;
		$pagina = $_SERVER['PHP_SELF'] ;
		$pagina1=new Pagina('Agrega Saca','<input type="submit" value="Cancelar"> <input type="submit" name="agregasacaok" value="'.$boton.'" autofocus>');
		}
	//
	//	Mustra Pantalla para Agregar Coordinador
	//
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
	if ( $Anx->Error == false )
		{
		//
		// Lista de coordinadores
		//
		$sacas = new Sacas() ;
		$lsacas = $sacas->Obtener_Lista() ;
		$cel = new Celda() ;
		$cel->Mostrar_Desplegable( 'Agrega_SacaId', '' , $lsacas , 0, 1 ,true ) ;
		$pagina1->graficar_pie();
		}
	?>
</form>
</body>
</html>
<?php
	}
?>



<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- Agrega Saca UPD --------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->



<?php
	function carga_saca_upd()
		{
?>

<!DOCTYPE html>
<html>
<head>
<title>Carga Saca </title>
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
	$cn = $_REQUEST['m_nro_capa'];
	$Anx = new Anexo() ;
	$Anx->Set_id($an);
	//
	// Graba los datos
	//
	$IdSaca = $_POST['Agrega_SacaId'] ;
	$Anx->Agrega_Saca($IdSaca);
	$boton = "Ok" ;
	$pagina =  $_SERVER['PHP_SELF'] ;
	$pagina1=new Pagina('Carga Anexo - Agrega Saca','<input type="submit" value="'.$boton.'" autofocus>');
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
	if ( $Anx->Error == true )
		{
		$Anx->Mostrar_Error() ;
		}
	else
		{
			echo '<tr><td> Saca Agregada Id='.$IdSaca.'</td></tr>' ;
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
<!-- Baja Saca UPD ----------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->



<?php
	function baja_saca_upd()
		{
?>

<!DOCTYPE html>
<html>
<head>
<title>Baja Saca </title>
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
	$cn = $_REQUEST['m_nro_capa'];
	$Anx = new Anexo() ;
	$Anx->Set_id($an);
	//
	// Graba los datos
	//
	$IdSaca = $_REQUEST['Baja_SacaId'] ;
	$Anx->Baja_Saca($IdSaca);
	$boton = "Ok" ;
	$pagina =  $_SERVER['PHP_SELF'] ;
	$pagina1=new Pagina('Carga Anexo - Baja Saca','<input type="submit" value="'.$boton.'" autofocus>');
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
	if ( $Anx->Error == true )
		{
		$Anx->Mostrar_Error() ;
		}
	else
		{
			echo '<tr><td> Saca Eliminada Id='.$IdSaca.'</td></tr>' ;
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
<!-- Agrega Cordo ------------------------------------------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->


<?php
	function carga_cordo()
		{
?>
<!DOCTYPE html>
<html>
<head>
<title>Agrega Coordinador</title>
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
	$Anx->Guardar() ;
	if ( $Anx->Error == true )
		{
		$boton = "Volver" ;
		$pagina = "carga_anexo.php" ;
		$pagina1=new Pagina('Carga Anexo - Error','<input type="submit" value="'.$boton.'" autofocus>');
		}
		else
		{
		$boton = "Confirmar" ;
		$pagina = $_SERVER['PHP_SELF'] ;
		$pagina1=new Pagina('Agrega Coordinador','<input type="submit" value="Cancelar"> <input type="submit" name="agregacordook" value="'.$boton.'" autofocus>');
		}
	//
	//	Mustra Pantalla para Agregar Coordinador
	//
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
	if ( $Anx->Error == false )
		{
		//
		// Lista de coordinadores
		//
		$cordis = new Cordos() ;
		$lcordis = $cordis->Obtener_Lista() ;
		$cel = new Celda() ;
		$cel->Mostrar_Desplegable( 'Agrega_CoordId', '' , $lcordis , 0, 1 ,true ) ;
		$pagina1->graficar_pie();
		}
	?>
</form>
</body>
</html>

<?php
	}
?>

<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- Agrega Coordinador UPD -------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->



<?php
	function carga_cordo_upd()
		{
?>

<!DOCTYPE html>
<html>
<head>
<title>Carga Anexo </title>
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
	$cn = $_REQUEST['m_nro_capa'];
	$Anx = new Anexo() ;
	$Anx->Set_id($an);
	//
	// Graba los datos
	//
	$IdCordo = $_POST['Agrega_CoordId'] ;
	$Anx->Agrega_Cordo($IdCordo);
	$boton = "Ok" ;
	$pagina =  $_SERVER['PHP_SELF'] ;
	$pagina1=new Pagina('Carga Anexo - Agrega Coordinador','<input type="submit" value="'.$boton.'" autofocus>');
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
	if ( $Anx->Error == true )
		{
		$Anx->Mostrar_Error() ;
		}
	else
		{
			echo '<tr><td> Coordinador Agregado Id='.$IdCordo.'</td></tr>' ;
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
<!-- Baja Coordinador UPD ---------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->



<?php
	function baja_coordinador_upd()
		{
?>

<!DOCTYPE html>
<html>
<head>
<title>Carga Anexo </title>
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
	$cn = $_REQUEST['m_nro_capa'];
	$Anx = new Anexo() ;
	$Anx->Set_id($an);
	//
	// Graba los datos
	//
	$IdCordo = $_REQUEST['Baja_CoordinadorId'] ;
	$Anx->Baja_Cordo($IdCordo);
	$boton = "Ok" ;
	$pagina =  $_SERVER['PHP_SELF'] ;
	$pagina1=new Pagina('Carga Anexo - Baja Coordinador','<input type="submit" value="'.$boton.'" autofocus>');
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
	if ( $Anx->Error == true )
		{
		$Anx->Mostrar_Error() ;
		}
	else
		{
			echo '<tr><td> Coordinador Eliminado Id='.$IdCordo.'</td></tr>' ;
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
<!-- Agrega Docente ---------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->


<?php
	function carga_prof()
		{
?>
<!DOCTYPE html>
<html>
<head>
<title>Agrega Docente</title>
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
	$Anx->Guardar();
	if ( $Anx->Error == true )
		{
		$boton = "Volver" ;
		$pagina = "carga_anexo.php" ;
		$pagina1=new Pagina('Carga Anexo','<input type="submit" value="'.$boton.'" autofocus>');
		}
		else
		{
		//
		//	Mustra Pantalla para Agregar Docente
		//
		$boton = "Confirmar" ;
		$pagina = $_SERVER['PHP_SELF'] ;
		$pagina1=new Pagina('Agrega Docente','<input type="submit" value="Cancelar"> <input type="submit" name="agregaprofok" value="'.$boton.'" autofocus>');		
		}
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
	if ( $Anx->Error == false )
		{
		//
		// Lista de docentes
		$dtes = new Docente() ;
		$ldtes = $dtes->Obtener_Lista() ;
		$cel = new Celda() ;
		$cel->Mostrar_Desplegable( 'Agrega_ProfId', '' , $ldtes , 0, 1, true ) ;
		$pagina1->graficar_pie();
		}
	?>
</form>
</body>
</html>

<?php
	}
?>


<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- Agrega Docente UPD ------------------------------------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->



<?php
	function carga_prof_upd()
		{
?>

<!DOCTYPE html>
<html>
<head>
<title>Carga Anexo </title>
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
	$cn = $_REQUEST['m_nro_capa'];
	$Anx = new Anexo() ;
	$Anx->Set_id($an);
	//
	// Graba los datos
	//
	$IdProf = $_POST['Agrega_ProfId'] ;
	$Anx->Agrega_Prof($IdProf);
	$boton = "Ok" ;
	$pagina =  $_SERVER['PHP_SELF'] ;
	$pagina1=new Pagina('Carga Anexo - Agrega Prof','<input type="submit" value="'.$boton.'" autofocus>');
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
	if ( $Anx->Error == true )
		{
		$Anx->Mostrar_Error() ;
		}
	else
		{
			echo '<tr><td> Docente Agregado Id='.$IdProf.'</td></tr>' ;
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
<!-- Baja Docente UPD -------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->



<?php
	function baja_docente_upd()
		{
?>

<!DOCTYPE html>
<html>
<head>
<title>Carga Anexo </title>
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
	$cn = $_REQUEST['m_nro_capa'];
	$Anx = new Anexo() ;
	$Anx->Set_id($an);
	//
	// Graba los datos
	//
	$IdProf = $_REQUEST['Baja_DocenteId'] ;
	$Anx->Baja_Prof($IdProf);
	$boton = "Ok" ;
	$pagina =  $_SERVER['PHP_SELF'] ;
	$pagina1=new Pagina('Carga Anexo - Baja Docente','<input type="submit" value="'.$boton.'" autofocus>');
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
	if ( $Anx->Error == true )
		{
		$Anx->Mostrar_Error() ;
		}
	else
		{
			echo '<tr><td> Docente Borrado Id='.$IdProf.'</td></tr>' ;
		}
	$pagina1->graficar_pie();
	?>
</form>
</body>
</html>

<?php
	}
?>
