<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
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
<script src="js.js?v=1"></script><script src="../../../librerias/js/cookies.js"></script><script src="../../../librerias/js/validaciones.js"></script>
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
			
			<?php $herramientas="nuevo"; include("../componentes/herramientas.php"); ?>
			<?php include("../../../componentes/avisos.php");?>
        
          	<!-- Horizontal Form -->
            <div class="box box-info" style="border-color:#D82533">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
				<div class="form-group hide">
                    <label for="ctipo" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                    	
                        <input value="salida" name="tipo" type="hidden" class="form-control" id="ctipo" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                  	<label for="cconcepto" class="col-sm-2 control-label">Motivo del movimiento:</label>
                    <div class="col-sm-5">
                    	<select id="cconcepto" name="concepto" class="form-control">
							<option value="ELIJA UNO">ELIJA UNO</option>
                            <option value="AJUSTE">AJUSTE</option>
							<option value="REQUISICION">REQUISICION</option>
							<option value="TRASPASO">TRASPASO ENTRE ALMACENES</option>
                            <option value="CONSIGNACION A CLIENTE">NUEVA CONSIGNACION A CLIENTE</option>
                            <option value="CONSIGNACION A VENDEDOR">NUEVA CONSIGNACION A VENDEDOR</option>
                            <option value="M CONSIGNACION A CLIENTE">MODIFICAR CONSIGNACION A CLIENTE</option>
                            <option value="M CONSIGNACION A VENDEDOR">MODIFICAR CONSIGNACION A VENDEDOR</option>
							<option value="DEVOLUCION DE COMPRA">DEVOLUCION SOBRE COMPRA</option>
							<option value="OTRO">OTRO</option>
						</select>
                    </div> 
                </div>
				
				<div class="form-group">
                    <label for="cfechamovimiento" class="col-sm-2 control-label">Fecha del movimiento:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo date('Y-m-d'); ?>" name="fechamovimiento" type="date" required class="form-control" id="cfechamovimiento" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group" id="seccionTraspasoO">
                  	<label for="selectidsucursal_ajax" class="col-sm-2 control-label" id="Lalmacen">Sucursal / Almacén:</label>
                    <div class="col-sm-5">
                      <select id="idsucursal_ajax" name="idsucursal" class="form-control">
                      </select>
                    </div> 
                </div>
                
                <div class="form-group" id="seccionTraspaso" style="display:none;">
                  	<label for="selectidsucursaldestino_ajax" class="col-sm-2 control-label" id="Lalmacendestino">Sucursal / Almacén Destino:</label>
                    <div class="col-sm-5">
                      <select id="idsucursaldestino_ajax" name="idsucursaldestino" class="form-control">
                      </select>
                    </div> 
                </div>
                
                <div class="form-group" id="seccionEmpleado" style="display:none;">
                  	<label for="selectidempleado_ajax" class="col-sm-2 control-label">Vendedor:</label>
                    <div class="col-sm-5">
                      <select id="idempleado_ajax" name="idempleado" class="form-control">
                      </select>
                    </div> 
                </div>
                
                <div class="form-group" id="seccionCliente" style="display:none;">
                    <label for="cidcliente" class="col-sm-2 control-label">Cliente:</label>
                    <div class="col-sm-5">
						<input value="0" name="idcliente" type="hidden" class="normal" id="cidcliente" style="width:50px;"/>
						<input value="" name="consultaidcliente" type="hidden" class="normal" id="consultaidcliente" style="width:100px;"/>
						<input value="" name="autoidcliente" type="text" class="form-control" id="autoidcliente" />
                    </div>
                </div>
				
				<div class="form-group">
                    <label for="cnumerocomprobante" class="col-sm-2 control-label">No. comprobante:</label>
                    <div class="col-sm-2">
                        <input value="" name="numerocomprobante" type="text" class="form-control" id="cnumerocomprobante"/>
                    	<input value="<?php echo generarClave(3);?>" id="clave" type="hidden">
                    </div>
                    <div class="col-sm-2">
                        
                        <input type="button" value="Procesar" class="form-control btn btn-success" id="botonProcesar" style="display:none;"/>
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
                
                
                <div id="seccionTabla"><!-- Seccion tabla --> 
                <!-- Agregar a tabla --> 
                <div class="box-header with-border">
                	<h3 class="box-title">Tabla de productos</h3>
              	</div><!-- /.box-header -->
                    
                <div class='row' style="padding:20px;">
                    <div class='col-sm-4'>    
                        <div class='form-group'>
                            <label for="cnombreproducto">Producto</label>
                            
                            <input value="" name="idproducto" type="hidden" class="normal" id="cidproducto"/>
                            <input value="" name="codigoproducto" type="hidden" class="normal" id="ccodigoproducto"/>
                            <input value="" name="nnombreproducto" type="hidden" class="normal" id="nnombreproducto"/>
                            <input value="" name="consultaidproducto" type="hidden" class="normal" id="consultaidproducto" style="width:100px;"/>
                            <input value="" name="autoidproducto" type="text" class="form-control" id="autoidproducto" />
                        </div>
                    </div>
                    <div class='col-sm-2'>
                        <div class='form-group'>
                            <label for="ncantidad">Unidad</label>
                            <input value="" name="nunidad" type="text" class="form-control" id="nunidad" disabled/>
                        </div>
                    </div>
                    <div class='col-sm-2'>
                        <div class='form-group'>
                            <label for="ncantidad">Cantidad</label>
                            <input value="1" name="ncantidad" type="text" class="form-control" id="ncantidad"/>
                        </div>
                    </div>
                    
                    
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="botonAgregarFila">&nbsp;</label>
                            <input value="" name="listaSalida" type="hidden" id="listaSalida"/>
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
                                <td width="30" align="center"></td>
                            </tr>
                        </thead>
                        <tbody id="filas" style="background:#FFF; border:1px #666 solid;" align="center">
                        </tbody>
                    </table>
                </div>
                <!-- Fina Tabla --> 
                </div> <!-- Fin sección tabla --> 
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#25c274"></i>
			  </div>
              <div id="mensaje"></div>
            </div><!-- /.box -->
        </section><!-- /.content -->
        <audio id="player" src="sonido.mp3"> </audio>
        <audio id="playerq" src="bien.mp3"> </audio>
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>