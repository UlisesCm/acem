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

if (isset($_REQUEST['nombreExamen'])) {
	$nombreExamen = htmlentities($_REQUEST['nombreExamen']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$nombreExamen  = "no existe";
}
//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Ocursos = new Cursos;

// $resultadoExamen = $Ocursos->mostrarExamen($idcurso);
$calificacionFinal=0;
$resultadoAvance = $Ocursos->mostrarIndividualAvance($idavancecurso);
$filasAvance = mysqli_fetch_array($resultadoAvance);
$iddetalleexamen = $filasAvance['iddetalleexamen'];
$resultado = $Ocursos->mostrarDetallePreguntas($iddetalleexamen);
$resultadoAlumno = $Ocursos->mostrarIndividualAlumno($filasAvance['idalumno']);
$filasAlumno = mysqli_fetch_array($resultadoAlumno);
$cadenaCalificaciones = "";
$alumno = $filasAlumno['nombre'];
$contadorCalificaciones = 0;
?>
<div class="container ">
	<div class="carta-cursos margin-top20 margin-bot20">
		<div class="contenedor justify-content-spacebetween">
			<h1 class="margen-lateral-texto">
				<?php echo $nombreExamen?>
				<small>
					<?php echo $alumno?>
				</small>
			</h1>
		</div>
		<hr>
		<!-- <form class="margen-5" action="../enviarexamen/vista.php?n1=cursos&n2=nuevocursos" method="post"> -->
		<form class="margen-5" action="../enviarcalificacion/vista.php?n1=cursos&n2=evaluar" method="post">
			<?php
			$calificacionMaxima = 0; 
			while ($filas = mysqli_fetch_array($resultado)) {
				$calificacionTemp = 0;
				$resultadoPregunta2 = $Ocursos->mostrarPreguntas2($filas['idpregunta']);
				$filaPregunta = mysqli_fetch_array($resultadoPregunta2);
				/* $resultadoRespuesta2 = $Ocursos->mostrarDetalleRespuestas($filas['iddetallepregunta']);
				$filaRespuesta = mysqli_fetch_array($resultadoRespuesta2); */
				?>
				<div class="margen-lateral-texto">
					<h1> 
						<?php echo $filaPregunta['pregunta'] ?>
						<small><?php echo $filaPregunta['tipopregunta']." - ".$filaPregunta['valor']?> puntos</small>
					</h1>
					<?php 
					switch ($filaPregunta['tipopregunta']) {
						case 'abierta':
							$resultadoRespuesta2 = $Ocursos->mostrarDetalleRespuestas($filas['iddetallepregunta']);
							$filaRespuesta = mysqli_fetch_array($resultadoRespuesta2);
							?><textarea class="form-control" name="" id="" cols="100" rows="3" disabled><?php echo $filaRespuesta['respuesta']?></textarea><?php
							break;
						case 'casilla'://checkboxk
							$respuestas = $Ocursos->mostrarRespuestas($filas['idpregunta']);
							$cantidadRespuestas = mysqli_num_rows($respuestas);
							$operacion = $filaPregunta['valor']/$cantidadRespuestas;
							$respuestasTemp = 0;
							while ($filasRespuestas = mysqli_fetch_array($respuestas)) {
								$respuestas2 = $Ocursos->mostrarDetalleRespuestas2($filasRespuestas['idrespuesta']);
								$filasDetallesRespuestas = mysqli_fetch_array($respuestas2);
								?>
								<div class="margen-lateral-texto contenedor alineacion-center ">
									<div class="col-md-3">
										<p class="margin-right">
											<?php echo $filasRespuestas['respuesta']?>
										</p>
									</div>
									<input 
										type="checkbox" 
										name="<?php echo $filasRespuestas['idrespuesta']?>" 
										id="<?php echo $filasRespuestas['idrespuesta']?>" 
										value="<?php echo $filasRespuestas['respuesta']?>"
										<?php 
											if ($filasRespuestas['respuesta'] == $filasDetallesRespuestas['respuesta']) {
												?> checked <?php
											}
										?>
										disabled
									>
								</div>
								<?php
								if (($filasRespuestas['correcto'] == "on") && ($filasRespuestas['respuesta'] == $filasDetallesRespuestas['respuesta'])) {
									$respuestasTemp = $respuestasTemp + $operacion;
								}
								if (($filasRespuestas['correcto'] == "off") && ($filasRespuestas['respuesta'] != $filasDetallesRespuestas['respuesta'])) {
									$respuestasTemp = $respuestasTemp + $operacion;
								}
							}
							$calificacionTemp = round($respuestasTemp);
							break;
						case 'multiple'://radio
							$respuestas = $Ocursos->mostrarRespuestas($filas['idpregunta']);

							while ($filasRespuestas = mysqli_fetch_array($respuestas)) {
								$respuestas2 = $Ocursos->mostrarDetalleRespuestas2($filasRespuestas['idrespuesta']);
								$filasDetallesRespuestas = mysqli_fetch_array($respuestas2);
								?>
								<div class="margen-lateral-texto contenedor alineacion-center ">
									<div class="col-md-3">
										<p class="margin-right">
											<?php echo $filasRespuestas['respuesta']?>
										</p>
									</div>
									<input 
										type="radio" 
										name="<?php echo $filasRespuestas['idrespuesta']?>"
										id="<?php echo $filasRespuestas['idrespuesta']?>"
										value="<?php echo $filasRespuestas['respuesta']?>"
										<?php 
											if ($filasRespuestas['respuesta'] == $filasDetallesRespuestas['respuesta']) {
												?> checked <?php
											}
										?>
										disabled
									>
								</div>
								<?php
								if (($filasRespuestas['correcto'] == "on") && ($filasRespuestas['respuesta'] == $filasDetallesRespuestas['respuesta'])) {
									$calificacionTemp = $filaPregunta['valor'];
								}
							}
							break;

						case 'practica':
							break;
						
						default:
							break;
					}					
					?>
				</div>
				<div class="margen-lateral-texto contenedor margin-top20 row">
					<label class="label-alinear2"> Calificacion: </label>
					<div class="col-md-2">
						<input 
							type="text" 
							class="form-control" 
							name="<?php echo $filas['idpregunta']?>"
							value="<?php echo $calificacionTemp?>"
						>
					</div>
				</div>
				<hr>
				<?php
				$calificacionFinal = $calificacionFinal + $calificacionTemp;
				$cadenaCalificaciones = $cadenaCalificaciones.":::".$filas['idpregunta'];
				$contadorCalificaciones++;
				$calificacionMaxima = $calificacionMaxima + $filaPregunta['valor'];
			}	
			?>
		<input type="hidden" name="id-avancecurso" id="id-avancecurso" value="<?php echo $idavancecurso?>"> <!-- SI EXISTE -->
		<input type="hidden" name="cadenaCalificacion" id="cadenaCalificacion" value="<?php echo $cadenaCalificaciones?>"> <!-- SI EXISTE -->
		<input type="hidden" name="contadorCalificaciones" id="contadorCalificaciones" value="<?php echo $contadorCalificaciones?>"> <!-- SI EXISTE -->
		<input type="hidden" name="calificacionMaxima" id="calificacionMaxima" value="<?php echo $calificacionMaxima?>"> <!-- SI EXISTE -->
		<!-- VARIABLES PARA PDF -->
		<input type="hidden" name="calificacionFinal" id="calificacionFinal" value="<?php echo $calificacionFinal?>">
		<input type="hidden" name="nombreExamen" id="nombreExamen" value="<?php echo $nombreExamen?>"> <!-- SI EXISTE -->
		<input type="hidden" name="nombreAlumno" id="nombreAlumno" value="<?php echo $alumno?>"> <!-- SI EXISTE -->
		<input type="hidden" name="calificacionFinal" id="calificacionFinal" value="<?php echo $calificacionFinal?>"> <!-- SI EXISTE -->
		<input type="hidden" name="nombreDocente" id="nombreDocente" value="<?php echo $nombreDocente?>">
		<div class="contenedor justify-content-center margen-bot2">
			<button class="btn btn-success" id="enviarexamen" onclick="">Enviar Calificación</button>
		</div>
		</form>
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
:::3622119461631
:::3622119461659
:::3622119461723
:::3622119461638
-->