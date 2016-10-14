<?php

require_once 'db.php' ;
require_once 'controlsesion.php' ; 
require_once 'clases_base.php' ;
require_once 'utilisateur.php' ;
require_once 'class_paginai.php';
require_once 'sitio.php' ;

if( isset($_POST['okregistrarse']) )
{
	//
	// Registra el nuevo usuario
	//
	$utls = new utilisateur();
	$utls->Pone_Nom($_POST['newid']) ;
	$utls->Pone_Ape_y_Nom($_POST['newname']) ;
	$utls->Pone_Tel($_POST['newtel']);
	$utls->Pone_Comentario($_POST['newnotes']) ;
	$sitio = new sitio();
	$nouvellemot =  substr(md5(time()),0,6);
	$utls->Pone_Mot($nouvellemot) ;
	//
	// Busca si el usuario existe
	$utls->Buscar() ;
	if ( $utls->existe )
		{ 
			mostrar_pagina('El usuario ya existe!') ;
		}
	else
		{
		$utls->Agregar();
		if ( $utls->hay_error() )
			{echo '<table><tr><td> Se produjo un error '.$utls->textoError().'</td></tr></table>' ;
			}
		else
			{ 

				$to = $_POST['newid'];
				$subject = "Nueva Constraseña";
				$txt = 'Ha sido registrado en el sitio '.$sitio->nombre.'. Su contraseña es: '.$nouvellemot ;
				$headers = "From: ".$sitio->mailremitente . "\r\n" . "CC: daniel.zabalet@gmail.com";
				mail($to,$subject,$txt,$headers);
				mostrar_alta() ; 
			}
		}
}
else
{ mostrar_pagina('') ;
}

 ;

?>

<?php

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
	$botones = $botones.'<input type="submit" name="okregistrarse" value="   OK   " />' ;
	$pagina = new paginai('Alta de Usuario',$botones) ;
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
				<input name="newid" type="text" maxlength="100" size="35" placeholder = "nombre@ejemplo.com" />
				<font color="orangered" size="+1"><tt><b>*</b></tt></font>' ;
	$pagina->insertarCuerpo($texto);
	$texto = '<p>Nombre Completo</p>
			  </td>
			  <td>
				<input name="newname" type="text" maxlength="100" size="35" placeholder = "Apellido, Nombre"/>
				<font color="orangered" size="+1"><tt><b>*</b></tt></font>' ;
	$pagina->insertarCuerpo($texto);			
	$texto = '<p>Tel. de Contacto</p>
			  </td>
			  <td>
				<input name="newtel" type="text" maxlength="100" size="35" />
				<font color="orangered" size="+1"><tt><b>*</b></tt></font>' ;
	$pagina->insertarCuerpo($texto);			
	$texto = '<p>Comentarios</p>
			  </td>
			  <td>
			<textarea wrap="soft" name="newnotes" rows="5" cols="30"></textarea>' ;
	$pagina->insertarCuerpo($texto);			
	
	$pagina->graficar_c_form($_SERVER['PHP_SELF']);
}


function mostrar_alta() {
	$sitio = new sitio();
	$botones = '<input type="submit" name="ok" value="   OK   " />' ;
	$pagina = new paginai('Alta de Usuario',$botones) ;
	$pagina->sinborde() ;
	$texto = ' <table>
			<tr><td> Usuario Dado de Alta </td></tr>
			<tr><td> Se envio un mail con la contraseña, desde ' . $sitio->mailremitente . ', a su casilla de correo </td></tr>
			</table>' ;
	$pagina->insertarCuerpo($texto);
	$pagina->graficar_c_form('accueil.php');
}


