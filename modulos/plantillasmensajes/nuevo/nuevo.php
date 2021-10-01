<?php
include("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>

<head>
  <?php include("../../../componentes/cabecera.php") ?>
  <link type="text/css" rel="stylesheet" href="../../../librerias/js/editor/jquery-te-1.4.0.css">
  <link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
  <script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <script src="../../../plugins/fastclick/fastclick.min.js"></script>
  <script src="../../../dist/js/app.min.js" type="text/javascript"></script>
  <script src="js.js"></script>
  <script src="../../../librerias/js/cookies.js"></script>
  <script src="../../../librerias/js/validaciones.js"></script>
  <script type="text/javascript" src="../../../librerias/js/editor/jquery-te-1.4.0.min.js" charset="utf-8"></script>
  <script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
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
        <h1>Plantillas de Mensaje<small>Nuevo registro</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li><a href="#">Nuevo Plantilla mensaje</a></li>
        </ol>
      </section>

      <!-- Contenido principal -->
      <section class="content">

        <?php
        /////PERMISOS////////////////
        if (!isset($_SESSION['permisos']['plantillasmensajes']['guardar']) or  !isset($_SESSION['permisos']['plantillasmensajes']['acceso'])) {
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
        <div class="box box-info" style="border-color:#6a00a4">
          <div class="box-header with-border">
            <h3 class="box-title">Formulario de registro</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" name="formulario" id="formulario" method="post">
            <div class="box-body">

              <div class="form-group ">
                <label for="ctitulo" class="col-sm-2 control-label">Título de la plantilla:</label>
                <div class="col-sm-5">
                  <span id="Vtitulo">
                    <input value="" name="titulo" type="text" class="form-control" id="ctitulo" />
                    <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                    <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                  </span>
                </div>
              </div>


              <div class="form-group ">
                <label for="casunto" class="col-sm-2 control-label">Asunto del mensaje:</label>
                <div class="col-sm-5">
                  <span id="Vasunto">
                    <input value="" name="asunto" type="text" class="form-control" id="casunto" />
                    <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                    <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                  </span>
                </div>
              </div>


              <div class="form-group ">
                <label for="cmensaje" class="col-sm-2 control-label">Mensaje de la plantilla:</label>
                <div class="col-sm-5">

                  <input value="" name="mensaje" type="text" class="jqte-test" id="cmensaje" />


                </div>
              </div>

            </div><!-- /.box-body -->

            <div class="box-footer">
              <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
              <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
            </div><!-- /.box-footer -->
          </form>
          <div id="loading" class="overlay" style="display:none">
            <i class="fa fa-cog fa-spin" style="color:#6a00a4"></i>
          </div>

        </div><!-- /.box -->
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include("../../../componentes/pie.php"); ?>
  </div><!-- ./wrapper -->
  <script>
    $('.jqte-test').jqte();
    var jqteStatus = true;
    $(".status").click(function() {
      jqteStatus = jqteStatus ? false : true;
      $('.jqte-test').jqte({
        "status": jqteStatus
      })
    });
  </script>
  <script type="text/javascript">
    var sprytextfield1 = new Spry.Widget.ValidationTextField("Vtitulo", "none", {
      validateOn: ["blur"],
      maxChars: 150,
      minChars: 1
    });
    var sprytextfield2 = new Spry.Widget.ValidationTextField("Vasunto", "none", {
      validateOn: ["blur"],
      maxChars: 150,
      minChars: 1
    });
  </script>

</body>

</html>