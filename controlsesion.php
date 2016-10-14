<?php
//
//
require_once 'db.php' ;
require_once 'clases_base.php';
require_once 'clase_entidad.php' ;
require_once 'clase_entidadi.php' ;
require_once 'class_paginai.php' ;
require_once 'utilisateur.php' ;
require_once 'clase_relacionj.php' ;
require_once 'clase_rolusuario.php' ;
require_once 'clase_funciones_y_roles.php' ;


//
// Inicia o restablece sesion
session_start();
//
// Levanta variables

//
// Si esta iniciando sesion
if (isset($_POST['iniciasesionok'] ) ) 
	{
	controla_inicio_sesion() ;
	controla_sesion_iniciada() ;
	}
else
	{
	controla_sesion_iniciada() ;
	}



/////////////////////////////////////////////////////
// Funciones ////////////////////////////////////////
/////////////////////////////////////////////////////

function controla_sesion_iniciada_nueva_version()
	{
		$uid = '';						// Id del usuario ( en general el mail )
		$pwd = '';						// Contraseña
		$ses = '';						// Id de la sesion ( no implementado aun )
		$uid_setter = '';				// Id del administrador que funciona como otro usuario
		$tb_uis_setter = false ;		// Flag que indica si un administrador se conecta como otro usuario
		if (isset( $_SESSION['uid'] ) ) 
			{
			$uid = $_SESSION['uid'];
			}
		if (isset($_SESSION['pwd']) ) 
			{
			$pwd = $_SESSION['pwd'];
			}
		if (isset($_SESSION['ses']) ) 
			{
			$ses = $_SESSION['ses'];
			}
		if (isset($_SESSION['uid_setter']) )
			{
			$uid_setter = $_SESSION['uid_setter'] ;
			$tb_uis_setter = true ;
			}
		// si hay uid_setter
			// busca el usuario y la contraseña con el id del uid_setter 
			// inner join con la tabla de id_setters ( / suddoers )
			
	}

function controla_sesion_iniciada ()
	{
		$uid = '';
		$pwd = '';
		$ses = '';
		if (isset( $_SESSION['uid'] ) ) 
			{
			$uid = $_SESSION['uid'];
			}
		if (isset($_SESSION['pwd']) ) 
			{
			$pwd = $_SESSION['pwd'];
			}
		if (isset($_SESSION['ses']) ) 
			{
			$ses = $_SESSION['ses'];
			}
		//
		// Abre conexion
		$cnx=new Conexion();
		//
		// Busca el usuario en la base de datos
		$strsql = "SELECT count(*) as existe FROM user WHERE
		userid = '$uid' AND password = '$pwd'";


		$registros=mysqli_query($cnx->conexion,$strsql) or
						die("Problemas en el select de usuarios: ".mysqli_error($cnx->conexion));
		//
		// Si encuentra el usuario
		if ( $registro = mysqli_fetch_array($registros ) ) {
			if ( $registro['existe'] == 1 )
				{
					//
					// Si el usuario existe .... 
					$func = new func() ;
					$func->Set_id($_SERVER['PHP_SELF']);
					$habilitado = $func->controlar_funcion($uid);
					//
					// y tiene accesso
					//continua la carga de la pagina que llamo a control sesion
					// antes actualiza último acceso
					if ( ! $habilitado )
					{
						//
						// si no tiene acceso muestra mensaje
						mostrar_funcion_no_habilitada() ;
					}
				}
			else
				{ unset($_SESSION['uid']);
					unset($_SESSION['pwd']);
					unset($_SESSION['ses']);
					//
					// Pide que inicie la sesion
					form_ingresa_usuario () ;
				}
			}
		else
			{ die( " error en el vector de registros" ) ;
			}
		//
		// Cierra Conexion
		$cnx->cerrar();
	}
/////////////////////////////////////////////////////


/////////////////////////////////////////////////////
// Funcion controla inicio sesion ///////////////////
/////////////////////////////////////////////////////
function controla_inicio_sesion () 
	{
	require_once 'db.php' ;
	//
	// Levanta variables 
	$uid = '';
	$pwd = '';
	if (isset($_POST['uid']) ) {
		$uid = $_POST['uid'];
		}
	if (isset($_POST['pwd']) ) {
		$pwd = $_POST['pwd'];
		}
	//
	// Abre conexion
	$cnx=new Conexion();
	//
	// Busca el usuario en la base de datos
	$strsql = "SELECT count(*) as existe FROM user WHERE
	userid = '$uid' AND password = '$pwd'";


	$registros=mysqli_query($cnx->conexion,$strsql) or
					die("Problemas en el select de usuarios: ".mysqli_error($cnx->conexion));
	//
	// Si encuentra el usuario
	if ( $registro = mysqli_fetch_array($registros ) ) {
		if ( $registro['existe'] == 1 )
			{
				//
				// Si el usuario existe crea una sesion
				$_SESSION['uid'] = $uid ;
				$_SESSION['pwd'] = $pwd ;
			}
		else
			{ unset($_SESSION['uid']);
				unset($_SESSION['pwd']);
				muestra_acceso_denegado() ;
			}
		}
	else
		{ die( " error en el vector de registros" ) ;
		}
	//
	// Cierra Conexion
	$cnx->cerrar();
}
/////////////////////////////////////////////////////


