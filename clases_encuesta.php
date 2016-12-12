<?php

//
// Conexion a la base de datos
//

require_once 'db.php' ;


class Encuesta extends Entidad {
	protected $TipoEncuesta ;
	protected $ConjPreguntas ;
	protected $AnexoNro ;
	protected $ExisteAnexo ;
	protected $Edicion_Actual ;
	public $anexo;
	public $Error;
	public $TextoError;
	
	public function Set_Conj_Preg_Cod($cto)
		{
			$this->ConjPreguntas = $cto;
		}
	public function Set_Tipo_Encuesta_Cod($tipo)
		{
			$this->TipoEncuesta = $tipo;
		}
	public function Set_Anexo_Nro($nro_anexo)
		{
			$this->AnexoNro = $nro_anexo;
		}
	protected function Pone_Clase_Detalle()													// by DZ 2016-01-21 - agregado clase detalle
		{
			$this->detalle = new Observaciones_Encuesta() ;
		}	

	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Encuestas" ;
		}
	protected function Carga_Sql_Lectura()
	{
	$this->strsql = "SELECT encuestas.Nro_Encuesta, encuestas.Nombre_Encuestado, 
													encuestas.Apellido_Encuestado, encuestas.Cargo_Encuestado, 
													encuestas.Tipo_de_Encuesta_Cod, encuestas.Anexo_Nro
									FROM encuestas LEFT JOIN cargos ON encuestas.Cargo_Encuestado = cargos.Cod_Cargo
									WHERE encuestas.Nro_Encuesta = '".$this->id."' "  ;
	}
	public function Actualizar()
	{  
		//
		// Lee encuesta y anexo
		//
		$this->Error= false ;
		$this->anexo= new Anexo();
		$this->anexo->Set_id($this->AnexoNro);
		$this->anexo->Leer();
		$this->Leer();
		//
		// Si el anexo no existe
		//
		if ( $this->anexo->existe == false )
			{ 
				$this->Error = true ;
				$this->TextoError = "El anexo  ".$this->AnexoNro." no se encuentra en la base de datos. " ;
			}
		//
		// Si no se ingresó numero de encuesta
		//
		if ( empty($this->id )  and $this->Error == false  ) 
			{ 
				$this->Error = true ;
				$this->TextoError = 'Ingrese un número de encuesta. ' ; 
			}
		//
		// Si el anexo es de otra edicion
		//
		if ( $this->anexo->registro['Edicion_Actual'] != 1 and $this->Error == false )
			{
				$this->Error = true ;
				$this->TextoError = 'El Anexo '.$this->AnexoNro.' pertenece a otra edición del programa' ;
			}
		//
		// Busca La encuesta
		//
		$this->Leer();
		//
		// Si la encuesta no existe la agrega 
		//
		if ($this->existe == false and $this->Error == false )
		{
			//
			// Agrega la cabecera de la encuesta
			$cn=new Conexion();
		
			$sql = "INSERT INTO encuestas ( Nro_Encuesta, Anexo_Nro, Tipo_de_Encuesta_Cod) 
						VALUES(".$this->id.",".$this->AnexoNro.",'".$this->TipoEncuesta."' )" ;
		mysqli_query($cn->conexion,$sql) or die("Problemas al encuesta : ".mysqli_error($cn->conexion));
			//
			// Agrega las respuestas
			$sql = "INSERT INTO respuestas_de_la_encuesta (  Nro_Encuesta, Pregunta_Cod , Pregunta_Nro)
							SELECT ".$this->id." AS Nro_Encuesta, Pregunta_Cod , Pregunta_Nro
							FROM conjunto_de_preguntas_detalle 
							WHERE conjunto_de_preguntas_detalle.ConjPreg_Cod = '".$this->ConjPreguntas."' " ;
		mysqli_query($cn->conexion,$sql) or die("Problemas al agregar las respuestas : ".mysqli_error($cn->conexion));
			$cn->cerrar();

		}
		else
		{
			//
			// Si esta asociada a otro anexo
			//
			if ( $this->anexo->registro['Anexo_Nro'] > 0 and $this->registro['Anexo_Nro'] != $this->anexo->registro['Anexo_Nro'] and $this->Error == false )
				{
					$this->Error = true ;
					$this->TextoError = 'La encuesta '.$this->id.' ya esta asociada a un anexo cuyo número es: '.$this->registro['Anexo_Nro'] ;
				}
		}
	}
	public function Mostrar_Error()
		{
		echo '<tr><td> '.$this->TextoError.'</td></tr>' ;
		}
	public function textoModificarDetalle ()
	{
		$this->Leer();
		$cpo = new Campo() ;
		$linea = new Registro() ;
		$cel = new Celda() ;
		$pagina = $_SERVER['PHP_SELF'] ;
		//
		// Respuestas del anexo
		//
		$re = new Respuestas_de_la_Encuesta() ;
		$re->Set_id ($this->id ) ;
		$regs = $re->Obtener_Lista() ;
		$texto =  '<table>' ;
		$texto = $texto.'<tr><th>#</th><th>Pregunta</th><th>Respuesta</th><th>Observaciones</th></tr>';
		while ($re->existe == true and $reg=mysqli_fetch_array($regs))
			{
			$texto = $texto.'<tr>';
			$pref_re = 'preg_enc_nro_'.$reg['Nro_Encuesta'].'_pp_'.$reg['Pregunta_Cod'] ;
			$texto = $texto.'<td>'.$reg['Pregunta_Nro'].'</td>' ;
			$texto = $texto.'<td width="55%" style="word-wrap:break-word" >'.$reg['Pregunta'].'</td>' ;
		//	// Respuestas de la pregunta
		//	//
		//	$rtas = new Respuestas_de_la_Pregunta() ;
		//	$rtas->Set_id ($reg['Pregunta_Cod']) ;
		//	$lrespuestas = $rtas->Obtener_Lista() ;
		//	$cel->Mostrar_Desplegable( $pref_ra.'Rta', $reg['Respuesta_Cod'] , $lrespuestas , 1, 0, true ) ;
			if ( $reg['Pregunta_con_Observacion'] == 1 )
				{
				$texto = $texto.'<td>'.$reg['Texto_Observacion'].'</td>' ;
				$nomcampo = $pref_re.'RtaTxto';
				//$texto = $texto.'<td><input type="text" name="'.$nomcampo.'" value="'.$reg['Respuesta_Texto'].'" ></td>';
				$texto = $texto. '<td><TEXTAREA name="'.$nomcampo.'" ROWS=4 COLS= 35>'.$reg['Respuesta_Texto'].'</TEXTAREA></td>' ;
				}
			else
				{
				$nomcampo = $pref_re.'Rta';
				$texto = $texto.'<td><input type="number" name="'.$nomcampo.'" value="'.$reg['Respuesta_Cod'].'"></td>';
				$texto = $texto.'<td>---</td>';
				}				
		//	//
		//	//
			$texto = $texto.'</tr>';;
			}
		$texto = $texto.'</table>' ;
		return $texto;
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
		$query = 'update encuestas set Nombre_Encuestado ="" ,
							Apellido_Encuestado = "" ,
							Cargo_Encuestado = NULL 
							where Nro_Encuesta = '.$this->id ;

		//echo '<tr><td> query = '.$query.'</td></tr>' ;
		if ( ! $cn->conexion->query($query)  === TRUE) 
			{
			$this->Error = TRUE ;
			$this->TextoError = "Error al actualizar la encuesta nro=".$this->id." <br> query = ".$query."<br> ".$cn->conexion->error ;
			}
		//
		// Respuestas de la pregunta
		//
		if ( $this->Error == FALSE )
			{
			$re = new Respuestas_de_la_Encuesta() ;
			$re->Set_id ($this->id ) ;
			$regs = $re->Obtener_Lista() ;
			while ($re->existe == true and $reg=mysqli_fetch_array($regs))
				{ 
					//
					// Nombre del control
					$pref_re = 'preg_enc_nro_'.$reg['Nro_Encuesta'].'_pp_'.$reg['Pregunta_Cod'] ;
					$re_rta_nom = $pref_re.'Rta' ;
					//$re_txt_nom = 'm_'.$pref_re.'RtaTxto' ;
					$re_txt_nom = $pref_re.'RtaTxto' ;
					//
					// Codigo de Pregunta
					$re_preg_cod = $reg['Pregunta_Cod'] ;
					$re->Pone_Pregunta_Cod ( $re_preg_cod ) ;
					//
					// Respuesta
					$re_rta_cod = '';
					if ( isset( $_REQUEST[$re_rta_nom] ) ) 
						{
						$re_rta_cod = $_REQUEST[$re_rta_nom];
						}
					//
					// Pregunta con observacion
					$re_rta_txt = '' ;
					if ( isset( $_REQUEST[$re_txt_nom] ) )
						{
						$re_rta_txt = $_REQUEST[$re_txt_nom] ;
						}
					//
					// Graba		
					//if ( $reg['Pregunta_con_Observacion'] == 1 )
					$re->Pone_Respuesta_Cod ( $re_rta_cod ) ;
					$re->Pone_Respuesta_Txt ( $re_rta_txt ) ;
					$re->Grabar () ;
				}
			}
		//
		// Cierra la conexion
		//
		$cn->cerrar();
		}
		protected function borrar_datos()
		{
			$txt = " DELETE FROM `encuestas` WHERE Nro_Encuesta = 184844 ;
			
					DELETE FROM `respuestas_de_la_encuesta` WHERE Nro_Encuesta = 184844 ;
					
					DELETE FROM `detalle_observaciones_encuestas` WHERE `Nro_Encuesta` = 184867 ;
			" ;
			
		}
		
}


