<!-- objeto en desuso -->
<!--
<!DOCTYPE html>
<html>
<head>
<title>Seleccion de Capacitaciones</title>
<link rel= "stylesheet" href= estilos.css>

</head>
<body>
<?php
	require 'clases_base.php' ;
	require 'clases_anexo.php' ;
	require 'clases_crono.php' ;
	//
	// Instancia clases
	//
	
	//
	$boton = "Confirmar" ;
	$pagina = "crono_sel_docente_upd.php" ;
	//	}
	$pagina1=new Pagina('Crono','</th><th colspan="10"><input type="submit" value="'.$boton.'">');
	?>

<form method="post" action="<?php echo $pagina; ?>"> 
	<?php
	//
	// Dibuja Pagina
	//
	$pagina1->graficar_cabecera();
  //
	// Datos de la Persona
	//
	//$pagina1->insertarCuerpo('</td><td colspan="1" align="center" >--------------------------');
	$pagina1->insertarCuerpo('</td><td colspan="1" align="center" >Ingrese el mail con el que se registro en el programa');
	$txt = 'Mail: </td><td colspan="1"> '.'<input type="text" name="m_mail_capacitador">';
	$pagina1->insertarCuerpo($txt);
	//$pagina1->insertarCuerpo('</td><td colspan="1" align="center" >--------------------------');
		
	$pagina1->graficar_cuerpo();
	$pagina1->graficar_pie();
	?>
</form>
</body>
</html>
-->

