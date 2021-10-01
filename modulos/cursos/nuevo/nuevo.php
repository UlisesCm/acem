<?php
include("../../seguridad/comprobar_login.php");
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
        <div class="box box-info" style="border-color:#000000">
          <div class="box-header with-border">
            <h3 class="box-title">Formulario de registro</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" name="formulario" id="formulario" method="post">
            <div class="box-body">

              <div class="form-group">
                <label for="cnombre" class="col-sm-2 control-label">Nombre:</label>
                <div class="col-sm-5">
                  <span id="Vnombre">
                    <input value="" name="nombre" type="text" class="form-control" id="cnombre" />

                    <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                  </span>
                </div>
              </div>

              <div class="form-group ">
                <label for="ccategoria" class="col-sm-2 control-label">Categoria:</label>
                <div class="col-sm-5">
                  <select id="ccategoria" name="categoria" class="form-control">
                    <option value="informatica">informatica</option>
                    <option value="logistica">logistica</option>
                    <option value="inventarios">inventarios</option>
                  </select>
                </div>
              </div>

              <div class="form-group ">
                <label for="cicono" class="col-sm-2 control-label">Icono:</label>
                <div class="col-sm-5">
                  <input value="" name="icono" type="text" class="form-control" id="cicono" />
                </div>
              </div>

              <div class="form-group ">
                <label for="ccategoria" class="col-sm-2 control-label">Descripcion:</label>
                <div class="col-sm-5">
                  <textarea class="form-control" name="descripcion" cols="80" rows="4" id="cdescripcion"></textarea>
                </div>
              </div>

              <!-- LECCIONES -->
              <div class="box box-info" style="border-color:#000000" id="padre-lecciones">
                <!-- HEADER LECCIONES -->
                <div class="box-header ">
                  <h3 class="box-title">Lecciones</h3>
                  <button class="btn btn-success pull-right" id="agregar-leccion">Agregar Leccion </button>
                </div>


                <!-- Agregar Contenidos -->
                <div class="carta-lecciones" id="nodo-padre">
                  <div class="form-group" > <!-- div1 -->
                    <label class="col-sm-2 control-label"> Tipo de Leccion:</label>
                    <div class="col-sm-2">
                      <select id="ctipoLeccion" name="tipoLeccion" class="form-control">
                        <option value="texto">Texto</option>
                        <option value="enlace">Enlace</option>
                        <option value="imagen">Imagen</option>
                        <option value="video">Video</option>
                        <option value="documento">Documento</option>
                      </select>
                    </div>
                    <!-- text arae -->
                    <div class="form-group" id="contenidoTextArea">
                      <label class="col-sm-2 control-label"> Contenido:</label>
                      <textarea name="" id="" cols="80" rows="6"></textarea>
                    </div>
                    <!-- input -->
                    <div class="form-group" id="contenidoInput">
                      <label class="col-sm-2 control-label"> Contenido:</label>
                      <div class="col-sm-4">
                        <input value="" name="icono" type="text" class="form-control" id="cicono" />
                      </div>
                    </div>
                    <!-- archivo -->
                    <div class="form-group" id="contenidoArchivo">
                      <label for="x" class="col-sm-2 control-label">Adjuntar Recurso:</label>
                      <div class="col-sm-4">
                        <div class="input-group">
                          <input type="file" name="factura" style="display:none;" id="cfactura" accept=".pdf" onChange="fileinput('factura')" />
                          <input type="text" name="nfactura" id="nfactura" class="form-control" placeholder="Seleccionar Archivo" disabled="disabled">
                          <span class="input-group-btn">
                            <a class="btn btn-warning" onclick="$('#cfactura').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Final de Lecciones -->

              <!-- Examen -->
              <div class="box box-info" style="border-color:#000000">
                <!-- HEADER EXAMEN -->
                <div class="box-header">
                  <h3 class="box-title">Examen</h3>
                  <button class="btn btn-success pull-right">Agregar Pregunta</button>

                </div>


                <!-- Agregar Preguntas -->
                <div class="carta-examen">
                  <div class="form-group">
                    <label class="col-sm-2 control-label"> Tipo de Pregunta:</label>
                    <div class="col-sm-2">
                      <select id="ctipopregunta" name="categoria" class="form-control">
                        <option value="abierta">Pregunta Abierta</option>
                        <option value="multiple">Opcion Multiple</option>
                        <option value="practica">Practica</option>
                      </select>
                    </div>
                    <label class="col-sm-2 control-label"> Pregunta:</label>
                    <div class="col-sm-4" >
                      <input class="form-control" type="text" name="" id="input-pregunta">
                      <textarea class="form-control" name="descripcion" cols="80" rows="4" id="textarea-pregunta"></textarea>
                    </div>
                  </div>

                  <div class="form-group" id="respuesta-checkbox">
                    <label class="col-sm-2 control-label"> Respuesta:</label>
                    <div class="col-sm-4">
                      <input class="form-control" type="text" name="" id="">
                    </div>
                    <div class="checkbox col-sm-2">
                      <label>
                        <input type="checkbox"> Correcta
                      </label>
                    </div>
                    <button type="button" class="btn btn-default">Agregar Respuesta</button>
                  </div>

                </div>




              </div>
              <!-- Final Examen -->
            </div><!-- /.box-body -->

            <div class="box-footer">
              <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
              <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
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