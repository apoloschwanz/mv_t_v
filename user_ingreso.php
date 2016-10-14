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

<form method="post" action="usu_abresesion.php"> 
	<?php
	$pagina1=new Pagina('Ingreso:','<input type="submit" value="Confirmar">');
	$pagina1->insertarCuerpo('Ingrese direccion de mail: <input type="text" name="m_usuario">');
	$pagina1->insertarCuerpo('Ingrese clave: <input type="password" name="m_password">');
	$pagina1->graficar();

	?>
</form>
</body>
</html>
