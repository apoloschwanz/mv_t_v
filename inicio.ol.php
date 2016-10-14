<html> 

<meta charset="utf-8" />

<head> 
<title>Cronograma MVME</title> 
<link rel= "stylesheet" href= estilos.css>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head> 
<body>
	<?php 
	require 'clases_base.php' ;
	require 'clases_anexo.php' ;
  	//
	// Conexion
	//
	$cnx=new Conexion();
	//	$this->registros=mysqli_query($cn->conexion,$this->strsql) or
	//				die("Problemas en el select de ".$this->nombre_tabla.": ".mysqli_error($cn->conexion). " id = ".$this->id );

	//
	// Levanta Variables
	//
	//$_mesa_nro=$_REQUEST['m_mesa_nro'];
	//$dn=$_REQUEST['m_distrito_nro'];
	$cnx->cerrar();
	?>

<!-- dz 2015-05-02 
 <form method="post" action="recuento.php" >
-->
	<table class="tablaext" width="100%" ><tr><td align="center">	
	<table class="tablacert"><tr><td>
	<table class="tablaenc"><tr><th colspan="4"><h3>Gestion Integral de Capacitaciones</h3></th></tr>
	
	</td></tr>
		<tr><td>
		<table class="tablapie">
			<!-- dz 2015-05-02 
			<tr><td></td><td align="right" width="100%" ><input type="submit" value="Cargar"></td></tr>
			-->
			<!-- dz 2015-08-18 <tr><td></td><td align="right" width="80%" ><a href="docentes.php"> <button> Docentes </button>  </td></tr> -->
			<tr><td width="80%" style="word-wrap:break-word" >Acciones:</td></tr>
			<!-- <tr><td></td><td align="right" width="80%" ><a href="crono.php?m_nro_edicion=2115 "> <button> Elegir Capacitaciones </button></td></tr> -->
			<tr><td></td><td align="right" width="80%" ><a href="sel_capa.php"> <button> Carga Anexo </button></td></tr>
			<tr><td></td><td align="right" width="80%" ><a href="capas_solicitadas.php"> <button> Capas Solicitadas </button></td></tr>
			<tr><td></td><td align="right" width="80%" ><a href="crono_sel_docente.php?m_nro_edicion=2115 "> <button> Elegir Capacitaciones Opcionales</button></td></tr>
			<tr><td></td><td align="right" width="80%" ><a href="capacitaciones_crono.php?m_nro_edicion=2115 "> <button> Crono On Line</button></td></tr>
		</table>
		</td></tr>
		<!-- dz 2015-05-02 
		<tr><td>
		<a href="info.php">Info PHP</a>
		</td></tr>
		-->
	</table>
	</td></tr></table>
<!-- dz 2015-05-02     
	</form>
-->

</body> 
</html>
