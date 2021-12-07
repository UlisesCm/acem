<?php
include("../../seguridad/comprobar_login.php");
require('../Cursos.class.php');
$Ocursos = new Cursos;
if (isset($_POST['id'])) {
	$idcurso = htmlentities(trim($_POST['id']));
}

$resultadoExamen = $Ocursos->mostrarExamen($idcurso);
$filasExamen = mysqli_fetch_array($resultadoExamen);
$idexamen = $filasExamen['idexamen'];
$preguntas = $Ocursos->mostrarPreguntas($idexamen);
?>
<!DOCTYPE html>
<html>

<head>
  <?php include("../../../componentes/cabecera.php") ?>
  <link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
  <script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <script src="../../../plugins/fastclick/fastclick.min.js"></script>
  <script src="../../../dist/js/app.min.js" type="text/javascript"></script>
  <script src="js.js"></script>
  <script src="../../../librerias/js/cookies.js"></script>
  <script src="../../../librerias/js/validaciones.js"></script>
  <script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
  <link rel="stylesheet" href="../../../bootstrap/css/style.css">
</head>

<body class="sidebar-mini <?php include("../../../componentes/skin.php"); ?>">
  <!-- Wrapper es el contenedor principal -->
  <div class="wrapper">

    <?php include("../../../componentes/menuSuperior.php"); ?>
    <?php include("../../../componentes/menuLateral.php"); ?>

    <!-- Contenido-->
    <div class="content-wrapper">
      <!-- Contenido de la cabecera -->
      <section class="content-header">
        <h1>Cursos<small>Nuevo registro</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li><a href="#">Nuevo cursos</a></li>
        </ol>
      </section>

      <!-- Contenido principal -->
      <section class="content">

        <?php
        /////PERMISOS////////////////
        if (!isset($_SESSION['permisos']['cursos']['guardar']) or  !isset($_SESSION['permisos']['cursos']['acceso'])) {
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

        <?php $herramientas = "nuevo";
        include("../componentes/herramientas.php"); ?>
        <?php include("../../../componentes/avisos.php"); ?>

        <!-- Horizontal Form -->
        <div class="box box-info" style="border-color:#3A6D98">
          <div class="box-header with-border">
            <h3 class="box-title">Formulario de registro</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
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
    <form  name="formulario" id="formulario" method="post" enctype ="multipart/form-data">
		<?php
		while ($filas = mysqli_fetch_array($preguntas)) {

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
							?><textarea name="" id="" class="form-control" cols="100" rows="4"></textarea><?php
							break;

						case 'casilla':
							$respuestas = $Ocursos->mostrarRespuestas($filas['idpregunta']);
							while ($filasRespuestas = mysqli_fetch_array($respuestas)){
								?>
								<div class="margen-lateral-texto contenedor alineacion-center">
									<p class="margin-right">
										<?php echo $filasRespuestas['respuesta']?>
									</p>
									<input type="checkbox"  class="" name="<?php echo $filasRespuestas['idpregunta']?>" id="<?php echo $filasRespuestas['idpregunta']?>">
								</div>
								
								<?php
							}
							break;

						case 'multiple':
							$respuestas = $Ocursos->mostrarRespuestas($filas['idpregunta']);
							while ($filasRespuestas = mysqli_fetch_array($respuestas)){
								?> 
								<div class="margen-lateral-texto contenedor alineacion-center">
									<p class="margin-right">
										<?php echo $filasRespuestas['respuesta']?>
									</p>
									<input type="radio"  class="margin-negativo-bot" name="<?php echo $filasRespuestas['idpregunta']?>" id="<?php echo $filasRespuestas['idpregunta']?>">
								</div>
								<?php
							}
							break;

						case 'practica':
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
		<div class="contenedor justify-content-center margen-bot2">
			<button class="btn btn-success">Enviar Examen</button>
		</div>
    </form>
	</div>

</div>
          
            
          
          <div id="loading" class="overlay" style="display:none">
            <i class="fa fa-cog fa-spin" style="color:#000000"></i>
          </div>
        </div><!-- /.box -->
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include("../../../componentes/pie.php"); ?>
  </div><!-- ./wrapper -->
  <script type="text/javascript">
    var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombre", "none", {
      validateOn: ["blur"],
      minChars: 1
    });
  </script>

</body>

</html>