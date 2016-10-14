<?php

//
// Conexion a la base de datos
//

include_once 'db.php' ;
include_once 'clase_docente.php' ;
include_once 'clase_edicion_actual.php' ;





class Cordos extends Entidad {
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Coordinadores" ;
		}
	protected function Carga_Sql_Lista() // protected function Carga_Sql_Lectura()
	{
	$this->strsql = " SELECT coordinadores.Coordinador_Id, 
										personas.`Apellido y Nombre`, 
										coordinadores.Estado
										FROM coordinadores 
										INNER JOIN personas 
										ON coordinadores.Persona_Id = personas.Persona_Id 
										WHERE coordinadores.Estado = 1" ;
	}

}

//
// Sacas
//

class Sacas extends Entidad {
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Sacas" ;
		}
	protected function Carga_Sql_Lista() // protected function Carga_Sql_Lectura()
	{
	$this->strsql = " 	SELECT sacas.Nro_de_Saca, sacas.Nro_de_Saca as Nombre
											FROM sacas 
											ORDER BY sacas.Nro_de_Saca" ;
	}

}


//
// Coordinadores
//
class Cordos_del_Anexo extends Entidad {
	protected $Coordinador_Id ;
	protected $Orden ;
	protected $Cantidad ;
	public function Grabar ()
		{
			$cn=new Conexion();
			$this->strsql = "update cordinaciones_del_anexo ".
											" set Orden = ".$this->Orden.
											" , Cantidad_de_Pendrives = " .$this->Cantidad	.
											" WHERE cordinaciones_del_anexo.Anexo_Nro = " .$this->id.
											" AND cordinaciones_del_anexo.Coordinador_Id = '" .$this->Coordinador_Id . "' "
			;
			mysqli_query($cn->conexion,$this->strsql) or
					die("Problemas en el update de grabar de".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
			$cn->cerrar();
		}
	public function Pone_Coordinador_Id ( $id )
		{
			$this->Coordinador_Id = $id ;
		}
	public function Pone_Orden ( $orden )
		{
			$this->Orden = $orden ;
		}
	public function Pone_Cantidad ( $cantidad )
		{
			$this->Cantidad = $cantidad ;
		}
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Coordinadores del Anexo" ;
		}
	protected function Carga_Sql_Lista() // protected function Carga_Sql_Lectura()
	{
		$this->strsql = " SELECT cordinaciones_del_anexo.Anexo_Nro, 
											cordinaciones_del_anexo.Orden, 
											cordinaciones_del_anexo.Coordinador_Id, 
											personas.`Apellido y Nombre` as ApeyNom ,
											cordinaciones_del_anexo.Cantidad_de_Pendrives
											FROM coordinadores INNER JOIN cordinaciones_del_anexo 
											ON coordinadores.Coordinador_Id = cordinaciones_del_anexo.Coordinador_Id 
											INNER JOIN personas ON coordinadores.Persona_Id = personas.Persona_Id
											WHERE cordinaciones_del_anexo.Anexo_Nro = " .$this->id. " order by Orden" ;
	}
}
//
// Docentes
//
class Docentes_del_Anexo extends Entidad {
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Docentes del Anexo" ;
		}
	protected function Carga_Sql_Lista() // protected function Carga_Sql_Lectura()
	{
		$this->strsql = "SELECT docentes_de_los_anexos.Anexo_Nro, 
										docentes_de_los_anexos.Docente_Nro, 
										docentes_de_los_anexos.Orden, 
										personas.`Apellido y Nombre` as ApeyNom
										FROM docente 
										INNER JOIN docentes_de_los_anexos 
										ON docente.Docente_Nro = docentes_de_los_anexos.Docente_Nro  
										INNER JOIN personas ON docente.Persona_Id = personas.Persona_Id 
										WHERE docentes_de_los_anexos.Anexo_Nro = " .$this->id . " order by Orden " ;
	}
}


//
// Sacas del Anexo
//

class Sacas_del_Anexo extends Entidad {
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Sacas del Anexo" ;
		}
	protected function Carga_Sql_Lista() // protected function Carga_Sql_Lectura()
	{
		$this->strsql = "	SELECT sacas_del_anexo.Anexo_Nro, 
											sacas_del_anexo.Nro_de_Saca
											FROM sacas_del_anexo 
											WHERE Anexo_Nro = " .$this->id  ;
	}
}



//
// Respuestas del Anexo
//

class Respuestas_del_Anexo extends Entidad {
	protected $Pregunta_Cod ;
	protected $Respuesta_Cod ;
	protected $Respuesta_Txt ;
	public function Grabar ()
		{
			$cn=new Conexion();
			if ( empty( $this->Respuesta_Cod ) )
				{ $Rta_Cod = "NULL" ; }
			else
				{ $Rta_Cod = $this->Respuesta_Cod ; }
			$this->strsql = "update respuestas_del_anexo ".
											" set Respuesta_Cod = ".$Rta_Cod.
											" , Respuesta_Texto = '".$this->sanear_string($this->Respuesta_Txt)."'".
											" WHERE respuestas_del_anexo.Anexo_Nro = " .$this->id.
											" AND respuestas_del_anexo.Pregunta_Cod = " .$this->Pregunta_Cod . " "
			;
			mysqli_query($cn->conexion,$this->strsql) or
					die("Problemas en el update de grabar de".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql .
						'<br> Respuesta_Cod = '.$this->Respuesta_Cod );
			$cn->cerrar();
		}
	public function Pone_Pregunta_Cod ( $Preg_Cod )
		{
			$this->Pregunta_Cod = $Preg_Cod ;
		}
	public function Pone_Respuesta_Cod ( $Rta_Cod )
		{
			$this->Respuesta_Cod = $Rta_Cod ;
			//echo '<br> Pone Repuesta cod....---> Respuesta cod = '.$this->Respuesta_Cod ;
		}
	public function Pone_Respuesta_Txt ( $Rta_txt )
		{
			$this->Respuesta_Txt = $Rta_txt ;
		}
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Respuestas del Anexo" ;
		}
	protected function Carga_Sql_Lista() // protected function Carga_Sql_Lectura()
	{
		$this->strsql = "SELECT respuestas_del_anexo.Anexo_Nro, 
										 	respuestas_del_anexo.Pregunta_Cod, 
											respuestas_del_anexo.Respuesta_Cod, 
											preguntas.Pregunta, 
											respuestas_del_anexo.Pregunta_Nro, 
											respuestas_del_anexo.Respuesta_Texto, 
											preguntas.Texto_Observacion, 
											preguntas.Pregunta_con_Observacion 
											FROM preguntas INNER JOIN respuestas_del_anexo 
											ON preguntas.Pregunta_Cod = respuestas_del_anexo.Pregunta_Cod 
											WHERE Anexo_Nro = " .$this->id. " "  ;
		$this->strsql .= " ORDER BY respuestas_del_anexo.Pregunta_Nro , respuestas_del_anexo.Pregunta_Cod " ; 
	}
}




