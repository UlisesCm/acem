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

// $resultadoExamen = $Ocursos->mostrarExamen($idcurso);

$resultadoAvance = $Ocursos->mostrarIndividualAvance($idavancecurso);
$filasAvance = mysqli_fetch_array($resultadoAvance);
$iddetalleexamen = $filasAvance['iddetalleexamen'];

$resultado = $Ocursos->mostrarDetallePreguntas($iddetalleexamen);

?>
<div class="container ">
	<div class="carta-cursos margin-top20 margin-bot20">
		<div class="contenedor justify-content-spacebetween">
			<h1 class="margen-lateral-texto">
				text prueba
			</h1>
		</div>
		<hr>
		<form class="margen-5" action="../enviarexamen/vista.php?n1=cursos&n2=nuevocursos" method="post">
			<h1>
				test: <?php echo $filasAvance['idavancecurso']?>
			</h1>
			<?php 
			while ($filas = mysqli_fetch_array($resultado)) {
				$resultadoPregunta2 = $Ocursos->mostrarPreguntas2($filas['idpregunta']);
				$filaPregunta = mysqli_fetch_array($resultadoPregunta2);
				$resultadoRespuesta2 = $Ocursos->mostrarDetalleRespuestas($filas['iddetallepregunta']);
				$filaRespuesta = mysqli_fetch_array($resultadoRespuesta2);
				?>
				<div class="margen-lateral-texto">
					<h1> 
						<?php echo $filaPregunta['pregunta'] ?>
						<small><?php echo $filaPregunta['valor']?> puntos</small>
					</h1>
					<textarea class="form-control" name="" id="" cols="100" rows="3"><?php echo $filaRespuesta['respuesta']?></textarea>
				</div>
				<?php
				
			}	
			?>
		<hr>
		<input type="hidden" name="contadorPreguntas" id="contadorPreguntas" value="<?php echo $contadorPreguntas?>">
		<input type="hidden" name="contadorRespuestas" id="contadorRespuestas" value="<?php echo $contadorRespuestas?>">
		<input type="hidden" name="total" id="total" value="<?php echo $total?>">
		<input type="hidden" name="idcurso" id="idcurso" value="<?php echo $filasExamen['idcurso']?>">
		<input type="hidden" name="idexamen" id="idexamen" value="<?php echo $idexamen?>">
		<input type="hidden" name="cadenaPreguntas" id="cadenaPreguntas" value="<?php echo $cadenaPreguntas?>">
		<input type="hidden" name="cadenaRespuestas" id="cadenaRespuestas" value="<?php echo $cadenaRespuestas?>">
		<input type="hidden" name="cadenaTipo" id="cadenaTipo" value="<?php echo $cadenaTipo?>">
		<input type="hidden" name="id-avancecurso" id="id-avancecurso" value="<?php echo $idavancecurso?>">
		<input type="hidden" name="nombreExamen" id="nombreExamen" value="<?php echo $filasExamen['nombreExamen']?>">
		<div class="contenedor justify-content-center margen-bot2">
			<button class="btn btn-success">Enviar Examen</button>
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
CADENA PREGUNTAS
:::3392117302226
:::3392117302235
:::3392117302235
:::3392117302235
:::3392117302245
:::3392117302270

CADENA RESPUESTAS
:::SinRespuesta
:::3392117302263
:::3392117302322
:::3392117302359
:::SinRespuesta
:::SinRespuesta

CADENA TIPO
:::abierta
:::casilla
:::casilla
:::casilla
:::multiple
:::abierta


:::SinRespuesta
:::SinRespuesta
:::SinRespuesta
:::3542118213718
:::3542118213860
:::3542118213867
:::SinRespuesta
:::SinRespuesta

:::3542118213711
:::3542118213735
:::3542118213740
:::3542118213762
:::3542118213762
:::3542118213762
:::35421182137813542118213871

:::3542118213711
:::3542118213735
:::3542118213740
:::3542118213762
:::3542118213762
:::3542118213762
:::3542118213781
:::3542118213871


[1] => 12312313 
[2] => 12313123 
[3] => multiple 1 
[4] => verificacion 1 
[5] => SinSeleccionar 
[6] => verificacion 2 
[7] => 123131231

[1] => PREGUNTA 3 
[2] => PREGUNTA 1 
[3] => multiple 2 
[4] => verificacion 1 
[5] => SinSeleccionar 
[6] => verificacion 2 
[7] => PREGUNTA 2
-->