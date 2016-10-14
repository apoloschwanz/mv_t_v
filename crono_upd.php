<!-- objeto en desuso
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
		$edcn = $_REQUEST['m_nro_edicion'];
		$mail = $_REQUEST['m_mail_capacitador'];
		$docente = $_REQUEST['m_docente_nro'];
		//
		// Lista Capas
		//
		$LCapas = new Capas_de_un_Rango() ;
		$LCapas->Pone_Edicion($edcn);
		$LCapas->leer_lista();
		$regs = $LCapas->Obtener_Lista();
		//		
		if ( $LCapas->existe == false )
				{
				die( 'No hay capacitaciones para la edicion '.$this->edicion) ; 
				}
		else 
			{	
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
											VALUES ('$crono', '$docente', 'P')" ;
									$cn->conexion->query($strsql) ;
									if ($cn->conexion->connect_error )
								die("Problemas en el insert de solicitudes_de_asignacion_de_capacitacion : ".$cn->conexion->error.$strsql );
								echo '<br> Uste eligió'. $reg->Crono_Id . ' para el mail = '. $mail ;
								}				
						}
					//
					// Cierra la conexion
					$cn->cerrar();
			}			
		//$mysql=new mysqli("localhost","root","","base1");
    //if ($mysql->connect_error)
    //  die("Problemas con la conexión a la base de datos");
  
    //$mysql->query("delete from articulos where codigo=$_REQUEST[codigo]") or
    //    die($mysql->error);    
    
    //$mysql->close();
    
    header('Location:solicitudes_de_asignacion_de_capacitacion.php?m_docente_nro='.$docente);
?>  
-->
