<?php
	//
	// Clases
	//
	require_once 'clases_base.php' ;
	require_once 'class_paginai.php' ;
	require_once 'clase_eleccion.php' ;
	require_once 'clase_cargos.php';
	require_once 'clase_distrito.php';
	require_once 'clase_listas.php' ;
	//require_once 'db.php' ;
	//require_once 'clases_certificado.php' ;
	
	//
	// Distrito
	$obj_dd = new distrito() ;
	if ( isset( $_REQUEST['m_distrito_nro'] ) )
	{
		$dn=$_REQUEST['m_distrito_nro'];
	}
	else
	{
		$dn = $obj_dd->distrito_numero_default() ;
	}
	//
	// Eleccion
	$obj_el = new eleccion() ;
	if ( isset( $_REQUEST['m_eleccion_nro'] ) )
	{
		$el = $_REQUEST['m_eleccion_nro'] ;
	}
	else
	{
		$el = $obj_el->eleccion_numero_default() ;
	}
	

//
// <button class="testButton1"><img src="Car Blue.png" alt="">Car</button>

	if( isset($_REQUEST['ok_voto']) )
	{
		$ln = $_REQUEST['ok_voto'] ;
		confirmar_seleccion($dn,$el,$ln) ;
	}
	elseif( isset($_REQUEST['okimprimir']) )
	{
		mostrar_impresion($dn,$el) ;
	}
	elseif( isset($_REQUEST['ok_sel_eleccion']) )
	{
		$cargo_oculto = '' ;
		if ( isset ( $_REQUEST['elecc_1'] ) )
			{
				$el = 1 ;
				mostrar_listas($dn,$el) ;
			}
		elseif ( isset ( $_REQUEST['elecc_2'] ) )
			{
				$el = 2 ;
				mostrar_listas($dn,$el) ;
			}
	}
	else
	{
		slecciona_eleccion($obj_el,$dn) ;
	}
	//var_dump($_REQUEST ) ;


	function mostrar_listas( $dn, $el )
	{
		$oculto = '<input type="hidden" name="m_distrito_nro" value="'.$dn.'">';
		$oculto .= '<input type="hidden" name="m_eleccion_nro" value="'.$el.'">';
		$botones = $oculto.'<input type="submit" name="okvoler" value="   VOLVER   " />' ;
		$pagina = new paginai('','Confección de la Boleta'.$botones) ;
		$pagina->sinborde() ;
		//
		// Obtiene Cargos
		$obj_cargo = new cargo() ;
		$obj_listas = new lista() ;
		$lista_cargos = $obj_cargo->obtener_lista_cargos($dn , $el) ;
		$lista_superlistas = $obj_listas->obtener_lista_superlistas($dn, $el) ;
		$cnt_listas = count( $lista_superlistas );
		$alto_lista = round( 85/$cnt_listas , 0 ) ;
		$alto_icono = round( $alto_lista/4 , 0 ) ;
		echo 'hay '.$cnt_listas.'listas <br> con un alto de: '.$alto_lista.'<br>';
		//
		// Encabezado
		$txt  = '<table>' ;
		$txt .= '<tr>' ;
		$txt .= '<th style="background-color: transparent;" >Lista #</th>' ;
		foreach( $lista_cargos as $cargo )
		{	$txt .= '<th style="background-color: transparent;">' ;
			$txt .= $cargo['des'] ;
			$txt .= '</th>' ;
		}
		$txt .= '</tr>' ;
		//
		// Recorre las listas
		foreach( $lista_superlistas as $superlista )
		{
			$txt .= '<tr style=background-color:'.$superlista['color'].'>' ;
			$txt .= '<td style="background-color: transparent;">' ;
			$txt .= $superlista['lista_nro'] ;
			$txt .= '<img src="'.$superlista['imagen'].'"  alt="'.$superlista['imagen'].'" height="42" width="42">' ;
			$txt .= '</td>' ;
			//
			// Recorre los cargos
			foreach( $lista_cargos as $cargo )
			{	
				$lista = $obj_listas->obtener_lista($dn, $el , $superlista['nro'] , $cargo['nro'] ) ;
				$lnk_foto = $lista['foto'] ;
				$txt .= '<td style="background-color: transparent;"  >' ;
				$mvalor = $lista['nro'];
				$txt .= '<button name="ok_voto" value='.$mvalor.' style="background-color: transparent;" > ';
				$txt .= '<img src="'.$lnk_foto.'" alt="'.$lnk_foto.'" height="150" width="420">' ;
				//$txt .= '<table style="background-color: transparent;" width="420" >' ;
				//$txt .= '<tr>';
				//$txt .= '<td>'.$lista['des'].'</td>';
				//$txt .= '</tr>';
				//$txt .= '</table>' ;
				$txt .= '</button>' ;
				$txt .= '</td>' ;
			}
			$txt .= '</tr>' ;
		}
		$txt .= '</table>';
		
		$pagina->insertarCuerpo($txt);			
		$pagina->graficar_c_form($_SERVER['PHP_SELF']);
	}
	function slecciona_eleccion($obj_el,$dn) 
	{
		$oculto = '<input type="hidden" name="m_distrito_nro" value="'.$dn.'">';
		$oculto .= '<input type="hidden" name="ok_sel_eleccion" value="ok">';
		$botones = $oculto ;
		//$botones = $botones.'<input type="submit" name="okregistrarse" value="   OK   " />' ;
		$pagina = new paginai('','Confección de la Boleta'.$botones) ;
		$pagina->sinborde() ;
		$texto = $obj_el->txt_muestra_seleccion() ;
		$pagina->insertarCuerpo($texto);			
		$pagina->graficar_c_form($_SERVER['PHP_SELF']);		
	}
	function mostrar_impresion($dn,$el)
	{
		//
		// Confirma Impresion
		$oculto = '<input type="hidden" name="m_distrito_nro" value="'.$dn.'">';
		$oculto .= '<input type="hidden" name="m_eleccion_nro" value="'.$el.'">';
		$botones = $oculto ;
		$botones .= '<input type="hidden" name="elecc_'.$el.'" value="" >' ;
		//$botones .= '<input type="submit" name="ok_sel_eleccion" value=" OK " />' ;
		$botones .= '<input type="submit" name="ok" value=" OK " />' ;
		//
		// Datos de la Pantalla
		$txt = 'Gracias por participar' ;
		//
		// Pagina
		$pagina = new paginai('',''.$botones) ;
		$pagina->sinborde() ;
		$pagina->insertarCuerpo($txt);			
		$pagina->graficar_c_form($_SERVER['PHP_SELF']);		
	}
	
	function confirmar_seleccion($dn,$el,$ln)
	{
		//
		// Confirma Seleccion
		$oculto = '<input type="hidden" name="m_distrito_nro" value="'.$dn.'">';
		$oculto .= '<input type="hidden" name="m_eleccion_nro" value="'.$el.'">';
		$botones = $oculto ;
		$botones .= '<input type="hidden" name="elecc_'.$el.'" value="" >' ;
		$botones .= '<input type="submit" name="ok_sel_eleccion" value=" MODIFICAR " />' ;
		$botones .= '<input type="submit" name="okimprimir" value=" IMPRIMIR " />' ;
		//
		// Lista Completa
		$obj_lista = new lista() ;
		$txtlista = $obj_lista->lista_completa($dn,$el,$ln) ;
		//
		// Pagina
		$pagina = new paginai('','Confirma ?'.$botones) ;
		$pagina->sinborde() ;
		$pagina->insertarCuerpo($txtlista);			
		$pagina->graficar_c_form($_SERVER['PHP_SELF']);		
	}
?>	



