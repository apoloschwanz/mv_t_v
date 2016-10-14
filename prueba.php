<?php
	require_once 'db.php' ;
	require_once 'clases_base.php' ;
	require_once 'class_paginai.php';
	require_once 'clase_entidad.php';
	require_once 'clase_entidadi.php';
	require_once 'utilisateur.php';
	require_once 'clase_relacionj.php' ;
	require_once 'clase_rolusuario.php' ;
	
	?>

<form method="post" action="carga_anexo.php"> 
	<?php
	$cn=new Conexion();
        $cn->ver_root();
	$xx= $cn->conexion ;
	$pagina1=new Pagina('Título de la Página','<input type="submit" value="Confirmar">');
	$pagina1->insertarCuerpo('Esto es una prueba que debe aparecer dentro del cuerpo de la página 1');
	$pagina1->insertarCuerpo('Esto es una prueba que debe aparecer dentro del cuerpo de la página 2');
	$pagina1->insertarCuerpo('Esto es una prueba que debe aparecer dentro del cuerpo de la página 3');
	$pagina1->insertarCuerpo('Esto es una prueba que debe aparecer dentro del cuerpo de la página 4');
	$pagina1->insertarCuerpo('Esto es una prueba que debe aparecer dentro del cuerpo de la página 5');
	$pagina1->insertarCuerpo('Esto es una prueba que debe aparecer dentro del cuerpo de la página 6');
	$pagina1->insertarCuerpo('Esto es una prueba que debe aparecer dentro del cuerpo de la página 7');
	$pagina1->insertarCuerpo('Esto es una prueba que debe aparecer dentro del cuerpo de la página 8');
	$pagina1->insertarCuerpo('Esto es una prueba que debe aparecer dentro del cuerpo de la página 9');
	$pagina1->graficar();
	//
	// Prueba de rolusuario
	echo '<br><br> Prueba de Rolusuario ' ;
	$rolusuario = new RolUsuario() ;
	$rolusuario->Pruebas() ;
	echo '<br><br> Prueba de Rolusuario ' ;
	$utl = new utilisateur() ;
	$utl->Pruebas() ;
	?>
</form>
</body>
</html>
