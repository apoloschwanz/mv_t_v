<?php
	require_once 'controlsesion.php' ; 
	require_once 'clases_base.php' ;
	require_once 'clases_anexo.php' ;
	require_once 'clases_crono.php' ;
	require_once 'class_paginai.php' ;
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
	// Usuario
	//
	$uid = $_SESSION['uid'] ;
	//
	// Instancia clases
	//
	$Entidad = new Crono() ;
	$Entidad->Pone_Edicion($edcn);
	//
	// Manejo de Eventos
	//	
	$okVer = $Entidad->obtiene_prefijo_campo().'okVer' ;
	$okModificar = $Entidad->obtiene_prefijo_campo().'okModificar' ;
	$okagregar = $Entidad->obtiene_prefijo_campo().'_okAgregar' ;
	$okborrar  = $Entidad->obtiene_prefijo_campo().'_okBorrar' ;
	$okAsignarDte = $Entidad->obtiene_prefijo_campo().'okAsignarDte' ;
	$okAsignarCoord = $Entidad->obtiene_prefijo_campo().'okAsignarCordo' ;
	$okExportar = $Entidad->okExportar ;
	if ( isset($_POST[$okVer]) )
		{
			//
			// Mustra capacitaciones Disponibles
			muestra_ver($Entidad) ;
		}
	elseif ( isset($_POST[$okExportar]) )
		{
			$ts_archivo = $Entidad->exportar_a_archivo();
			$Entidad->bajar_archivo($ts_archivo);
		}
	elseif ( isset($_GET[$okAsignarDte]) )
		{
			$nomid= $Entidad->obtiene_prefijo_campo().'_Id' ;
			header('Location:crono_asignar_docente.php?'.$nomid.'='.$_REQUEST[$nomid]) ;
		}
	elseif ( isset($_GET[$okAsignarCoord]) )
		{
			$nomid= $Entidad->obtiene_prefijo_campo().'_Id' ;
			header('Location:crono_asignar_coordinador.php?'.$nomid.'='.$_REQUEST[$nomid]) ;
		}
	elseif ( isset($_GET[$okModificar]) )
		{
			//
			// Edita
			$nomid= $Entidad->obtiene_prefijo_campo().'_Id' ;
			$Entidad->Set_id($_REQUEST[$nomid]) ;
			muestra_modificar($Entidad) ;
		}
	elseif ( isset($_POST['okGrabaActualizar']) )
		{
			// Graba Modificaciones
			$Entidad->texto_actualizar_okGrabar();
			if ( $Entidad->hay_error() == true ) muestra_error($Entidad) ;
			else muestra_ok('Registro # '.$Entidad->id().' actualizado') ;
		}
	elseif ( isset($_POST['okGrabaAgregar']) )
		{
			// Graba Modificaciones
			$Entidad->texto_agregar_okGrabar();
			if ( $Entidad->hay_error() == true ) muestra_error($Entidad) ;
			else muestra_ok('Registro # '.$Entidad->id().' agregado') ;
		}
	elseif ( isset($_POST[$okagregar]) )
		{
			//
			// Muestra Alta
			muestra_alta($Entidad) ;
		}
	elseif ( isset($_POST[$okborrar] ) )
		{
			// Borra Capacitaciones
			$Entidad->texto_okBorrarSeleccion();
			if ( $Entidad->hay_error() == true ) muestra_error($Entidad) ;
			else muestra_lista($Entidad)  ;
		}
	elseif ( isset($_POST['okSalir'] ) )
		//
		// Vuelve al inicio
		header('Location:accueil.php');
	else
		{
			//
			// Mustra lista
			muestra_lista($Entidad) ;
		}


//
// Formularios
//
	function muestra_borrar($Entidad)
		{
			//
			// Arma la página
			$pagina=new Paginai('Crono','<input type="submit" value="Borrar" name="okGrabaBorrar"><input type="submit" value="Salir" name="okSalir">');
			$txt = $Entidad->texto_ver() ;
			$pagina->insertarCuerpo($txt);
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
		}
	function muestra_modificar($Entidad)
		{
			//
			// Arma la página
			$pagina=new Paginai('Crono','<input type="submit" value="Grabar" name="okGrabaActualizar"><input type="submit" value="Salir" name="okSalir">');
			$txt = 	$Entidad->texto_actualizar();
			$pagina->insertarCuerpo($txt);
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
		}


	function muestra_lista($Entidad)
		{
			//
			// Arma la página
			$pagina=new Paginai('Crono','<input type="submit" value="Salir" name="okSalir">');
			$txt = 	$Entidad->texto_mostrar_abm();
			$pagina->insertarCuerpo($txt);
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
		}

	function muestra_alta($Entidad)
		{
			//
			// Arma la página
			$pagina=new Paginai('Crono','<input type="submit" value="Grabar" name="okGrabaAgregar"><input type="submit" value="Salir" name="okSalir">');
			$txt = 	$Entidad->texto_agregar();
			$pagina->insertarCuerpo($txt);
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
		}

	function muestra_error($Entidad)
		{
			$pagina=new Paginai('Crono','<input type="submit" value="Ok" name="okError">');
			$txt = 	$Entidad->textoError() ;
			$pagina->insertarCuerpo($txt);
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
		}
	function muestra_ok($texto)
		{
			$pagina=new Paginai('Crono','<input type="submit" value="Ok" name="okMje">');
			$txt = 	$texto ;
			$pagina->insertarCuerpo($txt);
			$pagina->graficar_c_form($_SERVER['PHP_SELF']);
		}
	function actualizar($Entidad)
		{
			//
			//
		}

?>


<!-- 

Paera tener en cuenta

<select>

    <optgroup label="Obligatorias">
    <option value="mat">Matem&aacute;ticas</option>
    <option value="len">Lenguaje</option>
    </optgroup>

    <optgroup label="Optativas">
    <option value="cor">Corte y confecci&oacute;n</option>
    <option value="ast">Astronom&iacute;a</option>
    </optgroup>

</select> 


"Solicitantes"
"Disponibles"
"En el estabecimiento"
"De otras comunas"
"Ocupados"



Parámetros comunes

La mayoría de los elementos de un formulario cuentan con algunos parámetros comunes muy útiles:

    size: en los cuadros de texto se emplea para definir el tamaño del campo. Por ejemplo size="20".
    maxlenght: también en los cuadros de texto nos servirá para limitar el tamaño. Por ejemplo: <input type="text" name="telefono" maxlenght="9" size="9" />
    readonly: en los cuadros de texto hace que el valor sea de sólo lectura, que no se pueda cambiar. Por ejemplo: <input type="text" name="pais" readonly="readonly" />España
    disabled: hace que el elemento se encuentre desactivado y no se pueda modificar. Sirve con varios elementos diferentes. Se añade así: disabled="disabled"
    placeholder: permite añadir un texto dentro del cuadro, que desaparece automáticamente al hacer clic sobre él. Son muy útiles para incorporar pequeñas indicaciones sobre el valor que se espera. Se añade así: placeholder="Introduce tu nombre"
    tabindex: es habitual desplazarse por un formulario presionando la tecla Tab para avanzar al campo siguiente o Mayús-Tab para ir al anterior. Mediante tabindex podemos modificar el orden de esos saltos entre los campos de nuestro formulario. Iremos numerando cada campo mediante un número, así : <input type="password" name="clave" tabindex="1" />



-->


