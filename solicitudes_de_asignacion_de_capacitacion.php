<?php
	require_once 'controlsesion.php' ; 
	require_once 'clases_base.php' ;
	require_once 'clases_anexo.php' ;
	require_once 'clases_crono.php' ;
	require_once 'class_paginai.php' ;
	require_once 'clase_parametro.php' ;
	//
	// Edicion
	//
	$edactual = new Edicion_Actual() ;
	if ( $edactual->existe )
		{
		$edcn = $edactual->Edicion_Actual_Nro ;
		}
	else 
		{
		die( 'Problemas al buscar edicion actual') ;
		}
	//
	// Docente
	//
	$uid = $_SESSION['uid'] ;
	$Docente = new Docente() ;
	$Docente->Leer_x_mail($uid);
	$reg_dte = $Docente->Obtener_Registro() ;
	if ( $Docente->existe == false )
			{
			echo 'Docente_Nro='.$reg_dte['Docente_Nro'] ;
			die( 'No hay docente registrados con el mail '.$uid) ; 
			}
	
	if ( isset($_POST['okSeleccion']) )
		{
			//
			// Agrega Capas
			agrega_capas($reg_dte,$edcn,$uid) ;
			muestra_capas_elegidas($reg_dte,$edcn) ;
		}
	elseif ( isset($_POST['ok_ver_elegidas']) )
		{
			muestra_capas_elegidas($reg_dte,$edcn) ;
		}
	elseif ( isset($_POST['solicitudes_de_asignacion_de_capacitacion_okAgregar']) )
		{
			//
			// Mustra capacitaciones Disponibles
			muestra_capas_disponibles($reg_dte,$edcn) ;
		}
	elseif ( isset($_POST['solicitudes_de_asignacion_de_capacitacion_okBorrar'] ) )
		{
			//
			// Borra la capacitacion seleccionada
			borra_capa_elegida($reg_dte) ;
			muestra_capas_elegidas($reg_dte,$edcn) ;
		}
	elseif ( isset($_POST['okSalir'] ) )
		//
		// Vuelve al inicio
		header('Location:accueil.php');
	else
		{
			//
			// Mustra capacitaciones Disponibles
			muestra_capas_disponibles($reg_dte,$edcn) ;
		}

	function muestra_capas_disponibles($reg_dte,$edcn)
		{
			//
			// Lista Capas
			//
			$LCapas = new Capas_a_Elegir_de_un_Rango() ;
			$LCapas->Pone_Edicion($edcn);
			$LCapas->Pone_paraDocente($reg_dte['Docente_Nro']);
			//
			// Arma la página
			$oculto = '<input type="hidden" name="m_nro_edicion" value="'.$edcn.'">';
			$pagina=new Paginai('Crono','<input type="submit" name="okSeleccion" value="Elegir"><input type="submit" name="ok_ver_elegidas" value="Var Capacitaciones Ya Elegidas"><input type="submit" value="Salir" name="okSalir">'.$oculto);
			$txt = ' Docente: '.$reg_dte['Docente_Nro'].' - '.$reg_dte['Apellido y Nombre'] ;			
			$pagina->insertarCuerpo($txt);
			$pagina->insertarCuerpo('<h1></h1>Seleccione las capacitaciones a las que puede asistir');
			$txt = 	$LCapas->txtMostrar();
			$pagina->insertarCuerpo($txt);
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
			//
			// Capacitaciones
			// 
		}
	//
	// Muestra capacitaciones para elegir
	//
	function muestra_capas_elegidas($reg_dte,$edcn)
		{
		$docente = $reg_dte['Docente_Nro'];
		$Solicitudes = new Solicitudes_de_Asignacion_de_Capacitacion() ;
		$Solicitudes->Set_id($docente);
		$Prof = new Docente() ;
		$Prof->Set_id($docente) ;
		$Prof->Leer() ;
		$profe = $Prof->Obtener_Registro() ;
		//
		//
		$pagina=new Paginai('Crono','</td><td><input type="submit" value="Salir" name="okSalir">');
		$txt = 'Docente: </td><td colspan="9"> '.$docente.' - '.$profe['Apellido y Nombre'];
		$pagina->insertarCuerpo($txt);
		//
		// Capacitaciones
		// 
		$txt='Capacitaciones Seleccionadas </td><td>'.$Solicitudes->texto_mostrar_abm() ;
		$pagina->insertarCuerpo($txt);
		$pagina->graficar_c_form($_SERVER['PHP_SELF']);
	
		}
	//
	// Borra una capacitacion
	//
	function borra_capa_elegida($reg_dte)
		{
		$docente = $reg_dte['Docente_Nro'];
		$Solicitudes = new Solicitudes_de_Asignacion_de_Capacitacion() ;
		$Solicitudes->Set_id($docente);
		$Solicitudes->borrar_desde_abm();
		}
	//
	// Agrega las capacitaciones
	//
	function agrega_capas($reg_dte,$edcn,$uid)
		{
		//
		// Lista Capas
		//
		$LCapas = new Capas_a_Elegir_de_un_Rango() ;
		$LCapas->Pone_Edicion($edcn);
		$LCapas->leer_lista();
		$regs = $LCapas->Obtener_Lista();
		//
		// Abre conexion con la base de datos
		$cn=new Conexion();
			while ($LCapas->existe == true and $reg=$regs->fetch_object() )		
				{
					$pref_capa = 'm_cap_rango_cronoid'.$reg->Crono_Id ;
					$nom_check = $pref_capa.'_check' ;
					if (  isset($_REQUEST [$nom_check] ) )
						{
							//
							// Inserta la seleccion
							$crono = $reg->Crono_Id;
							$strsql = "INSERT INTO solicitudes_de_asignacion_de_capacitacion
								 (Crono_Id, Docente_Nro, Estado_Solicitud) 
									VALUES ('$crono', '".$reg_dte['Docente_Nro']."', 'P')" ;
							$cn->conexion->query($strsql) ;
							if ($cn->conexion->connect_error )
						die("Problemas en el insert de solicitudes_de_asignacion_de_capacitacion : ".$cn->conexion->error.$strsql );
						}				
				}
			//
			// Cierra la conexion
			$cn->cerrar();

		}
?>
