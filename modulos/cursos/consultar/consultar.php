<?php
include("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['cursos']['acceso'])) {
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include("../../../librerias/php/variasfunciones.php");
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
		$campoOrden = "idcurso";
	}
} else {
	$campoOrden = "idcurso";
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

if (isset($_REQUEST['id-cursos-input']) && $_REQUEST['id-cursos-input'] != "") {
	$cursosBusqueda = htmlentities($_REQUEST['id-cursos-input']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$cursosBusqueda = "";
}

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Ocursos = new Cursos;
$resultado = $Ocursos->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $categorias, $cursosBusqueda);
if ($resultado == "denegado") {
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Ocursos->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista == "tabla") { // Si se ha elegido el tipo tabla 
?>
	<div class="box-body table-responsive no-padding">
		<!-- /.box-body -->
		<table class="table table-hover table-bordered">
			<tr>
				<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox" onclick="seleccionarTodo();"></th>
				<th class="columnaDecorada" style="background:#000000;"></th>
				<th class="Cidcurso">ID</th>
				<th class="Cnombre">Nombre</th>
				<th class="Ccategoria">Categoria</th>
				<th class="Cicono">Icono</th>
				<th width="40"></th>
				<th width="40"></th>
			</tr>
			<?php
			while ($filas = mysqli_fetch_array($resultado)) { ?>
				<tr id="iregistro<?php echo $filas['idcurso'] ?>">
					<td class="checksEliminar" width="30" valign="middle">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['cursos']['eliminar'])) { ?>
							<?php if ($filas['idcurso'] != 0) { ?>
								<input id="registroEliminar<?php echo $filas['idcurso'] ?>" type="checkbox" name="registroEliminar[]" value="<?php echo $filas['idcurso'] ?>" class="checkEliminar">
							<?php } ?>
						<?php
						}
						?>
					</td>
					<td class="columnaDecorada" style="background:#000000;"></td>
					<td class="Cidcurso"><?php echo $filas['idcurso']; ?></td>
					<td class="Cnombre"><?php echo $filas['nombre']; ?></td>
					<td class="Ccategoria"><?php echo $filas['categoria']; ?></td>
					<td class="Cicono"><?php echo $filas['icono']; ?></td>
					<td>
						<?php
						if (!$papelera) {
						?>
							<?php /////PERMISOS////////////////
							if (isset($_SESSION['permisos']['cursos']['eliminar'])) {
							?>
								<?php if ($filas['idcurso'] == 0) { ?>
									<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
								<?php } else { ?>
									<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idcurso'] ?>))">
										<li class="fa fa-trash"></li>
									</a>
								<?php } ?>
							<?php
							} else { ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php
						} else { ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idcurso'] ?>))">
								<li class="fa fa-recycle"></li>
							</a>
						<?php
						}
						?>
					</td>
					<td>
						<?php
						/////PERMISOS////////////////
						if (isset($_SESSION['permisos']['cursos']['modificar'])) {
						?>
							<form action="../modificar/actualizar.php?n1=cursos&n2=consultarcursos" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idcurso'] ?>" />
								<button type="submit" class="btn btn-success btn-xs" value="" title="Modificar">
									<li class="fa fa-pencil"></li>
								</button>
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
} else { // Si se ha elegido el tipo lista 
?>
	<div class="box-body">
		<?php
		while ($filas = mysqli_fetch_array($resultado)) {
		?>
			<div class="col-sm-3 carta-cursos" id="iregistro<?php echo $filas['idcurso'] ?>">
				<h4 class="d-flex centrar-elementos">
					<?php echo $filas['categoria'] ?>
				</h4>
				<hr class="d-flex centrar-elementos">
				<div class="d-flex centrar-elementos">
					<i class="fa fa-pencil icono-curso"></i>
				</div>
				<hr>
				<h3 class="d-flex centrar-elementos">
					<?php echo $filas['nombre'] ?>
				</h3>
				<div class="d-flex centrar-elementos margen-bot">
					<button class="btn btn-default boton-curso "> Incribirme</button>
				</div>
			</div>
	<?php
		} //Fin de while
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