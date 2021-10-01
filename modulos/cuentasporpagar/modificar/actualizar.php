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

<script><?php echo "var idcuentaprincipalSeleccionado='$idcuentaprincipal';";?></script>

<script><?php echo "var idcuentasecundariaSeleccionado='$idcuentasecundaria';";?></script>

<script><?php echo "var idproveedorSeleccionado='$idproveedor';";?></script>

<script><?php echo "var idmodeloimpuestosSeleccionado='$idmodeloimpuestos';";?></script>


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
          <h1>Gasto<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar gasto</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['gastos']['modificar']) or  !isset($_SESSION['permisos']['gastos']['acceso'])){
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
            <div class="box box-info" style="border-color:#ef7769">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group ">
                  	<label for="selectidcuentaprincipal_ajax" class="col-sm-2 control-label">Idcuentaprincipal:</label>
                    <div class="col-sm-5">
                      <select id="idcuentaprincipal_ajax" name="idcuentaprincipal" class="form-control">
                      </select>
                    </div> 
                </div>
				<div class="form-group ">
                  	<label for="selectidcuentasecundaria_ajax" class="col-sm-2 control-label">Idcuentasecundaria:</label>
                    <div class="col-sm-5">
                      <select id="idcuentasecundaria_ajax" name="idcuentasecundaria" class="form-control">
                      </select>
                    </div> 
                </div>
				<div class="form-group ">
                    <label for="cdescripcion" class="col-sm-2 control-label">Descripcion:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $descripcion; ?>" name="descripcion" type="text" class="form-control" id="cdescripcion" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="selectidproveedor_ajax" class="col-sm-2 control-label">Idproveedor:</label>
                    <div class="col-sm-5">
                      <select id="idproveedor_ajax" name="idproveedor" class="form-control">
                      </select>
                    </div> 
                </div>
				<div class="form-group ">
                    <label for="cfactura" class="col-sm-2 control-label">Factura:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $factura; ?>" name="factura" type="text" class="form-control" id="cfactura" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="selectidmodeloimpuestos_ajax" class="col-sm-2 control-label">Idmodeloimpuestos:</label>
                    <div class="col-sm-5">
                      <select id="idmodeloimpuestos_ajax" name="idmodeloimpuestos" class="form-control">
                      </select>
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
                    <label for="cidretiro" class="col-sm-2 control-label">Idretiro:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idretiro; ?>" name="idretiro" type="text" class="form-control" id="cidretiro" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $estatus; ?>" name="estatus" type="hidden" class="form-control" id="cestatus" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="idgasto" type="hidden" id="cidgasto" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#ef7769"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
</body>
</html>