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
<script src="js.js"></script>
<script src="../../../librerias/js/cookies.js"></script>
<?php 
	if (isset($_GET['busqueda'])){
		echo "<script>
		var busqueda='".$_GET['busqueda']."';
		</script>";
	}else{
		echo '<script>var busqueda="";</script>';
	}
	if (isset($_GET['papelera'])){
		echo '<script>var papelera="si";</script>';
	}else{
		echo '<script>var papelera="no";</script>';
	}
?>
</head>
<body class="sidebar-mini <?php include("../../../componentes/skin.php");?>">
	<!-- Wrapper es el contenedor principal -->
    <div class="wrapper s">
      
      <?php include("../../../componentes/menuSuperior.php");?>
      <?php include("../../../componentes/menuLateral.php");?>
      <!-- Contenido-->
      <div class="content-wrapper">
        <!-- Contenido de la cabecera -->
        <section class="content-header">
          <h1>Retiros<small> Nuevo</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Consultar gasto</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['gastos']['consultar']) or  !isset($_SESSION['permisos']['gastos']['acceso'])){
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
			
			<?php $herramientas="consultar"; include("../componentes/herramientas.php"); ?>
        	<?php include("../../../componentes/avisos.php");?>
            
             <!-- Herramientas de filtrado-->
            <!-- Horizontal Form -->
            
            
            <div class="box box-info" style="border-color:#13A44D">
              <div class="box-header with-border">
                <h3 class="box-title"><i></i> Datos del retiro</h3>
                
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulariovista" method="post">
                <div class="box-body">
                	<div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;">
                    	
                        <div class='col-sm-2'>
                            <div class="form-group">
                            	<label for="cfecha">Fecha:</label>
                            	<input value="<?php echo date('Y-m-d'); ?>" name="fecha" type="date" required class="form-control" id="cfecha" />
                            </div>
                         </div>
                         <div class='col-sm-2'>	
                        	<div class="form-group">
                                <label for="idcuenta_ajax">Cuenta:</label>
                                <select id="idcuenta_ajax" name="idcuenta" class="form-control">
                     			 </select>
                        	</div>
                        </div>
                        <div class='col-sm-2'>	
                        	<div class="form-group">
                                <label for="ccheque" >Cheque/Referencia:</label>
                                 <input value="" name="cheque" type="text" class="form-control" id="ccheque" />
                        	</div>
                        </div>
                        <div class='col-sm-6'>	
                        	<div class="form-group">
                                <label for="ccheque" >Descripción:</label>
                                 <input value="" name="descripcion" type="text" class="form-control" id="cdescripcion" />
                        	</div>
                        </div>
                	</div><!-- /.Fin row -->
				</div><!-- /.box-body -->
                <div class="box-footer">
                
				 
                  
                </div><!-- /.box-footer -->
                
              </form>
              
            </div><!-- /.box -->
            <!-- Fin Herramientas de filtrado>
            
            
            
          	<!-- box -->
            <div class="box box-info" style="border-color:#ef7769">
            	<div class="box-header with-border">
                	<h3 class="box-title">Proveedores de mercancias (compras)</h3>
              	</div><!-- /.box-header -->
                <div id="muestra_contenido_ajax" style="min-height:100px;">
            	</div><!-- /din contenido ajax -->
                <div id="loading" class="overlay">
  					<i class="fa fa-cog fa-spin" style="color:#ef7769"></i>
			  	</div>
                 <div id="salida"></div>
            </div><!-- Fin box>
			
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>