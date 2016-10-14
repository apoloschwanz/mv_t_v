<?php
	require_once 'controlsesion.php' ; 
	require_once 'clases_base.php' ;
	require_once 'controlsesion.php';
	require_once 'clases_anexo.php' ;
	require_once 'class_paginai.php' ; 
	require_once 'clases_encuesta.php' ;
	require_once 'clase_relacion.php' ;
	require_once 'clase_observaciones_encuesta.php' ;
	require_once 'clase_detalle_observaciones_encuesta.php';
	require_once 'clase_Capacitaciones_de_un_Anexo_p_Encuesta.php';
	//require_once 'xx.php' ;


	//
	// Instancia Clases 
	$Rel1 = new Detalle_Observaciones_Encuesta() ; // DZ 2016-01-21
	//
	// Varibales de accion
	//
	// Solicita agregar detalles
	$okAgregarDetalle = $Rel1->obtiene_prefijo_campo().'_okAgregar' ;
	//
	// Solicita borrar detalle
	$okBorrarDetalle = $Rel1->obtiene_prefijo_campo().'_okBorrar' ;
	//
	// Selecciono detalles para agregar
	$okseleccion = $Rel1->obtiene_prefijo_campo().'_okSelected'; // DZ 2016-01-22
	//
	// Si viene de ingresar el número de anexo
	if ( isset($_GET['nro_anexo']) )
		confirma_anexo_nro() ; // viene de un link de la capacitacion
	elseif ( isset($_POST['nro_anexo_ok']) )
		{
		//
		// Controla si el nro de anexo cargado existe
		$an = $_REQUEST['m_nro_anexo'];
		$Anx = new Anexo() ;
		$Anx->Set_id($an);
		$Anx->Leer();
		//
		// Busca capacitaciones
		if ( $Anx->existe == true ) 
		{
			$ca = new Capacitaciones_de_un_Anexo_p_Encuesta();
			$ca->Set_id ($Anx->id() ) ;
			$regs = $ca->Obtener_Lista() ;
			$ok_capa = $ca->existe==true and $reg_capa=mysqli_fetch_array($regs) ;
		}
		$mensaje = '' ;
		if ( ! $Anx-> existe == true )
			$mensaje = 'El número de anexo ingresado no existe' ;
		elseif ( ! $ok_capa == true )
			$mensaje = 'No se pudo encontrar la capacitacion correspondiente al anexo' ;
		if ( $Anx->existe == true and $ok_capa == true)
			{
				pide_encuesta($Anx,$reg_capa) ;
			}
			else
			{
				re_pide_anexo_nro($mensaje) ;
			}
		}
	//
	// Si viene de Ingresar el número de encuesta
	elseif ( isset($_POST['nro_encuesta_ok']) )
		{
		//
		// Controla si la encuesta pertenece al anexo
		
		$an = $_REQUEST['m_nro_anexo'];
		$en = $_REQUEST['m_nro_encuesta'];
		$Anx = new Anexo() ;
		$Anx->Set_id($an);
		$Anx->Leer();
		$Enc = new Encuesta();
		$Enc->Set_id($en);
		$Enc->Set_Anexo_Nro($an);
		$Enc->Set_Tipo_Encuesta_Cod('Alumnos___');
		//$Enc->Set_Conj_Preg_Cod('EncAlu2016');
		//
		//////////////////////////////////////////////////////////
		
		//
		// Si existe el anexo
		if ( $Anx->existe )
		{
			$ca = new Capacitaciones_de_un_Anexo_p_Encuesta();
			$ca->Set_id ($Anx->id() ) ;
			$regs = $ca->Obtener_Lista() ;
			$ok_capa = $ca->existe==true and $reg_capa=mysqli_fetch_array($regs) ;
			if ( ! $ok_capa	== true )
				$err_capa = 'No se pudo obtener la capacitación asociada al anexo' ;
		}
		//
		// Determina el conjunto de preguntas
		if ( $ok_capa == true  )
			{
				if ( $reg_capa['Programa_Nro'] == 1 )
					$Enc->Set_Conj_Preg_Cod('EncAl2016m');
				elseif ( $reg_capa['Programa_Nro'] == 5 )
					$Enc->Set_Conj_Preg_Cod('EncAl2016p');
				else
					$ok_capa = false ;
				$err_capa = 'No se encuentra el conjunto de preguntas para la capacitacion del anexo' ;
			}
				//
				// Actualiza la encuesta
				if ( $ok_capa == true )
						$Enc->Actualizar();
				//
				// Si no hay error carga la encuesta
				if ( ! $Anx->existe )
					muestra_error_encuesta("El anexo ingresado no existe",$an) ;
				elseif ( !$ok_capa == true )
					muestra_error_encuesta($err_capa,$an) ;
				elseif ( $Enc->Error == true )
						muestra_error_encuesta($Enc->TextoError,$an) ;
				else
						carga_encuesta($Enc,$Rel1,$reg_capa) ;
		}
	elseif ( isset($_POST['grabar_encuesta_ok'] ) )
		{
		//
		// Instancia encuesta	
		$en = $_REQUEST['m_nro_encuesta'];
		$an = $_REQUEST['m_nro_anexo'];
		$Enc = new Encuesta();
		$Enc->Set_id($en);
		$Enc->Set_Anexo_Nro($an);
		//
		// Graba con los datos enviados en el formulario de edición
		$Enc->Guardar();
		//
		// Guarda la sistematizacion de observaciones
		if ( $Enc->Error == false )
			{
				$Rel1->set_id_lado_uno ($en) ;
				$Rel1->agrega_seleccion() ;
				if ( $Rel1->hay_error() == true ) 
					{
						$Enc->Error = true ;
						$Enc->TextoError =  $Rel1->textoError() ;
					}
			}
		if ( $Enc->Error == true )
			{
				muestra_error_grabar($Enc->TextoError,$an,$en) ;
			}
		else
			{
				// DZ 2106/01/21 encuesta_cargada($en,$an) ;
				//
				// Si no tiene observaciones asociadas 
				$Rel1->set_id_lado_uno ($en) ;
				$Rel1->leer_lista() ;
				if ( $Rel1->existe == true ) 
					{
						actualizar_detalle($an,$en,$Enc,$Rel1) ;
					}
				else
					{
						agregar_detalle($an,$en,$Enc,$Rel1) ;
					}
			}
		}
	elseif ( isset( $_POST[$okseleccion] ) )
		{
			$en = $_REQUEST['m_nro_encuesta'];
			$an = $_REQUEST['m_nro_anexo'];
			$Rel1->set_id_lado_uno ($en) ;
			$Rel1->agrega_seleccion() ;
			if ( $Rel1->hay_error() == true ) die( $Rel1->textoError() ) ;
			else
				{
				$Enc = new Encuesta();
				$Enc->Set_id($en);
				$Enc->Set_Anexo_Nro($an);
				$Rel1->set_id_lado_uno ($en) ;
				$Rel1->leer_lista() ;
				actualizar_detalle($an,$en,$Enc,$Rel1) ;
				}
		}
	//
	// Solicita agregar detalles
	elseif ( isset( $_POST[$okAgregarDetalle] ) )
		{
		$en = $_REQUEST['m_nro_encuesta'];
		$an = $_REQUEST['m_nro_anexo'];
		$Enc = new Encuesta();
		$Enc->Set_id($en);
		$Enc->Set_Anexo_Nro($an);
		$Rel1->set_id_lado_uno ($en) ;
		$Rel1->leer_lista() ;
		agregar_detalle($an,$en,$Enc,$Rel1) ;
		}
	//
	// Solicita borrar detalle
	elseif ( isset( $_POST[$okBorrarDetalle] ) )
		{
		$en = $_REQUEST['m_nro_encuesta'];
		$an = $_REQUEST['m_nro_anexo'];
		$Enc = new Encuesta();
		$Enc->Set_id($en);
		$Enc->Set_Anexo_Nro($an);
		$Rel1->set_id_lado_uno ($en) ;
		$Rel1->borrar_seleccion() ;
		actualizar_detalle($an,$en,$Enc,$Rel1) ;
		}
	elseif ( isset( $_POST['okSalir'] ) )
		{
		header('Location:accueil.php');
		}
	else
		{
		pide_anexo_nro() ;
		}




	//
	// Carga Encuesta
	//
	function carga_encuesta($Enc,$Rel1,$reg_capa)
		{
			//$reg_enc= $Enc->Obtener_Registro();
			$accion = $_SERVER['PHP_SELF'] ;
			$boton = "Grabar";	
			//
			// Pide Nro de Anexo
			//
			$Enc->Leer() ;
			$reg = $Enc->Obtener_Registro() ;
			$Enc->anexo->Leer();
			$reganexo = $Enc->anexo->Obtener_Registro();
			$pagina = new Paginai('Carga de Encuestas','</td><td><input type="submit" name="grabar_encuesta_ok" value="'.$boton.'" >') ;
			$texto = 'Anexo Nro </td><td colspan="1">'.$reg['Anexo_Nro'].'<input type="hidden"  name="m_nro_anexo" value="'.$reg['Anexo_Nro'].'">' ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Fecha </td><td colspan="1">'.$reganexo['Fecha'] ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Nombre del Establecimiento </td><td colspan="1">'.$reganexo['NOMBRE'] ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Programa </td><td colspan="1">'.$reg_capa['Programa'] ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Cantidad de Alumnos </td><td colspan="1">'.$reganexo['Cantidad_de_Alumnos'] ;
			$pagina->insertarCuerpo($texto);
			$texto = ' Nro de Encuesta: </td><td colspan="1"> '.$reg['Nro_Encuesta'].'<input type="hidden"  name="m_nro_encuesta" value="'.$reg['Nro_Encuesta'].'">' ;
			$pagina->insertarCuerpo($texto);
			$texto = '</td><td colspan="1">'.$Enc->textoModificarDetalle();
			$pagina->insertarCuerpo($texto);
			//
			// Si la encuesta no tiene sistematizacion de observaciones agregadas
			$Rel1->set_id_lado_uno ($reg['Nro_Encuesta']) ;
			$Rel1->leer_lista() ;
			if ( ! $Rel1->existe )
				{
					$texto = '</td><td colspan="1">'.$Rel1->texto_Mostrar_Seleccion_Sin_Boton();
					$pagina->insertarCuerpo($texto);
				}
					
			$pagina->graficar_c_form($accion);
		}
	//
	// Confirma Anexo Nro
	//
	function confirma_anexo_nro()
		{
			$accion = $_SERVER['PHP_SELF'] ;
			$boton = "Confirmar";	
			$manx_nro = $_GET['nro_anexo'] ;
			//
			// Pide Nro de Anexo
			//
			$pagina = new Paginai('Carga de Encuestas','<input type="submit" name="nro_anexo_ok" value="'.$boton.'" autofocus><input type="submit" value="Salir" name="okSalir">') ;
			$texto = 'Nro de Anexo: '.$manx_nro.'<input type="hidden" name="m_nro_anexo"  value="'.$manx_nro.'">' ;
			$pagina->insertarCuerpo($texto);
			$pagina->graficar_c_form($accion);
	}

	//
	// Pide el Anexo
	//
	function pide_anexo_nro()
		{
			$accion = $_SERVER['PHP_SELF'] ;
			$boton = "Confirmar";	
			//
			// Pide Nro de Anexo
			//
			$pagina = new Paginai('Carga de Encuestas','<input type="submit" name="nro_anexo_ok" value="'.$boton.'" autofocus><input type="submit" value="Salir" name="okSalir">') ;
			$texto = 'Ingrese el Nro de Anexo: <input type="numbre" name="m_nro_anexo"  autofocus>' ;
			$pagina->insertarCuerpo($texto);
			$pagina->graficar_c_form($accion);
	}
	//
	// Vuelva a pedir el Anexo
	//
	function re_pide_anexo_nro($mensaje)
		{
			$accion = $_SERVER['PHP_SELF'] ;
			$boton = "Confirmar";	
			//
			// Pide Nro de Anexo
			//
			$pagina = new Paginai('Carga de Encuestas','<input type="submit" name="nro_anexo_ok" value="'.$boton.'" autofocus><input type="submit" value="Salir" name="okSalir">') ;
			$texto = $mensaje.' <br>
								Por favor: Verifique y vuelva a ingresarlo.' ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Nro de Anexo: <input type="numbre" name="m_nro_anexo" autofocus>' ;
			$pagina->insertarCuerpo($texto);
			$pagina->graficar_c_form($accion);
	}

	//
	// Pide Encuesta
	//
	function pide_encuesta($Anx,$reg_capa)
		{
			$reg_anexo= $Anx->Obtener_Registro();
			$accion = $_SERVER['PHP_SELF'] ;
			$boton = "Confirmar";	
			//
			// Pide Nro de Anexo
			//
			$pagina = new Paginai('Carga de Encuestas','</td><td><input type="submit" name="nro_encuesta_ok" value="'.$boton.'" autofocus>  <input type="submit" value="Cambiar de Anexo"><input type="submit" value="Salir" name="okSalir">') ;
			$texto = 'Anexo Nro </td><td colspan="1">'.$reg_anexo['Anexo_Nro'] .'<input type="hidden"  name="m_nro_anexo" value="'.$reg_anexo['Anexo_Nro'].'">';
			$pagina->insertarCuerpo($texto);
			$texto = 'Fecha </td><td colspan="1">'.$reg_anexo['Fecha'] ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Nombre del Establecimiento </td><td colspan="1">'.$reg_anexo['NOMBRE'] ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Programa </td><td colspan="1">'.$reg_capa['Programa'] ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Cantidad de Alumnos </td><td colspan="1">'.$reg_anexo['Cantidad_de_Alumnos'] ;
			$pagina->insertarCuerpo($texto);
			$texto = ' Nro de Encuesta: </td><td colspan="1"> <input type="numbre" name="m_nro_encuesta" autofocus>' ;
			$pagina->insertarCuerpo($texto);
			$pagina->graficar_c_form($accion);
		}

	//
	// Muestra Error
	//
	function muestra_error_encuesta($error,$an_nro)
		{
			$accion = $_SERVER['PHP_SELF'] ;
			$boton = "Ok";	
			//
			// Pide Nro de Anexo
			//
			$pagina = new Paginai('Carga de Encuestas','<input type="submit" name="nro_anexo_ok" value="'.$boton.'" autofocus>') ;
			$texto = $error.'<input type="hidden"  name="m_nro_anexo" value="'.$an_nro.'">'  ;
			$pagina->insertarCuerpo($texto);
			$pagina->graficar_c_form($accion);
	}
	//
	// Muestra Eror al Grabar
	//
	function muestra_error_grabar($error,$an_nro,$enc_nro)
		{
			$accion = $_SERVER['PHP_SELF'] ;
			$boton = "Ok";	
			//
			// Pide Nro de Anexo
			//
			$pagina = new Paginai('Carga de Encuestas','<input type="submit" name="nro_encuesta_ok" value="'.$boton.'" autofocus>') ;
			$texto = $error ;
			$texto = $texto.'<input type="hidden"  name="m_nro_anexo" value="'.$an_nro.'">' ;
			$texto = $texto.'<input type="hidden"  name="m_nro_encuesta" value="'.$enc_nro.'">';
			$pagina->insertarCuerpo($texto);
			$pagina->graficar_c_form($accion);
	}
	//
	// Carga Encuesta
	//
	function encuesta_cargada($en,$an)
		{
			$accion = $_SERVER['PHP_SELF'] ;
			$boton = "OK";	
			//
			// Pide Nro de Anexo
			//
			$pagina = new Paginai('Carga de Encuestas','<input type="submit" name="nro_anexo_ok" value="'.$boton.'" autofocus>') ;
			$texto = 'Encuesta Nro.: '.$en.' Grabada ! '.'<input type="hidden"  name="m_nro_anexo" value="'.$an.'">' ;
			$pagina->insertarCuerpo($texto);
			$pagina->graficar_c_form($accion);
		}
	//
	// Agrega sistematizacion de observaciones
	//
	function agregar_detalle($an,$en,$Enc,$Rel1)
		{
			$accion = $_SERVER['PHP_SELF'] ;
			$boton = "Grabar";	
			//
			// Pide Nro de Anexo
			//
			$Enc->Leer() ;
			$reg = $Enc->Obtener_Registro() ;
			$Enc->anexo= new Anexo();
			$Enc->anexo->Set_id($an);
			$Enc->anexo->Leer();
			$reganexo = $Enc->anexo->Obtener_Registro();
			$pagina = new Paginai('Carga de Encuestas','</td><td><input type="submit" value="Salir" name="okSalir">') ;
			$texto = 'Anexo Nro </td><td colspan="1">'.$reg['Anexo_Nro'].'<input type="hidden"  name="m_nro_anexo" value="'.$reg['Anexo_Nro'].'">' ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Fecha </td><td colspan="1">'.$reganexo['Fecha'] ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Nombre del Establecimiento </td><td colspan="1">'.$reganexo['NOMBRE'] ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Cantidad de Alumnos </td><td colspan="1">'.$reganexo['Cantidad_de_Alumnos'] ;
			$pagina->insertarCuerpo($texto);
			$texto = ' Nro de Encuesta: </td><td colspan="1"> '.$reg['Nro_Encuesta'].'<input type="hidden"  name="m_nro_encuesta" value="'.$reg['Nro_Encuesta'].'">' ;
			$pagina->insertarCuerpo($texto);
			$texto = '</td><td colspan="1">'.$Rel1->texto_Mostrar_Seleccion();
			$pagina->insertarCuerpo($texto);
			$pagina->graficar_c_form($accion);
		}
	//
	// Actualiza sistematizacion de observaciones
	//
	function actualizar_detalle($an,$en,$Enc,$Rel1)
		{
			$accion = $_SERVER['PHP_SELF'] ;
			$boton = "Grabar";	
			//
			// Pide Nro de Anexo
			//
			$Enc->Leer() ;
			$reg = $Enc->Obtener_Registro() ;
			$Enc->anexo= new Anexo();
			$Enc->anexo->Set_id($an);
			$Enc->anexo->Leer();
			$reganexo = $Enc->anexo->Obtener_Registro();
			$pagina = new Paginai('Carga de Encuestas','</td><td><input type="submit" name="nro_anexo_ok" value="Finalizar" autofocus><input type="submit" name="nro_encuesta_ok" value="Volver"><input type="submit" value="Salir" name="okSalir">') ;
			$texto = 'Anexo Nro </td><td colspan="1">'.$reg['Anexo_Nro'].'<input type="hidden"  name="m_nro_anexo" value="'.$reg['Anexo_Nro'].'">' ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Fecha </td><td colspan="1">'.$reganexo['Fecha'] ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Nombre del Establecimiento </td><td colspan="1">'.$reganexo['NOMBRE'] ;
			$pagina->insertarCuerpo($texto);
			$texto = 'Cantidad de Alumnos </td><td colspan="1">'.$reganexo['Cantidad_de_Alumnos'] ;
			$pagina->insertarCuerpo($texto);
			$texto = ' Nro de Encuesta: </td><td colspan="1"> '.$reg['Nro_Encuesta'].'<input type="hidden"  name="m_nro_encuesta" value="'.$reg['Nro_Encuesta'].'">' ;
			$pagina->insertarCuerpo($texto);
			$texto = '</td><td colspan="1">'.$Rel1->texto_actualizar_detalle();
			$pagina->insertarCuerpo($texto);
			$pagina->graficar_c_form($accion);
		}
	

?>
