<?php


class utilisateur extends entidad {
	protected $nom ;
	protected $mot ;
	protected $apeynom ;
	protected $tel;
	protected $comentario ;
	protected $rol ;
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Utilisateur" ;
			$this->nombre_fisico_tabla = "user" ;
		}
	public function Pone_Tel($tel)
		{
			$this->tel = $tel ;
		}
	public function Pone_nouvel_mot ($nmot)
		{
			$this->nouvel_mot = $nmot ;
		}
	protected function Pone_nombre_pag ()
		{
			$this->nombre_pagina = "utilisateur" ;
		}
	protected function Carga_Sql_Lectura()
	{
	$this->strsql = "SELECT userid, fullname
			FROM ".$this->nombre_fisico_tabla." 
			WHERE userid = '" .$this->id."' " ;
	}
	public function apeynom()
	{
		return $this->apeynom ;
	}
	public function Generar_Clave_Nueva()
	{
		$clave_nueva = substr(md5(time()),0,8);
		$this->error = false ;
		$this->textoError = false;
		$this->Buscar() ;
		if ( $this->existe == false )
		{
			$this->error = true ;
			$this->textoError = ' Usuario no registrado ' ;
		}
		if ( $this->error == false )
		{
			$cn = new Conexion() ;
			$this->strsql = " UPDATE user SET password = '".$clave_nueva."'
								WHERE userid = '".$this->nom."' "  ;
			$cambiado = $cn->conexion->query( $this->strsql ) ;
			if ( ! $cambiado )
			{
				echo '<br> NO Cambiado ! <br>' ;
				$this->error = true ;
				$this->textoError = ' Error en el update de usuario ' ;
			}
			else
			{
			$retorno_ok = true ;
			}
		}
	return $clave_nueva ;
	}
	public function Changer_Mot()
	{
		$retorno_ok = false ;
		$this->error = false ;
		$this->textoError = false;
		$this->Buscar() ;
		if ( $this->existe == false )
		{
			$this->error = true ;
			$this->textoError = ' Usuario no registrado ' ;
		}
		if ( $this->error == false and $this->mot == $this->nouvel_mot )
		{
			$this->error = true ;
			$this->textoError = ' La nueva clave no puede ser igual a la anterior, intente nuevamente.' ;
		}
		if ( $this->error == false )
		{
			$this->Verifier_mot();
			if ( $this->existe == false )
			{
				$this->error = true ;
				$this->textoError = ' Contraseña incorrecta, vuelva a intentar. ' ;
			}
		}
		if ( $this->error == false )
		{
			$cn = new Conexion() ;
			$this->strsql = " UPDATE user SET password = '".$this->nouvel_mot."'
								WHERE userid = '".$this->nom."' 
								AND password = '".$this->mot."' " ;
			$cambiado = $cn->conexion->query( $this->strsql ) ;
			if ( ! $cambiado )
			{
				echo '<br> NO Cambiado ! <br>' ;
				$this->error = true ;
				$this->textoError = ' Error en el update de usuario ' ;
			}
			else
			{
			$retorno_ok = true ;
			}
		}
	return $retorno_ok ;
	}
	public function Verifier_mot()
	{
		$cn = new Conexion() ;
		$this->strsql = "SELECT count(*) as cant FROM user WHERE
		userid = '".$this->nom."' AND password = '".$this->mot."'";
		if ( $this->registros = $cn->conexion->query($this->strsql) )
		{
			if ( $this->registro = mysqli_fetch_array($this->registros ) )
			{
				if ( $this->registro['cant'] > 0 )
					{
						$this->existe = true ;
					}
					else
					{
						$this->existe = false ;
					}
				mysqli_data_seek( $this->registros , 0 ) ;
			}
					
		}
		else die('Problemas en utilisateru 44');
	}
	public function Leer()
	{ $this->Carga_Sql_Lectura();		
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el select de lectura de los datos del usuario " );
		$cn->cerrar();
		if ( $this->registro=mysqli_fetch_array($this->registros) )
			{
				$this->existe = true ;
				$this->nom = $this->registro['userid'];
				$this->apeynom = $this->registro['fullname'];
				mysqli_data_seek ( $this->registros , 0 ) ;	
			}
		else
			{
				$this->existe = false ;
			}
		//$this->Leer_Detalle();
		//
		// Rol
		if ( $this->id == 'delfinalarriva@gmail.com' ) $this->rol = 'admin' ;
		elseif (  $this->id == 'martin.lerner10@gmail.com' ) $this->rol = 'admin' ;
		elseif (  $this->id == 'daniel.zabalet@gmail.com' ) $this->rol = 'dev' ;
		else $this->rol = 'usuario' ;
		
		
	}

	public function Pone_Nom($nom)
	{
	$this->nom = $this->sanear_string($nom);
	}
	public function Pone_Ape_y_Nom($apeynom)
	{
		$this->apeynom = $this->sanear_string($apeynom) ;
	}
	public function Pone_Mot($mot)
	{
	$this->mot = $this->sanear_string($mot) ;
	}
	public function Pone_Comentario($comentario)
	{
		$this->comentario = $this->sanear_string($comentario) ;
	}
	public function Buscar ()
	{
		$cn=new Conexion();
		//
		// busca si el usuario existe
		$this->strsql = "Select count(*) as cant from user WHERE userid = '".$this->nom."' " ;		
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el select de ".$this->nombre_tabla.": ".mysqli_error($cn->conexion));
		if ( $this->registro=mysqli_fetch_array($this->registros) )
			{
				if ( $this->registro['cant'] > 0 )
				{
					$this->existe = true ;
				}
				else
				{
					$this->existe = false ;
				}
				mysqli_data_seek( $this->registros , 0 ) ;
			}
		else
			{
				die("Problemas en el select de ".$this->nombre_tabla ) ;
			}
		$cn->cerrar();
	}
	
	public function Agregar_Docente()
	{
		//
		// busca si el usuario existe
		$this->error = false ;
		$this->Buscar() ;
		if ( $this->existe )
		{
			$this->error = true ;
		}
		else
		{
		$cn=new Conexion();		
		//$this->strsql = "insert into user ( userid , password ) values ( '".$this->nom."' , PASSWORD('".$this->mot."') )" ;
		$this->strsql = "insert into user ( userid , password , fullname , notes , tel ) values ( '".$this->nom."' , '".$this->mot."' , '".$this->apeynom."' , '".$this->comentario."' , '".$this->tel."' )" ;		
 		//echo $this->strsql ;
		mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el select de al agregar usuario");
				
		//
		// Busca el código de docente
		$dte = new Docente();
		$dte->Leer_x_mail($this->nom);
		if ( ! $dte->existe )
			{ 
				//
				// Agrega Persona
				$pers = new persona() ;
				$pers->agregar($this->apeynom,$this->tel,$this->nom);
				//
				// Agrega el Docente
				$dte->Agrega_Docente($this->nom,$this->apeynom,$this->tel,$pers->id()) ;
			}
		
		
		$cn->cerrar();
		return $dte->id() ;
		}
	}

	public function Agregar ()
	{
		//
		// busca si el usuario existe
		$this->error = false ;
		$this->Buscar() ;
		if ( $this->existe )
		{
			$this->error = true ;
		}
		else
		{
		$cn=new Conexion();		
		//$this->strsql = "insert into user ( userid , password ) values ( '".$this->nom."' , PASSWORD('".$this->mot."') )" ;
		$this->strsql = "insert into user ( userid , password , fullname , notes , tel ) values ( '".$this->nom."' , '".$this->mot."' , '".$this->apeynom."' , '".$this->comentario."' , '".$this->tel."' )" ;		
 		//echo $this->strsql ;
		mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el select de ".$this->nombre_tabla.": ".mysqli_error($cn->conexion));
		$cn->cerrar();
		}
	}

	public function Crear_Tabla ()
	{
		$this->strsql = " CREATE TABLE IF NOT EXISTS `user` (
				`userid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
				`password` char(100) COLLATE utf8_unicode_ci NOT NULL,
				`fullname` varchar(100) COLLATE utf8_unicode_ci ,
				`notes` text COLLATE utf8_unicode_ci ;
				ALTER TABLE user ADD tel varchar(50) ;
				
				" ;
	}
	public function tiene_rol($rol)
	{
		$tiene_rol = false ;
		if ( $rol == 'usuario' or $rol == 'todos' or $this->obtener_rol() == 'admin' )
		{
			$tiene_rol = true ;
		}
		else
		{
			//
			// Busca Rol
			$rolusuario = new RolUsuario() ;
			if( $rolusuario->Tiene_Rol($this->id,$rol) )
				$tiene_rol = true ;
		}
		return $tiene_rol ;
	}
	public function obtener_rol()
	{
		$this->Leer();
		return $this->rol ;
	}
	public function levanta_usuario_de_la_sesion()
	{
		if (isset( $_SESSION['uid'] ) ) 
			{
			$uid = $_SESSION['uid'];
			$this->id = $uid ;
			}
		else $this->id = null;
	}
	public function  Pruebas()
	{
		$usurol = new RolUsuario() ;
		echo '<br> Pruebas de Utilisateur' ;
		echo '<br> Pruega si el usuario docente tiene rol docente ';
		echo '<br> El rol docente tiene rol docente: '.$usurol->tiene_rol('docente','docente');
		echo '<br> Pruega si el usuario docente tiene rol noexiste ';
		echo '<br> El rol docente tiene rol noexiste: '.$usurol->tiene_rol('docente','noexiste');
		
	}
}
?>
