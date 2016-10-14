<?php
	//
	// Control Sesion
	require_once 'controlsesion.php' ;
	//
	// Inclusion de clases 
	//require_once 'clases_base.php' ;
	//require_once 'clases_anexo.php' ;
	//require_once 'clases_crono.php' ;
	require_once 'class_paginai.php' ;
	
	//
	// Opcionales
	//
	
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
	
	
	//
	// Basicos
	//
	
	//
	// Clase de la entidad
	require_once 'clases_llamados.php' ;
	//
	// Instancia Entidad
	$pagina = new resumen_capas_p_llamados() ;
	
	//
	// Mustra Pagina Web de la entidad
	$pagina->mostrar_pagina_lista();

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


