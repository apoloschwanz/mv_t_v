 <?php
 
	require_once 'controlsesion.php' ; 
	require_once 'class_paginai.php' ; 
	require_once 'clases_base.php' ;
	require_once 'clase_vista_total_de_capacitaciones.php' ;
 
 
 
 
 $obj_tot_cap = new vista_total_de_capacitaciones() ;
 
	//
	//
	// Muestra Página principal para total de capacitaciones
	$obj_tot_cap->pagina_lista_leer_eventos()
 
 ?>
