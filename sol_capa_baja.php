<!-- Objeto en desuso
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
		// Id de Docente
		$docente = $_REQUEST['m_docente_nro'];
		//
		// Id de Capacitacion
		$crono_id = $_REQUEST['crn'];
		//
		// Lista Capas
		//
		//
		// Abre conexion con la base de datos
		$cn=new Conexion();
		$strsql = "DELETE FROM solicitudes_de_asignacion_de_capacitacion
										 WHERE Crono_Id = '".$crono_id."' AND Docente_Nro = '".$docente."'" ;
		$cn->conexion->query($strsql) ;
		if ($cn->conexion->connect_error )
			{
					die("Problemas en el delete de solicitudes_de_asignacion_de_capacitacion : ".$cn->conexion->error.$strsql );
					echo '<br> Uste eligió'. $reg->Crono_Id . ' para el mail = '. $mail ;
			}				
		//
		// Cierra la conexion
		$cn->cerrar();
		//
		// Abre la pantalla para seleccionar mails
		header('Location:solicitudes_de_asignacion_de_capacitacion.php?m_docente_nro='.$docente);
		//echo 'Docente'.$docente.' Crono_id'.$crono_id.'<br> '.$strsql ;		
?>->
