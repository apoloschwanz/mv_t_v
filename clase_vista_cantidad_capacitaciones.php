<?php
class vista_cantidad_capacitaciones
{ 	public function cantidad_alumnos_x_programa($pn_edicion_nro,$pn_programa_nro)
	{
		$tn_retorno = null ;
		$this->strsql =  "SELECT " ;
		$this->strsql .= " sum( anexo.Cantidad_de_Alumnos ) as Cantidad_Alumnos_Capacitados";	
		$this->strsql .= " FROM anexo " ;
		$this->strsql .= " LEFT JOIN capacitaciones ON anexo.Anexo_Nro = capacitaciones.Anexo_Nro " ;
		$this->strsql .= " where anexo.Edicion_Nro = ' ".$pn_edicion_nro."' " ;
		$this->strsql .= " AND capacitaciones.Programa_Nro = '".$pn_programa_nro."' " ;
		$cn=new Conexion();
		$this->registros=mysqli_query($cn->conexion,$this->strsql) or
				die("Problemas en el select de lectura de".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id. " <br><br> Sql= ".$this->strsql );
		$cn->cerrar();
		if ( $this->registro=mysqli_fetch_array($this->registros) )
			{
				$this->existe = true ;
				$tn_retorno = $this->registro['Cantidad_Alumnos_Capacitados'];
				mysqli_data_seek ( $this->registros , 0 ) ;	
			}
		else
			{
				$tn_retorno = Null ;
				$this->existe = false ;
			}
		return $tn_retorno ;
	}
	protected function crear(){

			$this->strsql = " CREATE VIEW vista_cantidad_capacitaciones as 
								select count( anexo.Anexo_Nro ) as Cantidad_de_Capas , 
								sum( anexo.Cantidad_de_Alumnos ) as Cantidad_Alumnos_Capacitados , 
								sum( anexo.Cantidad_de_Alumnos_Adicional ) as Cantidad_Adicional_Capacitados , 
								sum( anexo.Cantidad_de_Docentes ) as Cantidad_Docentes_Capacitados,
								YEAR( anexo.Fecha) as Anio, 
								MONTH( anexo.Fecha ) as Mes , 
								escuelas_general.Gestion_Tipo as Gestion , 
								anexo.Edicion_Nro , capacitaciones.Programa_Nro
							From anexo 
							LEFT JOIN escuelas_general
							ON anexo.CUE = escuelas_general.CUE
							LEFT JOIN capacitaciones
							ON anexo.Anexo_Nro = capacitaciones.Anexo_Nro
							GROUP BY YEAR( anexo.Fecha) , MONTH( anexo.Fecha ) , anexo.Edicion_Nro , escuelas_general.Gestion_Tipo ,
							capacitaciones.Programa_Nro
							ORDER BY Anio DESC,Mes,Gestion,Programa_Nro
							" ;
							}
}
?>  
