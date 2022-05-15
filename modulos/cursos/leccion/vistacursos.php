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

if (isset($_POST['id'])) {
	$idcurso = htmlentities($_POST['id']);
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
	$nombre  = "no existe";
}

if (isset($_POST['contador'])) {
	$contador = htmlentities($_POST['contador']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$contador = 0;
}

if (isset($_POST['contadorGlobal'])) {
	$contadorGlobal = htmlentities($_POST['contadorGlobal']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$contadorGlobal = 0;
}

if (isset($_POST['arregloLeccionesVistas'])) {
	$arregloLeccionesVistas = htmlentities($_POST['arregloLeccionesVistas']);
	// $busqueda=mysql_real_escape_string($busqueda);
} else {
	$arregloLeccionesVistas = 0;
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
				<h1>Cursos
					<small> 
						<?php echo $nombre ?>
					</small>
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
				// include("../componentes/herramientas.php"); ?>
				<?php include("../../../componentes/avisos.php"); ?>
				
				<form class="form-horizontal" name="formularioFiltro" id="formularioFiltro" method="POST">
					<input type="hidden" name="id-detalleleccion" id="idleccion" value="<?php echo $iddetalleleccion?>">
					<input type="hidden" name="id" id="id" value="<?php echo $idcurso?>">
					<input type="hidden" name="orden" id="orden" value="<?php echo $ordenLeccion?>">
					<input type="hidden" name="contador" id="contador" value="<?php echo $contador?>">
					<input type="hidden" name="id-avancecurso" value="<?php echo $idavancecurso?>"/>
					<input type="hidden" name="avance" value="<?php echo $avance?>"/>
					<input type="hidden" name="nombre" value="<?php echo $nombre?>"/>
					<input type="hidden" name="contadorGlobal" value="<?php echo $contadorGlobal?>"/>
				</form>
				<div class="box box-info" style="border-color:#68983A">
					<div class="box-header with-border contenedor alineacion-centro">
						<div class="col-sm-2 margen-bot2">
							<h2><?php echo $nombre ?></h2>
						</div>
						<div class="col-sm-7">
							<div class="progress alineacion-centro-texto">
								<div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avance ?>%;">
									<span class="sr-only"><?php echo $avance?>% Complete</span>
								</div>
							</div>
						</div>
						<div class="col-sm-2">
							<h4>
							<?php 
						if ($avance < 100) {
							echo $avance?>% de Progreso<?php
						} else {
							?>Lecciones Terminadas <?php
						}?>
							</h4>
						</div>
						<div class="col-sm-1">
							<form action="../miscursos/vistacursos.php?n1=cursos&n2=miscursos" method="post">
								<button class="btn btn-default pull-right">
									Volver a mis Cursos
								</button>
							</form>
						</div>
					</div>
				</div>
				<!-- box -->
				<div class="box box-info" style="border-color:#3A6D98">
					<div class="box-header with-border">
						<h3 class="box-title">Navegacion Lección</h3>
						
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