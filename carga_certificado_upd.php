<!doctype html>
<html>
<head>
  <title>Carga del Certificado de Escrutinio
	<?php echo " Mesa Nro ";
		echo $_REQUEST['m_mesa_nro'] ; ?></title>
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
	//$cnx->conexion=mysqli_connect("localhost","u876769451_root","3e04u0io","u876769451_rc") or die("Problemas en la conexion");
	$mn=$_REQUEST['m_mesa_nro'];
	$dn=$_REQUEST['m_distrito_nro'];
	//$cbase=$_REQUEST['m_cargo_nro'];
	$tcn=$_REQUEST['m_tcert_nro'];
	$_mesa_id_nro=$_REQUEST['m_mesa_id_nro'];
	$_cantidad_de_votantes = $_REQUEST['m_cantidad_de_votantes'] ;
	$_cantidad_de_sobres = $_REQUEST['m_cantidad_de_sobres'];
	if( $_cantidad_de_votantes > 0 ) { $_cv = $_cantidad_de_votantes ; } else {$_cv = 'null'; }
    if( $_cantidad_de_sobres > 0 ) { $_cs = $_cantidad_de_sobres ; } else {$_cs = 'null'; }
    mysqli_query($cnx->conexion,"update Mesa set Cantidad_de_Votantes= $_cv ,Cantidad_de_Sobres= $_cs where Mesa_Nro = $mn")
	or die("Error en update Mesa ".mysqli_error($cnx->conexion)." Mesa Nro = ".$mn);
	// $listas_cargos=mysqli_query($cnx->conexion,"select Lista_Nro, Cargo_Nro from Cargos , Lista 
	//											where Activo = 1 and Distrito_Nro = $dn and Cargo_Nro = $cbase ")
	//or die(mysqli_error($cnx->conexion));    
	$listas_cargos=mysqli_query($cnx->conexion," Select Lista_Cargos.Lista_Nro, cc.Cargo_Nro from Lista_Cargos
											inner join Lista on Lista_Cargos.Lista_Nro = Lista.Lista_Nro
											inner join
												( Select Tipocert_Cargos.Cargo_Nro from Tipocert_Cargos 
													inner join Cargos on Tipocert_Cargos.Cargo_Nro = Cargos.Cargo_Nro
													where Tipocert_nro = $tcn ) as cc
												on Lista_Cargos.Cargo_Nro = cc.Cargo_Nro
											where  Distrito_Nro = $dn ")
	or die("Error en el select de Listas_cargos".mysqli_error($cnx->conexion)); 

	while( $lista_cargo=mysqli_fetch_array($listas_cargos) )
	{
	$ln=$lista_cargo['Lista_Nro'];
	$cn=$lista_cargo['Cargo_Nro'];
	$nv='m_voto_ll'.$ln.'cc'.$cn;
	$vv=$_REQUEST[$nv];
	if( $vv > 0 ) {
	mysqli_query($cnx->conexion,"update Votos set Voto= $vv where Mesa_Nro = $mn
					and Lista_Nro = '$ln' and Cargo_Nro = $cn")
	or die("Error en update".mysqli_error($cnx->conexion)); }
	else {
	mysqli_query($cnx->conexion,"update Votos set Voto= null where Mesa_Nro = $mn
					and Lista_Nro = '$ln' and Cargo_Nro = $cn")
	or die("Error en update null".mysqli_error($cnx->conexion)); }
	}
	

  ?>
  <!-- Validación de Totales --> 
  <?php 
	$cargos=mysqli_query($cnx->conexion,"Select Cargo_Nro, Cargo from Cargos 
							where Cargo_Nro in 
							( Select Cargo_Nro from Votos 
								where Mesa_Nro = $mn and Voto is not null  and Cargo_Nro in
								( Select Tipocert_Cargos.Cargo_Nro from Tipocert_Cargos 
													inner join Cargos on Tipocert_Cargos.Cargo_Nro = Cargos.Cargo_Nro
													where Tipocert_nro = $tcn )
								 group by Cargo_Nro )")
	or die("Error en el select de cargos para totales ".mysqli_error($cnx->conexion));
	$errores = "";
	$hayerror= false ;
	while($cargo=mysqli_fetch_array($cargos))
	{ 	$cn = $cargo['Cargo_Nro'];
		$totales=mysqli_query($cnx->conexion, "SELECT sum(Voto) as TVoto FROM Votos 
											WHERE Mesa_Nro = $mn and Cargo_Nro = $cn
											and Lista_Nro in ( 
											SELECT Lista_Nro FROM Lista
											WHERE Recuento =1 ) group by Mesa_Nro") 
		or die("Error en el sum de voto, totales".mysqli_error($cnx->conexion));	
		$totscol=mysqli_query($cnx->conexion, "Select Voto as TCol from Votos
											where Mesa_Nro = $mn  and Cargo_Nro = $cn
											and Lista_Nro in (
											Select Lista_Nro From Lista
											where Total = 1 )" )
		or die("Error en el sum de voto, total columna".mysqli_error($cnx->conexion));
	if($total=mysqli_fetch_array($totales))
		{ if($total['TVoto']!=$_cantidad_de_sobres and $total['TVoto'] > 0 )
			{
			$dif =  $_cantidad_de_sobres - $total['TVoto'] ;
			$texto = 'Los votos totalizan '.$total['TVoto'].'<br>'.
					 'el total de sobres es '.$_cantidad_de_sobres.'<br><br>'.
					 'la diferencia es <b>'. $dif .'</b>'.
					  '<br><br>' ;
			$error['Cargo']= $cargo['Cargo'];
			$error['Texto']= $texto;
			$errores[] = $error ;
			$hayerror = true ;
			} 
		}
	} 
  ?>
  <!-- Determina próximo cargo -->
	<?php
	$cnvo=null;
	$cult=true;
	$cargos=mysqli_query($cnx->conexion,"select Tipocert_orden from Tipocert where Tipocert_nro = $tcn")
									or die ("No se obtubo el cargo");
	$cargo =mysqli_fetch_array($cargos);
	$or=$cargo['Tipocert_orden'];
	$proxcargos=mysqli_query($cnx->conexion,"select Def_Cert_Tipos.Tipocert_nro from Distrito
			inner join Def_Cert_Tipos on Distrito.Def_Cert_Nro = Def_Cert_Tipos.Def_Cert_Nro
			inner join Tipocert on Def_Cert_Tipos.Tipocert_nro = Tipocert.Tipocert_nro
			where Distrito.Distrito_Nro = $dn and Tipocert.Tipocert_orden in
			( select min( Tipocert.Tipocert_orden ) as Orden from Distrito
			inner join Def_Cert_Tipos on Distrito.Def_Cert_Nro = Def_Cert_Tipos.Def_Cert_Nro
			inner join Tipocert on Def_Cert_Tipos.Tipocert_nro = Tipocert.Tipocert_nro
			where Distrito.Distrito_Nro = $dn and Tipocert.Tipocert_orden > $or	) " )
							or die("Problemas en el select de Siguiente Orden : ".mysqli_error($cnx->conexion)." or = ".$or);
	
	if ($cargo=mysqli_fetch_array($proxcargos) )
				{ $cnvo=$cargo['Tipocert_nro'] ;
					//echo "Nuevo Cargo".$cnvo ; 
					$cult = false ; }

	

	?>
	

  <!-- Cierre de la Conexión -->
  <?php $cnx->cerrar();//mysqli_close($cnx->conexion); ?>
	<!-- Arma el Form -->
	<?php 
		$inc = false ; // by DZ 2015_10_16 if ( isset($_REQUEST['Inconsistente']) ) { $inc = true ; } else { $inc = false ; }
		//
		// Si quedan mas tipos de certificado para cargar 
		// O si hay error vuelve
		if ( $hayerror==true and $inc == false or $cult==false ) { $pagina = 'carga_certificado.php'; }
		else {  $pagina = 'sel_mesa.php'; 	}
		// Si hay otro cetificado para cargar
		// cambia al proximo tipo de certificado
	  // by DZ 2015_10_16  if ( ( $hayerror == false or $inc == true ) and $cult== false ) { $tc_siguiente=$cnvo; }
		 if ( $cult== false ) { $tc_siguiente=$cnvo; }
		// by DZ 2015_10_16 else { $tc_siguiente=$tcn ; }
	?>
  <form method="post" action="<?php echo $pagina ?>">
	<table class="tablaext" width="100%" >	
		<tr>
			<td align="center">
				<table class="tablacert">
					<tr>
						<td>
							<table class="tablaenc">
								<tr>
									<th colspan="2">
										<h3>Certificado de Escrutinio <?php echo " - Mesa ".$mn ; ?> </h3>
									</th>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<!-- Muestra errores       -->
							<table class="tablaerror">
	<?php
	    if ($hayerror==true) { 
		echo '<tr><th>Cargo</th><th>Error</th></tr>'; 
		for($f=0;$f<count($errores);$f++) 
		{ 
		$error= $errores[$f]; 
  		//echo "Cargo".$error['Cargo']."Texto".$error['Texto']."<br>";
		echo '<tr><td>'.$error['Cargo'].'</td><td>'.$error['Texto'].'</td></tr>';
		}
		}
		else { echo '<tr><th>Certificado Cargado</th></tr>'; }	
		  
	?>
							</table>
						</td>		
					</tr>
					<tr>
						<td>
							<table width="100%"> 
      							<tr>
<?php
									if ($hayerror==true) {
										echo '<td> <input type="submit" value="Corregir" name="carga_anterior">' ; // <!-- by dz 2015 10 16-->
									}
									if ( $cult==true ) {
										$nombre_boton_ok = "selecciona_mesa" ;
									}
									else
									{
										$nombre_boton_ok = "carga_proximo" ;
									}
?> 
									<td class="tablaext" align="right"> 
										<input type="submit" value="Siguiente" name="<?php echo $nombre_boton_ok;?>">
	  									<input type="hidden" name="m_mesa_nro" value="<?php echo $mn; ?>">
	  									<input type="hidden" name="m_distrito_nro" value="<?php echo $dn; ?>">
										<!-- <input type="hidden" name="m_cargo_nro" value="<?php echo $cn; ?>"> -->
										<input type="hidden" name="m_tcert_nro" value="<?php echo $tc_siguiente; ?>"> 
										<input type="hidden" name="m_mesa_id_nro" value="<?php echo $_mesa_id_nro; ?>">
										<input type="hidden" name="m_tcert_anterior" value="<?php echo $tcn; ?>"> <!-- by dz 2015 10 16--> 
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form> 
</body>
</html>
