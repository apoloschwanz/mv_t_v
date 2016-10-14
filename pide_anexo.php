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
	require_once 'clase_programa.php' ;
	
	//
	// Lee la Capacitación
	//
	$cap= new Capa() ;
	$cn = $_REQUEST['m_nro_capa'];
	$cap->Set_id($cn);
	$cap->Leer();
	if ( $cap->existe == true )
		{
		$prox_pag = "carga_anexo.php" ;
		$boton = "Cargar" ;
		}
		else
		{
		$prox_pag = "sel_capa.php" ;
		$boton = "Ok";
		}
	 $pagina1=new Pagina('Carga Anexo','<input type="submit" value="'.$boton.'">');
	?>

<form method="post" action="<?php echo $prox_pag; ?>"> 
	<?php
	//
	//
	// Dibuja Pagina
	//
	$pagina1->graficar_cabecera();
	if ( $cap->existe == true )
		{
			$cap->Mostrar();
			echo '<tr><td> Ingrese número de Anexo </td><td>' ;
			echo '<input type="text" name="m_nro_anexo" autofocus>' ; 
			echo '</td></tr>' ;
			echo '<tr><td>  </td><td>' ;
			echo '<input type="hidden" name="m_nro_capa" value="'.$cn.'">' ; 
			echo '</td></tr>' ;
		} 
		else
		{
		echo '<tr><td>' ;
		echo '<h3> El código de capacitación no existe en la base de datos. </h3>' ;
		echo '</td></tr>' ;
		}
	$pagina1->graficar_pie();

	?>
</form>
</body>
</html>
