<?php
//
// Edicion Actual
//
class Edicion_Anterior extends Entidad {
	public $Edicion_Anterior ;
	public function __construct()
  		{
				$this->existe = false ;
				$this->Edicion_Anterior = 0 ;
				$this->Pone_nombre () ;
				$this->Leer();
				$this->Edicion_Anterior = $this->registro['Edicion_Nro'];
  		}
	protected function Carga_Sql_Lectura()
	{
		$this->strsql  = "	SELECT Max(edicion.Edicion_Nro) as Edicion_Anterior_Nro " ;
		$this->strsql .= "		FROM edicion WHERE edicion.Edicion_Nro < " ;
		$this->strsql .= "		( SELECT Max(edicion.Edicion_Nro) AS Edicion_Actual_Nro " ;
		$this->strsql .= "				FROM edicion " ;
		$this->strsql .= "					WHERE edicion.Edicion_Actual = 1 ) "  ;
	}
}
?>
