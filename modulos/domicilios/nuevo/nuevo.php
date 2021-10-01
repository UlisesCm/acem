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
    <script src="js.js"></script>
    <script src="../../../librerias/js/jquery-ui.js"></script>
    <script src="../../../librerias/js/cookies.js"></script>
    <script src="../../../librerias/js/validaciones.js"></script>
    <script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
    <script src="../../../librerias/js/Spry/SpryValidationTextarea.js" type="text/javascript"></script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgklWcfzgoPJ2RSW3t2MCuaq1pTXd0qIo"></script>
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
                <h1>Domicilio<small>Nuevo registro</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
                    <li><a href="#">Nuevo domicilio</a></li>
                </ol>
            </section>

            <?php include("../../../componentes/modalMap.php"); ?>

            <!-- Contenido principal -->
            <section class="content">

                <?php
                /////PERMISOS////////////////
                if (!isset($_SESSION['permisos']['domicilios']['guardar']) or  !isset($_SESSION['permisos']['domicilios']['acceso'])) {
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
                <div class="box box-info" style="border-color:#2ea737">
                    <div class="box-header with-border">
                        <h3 class="box-title">Formulario de registro</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" name="formulario" id="formulario" method="post">
                        <div class="box-body">

                            <blockquote style="font-size:14px;">
                                <!--<p><b>Cliente:</b> <?php if (isset($_POST['nombre'])) {
                                                            echo $_POST['nombre'];
                                                        } else {
                                                            if (isset($_GET['nombre'])) {
                                                                echo $_GET['nombre'];
                                                            } else {
                                                                echo "";
                                                            }
                                                        } ?></p>-->
                                <p><b>Nombre comercial:</b> <?php if (isset($_POST['nic'])) {
                                                                echo $_POST['nic'];
                                                            } else {
                                                                if (isset($_GET['nic'])) {
                                                                    echo $_GET['nic'];
                                                                } else {
                                                                    echo "";
                                                                }
                                                            } ?></p>
                            </blockquote>


                            <div class='form-group'>
                                <label for="cidcliente" class="col-sm-2 control-label">Cliente:</label>
                                <div class='col-sm-5'>
                                    <!--<input value="" name="idcliente" type="hidden" class="normal" id="cidcliente" style="width:50px;"/>-->
                                    <input value="<?php if (isset($_POST['idcliente'])) {
                                                        echo $_POST['idcliente'];
                                                    } else {
                                                        if (isset($_GET['idcliente'])) {
                                                            echo $_GET['idcliente'];
                                                        } else {
                                                            echo "";
                                                        }
                                                    } ?>" name="idcliente" type="hidden" class="form-control" id="cidcliente" />
                                    <input value="" name="consultaidcliente" type="hidden" class="normal" id="consultaidcliente" style="width:100px;" />
                                    <input value="<?php if (isset($_POST['nombre'])) {
                                                        echo $_POST['nombre'];
                                                    } else {
                                                        if (isset($_GET['nombre'])) {
                                                            echo $_GET['nombre'];
                                                        } else {
                                                            echo "";
                                                        }
                                                    } ?>" name="autoidcliente" type="text" class="form-control" id="autoidcliente" />
                                    <input value="" name="cotizacionespendientes" type="hidden" class="form-control" id="idcotizacionespendientes" />
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="ctipovialidad" class="col-sm-2 control-label">Tipo vialidad:</label>
                                <div class="col-sm-5">
                                    <select id="ctipovialidad" name="tipovialidad" class="form-control">
                                        <option value="CALLE">CALLE</option>
                                        <option value="AVENIDA">AVENIDA</option>
                                        <option value="BOULEVARD">BOULEVARD</option>
                                        <option value="CALZADA">CALZADA</option>
                                        <option value="LIBRAMIENTO">LIBRAMIENTO</option>
                                        <option value="PRIVADA">PRIVADA</option>
                                        <option value="ANDADOR">ANDADOR</option>
                                        <option value="CALLEJÓN">CALLEJÓN</option>
                                        <option value="KILOMETRO">KILOMETRO</option>
                                        <option value="PASEO">PASEO</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="ccalle" class="col-sm-2 control-label">Calle:</label>
                                <div class="col-sm-5">
                                    <input value="" name="calle" type="text" class="form-control" id="autocalle" />
                                </div>
                            </div>


                            <div class="form-group ">
                                <label for="cnoexterior" class="col-sm-2 control-label">No. exterior:</label>
                                <div class="col-sm-2">


                                    <input value="" name="noexterior" type="text" class="form-control" id="autonoexterior" />


                                </div>
                            </div>


                            <div class="form-group ">
                                <label for="cnointerior" class="col-sm-2 control-label">No. interior:</label>
                                <div class="col-sm-2">

                                    <input value="" name="nointerior" type="text" class="form-control" id="cnointerior" />


                                </div>
                            </div>


                            <div class="form-group ">
                                <label for="cnombrecomercial" class="col-sm-2 control-label">Nombre comercial:</label>
                                <div class="col-sm-5">


                                    <input value="" name="nombrecomercial" type="text" class="form-control" id="autonombrecomercial" />


                                </div>
                            </div>


                            <div class="form-group ">
                                <label for="ccolonia" class="col-sm-2 control-label">Colonia:</label>
                                <div class="col-sm-5">


                                    <input value="" name="colonia" type="text" class="form-control" id="autocolonia" />


                                </div>
                            </div>


                            <div class="form-group ">
                                <label for="ccp" class="col-sm-2 control-label">CP:</label>
                                <div class="col-sm-2">
                                    <span id="Vcp">
                                        <input value="" name="cp" type="text" class="form-control" id="ccp" />
                                        <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                        <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                        <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                                    </span>
                                </div>
                            </div>


                            <div class="form-group ">
                                <label for="cciudad" class="col-sm-2 control-label">Ciudad:</label>
                                <div class="col-sm-5">


                                    <input value="" name="ciudad" type="text" class="form-control" id="autociudad" />


                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="selectestado_ajax" class="col-sm-2 control-label">Estado:</label>
                                <div class="col-sm-5">
                                    <select id="estado_ajax" name="estado" class="form-control">
                                    </select>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="selectidzona_ajax" class="col-sm-2 control-label">Zona:</label>
                                <div class="col-sm-5">
                                    <select id="idzona_ajax" name="idzona" class="form-control">
                                    </select>
                                </div>
                            </div>


                            <div class="form-group ">
                                <label for="ccoordenadas" class="col-sm-2 control-label">Coordenadas:</label>
                                <div class="col-sm-3">

                                    <input value="" name="coordenadas" type="text" class="form-control" id="ccoordenadas" readonly />


                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-warning" onClick="javascript:abrirModal();"><i class="fa fa-crosshairs"></i> Localizar</a>
                                </div>
                            </div>


                            <div class="form-group ">
                                <label for="creferencia" class="col-sm-2 control-label">Referencia:</label>
                                <div class="col-sm-5">
                                    <span id="Vreferencia">
                                        <textarea name="referencia" id="creferencia" class="form-control"></textarea>
                                        <span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                        <span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                        <span class="textareaRequiredMsg">Se necesita un valor.</span>
                                    </span>
                                </div>
                            </div>


                            <div class="form-group ">
                                <label for="cobservaciones" class="col-sm-2 control-label">Observaciones:</label>
                                <div class="col-sm-5">
                                    <span id="Vobservaciones">
                                        <textarea name="observaciones" id="cobservaciones" class="form-control"></textarea>
                                        <span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                        <span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                        <span class="textareaRequiredMsg">Se necesita un valor.</span>
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
                                <label for="selectidgirocomercial_ajax" class="col-sm-2 control-label">Giro comercial:</label>
                                <div class="col-sm-5">
                                    <select id="idgirocomercial_ajax" name="idgirocomercial" class="form-control">
                                    </select>
                                </div>
                            </div>

                            <div class="form-group hide">
                                <label for="validardosis" class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-10">
                                    <label>
                                        <input id="cvalidardosis" type="checkbox" name="validardosis" value="si">
                                        Validar dosis para este domicilio
                                    </label>
                                </div>
                            </div>


                            <div class="form-group ">
                                <label for="selectidempleado_ajax" class="col-sm-2 control-label">Ejecutivo de cuenta:</label>
                                <div class="col-sm-5">
                                    <select id="idempleado_ajax" name="idempleado" class="form-control">
                                    </select>
                                </div>
                            </div>


                            <div class="form-group hide">
                                <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                                <div class="col-sm-5">

                                    <input value="activo" name="estatus" type="hidden" class="form-control" id="cestatus" />


                                </div>
                            </div>


                            <div class="form-group campo_contactos">
                                <label for="ccontactos" class="col-sm-2 control-label">Contactos:</label>
                                <div class="col-sm-5">
                                    <div style="width:100%;">
                                        <div class="row" id="contactos_ajax">
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                            <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                        </div><!-- /.box-footer -->
                    </form>
                    <div id="loading" class="overlay" style="display:none">
                        <i class="fa fa-cog fa-spin" style="color:#2ea737"></i>
                    </div>

                </div><!-- /.box -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include("../../../componentes/pie.php"); ?>
    </div><!-- ./wrapper -->
    <script type="text/javascript">
        var sprytextfield1 = new Spry.Widget.ValidationTextField("Vcp", "none", {
            validateOn: ["blur"],
            maxChars: 5,
            minChars: 5
        });
        var sprytextarea2 = new Spry.Widget.ValidationTextarea("Vreferencia", {
            maxChars: 250,
            minChars: 1
        });
        var sprytextarea3 = new Spry.Widget.ValidationTextarea("Vobservaciones", {
            maxChars: 250,
            minChars: 1
        });
    </script>

</body>

</html>