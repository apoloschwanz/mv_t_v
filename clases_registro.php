<?php



//
// Edicion Actual
//
class Edicion_Actual extends Entidad {
	public $Edicion_Actual_Nro ;
	public function __construct()
  		{
				$this->existe = false ;
				$this->Edicion_Actual_Nro = 0 ;
				$this->Pone_nombre () ;
				$this->Leer();
				$this->Edicion_Actual_Nro = $this->registro['Edicion_Nro'];
  		}
	protected function Carga_Sql_Lectura()
	{
		$this->strsql = "	SELECT Max(edicion.Edicion_Nro) AS Edicion_Nro
											FROM edicion
											WHERE edicion.Edicion_Actual = 1 "  ;
	}
}




class Miembro extends Entidad {
	protected $mail ;
  protected $clave ;
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Miembros" ;
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
			}
		else
			{ 
				$this->existe = false ;
			}
		$this->Leer_Detalle();
	}
	protected function Carga_Sql_Lectura_x_Mail()
	{
	$this->strsql = " SELECT docentes.Docente_Nro, personas.`Apellido y Nombre`
										FROM docentes 
										INNER JOIN personas 
										ON docentes.persona_Id = personas.Persona_Id 
										WHERE docentes.EMAIL = '".$this->mail."'" ;
	}
	protected function Carga_Sql_Lectura()
	{
	$this->strsql = " SELECT docentes.Docente_Nro, personas.`Apellido y Nombre`
										FROM docentes 
										INNER JOIN personas 
										ON docentes.Persona_Id = personas.Persona_Id 
										WHERE docentes.Docente_Nro = '".$this->id."'" ;
	}
	protected function Carga_Sql_Lista()
	{
	$this->strsql = "SELECT Docentes.Docente_Nro, Personas.`Apellido y Nombre`
										FROM Docentes 
										INNER JOIN Personas 
										ON Docentes.Persona_Id = Personas.Persona_Id 
										WHERE Docentes.Activo=1" ;
	}

}




?>
