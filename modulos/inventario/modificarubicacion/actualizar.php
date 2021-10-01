<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" /><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/jquery-ui.js"></script><script src="../../../librerias/js/cookies.js"></script>

<script><?php echo "var idalmacenSeleccionado='$idalmacen';";?></script>

<script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
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
          <h1>Inventario<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar inventario</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['inventario']['modificar']) or  !isset($_SESSION['permisos']['inventario']['acceso'])){
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
            <div class="box box-info" style="border-color:#005ebb">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
              
              
              
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group">
                  	<label for="selectidalmacen_ajax" class="col-sm-2 control-label">Almacén:</label>
                    <div class="col-sm-5">
                      <select id="idalmacen_ajax" name="idalmacen" class="form-control" disabled>
                      </select>
                    </div> 
                </div>
				<div class="form-group">
                    <label for="cidproducto" class="col-sm-2 control-label">Producto:</label>
                    <div class="col-sm-5">
                    	
                        
				<input value="<?php echo $idproducto; ?>" name="idproducto" type="hidden" class="normal" id="cidproducto" style="width:50px;"/>
				<input value="" name="consultaidproducto" name="consultaidproducto" type="hidden" class="normal" id="consultaidproducto" style="width:100px;"/>
				<input value="<?php echo $autoidproducto; ?>" name="autoidproducto" type="text" class="form-control" id="autoidproducto" disabled/>
            			
						
                    </div>
                </div>
			
				
			
				<div class="form-group">
                    <label for="cminimo" class="col-sm-2 control-label">Stock Mínimo:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $minimo; ?>" name="minimo" type="text" class="form-control" id="cminimo" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cubicacion" class="col-sm-2 control-label">Ubicación:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $ubicacion; ?>" name="ubicacion" type="text" class="form-control" id="cubicacion" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cestado" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $estado; ?>" name="estado" type="hidden" class="form-control" id="cestado" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="idinventario" type="hidden" id="cidinventario" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#005ebb"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
</body>
</html>