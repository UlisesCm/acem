<?php
include("../../seguridad/comprobar_login.php");
require("../Cursos.class.php");
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocursos= new Cursos;
	$resultado=$Ocursos->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
  $idcurso=$extractor["idcurso"];
	$nombre=$extractor["nombre"];
	$categoria=$extractor["categoria"];
	$icono=$extractor["icono"];
}
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
        <h1>Cursos<small>Inscribirme</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li><a href="#">Inscribirme</a></li>
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
        <div class="box box-info" style="border-color:#000000">
          <div class="box-header with-border">
            <h3 class="box-title">Formulario de registro</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" name="formularioInscribirme" id="formulario-inscribirme" method="post" enctype ="multipart/form-data">  
          <div class="box-body">

              <input type="hidden" name="id" value="<?php echo $idcurso ?>" readonly="readonly"/>
              <div class="form-group ">
                <label for="selectiddocente_ajax" class="col-sm-2 control-label">Docente:</label>
                <div class="col-sm-5">
                  <select id="iddocente_ajax" name="docente" class="form-control">
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="calumno" class="col-sm-2 control-label">Alumno:</label>
                <div class="col-sm-5">
                  <input name="calumno" type="text" class="form-control" id="alumno" value="<?php echo $_SESSION['usuario'] ?>" readonly="readonly"/>
                </div>
              </div>
              <div class="form-group">
                <label for="calumno" class="col-sm-2 control-label">Curso:</label>
                <div class="col-sm-5">
                  <input name="ccurso" type="text" class="form-control" id="curso" value="<?php echo $nombre ?>" readonly="readonly"/>
                </div>
              </div>
              <div class="form-group">
                <label for="calumno" class="col-sm-2 control-label">Categoria:</label>
                <div class="col-sm-5">
                  <input name="ccategoria" type="text" class="form-control" id="categoria" value="<?php echo $categoria ?>" readonly="readonly"/>
                </div>
              </div>
           
            </div><!-- /.box-body -->

              <div class="box-footer">
                <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                <button type="button" class="btn btn-primary pull-right" id="botonGuardarInscribir"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
              </div><!-- /.box-footer -->
          </form>
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