class Docentes_de_la_Capa extends Entidad {
	protected function Pone_nombre ()
		{

			$this->nombre_tabla = "Docentes de la Capacitación" ;
		}
	//protected function Carga_Sql_Lectura()
	protected function Carga_Sql_Lista()
	{
	$this->strsql = "SELECT docentes_de_la_capacitacion.Crono_Id, 
										docentes_de_la_capacitacion.Docente_Nro, 
										docentes_de_la_capacitacion.Orden_Docente, 
										personas.`Apellido y Nombre`
										FROM docente INNER JOIN docentes_de_la_capacitacion ON docente.Docente_Nro = docentes_de_la_capacitacion.Docente_Nro 
									 	INNER JOIN personas ON docente.Persona_Id = personas.Persona_Id
										WHERE docentes_de_la_capacitacion.Crono_Id = " .$this->id." order by Orden_Docente " ;
	}

}

class Cordos_de_la_Capa extends Entidad {
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Coordinadores de la Capacitación" ;
		}
	protected function Carga_Sql_Lista() // protected function Carga_Sql_Lectura()
	{
	$this->strsql = " SELECT coordinadores_de_la_capacitacion.Crono_Id,  
										coordinadores_de_la_capacitacion.Coordinador_Id,  
										coordinadores_de_la_capacitacion.Orden_Coordinador, 

										personas.`Apellido y Nombre` 
										FROM coordinadores 
										INNER JOIN coordinadores_de_la_capacitacion  
										ON coordinadores.Coordinador_Id =  coordinadores_de_la_capacitacion.Coordinador_Id 
										INNER JOIN personas ON coordinadores.Persona_Id = personas.Persona_Id 
										WHERE coordinadores_de_la_capacitacion.Crono_Id = " .$this->id ;
	}

}

class Capa extends Entidad {
	public $docentes_de_la_capa ;
	public $cordos_de_la_capa ;
	private $dcs;
	private $dc;
	private $ccs;
	private $cc;
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Capacitaciones" ;
		}
	protected function Carga_Sql_Lectura()
	{
	$this->strsql = "SELECT capacitaciones.Crono_Id, CAST(capacitaciones.Fecha AS DATE ) AS Fecha , 
			CAST( capacitaciones.Hora_Desde AS TIME ) AS Hora_Desde , CAST( capacitaciones.Hora_Hasta AS TIME ) AS Hora_Hasta , 
			capacitaciones.Turno_Id, capacitaciones.CUE, 
			capacitaciones.Anexo_Nro,
			capacitaciones.Divisiones, escuelas_general.NOMBRE, 
			escuelas_general.COMUNA, escuelas_general.BARRIO, 
			escuelas_general.DOMICILIO, edicion.Edicion_Actual , programa.Programa_Nro,programa.Programa
			FROM capacitaciones 
			LEFT JOIN  escuelas_general
			ON capacitaciones.CUE = escuelas_general.CUE
			LEFT JOIN edicion
			ON capacitaciones.Edicion_Nro = edicion.Edicion_Nro
			LEFT JOIN programa ON programa.Programa_Nro = capacitaciones.Programa_Nro 
			WHERE capacitaciones.Crono_Id = " .$this->id ;
	}
	protected function Leer_Detalle(){
	// Lee Docentes de la capacitación
	$dcs = new Docentes_de_la_Capa() ;
	$dcs->Set_id($this->id);
	$docentes_de_la_capa = $dcs->Obtener_Lista();
	// Lee Coordinadores de la Capacitación
	$ccs = new Cordos_de_la_Capa() ;
	$ccs->Set_id($this->id);
	$cordos_de_la_capa = $ccs->Obtener_Lista();
	}
	public function Mostrar ()
	{
	$this->Leer();
	echo '<tr>' ;
	echo '<td> Codigo de capacitacion </td><td colspan="1">'.$this->registro['Crono_Id'].'</td>' ;
	echo '</tr>' ; 
	echo '<tr><td> Fecha </td><td colspan="1">'.$this->registro['Fecha'].'</td>' ;
	echo '<td colspan = "2"> '.$this->registro['Programa'].'</td>' ;
	echo '</tr>' ;
	echo '<tr><td> Hora Desde </td><td colspan="1">'.$this->registro['Hora_Desde'].'</td>' ;
	echo '<td> Hora Hasta </td><td colspan="1">'.$this->registro['Hora_Hasta'].'</td></tr>' ;
	echo '<tr><td> Nombre del Establecimiento </td><td colspan="3">'.$this->registro['NOMBRE'].'</td></tr>' ;
	echo '<tr><td> Comuna </td><td colspan="1">'.$this->registro['COMUNA'].'</td>';
		echo '<td> Barrio</td><td>'.$this->registro['BARRIO'].'</td></tr>' ;
	}
}

class Capacitaciones_de_un_Anexo extends Entidad {
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Capacitaciones de un Anexo" ;
		}
	protected function Carga_Sql_Lista() //protected function Carga_Sql_Lectura()
		{
			$this->strsql = "SELECT capacitaciones.Anexo_Nro, 
											capacitaciones.Crono_Id 
											FROM capacitaciones 
											WHERE capacitaciones.Anexo_Nro = ".$this->id;
		}

}


//
// Respuestas de la Pregunta
//
class Respuestas_de_la_Pregunta extends Entidad {
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Respuestas de la pregunta" ;
		}
	protected function Carga_Sql_Lista() //Carga_Sql_Lectura()
		{
			$this->strsql = " SELECT concat( Respuesta_Nro , ' - ' , respuestas.Respuesta ) AS Respuesta_con_Numero, 
												respuestas.Respuesta_Cod 
												FROM respuestas 
												INNER JOIN respuestas_de_la_pregunta 
												ON respuestas.Respuesta_Cod = respuestas_de_la_pregunta.Respuesta_Cod 
												WHERE respuestas_de_la_pregunta.Pregunta_Cod = ".$this->id. " ORDER BY respuestas_de_la_pregunta.Respuesta_Nro " ;
		}

}





