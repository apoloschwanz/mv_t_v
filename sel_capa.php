<!DOCTYPE html>
<html>
<head>
<title>Carga Anexo</title>
<link rel= "stylesheet" href= estilos.css>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
	require 'clases_base.php' ;
	require 'clases_anexo.php' ;

	?>

<form method="post" action="pide_anexo.php"> 
	<?php
	$pagina1=new Pagina('Carga Anexo','<input type="submit" value="Confirmar">');
	$pagina1->insertarCuerpo('Ingrese el Nro de Capacitacion: <input type="text" name="m_nro_capa" autofocus>');
	$pagina1->graficar();

	?>
</form>
</body>
</html>
