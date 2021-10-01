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
          <h1>Inventario<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo inventario</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['inventario']['guardar']) or  !isset($_SESSION['permisos']['inventario']['acceso'])){
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
            <div class="box box-info" style="border-color:#3972ce">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
				<div class="form-group">
                    <label for="cidalmacen" class="col-sm-2 control-label">Almacén:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="idalmacen" type="text" class="form-control" id="cidalmacen" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group">
                    <label for="cidproducto" class="col-sm-2 control-label">Producto:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="idproducto" type="text" class="form-control" id="cidproducto" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group">
                    <label for="cexistencia" class="col-sm-2 control-label">Existencia:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="existencia" type="text" class="form-control" id="cexistencia" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group">
                    <label for="cpromedio" class="col-sm-2 control-label">Costo Promedio:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="promedio" type="text" class="form-control" id="cpromedio" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group">
                    <label for="csaldo" class="col-sm-2 control-label">Saldo:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="saldo" type="text" class="form-control" id="csaldo" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group">
                    <label for="cminimo" class="col-sm-2 control-label">Stock Mínimo:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="minimo" type="text" class="form-control" id="cminimo" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group">
                    <label for="cubicacion" class="col-sm-2 control-label">Ubicación:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="ubicacion" type="text" class="form-control" id="cubicacion" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group">
                    <label for="cestado" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="estado" type="text" class="form-control" id="cestado" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#3972ce"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>