<?php
///MIS CURSOS////////////////////////
include("../../seguridad/comprobar_login.php");
require("../Cursos.class.php");

if (isset($_POST['id-detalleleccion'])) {
	$iddetalleleccion = htmlentities($_POST['id-detalleleccion']);
} else {
	$iddetalleleccion = 'no existe';
}

if (isset($_POST['orden'])) {
	$ordenLeccion = htmlentities($_POST['orden']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$ordenLeccion = "no existe";
}

if (isset($_POST['idcurso'])) {
	$idcurso = htmlentities($_POST['idcurso']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$idcurso = "no existe";
}

if (isset($_POST['id-avancecurso'])) {
	$idavancecurso = htmlentities($_POST['id-avancecurso']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$idavancecurso = "no existe";
}

if (isset($_POST['avance'])) {
	$avance = htmlentities($_POST['avance']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$avance = "no existe";
}

if (isset($_POST['nombre'])) {
	$nombre = htmlentities($_POST['nombre']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$nombre  = "";
}

if (isset($_POST['nombreAlumno'])) {
	$nombreAlumno = htmlentities($_POST['nombreAlumno']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$nombreAlumno  = "";
}

if (isset($_POST['nombreExamen'])) {
	$nombreExamen = htmlentities($_POST['nombreExamen']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$nombreExamen  = "";
}

if (isset($_POST['contador'])) {
	$contador = htmlentities($_POST['contador']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$contador = 0;
}

if (isset($_POST['contadorPreguntas'])) {
	$contadorPreguntas = htmlentities($_POST['contadorPreguntas']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$contadorPreguntas = 0;
}

if (isset($_POST['contadorRespuestas'])) {
	$contadorRespuestas = htmlentities($_POST['contadorRespuestas']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$contadorRespuestas = 0;
}

if (isset($_POST['total'])) {
	$total = htmlentities($_POST['total']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$total = 0;
}

if (isset($_POST['idexamen'])) {
	$idexamen = htmlentities($_POST['idexamen']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$idexamen = 0;
}

if (isset($_POST['nombreExamen'])) {
	$nombreExamen = htmlentities($_POST['nombreExamen']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$nombreExamen = 0;
}

if (isset($_POST['cadenaPreguntas'])) {
	$cadenaPreguntas = htmlentities($_POST['cadenaPreguntas']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$cadenaPreguntas = 0;
}
$arregloPregunta = array(); 
$arregloPregunta = explode(":::", $cadenaPreguntas); 
$arregloPregunta = array_filter($arregloPregunta); 

if (isset($_POST['cadenaRespuestas'])) {
	$cadenaRespuestas = htmlentities($_POST['cadenaRespuestas']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$cadenaRespuestas = 0;
}
$arregloRespuesta = array(); 
$arregloRespuesta = explode(":::", $cadenaRespuestas ); 
$arregloRespuesta = array_filter($arregloRespuesta);

if (isset($_POST['cadenaTipo'])) {
	$cadenaTipo = htmlentities($_POST['cadenaTipo']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$cadenaTipo = 0;
}

$arregloTipo = array(); 
$arregloTipo = explode(":::", $cadenaTipo ); 
$arregloTipo = array_filter($arregloTipo);

$cadenaRespuestasAlumno = "";

for ($i=1; $i < $total+1; $i++) { 
	if ($arregloTipo[$i] == "casilla") {
		$nameTemporal = $arregloRespuesta[$i];
		$respuestaTemporal = htmlentities(trim($_POST[$nameTemporal]));
		if ($respuestaTemporal == null) {
			$respuestaTemporal = "SinSeleccionar";
		}
	} else {
		$nameTemporal = $arregloPregunta[$i];
		$respuestaTemporal = htmlentities(trim($_POST[$nameTemporal]));
	}
	$cadenaRespuestasAlumno = $cadenaRespuestasAlumno.":::".$respuestaTemporal;
}

if (isset($_POST['contadorCalificaciones'])) {
	$contadorCalificaciones = htmlentities($_POST['contadorCalificaciones']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$contadorCalificaciones = "no existe";
}

if (isset($_POST['cadenaCalificacion'])) { //ARREGLO CON IDRESPUESTA
	$cadenaIdRespuestas = htmlentities($_POST['cadenaCalificacion']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$cadenaIdRespuestas = "no existe";
}

$arregloIdPregunta = array(); 
$arregloIdPregunta = explode(":::", $cadenaIdRespuestas); 
$arregloIdPregunta = array_filter($arregloIdPregunta);

$cadenaCalificacion = "";

for ($i=1; $i <= $contadorCalificaciones; $i++) { 
	$nameTemporal = $arregloIdPregunta[$i];
	if (isset($_POST[$nameTemporal])) {
		$calificacionTemp = htmlentities($_POST[$nameTemporal]);
	} else {
		$calificacionTemp = 0;
	}
	$cadenaCalificacion = $cadenaCalificacion.":::".$calificacionTemp;
}

if (isset($_POST['calificacionMaxima'])) {
	$calificacionMaxima = htmlentities($_POST['calificacionMaxima']);
} else {
	$calificacionMaxima = "no existe";
}

?>

<!DOCTYPE html>
<html>

<head>
	<?php include("../../../componentes/cabecera.php") ?>
	<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="../../../plugins/fastclick/fastclick.min.js"></script>
	<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
	<script src="js.js"></script>
	<script src="../../../librerias/js/cookies.js"></script>
	<link rel="stylesheet" href="../../../bootstrap/css/style.css">
	<script src="../../../bootstrap/css/style.css"></script>
	<?php
	if (isset($_GET['busqueda'])) {
		echo "<script>
		var busqueda='" . $_GET['busqueda'] . "';
		</script>";
	} else {
		echo '<script>var busqueda="";</script>';
	}
	if (isset($_GET['papelera'])) {
		echo '<script>var papelera="si";</script>';
	} else {
		echo '<script>var papelera="no";</script>';
	}
	?>
</head>

<body class="sidebar-mini <?php include("../../../componentes/skin.php"); ?>">
	<!-- Wrapper es el contenedor principal -->
	<div class="wrapper s">

		<?php include("../../../componentes/menuSuperior.php"); ?>
		<?php include("../../../componentes/menuLateral.php"); ?>
		<!-- Contenido-->
		<div class="content-wrapper">
			<!-- Contenido de la cabecera -->
			<section class="content-header">
				<h1>Examen
				</h1>
				<ol class="breadcrumb">
					<li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
					<li><a href="#">Consultar cursos</a></li>
				</ol>
			</section>

			<!-- Contenido principal -->
			<section class="content">
				<?php
				/////PERMISOS////////////////
				if (!isset($_SESSION['permisos']['cursos']['consultar']) or  !isset($_SESSION['permisos']['cursos']['acceso'])) {
					echo $_SESSION['msgsinacceso'];
					echo "
		</section><!-- /.content -->
       </div><!-- /.content-wrapper -->";
					include("../../../componentes/pie.php");
					echo "
	</div><!-- ./wrapper -->
</body>
</html>";
					include("../../../componentes/avisos.php");
					exit;
				}
				/////FIN  DE PERMISOS////////
				?>

				<?php $herramientas = "consultar";
				include("../componentes/herramientas.php"); ?>
				<?php include("../../../componentes/avisos.php"); ?>
				
				<form class="form-horizontal" name="formularioFiltro" id="formularioFiltro" method="POST">
					<input type="text" name="id-detalleleccion" id="idleccion" value="<?php echo $iddetalleleccion?>">	
					<input type="text" name="orden" id="orden" value="<?php echo $ordenLeccion?>">
					<input type="text" name="contador" id="contador" value="<?php echo $contador?>">
					<input type="text" name="id-avancecurso" value="<?php echo $idavancecurso?>"/>
					<input type="text" name="avance" value="<?php echo $avance?>"/>
					<input type="text" name="nombre" value="<?php echo $nombre?>"/>
					<input type="text" name="nombreAlumno" value="<?php echo $nombreAlumno?>"/>
					<input type="text" name="nombreExamen" value="<?php echo $nombreExamen?>"/>
					<input type="text" name="contadorPreguntas" value="<?php echo $contadorPreguntas?>"/>
					<input type="text" name="contadorRespuestas" value="<?php echo $contadorRespuestas?>"/>
					<input type="text" name="total" value="<?php echo $total?>"/>
					<input type="text" name="idcurso" id="idcurso" value="<?php echo $idcurso?>">
					<input type="text" name="cadenaPreguntas" id="cadenaPreguntas" value="<?php echo $cadenaPreguntas?>">
					<input type="text" name="cadenaRespuestas" id="cadenaRespuestas" value="<?php echo $cadenaRespuestas?>">
					<input type="text" name="cadenaTipo" id="cadenaTipo" value="<?php echo $cadenaTipo?>">
					<input type="text" name="cadenaRespuestasAlumno" id="cadenaRespuestasAlumno" value="<?php echo $cadenaRespuestasAlumno?>">
					<input type="text" name="prueba" id="prueba" value="<?php echo $prueba?>">
					<input type="text" name="idexamen" id="idexamen" value="<?php echo $idexamen?>">
					<input type="text" name="nombreExamen" id="nombreExamen" value="<?php echo $nombreExamen?>">
					<input type="text" name="cadenaIdRespuestas" id="cadenaIdRespuestas" value="<?php echo $cadenaIdRespuestas?>">
					<input type="text" name="contadorCalificaciones" id="contadorCalificaciones" value="<?php echo $contadorCalificaciones?>">
					<input type="text" name="cadenaCalificacion" id="cadenaCalificacion" value="<?php echo $cadenaCalificacion?>">
					<input type="text" name="calificacionMaxima" id="calificacionMaxima" value="<?php echo $calificacionMaxima?>">
				</form>
				<!-- box -->
				<div class="box box-info" style="border-color:#3A6D98">
					<div class="box-header with-border">
						<h3 class="box-title">Examen Enviado</h3>
						
					</div><!-- /.box-header -->
					<div id="muestra_contenido_ajax" style="min-height:100px;">
					</div><!-- /din contenido ajax -->
					<div id="loading" class="overlay">
						<i class="fa fa-cog fa-spin" style="color:#000000"></i>
					</div>

				</div><!-- Fin box>-->
				<!-- <div class="col-sm-4 carta-cursos">
					<h1>Holas</h1>
				</div> -->

			</section><!-- /.content -->
		</div><!-- /.content-wrapper -->

		<?php include("../../../componentes/pie.php"); ?>
	</div><!-- ./wrapper -->

</body>

</html>