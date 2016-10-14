<?php
	$dn=$_REQUEST['m_distrito_nro'];
	if ( isset($_POST['selecciona_mesa'] ) ) {
	header('Location:sel_mesa.php?m_distrito_nro='.$dn);
	}
	else
	{
?>	



<html> 
<head> 
<title>Carga del Certificado de Escrutinio
	<?php echo " Mesa Nro ";
		echo $_REQUEST['m_mesa_id_nro'] ; ?>
</title> 
<meta charset="utf-8" />
<link rel= "stylesheet" href= estilos.css>
</head> 
<body>
<?php 
	//
	// Clases
	//
	require 'clases_base.php' ;
	require 'clases_certificado.php' ;
	//
	// Conexion
	//
	$cnx=new Conexion();
	//
	// Lee Variables
	//
	$_mesa_id_nro=$_REQUEST['m_mesa_id_nro'];	
	// by DZ 2015_10_16 $dn=$_REQUEST['m_distrito_nro'];
	//$cn=$_REQUEST['m_cargo_nro'];
	$tcn=$_REQUEST['m_tcert_nro'];
	//
	// Si apreto corregir
	if ( isset($_REQUEST['m_tcert_anterior']) and isset($_POST['carga_anterior']) ) {
			$tcn = $_REQUEST['m_tcert_anterior'] ;
		}
	
  	//$cnx->conexion=mysqli_connect("localhost","u876769451_root","3e04u0io","u876769451_rc") or die("Problemas en la conexion");
	// $_mesa_nro=$_REQUEST['m_mesa_nro'];

	//
	// Busca la mesa
	//
	$mesa=mysqli_query($cnx->conexion,"select Mesa_Nro,Cantidad_de_Votantes,Cantidad_de_Sobres
						from Mesa
						where Mesa_id_Nro = $_mesa_id_nro and Mesa.Distrito_Nro = $dn" ) or
				die("Problemas en el select de mesas: ".mysqli_error($cnx->conexion));




	
	
		
	
	//$mesa=mysqli_query($cnx->conexion,"select Mesa_Nro,Cantidad_de_Votantes,Cantidad_de_Sobres
	//				 	from Mesa 
	//					inner join Escuelas
	//						on Mesa.Escuela_Nro = Escuelas.Escuela_Nro
	//					inner join Cirucito
	//						on Escuelas.Circuito = Cirucito.Circuito_Nro  
	//					inner join Distrito 
	//						on Cirucito.Distrito_Nro = Distrito.Distrito_Nro
	//					where Mesa_Nro = $_mesa_nro and Distrito.Distrito_Nro = $dn ") or
	//die("Problemas en el select de mesas:".mysqli_error($cnx->conexion));	
	
	
	
	//
	// Agrega la Mesa si no existe
	//
	$agrega_mesa = 0 ;
	//if ( $agrega_mesa = 1 )
	//{
	//$mn_nvo = $dn * 100000 + $_mesa_id_nro ;
    //mysqli_query($cnx->conexion,"insert into Mesa ( Mesa_Nro, Mesa_id_Nro, Distrito_Nro )
	//				 select mm.Mesa_Nro, mm.Mesa_id_Nro, mm.Distrito_Nro from
	//				( select $mn_nvo as Mesa_Nro, $_mesa_id_nro as Mesa_id_Nro, Distrito_Nro from Distrito 
	//					WHERE Distrito_Nro = $dn ) as mm
	//				left join Mesa on mm.Mesa_Nro = Mesa.Mesa_Nro
	//				where Mesa.Mesa_Nro is null ") or
	//		die("Problemas en el insert de Mesa: ".mysqli_error($cnx->conexion));
	//}	

	
	


	//$cargos=mysqli_query($cnx->conexion,"select Cargo_Nro, Cargo
	//				 from Cargos where Activo =1 and Cargo_Nro = $cn order by Orden") or
	//die("Problemas en el select de cargos:".mysqli_error($cnx->conexion));
	
	//
	// Cargos
	//
	$cargos=mysqli_query($cnx->conexion,"Select Tipocert_Cargos.Cargo_Nro, Cargo from Tipocert_Cargos 
									inner join Cargos on Tipocert_Cargos.Cargo_Nro = Cargos.Cargo_Nro
									where Tipocert_nro = $tcn order by 	Tipocert_Cargos_Orden") or
			die("Probema en el select de Cargos: ".mysqli_error($cnx->conexion));

	//
	// Listas
	//
	//$listas=mysqli_query($cnx->conexion,"select Lista_Nro,Lista_Nro_Identificacion, Lista_Nombre, Agrup_Pol
	//				 from Lista  
	//				 where Distrito_Nro = $dn order by Orden") or
	$listas=mysqli_query($cnx->conexion," select Lista.Lista_Nro,Lista_Nro_Identificacion, Lista_Nombre, Agrup_Pol from Lista
			where Lista_Nro in ( select Lista_Nro from Lista_Cargos 
			inner join Tipocert_Cargos on Lista_Cargos.Cargo_Nro = Tipocert_Cargos.Cargo_Nro
			where Tipocert_nro = $tcn ) and Distrito_Nro = $dn order by Orden ") or	
	die("Problemas en el select de Listas: ".mysqli_error($cnx->conexion));	

	if ($reg=mysqli_fetch_array($mesa))
    	{
			$_mesa_nro = $reg['Mesa_Nro'];
			$query = "insert into Votos(Mesa_Nro,Lista_Nro,Cargo_Nro)  
				select $_mesa_nro as mesa_nro, lc.Lista_Nro, lc.Cargo_Nro from   
				(select Lista_Cargos.Lista_Nro, Lista_Cargos.Cargo_Nro from Lista_Cargos  
				inner join Lista on Lista_Cargos.Lista_Nro = Lista.Lista_Nro 
				inner join Cargos on Cargos.Cargo_Nro = Lista_Cargos.Cargo_Nro where Activo = 1 and Lista.Distrito_Nro =  $dn  )  lc 
				left join (select Mesa_Nro,Lista_Nro,Cargo_Nro from Votos where Mesa_Nro = $_mesa_nro ) vv 
				on lc.Lista_Nro = vv.Lista_Nro and lc.Cargo_Nro = vv.Cargo_Nro 
				where  vv.Lista_Nro is null  " ;
			mysqli_query($cnx->conexion,$query) or
			die("Problemas en el insert de votos ".mysqli_error($cnx->conexion)." <br> query= ".$query );

			

			$distritos=mysqli_query($cnx->conexion,"select Distrito_Nro, Distrito_Nombre
					 from Distrito where Distrito_Nro = $dn ") or
			die("Problemas en el select de Distritos: ".mysqli_error($cnx->conexion));
		    
			$dnom = "" ;
			if ($distrito=mysqli_fetch_array($distritos))
			{ $dnom= $distrito['Distrito_Nombre'] ;
			}


			 ?>
 <form method="post" action="carga_certificado_upd.php" >
	<table class="tablaext" width="100%" ><tr><td align="center">	
	<table class="tablacert"><tr><td>
	<table class="tablaenc"><tr><th colspan="4"><h3>Certificado de Escrutinio <?php echo " - Mesa Nro:".$_mesa_nro ; ?> </h3>
	
	<input type="hidden" name="m_mesa_nro" value="<?php echo $_mesa_nro ; ?>">  
	<input type="hidden" name="m_distrito_nro" value="<?php echo $dn; ?>">   
	<!-- <input type="hidden" name="m_cargo_nro" value="<?php echo $cn; ?>"> -->   
	<input type="hidden" name="m_tcert_nro" value="<?php echo $tcn; ?>"> 
	<input type="hidden" name="m_mesa_id_nro" value="<?php echo $_mesa_id_nro; ?>">	
	<input type="hidden" name="Inconsistente" value="1">
	</th></tr>
    <tr><td>Cantidad de Votantes:</td>
    <td><input type="integer" name="m_cantidad_de_votantes" size="3" value="<?php echo $reg['Cantidad_de_Votantes']; ?>"></td><td>Distrito:</td><td> <?php echo $dnom; ?>  </td>
	</tr>
    <tr><td>Cantidad de Sobres:</td>
    <td><input type="integer" name="m_cantidad_de_sobres" size="3" value="<?php echo $reg['Cantidad_de_Sobres']; ?>"></td>
	</tr>
	</table></td></tr>	
	
	<?php
		echo '<tr><td><table class="tablavoto">';
    	echo '<tr>';
		echo '<th>Lista Nro.</th><th>Agrupación Política</th>';
		//$list_cargos=0;
		$i=0;
		while ($cargo=mysqli_fetch_array($cargos))
    	{ echo '<th>'.$cargo['Cargo'].'</th>'; 
		$list_cargos[$i]=$cargo['Cargo_Nro'];
		$i=$i+1;
		}
		$cnt_cargos = $i;
		echo '</tr>';
		//
		// Recorre listas
    	while ($lista=mysqli_fetch_array($listas))
		{
		echo '<tr>';
		$_lista_nro = $lista['Lista_Nro'];
		$_lista_id = $lista['Lista_Nro_Identificacion'];
		//
		// Votos
		//
		// falta filtrar por activo
		//$votos=mysqli_query($cnx->conexion,"select vv.Voto, vv.Cargo_Nro
		//			 from Votos vv right join 
		//			 ( Select Cargo_Nro , Tipocert_Cargos_Orden from Tipocert_Cargos where Tipocert_nro = $tcn )					
		//			 cc on vv.Cargo_Nro = cc.Cargo_Nro
		//			 where vv.Mesa_Nro = $_mesa_nro and vv.Lista_Nro = '$_lista_nro' 
		//			 order by Tipocert_Cargos_Orden ") or
		//die("Problemas en el select de Votos:".mysqli_error($cnx->conexion));	
		if ($lista['Agrup_Pol']==1) {
		echo '<td>'.$_lista_id.'</td>'; }
		else { echo '<td> </td>'; }
		echo '<td>'.$lista['Lista_Nombre'].'</td>';
		//while ($voto=mysqli_fetch_array($votos))
		for($f=0;$f<$cnt_cargos;$f++) 
		{
		$fcargo=$list_cargos[$f];
		$votos=mysqli_query($cnx->conexion,"select Voto, Votos.Cargo_Nro
					 from Votos inner join Lista_Cargos on Votos.Lista_Nro = Lista_Cargos.Lista_Nro and
									Votos.Cargo_Nro = Lista_Cargos.Cargo_Nro 
					where Votos.Mesa_Nro = $_mesa_nro and Votos.Lista_Nro = '$_lista_nro' and
					Votos.Cargo_Nro = $fcargo") or
		die("Problemas en el select de Votos:".mysqli_error($cnx->conexion)." Lista = ".$_lista_nro." Cargo = ".$fcargo );
		if ($voto=mysqli_fetch_array($votos)) 
			{
			echo'<td>';	// echo'<td style="background-color:lightgrey">';	
			echo'<input type="number" name=';
			echo'"m_voto_ll'.$_lista_nro.'cc'.$voto['Cargo_Nro'].'" size="3" ';
			echo'value="'.$voto['Voto'].'" style="width:100%;border-style:none;text-align: right; " >';
			echo'</td>';
			}
		else
			{ echo'<td> --- </td>'; }
		}
		echo '</tr>'; 
		}
		// Fin Recorre lista
	?>
	</table></td></tr>
		<tr><td>
		<table class="tablapie">
			<tr><td></td><td align="right" width="100%" ><input type="submit" value="Confirmar"></td></tr>
		</table>
		</td></tr>	
	</table>
	</td></tr></table>
    
	</form>
<?php }
	else
		{   
			echo " El número de mesa Ingresado no Existe para el Distrito" ; 
			 echo '<a onclick="history.back(-1);" > <button> Volver</button> </a> ';
			 }
	
	$cnx->cerrar();//mysqli_close($cnx->conexion);
?>


</body> 
</html>

<?php
}
?>
