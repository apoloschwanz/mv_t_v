<!-- clase fuera de uso
<?php
		//
		// Clases
		//
		require 'clases_base.php' ;
		require 'clases_anexo.php' ;
		require 'clases_crono.php' ;
		//
		// Variables
		//
		$mail = $_REQUEST['m_mail_capacitador'];
		//
		// Lista Capas
		//
		$uid = $_SESSION['uid']
		$Docente = new Docente() ;
		$Docente->Leer_x_mail($uid);
		$reg = $Docente->Obtener_Registro() ;
				
		if ( $Docente->existe == false )
				{
				echo 'Docente_Nro'.$reg['Docente_Nro'] ;
				die( 'No hay docente registrados con el mail '.$mail) ; 
				}
		else 
			{	
				//
				// Abre la pantalla para seleccionar mails
				header('Location:crono.php?m_docente_nro='.$reg['Docente_Nro']);
			}			
?>  
-->

