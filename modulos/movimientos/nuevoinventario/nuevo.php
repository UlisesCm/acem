<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?>
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../librerias/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/jquery-ui.css" />
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script><script src="../../../librerias/js/validaciones.js"></script>
</head>
  <body class="sidebar-mini <?php include("../../../componentes/skin.php");?>">
    <!-- Wrapper es el contenedor principal -->
    <div class="wrapper">
      
      <?php include("../../../componentes/menuSuperior.php");?>
      <?php include("../../../componentes/menuLateral.php");?>

      <!-- Contenido-->
      <div class="content-wrapper">
        <!-- Contenido de la cabecera -->
        <section class="content-header">
          <h1>Movimiento<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo movimiento</a></li>
          </ol>
        </section>
        
        
        
        
        
        <div class="modal fade" id="modal-confirmacion">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="tituloRespuesta">Favor de confirmar la operación</h3>
              </div>
              <div class="modal-body">
              
                 <div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;">
                    <div class='col-sm-4' align="center"> 
                    	<div class="info-icons" style="color:#D81831">
                            <span class="fa-stack fa-lg fa-5x">
                              <i class="fa fa-square-o fa-stack-2x"></i>
                              <i class="fa fa-lock fa-stack-1x"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-8" align="center">
                    	<div class="form-group">
                            <label for="cpass">Contraseña de supervisión:</label>
                            <input value="" name="pass" type="password" class="form-control" id="cpass">
                    	</div>
                    </div>
                    
                 </div>
                 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="botonGuardar" data-dismiss="modal"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
        
        
        
        
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['movimientos']['guardar']) or  !isset($_SESSION['permisos']['movimientos']['acceso'])){
			echo $_SESSION['msgsinacceso'];
			echo "
		</section><!-- /.content -->
       </div><!-- /.content-wrapper -->";
       include("../../../componentes/pie.php");
	   echo "
	</div><!-- ./wrapper -->
</body>
</html>";
			include ("../../../componentes/avisos.php");
			exit;
		}
	/////FIN  DE PERMISOS////////
    		?>
			
			<?php $herramientas="nuevo"; include("../componentes/herramientas2.php"); ?>
			<?php include("../../../componentes/avisos.php");?>
        
          	<!-- Horizontal Form -->
            <div class="box box-info" style="border-color:#25c274">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
				<div class="form-group hide">
                    <label for="ctipo" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        <input value="entrada" name="tipo" type="hidden" class="form-control" id="ctipo" />
                    </div>
                </div>
			
				<div class="form-group hidden">
                  	<label for="cconcepto" class="col-sm-2 control-label">Motivo del movimiento:</label>
                    <div class="col-sm-5">
                    	<select id="cconcepto" name="concepto" class="form-control">
                        	<option value="ELIJA UNO">ELIJA UNO</option>
							<option value="AJUSTE">AJUSTE</option>
							<option value="ORDEN DE COMPRA">ORDEN DE COMPRA</option>
							<option value="INVENTARIO INICIAL">INVENTARIO INICIAL</option>
                            <option value="TRASPASO">TRASPASO ENTRE ALMACENES</option>
                            <option value="CONSIGNACION A CLIENTE">INGRESO DE CONSIGNACION A CLIENTE</option>
                            <option value="CONSIGNACION A VENDEDOR">INGRESO DE CONSIGNACION A VENDEDOR</option>
							<option value="DEVOLUCION">DEVOLUCION</option>
							<option value="OTRO">OTRO</option>
                            <option value="INVENTARIO NUEVO" selected>INVENTARIO NUEVO</option>
						</select>
                    </div> 
                </div>
				
				<div class="form-group EB">
                    <label for="cfechamovimiento" class="col-sm-2 control-label">Fecha del movimiento:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo date('Y-m-d'); ?>" name="fechamovimiento" type="date" required class="form-control" id="cfechamovimiento" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group EB">
                  	<label for="selectidalmacen_ajax" class="col-sm-2 control-label">Sucursal / Almacén:</label>
                    <div class="col-sm-5">
                      <select id="idalmacen_ajax" name="idalmacen" class="form-control">
                      </select>
                    </div> 
                </div>
				
				<div class="form-group">
                    <label for="cnumerocomprobante" class="col-sm-2 control-label">No. comprobante:</label>
                    <div class="col-sm-2">
                        <input value="" name="numerocomprobante" type="text" class="form-control" id="cnumerocomprobante"/>
                    </div>
                    <div class="col-sm-2">
                        <input type="button" value="Procesar" class="form-control btn btn-success" id="botonProcesar" style="display:none;"/>
                    </div>
                </div>
                
                <div class="form-group COMPRA" style="display:none">
                  	<label for="selectidproveedor_ajax" class="col-sm-2 control-label">Proveedor:</label>
                    <div class="col-sm-5">
                      <select id="idproveedor_ajax" name="idproveedor" class="form-control">
                      </select>
                    </div> 
                </div>
			
				
				<div class="form-group">
                    <label for="ccomentarios" class="col-sm-2 control-label">Comentarios:</label>
                    <div class="col-sm-5">
                        <textarea name="comentarios" id="ccomentarios" class="form-control"></textarea>
						
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        <input value="activo" name="estatus" type="hidden" class="form-control" id="cestatus" />
                    </div>
                </div>
                <div id="ajax_resultado">
                </div>
                <!-- Agregar a tabla --> 
                <div class="EB tablita">
                <div class="box-header with-border">
                	<h3 class="box-title">Tabla de productos</h3>
              	</div><!-- /.box-header -->
                    
                <div class='row' style="padding:20px;">
                    <div class='col-sm-3'>    
                        <div class='form-group'>
                            <label for="cnombreproducto">Producto</label>
                            
                            <input value="" name="idproducto" type="hidden" class="normal" id="cidproducto"/>
                            <input value="" name="codigoproducto" type="hidden" class="normal" id="ccodigoproducto"/>
                            <input value="" name="nnombreproducto" type="hidden" class="normal" id="nnombreproducto"/>
                            <input value="" name="consultaidproducto" type="hidden" class="normal" id="consultaidproducto" style="width:100px;"/>
                            <input value="" name="autoidproducto" type="text" class="form-control" id="autoidproducto" />
                        </div>
                    </div>
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="ncantidad">Unidad</label>
                            <input value="" name="nunidad" type="text" class="form-control" id="nunidad" disabled/>
                        </div>
                    </div>
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="ncantidad">Cantidad</label>
                            <input value="1" name="ncantidad" type="text" class="form-control" id="ncantidad"/>
                        </div>
                    </div>
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="ncosto">Costo</label>
                            <input value="" name="ncosto" type="text" class="form-control" id="ncosto"/>
                        </div>
                    </div>
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="nminimo">Mínimo</label>
                            <input value="0" name="nminimo" type="text" class="form-control" id="nminimo"/>
                        </div>
                    </div>
                    <div class='col-sm-2'>
                        <div class='form-group'>
                            <label for="nubicacion">Ubicación</label>
                            <input value="" name="nubicacion" type="text" class="form-control" id="nubicacion"/>
                        </div>
                    </div>
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="botonAgregarFila">&nbsp;</label>
                            <input value="" name="listaSalida" type="hidden" id="listaSalida"/>
                            <input value="" name="supervisor" type="hidden" id="csupervisor"/>
                            <input type="button" value="Agregar" class="form-control btn btn-success" id="botonAgregarFila"/>
                        </div>
                    </div>
                </div>
                <!-- Fin Agregar a tabla --> 
                <!-- Tabla --> 
                <div class="box-body table-responsive no-padding">
                    <table id="tablaSalida" class="table table-hover table-bordered">
                        <thead>
                            <tr style="background:#F3F3F3; color:#666; height:30px; border:1px" align="center">
                                <td width="80" style='display:none'>No.</td>
                                <td width="80" style='display:none'>ID</td>
                                <td width="100">Código</td>
                                <td width="200">Producto</td>
                                <td width="100">Unidad</td>
                                <td width="100">Cantidad <span id="totalLista" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Costo <span id="totalLista2" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Stock Mínimo</td>
                                <td width="150">Ubicación</td>
                                <td width="30" align="center"></td>
                            </tr>
                        </thead>
                        <tbody id="filas" style="background:#FFF; border:1px #666 solid;" align="center">
                        </tbody>
                    </table>
                </div>
                </div>
                <!-- Fina Tabla --> 
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonContinuar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Continuar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#25c274"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
        <audio id="player" src="sonido.mp3"> </audio>
        <audio id="playerq" src="bien.mp3"> </audio>
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>