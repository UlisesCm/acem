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

if (isset($_REQUEST['nombreAlumno'])) {
	$nombreAlumno = htmlentities($_REQUEST['nombreAlumno']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$nombreAlumno  = "no existe";
}

if (isset($_REQUEST['cadenaTipo'])) {
	$cadenaTipo = htmlentities($_REQUEST['cadenaTipo']);
} else {
	$cadenaTipo  = "no existe";
}
$arregloTipo = array(); 
$arregloTipo = explode(":::", $cadenaTipo); 
$arregloTipo = array_filter($arregloTipo); 

if (isset($_REQUEST['cadenaPreguntas'])) {
	$cadenaPreguntas = htmlentities($_REQUEST['cadenaPreguntas']);
} else {
	$cadenaPreguntas  = "no existe";
}
$arregloPregunta = array(); 
$arregloPregunta = explode(":::", $cadenaPreguntas); 
$arregloPregunta = array_filter($arregloPregunta); 

if (isset($_REQUEST['cadenaRespuestas'])) {
	$cadenaRespuestas = htmlentities($_REQUEST['cadenaRespuestas']);
} else {
	$cadenaRespuestas  = "no existe";
}

$arregloRespuesta = array(); 
$arregloRespuesta = explode(":::", $cadenaRespuestas ); 
$arregloRespuesta = array_filter($arregloRespuesta);


if (isset($_REQUEST['idcurso'])) {
	$idcurso = htmlentities($_REQUEST['idcurso']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$idcurso = "no existe";
}

if (isset($_REQUEST['nombreExamen'])) {
	$nombreExamen = htmlentities($_REQUEST['nombreExamen']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$nombreExamen = "no existe";
}

if (isset($_REQUEST['total'])) {
	$total = htmlentities($_REQUEST['total']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$total = "no existe";
}

if (isset($_REQUEST['contadorRespuestas'])) {
	$contadorRespuestas = htmlentities($_REQUEST['contadorRespuestas']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$contadorRespuestas = "no existe";
} 

$arregloContadorRespuesta = array(); 
$arregloContadorRespuesta = explode(":::", $contadorRespuestas ); 
$arregloContadorRespuesta = array_filter($arregloContadorRespuesta);

if (isset($_REQUEST['contadorPreguntas'])) {
	$contadorPreguntas = htmlentities($_REQUEST['contadorPreguntas']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$contadorPreguntas = "no existe";
}


if (isset($_REQUEST['cadenaRespuestasAlumno'])) {
	$cadenaRespuestasAlumno = htmlentities($_REQUEST['cadenaRespuestasAlumno']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$cadenaRespuestasAlumno = "no existe";
}

$arregloRespuestasAlumno = array(); 
$arregloRespuestasAlumno = explode(":::", $cadenaRespuestasAlumno ); 
$arregloRespuestasAlumno = array_filter($arregloRespuestasAlumno);

if (isset($_REQUEST['idexamen'])) {
	$idexamen = htmlentities($_REQUEST['idexamen']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$idexamen = "no existe";
}

if (isset($_REQUEST['contadorCalificaciones'])) {
	$contadorCalificaciones = htmlentities($_REQUEST['contadorCalificaciones']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$contadorCalificaciones = 0;
}

if (isset($_REQUEST['cadenaIdRespuestas'])) {
	$cadenaIdRespuestas = htmlentities($_REQUEST['cadenaIdRespuestas']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$cadenaIdRespuestas = "no existe";
}

$arregloIdRespuestas = array(); 
$arregloIdRespuestas = explode(":::", $cadenaIdRespuestas); 
$arregloIdRespuestas = array_filter($arregloIdRespuestas);

if (isset($_REQUEST['cadenaCalificacion'])) {
	$cadenaCalificacion = htmlentities($_REQUEST['cadenaCalificacion']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$cadenaCalificacion = "no existe";
}

$arregloCalificacion = array(); 
$arregloCalificacion = explode(":::",$cadenaCalificacion); 
$arregloCalificacion = array_filter($arregloCalificacion);

if (isset($_REQUEST['calificacionMaxima'])) {
	$calificacionMaxima = htmlentities($_REQUEST['calificacionMaxima']);
} else {
	$calificacionMaxima = 0;
}
//GENERAR ID
function generarClavePDF($numero,$prefijo="",$sufijo=""){
	if ($sufijo==""){
		$sufijo=date("jwynGis");
	}
	$rand="";
	$caracter= "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
	srand((double)microtime()*1000000);
	for($i=0; $i<$numero; $i++) {
		$rand.= $caracter[rand()%strlen($caracter)];
	}
	return $prefijo.$rand.$sufijo.".pdf";
}
$nombrePDF = generarClavePDF(2);

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Ocursos = new Cursos;

$resultado = $Ocursos->mostrarLeccion($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcurso, $ordenLeccion);
// $Ocursos->enviarCalificacion($contadorCalificaciones, $arregloCalificacion, $arregloIdRespuestas);
$resultadoAvance = $Ocursos->mostrarAvance($idavancecurso);
$filas = mysqli_fetch_array($resultadoAvance);
$iddetalleexamen = $filas['iddetalleexamen'];
$idempleado = $filas['iddocente'];
$resultadoDocente = $Ocursos->mostrarDocente($idempleado);
$filasDocente = mysqli_fetch_array($resultadoDocente);
$nombreDocente = $filasDocente['nombre'];
$calificacionFinal = $Ocursos->enviarCalificacion($contadorCalificaciones, $arregloCalificacion, $arregloIdRespuestas, $calificacionMaxima, $iddetalleexamen, $nombrePDF);

?>
<div class="container">
	<div class="carta-cursos margin-top20 margin-bot20">
		<h1 class="d-flex centrar-elementos">
			??Examen Calificado!
		</h1>
		<hr>
		<h2 class="d-flex centrar-elementos">
			El Total fue de: <strong>&nbsp<?php echo $calificacionFinal?> puntos.</strong>
		</h2>
		<h2 class="d-flex centrar-elementos">
			La Calificaci??n fue enviada a la plataforma.
		</h2>
		<div class="d-flex centrar-elementos">
				<i class="fa fa-check-circle icono-curso2 text-success"></i>
		</div>
		<hr>
		<form action="../evaluacion/vistacursos.php?n1=cursos&n2=evaluar" method="post">
			<div class="contenedor justify-content-center margen-bot2">
				<input class="btn btn-success pull-right margen-5" type="button" value="Generar PDF" onclick="imprimirpdfs()">
				<button class="btn btn-default pull-right margen-5">
					Volver a Evaluaciones
				</button>
				<input type="hidden" name="calificacionFinal" id="calificacionFinal" value="<?php echo $calificacionFinal?>">
				<input type="hidden" name="nombreAlumno" id="nombreAlumno" value="<?php echo $nombreAlumno?>">
				<input type="hidden" name="nombreExamen" id="nombreExamen" value="<?php echo $nombreExamen?>">
				<input type="hidden" name="idavancecurso" id="idavancecurso" value="<?php echo $idavancecurso?>">
				<input type="hidden" name="nombreDocente" id="nombreDocente" value="<?php echo $nombreDocente?>">
				<input type="hidden" name="nombrePDF" id="nombrePDF" value="<?php echo $nombrePDF?>">
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
/* if (mysqli_num_rows($resultado) == 0) {
	include("../../../componentes/mensaje_no_hay_registros.php");
} */
?>
<!-- 
10 - 3622119461631
20 - 3622119461659
15 - 3622119461723
20 - 3622119461638

 -->