
<?php

//
// Agrega Docentes desde usuarios_registrados
// 

require_once 'db.php' ;
require_once 'clases_base.php' ;
require_once 'clase_entidad.php';
require_once 'clase_entidadi.php' ;
require_once 'utilisateur.php' ;
require_once 'clase_docente.php' ;
require_once 'class_paginai.php';
require_once 'clase_persona.php';


$cn=new Conexion();	


$pagina = new Paginai('Docentes Registrados','') ;
$accion = $_SERVER['PHP_SELF'] ;
//
// Lista Docentes
$strsql = "SELECT usuarios_registrados.mail,usuarios_registrados.apeynom,celular,personas.`Apellido y Nombre` as perape FROM `usuarios_registrados`
			LEFT JOIN `usuarios_registrados_celulares` 
			ON usuarios_registrados_celulares.mail = usuarios_registrados.mail
            LEFT JOIN docente
            ON docente.EMAIL = usuarios_registrados.mail
            LEFT JOIN personas 
            ON docente.Persona_Id = personas.Persona_Id
			order by usuarios_registrados.apeynom, usuarios_registrados.mail" ;
			
$usuarios = mysqli_query($cn->conexion,$strsql) or
				die("Problemas en el select de usuarios registrados <br> Sql: <br>".$strsql.'<br> Error: <br>'.mysqli_error($cn->conexion));


$dte = new Docente();
if ( isset( $_GET['agregar_dte'] ) )
{
	$mail_docente_a_agregar = $_GET['agregar_dte'] ;
	$agregar = true ;
}
else $agregar = false ;


while( $usuario=mysqli_fetch_array($usuarios,MYSQLI_ASSOC) )
{	
	//
	// Busca Docente
	$dte->Leer_x_mail($usuario['mail']);
	if ( $dte->existe ) $id_docente = $dte->id() ;
	else 
	{
		$id_docente = '<a href="'.$accion.'?agregar_dte='.$usuario['mail'].'" > Agregar </a>' ;
		if ( $agregar and $mail_docente_a_agregar == $usuario['mail'] )
		{
			Agregar_Docente($cn,$dte,$mail_docente_a_agregar,$usuario['apeynom'],$usuario['celular']) ;
			$id_docente = 'Agregado con Id'.$dte->id() ;
		}
	}
	$texto = $usuario['mail'].'</td><td>'.$usuario['apeynom'].'</td><td>'.$usuario['celular'].'</td><td> Registrado como:'.$usuario['perape'].'</td><td>'.$id_docente ;
	$pagina->insertarCuerpo($texto) ;
	
	
}


$pagina->graficar_c_form($accion) ;




$cn->cerrar();
function Agregar_Docente($cn,$dte,$mail_docente_a_agregar,$apeynom,$tel)
	{
		//
		// Busca el código de docente
		$dte->Leer_x_mail($mail_docente_a_agregar);
		if ( ! $dte->existe )
			{ 
				//
				// Agrega Persona
				$pers = new persona() ;
				$pers->agregar($apeynom,$tel,$mail_docente_a_agregar);
				//
				// Agrega el Docente
				$dte->Agrega_Docente($mail_docente_a_agregar,$apeynom,$tel,$pers->id()) ;
			}
		else
			die('Intento agregar un docente que ya existia');
		
		
		return $dte->id() ;
		
	}


?>
