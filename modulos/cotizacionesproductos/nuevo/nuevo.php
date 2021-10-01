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
    <script>
        var estiloDescripcion = "style='padding-bottom:3pt;'";
    </script>
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
                <h1>Venta de productos<small>Nuevo registro</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
                    <li><a href="#">Nueva venta de productos</a></li>
                </ol>
            </section>
            <?php include("../componentes/modal.php"); ?>
            <?php include("../../../componentes/modalMap.php"); ?>
            <!-- Contenido principal -->
            <section class="content">

                <?php
                /////PERMISOS////////////////
                if (!isset($_SESSION['permisos']['cotizacionesproductos']['guardar']) or  !isset($_SESSION['permisos']['cotizacionesproductos']['acceso'])) {
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
                <div class="box box-info" style="border-color:#649ad0">
                    <div class="box-header with-border">
                        <h3 class="box-title">Formulario de registro</h3>
                        <label class="label pull-right bg-red" style="margin-left:10px;">Folio: <span id="lserie"> </span>-<span id="lfolio"></span></label>
                        <label class="label pull-right bg-yellow">Fecha: <?php echo date('Y-m-d'); ?></label>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" name="formulario" id="formulario" method="post">
                        <div class="box-body">

                            <div class="form-group hide">
                                <label for="cserie" class="col-sm-2 control-label">Serie:</label>
                                <div class="col-sm-2">
                                    <span id="Vserie">
                                        <input value="" name="serie" type="text" class="form-control" id="cserie" />
                                        <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                        <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                        <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                                    </span>
                                </div>
                            </div>


                            <div class="form-group hide">
                                <label for="cfolio" class="col-sm-2 control-label">Folio:</label>
                                <div class="col-sm-2">
                                    <span id="Vfolio">
                                        <input value="" name="folio" type="text" class="form-control" id="cfolio" />
                                        <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                        <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                        <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                                    </span>
                                </div>
                            </div>


                            <div class="form-group hide">
                                <label for="cfecha" class="col-sm-2 control-label">Fecha:</label>
                                <div class="col-sm-3">

                                    <input value="<?php echo date('Y-m-d'); ?>" name="fecha" type="date" required class="form-control" id="cfecha" />


                                </div>
                            </div>


                            <div class="form-group hide">
                                <label for="chora" class="col-sm-2 control-label">Hora:</label>
                                <div class="col-sm-3">

                                    <input value="<?php echo date('H:i'); ?>" name="hora" type="time" required class="form-control" id="chora" />


                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Horizontal Form -->
                                    <div class="box box-info" style="border-color:#0B6121">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Datos principales</h3>
                                        </div><!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">

                                            <div class='col-sm-4'>
                                                <div class='form-group'>
                                                    <label for="cidcliente">Cliente</label>
                                                    <input value="" name="idcliente" type="hidden" class="normal" id="cidcliente" style="width:50px;" />
                                                    <input value="" name="consultaidcliente" type="hidden" class="normal" id="consultaidcliente" style="width:100px;" />
                                                    <input value="" name="autoidcliente" type="text" class="form-control" id="autoidcliente" />
                                                    <input value="" name="cotizacionespendientes" type="hidden" class="form-control" id="idcotizacionespendientes" />
                                                </div>
                                            </div>

                                            <div class='col-sm-2'>
                                                <div class='form-group'>
                                                    <label for="telefono">Teléfono</label>
                                                    <input value="" name="telefono" type="text" class="form-control" id="telefono" />
                                                </div>
                                            </div>

                                            <div class='col-sm-2'>
                                                <div class='form-group'>
                                                    <label for="cfecha">Fecha</label>
                                                    <input value="<?php echo date('Y-m-d'); ?>" name="fecha" type="date" required class="form-control" id="cfecha" />
                                                </div>
                                            </div>

                                            <div class='col-sm-2'>
                                                <div class='form-group'>
                                                    <label for="chora">Hora</label>
                                                    <input value="<?php echo date('H:i'); ?>" name="hora" type="time" required class="form-control" id="chora" />
                                                </div>
                                            </div>

                                            <div class='col-sm-2'>
                                                <div class='form-group'>
                                                    <label for="idempleado_ajax">Vendedor</label>
                                                    <select id="idempleado_ajax" name="idempleado" class="form-control">
                                                    </select>
                                                </div>
                                            </div>





                                        </div><!-- /.box-body -->

                                    </div><!-- /.box -->
                                </div><!-- /.end .col-4 -->
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class='col-sm-4'>
                                        <div class='form-group'>
                                            <button type="button" style="display: none;" class="btn btn-danger pull-left" id="botonMostrar"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Mostrar cotizaciones pendientes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Horizontal Form -->
                                    <div class="box box-info" style="border-color:#0c63ba">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Lista de productos</h3>
                                            <div style="display:none">(TICKET: <span class="numticket"></span>)</div>

                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;">



                                                <div class="row filaEspecial">
                                                    <div class="col-md-12">

                                                        <div class='col-sm-2'>
                                                            <div class='form-group'>
                                                                <label for="cantidad">Cantidad</label>
                                                                <input value="" name="cantidad" type="text" class="form-control" id="cantidad" />
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-10">
                                                            <div class="form-group ">
                                                                <label for="cnombreproducto" id="etiquetaProducto">Producto</label>
                                                                <div class="input-group">
                                                                    <input value="" name="idproducto" type="hidden" class="normal" id="cidproducto" />
                                                                    <input value="" name="codigoproducto" type="hidden" class="normal" id="ccodigoproducto" />
                                                                    <input value="" name="nnombreproducto" type="hidden" class="normal" id="nnombreproducto" />
                                                                    <input value="" name="consultaidproducto" type="hidden" class="normal" id="consultaidproducto" style="width:100px;" />
                                                                    <input value="" name="autoidproducto" type="text" class="form-control" id="autoidproducto" />
                                                                    <span class="input-group-btn">
                                                                        <a class="btn btn-default" id="botonCatalogo"><i class="fa fa-cubes"></i>&nbsp;&nbsp;&nbsp;Catálogo</a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>




                                                <div class='col-sm-2 hidden'>
                                                    <div class='form-group'>
                                                        <label for="ncantidad">Unidad</label>
                                                        <input value="" name="nunidad" type="text" class="form-control" id="nunidad" disabled />
                                                    </div>
                                                </div>
                                                <div class='col-sm-2'>
                                                    <div class='form-group hidden'>
                                                        <label for="ncantidad">Cantidad</label>
                                                        <input value="1" name="ncantidad" type="text" class="form-control" id="ncantidad" />
                                                    </div>
                                                </div>

                                                <?php
                                                $habilitarpreciotext = "";
                                                $habilitarprecioselect = "";
                                                if (!isset($_SESSION['permisos']['ventas']['modificarprecio'])) {
                                                    $habilitarpreciotext = "hide";
                                                    $habilitarprecioselect = "";
                                                } else {
                                                    $habilitarpreciotext = "";
                                                    $habilitarprecioselect = "hide";
                                                }
                                                ?>

                                                <div class='col-sm-2 <?php echo $habilitarpreciotext ?> hidden'>
                                                    <div class='form-group'>
                                                        <label for="ncosto">Precio</label>
                                                        <input value="" name="nprecio" type="text" class="form-control" id="nprecio" onBlur="checarImpuestos();" onkeypress="return soloNumeros(event,'nprecio');" />
                                                        <input value="" name="nprecio1" type="text" class="form-control" id="nprecio1" />
                                                        <input value="" name="nprecio3" type="text" class="form-control" id="nprecio2" />
                                                        <input value="" name="nprecio3" type="text" class="form-control" id="nprecio3" />
                                                        <input value="" name="nprecio4" type="text" class="form-control" id="nprecio4" />

                                                    </div>
                                                </div>

                                                <div class='col-sm-2 <?php echo $habilitarprecioselect ?> hidden'>
                                                    <div class="form-group">
                                                        <label for="cprecios_ajax">Precio:</label>

                                                        <select id="cprecios_ajax" name="cprecios" class="form-control">
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class='col-sm-2 hide'>
                                                    <div class='form-group'>
                                                        <label for="niva">IVA</label>
                                                        <input value="1" name="niva" type="text" class="form-control" id="niva" />
                                                    </div>
                                                </div>
                                                <div class='col-sm-2 hide'>
                                                    <div class='form-group'>
                                                        <label for="ntasaiva">TASA IVA</label>
                                                        <input value="1" name="ntasaiva" type="text" class="form-control" id="ntasaiva" />
                                                    </div>
                                                </div>
                                                <div class='col-sm-2 hide'>
                                                    <div class='form-group'>
                                                        <label for="nieps">IEPS</label>
                                                        <input value="1" name="nieps" type="text" class="form-control" id="nieps" />
                                                    </div>
                                                </div>
                                                <div class='col-sm-2 hide'>
                                                    <div class='form-group'>
                                                        <label for="ntasaieps">TASA IEPS</label>
                                                        <input value="1" name="ntasaieps" type="text" class="form-control" id="ntasaieps" />
                                                    </div>
                                                </div>



                                                <div class='col-sm-12'>
                                                    <span style="font-size:16px;" class="label label-primary" id="nombreProducto"></span>
                                                </div>
                                            </div> <!-- Fin row -->


                                            <!-- Fin Agregar a tabla -->
                                            <div class="box-body table-responsive no-padding">
                                                <table id="tablaSalida" class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr style="background:#F3F3F3; color:#666; height:30px; border:1px" align="center">
                                                            <td width="80" style="display:none">No.</td>
                                                            <td width="80" style="display:none">ID</td>
                                                            <td width="60">Clave</td>
                                                            <td width="200">Producto</td>
                                                            <td width="60">Cantidad</td>
                                                            <td width="300">
                                                                <div class="row">
                                                                    <?php include("../componentes/llenarCabecerasPrecios.php"); ?>
                                                                </div>
                                                            </td>
                                                            <td width="60">Precio Unitario</td>
                                                            <td width="60">Importe Neto</td>
                                                            <td width="30" align="center"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="filas" style="background:#FFF; border:1px #666 solid;" align="center">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Fina Tabla -->
                                        </div><!-- /.box-body -->
                                        <div class="box-footer">
                                            <div class="row filaEspecial">
                                                <div class="col-md-12">

                                                    <div class='col-sm-4'>
                                                        <div class='form-group'>
                                                            <label for="peso">Peso en KG</label>
                                                            <input value="" name="peso" type="text" class="form-control" id="peso" />
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-8">
                                                        <div class="form-group ">
                                                            <span id="Vobservaciones">
                                                                <label for="observaciones">Observaciones</label>
                                                                <input name="observaciones" id="cobservaciones" class="form-control"></textarea>
                                                                <span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                                                <span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                                                <span class="textareaRequiredMsg">Se necesita un valor.</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div><!-- /.box-footer -->


                                        <div id="loading" class="overlay" style="display:none">
                                            <i class="fa fa-cog fa-spin" style="color:#0c63ba"></i>
                                        </div>
                                    </div><!-- /.box -->
                                </div><!-- /.end .col -->
                            </div><!-- /.end .row -->



                            <input value="" name="listaSalida" type="hidden" class="form-control" id="listaSalida" />











                            <!--OTROS -->
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Horizontal Form -->
                                    <div id="panelOtros" class="box box-info collapsed-box" style="border-color:#0c63ba">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Otros servicios</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" id="botonOtros" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div><!-- /.box-header -->
                                        <!-- Agregar a tabla -->
                                        <div class="box-body">
                                            <div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;">
                                                <div class='col-sm-12'>
                                                    <div class='form-group'>
                                                        <label class="label pull-right bg-red" style="margin-left:10px;">Folio: <span id="lserieotros"> </span>-<span id="lfoliootros"></span></label>
                                                        <label class="label pull-right bg-yellow">Fecha: <?php echo date('Y-m-d'); ?></label>
                                                    </div>
                                                </div> <!-- Fin row -->
                                            </div>

                                            <!-- Fin Agregar a tabla -->
                                            <div class="box-body">
                                                <div class="box-body table-responsive no-padding">
                                                    <!-- form start -->
                                                    <!--<form class="form-horizontal" name="formulariootros" id="formulariootros" method="post">-->
                                                    <div class="box-body">

                                                        <div class="form-group hide">
                                                            <label for="cfechaotros" class="col-sm-2 control-label">Fecha:</label>
                                                            <div class="col-sm-3">

                                                                <input value="<?php echo date('Y-m-d'); ?>" name="fechaotros" type="date" required class="form-control" id="cfechaotros" />


                                                            </div>
                                                        </div>


                                                        <div class="form-group hide">
                                                            <input value="" name="serieotros" type="text" class="form-control" id="cserieotros" />
                                                        </div>
                                                        <div class="form-group hide">
                                                            <input value="" name="foliootros" type="text" class="form-control" id="cfoliootros" />
                                                        </div>

                                                        <div class="form-group ">
                                                            <div class="col-sm-12">
                                                                <button type="button" class="btn btn-default pull-right" id="botonAgregar" onclick="agregarFilaOtros();">Agregar Fila</button>
                                                            </div>
                                                        </div>


                                                        <div class="form-group hide">
                                                            <label for="ctipootros" class="col-sm-2 control-label">Tipo Otros:</label>
                                                            <div class="col-sm-3">
                                                                <span id="Vtipootros">
                                                                    <input value="DIRECTA" name="tipootros" type="text" class="form-control" id="ctipootros" />
                                                                    <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                                                    <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                                                    <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                                                                </span>
                                                            </div>
                                                        </div>


                                                        <div class="box-body table-responsive no-padding oCorrectivo">
                                                            <!-- /.box-body -->
                                                            <table id="TablaServicios" class="table table-hover table-bordered">
                                                                <thead>
                                                                    <tr style="background:#F3F3F3; color:#666; height:30px; border:1px" align="left">
                                                                        <th style="display:none;">ID</th>
                                                                        <th>Fecha</th>
                                                                        <th>Cantidad</th>
                                                                        <th>Descripción</th>
                                                                        <th>Unidad</th>
                                                                        <th>Precio Unitario</th>
                                                                        <th>Importe</th>
                                                                        <th>Importe NETO</th>
                                                                        <th style="display:none;">Impuestos</th>
                                                                        <th width="30" align="center"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="filasotros">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>


                                                        <div class="row filaEspecial">
                                                            <div class="col-sm-3">
                                                                <div class="form-group ">
                                                                    <label for="csubtotalotros">Subtotal:</label>
                                                                    <input value="" name="subtotalotros" type="text" readonly class="form-control" id="csubtotalotros" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group ">
                                                                    <label for="idmodeloimpuestos_ajax">Modelo impuestos:</label>
                                                                    <select id="idmodeloimpuestos_ajax" name="idmodeloimpuestosotros" class="form-control">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group ">
                                                                    <label for="cimpuestosotros">Impuestos:</label>
                                                                    <input value="" name="impuestosotros" type="text" readonly class="form-control" id="cimpuestosotros" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group ">
                                                                    <label for="cmontootros">Total:</label>
                                                                    <input value="" name="montootros" type="text" readonly class="form-control" id="cmontootros" />
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group hide">
                                                            <label for="cidsucursal" class="col-sm-2 control-label">idsucursal:</label>
                                                            <div class="col-sm-2">
                                                                <input value="<?php echo $_SESSION['idsucursal'] ?>" name="idsucursal" type="text" class="form-control" id="cidsucursal" />
                                                            </div>
                                                        </div>


                                                        <div class="row filaEspecial">
                                                            <div class="col-sm-12">
                                                                <div class="form-group ">
                                                                    <label for="cobservacionesotros">Observaciones:</label>
                                                                    <span id="Vobservaciones">
                                                                        <input value="" name="observacionesotros" type="text" class="form-control" id="cobservacionesotros" />
                                                                        <span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                                                        <span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                                                        <span class="textareaRequiredMsg">Se necesita un valor.</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group hide">
                                                            <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                                                            <div class="col-sm-5">
                                                                <span id="Vestatus">
                                                                    <input value="activo" name="estatusotros" type="hidden" class="form-control" id="cestatus" />
                                                                    <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                                                    <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                                                    <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <input value="" name="listaSalidaOtros" type="hidden" class="form-control" id="listaSalidaOtros" />
                                                    </div><!-- /.box-body -->
                                                    <!--</form>-->
                                                </div>
                                                <!-- Fina Tabla -->
                                            </div><!-- /.box-body -->
                                            <div class="box-footer">
                                            </div><!-- /.box-footer -->
                                            <div id="loading" class="overlay" style="display:none">
                                                <i class="fa fa-cog fa-spin" style="color:#0c63ba"></i>
                                            </div>
                                        </div><!-- /.box -->
                                    </div><!-- /.end .col -->
                                </div><!-- /.end .row -->


                                <div class="row">


                                    <div class="col-md-7">
                                        <!-- Horizontal Form -->
                                        <div class="box box-info" style="border-color:#0B6121">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Opciones de venta</h3>
                                            </div><!-- /.box-header -->
                                            <!-- form start -->
                                            <div class="box-body">
                                                <div class="row" style=" margin:0px; padding:0px 0px 0px 0px;">
                                                    <div class="col-sm-12">
                                                        <label>
                                                            <input id="dividirVenta" type="checkbox" name="dividirventa" value="si">&nbsp; Dividir venta
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="form-group panelDivision" style="display:none;">
                                                    <label for="selectidempleado_ajax" class="col-sm-3 control-label">En montos menores de: $</label>
                                                    <div class="col-sm-3">
                                                        <input class="form-control" type="text" id="montodivision" name="montodivision" value="2000" />
                                                    </div>
                                                </div>

                                                <div class="row" style=" margin:0px; padding:0px 0px 0px 0px;">
                                                    <div class="col-sm-12">
                                                        <label>
                                                            <input id="enviarDomicilio" type="checkbox" name="enviarDomicilio" value="si">&nbsp; Enviar a domicilio
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="form-group panelDomicilio" style="display:none;">
                                                    <label for="selectidempleado_ajax" class="col-sm-3 control-label">Fecha de entrega:</label>
                                                    <div class="col-sm-3">
                                                        <input value="<?php echo date('Y-m-d'); ?>" name="fechaentrega" type="date" required class="form-control" id="cfechaentrega" />
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input value="<?php echo date('H:i'); ?>" name="horaentregainicio" type="time" required class="form-control" id="choraentregainicio" />
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input value="<?php echo date('H:i'); ?>" name="horaentregafin" type="time" required class="form-control" id="choraentregafin" />
                                                    </div>

                                                </div>

                                                <div class="form-group panelDomicilio" style="display:none;">
                                                    <label for="selectidempleado_ajax" class="col-sm-3 control-label">Prioridad:</label>
                                                    <div class="col-sm-9">
                                                        <select id="cprioridad" name="prioridad" class="form-control">
                                                            <option value="BAJA">BAJA</option>
                                                            <option value="MEDIA">MEDIA</option>
                                                            <option value="ALTA">ALTA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group panelDomicilio" style="display:none;">
                                                    <label for="selectidempleado_ajax" class="col-sm-3 control-label">Domicilio de entrega:</label>
                                                    <div class="col-sm-9">
                                                        <select id="iddomicilio_ajax" name="iddomicilio" class="form-control" onChange="mostrarobjetosdomicilio(this.value);">
                                                            <option value="SELECCIONE DOMICILIO...">SELECCIONE DOMICILIO...</option>
                                                            <option value="NUEVO">NUEVO</option>
                                                        </select>
                                                    </div>
                                                </div>



                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="ctipovialidad" class="col-sm-3 control-label">Tipo vialidad:</label>
                                                    <div class="col-sm-9">
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



                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="ccalle" class="col-sm-3 control-label">Calle:</label>
                                                    <div class="col-sm-5">
                                                        <input value="" name="calle" type="text" class="form-control" id="autocalle" />
                                                    </div>
                                                </div>



                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="cnoexterior" class="col-sm-3 control-label">No. exterior:</label>
                                                    <div class="col-sm-2">


                                                        <input value="" name="noexterior" type="text" class="form-control" id="autonoexterior" />


                                                    </div>
                                                </div>


                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="cnointerior" class="col-sm-3 control-label">No. interior:</label>
                                                    <div class="col-sm-2">

                                                        <input value="" name="nointerior" type="text" class="form-control" id="cnointerior" />


                                                    </div>
                                                </div>


                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="cnombrecomercial" class="col-sm-3 control-label">Nombre comercial:</label>
                                                    <div class="col-sm-5">


                                                        <input value="" name="nombrecomercial" type="text" class="form-control" id="autonombrecomercial" />


                                                    </div>
                                                </div>


                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="ccolonia" class="col-sm-3 control-label">Colonia:</label>
                                                    <div class="col-sm-5">


                                                        <input value="" name="colonia" type="text" class="form-control" id="autocolonia" />


                                                    </div>
                                                </div>


                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="ccp" class="col-sm-3 control-label">CP:</label>
                                                    <div class="col-sm-2">
                                                        <span id="Vcp">
                                                            <input value="" name="cp" type="text" class="form-control" id="ccp" />
                                                            <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                                            <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                                            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                                                        </span>
                                                    </div>
                                                </div>


                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="cciudad" class="col-sm-3 control-label">Ciudad:</label>
                                                    <div class="col-sm-5">


                                                        <input value="" name="ciudad" type="text" class="form-control" id="autociudad" />


                                                    </div>
                                                </div>

                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="selectestado_ajax" class="col-sm-3 control-label">Estado:</label>
                                                    <div class="col-sm-5">
                                                        <select id="estado_ajax" name="estado" class="form-control">
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="selectzona_ajax" class="col-sm-3 control-label">Zona:</label>
                                                    <div class="col-sm-5">
                                                        <select id="idzona_ajax2" name="idzona2" class="form-control">
                                                        </select>
                                                    </div>
                                                </div>



                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="ccoordenadas" class="col-sm-3 control-label">Coordenadas:</label>
                                                    <div class="col-sm-3">

                                                        <input value="" name="coordenadas" type="text" class="form-control" id="ccoordenadas" readonly />


                                                    </div>
                                                    <div class="col-sm-2">
                                                        <a class="btn btn-warning" onClick="javascript:abrirModalDomicilio();"><i class="fa fa-crosshairs"></i> Localizar</a>
                                                    </div>
                                                </div>


                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="creferencia" class="col-sm-3 control-label">Referencia:</label>
                                                    <div class="col-sm-5">
                                                        <span id="Vreferencia">
                                                            <textarea name="referencia" id="creferencia" class="form-control"></textarea>
                                                            <span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                                            <span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                                            <span class="textareaRequiredMsg">Se necesita un valor.</span>
                                                        </span>
                                                    </div>
                                                </div>


                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="cobservacionesdomicilio" class="col-sm-3 control-label">Observaciones:</label>
                                                    <div class="col-sm-5">
                                                        <span id="Vobservacionesdomicilio">
                                                            <textarea name="observacionesdomicilio" id="cobservacionesdomicilio" class="form-control"></textarea>
                                                            <span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                                            <span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                                            <span class="textareaRequiredMsg">Se necesita un valor.</span>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="form-group panelDomicilioAlta" style="display:none;">
                                                    <label for="selectidgirocomercial_ajax" class="col-sm-3 control-label">Giro comercial:</label>
                                                    <div class="col-sm-5">
                                                        <select id="idgirocomercial_ajax" name="idgirocomercial" class="form-control">
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display:none;">
                                                    <label for="validardosis" class="col-sm-3 control-label">&nbsp;</label>
                                                    <div class="col-sm-10">
                                                        <label>
                                                            <input id="cvalidardosis" type="checkbox" name="validardosis" value="si">
                                                            Validar dosis para este domicilio
                                                        </label>
                                                    </div>
                                                </div>


                                                <div class="campo_contactos">
                                                    <div class="form-group panelDomicilioAlta">
                                                        <label for="ccontactos" class="col-sm-3 control-label">Contactos:</label>
                                                        <div class="col-sm-5">

                                                            <div style="width:100%;">
                                                                <div class="row" id="contactos_ajax">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div><!-- /.box-body -->

                                        </div><!-- /.box -->
                                    </div><!-- /.end .col-4 -->





                                    <div class="col-md-5">

                                        <!-- Horizontal Form -->
                                        <div class="box box-info" style="border-color:#0c63ba">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Totales</h3>
                                            </div><!-- /.box-header -->
                                            <!-- form start -->

                                            <div class="box-body">


                                                <div class="row">
                                                    <!-- /.inicio row -->
                                                    <div class="col-lg-12 ">
                                                        <div class="form-group">
                                                            <div class="col-sm-4">
                                                                <h3 style="line-height:0px;"></h3>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <h3 style="line-height:0px;">Otros</h3>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <h3 style="line-height:0px;">Productos</h3>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-4">
                                                                <h3 style="line-height:0px;">Subtotal:</h3>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <h3 style="line-height:0px;" id="lsubtotalotros">$0.00</h3>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <h3 style="line-height:0px;" id="lsubtotal">$0.00</h3>
                                                            </div>
                                                        </div>

                                                        <div class="form-group limpuestos">
                                                            <div class="col-sm-4">
                                                                <h3 style="line-height:0px;">Impuestos:</h3>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <h3 style="line-height:0px;" id="limpuestosotros">$0.00</h3>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <h3 style="line-height:0px;" id="limpuestos">$0.00</h3>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-4">
                                                                <h3 style="line-height:0px;">Total:</h3>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <h3 style="line-height:0px;" id="ltotalotros">$0.00</h3>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <h3 style="line-height:0px;" id="ltotal">$0.00</h3>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div><!-- /.fin row -->

                                            </div><!-- /.box-body -->


                                            <div class="box-footer">
                                                <div class="row filaEspecial">
                                                    <div class="col-sm-12">
                                                        <div class="form-group ">
                                                            <button type="button" class="btn btn-primary pull-left" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                                                            <button type="button" class="btn btn-default pull-left" id="botonCancelar" onclick="vaciarCampos();"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;Limpiar</button>
                                                            <button type="button" class="btn btn-success pull-right" id="botonAceptar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Aceptar</button>
                                                        </div>
                                                    </div>
                                                </div><!-- /filaespecial-->
                                            </div>





                                        </div><!-- /.box -->
                                    </div><!-- /.end .col-4 -->

                                </div><!-- /.end .row -->


                                <div class="form-group hide">
                                    <label for="cestadopago" class="col-sm-2 control-label">Estado pago:</label>
                                    <div class="col-sm-3">
                                        <span id="Vestadopago">
                                            <input value="" name="estadopago" type="text" class="form-control" id="cestadopago" />
                                            <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                            <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                                        </span>
                                    </div>
                                </div>


                                <div class="form-group hide">
                                    <label for="cestadofacturacion" class="col-sm-2 control-label">Estado facturación:</label>
                                    <div class="col-sm-3">
                                        <span id="Vestadofacturacion">
                                            <input value="" name="estadofacturacion" type="text" class="form-control" id="cestadofacturacion" />
                                            <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                            <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                                        </span>
                                    </div>
                                </div>


                                <div class="form-group hide">
                                    <label for="ctipo" class="col-sm-2 control-label">Tipo:</label>
                                    <div class="col-sm-3">
                                        <span id="Vtipo">
                                            <input value="" name="tipo" type="text" class="form-control" id="ctipo" />
                                            <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                            <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                                        </span>
                                    </div>
                                </div>


                                <div class="form-group hide">
                                    <label for="csubtotal" class="col-sm-2 control-label">Subtotal:</label>
                                    <div class="col-sm-3">

                                        <input value="" name="subtotal" type="text" class="form-control" id="csubtotal" />


                                    </div>
                                </div>


                                <div class="form-group hide">
                                    <label for="cimpuestos" class="col-sm-2 control-label">Impuestos:</label>
                                    <div class="col-sm-3">

                                        <input value="" name="impuestos" type="text" class="form-control" id="cimpuestos" />


                                    </div>
                                </div>


                                <div class="form-group hide">
                                    <label for="ctotal" class="col-sm-2 control-label">Total:</label>
                                    <div class="col-sm-3">

                                        <input value="" name="total" type="text" class="form-control" id="ctotal" />


                                    </div>
                                </div>


                                <div class="form-group hide">
                                    <label for="ccostodeventa" class="col-sm-2 control-label">Costo de venta:</label>
                                    <div class="col-sm-3">

                                        <input value="" name="costodeventa" type="text" class="form-control" id="ccostodeventa" />


                                    </div>
                                </div>


                                <div class="form-group hide">
                                    <label for="cutilidad" class="col-sm-2 control-label">Utilidad:</label>
                                    <div class="col-sm-3">

                                        <input value="" name="utilidad" type="text" class="form-control" id="cutilidad" />


                                    </div>
                                </div>


                                <div class="form-group hide">
                                    <label for="cidusuario" class="col-sm-2 control-label">idusuario:</label>
                                    <div class="col-sm-5">
                                        <input value="<?php echo $_SESSION['idusuario'] ?>" name="idusuario" type="text" class="form-control" id="cidusuario" />
                                    </div>
                                </div>



                                <div class="form-group hide">
                                    <label for="cenviaradomicilio" class="col-sm-2 control-label">Enviar a domicilio:</label>
                                    <div class="col-sm-5">
                                        <span id="Venviaradomicilio">
                                            <input value="" name="enviaradomicilio" type="text" class="form-control" id="cenviaradomicilio" />
                                            <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                            <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                                        </span>
                                    </div>
                                </div>


                                <div class="form-group hide">
                                    <label for="cestadoentrega" class="col-sm-2 control-label">Estado entrega:</label>
                                    <div class="col-sm-3">
                                        <span id="Vestadoentrega">
                                            <input value="" name="estadoentrega" type="text" class="form-control" id="cestadoentrega" />
                                            <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                            <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                                        </span>
                                    </div>
                                </div>


                                <div class="form-group hide">
                                    <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                                    <div class="col-sm-5">
                                        <span id="Vestatus">
                                            <input value="activo" name="estatus" type="" class="form-control" id="cestatus" />
                                            <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                                            <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                                            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                                        </span>
                                    </div>
                                </div>

                            </div><!-- /.box-body -->


                    </form>
                    <div id="loading" class="overlay" style="display:none">
                        <i class="fa fa-cog fa-spin" style="color:#649ad0"></i>
                    </div>
                    <div id="salida"></div>
                </div><!-- /.box -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include("../../../componentes/pie.php"); ?>
    </div><!-- ./wrapper -->
    <script type="text/javascript">
        var sprytextfield1 = new Spry.Widget.ValidationTextField("Vserie", "none", {
            validateOn: ["blur"],
            maxChars: 10,
            minChars: 1
        });
        var sprytextfield2 = new Spry.Widget.ValidationTextField("Vfolio", "none", {
            validateOn: ["blur"],
            maxChars: 10,
            minChars: 1
        });
        /*var sprytextfield3 = new Spry.Widget.ValidationTextField("Vestadopago", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
        var sprytextfield4 = new Spry.Widget.ValidationTextField("Vestadofacturacion", "none", {validateOn:["blur"],  maxChars:12,  minChars:1});
        var sprytextfield5 = new Spry.Widget.ValidationTextField("Vtipo", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
        var sprytextfield6 = new Spry.Widget.ValidationTextField("Venviaradomicilio", "none", {validateOn:["blur"],  maxChars:20,  minChars:1});
        var sprytextarea8 = new Spry.Widget.ValidationTextarea("Vdomicilioentrega",  { maxChars:255,  minChars:1});
        var sprytextfield9 = new Spry.Widget.ValidationTextField("Vcoordenadas", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
        var sprytextarea10 = new Spry.Widget.ValidationTextarea("Vobservaciones",  { maxChars:200,  minChars:1});
        var sprytextfield11 = new Spry.Widget.ValidationTextField("Vestadoentrega", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});*/
        var sprytextfield12 = new Spry.Widget.ValidationTextField("Vestatus", "none", {
            validateOn: ["blur"],
            maxChars: 15,
            minChars: 1
        });
    </script>

</body>

</html>