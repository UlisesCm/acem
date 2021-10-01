<?php
include("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>

<head>





  <?php include("../../../componentes/cabecera.php") ?>
  <link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
  <link href="../../../librerias/js/Spry/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" />
  <script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <script src="../../../plugins/fastclick/fastclick.min.js"></script>
  <script src="../../../dist/js/app.min.js" type="text/javascript"></script>
  <script src="../../../librerias/js/jquery-ui.js"></script> <!-- autocompletar libreria -->
  <script src="js.js"></script>
  <script src="../../../librerias/js/cookies.js"></script>
  <script src="../../../librerias/js/validaciones.js"></script>
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
        <h1>Usuario<small>Nuevo registro</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li><a href="#">Nuevo usuario</a></li>
        </ol>
      </section>

      <!-- Contenido principal -->
      <section class="content">

        <?php
        /////PERMISOS////////////////
        if (!isset($_SESSION['permisos']['usuarios']['guardar']) or  !isset($_SESSION['permisos']['usuarios']['acceso'])) {
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
        <div class="box box-info" style="border-color:#1c81f0">
          <div class="box-header with-border">
            <h3 class="box-title">Formulario de registro</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" name="formulario" id="formulario" method="post" enctype="multipart/form-data">
            <div class="box-body">

              <div class="form-group ">
                <label for="cnombre" class="col-sm-2 control-label">Nombre completo:</label>
                <div class="col-sm-5">
                  <span id="Vnombre">
                    <input value="" name="nombre" type="text" class="form-control" id="cnombre" />
                    <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                    <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                  </span>
                </div>
              </div>

              <div class="form-group ">
                <label for="selectidsucursal_ajax" class="col-sm-2 control-label">Sucursal:</label>
                <div class="col-sm-5">
                  <select id="idsucursal_ajax" name="idsucursal" class="form-control">
                  </select>
                </div>
              </div>


              <div class="form-group ">
                <label for="cemail" class="col-sm-2 control-label">Correo electrónico:</label>
                <div class="col-sm-5">
                  <span id="Vemail">
                    <input value="" name="email" type="text" class="form-control" id="cemail" />
                    <span class="textfieldInvalidFormatMsg">Formato no válido.</span>
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                  </span>
                </div>
              </div>

              <div class="form-group ">
                <label for="x" class="col-sm-2 control-label">Fotografía:</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <input type="file" name="foto" style="display:none;" id="cfoto" accept=".jpg" onChange="fileinput('foto')" />
                    <input type="text" name="nfoto" id="nfoto" class="form-control" placeholder="Seleccionar Imagen" disabled="disabled">
                    <span class="input-group-btn">
                      <a class="btn btn-success" onclick="$('#cfoto').click();">&nbsp;&nbsp;&nbsp;Seleccionar Imagen</a>
                    </span>
                  </div>
                </div>
              </div>


              <div class="form-group ">
                <label for="cusuario" class="col-sm-2 control-label">Usuario:</label>
                <div class="col-sm-3">
                  <span id="Vusuario">
                    <input value="" name="usuario" type="text" class="form-control" id="cusuario" />
                    <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                    <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                  </span>
                </div>
              </div>


              <div class="form-group ">
                <label for="ccontrasena" class="col-sm-2 control-label">Contraseña:</label>
                <div class="col-sm-3">
                  <span id="Vcontrasena">
                    <input value="" name="contrasena" type="password" class="form-control" id="ccontrasena" />
                    <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                    <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                  </span>
                </div>
              </div>


              <div class="form-group hide">
                <label for="cestado" class="col-sm-2 control-label"></label>
                <div class="col-sm-5">

                  <input value="activo" name="estado" type="hidden" class="form-control" id="cestado" />


                </div>
              </div>

              <div class="form-group ">
                <label for="selectidperfil_ajax" class="col-sm-2 control-label">Perfil de permisos:</label>
                <div class="col-sm-5">
                  <select id="idperfil_ajax" name="idperfil" class="form-control">
                  </select>
                </div>
              </div>


              <div class="form-group hide">
                <label for="cempresa" class="col-sm-2 control-label"></label>
                <div class="col-sm-5">

                  <input value="<?php echo $_SESSION['empresa'] ?>" name="empresa" type="hidden" class="form-control" id="cempresa" />


                </div>
              </div>

              <div class="form-group ">
                <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                <div class="col-sm-10">
                  <label>
                    <input id="ccontrolaracceso" type="checkbox" name="controlaracceso" value="si">
                    Controlar acceso por horario
                  </label>
                </div>
              </div>

              <div class="form-group ">
                <label for="chorainicio" class="col-sm-2 control-label">Hora de inicio:</label>
                <div class="col-sm-2">

                  <input value="<?php echo date('H:i'); ?>" name="horainicio" type="time" required class="form-control" id="chorainicio" />


                </div>
              </div>


              <div class="form-group ">
                <label for="chorafin" class="col-sm-2 control-label">Hora de fin:</label>
                <div class="col-sm-2">

                  <input value="<?php echo date('H:i'); ?>" name="horafin" type="time" required class="form-control" id="chorafin" />


                </div>
              </div>


              <div class="form-group ">
                <label for="x" class="col-sm-2 control-label"><span data-placement="bottom" data-toggle="tooltip" data-html="true" title="" data-original-title="
               <b>Previamente se debe dar de alta un técnico, empleado o cliente en su respectivo catalogo para crear un usuario.</b>"><i class="fa fa-question-circle text-blue ayuda"></i></span> Relacionar con:</label>
                <div class="col-lg-10">
                  <label class="radio inline control-label">
                    <input id="tipo" type="radio" class="tipo" name="tipo" value="Empleado">Empleado</label>
                  <label class="radio inline control-label">
                    <input id="tipo" type="radio" class="tipo" name="tipo" value="Cliente">Cliente</label>
                </div>
              </div>

              <div style="display:none;" class="form-group" id="Empleado">
                <label for="cidempleado" class="col-sm-2 control-label">Empleado:</label>
                <div class="col-sm-5">
                  <input value="" name="idempleado" type="hidden" class="normal" id="cidempleado" style="width:50px;" />
                  <input value="" name="consultaidempleado" type="hidden" class="normal" id="consultaidempleado" style="width:100px;" />
                  <input value="" name="autoidempleado" type="text" class="form-control" id="autoidempleado" />
                </div>
              </div>


              <!-- <div style="display:none;" class="form-group" id="Tecnico">
                <label for="cidtecnico" class="col-sm-2 control-label">Técnico:</label>
                <div class="col-sm-5">
                  <input value="" name="idtecnico" type="hidden" class="normal" id="cidtecnico" style="width:50px;" />
                  <input value="" name="consultaidtecnico" type="hidden" class="normal" id="consultaidtecnico" style="width:100px;" />
                  <input value="" name="autoidtecnico" type="text" class="form-control" id="autoidtecnico" />
                </div>
              </div> -->


              <div style="display:none;" class="form-group" id="Cliente">
                <label for="cidcliente" class="col-sm-2 control-label">Cliente:</label>
                <div class="col-sm-5">
                  <input value="" name="idcliente" type="hidden" class="normal" id="cidcliente" style="width:50px;" />
                  <input value="" name="consultaidcliente" type="hidden" class="normal" id="consultaidcliente" style="width:100px;" />
                  <input value="" name="autoidcliente" type="text" class="form-control" id="autoidcliente" />
                </div>
              </div>


              <div class="form-group ">
                <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                <div class="col-sm-10">
                  <label>
                    <input id="cbitacora" type="checkbox" name="bitacora" value="si">
                    Registrar en bitácora las acciones del usuario
                  </label>
                </div>
              </div>
            </div><!-- /.box-body -->

            <div class="box-footer">
              <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
              <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
            </div><!-- /.box-footer -->
          </form>
          <div id="loading" class="overlay" style="display:none">
            <i class="fa fa-cog fa-spin" style="color:#1c81f0"></i>
          </div>

        </div><!-- /.box -->
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include("../../../componentes/pie.php"); ?>
  </div><!-- ./wrapper -->
  <script type="text/javascript">
    var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombre", "none", {
      validateOn: ["blur"],
      maxChars: 100,
      minChars: 2
    });

    var sprytextfield2 = new Spry.Widget.ValidationTextField("Vemail", "email", {
      validateOn: ["blur"]
    });
    var sprytextfield3 = new Spry.Widget.ValidationTextField("Vusuario", "none", {
      validateOn: ["blur"],
      maxChars: 15,
      minChars: 2
    });
    var sprytextfield4 = new Spry.Widget.ValidationTextField("Vcontrasena", "none", {
      validateOn: ["blur"],
      maxChars: 12,
      minChars: 6
    });
  </script>

</body>

</html>