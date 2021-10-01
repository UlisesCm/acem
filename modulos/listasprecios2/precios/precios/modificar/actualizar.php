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
          <h1>Precios<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar precios</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['precios']['modificar']) or  !isset($_SESSION['permisos']['precios']['acceso'])){
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
            <div class="box box-info" style="border-color:#000000">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group ">
                    <label for="cidlistaprecios" class="col-sm-2 control-label">Idlistaprecios:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idlistaprecios; ?>" name="idlistaprecios" type="text" class="form-control" id="cidlistaprecios" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cidreferencia" class="col-sm-2 control-label">Referencia:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idreferencia; ?>" name="idreferencia" type="text" class="form-control" id="cidreferencia" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cdescripcion" class="col-sm-2 control-label">Descripción:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $descripcion; ?>" name="descripcion" type="text" class="form-control" id="cdescripcion" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cpreciopublico" class="col-sm-2 control-label">Precio público:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $preciopublico; ?>" name="preciopublico" type="text" class="form-control" id="cpreciopublico" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ccomisiongeneral" class="col-sm-2 control-label">Comisión general:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $comisiongeneral; ?>" name="comisiongeneral" type="text" class="form-control" id="ccomisiongeneral" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ccomisionreferenciado" class="col-sm-2 control-label">Comisión referenciado:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $comisionreferenciado; ?>" name="comisionreferenciado" type="text" class="form-control" id="ccomisionreferenciado" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ccomisionmaster" class="col-sm-2 control-label">Comisión master:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $comisionmaster; ?>" name="comisionmaster" type="text" class="form-control" id="ccomisionmaster" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cprecioproveedor" class="col-sm-2 control-label">Precio proveedor:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $precioproveedor; ?>" name="precioproveedor" type="text" class="form-control" id="cprecioproveedor" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="idprecio" type="hidden" id="cidprecio" value="<?php echo $id;?>"/>
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