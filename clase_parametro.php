<?php
class parametro extends entidad {
	public function Obtener_Parametro($Parametro_Nro)
	{
		//
		// Fecha Hasta Seleccion de Registros.
		$this->id = $Parametro_Nro;
		$this->Leer();
		if ( $this->existe )
		{
			if ( $this->registro['Tipo'] == 'DATE' ) 
				return $this->registro['Valor_Date_Date'] ;
			else
				return $this->registro['Valor_Str'] ;
		}
		else
			return null ;
	}
	protected function Carga_Sql_Lectura()
	{
		$this->strsql = "SELECT " ;
		$this->strsql .= "Parametro_Nro, " ;
		$this->strsql .= "Parametro, " ;
		$this->strsql .= "Tipo, " ;
		$this->strsql .= "Valor_Str, " ;
		$this->strsql .= "Valor_Int, " ;
		$this->strsql .= "CAST(Valor_Date AS DATE ) as Valor_Date_Date, " ;
		$this->strsql .= "CAST(Valor_Date AS TIME) as Valor_Date_TIME, " ;
		$this->strsql .= "CAST(Valor_Date AS TIME) as Valor_Date_DATETIME " ;
		$this->strsql .= "FROM parametros " ;
		$this->strsql .= "WHERE" ;
		$this->strsql .= " Parametro_Nro = '" . $this->id . "' " ;
	}
	protected function Crear_Tabla()
	{
		$sql = " CREATE TABLE parametros ( Parametro_Nro INT PRIMARY KEY, Parametro Varchar(50) , Tipo Varchar(5) , Valor_Str varchar(255) , Valor_Int INT, Valor_Date DATETIME ) ;
					INSERT INTO parametros ( Parametro_Nro, Tipo , Valor_Date ) Values( 1 ,'DATE', '2016/05/27' ) ;
		" ;
		
	}
	public function prueba()
	{
		echo ' Prueba de clase parametro <br>' ;
		$fecha = $this->Obtener_Parametro(1) ;
		echo ' La fecha obtenida es '.$fecha ;
	}
}
?>
