<!DOCTYPE html>
<html>
<head>
<title>Carga Anexo</title>
<link rel= "stylesheet" href= estilos.css>

</head>
<body>
<?php
	require 'clases_base.php' ;
	require 'clases_anexo.php' ;
	
	//
	// Lee la Capacitación
	//


	//
	// Clase Desplegable
	//
	
class Desplegable {
	public function Mostrar_Celda( $nombre, $valor )
	{
	echo '<td>' ;
	echo '<input type="text" ' ; 
	echo 'name="m_'.$nombre.'" ' ; 
	echo 'value="'.$valor.'">' ;
	echo '</td>';
	}
	public function Mostrar_Vacia()
	{
	echo '<td>' ;
	echo '</td>';
	}
}


	 $pagina1=new Pagina('Carga Anexo','<input type="submit" value="Probar Carga Anexo">');
	?>

<form method="post" action="carga_anexo.php"> 
	<?php
	//
	//
	// Dibuja Pagina
	//
	$pagina1->graficar_cabecera();
	
			echo '<tr><td> Ingrese número de Anexo </td><td>' ;
			echo '<input type="text" name="m_nro_anexo">' ; 
			echo '</td></tr>' ;
			echo '<tr><td> Ingrese número de Capa </td><td>' ;
			echo '<input type="text" name="m_nro_capa" >' ; 
			echo '</td></tr>' ;
	
	$pagina1->graficar_pie();
	echo ' pruebaaaaa ' ;
	echo '<table>';
	$cpo = new Campo() ; 
	$cpo->Mostrar('Etiquetaaaa','Nombreeee','Valorrrr');
	$cpo->Mostrar('Etiquetaaaa','Nombreeee','Valorrrr');
	$cpo->Mostrar('Etiquetaaaa','Nombreeee','Valorrrr');
	$cpo->Mostrar('Etiquetaaaa','Nombreeee','Valorrrr');
	echo '<tr>' ; //echo '<tr><td>' ;
	//
	// Respuestas de la pregunta
	//
	$rtas = new Respuestas_de_la_Pregunta() ;
	$rtas->Set_id (16) ;
	$regs = $rtas->Obtener_Lista() ;
	$nombre = 'xxxx_pregunta' ;
	$valor = 2 ;
	$posdes = 0 ;
	$poscod = 1 ;
	$cel = new Celda() ;
	$cel->Mostrar_Desplegable( $nombre, $valor , $regs , $poscod, $posdes) ;
	//echo '<select name="'.$nombre.'">' ;
	////
	////
	////
	//while ($reg=mysqli_fetch_array($regs))
	//{ 
	//	$sel = '' ;
	//	if ( $reg['Respuesta_Cod'] == $valor ) 
	//		{
	//		$sel = 'selected' ;
	//		}
	//	// echo '  <option value="'.$reg['Respuesta_Cod'].'" '.$sel.'>'.$reg['Respuesta_con_Numero'].'</option> ' ;
	//	echo '  <option value="'.$reg[$poscod].'" '.$sel.'>'.$reg[$posdes].'</option> ' ;
	//}
	//echo '  </select> ' ;

	echo '</tr>' ; //echo '</td></tr>' ;
	echo '</table>';
	?>
</form>
</body>
</html>
