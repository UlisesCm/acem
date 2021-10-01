<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
  <head>
      <?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script><script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
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
          <h1>Gasto<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo gasto</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['gastos']['guardar']) or  !isset($_SESSION['permisos']['gastos']['acceso'])){
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
                      <label for="selectidsucursal_ajax" class="col-sm-2 control-label">Sucursal:</label>
                    <div class="col-sm-5">
                      <select id="idsucursal_ajax" name="idsucursal" class="form-control">
                      </select>
                    </div> 
                    
                      <div class="col-sm-5">
                          <button type="button" class="btn btn-default pull-right" id="botonAgregar" onclick="agregarFila();">Agregar Fila</button>
                       </div>
                 </div>
                                 
                                 
                 <div class="box-body table-responsive no-padding oCorrectivo"> <!-- /.box-body -->
                                <table id="TablaGastos" class="table table-hover table-bordered"> 
                                    <thead> 
                                     <tr style="background:#F3F3F3; color:#666; height:30px; border:1px" align="left">
                                        <th style="display:none;">ID</th> 
                                        <th>Fecha factura</th> 
                                        <th>Fecha vencimiento</th> 
                                        <th>Cuenta principal</th> 
                                        <th>Cuenta Secundaria</th> 
                                        <th>Descripción</th> 
                                        <th>Proveedor</th> 
                                        <th>Beneficiario</th> 
                                        <th>Factura</th> 
                                        <th>Modelo impuestos</th>
                                        <th>Subtotal</th>
                                        <th>Impuestos</th>
                                        <th>Total</th>
                                        <th width="30" align="center"></th>
                                    </tr> 
                                    </thead> 
                                    <tbody id="filas"> 
                                    
                                    </tbody> 
                                    </table> 
                                 </div>
                                 <br>
				<input value="" name="listaSalida" type="hidden" class="form-control" id="listaSalida" />
                
                 <div class="form-group ">
                    <label for="ctotal" class="col-sm-10 control-label">Total:</label>
                    <div class="col-sm-2">
                    	
                        <input value="0.00" name="total" readonly type="text" class="form-control" style="text-align:right; font-weight: bold;" id="ctotal" />
            			
						
                    </div>
                </div>
				
				
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-sm-5">
                    	
                        <input value="activo" name="estatus" type="hidden" class="form-control" id="cestatus" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#ef7769"></i>
			  </div>
               <div id="salida"></div>
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vdescripcion", "none", {validateOn:["blur"],  maxChars:200,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vcheque", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vbeneficiario", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
				
</script>
</body>
</html>