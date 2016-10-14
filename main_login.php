<!DOCTYPE html>
<html>
<head>
<title>Identificarse</title>
<link rel= "stylesheet" href= estilos.css>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
	require 'clases_base.php' ;
	require 'clases_anexo.php' ;
	require 'clases_crono.php' ;
	//
	// Variables
	//
	$pagina = 'checklogin.php' ;
	$boton = 'Ingresar' ;
	//
	// Instancia clases
	//
	$pagina1=new Pagina('Ingreso','</th><th colspan="1"><input type="submit" value="'.$boton.'">');
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
	
	
	//
	// Datos de la Persona
	//
	$txt = 'Mail:</td><td><input type="text" name="m_mail" >';
	$pagina1->insertarCuerpo($txt);
	$txt = 'Clave:</td><td><input type="password" name="m_clave" >';
	$pagina1->insertarCuerpo($txt);
	$pagina1->graficar_cuerpo();
	$pagina1->graficar_pie();
	?>
</form>
</body>
</html>
