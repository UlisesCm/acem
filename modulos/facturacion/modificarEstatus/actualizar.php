<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<?php include ("../../../componentes/cabecera.php")?>
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script>
<script src="../../../librerias/js/jquery-filestyle.min.js"></script>

<script><?php echo "var estadoSeleccionado='$estado';";?></script>


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
          <h1>Venta<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar venta</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['ventas']['modificar']) or  !isset($_SESSION['permisos']['ventas']['acceso'])){
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
        
          <div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-shopping-cart"></i>
                        <h3 class="box-title">Detalles de la venta</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <blockquote style="font-size:14px;">
                            <p><b>Cliente:</b> <?php echo strtoupper($nombrecliente)?></p>
                            <p><b>Fecha de venta:</b> <?php echo $nuevaFecha." | "; ?><cite><?php echo $hora; ?></cite></p>
                            <p><b>Ticket:</b> <?php echo $ticket; ?> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <b>Monto Total:</b> $ <?php echo $total; ?></p>
                            <p><b>Forma de pago:</b> <?php echo $formapago; ?></p>
                            <p><b>Sucursal:</b> <?php echo $nombrealmacen; ?></p>
                            <small>Vendedor:  <cite title="Source Title"><?php echo $nombreempleado; ?></cite></small>
                        </blockquote>
                    </div><!-- /.box-body -->
            </div>
            <!-- Horizontal Form -->
            <div class="box box-info" style="border-color:#000000">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post" enctype="multipart/form-data">
                <div class="box-body">
			
			
				<div class="form-group">
                    <label for="x" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-lg-10">
										<label class="radio inline control-label">
										 	<input id="cestado-0" type="radio" name="estado" value="Pendiente" <?php 
											if ($estado=="Pendiente"){
												echo 'checked="checked"';
											} ?> onClick="cambiarColor();">
											Pendiente
                        				 </label>
										<label class="radio inline control-label">
										 	<input id="cestado-1" type="radio" name="estado" value="Liquidada" <?php 
											if ($estado=="Liquidada"){
												echo 'checked="checked"';
											} ?> onClick="cambiarColor();">
											Liquidada
                        				 </label>
					</div>
				</div>
				
                
                
                <div class="form-group seccionFecha">
                    <label for="cfechaliquidacion" class="col-sm-2 control-label">Fecha de liquidación:</label>
                    <div class="col-sm-3">
                        <input value="<?php echo $fechaLiquidacion; ?>" name="fechaliquidacion" type="date" required class="form-control" id="cfechaliquidacion" />
                    </div>
                </div>
                
                <div class="form-group seccionNota">
                    <label for="x" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                    	<span class="text-green">&nbsp;&nbsp;* La cuenta se liquidará un saldo pendiente de <span class="badge bg-green">$ <?php echo number_format($diferenciaCredito,2); ?></span> por lo que se deberá crear la nota de crédito correspondiente</span>       
                    </div>
                </div>
                
				<div class="form-group seccionNota">
                	
                    <label for="x" class="col-sm-2 control-label">Adjuntar Nota de Crédito:</label>
                    <div class="col-sm-5">
                    	<div class="input-group">
                            <input type="file" name="archivoNotaI" style="display:none;" id="carchivoNotaI" accept=".xml,.zip,.rar,.pdf,.jpg,.jpeg" onChange="fileinput('archivoNota')"/>
                            <input value="<?php echo $archivoNota; ?>" type="text" name="archivoNota" id="carchivoNota" class="form-control" placeholder="Seleccionar Archivo" readonly >
                            <span class="input-group-btn">
                                <a class="btn btn-warning" onclick="$('#carchivoNotaI').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
                            </span>
                    	</div>        
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                    	<label>
							<?php 
								$checked="";
								if($facturada=="si"){
									$checked="checked='checked'";
								}
							?>
                  			<input id="cfacturada" type="checkbox" name="facturada" value="si" <?php echo $checked; ?>>
                  			Venta Facturada
                 		</label>
                    </div>
                </div>
                
                <div class="form-group" id="seccionFactura">
                	<label for="x" class="col-sm-2 control-label">Archivo de Factura:</label>
                    <div class="col-sm-5">
                    	<div class="input-group">
                            <input type="file" name="archivoFacturaI" style="display:none;" id="carchivoFacturaI" accept=".xml,.zip,.rar,.pdf,.jpg,.jpeg" onChange="fileinput('archivoFactura')"/>
                            <input value="<?php echo $archivoFactura; ?>" type="text" name="archivoFactura" id="carchivoFactura" class="form-control" placeholder="Seleccionar Archivo" readonly>
                            <input value="<?php echo $archivoFactura; ?>" type="hidden" name="archivoFacturaEliminacion" id="carchivoFacturaEliminacion">
                            <span class="input-group-btn">
                                <a class="btn btn-warning" onclick="$('#carchivoFacturaI').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
                            </span>
                    	</div>        
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cdiferenciaCredito" class="col-sm-2 control-label">Diferencia:</label>
                    <div class="col-sm-3">
                        <input value="<?php echo $diferenciaCredito; ?>" name="diferenciaCredito" type="text" class="form-control" id="cdiferenciaCredito" />
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="idventa" type="hidden" id="cidventa" value="<?php echo $id;?>"/>
                  <input name="idcliente" type="hidden" id="cidcliente" value="<?php echo $idcliente;?>"/>
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

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
</body>
</html>