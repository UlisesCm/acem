<?php
include("../../seguridad/comprobar_login.php");
include("../Pago.class.php");
include("../../detallecotizacionesproductos/Detallecotizacionproducto.class.php");
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
        <h1>Corte<small>Nuevo corte</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li><a href="#">Nuevo corte</a></li>
        </ol>
      </section>

      <!-- Contenido principal -->
      <section class="content">

        <?php
        /////PERMISOS////////////////
        if (!isset($_SESSION['permisos']['pagos']['guardar']) or  !isset($_SESSION['permisos']['pagos']['acceso'])) {
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


        <form class="form-horizontal" name="formulario" id="formulario" method="post">
          <div class="row">
            <div class="col-md-6">
              <!-- box -->
              <div class="box box-info" style="border-color:#3256B6">
                <div class="box-header with-border">
                  <h3 class="box-title">Datos principales</h3>
                </div><!-- /.box-header -->
                <div style="min-height:250px;">
                  <!-- mapa -->

                  <div class="form-group ">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha:</label>
                    <div class="col-sm-12" style="padding-left:25px; padding-right:25px;">
                      <input value="<?php echo date('Y-m-d'); ?>" name="fecha" type="date" required class="form-control" id="cfecha" />
                    </div>
                  </div>

                  <div class="form-group ">
                    <label for="cfecha" class="col-sm-2 control-label">Hora:</label>
                    <div class="col-sm-12" style="padding-left:25px; padding-right:25px;">
                      <input value="<?php echo date('H:i'); ?>" name="hora" type="time" required class="form-control" id="chora" />
                    </div>
                  </div>

                  <div class="form-group ">
                    <label for="selectidempleadocajero_ajax" class="col-sm-2 control-label">Cajero:</label>
                    <div class="col-sm-12" style="padding-left:25px; padding-right:25px;">
                      <select id="idempleadocajero_ajax" name="idempleadocajero" class="form-control">
                      </select>
                    </div>
                  </div>

                  <div class="form-group ">
                    <label for="selectidempleadogerente_ajax" class="col-sm-2 control-label">Gerente:</label>
                    <div class="col-sm-12" style="padding-left:25px; padding-right:25px; padding-bottom:5px;">
                      <select id="idempleadogerente_ajax" name="idempleadogerente" class="form-control">
                      </select>
                    </div>
                  </div>

                </div>
              </div><!-- Fin box-->
            </div><!-- /fin col -->
            <div class="col-md-6">
              <!-- box -->
              <div class="box box-info" style="border-color:#3256B6">
                <div class="box-header with-border">
                  <h3 class="box-title">Saldos de caja actuales</h3>
                </div><!-- /.box-header -->
                <div class="row" style=" padding:20px">
                  <div class="col-md-12">

                    <table border="0">
                      <tr height="30">
                        <td width="130" align="center" style="font-weight:bold">Forma de pago</td>
                        <td width="60" align="center" style="font-weight:bold">Saldo</td>
                      </tr>

                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-money" style="color:#8C85D3"></i> Efectivo:</td>
                        <td width="60" align="right" id="lefectivo">$0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-credit-card" style="color:#39B370"></i> Tarjeta de debito:</td>
                        <td width="60" align="right" id="ltarjetadedebito">$0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-credit-card" style="color:#EA5F0B"></i> Tarjeta de crédito:</td>
                        <td width="60" align="right" id="ltarjetadecredito">$0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-edit" style="color:#BF7C5B"></i> Cheques:</td>
                        <td width="60" align="right" id="lcheques">$0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-exchange" style="color:#DD7388"></i> Transferencias:</td>
                        <td width="60" align="right" id="ltransferencias">$0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-database" style="color:#5A5A61"></i> Depositos:</td>
                        <td width="60" align="right" id="ldepositos">$0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-files-o" style="color:#4B157E"></i> Notas de crédito:</td>
                        <td width="60" align="right" id="lnotasdecredito">$0.00</td>
                      </tr>
                    </table>


                    <table border="0">

                      <tr height="35" style="display:<?php //echo $mostrarCorte;
                                                      ?>" class="carle">
                        <td width="140" align="left" style="font-weight:bold">Saldo total:</td>
                        <td width="60" align="right"><span id="ltotal">0.00</span></td>
                      </tr>
                    </table>
                  </div><!-- /fin col -->
                </div><!-- /fin row -->
              </div><!-- Fin box-->

            </div><!-- /fin col -->


          </div>

          <div class="box box-info" style="border-color:#b4d571">
            <div class="box-header with-border">
              <h3 class="box-title">Efectivo</h3>
            </div><!-- /.box-header -->
            <div id="muestra_contenido_ajax" style="min-height:100px;">
            </div><!-- /din contenido ajax -->
            <div id="loading2" class="overlay" style="display:none">
              <i class="fa fa-cog fa-spin" style="color:#b4d571"></i>
            </div>
          </div><!-- Fin box>-->


          <div class="row">
            <!-- Left col -->
            <div class="col-md-4">
              <!-- box -->
              <div class="box box-info" style="border-color:#A46BD1">
                <div class="box-header with-border">
                  <h3 class="box-title">Conteo de efectivo</h3>
                </div><!-- /.box-header -->
                <div class="row" style=" padding:20px">
                  <div class="col-md-12">

                    <table border="0">
                      <tr height="30" style="border-top:1px dashed #999999">
                        <td width="130" align="center" style="font-weight:bold">Denominación</td>
                        <td width="60" align="center" style="font-weight:bold">Cantidad</td>
                        <td width="60" align="center" style="font-weight:bold">Monto</td>
                      </tr>
                      <tr height="10">
                        <td width="130">&nbsp;</td>
                        <td width="60">&nbsp;</td>
                        <td width="60">&nbsp;</td>
                      </tr>
                      <tr height="27">
                        <td width="130" align="left" style="font-weight:bold"><i class="fa fa-money" style="color:#8C85D3"></i> Billetes de $1000:</td>
                        <td width="60" align="right"><input value="0" type="text" class="form-control dinero" id="billetes1000" onBlur="calcularConteo('billetes1000',1000)" /></td>
                        <td width="60" align="right" id="lbilletes1000">$0</td>
                      </tr>
                      <tr height="27">
                        <td width="130" align="left" style="font-weight:bold"><i class="fa fa-money" style="color:#BF7C5B"></i> Billetes de $500:</td>
                        <td width="60" align="right"><input value="0" type="text" class="form-control dinero" id="billetes500" onBlur="calcularConteo('billetes500',500)" /></td>
                        <td width="60" align="right" id="lbilletes500">$0</td>
                      </tr>
                      <tr height="27">
                        <td width="130" align="left" style="font-weight:bold"><i class="fa fa-money" style="color:#39B370"></i> Billetes de $200:</td>
                        <td width="60" align="right"><input value="0" type="text" class="form-control dinero" id="billetes200" onBlur="calcularConteo('billetes200',200)" /></td>
                        <td width="60" align="right" id="lbilletes200">$0</td>
                      </tr>
                      <tr height="27">
                        <td width="130" align="left" style="font-weight:bold"><i class="fa fa-money" style="color:#EA5F0B"></i> Billetes de $100:</td>
                        <td width="60" align="right"><input value="0" type="text" class="form-control dinero" id="billetes100" onBlur="calcularConteo('billetes100',100)" /></td>
                        <td width="60" align="right" id="lbilletes100">$0</td>
                      </tr>
                      <tr height="27">
                        <td width="130" align="left" style="font-weight:bold"><i class="fa fa-money" style="color:#DD7388"></i> Billetes de $50:</td>
                        <td width="60" align="right"><input value="0" type="text" class="form-control dinero" id="billetes50" onBlur="calcularConteo('billetes50',50)" /></td>
                        <td width="60" align="right" id="lbilletes50">$0</td>
                      </tr>
                      <tr height="27">
                        <td width="130" align="left" style="font-weight:bold"><i class="fa fa-money" style="color:#63A9D3"></i> Billetes de $20:</td>
                        <td width="60" align="right"><input value="0" type="text" class="form-control dinero" id="billetes20" onBlur="calcularConteo('billetes20',20)" /></td>
                        <td width="60" align="right" id="lbilletes20">$0</td>
                      </tr>
                      <tr height="27">
                        <td width="130" align="left" style="font-weight:bold"><i class="fa fa-database" style="color:#FC3"></i> Monedas de $10:</td>
                        <td width="60" align="right"><input value="0" type="text" class="form-control dinero" id="monedas10" onBlur="calcularConteo('monedas10',10)" /></td>
                        <td width="60" align="right" id="lmonedas10">$0</td>
                      </tr>
                      <tr height="27">
                        <td width="130" align="left" style="font-weight:bold"><i class="fa fa-database" style="color:#CCC"></i> Monedas de $5:</td>
                        <td width="60" align="right"><input value="0" type="text" class="form-control dinero" id="monedas5" onBlur="calcularConteo('monedas5',5)" /></td>
                        <td width="60" align="right" id="lmonedas5">$0</td>
                      </tr>
                      <tr height="27">
                        <td width="130" align="left" style="font-weight:bold"><i class="fa fa-database" style="color:#CCC"></i> Monedas de $2:</td>
                        <td width="60" align="right"><input value="0" type="text" class="form-control dinero" id="monedas2" onBlur="calcularConteo('monedas2',2)" /></td>
                        <td width="60" align="right" id="lmonedas2">$0</td>
                      </tr>
                      <tr height="27">
                        <td width="130" align="left" style="font-weight:bold"><i class="fa fa-database" style="color:#CCC"></i> Monedas de $1:</td>
                        <td width="60" align="right"><input value="0" type="text" class="form-control dinero" id="monedas1" onBlur="calcularConteo('monedas1',1)" /></td>
                        <td width="60" align="right" id="lmonedas1">$0</td>
                      </tr>
                      <tr height="27">
                        <td width="130" align="left" style="font-weight:bold"><i class="fa fa-database" style="color:#FC3"></i> Monedas de ¢50:</td>
                        <td width="60" align="right"><input value="0" type="text" class="form-control dinero" id="monedas50c" onBlur="calcularConteo('monedas50c',0.5)" /></td>
                        <td width="60" align="right" id="lmonedas50c">$0</td>
                      </tr>
                    </table>
                    </br>

                    <table border="0">
                      <tr>
                        <td width="130" align="left" style="font-weight:bold">Suma:</td>
                        <td width="120" align="right"><input value="0" type="text" class="form-control" readonly id="sumaEfectivo" onBlur="calcularDiferencia('dineroCaja')" onkeypress="return soloNumeros(event,'dineroCaja');" /></td>
                      </tr>
                      <tr style="display:<?php //echo $mostrarCorte;
                                          ?>" class="carle">
                        <td width="130" align="left" style="font-weight:bold">Diferencia:</td>
                        <td width="120" align="right"><span id="ldiferencia">$0.00</span></td>
                        <input value="0" type="hidden" class="form-control" name="diferencia" id="diferencia" />
                      </tr>
                    </table>
                  </div><!-- /fin col -->
                </div><!-- /fin row -->
              </div><!-- Fin box-->
            </div><!-- /fin col -->

            <div class="col-md-4">
              <!-- box -->
              <div class="box box-info" style="border-color:#A46BD1">
                <div class="box-header with-border">
                  <h3 class="box-title">Restante en caja</h3>
                </div><!-- /.box-header -->

                <div class="row" style=" padding:20px">
                  <div class="col-md-12">

                    <table border="0">
                      <tr height="30">
                        <td width="130" align="center" style="font-weight:bold">Forma de pago</td>
                        <td width="60" align="center" style="font-weight:bold">Saldo</td>
                      </tr>

                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-money" style="color:#8C85D3"></i> Efectivo:</td>
                        <td width="60" align="right" id="lefectivorestante">0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-credit-card" style="color:#39B370"></i> Tarjeta de debito:</td>
                        <td width="60" align="right" id="ltarjetadedebitorestante">0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-credit-card" style="color:#EA5F0B"></i> Tarjeta de crédito:</td>
                        <td width="60" align="right" id="ltarjetadecreditorestante">0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-edit" style="color:#BF7C5B"></i> Cheques:</td>
                        <td width="60" align="right" id="lchequesrestante">0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-exchange" style="color:#DD7388"></i> Transferencias:</td>
                        <td width="60" align="right" id="ltransferenciasrestante">0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-database" style="color:#5A5A61"></i> Depositos:</td>
                        <td width="60" align="right" id="ldepositosrestante">0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-files-o" style="color:#4B157E"></i> Notas de crédito:</td>
                        <td width="60" align="right" id="lnotasdecreditorestante">0.00</td>
                      </tr>
                    </table>


                    <table border="0">

                      <tr height="35" style="display:<?php //echo $mostrarCorte;
                                                      ?>" class="carle">
                        <td width="140" align="left" style="font-weight:bold">Saldo total:</td>
                        <td width="60" align="right"><span id="ltotalrestante">0.00</span></td>
                      </tr>
                    </table>
                  </div><!-- /fin col -->
                </div><!-- /fin row -->

              </div><!-- Fin box-->

            </div><!-- /fin col -->


            <div class="col-md-4">
              <!-- box -->
              <div class="box box-info" style="border-color:#A46BD1">
                <div class="box-header with-border">
                  <h3 class="box-title">Totales a entregar</h3>
                </div><!-- /.box-header -->

                <div class="row" style=" padding:20px">
                  <div class="col-md-12">

                    <table border="0">
                      <tr height="30">
                        <td width="130" align="center" style="font-weight:bold">Forma de pago</td>
                        <td width="60" align="center" style="font-weight:bold">Saldo</td>
                      </tr>

                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-money" style="color:#8C85D3"></i> Efectivo:</td>
                        <td width="60" align="right" id="lefectivototal">0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-credit-card" style="color:#39B370"></i> Tarjeta de debito:</td>
                        <td width="60" align="right" id="ltarjetadedebitototal">0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-credit-card" style="color:#EA5F0B"></i> Tarjeta de crédito:</td>
                        <td width="60" align="right" id="ltarjetadecreditototal">0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-edit" style="color:#BF7C5B"></i> Cheques:</td>
                        <td width="60" align="right" id="lchequestotal">0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-exchange" style="color:#DD7388"></i> Transferencias:</td>
                        <td width="60" align="right" id="ltransferenciastotal">0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-database" style="color:#5A5A61"></i> Depositos:</td>
                        <td width="60" align="right" id="ldepositostotal">0.00</td>
                      </tr>
                      <tr height="27">
                        <td width="140" align="left" style="font-weight:bold"><i class="fa fa-files-o" style="color:#4B157E"></i> Notas de crédito:</td>
                        <td width="60" align="right" id="lnotasdecreditototal">0.00</td>
                      </tr>
                    </table>


                    <table border="0">

                      <tr height="35" style="display:<?php //echo $mostrarCorte;
                                                      ?>" class="carle">
                        <td width="140" align="left" style="font-weight:bold">Total a entregar:</td>
                        <td width="60" align="right"><span id="ltotaltotal">0.00</span></td>
                        <input value="0" type="hidden" class="form-control" name="totalaentregar" id="totalaentregar" />
                      </tr>
                    </table>
                  </div><!-- /fin col -->
                </div><!-- /fin row -->


                <div class="box-footer">
                  <div class="row filaEspecial">
                    <div class="col-sm-12">
                      <div class="form-group ">
                        <button type="button" class="btn btn-primary pull-right" id="botonImprimir"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;Imprimir</button>
                      </div>
                      <div class="form-group ">

                        <div class="input-group">
                          <input type="file" name="archivo" style="display:none;" id="carchivo" accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.txt,.pdf,.zip,.rar" onChange="fileinput('archivo')" />
                          <input type="text" name="narchivo" id="narchivo" class="form-control" placeholder="Archivo del corte..." disabled="disabled">
                          <span class="input-group-btn">
                            <a class="btn btn-warning" onclick="$('#carchivo').click();">&nbsp;&nbsp;&nbsp;Seleccionar archivo</a>
                          </span>
                        </div>
                      </div>
                      <div class="form-group ">
                        <button type="button" class="btn btn-success pull-right" id="botonAceptar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Finalizar corte</button>
                      </div>
                    </div>
                  </div><!-- /filaespecial-->
                </div>
              </div><!-- Fin box-->

            </div><!-- /fin col -->


          </div>
        </form>
        <div id="salida"></div>
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include("../../../componentes/pie.php"); ?>
  </div><!-- ./wrapper -->

</body>

</html>