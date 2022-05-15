<?php
///MIS CURSOS////////////////////////
include("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['cursos']['acceso'])) {
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
// include("../../../librerias/php/variasfunciones.php");
require('../Cursos.class.php');

if (isset($_REQUEST['tipoVista']) && $_REQUEST['tipoVista'] != "") {
	if ($_REQUEST['tipoVista'] != "undefined") {
		$tipoVista = htmlentities($_REQUEST['tipoVista']);
	} else {
		$tipoVista = "tabla";
	}
} else {
	$tipoVista = "tabla";
}

if (isset($_REQUEST['papelera']) && $_REQUEST['papelera'] == "si") {
	$papelera = false; // Cambiar a true en caso de que se requiera trabajar con la papelera
} else {
	$papelera = false;
}

if (isset($_REQUEST['campoOrden']) && $_REQUEST['campoOrden'] != "") {
	if ($_REQUEST['campoOrden'] != "undefined") {
		$campoOrden = htmlentities($_REQUEST['campoOrden']);
	} else {
		$campoOrden = "iddetalleleccion";
	}
} else {
	$campoOrden = "iddetalleleccion";
}


if (isset($_REQUEST['orden']) && $_REQUEST['orden'] != "") {
	if ($_REQUEST['orden'] != "undefined") {
		$orden = htmlentities($_REQUEST['orden']);
	} else {
		$orden = "DESC";
	}
} else {
	$orden = "DESC";
}

if (isset($_REQUEST['cantidadamostrar']) && $_REQUEST['cantidadamostrar'] != "") {
	if ($_REQUEST['cantidadamostrar'] != "undefined") {
		$cantidadamostrar = htmlentities($_REQUEST['cantidadamostrar']);
	} else {
		$cantidadamostrar = "20";
	}
} else {
	$cantidadamostrar = "20";
}

if (isset($_REQUEST['paginacion']) && $_REQUEST['paginacion'] != "") {
	$pg = htmlentities($_REQUEST['paginacion']);
}

if (isset($_REQUEST['busqueda']) && $_REQUEST['busqueda'] != "") {
	$busqueda = htmlentities($_REQUEST['busqueda']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$busqueda = "";
}

if (isset($_REQUEST['id-categorias-select']) && $_REQUEST['id-categorias-select'] != "") {
	$categorias = htmlentities($_REQUEST['id-categorias-select']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$categorias = "";
}

if (isset($_REQUEST['idcurso'])) {
	$idcurso = htmlentities($_REQUEST['idcurso']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$idcurso = "no existe";
}

if (isset($_REQUEST['idavancecurso'])) {
	$idavancecurso = htmlentities($_REQUEST['idavancecurso']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$idavancecurso = "no existe";
}
if (isset($_REQUEST['avance'])) {
	$avance = htmlentities($_REQUEST['avance']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$avance = "no existe";
}
if (isset($_REQUEST['nombre'])) {
	$nombre = htmlentities($_REQUEST['nombre']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$nombre = "no existe";
}

if (isset($_REQUEST['contadorGlobal'])) {
	$contadorGlobal = htmlentities($_REQUEST['contadorGlobal']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$contadorGlobal = 0;
}

if (isset($_REQUEST['cursosTerminados'])) {
	$cursosTerminados = true;
} else {
	$cursosTerminados = false;
}

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Ocursos = new Cursos;

$resultado = $Ocursos->navegacionCurso($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcurso);
$resultadoExamen = $Ocursos-> mostrarExamen($idcurso);
$resultadoAvance = $Ocursos-> mostrarIndividualAvance($idavancecurso);
$filasAvance = mysqli_fetch_array($resultadoAvance);
$contadorGlobal;
if ($contadorGlobal === "" || $contadorGlobal === NULL) {
	$contadorGlobal = 0;
}
if ($resultado == "denegado") {
	echo $_SESSION['msgsinacceso'];
	exit;
}
// $filasExamen = mysqli_fetch_array($esultadoExamen);

$filasTotales = mysqli_num_rows($resultado);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA

if ($tipoVista == "tabla") { // Si se ha elegido el tipo tabla 
?>
	<div class="box-body table-responsive no-padding">
		<!-- /.box-body -->
		<table class="table table-hover table-bordered">
			<tr>
				<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox" onclick="seleccionarTodo();"></th>
				<th class="columnaDecorada" style="background:#000000;"></th>
				<th class="Ciddetalleleccion">ID</th>
				<th class="Cleccion">Leccion</th>
				<th class="Ctipo">Tipo</th>
				<th class="Cestado">Estado</th>
				<th width="40"></th>
				<th width="40"></th>
			</tr>
			<?php
			while ($filas = mysqli_fetch_array($resultado)) { ?>
				<tr id="iregistro<?php echo $filas['iddetalleleccion'] ?>">
					<td class="checksEliminar" width="30" valign="middle">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['cursos']['eliminar'])) { ?>
							<?php if ($filas['iddetalleleccion'] != 0) { ?>
								<input id="registroEliminar<?php echo $filas['iddetalleleccion'] ?>" type="checkbox" name="registroEliminar[]" value="<?php echo $filas['iddetalleleccion'] ?>" class="checkEliminar"> <!-- modificado -->
							<?php } ?>
						<?php
						}
						?>
					</td>
					<td class="columnaDecorada" style="background:#000000;"></td>
					<td class="Ciddetalleleccion"><?php echo $filas['iddetalleleccion']; ?></td> <!-- modificado -->
					<td class="Cleccion"><?php echo $filas['orden']; ?></td>
					<td class="Ctipo"><?php echo $filas['tipo']; ?></td>
					<td class="Cestado">
						<?php
						if ($filas['visto'] === "NO") {
							echo "Sin Cursar";
						} else {
							echo "Cursada";
						}
						?>
					</td>
					<td>
					</td>
					<td>
						<?php
						/////PERMISOS////////////////
						if (isset($_SESSION['permisos']['cursos']['modificar'])) {
						?>
							<form action="../navegacion/vistacursos.php?n1=cursos&n2=miscursos" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['iddetalleleccion'] ?>" />
								<?php 
								if ($filas['visto'] === "NO") {
									?> 
									<button type="submit" class="btn btn-success btn-xs" value="" title="Modificar">
										<li class="fa fa-book"></li>
									</button>
									<?php
								} else{
									?> 
									<button type="submit" class="btn btn-default btn-xs" value="" title="Modificar">
										<li class="fa fa-book"></li>
									</button>
									<?php
								}
								?>		
							</form>
						<?php
						} else { ?>
							<a class="btn btn-success btn-xs disabled"><i class="fa fa-pencil"></i></a>
						<?php
						}
						?>
					</td>
				</tr>
			<?php
			} //Fin de while si es tabla 
			?>
		</table>
	</div><!-- /.box-body -->
<?php
} else { // Si se ha elegido el tipo lista ///////////////////////////////////////////////////////////////
?>
	<div class="box-body">
		<?php
		while ($filas = mysqli_fetch_array($resultado)) {
		?>
			<div class="col-sm-3 carta-cursos" id="iregistro<?php echo $filas['iddetalleleccion'] ?>">
				<h4 class="d-flex centrar-elementos">
					Leccion #<?php echo $filas['orden']?>
				</h4>
				<hr class="d-flex centrar-elementos">
				<div class="d-flex centrar-elementos">
					<?php 
					switch ($filas['tipo']) {
						case 'texto':
							if ($filas['visto'] === "NO") {
								?><i class="fa fa-paperclip icono-curso text-success"></i><?php
							}else{
								?><i class="fa fa-paperclip icono-curso text-muted"></i><?php
							}
							break;
						case 'enlace':
							if ($filas['visto'] === "NO") {
								?><i class="fa fa-link icono-curso text-success"></i><?php
							}else{
								?><i class="fa fa-link icono-curso text-muted"></i><?php
							}
							break;
						case 'imagen':
							if ($filas['visto'] === "NO") {
								?><i class="fa fa-image icono-curso text-success"></i><?php
							}else{
								?><i class="fa fa-image icono-curso text-muted"></i><?php
							}
							break;
						case 'video':
							if ($filas['visto'] === "NO") {
								?><i class="fa fa-film icono-curso text-success"></i><?php
							}else{
								?><i class="fa fa-film icono-curso text-muted"></i><?php
							}
							break;
						case 'documento':
							if ($filas['visto'] === "NO") {
								?><i class="fa fa-file icono-curso text-success"></i><?php
							}else{
								?><i class="fa fa-file icono-curso text-muted"></i><?php
							}
							break;		
						default:
						if ($filas['visto'] === "NO") {
							?><i class="fa fa-paperclip icono-curso text-success"></i><?php
						}else{
							?><i class="fa fa-paperclip icono-curso text-muted"></i><?php
						}
							break;
					}
					?>
					
				</div>
				<hr>
				<h3 class="d-flex centrar-elementos">
				<?php switch ($filas['tipo']) {
					case 'texto':
						echo "Texto";
						break;
					case 'enlace':
						echo "Enlace";
						break;
					case 'imagen':
						echo "Imagen";
						break;
					case 'video':
						echo "Video";
						break;
					case 'documento':
						echo "Documento";
						break;
					
					default:
						echo "Leccion sin Tipo";
						break;
				} ?>
				</h3>

				
				<form class="d-flex centrar-elementos margen-bot" action="../leccion/vistacursos.php?n1=cursos&n2=miscursos" method="post">
					<input type="hidden" name="contador" value="<?php echo $filasTotales?>"/>
					<input type="hidden" name="id" value="<?php echo $filas['idcurso']?>"/>
					<input type="hidden" name="orden" value="<?php echo $filas['orden']?>"/>
					<input type="hidden" name="id-avancecurso" value="<?php echo $idavancecurso?>"/>
					<input type="hidden" name="id-detalleleccion" value="<?php echo $filas['iddetalleleccion']?>"/>
					<input type="hidden" name="avance" value="<?php echo $avance?>"/>
					<input type="hidden" name="nombre" value="<?php echo $nombre?>"/>
					<?php

/* 					if ($filas['orden'] == 1 || $filas['visto'] === "SI" || $filas['orden'] == $contadorGlobal)  {
						?> dentro if <?php
					} else{
						?> fuera del if<?php
					} */
					if ($filas['visto'] === "NO") {
						?><button class="btn btn-success boton-curso"> Cursar</button><?php
					}else{
						?><button class="btn btn-default boton-curso"> Volver a Cursar</button><?php
					}
						
					?>
				<input type="hidden" name="contadorGlobal" value="<?php echo $contadorGlobal?>"/>
				</form>
			</div>
	<?php
		} //Fin de while
		while ($filasExamen = mysqli_fetch_array($resultadoExamen)) {?>
			<div class="col-sm-3 carta-cursos">
			<h4 class="d-flex centrar-elementos">
				Evaluacion
			</h4>
			<hr class="d-flex centrar-elementos">
			<div class="d-flex centrar-elementos">
				<?php
					if ($filasAvance['iddetalleexamen'] == 0) {
						?> <i class="fa fa-archive icono-curso text-success"></i> <?php
					} else {
						?> <i class="fa fa-archive icono-curso text-muted"></i> <?php
					}?>				
			</div>
			<hr>
			<h3 class="d-flex centrar-elementos">
				<?php echo $filasExamen['nombreExamen']?>				
			</h3>
			<form class="d-flex centrar-elementos margen-bot" action="../examen/vistacursos.php?n1=cursos&n2=miscursos" method="post">
					<input type="hidden" name="contador" value="<?php echo $filasTotales?>"/>
					<input type="hidden" name="id" value="<?php echo $filasExamen['idcurso']?>"/>
					<input type="hidden" name="orden" value="<?php echo $filas['orden']?>"/>
					<input type="hidden" name="id-avancecurso" value="<?php echo $idavancecurso?>"/>
					<input type="hidden" name="id-detalleleccion" value="<?php echo $filas['iddetalleleccion']?>"/>
					<input type="hidden" name="avance" value="<?php echo $avance?>"/>
					<input type="hidden" name="nombre" value="<?php echo $nombre?>"/>
					<input type="hidden" name="nombre" value="<?php echo $filasAvance['iddetalleexamen']?>"/>
					<?php
							if ($filasAvance['iddetalleexamen'] == 0) {
								?> <button class="btn btn-success boton-curso">Presentar</button> <?php
							} else {
								?> <button class="btn btn-default boton-curso" disabled>Examen Enviado</button> <?php //disabled
							}
						?>
					
			</form>
		</div>
		<?php
		} 
	
	} // Fin de sis es lista
	?>

	</div>
	<?php
	paginar($pg, $cantidadamostrar, $filasTotales, $campoOrden, $orden, $busqueda, $tipoVista);
	//FIN DEL CODIGO DE PAGINACION
	if (mysqli_num_rows($resultado) == 0) {
		include("../../../componentes/mensaje_no_hay_registros.php");
	}
	?>
	<!-- 


 -->