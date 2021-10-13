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

              <div class="form-group">
                <label for="cicono" class="col-sm-2 control-label">Icono:</label>
                <div class="col-sm-5">
                  <input name="icono" type="text" class="form-control" id="cicono" />
                </div>
              </div>

              <div class="form-group ">
                <label for="ccategoria" class="col-sm-2 control-label">Descripcion:</label>
                <div class="col-sm-5">
                  <textarea class="form-control" name="descripcion" cols="80" rows="4" id="cdescripcion"></textarea>
                </div>
              </div>

              <!-- LECCIONES -->
              <div class="box box-info" style="border-color:#000000">
                <!-- HEADER LECCIONES -->
                <div class="box-header ">
                  <h3 class="box-title">Lecciones</h3>
                  <button class="btn btn btn-default pull-right" id="mostrarLeccion" onclick="mostrarLecciones()">Mostrar </button>
                  <button class="btn btn btn-default pull-right" id="ocultarLeccion" onclick="ocultarLecciones()">Ocultar </button>
                  <button class="btn btn-success pull-right margen-right" id="agregar-leccion">Agregar Leccion </button>
                </div>
                <!-- Padre para clonacion -->

                <!-- Agregar Contenidos -->
                <div id="padre-lecciones">
                  <div class="carta-lecciones" id="nodo-padre-leccion">
                    <div class="form-group" id="div-principal">
                      <!-- div1 -->
                      <label class="col-sm-2 control-label"> Tipo de Leccion:</label>
                      <div class="col-sm-2" id="div-select">
                        <select id="ctipoLeccion" name="tipoLeccion" class="form-control tipoLeccion" onchange="contenidoLecciones(0)">
                          <option value="texto">Texto</option>
                          <option value="enlace">Enlace</option>
                          <option value="imagen">Imagen</option>
                          <option value="video">Video</option>
                          <option value="documento">Documento</option>
                        </select>
                      </div>
                      <div id="div-button" style="display: none;">
                        <button class="btn btn btn-danger pull-right boton-eliminar" onclick="borrarLeccion(0)">x</button>
                      </div>
                      <!-- text arae -->
                      <div class="form-group" id="div-contenido-textArea">
                        <label class="col-sm-2 control-label"> Contenido:</label>
                        <textarea name="contenidoTextArea" id="ccontenidoTextArea" cols="80" rows="6"></textarea>
                      </div>
                      <!-- input -->
                      <div class="form-group" id="div-contenido-input">
                        <label class="col-sm-2 control-label"> Contenido:</label>
                        <div class="col-sm-4" id="div-input">
                          <input value="" name="contenidoInput" type="text" class="form-control" id="ccontenidoInput" />
                        </div>
                      </div>
                      <!-- archivo -->
                      <div class="form-group" id="div-contenido-archivo">
                        <label for="x" class="col-sm-2 control-label">Adjuntar Recurso:</label>
                        <div class="col-sm-4" id="div-contenido-archivo-hijo">
                          <div class="input-group" id="div-contenido-archivo-nieto">
                            <input type="file" name="recurso" style="display:none;" id="crecurso" accept=".pdf" onChange="fileinput('recurso')" />
                            <input type="text" name="nrecurso" id="nrecurso" class="form-control" placeholder="Seleccionar Archivo" disabled="disabled">
                            <span class="input-group-btn">
                              <a class="btn btn-warning" onclick="$('#crecurso').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


              </div>
              <!-- Final de Lecciones -->

              <!-- Examen -->
              <div class="box box-info" style="border-color:#000000" >
                <!-- HEADER EXAMEN -->
                <div class="box-header">
                  <h3 class="box-title">Examen</h3>
                  <button class="btn btn btn-default pull-right" id="mostrarExamen" onclick="mostrarExamenes()">Mostrar </button>
                  <button class="btn btn btn-default pull-right" id="ocultarExamen" onclick="ocultarExamenes()">Ocultar </button>
                  <button class="btn btn-success pull-right margen-right" id="agregar-pregunta">Agregar Pregunta</button>
                </div>
                <div id="padre-examen">
                  <!-- ORIGINAL CLONE -->
                  <div style="display:none">
                    <div class="carta-examen" id="nodo-padre-examen">
                      <!-- div de select -->
                      <div class="form-group" id="primer-divX">
                        <label class="col-sm-2 control-label"> Tipo de Pregunta:</label>
                        <div class="col-sm-2" id="div-selectX">
                          <select id="ctipopreguntaX" name="tipopreguntaX" class="form-control" onchange="contenidoExamen(0)">
                            <option value="abierta">Pregunta Abierta</option>
                            <option value="multiple">Opcion Multiple</option>
                            <option value="practica">Practica</option>
                          </select>
                        </div>
                        <div id="div-button-preguntaX">
                          <button class="btn btn btn-danger pull-right boton-eliminar" id="boton-borrar-preguntaX"onclick="borrarPregunta(0)">x</button>
                        </div>
                        <label class="col-sm-1 control-label"> Pregunta:</label>
                        <div class="col-sm-4" id="div-preguntaX">
                          <input class="form-control" type="text" name="inputPreguntaX" id="input-preguntaX">
                          <textarea class="form-control" name="textareaPregunta" cols="80" rows="4" id="textarea-preguntaX"></textarea>
                        </div>
                        <label class="col-sm-1 control-label">valor:</label>
                        <div  class="col-sm-1" id="div-input-valorX">
                          <input class="form-control" name="inputValorX" type="text" id="input-valorX">
                        </div>
                      </div>
                      <!-- respuesta en checkbox -->
                      <div id="nodo-padre-respuestaX">
                        <div class="form-group" id="div-respuestaX">
                          <label class="col-sm-2 control-label"> Respuesta:</label>
                          <div class="col-sm-4" id="div-input-respuestaX">
                            <input class="form-control" type="text" name="" id="input-respuestaX" name="inputRespuestaX">
                          </div>
                          <div class="checkbox col-sm-2" id="div-checkbox-respuestaX">
                            <input type="checkbox" id="respuesta-checkboxX" name="respuestaCheckboxX"> Correcta
                          </div>
                          <button type="button" class="btn btn-default" id="agregar-respuestaX" onclick="crearRespuesta(0)">Agregar Respuesta</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- PRIMER NODO -->
                  <div class="carta-examen" id="nodo-padre-examen0">
                    <!-- div de select -->
                    <div class="form-group" id="primer-div">
                      <label class="col-sm-2 control-label"> Tipo de Pregunta:</label>
                      <div class="col-sm-2" id="div-select">
                        <select id="ctipopregunta" name="tipopregunta" class="form-control" onchange="contenidoExamen(0)">
                          <option value="abierta">Pregunta Abierta</option>
                          <option value="multiple">Opcion Multiple</option>
                          <option value="practica">Practica</option>
                        </select>
                      </div>
                      <label class="col-sm-1 control-label"> Pregunta:</label>
                      <div class="col-sm-4" id="div-pregunta">
                        <input class="form-control" type="text" name="inputPregunta" id="input-pregunta">
                        <textarea class="form-control" name="textareaPregunta" cols="80" rows="4" id="textarea-pregunta"></textarea>
                      </div>
                      <label class="col-sm-1 control-label">valor:</label>
                      <div  class="col-sm-1" id="div-input-valor">
                        <input class="form-control" type="text" id="input-valor">
                      </div>
                    </div>
                    <!-- respuesta en checkbox -->
                    <div id="nodo-padre-respuesta">
                      <div class="form-group" id="div-respuesta">
                        <label class="col-sm-2 control-label"> Respuesta:</label>
                        <div class="col-sm-4" id="div-input-respuesta">
                          <input class="form-control" type="text" name="inputRespuesta" id="input-respuesta">
                        </div>
                        <div class="checkbox col-sm-2" id="div-checkbox-respuesta">
                          <input type="checkbox" id="checkbox-respuesta" name="checkboxRespuesta"> Correcta
                        </div>
                        <button type="button" class="btn btn-default" id="agregar-respuesta" onclick="crearRespuesta(0)">Agregar Respuesta</button>
                        <button type="button" class="btn btn-danger" id="borrar-respuesta" onclick="borrarRespuesta(0)" style="display:none">x</button>
                      </div>
                    </div>
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