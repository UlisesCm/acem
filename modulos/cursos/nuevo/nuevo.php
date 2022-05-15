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
          <form class="form-horizontal" name="formulario" id="formulario" method="post" enctype="multipart/form-data">
            <div class="box-body">

              <div class="form-group">
                <label for="cnombre" class="col-sm-2 control-label">Nombre:</label>
                <div class="col-sm-5">
                  <span id="Vnombre">
                    <input name="nombre" type="text" class="form-control" id="cnombre" />
                    <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                  </span>
                </div>
              </div>

              <div class="form-group ">
                <label for="ccategoria" class="col-sm-2 control-label">Categoria:</label>
                <div class="col-sm-5">
                  <select id="ccategoria" name="categoria" class="form-control">
                  <option value="Almacen">Almacen</option>
                    <option value="Caja">Caja</option>
                    <option value="Compras">Compras</option>
                    <option value="Contabilidad">Contabilidad</option>
                    <option value="Ferreteria">Ferreteria</option>
                    <option value="Gerencia">Gerencia</option>
                    <option value="Informatica">Informatica</option>
                    <option value="Inventarios">Inventarios</option>
                    <option value="Logistica">Logistica</option>
                    <option value="Recursos Humanos">Recursos Humanos</option>
                    <option value="Reparto">Reparto</option>
                    <option value="Ventas">Ventas</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="cicono" class="col-sm-2 control-label">Icono:</label>
                <div class="col-sm-5">
                  <!-- <input name="icono" type="text" class="form-control" id="cicono" /> -->
                  <select name="icono" class="form-control" id="cicono">
                    <option value="fa-pencil">Lapiz</option>
                    <option value="fa-battery-full">Bateria</option>
                    <option value="fa-balance-scale">Balanza</option>
                    <option value="fa-calendar-check-o">Calendario</option>
                    <option value="fa-sticky-note">Nota</option>
                    <option value="fa-map-o">Mapa</option>
                    <option value="fa-commenting-o">Comentario</option>
                    <option value="fa-map-o">Mapa</option>
                    <option value="fa-anchor">Ancla</option>
                    <option value="fa-automobile">Carro</option>
                    <option value="fa-archive">Caja de Archivos</option>
                    <option value="fa-bar-chart">Grafica de Barras</option>
                    <option value="fa-bank">Banco</option>
                    <option value="fa-at">Arroba</option>
                    <option value="fa-bell-o">Campana</option>
                    <option value="fa-bicycle">Bicicleta</option>
                    <option value="fa-bolt">Rayo</option>
                    <option value="fa-birthday-cake">Pastel de Cumpleaños</option>
                    <option value="fa-calculator">Calculadora</option>
                    <option value="fa-camera">Camara</option>
                    <option value="fa-code">Simbolo de Codigo</option>
                    <option value="fa-cogs">Engranes</option>
                    <option value="fa-cloud">Nube</option>
                    <option value="fa-folder">Folder</option>
                    <option value="fa-feed">Señal</option>
                    <option value="fa-envelope-o">Correo</option>
                  </select>
                </div>
              </div>

              <div class="form-group ">
                <label for="ccategoria" class="col-sm-2 control-label">Descripcion:</label>
                <div class="col-sm-5">
                  <textarea class="form-control" name="descripcion" cols="80" rows="4" id="cdescripcion"></textarea>
                </div>
              </div>
              
              <div class="form-group ">
                    <label for="x" class="col-sm-2 control-label">Duración máxima:</label>
                    <div class="col-lg-6">
                    
                    	<div class="col-sm-5">
                         <label class="radio inline control-label">
                            <input id="cduracion-0" type="radio" name="tipo" value="Dias"/>
                            Dias
                         </label>
                          
                          		<input name="dias" type="text" class="form-control" id="cdias" readonly/>
                          </div>
                          
                           <div class="col-sm-5">
                         <label class="radio inline control-label">
                            <input id="cduracion-1" type="radio" name="tipo" value="Horas">
                            Horas
                         </label>
                         
                         		<input name="horas" type="text" class="form-control" id="choras" readonly ="true"/>
                         </div>
					</div>
				</div>

              <!-- LECCIONES -->
              <div class="box box-info" style="border-color:#000000">
                <!-- HEADER LECCIONES -->
                <div class="box-header ">
                  <h3 class="box-title">Lecciones</h3>
                  <input type="hidden" name="inputContadorLecciones" id="input-contador-lecciones" value="0">
                  <button type="button" class="btn btn btn-default pull-right" id="mostrarLeccion" onclick="mostrarLecciones()"> Mostrar</button>
                  <button type="button" class="btn btn btn-default pull-right" id="ocultarLeccion" onclick="ocultarLecciones()">Ocultar</button>
                  <button type="button" class="btn btn-success pull-right margen-right" id="agregar-leccion">Agregar Leccion</button>
                </div>
                <!-- Padre para clonacion --------------------------------------------------->
                <!-- Agregar Contenidos -->
                <div id="padre-lecciones">
                  <div style="display: none;">
                    <!--  -->
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
                          <button type="button" class="btn btn btn-danger pull-right boton-eliminar" onclick="borrarLeccion(0)">x</button>
                        </div>
                        <!-- text arae -->
                        <div class="form-group" id="div-contenido-textArea">
                          <label class="col-sm-2 control-label"> Contenido:</label>
                          <textarea name="contenidoTextArea" id="ccontenidoTextArea" cols="80" rows="6"></textarea>
                        </div>
                        <!-- input -->
                        <div class="form-group" id="div-contenido-input" style="display: none;">
                          <label class="col-sm-2 control-label"> Enlace:</label>
                          <div class="col-sm-4" id="div-input">
                            <input name="contenidoInput" type="text" class="form-control" id="ccontenidoInput" />
                          </div>
                        </div>
                        <!-- archivo -->
                        <div class="form-group" id="div-contenido-archivo">
                          <label for="x" class="col-sm-2 control-label">Adjuntar Recurso:</label>
                          <div class="col-sm-4 contenedor" id="div-contenido-archivo-hijo">
                            <div class="input-group col-sm-10" id="div-contenido-archivo-nieto">
                              <input type="file" class="form-control" id="inputArchivos"><!-- accept="application/pdf" -->
                              <input type="text" name="inputArchivoText" id="inputArchivoText" hidden>
                            </div>
                            <input type="button" value="Subir" id="btnEnviar" onclick="subirDocumento(0)" class="btn btn-success margen-5">
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                  <!-- PRIMEN NODO -->
                  <div class="carta-lecciones" id="nodo-padre-leccion0">
                    <div class="form-group" id="div-principal0">
                      <!-- div1 -->
                      <label class="col-sm-2 control-label"> Tipo de Leccion:</label>
                      <div class="col-sm-2" id="div-select0">
                        <select id="ctipoLeccion0" name="tipoLeccion0" class="form-control tipoLeccion" onchange="contenidoLecciones(0)">
                          <option value="texto">Texto</option>
                          <option value="enlace">Enlace</option>
                          <option value="imagen">Imagen</option>
                          <option value="video">Video</option>
                          <option value="documento">Documento</option>
                        </select>
                      </div>
                      <div id="div-button0" style="display: none;">
                        <button type="button" class="btn btn btn-danger pull-right boton-eliminar" id="borrar-leccion0" onclick="borrarLeccion(0)">x</button>
                        <!-- <a class="btn btn btn-danger pull-right boton-eliminar" id="borrar-leccion0" onclick="borrarLeccion(0)">x</a> -->
                      </div>
                      <!-- text arae -->
                      <div class="form-group" id="div-contenido-textArea0">
                        <label class="col-sm-2 control-label"> Contenido:</label>
                        <textarea name="contenidoTextArea0" id="ccontenidoTextArea0" cols="80" rows="6"></textarea>
                      </div>
                      <!-- input -->
                      <div class="form-group" id="div-contenido-input0">
                        <label class="col-sm-2 control-label"> Enlace:</label>
                        <div class="col-sm-4" id="div-input0">
                          <input name="contenidoInput0" type="text" class="form-control" id="ccontenidoInput0" />
                        </div>
                        <!-- <div class="alert alert-info" id="estado"></div> -->
                      </div>
                      <!-- archivo -->

                      <div class="form-group" id="div-contenido-archivo0">
                        <label for="x" class="col-sm-2 control-label">Adjuntar Recurso:</label>
                        <div class="col-sm-4 contenedor" id="div-contenido-archivo-hijo0">
                          <div class="input-group col-sm-10" id="div-contenido-archivo-nieto0">
                            <input type="file" class="form-control" name="inputArchivos0" id="inputArchivos0" ><!-- accept="application/pdf" accept="image/png, image/gif, image/jpeg"-->
                            <input type="text" name="inputArchivoText0" id="inputArchivoText0" hidden>
                          </div>
                          <input type="button" value="Subir" id="btnEnviar0" onclick="subirDocumento(0)" class="btn btn-success margen-5">
                        </div>
                      </div>
                      <!-- FIN ARCHIVO -->
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
                  <input type="hidden" name="inputContadorExamen" id="input-contador-examen" value="0">
                  <input type="hidden" name="inputContadorRespuestas" id="input-contador-respuesta" value="0">
                  <button type="button" class="btn btn btn-default pull-right" id="mostrarExamen" onclick="mostrarExamenes()">Mostrar </button>
                  <button type="button" class="btn btn btn-default pull-right" id="ocultarExamen" onclick="ocultarExamenes()">Ocultar </button>
                  <button type="button" class="btn btn-success pull-right margen-right" id="agregar-pregunta">Agregar Pregunta</button>
                </div>

                <div id="padre-examen">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Nombre del Examen:</label>
                    <div class="col-sm-4">
                      <input type="text" name="nombreExamen" id="nombre-examen" class="form-control">
                    </div>
                  </div>
                  <!-- ORIGINAL CLONE -->
                  <div style="display:none">
                    <div class="carta-examen" id="nodo-padre-examen">
                      <!-- div de select -->
                      <div class="form-group" id="primer-div">
                        <label class="col-sm-2 control-label"> Tipo de Pregunta:</label>
                        <div class="col-sm-2" id="div-select">
                          <select id="ctipopregunta" name="tipoPregunta" class="form-control" onchange="contenidoExamen(0)">
                            <option value="abierta">Pregunta Abierta</option>
                            <option value="multiple">Opcion Multiple</option>
                            <option value="casilla">Casilla de Verificacion</option>
                            <option value="practica">Practica</option>
                          </select>
                        </div>
                        <div id="div-button-pregunta">
                          <button type="button" class="btn btn btn-danger pull-right boton-eliminar" id="boton-borrar-pregunta" onclick="borrarPregunta(0)">x</button>
                        </div>
                        <label class="col-sm-1 control-label" id="label-cambiante">
                          <span id="label-pregunta">Pregunta:</span>
                          <span id="label-respuesta">Practica:</span>
                        </label>
                        <div class="col-sm-4" id="div-preguntaX">
                          <input class="form-control" type="text" name="inputPregunta" id="input-pregunta">
                          <textarea class="form-control" name="textareaPregunta" cols="80" rows="4" id="textarea-pregunta"></textarea>
                        </div>
                        <label class="col-sm-1 control-label">valor:</label>
                        <div class="col-sm-1" id="div-input-valor">
                          <input class="form-control" name="inputValor" type="text" id="input-valor">
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
                            <input type="checkbox" id="checkbox-respuesta" name="respuestaCheckbox">
                            <input type="radio" id="radio-respuesta" name="radioRespuesta"> Correcta
                          </div>
                          <button type="button" class="btn btn-default" id="agregar-respuesta" onclick="crearRespuesta(0)">Agregar Respuesta</button>
                          <button type="button" class="btn btn-danger" id="borrar-respuesta" onclick="borrarRespuesta(0)" style="display:none">x</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- PRIMER NODO -->
                  <div class="carta-examen" id="nodo-padre-examen0">
                    <!-- div de select -->
                    <div class="form-group" id="primer-div0">
                      <label class="col-sm-2 control-label"> Tipo de Pregunta:</label>
                      <div class="col-sm-2" id="div-select0">
                        <select id="ctipopregunta0" name="tipoPregunta0" class="form-control" onchange="contenidoExamen(0)">
                          <option value="abierta">Pregunta Abierta</option>
                          <option value="multiple">Opcion Multiple</option>
                          <option value="casilla">Casilla de Verificacion</option>
                          <option value="practica">Practica</option>
                        </select>
                      </div>
                      <label class="col-sm-1 control-label" id="label-pregunta">
                        <span id="label-pregunta0">Pregunta:</span>
                        <span id="label-respuesta0">Practica:</span>
                      </label>
                      <div class="col-sm-4" id="div-pregunta0">
                        <input class="form-control" type="text" name="inputPregunta0" id="input-pregunta0">
                        <textarea class="form-control" name="textareaPregunta0" cols="80" rows="4" id="textarea-pregunta0"></textarea>
                      </div>
                      <label class="col-sm-1 control-label">valor:</label>
                      <div class="col-sm-1" id="div-input-valor0">
                        <input class="form-control" type="text" id="input-valor0" name="inputValor0">
                      </div>
                    </div>
                    <!-- respuesta en checkbox -->
                    <div id="nodo-padre-respuesta0">
                      <div class="form-group" id="div-respuesta0">
                        <label class="col-sm-2 control-label"> Respuesta:</label>
                        <div class="col-sm-4" id="div-input-respuesta0">
                          <input class="form-control" type="text" name="inputRespuesta00" id="input-respuesta00">
                        </div>
                        <div class="checkbox col-sm-2" id="div-checkbox-respuesta0">
                          <input type="checkbox" id="checkbox-respuesta00" name="checkboxRespuesta00">
                          <input type="radio" id="radio-respuesta00" name="radioRespuesta0" value="radio00"> Correcta
                        </div>
                        <button type="button" class="btn btn-default" id="agregar-respuesta0" onclick="crearRespuesta(0),contenidoExamen(0)">Agregar Respuesta</button>
                        <button type="button" class="btn btn-danger" id="borrar-respuesta0" onclick="borrarRespuesta(0)" style="display:none">x</button>
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
  <script src="./subirArchivos/script.js" type="text/javascript"></script>
  <script type="text/javascript">
    var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombre", "none", {
      validateOn: ["blur"],
      minChars: 1
    });
  </script>


</body>

</html>