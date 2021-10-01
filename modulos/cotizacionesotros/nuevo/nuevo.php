<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link href="../../../librerias/js/Spry/SpryValidationTextarea.css" rel="stylesheet" type="text/css" /><link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/jquery-ui.js"></script><script src="../../../librerias/js/cookies.js"></script><script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script><script src="../../../librerias/js/Spry/SpryValidationTextarea.js" type="text/javascript"></script>
<script type="text/javascript" src="../../../librerias/js/sortTable.js"></script> 
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
          <h1>Cotizacionotro<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nueva cotizacion</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesotros']['guardar']) or  !isset($_SESSION['permisos']['cotizacionesotros']['acceso'])){
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
            <div class="box box-info" style="border-color:#ff71b8">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
                <label class= "label pull-right bg-red" style="margin-left:10px;">Folio: <span id="lserie"> </span>-<span id="lfolio"></span></label>
                <label class= "label pull-right bg-yellow">Fecha: <?php echo date('Y-m-d'); ?></label>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
			
			
				
				<div class="form-group hide">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo date('Y-m-d'); ?>" name="fecha" type="date" required class="form-control" id="cfecha" />
            			
						
                    </div>
                </div>
			
            
                <div class="form-group hide">
                	<input value="" name="serie" type="text" class="form-control" id = "cserie"/>
                </div>
                <div class="form-group hide">
                	<input value="" name="folio" type="text" class="form-control" id = "cfolio"/>
                </div>
                
                 <div class="form-group ">
                    <label for="cidcliente" class="col-sm-2 control-label">Cliente:</label>
                    <div class="col-sm-5">
                    	
                        
					<input value="" name="idcliente" type="hidden" class="normal" id="cidcliente" style="width:50px;"/>
					<input value="" name="consultaidcliente" type="hidden" class="normal" id="consultaidcliente" style="width:100px;"/>
					<input value="" name="autoidcliente" type="text" class="form-control" id="autoidcliente" />
            			
						
                    </div>
                      <div class="col-sm-5">
			           <button type="button" class="btn btn-default pull-right" id="botonAgregar" onclick="agregarFila();">Agregar Fila</button>
                    </div>
                 </div>
                
				
				<div class="form-group hide">
                    <label for="ctipo" class="col-sm-2 control-label">Tipo:</label>
                    <div class="col-sm-3">
                    	<span id="Vtipo">
                        <input value="DIRECTA" name="tipo" type="text" class="form-control" id="ctipo" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
                
                
                
               
                
                
                 <div class="box-body table-responsive no-padding oCorrectivo"> <!-- /.box-body -->
                <table id="TablaServicios" class="table table-hover table-bordered"> 
                    <thead> 
                    <tr bgcolor="#E0E0E0"> 
                        <th style="display:none;">ID</th> 
                        <th>Fecha</th> 
                        <th>Cantidad</th> 
                        <th>Descripción</th> 
                        <th>Unidad</th> 
                        <th>Precio Unitario</th> 
                        <th>Importe</th>
                        <th style="display:none;">Impuestos</th>
                        <th width="30" align="center"></th>
                    </tr> 
                    </thead> 
                    <tbody id="filas"> 
                    
                    </tbody> 
                    </table> 
                 </div>
			     <br>
                 
                 
                  <div class="row filaEspecial">
                    <div class="col-sm-3">
                        <div class="form-group ">
                            <label for="csubtotal">Subtotal:</label>
                            <input value="" name="subtotal" type="text" readonly class="form-control" id="csubtotal" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group ">
                       <label for="idmodeloimpuestos_ajax">Modelo impuestos:</label>
                      <select id="idmodeloimpuestos_ajax" name="idmodeloimpuestos" class="form-control">
                      </select>
                       </div> 
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group ">
                            <label for="cimpuestos">Impuestos:</label>
                            <input value="" name="impuestos" type="text" readonly class="form-control" id="cimpuestos" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group ">
                            <label for="cmonto">Total:</label>
                            <input value="" name="monto" type="text" readonly class="form-control" id="cmonto" />
                        </div>
                    </div>
                 </div>
			
                
                 <div class="form-group hide">
                    <label for="cidsucursal" class="col-sm-2 control-label">idsucursal:</label>
                    <div class="col-sm-2">
                        <input value="<?php echo $_SESSION['idsucursal'] ?>" name="idsucursal" type="text" class="form-control" id="cidsucursal" />
                    </div>
                </div>
				
                
                <div class="row filaEspecial">
                    <div class="col-sm-8">
                        <div class="form-group ">
                            <label for="cobservaciones">Observaciones:</label>
                            <span id="Vobservaciones">
                              <input value="" name="observaciones" type="text" class="form-control" id="cobservaciones" />
                            <span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                            <span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                            <span class="textareaRequiredMsg">Se necesita un valor.</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group ">
                             <label for="selectidvendedor_ajax">Vendedor:</label>
                            <select id="idempleado_ajax" name="idempleado" class="form-control">
                            </select>
                        </div>
                    </div>
                 </div>
                 
				
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-sm-5">
                    	<span id="Vestatus">
                        <input value="activo" name="estatus" type="hidden" class="form-control" id="cestatus" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                 <div class="box-footer">
                  <div class="row filaEspecial">
                    <div class="col-sm-12">
                        <div class="form-group ">
                            
                            <button type="button" class="btn btn-default pull-left" id="botonCancelar" onclick="vaciarCampos();"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;Limpiar</button>
                            <button type="button" class="btn btn-success pull-right" id="botonAceptar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Aceptar</button>
                         </div>
                    </div>
			    </div><!-- /filaespecial-->
                  
                  <input value="" name="listaSalida" type="hidden" class="form-control" id="listaSalida" />
                  <div id="salida"></div>
                </div><!-- /.box-footer -->
                
                <div id="Mensaje"></div>
                
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#ff71b8"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vtipo", "none", {validateOn:["blur"],  maxChars:13,  minChars:1});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("Vobservaciones", "none", {validateOn:["blur"],  maxChars:200,  minChars:1});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vestatus", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});
				
</script>

</body>
</html>