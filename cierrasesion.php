<?php
//
//
require_once 'db.php' ;
//
// Inicia o restablece sesion
session_start();
//
// Borra Variables
unset($_SESSION['uid']);
unset($_SESSION['pwd']);//
unset($_SESSION['ses']);//

// Abre conexion
$cnx=new Conexion();
//
// Cierra Conexion
$cnx->cerrar();
//
// Muestra mensaje
muestra_cierre_sesion () ;

?>

<?php
	function muestra_cierre_sesion () 
	{
	

?>

<!DOCTYPE html">
<head>
<title> Sesion Cerrada </title>
<meta http-equiv="Content-Type"
content="text/html; charset=iso-8859-1" />
</head>
<body> 
<h1> Hasta Pronto </h1>
<p> Gracias por iniciar sesion en el sistema. </p>
</body>
</html>
 

<?php
	// exit;
	}
?>
