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

<script src="../../../librerias/js/validaciones.js"></script>
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
          <h1>Movimiento<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar movimiento</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['movimientos']['modificar']) or  !isset($_SESSION['permisos']['movimientos']['acceso'])){
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
            <div class="box box-info" style="border-color:#25c274">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group">
                    <label for="ctipo" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $tipo; ?>" name="tipo" type="hidden" class="form-control" id="ctipo" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                  	<label for="cconcepto" class="col-sm-2 control-label">Motivo del movimiento:</label>
                    <div class="col-sm-5">
                    	<select id="cconcepto" name="concepto" class="form-control">
										<option value="AJUSTE" <?php 
											if ($concepto=="AJUSTE"){
												echo 'selected="selected"';
											}
											 ?>>AJUSTE</option>
										
										<option value="ORDEN DE COMPRA" <?php 
											if ($concepto=="ORDEN DE COMPRA"){
												echo 'selected="selected"';
											}
											 ?>>ORDEN DE COMPRA</option>
										
										<option value="INVENTARIO INICIAL" <?php 
											if ($concepto=="INVENTARIO INICIAL"){
												echo 'selected="selected"';
											}
											 ?>>INVENTARIO INICIAL</option>
										
										<option value="TRASPASO" <?php 
											if ($concepto=="TRASPASO"){
												echo 'selected="selected"';
											}
											 ?>>TRASPASO ENTRE ALMACENES</option>
										
										<option value="DEVOLUCION" <?php 
											if ($concepto=="DEVOLUCION"){
												echo 'selected="selected"';
											}
											 ?>>DEVOLUCION</option>
										
										<option value="OTRO" <?php 
											if ($concepto=="OTRO"){
												echo 'selected="selected"';
											}
											 ?>>OTRO</option>
										
						</select>
                    </div> 
                </div>
				<div class="form-group">
                    <label for="cfechamovimiento" class="col-sm-2 control-label">Fecha del movimiento:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $fechamovimiento; ?>" name="fechamovimiento" type="date" required="required" class="form-control" id="cfechamovimiento" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cidalmacen" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idalmacen; ?>" name="idalmacen" type="hidden" class="form-control" id="cidalmacen" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cnumerocomprobante" class="col-sm-2 control-label">No. comprobante:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $numerocomprobante; ?>" name="numerocomprobante" type="text" class="form-control" id="cnumerocomprobante" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="ccomentarios" class="col-sm-2 control-label">Comentarios:</label>
                    <div class="col-sm-5">
                    	
                        <textarea name="comentarios" id="ccomentarios" class="form-control"><?php echo $comentarios; ?></textarea>
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cestatus" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $estatus; ?>" name="estatus" type="hidden" class="form-control" id="cestatus" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="idmovimiento" type="hidden" id="cidmovimiento" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#25c274"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
</body>
</html>