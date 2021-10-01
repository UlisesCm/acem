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
          <h1>Ordenes de Compra<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar compra</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['compras']['modificar']) or  !isset($_SESSION['permisos']['compras']['acceso'])){
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
            <div class="box box-info" style="border-color:#ffaf09">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
                <div class="box-body">
				<div class="form-group hide">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha de orden:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $fecha; ?>" name="fecha" type="date" required class="form-control" id="cfecha" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group hide">
                    <label for="cidempleado" class="col-sm-2 control-label">Empleado:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idempleado; ?>" name="idempleado" type="text" class="form-control" id="cidempleado" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group hide">
                    <label for="ccomentarios" class="col-sm-2 control-label">Comentarios:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $comentarios; ?>" name="comentarios" type="text" class="form-control" id="ccomentarios" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group hide">
                    <label for="cestado" class="col-sm-2 control-label">Estado:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $estado; ?>" name="estado" type="text" class="form-control" id="cestado" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group hide">
                    <label for="cmonto" class="col-sm-2 control-label">Monto:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $monto; ?>" name="monto" type="text" class="form-control" id="cmonto" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group hide">
                    <label for="cidsucursal" class="col-sm-2 control-label">Sucursal:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idsucursal; ?>" name="idsucursal" type="text" class="form-control" id="cidsucursal" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group hide">
                    <label for="cidproveedor" class="col-sm-2 control-label">Proveedor:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idproveedor; ?>" name="idproveedor" type="text" class="form-control" id="cidproveedor" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group ">
                	<label for="x" class="col-sm-2 control-label">Factura:</label>
                    <div class="col-sm-5">
                    	<div class="input-group">
                            <input type="file" name="facturaI" style="display:none;" id="cfacturaI" accept=".pdf,.xml" onChange="fileinput('factura')"/>
                            <input value="<?php echo $factura; ?>" type="text" name="factura" id="cfactura" class="form-control" placeholder="Seleccionar Archivo" readonly >
                            <input value="<?php echo $factura; ?>" type="hidden" name="facturaEliminacion" id="cfacturaEliminacion" >
							<span class="input-group-btn">
                                <a class="btn btn-warning" onclick="$('#cfacturaI').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
                            </span>
                    	</div>        
                    </div>
					<span data-placement="bottom" data-toggle="tooltip" data-html="true" title="" data-original-title="
			<b>Adjuntar archivo de factura.</b>"><i class="fa fa-question-circle text-blue ayuda"></i></span>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="idcompra" type="hidden" id="cidcompra" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#ffaf09"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
</body>
</html>