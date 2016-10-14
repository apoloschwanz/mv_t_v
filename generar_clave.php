<?php
include_once 'db.php' ;
include_once 'clases_base.php' ;
include_once 'clase_docente.php' ;
include_once 'clase_persona.php' ;
include_once 'utilisateur.php' ;
include_once 'class_paginai.php';
include_once 'sitio.php' ;

//
// Si confirma cambia la clave
if( isset($_POST['okcambioclave']) )
{
	$utls = new utilisateur();
	$utls->Pone_Nom($_POST['user_id']) ;
	$sitio = new sitio();
	$nouvellemot =  substr(md5(time()),0,6);
	$utls->Pone_Mot($nouvellemot) ;
	//
	// Busca si el usuario existe
	$utls->Buscar() ;
	if ( ! $utls->existe )
		{ 
			mostrar_pagina('El usuario no existe!') ;
		}
	else
		{
		$nouvellemot = $utls->Generar_Clave_Nueva();
		if ( $utls->hay_error() )
			{echo '<table><tr><td> Se produjo un error '.$utls->textoError().'</td></tr></table>' ;
			}
		else
			{ 

				$to = $_POST['user_id'];
				$subject = "Nueva Constraseña";
				$txt = 'Se ha generado automáticamente una nueva clave para su usuario. Para cambiarla ingrese a http://'.$sitio->nombre.' . Su contraseña es: '.$nouvellemot ;
				$headers = "From: ".$sitio->mailremitente . "\r\n" ;
				mail($to,$subject,$txt,$headers);
				$txt = 'Se cmabio la clave para el usuario cuyo mail es : '.$_POST['user_id']. '. ';
				$txt = "/n".'Se le envió un mail con la contraseña ' ;
				mail('daniel.zabalet@gmail.com',' Cambio contraseña ',$txt,$headers ) ;
				mostrar_cambio() ; 
			}
		}
}
else
{ mostrar_pagina('') ;
}

function mostrar_pagina($mje)
{	//
	// Rol
	if ( isset($_REQUEST['m_rol']) )
		$rol = $_REQUEST['m_rol'] ;
	else
		$rol = 'usuario' ;
		
	$botones = '<p><font color="orangered" size="+1"><tt><b>*</b></tt></font> Dato necesario </p></td><td>' ;
	$botones .= '<input type="hidden" name="m_rol" value="$rol" /> ' ;
	$botones = $botones.'<input type="reset" value="Blanquear Formulario" />';
	$botones = $botones.'<input type="submit" name="okcambioclave" value="   Generar Nueva Contraseña   " />' ;
	$pagina = new paginai('Generacion de Nueva Clave',$botones) ;
	$pagina->sinborde() ;
	//
	// Mensaje
	if ( ! empty( $mje ) )
	{
		$texto = '</td><td><font size="+1">'.$mje.'</font>';
		$pagina->insertarCuerpo($texto);
	}
	$texto = '<p>Mail de Contacto</p>
				</td>
				<td>
				<input name="user_id" type="text" maxlength="100" size="35" placeholder = "nombre@ejemplo.com" />
				<font color="orangered" size="+1"><tt><b>*</b></tt></font>' ;
	$pagina->insertarCuerpo($texto);
	
	$pagina->graficar_c_form($_SERVER['PHP_SELF']);
}

function mostrar_cambio() {
	$sitio = new sitio();
	$botones = '<input type="submit" name="ok" value="   OK   " />' ;
	$pagina = new paginai('Contraseña Cambiada',$botones) ;
	$pagina->sinborde() ;
	$texto = ' <table>
			<tr><td> Cambio efectuado </td></tr>
			<tr><td> Se envio un mail con la contraseña, desde ' . $sitio->mailremitente . ', a la casilla de correo del usuario </td></tr>
			</table>' ;
	$pagina->insertarCuerpo($texto);
	$pagina->graficar_c_form('accueil.php');
}

?>
