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

if (isset($_REQUEST['id-leccion'])) {
	$idleccion = htmlentities($_REQUEST['id-leccion']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$idleccion = "no existe";
}

if (isset($_REQUEST['id-curso'])) {
	$idcurso = htmlentities($_REQUEST['id-curso']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$idcurso = "no existe";
}

if (isset($_REQUEST['cursosTerminados'])) {
	$cursosTerminados = true;
} else {
	$cursosTerminados = false;
}

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Ocursos = new Cursos;
// $resultado = $Ocursos->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $categorias, $cursosBusqueda);
// $resultado = $Ocursos->mostrarMisCursos($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $categorias, $cursosTerminados);
// $resultado = $Ocursos->navegacionCurso($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcurso);
$resultado = $Ocursos->mostrarLeccion($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcurso ,$idleccion);
if ($resultado == "denegado") {
	echo $_SESSION['msgsinacceso'];
	exit;
}

$filasTotales = mysqli_num_rows($resultado);
$filas = mysqli_fetch_array($resultado)
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
?>
<div class="container">
	<div class="carta-cursos">
			<div class="titulo-curgo">
			<h1>
				Leccion #<?php echo $filas['orden']?> 
			</h1>
			<h2>
				Leccion de tipo: <?php echo $filas['tipo']?>
			</h2>
			<form class="d-flex" action="../navegacion/vistacursos.php?n1=cursos&n2=nuevocursos" method="post">
					<input type="hidden" name="id" value="<?php echo $filas['idcurso'] ?>"/>
					<button class="btn btn-default"> Volver a Curso </button>
				</form>
		</div>
		<hr>
		<h3>
			<?php echo $filas['contenido']?>
		</h3>
		<hr>
		<div class="botones-curso">
			<button class="btn btn-default">Leccion Anterior</button>
			<button class="btn btn-default">Leccion Siguiente</button>
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