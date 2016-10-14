<!DOCTYPE html>
<html>
<head>
<title>Capacitaciones Solicitadas</title>
<link rel= "stylesheet" href= estilos.css>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
	require_once 'clases_base.php' ;
	require_once 'clases_anexo.php' ;
	require_once 'clases_crono.php' ;
	//
	// Edicion
	//
	if ( isset($_REQUEST ['m_nro_edicion'] ) )
		{	$edcn = $_REQUEST['m_nro_edicion']; }
	else
		{
		$edactual = new Edicion_Actual() ;
		if ( $edactual->existe )
			{
			$edcn = $edactual->Edicion_Actual_Nro ;
			}
		else 
			{
			die( 'Problemas al buscar edicion actual') ;
			}
		}
	//
	// Instancia clases
	//
	$Solicitudes = new Solicitudes_de_Asignacion_de_Capacitacion() ;
	$Solicitudes->Carga_Sql_Capas_Solicitadas();
	$Solicitudes->leer_sql_precargado();
	//
	$boton = "Refrescar" ;
	$pagina = "capas_solicitadas.php" ;
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
	// Variables Ocultas
	//
	//$txt = '<input type="hidden" name="m_nro_anexo" '.'value="'.$an.'">' ;
	//$pagina1->insertarCuerpo($txt);
	
	//
	// Datos de la Persona
	//
	$pagina1->insertarCuerpo('</td><td colspan="10"> <input type="hidden" name="m_nro_edicion" value="'.$edcn.'">');
	$pagina1->insertarCuerpo('</td><td colspan="10" align="center" > ');
	$pagina1->insertarCuerpo('</td><td colspan="10" align="center" > Capacitaciones Solictadas ');
	$pagina1->insertarCuerpo('</td><td colspan="10" align="center" > ');
	$pagina1->insertarCuerpo('Capacitacion #</td><td>Fecha</td><td>Escuela</td><td>Domicilio</td><td>Turno</td><td>Hora Desde</td><td>Hora Hasta</td><td colspan = "2" >Docente</td><td>Mail</td> ');
	$pagina1->graficar_cuerpo();
	//
	// Capacitaciones
	// 
	$puede_borrar = false ;
	$puede_agregar = false ;
	$Solicitudes->mostrar_registros($puede_borrar,$puede_agregar);
	$pagina1->graficar_pie();
	?>
</form>
</body>
</html>