function mostrar_funcion_no_habilitada() {
	$botones = '<input type="submit" name="ok" value="   OK   " />' ;
	$pagina = new paginai('Funcion no habilitada',$botones) ;
	$pagina->sinborde();
	$texto = ' <table>
			<tr><td> Esta función requiere habilitacion por parte del coordinador. </td></tr>
			</table>' ;
	$pagina->insertarCuerpo($texto);
	$pagina->graficar_c_form('salir.php');
	exit;
}

/////////////////////////////////////////////////////
// Funcion Ingresa Usuario //////////////////////////
/////////////////////////////////////////////////////
function form_ingresa_usuario() {
	$boton = '<input type="submit" name= "iniciasesionok" value="Iniciar Sesión" />' ;
	$pagina1=new Paginai('Inicio Sesión', $boton );
	$pagina1->sinborde();
	$txt = '<h3> Se requiere iniciar sesión. </h3>';
	$pagina1->insertarCuerpo($txt) ;
	$txt = '<p>Debe iniciar sesion en el sistema para acceder a esta pagina. si aun
	no se a registrado, <a href="registrarse.php">haga click aquí</a>
	para registrarse</p>' ;
	$txt = 'Email: <input type="text" name="uid" size="90" placeholder="Ingrese su correo electrónico" autofocus /><br />';
	$pagina1->insertarCuerpo($txt) ;
	$txt = 'Clave: <input type="password" name="pwd" SIZE="90" /><br />';
	$pagina1->insertarCuerpo($txt) ;
	$accion = $_SERVER['PHP_SELF'];
	$pagina1->graficar_c_form($accion);
	exit;
	}
function form_ingresa_usuario_ol() {

?>
<!DOCTYPE html>
<html>
<head>
<title> Por favor inicie sesión </title>
<meta http-equiv="Content-Type"
content="text/html; charset=utf-8" />
</head>
<body>
<h1> Se requiere iniciar sesión. </h1>
<p>Debe iniciar sesion en el sistema para acceder a esta pagina. si aun
no se a registrado, <a href="registrarse.php">haga click aquí</a>
para registrarse</p>
<p><form method="post" action="<?=$_SERVER['PHP_SELF']?>">
Email: <input type="text" name="uid" size="90" placeholder="Ingrese su correo electrónico" autofocus /><br />
Clave: <input type="password" name="pwd" SIZE="90" /><br />
<input type="submit" name= "iniciasesionok" value="Iniciar Sesión" />
</form></p>
</body>
</html>
<?php
exit;
	}
/////////////////////////////////////////////////////

/////////////////////////////////////////////////////
// Función Muestra acceso denegado //////////////////
/////////////////////////////////////////////////////
function muestra_acceso_denegado () {
	
	// 
	// Borra la sesion
	unset($_SESSION['uid']);
	unset($_SESSION['pwd']);	
	//
	// Muestra mensaje
	$pagina1=new Paginai('Acceso Denegado', '' );
	$pagina1->sinborde();
	$txt = '<h2> Acceso Denegado </h2>';
	$pagina1->insertarCuerpo($txt) ;
	$txt = '<p>Su nombre de usuario o correctos, o no se encuentra registrado en el sitio. 
	Para intentar ingresar de nuevo <a href="'.$_SERVER['PHP_SELF'].'">haga click aquí</a>. 
	si aun no se ha registrado, <a href="registrarse.php">haga click aquí</a>
	para registrarse</p>' ;
	$txt = '<p>Su nombre de usuario o correctos, o no se encuentra registrado en el sitio. 
	Para intentar ingresar de nuevo <a href="'.$_SERVER['PHP_SELF'].'">haga click aquí</a>. </p>' ;
	$pagina1->insertarCuerpo($txt) ;
	//$txt = 'Email: <input type="text" name="uid" size="90" placeholder="Ingrese su correo electrónico" autofocus /><br />';
	//$pagina1->insertarCuerpo($txt) ;
	//$txt = 'Clave: <input type="password" name="pwd" SIZE="90" /><br />';
	//$pagina1->insertarCuerpo($txt) ;
	//$accion = $_SERVER['PHP_SELF'];
	$pagina1->graficar();
	exit;

}
	function muestra_acceso_denegado_ol () {

// 
// Borra la sesion
unset($_SESSION['uid']);
unset($_SESSION['pwd']);


?>

<!DOCTYPE html">
<head>
<title> Access Denied </title>
<meta http-equiv="Content-Type"
content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1> Access Denied </h1>
<p>Your user ID or password is incorrect, or you are not a
registered user on this site. To try logging in again, click
<a href="<?=$_SERVER['PHP_SELF']?>">here</a>. To register for instant
access, click <a href="registrarse.php">here</a>.</p>
</body>
</html>

<?php
	exit;
	}
?>
