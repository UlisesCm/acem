<?php
include("../../seguridad/comprobar_login.php");
include("../../../librerias/php/variasfunciones.php");
include("recuperarValores.php");
?>
<!DOCTYPE html>
<html>

<head>
  <?php include("../../../componentes/cabecera.php") ?>
  <link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
        <h1>Cursos<small>Modificar registro</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li><a href="#">Modificar cursos</a></li>
        </ol>
      </section>

      <!-- Contenido principal -->
      <section class="content">

        <?php
        /////PERMISOS////////////////
        if (!isset($_SESSION['permisos']['cursos']['modificar']) or  !isset($_SESSION['permisos']['cursos']['acceso'])) {
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
              <div class="form-group ">
                <label for="cnombre" class="col-sm-2 control-label">Nombre:</label>
                <div class="col-sm-5">
                  <span id="Vnombre">
                    <input value="<?php echo $nombre; ?>" name="nombre" type="text" class="form-control" id="cnombre" />
                    <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                  </span>
                </div>
              </div>

              <div class="form-group ">
                <label for="ccategoria" class="col-sm-2 control-label">Categoria:</label>
                <div class="col-sm-5">
                  <select id="ccategoria" name="categoria" class="form-control">
                    <option value="informatica" <?php
                                                if ($categoria == "informatica") {
                                                  echo 'selected="selected"';
                                                }
                                                ?>>informatica</option>

                    <option value="logistica" <?php
                                              if ($categoria == "logistica") {
                                                echo 'selected="selected"';
                                              }
                                              ?>>logistica</option>

                    <option value="inventarios" <?php
                                                if ($categoria == "inventarios") {
                                                  echo 'selected="selected"';
                                                }
                                                ?>>inventarios</option>

                  </select>
                </div>
              </div>
              <div class="form-group ">
                <label for="cicono" class="col-sm-2 control-label">Icono:</label>
                <div class="col-sm-5">
                  <input value="<?php echo $icono; ?>" name="icono" type="text" class="form-control" id="cicono" />
                </div>
              </div>
              <hr>
              <div>
                <h3>Lecciones:</h3>
                <?php
                $contadorLecciones=0;
                $cadenaLecciones="";
                $contadorPreguntas=0;
                $cadenaPreguntas="";
                $contadorRespuestas="";
                $cadenaRespuestas="";
                $cadenaCheckbox="";
                while ($filasLecciones = mysqli_fetch_array($resultadoLeccion)) {
                  $contadorLecciones++;
                ?>
                  <div class="form-group ">
                    <label for="cicono" class="col-sm-2 control-label">Leccion <?php echo $filasLecciones['orden']; ?>:</label>
                    <div class="col-sm-5 row">
                      <?php
                      if ($filasLecciones['orden'] == "enlace") {
                      ?><input value="<?php echo $filasLecciones['contenido'];?>" name="<?php echo $filasLecciones['idleccion'];?>" type="text" class="form-control" id="<?php echo $filasLecciones['idleccion'];?>" /><?php
                      } else {                                              
                      ?><textarea class="form-control" name="<?php echo $filasLecciones['idleccion'];?>" id="<?php echo $filasLecciones['idleccion'];?>" cols="80" rows="4" value=""><?php echo $filasLecciones['contenido']; ?></textarea><?php                                                                                                                                                        }                                                                                                                                                                                                                                    ?>
                    </div>
                  </div>
                <?php
                $cadenaLecciones=$cadenaLecciones.":::".$filasLecciones['idleccion'];
                }
                ?>
              </div>
              <hr>
              <div>
                <h3>Examen:</h3>
                <?php
                while ($filasExamen = mysqli_fetch_array($resultadoExamen)) {
                 
                ?>
                  <div class="form-group ">
                    <label for="cicono" class="col-sm-2 control-label">Nombre del Examen:</label>
                    <div class="col-sm-5 row">
                      <input value="<?php echo $filasExamen['nombreExamen']; ?>" name="nombreExamen" type="text" class="form-control" id="nombreExamen" />
                    </div>
                  </div>
                <?php
                $idexamen = $filasExamen['idexamen'];
                }
                ?>
              </div>
              <hr>
              <div>
                <h3>Preguntas:</h3>
                <?php
                while ($filasPreguntas = mysqli_fetch_array($resultadoPreguntas)) {
                  $contadorPreguntas++;
                  
                ?>
                  <div class="form-group ">
                    <label for="cicono" class="col-sm-2 control-label">Pregunta:</label>
                    <div class="row">
                      <div class="col-sm-4">
                        <input value="<?php echo $filasPreguntas['pregunta']; ?>" name="<?php echo $filasPreguntas['idpregunta']; ?>" type="text" class="form-control" id="<?php echo $filasPreguntas['idpregunta'];?>" />
                      </div>
                      <div class="col-sm-1">
                        <input value="Tipo: <?php echo $filasPreguntas['tipopregunta']; ?>" name="icono" type="text" class="form-control" id="cicono" disabled />
                      </div>
                    </div>

                  </div>
                  <?php
                  if (($filasPreguntas['tipopregunta'] == "multiple") || ($filasPreguntas['tipopregunta'] == "casilla")) {
                    $resultadoRespuestas=$Ocursos->mostrarRespuestas($filasPreguntas['idpregunta']);
                    while ($filasRespuestas= mysqli_fetch_array($resultadoRespuestas)) {
                      $contadorRespuestas++;
                      ?>
                      <div class="form-group">
                        <label for="cicono" class="col-sm-2 control-label">Respuesta:</label>
                        <div class="row">
                          <div class="col-sm-3">
                            <input value="<?php echo $filasRespuestas['respuesta']; ?>" name="<?php echo $filasRespuestas['idrespuesta']; ?>" type="text" class="form-control" id="1" />
                          </div>
                          <div class="col-sm-2 row">
                            <label for="cicono" class="control-label">Correcto:</label>
                            <?php 
                            if ($filasPreguntas['tipopregunta'] == "casilla") {
                              $cadenaCheckbox = $cadenaCheckbox.":::s".$filasRespuestas['idrespuesta'];
                              ?><input type="checkbox" name="<?php echo "s".$filasRespuestas['idrespuesta']; ?>" value="<?php echo $filasRespuestas['idrespuesta']; ?>" id="" <?php echo ($filasRespuestas['correcto'] == "on") ? 'checked': ''?>><?php //se utiliza un operador ternario para validar si se pre-selecciona o no
                            } else {
                              $cadenaCheckbox = $cadenaCheckbox.":::s".$filasPreguntas['idpregunta'];
                              ?><input type="radio" name="<?php echo "s".$filasPreguntas['idpregunta']; ?>" value="<?php echo $filasRespuestas['idrespuesta']; ?>" id="" <?php echo ($filasRespuestas['correcto'] == "on") ? 'checked': ''?>><?php //se utiliza un operador ternario para validar si se pre-selecciona o no
                            }
                            ?>                          
                          </div>
                        </div>
                      </div>
                    <?php
                    $cadenaRespuestas = $cadenaRespuestas.":::".$filasRespuestas['idrespuesta'];
                    }
                  }
                  $cadenaPreguntas = $cadenaPreguntas.":::".$filasPreguntas['idpregunta'];
                  ?>
                
                <?php
                }
                ?>
              </div>
                <input type="hidden" name="contadorLecciones" id="contadorLecciones" value="<?php echo $contadorLecciones?>">
                <input type="hidden" name="cadenaLecciones" id="cadenaLecciones" value="<?php echo $cadenaLecciones?>">
                <input type="hidden" name="contadorPreguntas" id="contadorPreguntas" value="<?php echo $contadorPreguntas?>">
                <input type="hidden" name="cadenaPreguntas" id="cadenaPreguntas" value="<?php echo $cadenaPreguntas?>">
                <input type="hidden" name="contadorRespuestas" id="contadorRespuestas" value="<?php echo $contadorRespuestas?>">
                <input type="hidden" name="cadenaRespuestas" id="cadenaRespuestas" value="<?php echo $cadenaRespuestas?>">
                <input type="hidden" name="cadenaCheckbox" id="cadenaCheckbox" value="<?php echo $cadenaCheckbox?>">
                <input type="hidden" name="idexamen" id="idexamen" value="<?php echo $idexamen?>">
            </div><!-- /.box-body -->

            <div class="box-footer">
              <input name="idcurso" type="hidden" id="cidcurso" value="<?php echo $id; ?>" />
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
    var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombre", "none", {
      validateOn: ["blur"],
      minChars: 1
    });
  </script>
</body>

</html>