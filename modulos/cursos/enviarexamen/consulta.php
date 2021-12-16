<?php
///MIS CURSOS////////////////////////
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

if (isset($_REQUEST['cadenaTipo'])) {
	$cadenaTipo = htmlentities($_REQUEST['cadenaTipo']);
} else {
	$cadenaTipo  = "no existe";
}

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

if (isset($_REQUEST['contadorPreguntas'])) {
	$contadorPreguntas = htmlentities($_REQUEST['contadorPreguntas']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$contadorPreguntas = "no existe";
}


if (isset($_REQUEST['cadenaRespuestasAlumno'])) {
	$cadenaRespuestasAlumno = $_REQUEST['cadenaRespuestasAlumno'];
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




//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Ocursos = new Cursos;

// $resultado = $Ocursos->mostrarLeccion($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcurso, $ordenLeccion);
$resultadoExamen = $Ocursos->mostrarExamen($idcurso);

if ($resultado == "denegado") {
	echo $_SESSION['msgsinacceso'];
	exit;
}

for ($i=0; $i < $total ; $i++) { 
	$idpreguntaTemp = $arregloPregunta[$i+1];
	$idRespuestaTemp = $arregloRespuesta[$i+1];
	$respuestaTemp = $arregloRespuestasAlumno[$i];
	$Ocursos->enviarExamen($idexamen,$idpreguntaTemp,$idRespuestaTemp,$respuestaTemp);
}

// $filasTotales = mysqli_num_rows($resultadoExamen);
$filasExamen = mysqli_fetch_array($resultadoExamen);
$Ocursos->cambiarVisto($filas['iddetalleleccion']);
if ($filas['visto'] == 'NO') {
	$Ocursos->agregarAvance($filas['valor'], $idavancecurso);
}
$preguntas = $Ocursos->mostrarPreguntas($idexamen);


?>
<div class="container ">
	<div class="carta-cursos margin-top20 margin-bot20">
		<div class="contenedor justify-content-spacebetween">
			<h1 class="margen-lateral-texto">
				<?php echo $filasExamen['nombreExamen'] ?>
			</h1>
				<form class="alineacion-centro-texto margen-lateral-texto" action="../navegacion/vistacursos.php?n1=cursos&n2=nuevocursos" method="post">
					<input type="hidden" name="id" value="<?php echo $filasExamen['idcurso'] ?>" />
					<input type="hidden" name="id-avancecurso" value="<?php echo $idavancecurso ?>" />
					<button class="btn btn-default"> Volver al Curso</button>
				</form>
		</div>
		<hr>
		<h2>
			Examen enviado, Espera que tu docente evalue el examen y te asigne una calificacion.
		</h2>
		<h1>
			<?php 
				if (is_array($arregloRespuestasAlumno)) {
					echo "si es arreglo";
				} else {
					echo "no es arreglo";
				}
			?>
		</h1>
		<h1>
			<?php echo $cadenaRespuestasAlumno?>
		</h1>
		<h1>
			<?php echo print_r($arregloRespuestasAlumno)?>
		</h1>
		<div class="contenedor justify-content-center margen-bot2">
			<button class="btn btn-success">Volver al Curso</button>
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