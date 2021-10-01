<?php 
include ("../../seguridad/comprobar_login.php");
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
          <h1>Traspasos<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo traspaso</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['traspasos']['guardar']) or  !isset($_SESSION['permisos']['traspasos']['acceso'])){
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
            <div class="box box-info" style="border-color:#d70207">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
				<div class="form-group ">
                    <label for="cidmovimiento" class="col-sm-2 control-label">Movimiento:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="idmovimiento" type="text" class="form-control" id="cidmovimiento" />
            			
						
                    </div>
					
                </div>
			
				
				<div class="form-group ">
                    <label for="cidsucursalorigen" class="col-sm-2 control-label">Sucursal origen:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="idsucursalorigen" type="text" class="form-control" id="cidsucursalorigen" />
            			
						
                    </div>
					
                </div>
			
				
				<div class="form-group ">
                    <label for="cidsucursaldestino" class="col-sm-2 control-label">Sucursal destino:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="idsucursaldestino" type="text" class="form-control" id="cidsucursaldestino" />
            			
						
                    </div>
					
                </div>
			
				
				<div class="form-group ">
                    <label for="cfechasalida" class="col-sm-2 control-label">Fecha Salida:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo date('Y-m-d'); ?>" name="fechasalida" type="date" required="required" class="form-control" id="cfechasalida" />
            			
						
                    </div>
					
                </div>
			
				
				<div class="form-group ">
                    <label for="cfechaentrada" class="col-sm-2 control-label">Fecha Entrada:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo date('Y-m-d'); ?>" name="fechaentrada" type="date" required="required" class="form-control" id="cfechaentrada" />
            			
						
                    </div>
					
                </div>
			
				
				<div class="form-group ">
                    <label for="cestado" class="col-sm-2 control-label">Estado:</label>
                    <div class="col-sm-3">
                    	
                        <input value="" name="estado" type="text" class="form-control" id="cestado" />
            			
						
                    </div>
					
                </div>
			
				
				<div class="form-group ">
                    <label for="cnumerocomprobante" class="col-sm-2 control-label">Número Comprobante:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="numerocomprobante" type="text" class="form-control" id="cnumerocomprobante" />
            			
						
                    </div>
					
                </div>
			
				
				<div class="form-group ">
                    <label for="cidusuariosalida" class="col-sm-2 control-label">Usuario salida:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="idusuariosalida" type="text" class="form-control" id="cidusuariosalida" />
            			
						
                    </div>
					
                </div>
			
				
				<div class="form-group ">
                    <label for="cidusuarioentrada" class="col-sm-2 control-label">Usuario entrada:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="idusuarioentrada" type="text" class="form-control" id="cidusuarioentrada" />
            			
						
                    </div>
					
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#d70207"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>