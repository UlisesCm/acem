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

if (isset($_REQUEST['id-detalleleccion'])) {
	$iddetalleleccion = htmlentities($_REQUEST['id-detalleleccion']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$iddetalleleccion = "no existe";
}

if (isset($_REQUEST['id-avancecurso'])) {
	$idavancecurso = htmlentities($_REQUEST['id-avancecurso']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$idavancecurso = "no existe";
}

if (isset($_REQUEST['orden'])) {
	$ordenLeccion = htmlentities($_REQUEST['orden']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$ordenLeccion = "no existe";
}

if (isset($_REQUEST['id'])) {
	$idcurso = htmlentities($_REQUEST['id']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$idcurso = "no existe";
}

if (isset($_REQUEST['contador'])) {
	$contador = htmlentities($_REQUEST['contador']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$contador = 0;
}

if (isset($_REQUEST['cursosTerminados'])) {
	$cursosTerminados = true;
} else {
	$cursosTerminados = false;
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
	$nombre  = "no existe";
}

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Ocursos = new Cursos;

$resultado = $Ocursos->mostrarLeccion($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcurso, $ordenLeccion);

if ($resultado == "denegado") {
	echo $_SESSION['msgsinacceso'];
	exit;
}

$filasTotales = mysqli_num_rows($resultado);
$filas = mysqli_fetch_array($resultado);
$Ocursos->cambiarVisto($filas['iddetalleleccion']);
$avanceActualizado = $Ocursos->mostrarAvance($idavancecurso);
$filaAvance = mysqli_fetch_array($avanceActualizado);
if ($filas['visto'] == 'NO') {
	$Ocursos->agregarAvance($filas['valor'], $idavancecurso);
	$Ocursos->aumentarIndiceLeccion($idavancecurso, $filaAvance['indiceleccion']+1);
}
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
?>
<div class="container ">
	<div class="carta-cursos margin-top20 margin-bot20">
		<div class="contenedor justify-content-spacebetween">
			<h1 class="margen-lateral-texto">
				Lecci??n #<?php echo $filas['orden'] ?>
				<small>
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
				</small>
			</h1>
			<form class="alineacion-centro-texto margen-lateral-texto" action="../navegacion/vistacursos.php?n1=cursos&n2=nuevocursos" method="post">
				<input type="hidden" name="id" value="<?php echo $filas['idcurso'] ?>" />
				<input type="hidden" name="id-avancecurso" value="<?php echo $idavancecurso ?>" />
				<button class="btn btn-default"> Volver al Curso </button>
			</form>
		</div>
		<hr>
		<h2 class="margen-lateral-texto margen-top50">
			Contenido:
		</h2>
		<h3 class="margen-lateral-texto  margen-bot50">
			<?php switch ($filas['tipo']) {
						case 'texto':
							?><p><?php echo $filas['contenido']?></p><?php 
							// echo "Texto";
							break;
						case 'enlace':
							?> <a href="<?php echo $filas['contenido']?>">
								<?php echo $filas['contenido']?>
							</a><?php 
							break;
						case 'imagen':
							$contenidoImagen = "../../../empresas/modulalite/archivosSubidos/cursos/".$filas['contenido'];
							?>
							<div class="contenedor justify-content-center">
								<img class="margin-top20 border-radius" width="90%"  src="<?php echo $contenidoImagen ?>" alt="">
							</div>
							<div class="contenedor justify-content-center margin-top10">
								<a href="<?php echo $contenidoImagen ?>" target="_blank">
									<input class="btn btn-success" type="button" value="Ver Imagen">
								</a>
							</div>
							<?php
							break;
						case 'video':
							$contenidoVideo = "../../../empresas/modulalite/archivosSubidos/cursos/".$filas['contenido'];
							?>
							<div class="contenedor justify-content-center">
								<video class="margin-top20 border-radius" width="90%" src="<?php echo $contenidoVideo?>" controls></video>
							</div>
							<?php 
							break;
						case 'documento':
							$contenidoDocumento = "../../../empresas/modulalite/archivosSubidos/cursos/".$filas['contenido'];
							?> 
							<iframe style="width:100%;height:700px;" src="<?php echo $contenidoDocumento ?>" frameborder="0"></iframe>
							<div class="contenedor justify-content-center margin-top10">
								<a href="<?php echo $contenidoDocumento ?>" target="_blank">
									<input class="btn btn-success" type="button" value="Ver Documento">
								</a>
							</div>
							<?php 
							break;

						default:
						?><p><?php 	echo "No se pudo cargar el recurso";?></p><?php 

							break;
					} ?>
		</h3>
		<hr>
		<div class="contenedor justify-content-center margen-bot2">

			<form class="margen-5" action="../leccion/vistacursos.php?n1=cursos&n2=miscursos" method="post">
				<input type="hidden" name="id" value="<?php echo $filas['idcurso'] ?>" />
				<input type="hidden" name="orden" value="<?php echo $filas['orden'] - 1 ?>" />
				<input type="hidden" name="id-detalleleccion" value="<?php echo $filas['iddetalleleccion'] ?>" />
				<input type="hidden" name="contador" id="contador" value="<?php echo $contador ?>">
				<input type="hidden" name="id-avancecurso" value="<?php echo $idavancecurso ?>" />
				<input type="hidden" name="avance" value="<?php echo $filaAvance['avance'] ?>" />
				<input type="hidden" name="nombre" value="<?php echo $nombre ?>" />
				<?php
				if ($filas['orden'] == 1) {
				?><button class="btn btn-default" disabled>Anterior</button><?php
					} else {
				?><button type="submit" class="btn btn-default">Anterior</button><?php
				}	?>
			</form>

			<form class="margen-5" action="../leccion/vistacursos.php?n1=cursos&n2=miscursos" method="post">
				<input type="hidden" name="id" value="<?php echo $filas['idcurso'] ?>" />
				<input type="hidden" name="orden" value="<?php echo $filas['orden'] + 1 ?>" />
				<input type="hidden" name="id-detalleleccion" value="<?php echo $filas['iddetalleleccion'] ?>" />
				<input type="hidden" name="contador" value="<?php echo $contador ?>">
				<input type="hidden" name="id-avancecurso" value="<?php echo $idavancecurso ?>" />
				<input type="hidden" name="avance" value="<?php echo $filaAvance['avance'] ?>" />
				<input type="hidden" name="nombre" value="<?php echo $nombre ?>" />
				<?php
				if ($filas['orden'] == $contador) {
				?><button class="btn btn-default" disabled>Siguiente</button><?php
				} else {
				?><button type="submit" class="btn btn-default">Siguiente</button><?php
				}	?>
			</form>
		</div>
	</div>

</div>


<?php
// Fin de sis es lista
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