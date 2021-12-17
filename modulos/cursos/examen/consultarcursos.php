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

// $resultado = $Ocursos->mostrarLeccion($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcurso, $ordenLeccion);
$resultadoExamen = $Ocursos->mostrarExamen($idcurso);

if ($resultado == "denegado") {
	echo $_SESSION['msgsinacceso'];
	exit;
}

// $filasTotales = mysqli_num_rows($resultadoExamen);
$filasExamen = mysqli_fetch_array($resultadoExamen);
$Ocursos->cambiarVisto($filas['iddetalleleccion']);
if ($filas['visto'] == 'NO') {
	$Ocursos->agregarAvance($filas['valor'], $idavancecurso);
}
$idexamen = $filasExamen['idexamen'];
$preguntas = $Ocursos->mostrarPreguntas($idexamen);

$contadorPreguntas = 0;
$contadorRespuestas = "";
$total = 0;
$cadenaPreguntas = "";
$cadenaRespuestas = "";
$cadenaTipo = "";
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
					<button class="btn btn-default"> Volver al Curso </button>
				</form>
		</div>
		<hr>
		<form class="margen-5" action="../enviarexamen/vista.php?n1=cursos&n2=nuevocursos" method="post">
		<?php
		while ($filas = mysqli_fetch_array($preguntas)) {
			$contadorPreguntas++;
			?> 
			<h3 class="margen-lateral-texto">
				<?php echo $filas['pregunta'] ?>
				<small>
				 <?php 
				 switch ($filas['tipopregunta']) {
					 case 'abierta':
						echo "Pregunta Abierta -";
						break;

					 case 'casilla':
						echo "Casilla de Verificación -";
						break;

					 case 'multiple':
						echo "Opcion Multiple -";
						break;

					 case 'practica':
						echo "Practica -";
						break;
					 
					 default:
						 echo " ";
						 break;
				 }
				 ?>
				</small>
				<small>
				 <?php echo $filas['valor']?> puntos
				</small>
			</h3>
			<div class="margen-lateral-texto">
				<?php 
					switch ($filas['tipopregunta']) {
						case 'abierta':
							$total++;
							$contadorRespuestas = $contadorRespuestas.":::1";
							$cadenaPreguntas = $cadenaPreguntas.":::".$filas['idpregunta']; //PREGUNTAS
							$cadenaRespuestas = $cadenaRespuestas.":::SinRespuesta";
							$cadenaTipo = $cadenaTipo.":::".$filas['tipopregunta'];
							?><textarea name="<?php echo $filas['idpregunta']?>" id="<?php echo $filas['idpregunta']?>" class="form-control" cols="100" rows="4"></textarea><?php
							break;
						case 'casilla':
							$respuestas = $Ocursos->mostrarRespuestas($filas['idpregunta']);
							$contadorRespuestaTemp = 0;
							$total++;
							while ($filasRespuestas = mysqli_fetch_array($respuestas)){
								$cadenaPreguntas = $cadenaPreguntas.":::".$filas['idpregunta'];  //PREGUNTAS
								$cadenaRespuestas = $cadenaRespuestas.":::".$filasRespuestas['idrespuesta'];
								$cadenaTipo = $cadenaTipo.":::".$filas['tipopregunta'];
								$contadorRespuestaTemp++
								?>
								<div class="margen-lateral-texto contenedor alineacion-center">
									<p class="margin-right">
										<?php echo $filasRespuestas['respuesta']?>
									</p>
									<input type="checkbox" name="<?php echo $filasRespuestas['idrespuesta']?>" id="<?php echo $filasRespuestas['idrespuesta']?>" value="<?php echo $filasRespuestas['respuesta']?>">
								</div>
								<?php
							}
							$contadorRespuestas = $contadorRespuestas.":::".$contadorRespuestaTemp;
							break;
						case 'multiple':						
							$respuestas = $Ocursos->mostrarRespuestas($filas['idpregunta']);
							$cadenaPreguntas = $cadenaPreguntas.":::".$filas['idpregunta'];  //PREGUNTAS
							$cadenaRespuestas = $cadenaRespuestas.":::SinRespuesta";
							$cadenaTipo = $cadenaTipo.":::".$filas['tipopregunta'];
							$contadorRespuestas = $contadorRespuestas.":::1";
							while ($filasRespuestas = mysqli_fetch_array($respuestas)){
								
								$total++;
								?> 
								<div class="margen-lateral-texto contenedor alineacion-center">
									<p class="margin-right">
										<?php echo $filasRespuestas['respuesta']?>
									</p>
									<input type="radio"  class="margin-negativo-bot" name="<?php echo $filasRespuestas['idpregunta']?>" id="<?php echo $filasRespuestas['idpregunta']?>" value="<?php echo $filasRespuestas['respuesta']?>">
								</div>
								<?php
							}
							break;

						case 'practica':
							$total++;
							$contadorRespuestas = $contadorRespuestas.":::1";
							$cadenaPreguntas = $cadenaPreguntas.$filas['idpregunta'];
							$cadenaRespuestas = $cadenaRespuestas.":::SinRespuesta";
							$cadenaTipo = $cadenaTipo.":::".$filas['tipopregunta'];
							?><textarea name="" id="" class="form-control" cols="100" rows="4"></textarea><?php
							break;
						
						default:
							?><textarea name="" id="" class="form-control" cols="100" rows="4"></textarea><?php
							break;
					}
				?>
				
			</div>
			<?php
		}
		?>
		<hr>
		<h3>Numero de Preguntas: </h3>
		<input type="text" name="contadorPreguntas" id="contadorPreguntas" value="<?php echo $contadorPreguntas?>">
		<h3>Arreglo de Respuestas:</h3>
		<input type="text" name="contadorRespuestas" id="contadorRespuestas" value="<?php echo $contadorRespuestas?>">
		<h3>Totales: <?php echo $total?></h3>
		<input type="text" name="total" id="total" value="<?php echo $total?>">
		<h3>idcurso:</h3>
		<input type="text" name="idcurso" id="idcurso" value="<?php echo $filasExamen['idcurso']?>">
		<h3>idexamen:</h3>
		<input type="text" name="idexamen" id="idexamen" value="<?php echo $idexamen?>">
		<h3>Cadena Preguntas:</h3>
		<input type="text" name="cadenaPreguntas" id="cadenaPreguntas" value="<?php echo $cadenaPreguntas?>">
		<h3>cadena Respuestas</h3>
		<input type="text" name="cadenaRespuestas" id="cadenaRespuestas" value="<?php echo $cadenaRespuestas?>">
		<h3>cadena Tipo</h3>
		<input type="text" name="cadenaTipo" id="cadenaTipo" value="<?php echo $cadenaTipo?>">
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

3392117302226,
3392117302235,
3392117302235,
3392117302235,
3392117302245,
3392117302270

null,
3392117302263,
3392117302322,
3392117302359,
null,
null

abierta,
casilla,
casilla,
casilla,
multiple,
abierta

:::3392117302226
:::3392117302235
:::3392117302235
:::3392117302235
:::3392117302245
:::3392117302270

:::SinRespuesta
:::3392117302263
:::3392117302322
:::3392117302359
:::SinRespuesta
:::SinRespuesta

:::abierta
:::casilla
:::casilla
:::casilla
:::multiple
:::abierta
-->