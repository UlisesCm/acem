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
          <h1>Stock<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo stock</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['stocks']['guardar']) or  !isset($_SESSION['permisos']['stocks']['acceso'])){
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
            <div class="box box-info" style="border-color:#f06666">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				 <blockquote style="font-size:14px;">
                        <p><b>Producto:</b> <?php echo $_POST['nombre'] ?></p>
                     </blockquote>
				<div class="form-group ">
                    <label for="cidproducto" class="col-sm-2 control-label">Idproducto:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $_POST['id'] ?>" name="idproducto" type="text" class="form-control" id="cidproducto" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cfechainicio" class="col-sm-2 control-label">Fecha inicio:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo date('Y-m-d'); ?>" name="fechainicio" type="date" required class="form-control" id="cfechainicio" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cfechafin" class="col-sm-2 control-label">Fecha fin:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo date('Y-m-d'); ?>" name="fechafin" type="date" required class="form-control" id="cfechafin" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cstockminimo" class="col-sm-2 control-label">Stock m??nimo:</label>
                    <div class="col-sm-2">
                    	
                        <input value="" name="stockminimo" type="text" class="form-control" id="cstockminimo" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="creserva" class="col-sm-2 control-label">Reserva:</label>
                    <div class="col-sm-2">
                    	
                        <input value="" name="reserva" type="text" class="form-control" id="creserva" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cstockmaximo" class="col-sm-2 control-label">Stock m??ximo:</label>
                    <div class="col-sm-2">
                    	
                        <input value="" name="stockmaximo" type="text" class="form-control" id="cstockmaximo" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#f06666"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>