class Anexo extends Entidad {
	protected $CapaNro ;
	protected $ExisteCapa ;
	protected $Edicion_Actual ;
	protected $capa;
	protected $con_saca;
	protected $debug;
	protected $con_materiales;
	public $Error;
	public $TextoError;
	public function __construct()
		{
			parent::__construct() ;
			$this->con_saca = false ;
			$this->debug = false ;
			//$this->debug = true ; 
			$this->con_materiales = false ;
		}
	public function Set_Capa_Nro($nro_capa)
		{
			$this->CapaNro = $nro_capa;
		}
	public function Baja_Cordo ($IdCordo)
		{
		$this->strsql = " delete from cordinaciones_del_anexo where Anexo_Nro = '".$this->id."' and Coordinador_Id = '".$IdCordo."' " ;		
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el delete de coordinadores del ".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
		$cn->cerrar();
		}
	public function Baja_Prof ($IdProf)
		{
		$this->strsql = " delete from docentes_de_los_anexos where Anexo_Nro = '".$this->id."' and Docente_Nro =  '".$IdProf."' " ;		
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el delete de docente del ".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
		$cn->cerrar();
		}
	public function Baja_Saca ($IdSaca)
		{
		$this->strsql = " delete from sacas_del_anexo where  Anexo_Nro = '".$this->id."' and  Nro_de_Saca = '".$IdSaca."'  " ;	
									
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el delete de saca del ".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
		$cn->cerrar();
		}
	public function Agrega_Saca ($IdSaca)
		{
		$this->strsql = " insert sacas_del_anexo ( Anexo_Nro , Nro_de_Saca ) values ( '".$this->id."' , '".$IdSaca."' ) " ;	
									
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el insert de saca del ".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
		$cn->cerrar();
		}
	public function Agrega_Prof ($IdProf)
		{
		$this->strsql = " insert into docentes_de_los_anexos ( Anexo_Nro,Docente_Nro,Orden )
									select  anexo.Anexo_Nro , '".$IdProf."' as Coordinador_Id,
									Max( Orden + 1 ) as Orden   
									from anexo left join  docentes_de_los_anexos 
									on anexo.Anexo_Nro = docentes_de_los_anexos.Anexo_Nro 
									where anexo.Anexo_Nro = '".$this->id."' " ;		
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el insert de prof del ".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
		$cn->cerrar();
		}
	public function Agrega_Cordo ($IdCordo)
		{
		$this->strsql = " insert into cordinaciones_del_anexo ( Anexo_Nro,Coordinador_Id,Orden )
									select  anexo.Anexo_Nro , '".$IdCordo."' as Coordinador_Id,
									Max( Orden + 1 ) as Orden   
									from anexo left join  cordinaciones_del_anexo 
									on anexo.Anexo_Nro = cordinaciones_del_anexo.Anexo_Nro 
									where anexo.Anexo_Nro = '".$this->id."' " ;		
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el insert de agrega cordo de".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
		$cn->cerrar();
		}
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Anexo" ;
		}
	protected function Carga_Sql_Lectura()
	{
	$this->strsql = "SELECT anexo.Anexo_Nro, CAST(anexo.Fecha AS DATE) as Fecha, anexo.Horario, anexo.CUE, anexo.Cantidad_de_Alumnos, anexo.Cantidad_de_Docentes, anexo.Cantidad_de_Pendrives, anexo.Observaciones, anexo.Falta_Capacitar_Curso, anexo.Falta_Entregar_Pendrives, anexo.Pendrives_que_falta_entregar, anexo.Turno_ID, anexo.Anios_y_Cursos_Capacitados, anexo.Pendrives_Entregados_a_Presentes, anexo.Pendrives_Entregados_a_Ausentes, anexo.Pendrives_Entregados_a_Institucionales, anexo.Cantidad_Cuartos_Capacitados, anexo.Cantidad_Quintos_Capacitados, anexo.Edicion_Nro, anexo.Cantidad_de_Actas_de_Escrutinio, anexo.Pendrives_que_falta_entregar_Presentes, anexo.Pendrives_que_falta_entregar_Ausentes, anexo.Pendrives_que_falta_entregar_Institucionales, escuelas_general.DOMICILIO, escuelas_general.NOMBRE, escuelas_general.COMUNA, escuelas_general.BARRIO, anexo.Anexo_Nro, edicion.Edicion_Actual
FROM escuelas_general RIGHT JOIN (anexo LEFT JOIN edicion ON anexo.Edicion_Nro = edicion.Edicion_Nro) ON escuelas_general.CUE = anexo.CUE
WHERE anexo.anexo_Nro = '".$this->id."' "  ;
	}
	public function Actualizar()
	{
		$this->Actualizar_Gral() ;
		if ( ! $this->Error )
		{
			$this->capa= new Capa();
			$this->capa->Set_id($this->CapaNro);
			$this->capa->Leer();
			//
			// Marca la Capacitacion como Hecha
			//
			if ($this->existe == true and $this->Error == false )
				{
				if ( $this->debug == true ) echo '<br> Asocia el Anexos a la capacitacion';
				$cn=new Conexion();
				//
				// Asocia ese anexo a la capacitacion y marca la capa como hecha
				//
				$sql = 'UPDATE capacitaciones 
								SET  Estado = "H" 
								WHERE capacitaciones.Crono_Id = '.$this->capa->id ;
				if ( $this->debug == true ) echo '<br>'.$sql.'<br>';
				mysqli_query($cn->conexion,$sql) or die("Problemas al actualizar la capa con el nro de anexo: ".mysqli_error($cn->conexion));
				$cn->cerrar();
				}
		}
	}
	public function Actualizar_Coord()
	{
		$this->Actualizar_Gral() ;
	}
	
	protected function Actualizar_Gral()
	{  if ( $this->debug == true ) echo 'Anexo Actualizar' ;
		//
		// Lee la capacitación
		//
		$this->Error= false ;
		$this->capa= new Capa();
		$this->capa->Set_id($this->CapaNro);
		$this->capa->Leer();

		//
		// Si la capacitación no existe
		//
		if ( $this->capa->existe == false )
			{ 
				$this->Error = true ;
				$this->TextoError = "La capacitacion ".$this->CapaNro." no se encuentra en la base de datos " ;
				}
		//
		// Si la capacitación es de otra edicion
		//
		if ( $this->capa->registro['Edicion_Actual'] != 1 and $this->Error == false )
			{
				$this->Error = true ;
				$this->TextoError = 'La capacitacion '.$this->CapaNro.' pertenece a otra edición del programa' ;
			}
		//
		// Si esta asociada a otro anexo
		//
		if ( $this->capa->registro['Anexo_Nro'] > 0 and $this->id != $this->capa->registro['Anexo_Nro'] and $this->Error == false )
			{
				$this->Error = true ;
				$this->TextoError = 'La capacitacion '.$this->CapaNro.' ya esta asociada a un anexo cuyo número es: '.$this->capa->registro['Anexo_Nro'] ;
			}
		//
		// Si hay una capa asociada al mismo anexo
		//
		if ($this->Error == false )
			{ 
				$ca = new Capacitaciones_de_un_Anexo();
				$ca->Set_id ($this->id ) ;
				$regs = $ca->Obtener_Lista() ;
				while ($ca->existe==true and $reg=mysqli_fetch_array($regs))
					{
					if ( $reg['Crono_Id'] <> $this->capa->id )
						{
						$this->Error = true;
						$this->TextoError = ' El anexo ingresado ya tiene asociada la capacitación ' .$reg['Crono_Id'] ;
						}
					}
			}
		//
		// Busca el Anexo
		//
		$this->Leer();
		//
		// Si el anexo es de otra edicion
		//
		if ($this->existe == true 
					and $this->registro['Edicion_Actual']!= 1 
					and $this->Error == false )
			{
			$this->Error = true ;
			$this->TextoError = ' El anexo ingresado pertenece a otra edición ' ;
			}
		//
		// Si ingreso como anexo el número de la capacitacion
		//
		if ($this->existe == false
				and $this->id == $this->capa->id )
			{
			$this->Error = true ;
			$this->TextoError = ' Ingrese el número de anexo en lugar del núemro de capacitación. ' ;
			}	
		//
		// Asocia el anexo a la capacitación
		//
		if ($this->existe == true and $this->Error == false )
			{
			if ( $this->debug == true ) echo '<br> Asocia el Anexos a la capacitacion';
			$cn=new Conexion();
			//
			// Asocia ese anexo a la capacitacion y marca la capa como hecha pero falta traer anexo.
			//								cuando se carga definitivamente el anexo pasa a estado hecha.
			//
			$sql = 'UPDATE capacitaciones 
							SET capacitaciones.Anexo_Nro = '.$this->id.', Estado = "F" 
							WHERE capacitaciones.Crono_Id = '.$this->capa->id ;
			if ( $this->debug == true ) echo '<br>'.$sql.'<br>';
			mysqli_query($cn->conexion,$sql) or die("Problemas al actualizar la capa con el nro de anexo: ".mysqli_error($cn->conexion));
			$cn->cerrar();
			}
		//
		// Si el anexo no existe lo agrega a partir de la capacitación
		//
		if ($this->existe == false and $this->Error == false )
		{
			//
			// Agrega la cabecera del anexo
			if ( $this->debug == true ) echo 'En hora buena..... se va a gregar el anexo a partir de la capa indicada' ;
			$cn=new Conexion();
		
			$sql = 'INSERT INTO anexo ( Anexo_Nro, Fecha, CUE, Turno_Id, 
						Horario, Anios_y_Cursos_Capacitados , Edicion_Nro) 
						SELECT '.$this->id.' AS Anexo_Nro, capacitaciones.Fecha, 
						capacitaciones.CUE, capacitaciones.Turno_Id, 
						capacitaciones.Hora, capacitaciones.Divisiones ,
						capacitaciones.Edicion_Nro
						FROM capacitaciones where Crono_Id = '.$this->capa->id ;
			if ( $this->debug == true ) echo '<br>'.$sql.'<br>';
		mysqli_query($cn->conexion,$sql) or die("Problemas al agregar anexo a partir de la capa : ".mysqli_error($cn->conexion));
			//
			// Agrega los cordos
			$sql = 'INSERT INTO cordinaciones_del_anexo ( Anexo_Nro, Coordinador_Id )
							SELECT '.$this->id.' AS Anexo_Nro, 
							coordinadores_de_la_capacitacion.Coordinador_Id 
							FROM coordinadores_de_la_capacitacion 
							WHERE coordinadores_de_la_capacitacion.Crono_Id = '.$this->capa->id ;
			if ( $this->debug == true ) echo '<br>'.$sql.'<br>';
		mysqli_query($cn->conexion,$sql) or die("Problemas al agregar cordos del anexo a partir de la capa : ".mysqli_error($cn->conexion));
			//
			// Agrega los docentes
			$sql = 'INSERT INTO docentes_de_los_anexos ( Anexo_Nro, Docente_Nro, Orden ) 
							SELECT '.$this->id.' AS Anexo_Nro, 
							docentes_de_la_capacitacion.Docente_Nro, 
							docentes_de_la_capacitacion.Orden_Docente 
							FROM docentes_de_la_capacitacion 
							WHERE docentes_de_la_capacitacion.Crono_Id = '.$this->capa->id ;
			if ( $this->debug == true ) echo '<br>'.$sql.'<br>';
			mysqli_query($cn->conexion,$sql) or die("Problemas al agregar docentes del anexo a partir de la capa : ".mysqli_error($cn->conexion));
			//
			// Asocia ese anexo a la capacitacion y marca la capa como hecha
			//
			$sql = 'UPDATE capacitaciones 
							SET capacitaciones.Anexo_Nro = '.$this->id.', Estado = "H" 
							WHERE capacitaciones.Crono_Id = '.$this->capa->id ;
			if ( $this->debug == true ) echo '<br>'.$sql.'<br>';
			mysqli_query($cn->conexion,$sql) or die("Problemas al actualizar la capa con el nro de anexo: ".mysqli_error($cn->conexion));
			//
			// Agrega Respuestas del Anexo
			//
			if( $this->capa->registro['Programa_Nro'] == 5 )
				$ConjPregId = 'Anexo2016p' ; 
			else
				$ConjPregId = 'Anexo2016m' ;
			$sql = "insert into respuestas_del_anexo (  Anexo_Nro , Pregunta_Cod , Pregunta_Nro ) " ;
			$sql .= " select '".$this->id."' as Anexo_Nro ,  Pregunta_Cod ,  Pregunta_Nro  FROM conjunto_de_preguntas_detalle WHERE ConjPreg_Cod = '".$ConjPregId."' " ;
			$sql .= "  and Pregunta_Cod not in " ;
			$sql .= " ( SELECT Pregunta_Cod FROM `respuestas_del_anexo` WHERE Anexo_Nro = '".$this->id."' )" ;
			if ( $this->debug == true ) echo '<br> Agrega Respuestas del anexo <br>'.$sql.'<br>' ;
			mysqli_query($cn->conexion,$sql) or die("Problemas al agregar respuestas con el nro de anexo: ".mysqli_error($cn->conexion));
			$cn->cerrar();
			
		}
	}
	public function Mostrar_Error()
		{
		echo '<tr><td> '.$this->TextoError.'</td></tr>' ;
		}
	public function Mostrar ()
	{
		$this->Leer();
		$cpo = new Campo() ;
		$linea = new Registro() ;
		$cel = new Celda() ;
		$pagina = $_SERVER['PHP_SELF'] ;
		// >> DZ_2016_05_23
		echo '<tr><td style="width:30%"> Anexo </td>' ;
		echo '<td colspan="5">';
		echo $this->id;
		echo '</td></tr>' ;
		// << DZ_2016_05_23
		echo '<tr><td> Codigo de capacitacion </td>' ;
		echo '<td colspan="5">';
		echo $this->capa->registro['Crono_Id'];
		echo '</td></tr>' ;
		$cpo->pone_colspan_dato(5) ;
		$cpo->MostrarFecha('FECHA DE LA CAPACITACION','Fecha',$this->capa->registro['Fecha']);
		echo '<tr><td> Nombre del Establecimiento </td><td colspan="5">'.$this->registro['NOMBRE'].'</td></tr>' ;
		echo '<tr><td> Comuna </td><td colspan="2">'.$this->capa->registro['COMUNA'].'</td>';
			echo '<td> Barrio</td><td colspan="2">'.$this->capa->registro['BARRIO'].'</td></tr>' ;
		$cpo->Mostrar('TURNO','Turno_ID',$this->registro['Turno_ID']);
		$cpo->pone_autofocus() ;
		$cpo->Mostrar('HORARIO','Horario',$this->registro['Horario']);
		$cpo->Mostrar('AÑOS Y CURSOS CAPACITADOS','Anios_y_Cursos_Capacitados',$this->registro['Anios_y_Cursos_Capacitados']);
		$cpo->Mostrar('CANTIDAD TOTAL DE ALUMNOS PRESENTES','Cantidad_de_Alumnos',$this->registro['Cantidad_de_Alumnos']);
		//$cpo->Mostrar('CANTIDAD DE ARTICULOS ENTREGADOS','Cantidad_de_Pendrives',$this->registro['Cantidad_de_Pendrives']);
		//$cpo->Mostrar('CANTIDAD TOTAL DE PRESENTES EN LA CAPACITACION ADICIONAL','Cantidad_de_Alumnos_Adicional',$this->registro['Cantidad_de_Alumnos_Adicional']);
		$cpo->Mostrar('CANTIDAD TOTAL DE DOCENTES Y AUTORIDADES','Cantidad_de_Docentes',$this->registro['Cantidad_de_Docentes']);
		$cpo->MostrarComentario('Observaciones Adicionales','Observaciones',$this->registro['Observaciones']);
		$cpo->pone_colspan_dato= 1 ;
		//
		// Máquinas / Sacas
		//
		if ( $this->con_saca == true )
		{
			$ss = new Sacas_del_Anexo() ;
			$ss->Set_id ($this->id) ;
			$regs = $ss->Obtener_Lista() ;
			echo '<tr><th></th><th>Maquinas</th><th>&nbsp</th></tr>';
			while ($ss->existe == true and $reg=mysqli_fetch_array($regs))
				{
				$linea->Abrir();
				$cel->Mostrar_Vacia();
				$pref_sa = 'sacanx_aa'.$reg['Anexo_Nro'].'_ss_'.$reg['Nro_de_Saca'] ;
				//
				// Lista de sacas
				//
				$sacas = new Sacas() ;
				$lsacas = $sacas->Obtener_Lista() ;
				$cel->Mostrar_Desplegable( $pref_sa.'SacaNro', $reg['Nro_de_Saca'] , $lsacas , 0, 0, true) ;
				echo '<td><a href="'.$pagina.'?m_nro_capa='.$this->capa->registro['Crono_Id'].'&m_nro_anexo='.$this->id.'&bajasacaok=ok&Baja_SacaId='.$reg['Nro_de_Saca'].'">Borrar?</a></td>';
				//
				//
				$linea->Cerrar();
				} 
			// by ZD 2015_12_23 -->
			$linea->Abrir();
			$cel->Mostrar_Vacia();
			echo '<td colspan="3" align="center"><input type="submit" name="agregasaca" value="Agregar Máquinas"></td>' ;
			$cel->Mostrar_Vacia();
			$cel->Mostrar_Vacia();
			$linea->Cerrar();
		}
		// by ZD 2015_12_23 <--

		//
		// Coordinadores
		//
		$ca = new Cordos_del_Anexo() ;
		$ca->Set_id ($this->id) ;
		$regs = $ca->Obtener_Lista() ;
		// by DZ 2015_12_23 echo '<tr><th> </th><th>Coordinador</th><th>Orden</th><th colspan="3" >Materiales</th></tr>';
		echo '<tr><th></th><th colspan="5" >Coordinador</th></tr>';
		echo '<tr><th></th><th>Orden</th><th>Nombre</th><th colspan="3">Acción </th></tr>';
		$cta_orden = 0 ;
		while ($ca->existe == true and $reg=mysqli_fetch_array($regs))
			{
			$linea->Abrir();
			$cel->Mostrar_Vacia();
			$pref_ca = 'cordanx_aa'.$reg['Anexo_Nro'].'_cc_'.$reg['Coordinador_Id'] ;
			//$cel->Mostrar($pref_ca.'Id',$reg['Coordinador_Id']);
			//
			// Lista de coordinadores
			//
			// Orden
			$cta_orden ++ ;
			if( $reg['Orden'] > 0 )
				$cel->Mostrar($pref_ca.'Orden',$reg['Orden']);
			else
				$cel->Mostrar($pref_ca.'Orden',$cta_orden);
			// Nombre
			$cordis = new Cordos() ;
			$lcordis = $cordis->Obtener_Lista() ;
			$cel->Mostrar_Fk( $pref_ca.'CoordId', $reg['Coordinador_Id'] , $lcordis , 0, 1 ,true ) ;
			//Materiales
			if( $this->con_materiales == true )
			{
			$cel->Mostrar($pref_ca.'Cantidad_de_Pendrives',$reg['Cantidad_de_Pendrives']);
			}
			// Accion
			echo '<td colspan="3"><a href="'.$pagina.'?m_nro_capa='.$this->capa->registro['Crono_Id'].'&m_nro_anexo='.$this->id.'&bajacoordinadorok=ok&Baja_CoordinadorId='.$reg['Coordinador_Id'].'">Borrar?</a></td>';
			$linea->Cerrar();
			} 
		// by ZD 2015_12_04 -->
		$linea->Abrir();
		$cel->Mostrar_Vacia();
		echo '<td colspan="5" align="center"><input type="submit" name="agregacordo" value="Agregar Coordinador"></td>' ;
		//$cel->Mostrar_Vacia();
		//$cel->Mostrar_Vacia();
		$linea->Cerrar();
		// by ZD 2015_12_04 <--

		//
		// Docentes
		//
		$da = new Docentes_del_Anexo() ;
		$da->Set_id ($this->id ) ;
		$regs = $da->Obtener_Lista() ;
		echo '<tr><th> </th><th colspan="5">Docente</th></tr>';
		echo '<tr><th> </th><th>Orden</th><th>Nombre</th><th colspan="3">Accion</th></tr>';
		$i_orden = 0 ; // by DZ 2015_09_30
		while ($da->existe == true and $reg=mysqli_fetch_array($regs))
			{
			$linea->Abrir();
			$cel->Mostrar_Vacia();
			// by DZ 2015_09_30 - $pref_da = 'docanx_aa'.$reg['Anexo_Nro'].'_dd_'.$reg['Docente_Nro'] ;
			$i_orden += 1 ;// by DZ 2015_09_30
			$pref_da = 'docanx_aa'.$reg['Anexo_Nro'].'_oo_'.$i_orden.'__' ; // by DZ 2015_09_30
			//
			// Orden
			$cel->Mostrar_Etiqueta($i_orden) ; // by DZ 2015_09_30 $cel->Mostrar($pref_da.'Id' ,$i_orden) 
			//
			// Lista de docentes
			$dtes = new Docente() ;
			$ldtes = $dtes->Obtener_Lista() ;
			$cel->Mostrar_Fk( $pref_da.'DteNro', $reg['Docente_Nro'] , $ldtes , 0, 1, true ) ;
			echo '<td colspan="3" ><a href="'.$pagina.'?m_nro_capa='.$this->capa->registro['Crono_Id'].'&m_nro_anexo='.$this->id.'&bajadocenteok=ok&Baja_DocenteId='.$reg['Docente_Nro'].'">Borrar?</a></td>';
			//
			//
			// by DZ 2015_09_30 $cel->Mostrar($pref_da.'Id' ,$reg['Orden']);
			$linea->Cerrar();
			}
			$i_prox = $i_orden + 1 ;
		// by ZD 2015_12_22 -->
		$linea->Abrir();
		$cel->Mostrar_Vacia();
		echo '<td colspan="5" align="center"><input type="submit" name="agregaprof" value="Agregar Docente"></td>' ;
		//$cel->Mostrar_Vacia();
		//$cel->Mostrar_Vacia();
		$linea->Cerrar();
		// by DZ 2015_12_22 // by ZD 2015_12_22 <--
		// by DZ 2015_12_22 // by DZ 2015_10_09 -->
		// by DZ 2015_12_22 for($i_orden=$i_prox;$i_orden<=$i_prox+2;$i_orden++)
		// by DZ 2015_12_22 	{
		// by DZ 2015_12_22 		$linea->Abrir();
		// by DZ 2015_12_22 		$cel->Mostrar_Vacia();
		// by DZ 2015_12_22 	  $pref_da = 'docanx_aa'.$reg['Anexo_Nro'].'_oo_'.$i_orden.'__' ; // by DZ 2015_09_30
		// by DZ 2015_12_22 		//
		// by DZ 2015_12_22 		// Orden
		// by DZ 2015_12_22 		$cel->Mostrar_Etiqueta($i_orden);
		// by DZ 2015_12_22 		//
		// by DZ 2015_12_22 		// Lista de docentes
		// by DZ 2015_12_22 		//
		// by DZ 2015_12_22 		$dtes = new Docente() ;
		// by DZ 2015_12_22 		$ldtes = $dtes->Obtener_Lista() ;
		// by DZ 2015_12_22 		$cel->Mostrar_Desplegable( $pref_da.'DteNro', '' , $ldtes , 0, 1, true ) ;
		// by DZ 2015_12_22 		$linea->Cerrar();
		// by DZ 2015_12_22 	}

		// by DZ 2015_10_09 <--			
		//
		// Respuestas del anexo
		//
		$ra = new Respuestas_del_Anexo() ;
		$ra->Set_id ($this->id ) ;
		$regs = $ra->Obtener_Lista() ;
		echo '<tr><th> </th><th>#</th><th>Pregunta</th><th>Rta</th><th>Respuesta</th><th>Observaciones</th></tr>';
		while ($ra->existe == true and $reg=mysqli_fetch_array($regs))
			{
			$linea->Abrir();
			$cel->Mostrar_Vacia();
			$pref_ra = 'prcanx_aa'.$reg['Anexo_Nro'].'_pp_'.$reg['Pregunta_Cod'] ;
			$cel->Mostrar_Etiqueta($reg['Pregunta_Nro']);//$cel->Mostrar($pref_ra.'Nro' ,$reg['Pregunta_Nro']);
			echo '<td width="15%" style="word-wrap:break-word" >'.$reg['Pregunta'].'</td>' ;
			//by DZ 15-7-2015 // $cel->Mostrar($pref_ra.'Pregunta' ,$reg['Pregunta']);
			//
			// Rta. Cod
			//by DZ 15-7-2015 // $cel->Mostrar($pref_ra.'Rta' ,$reg['Respuesta_Cod']);
			//
			// Respuestas de la pregunta
			//
			$rtas = new Respuestas_de_la_Pregunta() ;
			$rtas->Set_id ($reg['Pregunta_Cod']) ;
			$lrespuestas = $rtas->Obtener_Lista() ;
			$cel->Mostrar_Desplegable( $pref_ra.'Rta', $reg['Respuesta_Cod'] , $lrespuestas , 1, 0, true ) ;
			//
			//
			// $cel->Mostrar($pref_ra.'Titulo' ,$reg['Respuesta_Texto']);
			if ( $reg['Pregunta_con_Observacion'] == 1 )
				{
				$cel->Mostrar_Etiqueta($reg['Texto_Observacion']);
				$cel->Mostrar($pref_ra.'RtaTxto' ,$reg['Respuesta_Texto']);
				}
			else
				{
				echo '<td></td><td></td>' ;
				}
			$linea->Cerrar();
			}
		//
		//
		//while ($reg=mysqli_fetch_array($this->capa->registros))
		//{
		//} 
	}
	
	public function Mostrar_Coord ()
	{
		$this->Leer();
		$cpo = new Campo() ;
		$linea = new Registro() ;
		$cel = new Celda() ;
		$pagina = $_SERVER['PHP_SELF'] ;
		// >> DZ_2016_05_23
		echo '<tr><td style="width:30%"> Anexo </td>' ;
		echo '<td colspan="5">';
		echo $this->id;
		echo '</td></tr>' ;
		// << DZ_2016_05_23
		echo '<tr><td> Codigo de capacitacion </td>' ;
		echo '<td colspan="5">';
		echo $this->capa->registro['Crono_Id'];
		echo '</td></tr>' ;
		$cpo->pone_colspan_dato(5) ;
		$cpo->MostrarFecha('FECHA DE LA CAPACITACION','Fecha',$this->capa->registro['Fecha']);
		echo '<tr><td> Nombre del Establecimiento </td><td colspan="5">'.$this->registro['NOMBRE'].'</td></tr>' ;
		echo '<tr><td> Comuna </td><td colspan="2">'.$this->capa->registro['COMUNA'].'</td>';
			echo '<td> Barrio</td><td colspan="2">'.$this->capa->registro['BARRIO'].'</td></tr>' ;
		$cpo->Mostrar('TURNO','Turno_ID',$this->registro['Turno_ID']);
		$cpo->pone_autofocus() ;
		$cpo->Mostrar('HORARIO','Horario',$this->registro['Horario']);
		$cpo->Mostrar('AÑOS Y CURSOS CAPACITADOS','Anios_y_Cursos_Capacitados',$this->registro['Anios_y_Cursos_Capacitados']);
		$cpo->Mostrar('CANTIDAD TOTAL DE ALUMNOS PRESENTES','Cantidad_de_Alumnos',$this->registro['Cantidad_de_Alumnos']);
		//$cpo->Mostrar('CANTIDAD DE ARTICULOS ENTREGADOS','Cantidad_de_Pendrives',$this->registro['Cantidad_de_Pendrives']);
		//$cpo->Mostrar('CANTIDAD TOTAL DE PRESENTES EN LA CAPACITACION ADICIONAL','Cantidad_de_Alumnos_Adicional',$this->registro['Cantidad_de_Alumnos_Adicional']);
		$cpo->Mostrar('CANTIDAD TOTAL DE DOCENTES Y AUTORIDADES','Cantidad_de_Docentes',$this->registro['Cantidad_de_Docentes']);
		$cpo->MostrarComentario('Observaciones Adicionales','Observaciones',$this->registro['Observaciones']);
		$cpo->pone_colspan_dato= 1 ;

	}	
	
	public function Guardar () 
		{
		//
		// Control de Errores
		//		
		$this->Error= false ;
		//
		// Abre la conexion
		//
		$cn=new Conexion();
		//
		// Datos Cabecera
		//
		//$query = 'update anexo set Fecha ="'.$_REQUEST['m_Fecha'].'" ,
		//					Turno_ID = "'.$_REQUEST['m_Turno_ID'].'" ,
		//					Horario = "'.$_REQUEST['m_Horario'].'" ,
		//					Anios_y_Cursos_Capacitados = "'. $_REQUEST['m_Anios_y_Cursos_Capacitados'].'" ,
		//					Cantidad_de_Alumnos = "'. $_REQUEST['m_Cantidad_de_Alumnos'].'" ,
		//					Cantidad_de_Pendrives = "'. $_REQUEST['m_Cantidad_de_Pendrives'].'" ,
		//					Cantidad_de_Alumnos_Adicional = "'. $_REQUEST['m_Cantidad_de_Alumnos_Adicional'].'" ,
		//					Observaciones = "'. $_REQUEST['m_Observaciones'].'" 
		//					where Anexo_Nro = '.$this->id ;
			
		$query = 'update anexo set Fecha ="'.$this->sanear_fecha($_REQUEST['m_Fecha']).'" ,
							Turno_ID = "'.$this->sanear_string($_REQUEST['m_Turno_ID']).'" ,
							Horario = "'.$this->sanear_string($_REQUEST['m_Horario']).'" ,
							Anios_y_Cursos_Capacitados = "'.$this->sanear_string($_REQUEST['m_Anios_y_Cursos_Capacitados']).'" ,
							Cantidad_de_Alumnos = "'.$this->sanear_num($_REQUEST['m_Cantidad_de_Alumnos']).'" ,
							Cantidad_de_Docentes = "'.$this->sanear_num($_REQUEST['m_Cantidad_de_Docentes']).'" ,
							Observaciones = "'.$this->sanear_string($_REQUEST['m_Observaciones']).'" 
							where Anexo_Nro = '.$this->id ;				
							

		if ( $this->debug == true ) echo '<tr><td> query = '.$query.'</td></tr>' ;
		if ( $cn->conexion->query($query)  === TRUE) 
			{
			if ( $this->debug == true ) printf("Se actualizaron los datos.\n");
			if ( $this->debug == true ) echo '<tr><td> query = '.$query.' </td></tr>' ;
			}
		else
			{
			$this->Error = TRUE ;
			$this->TextoError = "Error al actualizar anexo nro=".$this->id."  " ;
			if ( $this->debug == true ) echo '<tr><td> query = '.$query.' </td></tr>' ;
			}
		//
		// Docentes
		//
		if ( $this->Error == FALSE )
			{
			$i_orden = 0 ;
			$max_orden = 10 ;
			while ( $i_orden < $max_orden )
				{
				$i_orden += 1 ;// by DZ 2015_09_30
				$pref_da = 'docanx_aa'.$this->id.'_oo_'.$i_orden.'__' ; // by DZ 2015_12_01
				$dte_nro_nom = $pref_da.'DteNro' ;
				if ( isset( $_REQUEST[$dte_nro_nom] ) )
					{
					//echo '<br> docente ----> '.$_REQUEST[$dte_nro_nom] ;
					}
				}
			}
		//
		// Coordinadores
		//
		if ( $this->Error == FALSE )
			{
			$ca = new Cordos_del_Anexo() ;
			$ca->Set_id ($this->id) ;
			$regs = $ca->Obtener_Lista() ;
			while ($ca->existe == true and $reg=mysqli_fetch_array($regs))
				{
				$pref_ca = 'cordanx_aa'.$this->id.'_cc_'.$reg['Coordinador_Id'] ;
				$ca_id_nom = $pref_ca.'CoordId' ;
				$ca_ord_nom = 'm_'.$pref_ca.'Orden' ;
				$ca_cnt_nom = 'm_'.$pref_ca.'Cantidad_de_Pendrives' ;
				if ( isset( $_REQUEST[$ca_id_nom] ) )
					{
					$id = $_REQUEST[$ca_id_nom] ;
					$orden = $_REQUEST[$ca_ord_nom] ;
					if ( isset( $_REQUEST[$ca_cnt_nom] ) )
						$cantidad = $_REQUEST[$ca_cnt_nom] ;
					else
						$cantidad = 0 ;
					if ($this->debug == true ) echo '<br> cordo ----> '.$_REQUEST[$ca_id_nom] ;
					if ($this->debug == true ) echo '<br> Orden ----> '.$_REQUEST[$ca_ord_nom] ;
					if ($this->debug == true ) echo '<br> Cantidad ----> '.$_REQUEST[$ca_cnt_nom] ;
					$ca->Pone_Coordinador_Id ( $id ) ;
					$ca->Pone_Orden ( $orden ) ;
					$ca->Pone_Cantidad ( $cantidad ) ;
					$ca->Grabar () ;
					}
				}
			}
		//
		// Respuestas de la pregunta
		//
		if ( $this->Error == FALSE )
			{
			$ra = new Respuestas_del_Anexo() ;
			$ra->Set_id ($this->id ) ;
			$regs = $ra->Obtener_Lista() ;
			while ($ra->existe == true and $reg=mysqli_fetch_array($regs))
				{
					$pref_ra = 'prcanx_aa'.$this->id.'_pp_'.$reg['Pregunta_Cod'] ;
					$ra_rta_nom = $pref_ra.'Rta' ;
					$ra_txt_nom = 'm_'.$pref_ra.'RtaTxto' ;
					if ( isset( $_REQUEST[$ra_rta_nom] ) )
						{
						$ra_preg_cod = $reg['Pregunta_Cod'] ;
						$ra_rta_cod = $_REQUEST[$ra_rta_nom] ;
						//echo '<br> Respuesta ----> '.$ra_rta_cod ;
						if ( $reg['Pregunta_con_Observacion'] == 1 )
							{
							$ra_rta_txt = $_REQUEST[$ra_txt_nom] ;
							//echo '     Texto ----> '.$ra_rta_txt ;
							}
						else
							{
							$ra_rta_txt = '' ;
							//echo '     Texto ----> ------' ;
							}
						$ra->Pone_Pregunta_Cod ( $ra_preg_cod ) ;
						$ra->Pone_Respuesta_Cod ( $ra_rta_cod ) ;
						$ra->Pone_Respuesta_Txt ( $ra_rta_txt ) ;
						$ra->Grabar () ;
						}
				}
			}
		//
		// Cierra la conexion
		//
		$cn->cerrar();
		}
		protected function Modifica_tabla()
		{
			$strsql = 'ALTER TABLE anexo ADD Cantidad_de_Docentes INT ' ;
			
			
			//
			// Agregado de Conjunto de Preguntas
			//
			//
			// Conjunto de Preguntas
			$strsql = " INSERT INTO `conjunto_de_preguntas` (`ConjPreg_Cod`, `Tipo_de_Encuesta_Cod`, `ConjPreg_Nombre`) VALUES ('Anexo2016m', 'Anexo2014_', 'Anexos 2016 MVME') ";
			//
			// Conjunto de Preguntas Detalles - A partid de Id 93
			$strsql = "INSERT INTO `conjunto_de_preguntas_detalle` (`ConjPregDet_Nro`, `ConjPreg_Cod`, `Pregunta_Nro`, `Pregunta_Cod`) VALUES
						(93, 'Anexo2016m', 1, 16),
						(94, 'Anexo2016m', 2, 17),
						(95, 'Anexo2016m', 3, 18),
						(96, 'Anexo2016m', 4, 19),
						(97, 'Anexo2016m', 5, 22),
						(98, 'Anexo2016m', 6, 23),
						(99, 'Anexo2016m', 7, 53),
						(100, 'Anexo2016m', 8, 25),
						(101, 'Anexo2016m', 9, 26),
						(102, 'Anexo2016m', 9, 27),
						(103, 'Anexo2016m', 9, 28),
						(104, 'Anexo2016m', 9, 29),
						(105, 'Anexo2016m', 9, 30),
						(106, 'Anexo2016m', 9, 31),
						(107, 'Anexo2016m', 9, 32),
						(108, 'Anexo2016m', 9, 33);" ;
			//
			// Pregunta Nueva
			$strsql = "INSERT INTO `preguntas` (`Pregunta_Cod`, `Pregunta`, `Pregunta_con_Observacion`, `Texto_Observacion`) VALUES ('53', 'Se Ralizó el Bolque Práctico ?', 1, 'Por Que ?') " ;
			$strsql = "INSERT INTO `respuestas_de_la_pregunta` (`RespPreg_Cod`, `Pregunta_Cod`, `Respuesta_Nro`, `Respuesta_Cod`) VALUES ('81', '53', '1', '1'), ('82', '53', '2', '2') " ;
			
			//
			// Participacion Ciudadana
			$strsql = "
				
				INSERT INTO `conjunto_de_preguntas` (`ConjPreg_Cod`, `Tipo_de_Encuesta_Cod`, `ConjPreg_Nombre`) 
				VALUES ('Anexo2016p', 'Anexo2014_', 'Anexos 2016 PC') ;
			
				INSERT INTO `preguntas` (`Pregunta_Cod`, `Pregunta`, `Pregunta_con_Observacion`, `Texto_Observacion`) 
				VALUES ('54', 'Temática Elegida:', 1, 'Espresarla Aqui') ,
						('55', 'A. Nivel de Interes',0,'') ,
						('56' , 'B. Conocimiento sobre la temática',0,'') ,
						('57' , 'C. Nivel de Participación en clase',0,'') ;
						
				UPDATE preguntas SET Pregunta_con_Observacion = 1,Texto_Observacion='¿ Por Que ?' where Pregunta_Cod = 53 ;
								
				INSERT INTO `conjunto_de_preguntas_detalle` (`ConjPregDet_Nro`, `ConjPreg_Cod`, `Pregunta_Nro`, `Pregunta_Cod`) VALUES
						(109, 'Anexo2016p', 1, 16),
						(110, 'Anexo2016p', 2, 17),
						(111, 'Anexo2016p', 3, 18),
						(112, 'Anexo2016p', 4, 19),
						(113, 'Anexo2016p', 5, 22),
						(114, 'Anexo2016p', 6, 53),
						(115, 'Anexo2016p', 7, 54),
						(116, 'Anexo2016p', 7, 55),
						(117, 'Anexo2016p', 7, 56),
						(118, 'Anexo2016p', 7, 57)
						;
				
				INSERT INTO `respuestas` (`Respuesta_Cod`, `Respuesta`) VALUES ('52', 'Malo'), ('53', 'Nulo') ;
				
				INSERT INTO `respuestas` (`Respuesta_Cod`, `Respuesta`) VALUES ('54', 'Muy Bueno'), ('55', 'Bueno') ;
				
				INSERT INTO `respuestas_de_la_pregunta` (`RespPreg_Cod`, `Pregunta_Cod`, `Respuesta_Nro`, `Respuesta_Cod`) 
						VALUES ('83', '55', '1', '54'), 
								('84', '55', '2', '55'),
								('85', '55', '3', '11'),
								('86', '55', '4', '52'),
								('87', '55', '5', '53'),
								 
								('88', '56', '1', '54'), 
								('89', '56', '2', '55'),
								('90', '56', '3', '11'),
								('91', '56', '4', '52'),
								('92', '56', '5', '53'),
								
								('93', '57', '1', '54'), 
								('94', '57', '2', '55'),
								('95', '57', '3', '11'),
								('96', '57', '4', '52'),
								('97', '57', '5', '53');
				
			";
			
			
			
			
		}
		protected function cambia_preguntas_anexo_a_mivoto()
		{
				$strsql = "
				
				
				DELETE FROM `respuestas_del_anexo` WHERE Anexo_Nro = 6737 and Pregunta_Cod in ( 54, 55, 56 , 57 );
				
				INSERT INTO respuestas_del_anexo (Anexo_Nro, Pregunta_Cod, Respuesta_Cod, Pregunta_Nro) 
					VALUES ('6737', '23', NULL, '6');
				
				update respuestas_del_anexo set Pregunta_Nro = 7 where Anexo_Nro = 6737 and Pregunta_Cod = 
				53 ;
				
				INSERT INTO respuestas_del_anexo (Anexo_Nro, Pregunta_Cod, Respuesta_Cod, Pregunta_Nro) 
					VALUES ('6737', '25', NULL, '8'),
							('6737', '26', NULL, '9'),
							('6737', '27', NULL, '9'),
							('6737', '28', NULL, '9'),
							('6737', '29', NULL, '9'),
							('6737', '30', NULL, '9'),
							('6737', '31', NULL, '9'),
							('6737', '32', NULL, '9'),
							('6737', '33', NULL, '9')
					
					;
				
				" ;
				
		}
		protected function prueba_borrar_anexo()
		{
			$trsql = ' 
			 delete from anexo where anexo.Anexo_Nro = 10108 ; 
			 
			 update capacitaciones set Anexo_Nro = 0 where Anexo_Nro = 10108 ;
			 
			 delete from cordinaciones_del_anexo where Anexo_Nro = 10108 ;

			  delete from docentes_de_los_anexos where Anexo_Nro = 10108 ; 
			  
			  delete from respuestas_del_anexo where Anexo_Nro = 10108 ;
			  ';
		 }
		 protected function z_cambia_nro_anexo()
		{
				$strsql = '
				
			 
			 --
			 -- Primero
			 update cordinaciones_del_anexo Set Anexo_Nro = 10004 where Anexo_Nro = 10268 ;

			  update  docentes_de_los_anexos Set Anexo_Nro = 10004 where Anexo_Nro = 10268 ; 
			  
			  update  respuestas_del_anexo Set Anexo_Nro = 10004 where Anexo_Nro = 10268 ;
				
			 --
			 -- Segundo	
				
			  update anexo set Anexo_Nro = 10004 where anexo.Anexo_Nro = 10268 ; 
			
			  update capacitaciones set Anexo_Nro = 10004 where Anexo_Nro = 10268 ;
			 
			  --
			  -- Tercero
			  update encuestas Set Anexo_Nro = 10004 where Anexo_Nro = 10268 	;
				
				' ;
		}
}
?>