//
// Respuestas de la Encuesta
//

class Respuestas_de_la_Encuesta extends Entidad {
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
			$this->strsql = "update respuestas_de_la_encuesta ".
											" set Respuesta_Cod = ".$Rta_Cod.
											" , Respuesta_Texto = '" .$this->Respuesta_Txt	. "'".
											" WHERE respuestas_de_la_encuesta.Nro_Encuesta = " .$this->id.
											" AND respuestas_de_la_encuesta.Pregunta_Cod = " .$this->Pregunta_Cod . " "
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
		}
	public function Pone_Respuesta_Txt ( $Rta_txt )
		{
			$this->Respuesta_Txt = $Rta_txt ;
		}
	protected function Pone_nombre ()
		{
			$this->nombre_tabla = "Respuestas de la Encuesta" ;
		}
	protected function Carga_Sql_Lista() // protected function Carga_Sql_Lectura()
	{
		$this->strsql = "SELECT respuestas_de_la_encuesta.Nro_Encuesta, respuestas_de_la_encuesta.Pregunta_Cod, 
														respuestas_de_la_encuesta.Respuesta_Cod, respuestas_de_la_encuesta.Pregunta_Nro,
														respuestas_de_la_encuesta.Respuesta_Texto , preguntas.Pregunta , 
														preguntas.Pregunta_con_Observacion , preguntas.Texto_Observacion
										 	FROM respuestas_de_la_encuesta LEFT JOIN preguntas 
											ON respuestas_de_la_encuesta.Pregunta_Cod = preguntas.Pregunta_Cod 
											WHERE Nro_Encuesta = " .$this->id  . '  ORDER BY Pregunta_Nro, Pregunta_Cod ' ;
	}
	protected function crear_tabla()
	{
			$txt = "CREATE TABLE IF NOT EXISTS `respuestas_de_la_encuesta` (
  `Nro_Encuesta` int(11) NOT NULL,
  `Pregunta_Cod` int(11) NOT NULL,
  `Respuesta_Cod` int(11) DEFAULT NULL,
  `Pregunta_Nro` tinyint(4) DEFAULT NULL,
  `Respuesta_Texto` mediumtext" ;
	}
	
	function modificar_tabla()
	{
		$txt = "
		
				-- Preguntas
				select * from preguntas where Pregunta_Cod in ( 48,51,52,58,59,60 ) ;
				
				INSERT INTO `preguntas` (`Pregunta_Cod`, `Pregunta`, `Pregunta_con_Observacion`, `Texto_Observacion`) 
					VALUES 	('58', '¿Recibiste la capacitación de Mi Voto Mi Elección en 2015?', 0, ''), 
							('59', '¿Qué sistema de votación te parece el mas indicado para las elecciones en Argentina? *Se puece seleccionar mas de una opcion', 0, ''),
							('60', '¿Cuál de las herramientas de la capacitación te resultó de mayor utilidad?', 0, '');
				
				-- Conjunto de Preguntas
				select * from conjunto_de_preguntas where conjunto_de_preguntas.ConjPreg_Cod = 'EncAl2016m' ;
				
				INSERT INTO `conjunto_de_preguntas` (`ConjPreg_Cod`, `Tipo_de_Encuesta_Cod`, `ConjPreg_Nombre`) 
							VALUES ('EncAl2016m', 'Alumnos___', 'Alumnos 2016 MVME') ;
							
				-- Respuestas
				INSERT INTO `respuestas` (`Respuesta_Cod`, `Respuesta`) 
					VALUES 	('56', 'Muy útil'), ('57', 'Útil'), 
							('58', 'Poco útil'), ('59', 'Inútil')
					;
				
				INSERT INTO `respuestas` (`Respuesta_Cod`, `Respuesta`) 
					VALUES 	('60', 'Boleta Única Electrónica'), ('61', 'Boleta Única de Papel'), 
							('62', 'Boletas Múltiples de Papel'), ('63', 'Voto electrónico'),
							('64', 'Voto a través de Internet'), ('65', 'Ninguno')
					;
				
				INSERT INTO `respuestas` (`Respuesta_Cod`, `Respuesta`) 
					VALUES 	('66', 'Todas')
					;
				
				INSERT INTO `respuestas` (`Respuesta_Cod`, `Respuesta`) 
					VALUES 	('67', 'Positivo') , ('68', 'Negativo')
					;
				
				-- Respuestas de las preguntas
				
				INSERT INTO `respuestas_de_la_pregunta` (`RespPreg_Cod`, `Pregunta_Cod`, `Respuesta_Nro`, `Respuesta_Cod`) 
						VALUES ('98', '58', '1', '1'), 
								('99', '58', '2', '2'),
								 
								('100', '48', '1', '56'), 
								('101', '48', '2', '57'),
								('102', '48', '3', '58'),
								('103', '48', '4', '59'),
								('104', '48', '9', '3'),
								
								('105', '59', '1', '60'), 
								('106', '59', '2', '61'),
								('107', '59', '3', '62'),
								('108', '59', '4', '63'),
								('109', '59', '5', '64'),
								('110', '59', '6', '65'),
								('111', '59', '9', '3'),
								
								('112', '60', '1', '31'),
								('113', '60', '2', '33'),
								('114', '60', '3', '30'),
								('115', '60', '4', '66'),
								('116', '60', '9', '31'),
								
								('117', '60', '1', '67'),
								('118', '60', '2', '68'),
								('119', '60', '9', '3')
								
								;
				
				-- Detalle
				select * from conjunto_de_preguntas_detalle where  ConjPreg_Cod = 'EncAl2016m' ;
				
				INSERT INTO `conjunto_de_preguntas_detalle` (`ConjPregDet_Nro`, `ConjPreg_Cod`, `Pregunta_Nro`, `Pregunta_Cod`) VALUES
						(119, 'EncAl2016m', 1, 58),
						(120, 'EncAl2016m', 2, 48),
						(121, 'EncAl2016m', 3, 59),
						(122, 'EncAl2016m', 4, 60),
						(123, 'EncAl2016m', 5, 51),
						(124, 'EncAl2016m', 6, 52) ;
				
		
				";
				//
				// EncAl2016p
				$txt = "
		
				-- Preguntas
				select * from preguntas where Pregunta_Cod in ( 48,61,62,63,51 ) ;
				
				INSERT INTO `preguntas` (`Pregunta_Cod`, `Pregunta`, `Pregunta_con_Observacion`, `Texto_Observacion`) 
					VALUES 	('61', '¿Participás activamente de alguno de los siguientes espacios?', 0, ''), 
							('62', '¿Por que consideras de importancia solicitar información pública a las autoridades gubernamentales?', 0, ''),
							('63', '¿Después del taller, sentis que tu motivación para participar es:?', 0, ''),
							('64', '¿Que te pareció la capacitación que acabas de recibir?', 0, '');
				
				-- Conjunto de Preguntas
				select * from conjunto_de_preguntas where conjunto_de_preguntas.ConjPreg_Cod = 'EncAl2016p' ;
				
				INSERT INTO `conjunto_de_preguntas` (`ConjPreg_Cod`, `Tipo_de_Encuesta_Cod`, `ConjPreg_Nombre`) 
							VALUES ('EncAl2016p', 'Alumnos___', 'Alumnos 2016 PC') ;
							
				-- Respuestas
				INSERT INTO `respuestas` (`Respuesta_Cod`, `Respuesta`) 
					VALUES 	('69', 'Nada útil'), ('70', 'No sé')
					;
				
				INSERT INTO `respuestas` (`Respuesta_Cod`, `Respuesta`) 
					VALUES 	('71', 'Espacio politico ( partido político, centro de estudiantes)'),
							('72', 'Organización social, barrial, deportiva o cultural'), 
							('73', 'ONG s'), 
							('74', 'Otros')
					;
				
				INSERT INTO `respuestas` (`Respuesta_Cod`, `Respuesta`) 
					VALUES 	('75', 'Permite participar de manera informada y crítica') ,
							('76', 'Permite controlar las acciones del gobierno') ,
							('77', 'Acerca a los ciudadanos al estado') ,
							('78', 'No lo considero importante')
					;
				
				INSERT INTO `respuestas` (`Respuesta_Cod`, `Respuesta`) 
					VALUES 	('79', 'Mayor') ,
							('80', 'Igual que antes') ,
							('81', 'Menor')
					;
				
				
				-- Respuestas de las preguntas
				
				INSERT INTO `respuestas_de_la_pregunta` (`RespPreg_Cod`, `Pregunta_Cod`, `Respuesta_Nro`, `Respuesta_Cod`) 
						VALUES 	('120', '64', '1', '56'), 
								('121', '64', '2', '57'), 
								('122', '64', '3', '58'), 
								('123', '64', '4', '69'),
								('124', '64', '9', '70'),
								
								('125', '61', '1', '71'),
								('126', '61', '2', '72'),
								('127', '61', '3', '73'), 
								('128', '61', '4', '74'),
								('129', '61', '9', '65'),
								
								('130', '62', '1', '75'),
								('131', '62', '2', '76'),
								('132', '62', '3', '77'),
								('133', '62', '4', '78'),
								
								('134', '63', '1', '79'),
								('135', '63', '2', '80'),
								('136', '63', '3', '81'),
								('137', '63', '4', '70'),
								
								('138', '51', '1', '67'),
								('139', '51', '2', '68'),
								('140', '51', '9', '70')
								
								;
				
				-- Detalle
				select * from conjunto_de_preguntas_detalle where  ConjPreg_Cod = 'EncAl2016p' ;
				
				INSERT INTO `conjunto_de_preguntas_detalle` (`ConjPregDet_Nro`, `ConjPreg_Cod`, `Pregunta_Nro`, `Pregunta_Cod`) VALUES
						(125, 'EncAl2016p', 1, 64),
						(126, 'EncAl2016p', 2, 61),
						(127, 'EncAl2016p', 3, 62),
						(128, 'EncAl2016p', 4, 63),
						(129, 'EncAl2016p', 5, 51),
						(130, 'EncAl2016p', 6, 52) ;
				
		
				";
	}
	protected function modificar_tabla_enc_docentes_pc()
	{
		$txt = "
		
				-- Preguntas
				select * from preguntas where Pregunta_Cod in ( 65,3,5,6,70,71,10,66,67,68,69 ) ;
				
						-- son las mismas de las de mi voto ( menos una )
				-- Conjunto de Preguntas
				select * from conjunto_de_preguntas where conjunto_de_preguntas.ConjPreg_Cod = 'Aut__2016p' ;
				
				INSERT INTO `conjunto_de_preguntas` (`ConjPreg_Cod`, `Tipo_de_Encuesta_Cod`, `ConjPreg_Nombre`) 
							VALUES ('Aut__2016p', 'Autoridad_', 'Autoridades 2016 PC') ;
							
				-- Respuestas
				
					-- son las mimas de las de mi voto
				
				
				-- Respuestas de las preguntas
				
					-- son las mismas de las de mi voto
				
				-- Detalle
				select * from conjunto_de_preguntas_detalle where  ConjPreg_Cod = 'Aut__2016p' ;
				
				INSERT INTO `conjunto_de_preguntas_detalle` (`ConjPregDet_Nro`, `ConjPreg_Cod`, `Pregunta_Nro`, `Pregunta_Cod`) VALUES
						(143, 'Aut__2016p', 1, 65),
						(144, 'Aut__2016p', 2, 3),
						(145, 'Aut__2016p', 3, 5),
						(146, 'Aut__2016p', 5, 6),
						(147, 'Aut__2016p', 6, 70), 
						(148, 'Aut__2016p', 7, 71),
						(149, 'Aut__2016p', 8, 10),
						(150, 'Aut__2016p', 9, 66),
						(151, 'Aut__2016p', 9, 67),
						(152, 'Aut__2016p', 9, 68),
						(153, 'Aut__2016p', 10,69)
						;
				
		
				";
	}
	
	protected function modificar_tabla_enc_docentes()
	{
		$txt = "
		
				-- Preguntas
				select * from preguntas where Pregunta_Cod in ( 65,3,4,5,6,9,10,66,67,68,69 ) ;
				
				INSERT INTO `preguntas` (`Pregunta_Cod`, `Pregunta`, `Pregunta_con_Observacion`, `Texto_Observacion`) 
					VALUES 	('65', '¿A su entender, la modalidad de la capacitación brindada en su establecimiento, en el marco del Programa MVME, fue un ejercicio:', 0, ''), 
							('66', 'Conoce algún otro establecimiento en donde le gustaría que se realizara el Programa?', 0, ''),
							('67', 'Establecimiento:', 1, ''),
							('68', 'Contacto:', 1, ''),
							('69', '¿Qué comentarios podría realizar en relación a la implementación del Programa y qué sugerencias brindaría para futuras ediciones?', 1, ''),
							('70','Luego de haber recibido la capacitación, usted estima que los estudiantes quedaron:(puede marcar mas de una opción)', 0, ''),
							('71','¿Cuál de las herramientas de la capacitación estima que pudo resultar de mayor impacto para los estudiantes?', 0, '')
							;
				
				-- Conjunto de Preguntas
				select * from conjunto_de_preguntas where conjunto_de_preguntas.ConjPreg_Cod = 'Aut__2016m' ;
				
				INSERT INTO `conjunto_de_preguntas` (`ConjPreg_Cod`, `Tipo_de_Encuesta_Cod`, `ConjPreg_Nombre`) 
							VALUES ('Aut__2016m', 'Autoridad_', 'Autoridades 2016 MVME') ;
							
				-- Respuestas
				
				select * from respuestas
				
				INSERT INTO `respuestas` (`Respuesta_Cod`, `Respuesta`) 
					VALUES 	('82', 'Más motivados a participar'),
					('83','Menos motivados a participar')
					;
				
				INSERT INTO `respuestas` (`Respuesta_Cod`, `Respuesta`) 
					VALUES 	('84', 'La presentación  y exposición del docente'), ('85', 'El bloque práctico'),
					('86','El intercambio de dudas'),('87','Todas ellas'),('88','Ninguna ')
					;
				
				
				-- Respuestas de las preguntas
				
				INSERT INTO `respuestas_de_la_pregunta` (`RespPreg_Cod`, `Pregunta_Cod`, `Respuesta_Nro`, `Respuesta_Cod`) 
						VALUES 	('141', '65', '1', '5'),
								('142', '65', '2', '65'),
								('143', '65', '9', '70'),
								
								('144', '3' , '1', '8' ),
								('145', '3' , '2', '9' ),
								('146', '3' , '3', '10' ),
								('147', '3' , '4', '11' ),
								('148', '3' , '5', '45' ),
								('149', '3' , '9', '70' ),
								
								('150', '4' , '1', '8' ),
								('151', '4' , '2', '9' ),
								('152', '4' , '3', '10' ),
								('153', '4' , '4', '11' ),
								('154', '4' , '5', '45' ),
								('155', '4' , '9', '70' ),
								
								('156', '5' , '1', '8' ),
								('157', '5' , '2', '9' ),
								('158', '5' , '3', '10' ),
								('159', '5' , '4', '11' ),
								('160', '5' , '5', '45' ),
								('161', '5' , '9', '70' ),
								
								('162', '6' , '1', '8' ),
								('163', '6' , '2', '9' ),
								('164', '6' , '3', '10' ),
								('165', '6' , '4', '11' ),
								('166', '6' , '5', '45' ),
								('167', '6' , '9', '70' ),
								
								
								('168', '70' , '1', '82' ),
								('169', '70' , '2', '20' ),
								('170', '70' , '3', '22' ),
								('171', '70' , '4', '83' ),
								('172', '70' , '5', '21' ),
								('173', '70' , '6', '23' ),
								('174', '70' , '9', '70' ),
								
								('175', '71' , '1', '84' ),
								('176', '71' , '2', '85' ),
								('177', '71' , '3', '86' ),
								('178', '71' , '4', '87' ),
								('179', '71' , '5', '88' ),
								
								('180', '10' , '1', '1' ),
								('181', '10' , '2', '2' ),
								('182', '10' , '9', '70' ),
								
								('183', '66' , '1', '1' ) ,
								('184', '66' , '2', '2' ) 
								
								
								;
				
				-- Detalle
				select * from conjunto_de_preguntas_detalle where  ConjPreg_Cod = 'Aut__2016m' ;
				
				INSERT INTO `conjunto_de_preguntas_detalle` (`ConjPregDet_Nro`, `ConjPreg_Cod`, `Pregunta_Nro`, `Pregunta_Cod`) VALUES
						(131, 'Aut__2016m', 1, 65),
						(132, 'Aut__2016m', 2, 3),
						(133, 'Aut__2016m', 3, 4),
						(134, 'Aut__2016m', 4, 5),
						(135, 'Aut__2016m', 5, 6),
						(136, 'Aut__2016m', 6, 70), 
						(137, 'Aut__2016m', 7, 71),
						(138, 'Aut__2016m', 8, 10),
						(139, 'Aut__2016m', 9, 66),
						(140, 'Aut__2016m', 9, 67),
						(141, 'Aut__2016m', 9, 68),
						(142, 'Aut__2016m', 10,69)
						;
				
				UPDATE funciones SET rol = 'coord' WHERE func_id = '/carga_encuesta_autoridades.php'
				;
				
				";
	}
	
	
	protected function prueba_borrar_datos()
	{
		$txt = "	-- Respuestas 
					SELECT * FROM `respuestas_de_la_encuesta` where `Nro_Encuesta` = 9092
					
					
					-- Encuesta
					SELECT * FROM `encuestas` where `Nro_Encuesta` = 9092
					
					-- Borra Encuesta
					DELETE FROM `encuestas` where `Nro_Encuesta` = 9092 ;
					DELETE FROM `respuestas_de_la_encuesta` where `Nro_Encuesta` = 9092
					
				;" ;
	}
	protected function busqueda_de_huecos()
	{
		$txt = "
				
				" ;
	}
	protected function renumeracion()
	{
		$txt = "
		
				" ;
	}
	protected function textuales_observaciones()
		{
			$this->strsql = "
							SELECT 
								respuestas_de_la_encuesta.Respuesta_Texto as Textual,
								anexo.Anios_y_Cursos_Capacitados,
								encuestas.Nro_Encuesta , anexo.Anexo_Nro ,
								encuestas.Tipo_de_Encuesta_Cod,
								capacitaciones.Programa_Nro ,
								escuelas_general.NOMBRE
								from 
								respuestas_de_la_encuesta 
								inner join encuestas
									on encuestas.Nro_Encuesta = respuestas_de_la_encuesta.Nro_Encuesta
								inner join anexo
									on encuestas.Anexo_Nro = anexo.Anexo_Nro
								inner join capacitaciones
									on capacitaciones.Anexo_Nro = anexo.Anexo_Nro
								left join escuelas_general
									on anexo.CUE = escuelas_general.CUE
								where anexo.Edicion_Nro = 2016
								and respuestas_de_la_encuesta.Respuesta_Texto > ''
								order by respuestas_de_la_encuesta.Respuesta_Texto desc
							" ;
		}
	
}



?>
