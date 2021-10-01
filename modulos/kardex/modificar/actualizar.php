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
          <h1>Kardex<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar kardex</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['kardex']['modificar']) or  !isset($_SESSION['permisos']['kardex']['acceso'])){
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
            <div class="box box-info" style="border-color:#d90052">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group">
                    <label for="cidproducto" class="col-sm-2 control-label">Producto:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idproducto; ?>" name="idproducto" type="text" class="form-control" id="cidproducto" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cfechamovimiento" class="col-sm-2 control-label">Fecha de movimiento:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $fechamovimiento; ?>" name="fechamovimiento" type="date" required="required" class="form-control" id="cfechamovimiento" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cdescripcion" class="col-sm-2 control-label">Descripción:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $descripcion; ?>" name="descripcion" type="text" class="form-control" id="cdescripcion" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cobservaciones" class="col-sm-2 control-label">Observaciones:</label>
                    <div class="col-sm-5">
                    	
                        <textarea name="observaciones" id="cobservaciones" class="form-control"><?php echo $observaciones; ?></textarea>
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="centrada" class="col-sm-2 control-label">Entradas:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $entrada; ?>" name="entrada" type="text" class="form-control" id="centrada" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="csalida" class="col-sm-2 control-label">Salidas:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $salida; ?>" name="salida" type="text" class="form-control" id="csalida" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cexistencia" class="col-sm-2 control-label">Existencias:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $existencia; ?>" name="existencia" type="text" class="form-control" id="cexistencia" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="ccostounitario" class="col-sm-2 control-label">Costo Unitario:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $costounitario; ?>" name="costounitario" type="text" class="form-control" id="ccostounitario" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cpromedio" class="col-sm-2 control-label">Costo Promedio:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $promedio; ?>" name="promedio" type="text" class="form-control" id="cpromedio" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cdebe" class="col-sm-2 control-label">Debe:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $debe; ?>" name="debe" type="text" class="form-control" id="cdebe" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="chaber" class="col-sm-2 control-label">Haber:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $haber; ?>" name="haber" type="text" class="form-control" id="chaber" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="csaldo" class="col-sm-2 control-label">Saldo:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $saldo; ?>" name="saldo" type="text" class="form-control" id="csaldo" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cidalmacen" class="col-sm-2 control-label">Almacén:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idalmacen; ?>" name="idalmacen" type="text" class="form-control" id="cidalmacen" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cidmovimiento" class="col-sm-2 control-label">No.Movimiento:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idmovimiento; ?>" name="idmovimiento" type="text" class="form-control" id="cidmovimiento" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cidreferencia" class="col-sm-2 control-label">Referencia:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idreferencia; ?>" name="idreferencia" type="text" class="form-control" id="cidreferencia" />
            			
						
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
				  <input name="idkardex" type="hidden" id="cidkardex" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#d90052"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
</body>
</html>