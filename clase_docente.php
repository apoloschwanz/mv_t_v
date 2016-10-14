<?php


class Docente extends Entidadi {
	protected $mail ;
	protected function Pone_Datos_Fijos_No_Heredables()
		{	
			//
			// Prefijo campo
			$this->prefijo_campo = 'm_dte_' ;
			//
			// Lista de Campos
			//
			// tipos:  'pk' 'fk' 'otro' 'date' 'datetime' 'time' 'number' 'email' 'url' 'password'
			//								el tipo 'fk' espera que se defina una clase 
			$this->lista_campos_lista=array();
			$this->lista_campos_lista[]=array( 'nombre'=>'Docente_Nro' 			, 'tipo'=>'pk' 		, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lista[]=array( 'nombre'=>'Apellido y Nombre' 	, 'tipo'=>'text' 	, 'descripcion'=>'Docente' , 'clase'=>NULL ) ;
			//
			//
			$this->lista_campos_lectura=array();
			$this->lista_campos_lectura[]=array( 'nombre'=>'Docente_Nro' 			, 'tipo'=>'pk' 		, 'descripcion'=>'#' , 'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Apellido y Nombre' 	, 
													'tipo'=>'otro' 	, 
													'descripcion'=>'Docente' , 
													'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'Tel' 	, 
													'tipo'=>'text' 	, 
													'descripcion'=>'Telefono' , 
													'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'EMAIL' 	, 
													'tipo'=>'text' 	, 
													'descripcion'=>'Correo Electronico' , 
													'clase'=>NULL ) ;
			$this->lista_campos_lectura[]=array( 'nombre'=>'DNI' 	, 
													'tipo'=>'number' 	, 
													'descripcion'=>'Numero de Documento' , 
													'clase'=>NULL ) ;
			
													
						
			//
			// Nombre de la tabla
			$this->nombre_tabla = "Docentes" ;
			$this->nombre_fisico_tabla = "docente" ;
			//
			// Nombre de la pagina
			$this->nombre_pagina = $_SERVER['PHP_SELF'] ;
			//
			// Paginacion
			$this->desde = 0 ;																					// by DZ 2015-08-14 - agregado lista de datos
			$this->cuenta = 15 ;																				// by DZ 2015-08-14 - agregado lista de datos		
			//
			// Acciones Extra para texto_mostrar_abm
			//$this->acciones[] = array( 'nombre'=>'okAsignarDte' , 'texto'=>'AsignarDte' ) ;
			//
			// Botones extra edicion
			$this->botones_extra_edicion = array();
			$this->botones_extra_edicion[] = array( 'name'=> '_Comunas' ,
										'value'=>'Comunas' ,
										'link'=>'comunas_del_docente.php' ) ; // '<input type="submit" name="'.$this->prefijo_campo.'_Rel1" value="Salir" autofocus>
			$this->botones_extra_edicion[] = array( 'name'=> '_DiasTurnos' ,
										'value'=>'Turnos' ,
										'link'=>'turnos_del_docente.php' ) ; // '<input type="submit" name="'.$this->prefijo_campo.'_Rel1" value="Salir" autofocus>


	
		}	
	public function Leer_x_mail($mail)
	{ $this->mail = $mail ;
		$this->Carga_Sql_Lectura_x_Mail();		
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el select de ".$this->nombre_tabla." por mail : ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
		$cn->cerrar();
		if ( $this->registro=mysqli_fetch_array($this->registros) )
			{
				$this->existe = true ;
				$this->id = $this->registro['Docente_Nro'];
			}
		else
			{ 
				$this->existe = false ;
			}
		$this->Leer_Detalle();
	}
	protected function Carga_Sql_Lectura_x_Mail()
	{
	$this->strsql = " SELECT docente.Docente_Nro, personas.`Apellido y Nombre`,docente.Tel,docente.EMAIL,docente.DNI
										FROM docente 
										INNER JOIN personas 
										ON docente.persona_Id = personas.Persona_Id 
										WHERE docente.EMAIL = '".$this->mail."'" ;
	}
	protected function Carga_Sql_Lectura()
	{
	$this->strsql = " SELECT docente.Docente_Nro, personas.`Apellido y Nombre`,docente.Tel,docente.EMAIL,docente.DNI
										FROM docente 
										INNER JOIN personas 
										ON docente.Persona_Id = personas.Persona_Id 
										WHERE docente.Docente_Nro = '".$this->id."'" ;
	}
	protected function Carga_Sql_Lista()
	{
	$this->strsql = "SELECT docente.Docente_Nro, personas.`Apellido y Nombre`
										FROM docente 
										INNER JOIN personas 
										ON docente.Persona_Id = personas.Persona_Id 
										WHERE docente.Activo=1" ;
	}
	public function Agrega_Docente($mail,$apeynom,$tel,$persona)
	{
		//
		// Abre la conexion
		$cn=new Conexion();
		$i=0;
		$this->existe = false ;
		while( $i<100 and $this->existe == false )
		{
			$i++;
			//
			// Intenta Agregar Docente 
			$this->strsql = "SELECT Max(  CAST( Docente_Nro as unsigned ) ) + 1 as Nuevo_id FROM docente " ;
					
			$this->registros=mysqli_query($cn->conexion,$this->strsql) or
					die("Problemas en el select de busqueda de id de Docente" );
			if ( $this->registro=mysqli_fetch_array($this->registros) )
				{	
					$this->id = $this->registro['Nuevo_id'] ;
					mysqli_data_seek ( $this->registros , 0 ) ;	
					$this->strsql = "INSERT INTO docente ( Docente_Nro,	Docente, EMAIL , Tel , Persona_Id , Activo )
										VALUES 
										( 
										'".$this->id."' , 
										'".$apeynom."' ,
										'".$mail."' ,
										'".$tel."' ,
										'".$persona."' ,
										0
										)" ;
					$dte_agregado = mysqli_query($cn->conexion,$this->strsql) ;
					if ( $dte_agregado and mysqli_affected_rows($cn->conexion) == 1 )
					{
						$this->existe = true ;
					}					
				}
		}
		if ( $this->existe == false ) $this->id = NULL ;
		$cn->cerrar();
		return $this->id ;
	}
	protected function _cambiar_contrasenia()
	{
		$txt = " DELETE from user where user.userid = 'paulabande@hotmail.com' ; " ;
	}
}
?>
