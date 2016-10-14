<?php 
		require_once 'controlsesion.php' ;
		require_once 'clases_base.php' ;
		require_once 'class_paginai.php' ;
		require_once 'utilisateur.php' ;
		//
		// Obtiene Id de usuario de la sesion
		if ( isset( $_SESSION['uid'] ) )
		{
			$uid = $_SESSION['uid'] ; 
		}
		else
		{
			die('No se puedo identificar al usuario');
		}
		//
		// Ingresó nueva clave
		if( isset( $_POST['cambiamotok'] ))
			{
				// Valida datos
				$hayerror = false ;
				$pwd = $_REQUEST['pwd'] ;
				$pwdnew = $_REQUEST['pwdnew'] ;
				$pwdnew2 = $_REQUEST['pwdnew2'] ;		
				if ( $pwdnew != $pwdnew2 )
					{
					$hayerror = true;
					$texto = 'Las claves no coinciden';
					}
				if ( $hayerror ) pide_cambio($texto);
				else  
					{ 
						$utls = new utilisateur();
						$utls->Pone_Nom($uid);
						$utls->Pone_Mot($pwd);
						$utls->Pone_nouvel_mot($pwdnew);
						$cambiado = $utls->Changer_Mot();
						if ( $cambiado )
						{
							mot_cambiado();
						}
						else
						{	
							$texto = $utls->textoError ;
							pide_cambio($texto);
						}
					}
			}
		//
		// Ocion Inicial
		else
			{
				//
				// Pide nueva clave
				pide_cambio('');
			}	

function pide_cambio($mje) {

		$accion = $_SERVER['PHP_SELF'];
		$txtboton = 'Cambiar' ;
		//$boton = '&nbsp' ;
		$boton = '</td><td><input type="submit" name="cambiamotok" value="'.$txtboton.'">' ;
		$pagina1=new Paginai('Cambio de Clave', $boton );
		$pagina1->sinborde();
		if ( ! empty($mje ) )
		{
				$txt_cuerpo = 'Error: </td><td>'.$mje ;
				$pagina1->insertarCuerpo($txt_cuerpo) ;
		}
		$txt_cuerpo = 'Clave Anterior: </td><td><input type="password" name="pwd" SIZE="100" />' ;
		$pagina1->insertarCuerpo($txt_cuerpo ) ;
		$txt_cuerpo = 'Clave Nueva: </td><td><input type="password" name="pwdnew" SIZE="100" />' ;
		$pagina1->insertarCuerpo($txt_cuerpo ) ;
		$txt_cuerpo = 'Repita Clave Nueva: </td><td><input type="password" name="pwdnew2" SIZE="100" />' ;
		$pagina1->insertarCuerpo($txt_cuerpo ) ;
		$pagina1->graficar_c_form($accion);
	} // Cierra Funcion Pide_Cambio



function mot_cambiado() {

		$accion = 'accueil.php';
		$boton = '&nbsp' ;
		$boton = '<input type="submit" name="okSalir" value="OK">' ;
		$pagina1=new Paginai('Cambio de Clave', $boton );
		$pagina1->sinborde();
		$pagina1->insertarCuerpo('&nbsp;') ;
		$txt_cuerpo = 'La clave fue cambiada ! Vuelva a iniciar sesion con su nueva clave. ' ;
		$pagina1->insertarCuerpo($txt_cuerpo ) ;
		$pagina1->graficar_c_form($accion);

	} 
?>




