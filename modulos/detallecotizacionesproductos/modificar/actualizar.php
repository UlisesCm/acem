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
          <h1>Detallecotizacionproducto<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar detallecotizacionproducto</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesproductos']['modificar']) or  !isset($_SESSION['permisos']['detallecotizacionesproductos']['acceso'])){
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
            <div class="box box-info" style="border-color:#4da8ac">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group ">
                    <label for="csubfolio" class="col-sm-2 control-label">Subfolio:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $subfolio; ?>" name="subfolio" type="text" class="form-control" id="csubfolio" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cidproducto" class="col-sm-2 control-label">Idproducto:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idproducto; ?>" name="idproducto" type="text" class="form-control" id="cidproducto" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ccantidad" class="col-sm-2 control-label">Cantidad:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $cantidad; ?>" name="cantidad" type="text" class="form-control" id="ccantidad" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ccosto" class="col-sm-2 control-label">Costo:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $costo; ?>" name="costo" type="text" class="form-control" id="ccosto" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cprecio" class="col-sm-2 control-label">Precio:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $precio; ?>" name="precio" type="text" class="form-control" id="cprecio" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="csubtotal" class="col-sm-2 control-label">Subtotal:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $subtotal; ?>" name="subtotal" type="text" class="form-control" id="csubtotal" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cimpuestos" class="col-sm-2 control-label">Impuestos:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $impuestos; ?>" name="impuestos" type="text" class="form-control" id="cimpuestos" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ctotal" class="col-sm-2 control-label">Total:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $total; ?>" name="total" type="text" class="form-control" id="ctotal" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cutilidad" class="col-sm-2 control-label">Utilidad:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $utilidad; ?>" name="utilidad" type="text" class="form-control" id="cutilidad" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cidcotizacionproducto" class="col-sm-2 control-label">Idcotizacionproducto:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idcotizacionproducto; ?>" name="idcotizacionproducto" type="text" class="form-control" id="cidcotizacionproducto" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cpesounitario" class="col-sm-2 control-label">Peso unitario:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $pesounitario; ?>" name="pesounitario" type="text" class="form-control" id="cpesounitario" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ccantidadentregada" class="col-sm-2 control-label">Cantidad entregada:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $cantidadentregada; ?>" name="cantidadentregada" type="text" class="form-control" id="ccantidadentregada" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="iddetallecotizacion" type="hidden" id="ciddetallecotizacion" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#4da8ac"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
</body>
</html>