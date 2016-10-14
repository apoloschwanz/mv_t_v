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
?>
