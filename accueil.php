<?php 
	require_once 'controlsesion.php' ; 
	require_once 'class_paginai.php' ; 
	require_once 'clases_base.php' ;
	require_once 'clases_anexo.php' ;
	require_once 'clase_vista_cantidad_capacitaciones.php' ;
	//
	// Dibujar pagina
	//
	$pagina = new Paginai('MVME','</td><td>') ;
	$pagina->sinborde();
	//
	// Obtiene grupo de usuario
	$usr = new utilisateur() ;
	$usr->levanta_usuario_de_la_sesion() ;
	$usr->leer();
	$rol = $usr->obtener_rol();
	if ( $rol == 'dev' or $usr->tiene_rol('admin') )
	{
		$to_edicion_actual = new Edicion_Actual() ;
		$to_cantidad_capas = new vista_cantidad_capacitaciones() ;
		$tn_ea = $to_edicion_actual->Edicion_Actual_Nro ;
		$tn_alumnos_mvme = $to_cantidad_capas->cantidad_alumnos_x_programa($tn_ea,1) ;
		$tn_alumnos_pc = $to_cantidad_capas->cantidad_alumnos_x_programa($tn_ea,5) ;
		
	}
	if ( $rol == 'dev' or $usr->tiene_rol('admin') or $usr->tiene_rol('coordgen') )
	{
	//
		// Stats
		$texto = 		'</td><td align="right" width="80%" >Alumnos MVME: '.$tn_alumnos_mvme;
		$pagina->insertarCuerpo($texto);
		//
		// Stats
		$texto = 		'</td><td align="right" width="80%" >Alumnos PC: '.$tn_alumnos_pc ;
		$pagina->insertarCuerpo($texto);
	}
	
	if ( $rol == 'dev' )
	{
				
		// 
		//
		// Programas en desarrollo
		//
		//
		// Llamados
		$texto = 		'</td><td align="right" width="80%" ><a href="llamados_resumen_capas.php"> <button class="botonmenu"> Llamados </button>' ;
		$pagina->insertarCuerpo($texto);
		//
		// Escuelas
		$texto = 		'</td><td align="right" width="80%" ><a href="escuelas.php"> <button class="botonmenu"> Escuelas </button>' ;
		$pagina->insertarCuerpo($texto);
		//
		// Tipos de Establecimiento
		$texto = 		'</td><td align="right" width="80%" ><a href="tipos_de_establecimiento.php"> <button class="botonmenu"> Tipos de Establecimiento </button>' ;
		$pagina->insertarCuerpo($texto);
		//
		// Generar Nueva Clave de Acceso
		$texto = 		'</td><td align="right" width="80%" ><a href="generar_clave.php"> <button class="botonmenu"> Generar Nueva Clave de Acceso </button>' ;
		$pagina->insertarCuerpo($texto);
		//
		// Funciones
		$texto = 		'</td><td align="right" width="80%" ><a href="funciones.php"> <button class="botonmenu"> Funciones </button>' ;
		$pagina->insertarCuerpo($texto);
		
	}
	if ( $usr->tiene_rol('admin') )
	{
		//
		// Llamados
		$texto = 		'</td><td align="right" width="80%" ><a href="llamados_resumen_capas.php"> <button class="botonmenu"> Llamados </button>' ;
		$pagina->insertarCuerpo($texto);
		//
		// Cronograma
		$texto = 		'</td><td align="right" width="80%" ><a href="crono.php"> <button class="botonmenu"> Cronograma </button>' ;
		$pagina->insertarCuerpo($texto);
		//
		// Capacitaciones Asignadas
		$texto = 		'</td><td align="right" width="80%" ><a href="capacitaciones_asignadas_totales.php" > <button class="botonmenu"> Capacitaciones Asignadas Totales </button>';
		$pagina->insertarCuerpo($texto);
		//
		// Coordinaciones Asignadas
		$texto = 		'</td><td align="right" width="80%" ><a href="coordinaciones_asignadas_totales.php" > <button class="botonmenu"> Coordinaciones Asignadas Totales </button>';
		$pagina->insertarCuerpo($texto);
		//
		// Generar Nueva Clave de Acceso
		$texto = 		'</td><td align="right" width="80%" ><a href="generar_clave.php"> <button class="botonmenu"> Generar Nueva Clave de Acceso </button>' ;
		$pagina->insertarCuerpo($texto);
		//
		// Subir Archivos
		$texto = 		'</td><td align="right" width="80%" ><a href="./subir.php" > <button class="botonmenu"> Subir Arhcivos </button>';
		$pagina->insertarCuerpo($texto);
		//
		// Registrar Nuevo Docente
		$texto = 		'</td><td align="right" width="80%" ><a href="registrarse_docente.php" > <button class="botonmenu"> Registrar Nuevo Docente </button>';
		$pagina->insertarCuerpo($texto);
		//
		// Registrar Usuario
		$texto = 		'</td><td align="right" width="80%" ><a href="registrar_usuario.php" > <button class="botonmenu"> Registrar Nuevo Usuario </button>';
		$pagina->insertarCuerpo($texto);
		//
		// Total de capacitaciones
		$texto = 		'</td><td align="right" width="80%" ><a href="total_de_capacitaciones.php"> <button class="botonmenu"> Total de Capacitaciones </button>' ;
		$pagina->insertarCuerpo($texto);

	}
	if ( $usr->tiene_rol('docente') )
	{
		//
		// Datos Docente
		$texto = 		'</td><td align="right" width="80%" ><a href="datos_docente.php"> <button  class="botonmenu"> Datos Docente </button>' ;
		$pagina->insertarCuerpo($texto);
		//
		// Seleccion de capacitaciones por el docente
		$texto = 		'</td><td align="right" width="80%" ><a href="solicitudes_de_asignacion_de_capacitacion.php"> <button class="botonmenu"> Elegir Capacitaciones </button>' ;
		$pagina->insertarCuerpo($texto);
		//
		// Capacitaciones Asignadas a un Docente
		$texto = 		'</td><td align="right" width="80%" ><a href="capacitaciones_asignadas_del_docente.php" > <button class="botonmenu"> Mis Capacitaciones Asignadas </button>';
		$pagina->insertarCuerpo($texto);

	}
	if ( $usr->tiene_rol('coordgen') )
	{
		//
		// Carga de Anexos
		$texto = 		'</td><td align="right" width="80%" ><a href="sel_capa.php" > <button class="botonmenu"> Carga Anexo </button>';
		$pagina->insertarCuerpo($texto);
	}
	if ( $usr->tiene_rol('coordgen') or $usr->tiene_rol('coord') )
	{
		//
		// Coordinaciones del Coordinador
		$texto = 		'</td><td align="right" width="80%" ><a href="capacitaciones_asignadas_del_coordinador.php" > <button class="botonmenu"> Mis Coordinaciones </button>';
		$pagina->insertarCuerpo($texto);
		//
		// Carga Encuesta de alumnos
		$texto = 		'</td><td align="right" width="80%" ><a href="carga_encuesta_alumnos.php" > <button class="botonmenu"> Carga Encuesta de Alumnos </button>';
		$pagina->insertarCuerpo($texto);
		//
		// Carga Encuesta de Autoridades
		$texto = 		'</td><td align="right" width="80%" ><a href="carga_encuesta_autoridades.php" > <button class="botonmenu"> Carga Encuesta de Autoridades </button>';
		$pagina->insertarCuerpo($texto);
	}
	
	//
	// Cambiar contraseña
	$texto = 		'</td><td align="right" width="80%" ><a href="chlm.php" > <button class="botonmenu"> Cambiar contraseña </button>';
	$pagina->insertarCuerpo($texto);
	//
	// Salir
	$texto = 		'</td><td align="right" width="80%" ><a href="salir.php" > <button class="botonmenu"> Salir </button>';
	$pagina->insertarCuerpo($texto);

	$pagina->graficar();
?>
