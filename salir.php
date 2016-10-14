<?php
	//
	// Borra la sesion
	session_start();
	unset($_SESSION['uid']);
	unset($_SESSION['pwd']);
	unset($_SESSION['ses']);
	header('Location:index.php');
?>
