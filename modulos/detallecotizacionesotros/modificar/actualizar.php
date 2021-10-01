<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link href="../../../librerias/js/Spry/SpryValidationTextarea.css" rel="stylesheet" type="text/css" /><link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" /><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link href="../../../librerias/js/Spry/SpryValidationTextarea.css" rel="stylesheet" type="text/css" /><link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/jquery-ui.js"></script><script src="../../../librerias/js/cookies.js"></script>

<script><?php echo "var idmodeloimpuestosSeleccionado='$idmodeloimpuestos';";?></script>

<script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script><script src="../../../librerias/js/Spry/SpryValidationTextarea.js" type="text/javascript"></script>
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
          <h1>Detallecotizacionotro<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar detallecotizacionotro</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesotros']['modificar']) or  !isset($_SESSION['permisos']['detallecotizacionesotros']['acceso'])){
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
            <div class="box box-info" style="border-color:#b15fb8">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group ">
                    <label for="cidcliente" class="col-sm-2 control-label">Cliente:</label>
                    <div class="col-sm-3">
                    	
                        
					<input value="<?php echo $idcliente; ?>" name="idcliente" type="hidden" class="normal" id="cidcliente" style="width:50px;"/>
					<input value="" name="consultaidcliente" name="consultaidcliente" type="hidden" class="normal" id="consultaidcliente" style="width:100px;"/>
					<input value="<?php echo $autoidcliente; ?>" name="autoidcliente" type="text" class="form-control" id="autoidcliente" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $fecha; ?>" name="fecha" type="date" required="required" class="form-control" id="cfecha" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ccantidad" class="col-sm-2 control-label">Cantidad:</label>
                    <div class="col-sm-2">
                    	<span id="Vcantidad">
                        <input value="<?php echo $cantidad; ?>" name="cantidad" type="text" class="form-control" id="ccantidad" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cconcepto" class="col-sm-2 control-label">Concepto:</label>
                    <div class="col-sm-5">
                    	<span id="Vconcepto">
                        <textarea name="concepto" id="cconcepto" class="form-control"><?php echo $concepto; ?></textarea>
            			<span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textareaRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cunidad" class="col-sm-2 control-label">Unidad:</label>
                    <div class="col-sm-3">
                    	<span id="Vunidad">
                        <input value="<?php echo $unidad; ?>" name="unidad" type="text" class="form-control" id="cunidad" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cnumeroservicio" class="col-sm-2 control-label">Numeroservicio:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $numeroservicio; ?>" name="numeroservicio" type="hidden" class="form-control" id="cnumeroservicio" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="ctotalservicios" class="col-sm-2 control-label">Totalservicios:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $totalservicios; ?>" name="totalservicios" type="hidden" class="form-control" id="ctotalservicios" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cidcotizacionotros" class="col-sm-2 control-label">Idcotizacionotros:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $idcotizacionotros; ?>" name="idcotizacionotros" type="hidden" class="form-control" id="cidcotizacionotros" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cprecio" class="col-sm-2 control-label">Precio:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $precio; ?>" name="precio" type="text" class="form-control" id="cprecio" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cimpuestos" class="col-sm-2 control-label">Impuestos:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $impuestos; ?>" name="impuestos" type="text" class="form-control" id="cimpuestos" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ctotal" class="col-sm-2 control-label">Total:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $total; ?>" name="total" type="text" class="form-control" id="ctotal" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="selectidmodeloimpuestos_ajax" class="col-sm-2 control-label">Impuestos:</label>
                    <div class="col-sm-2">
                      <select id="idmodeloimpuestos_ajax" name="idmodeloimpuestos" class="form-control">
                      </select>
                    </div> 
                </div>
				<div class="form-group ">
                    <label for="cestadopago" class="col-sm-2 control-label">Estado pago:</label>
                    <div class="col-sm-2">
                    	<span id="Vestadopago">
                        <input value="<?php echo $estadopago; ?>" name="estadopago" type="text" class="form-control" id="cestadopago" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cestadofacturacion" class="col-sm-2 control-label">Estado facturación:</label>
                    <div class="col-sm-2">
                    	<span id="Vestadofacturacion">
                        <input value="<?php echo $estadofacturacion; ?>" name="estadofacturacion" type="text" class="form-control" id="cestadofacturacion" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cfactura" class="col-sm-2 control-label">Factura:</label>
                    <div class="col-sm-2">
                    	<span id="Vfactura">
                        <input value="<?php echo $factura; ?>" name="factura" type="text" class="form-control" id="cfactura" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-sm-2">
                    	<span id="Vestatus">
                        <input value="<?php echo $estatus; ?>" name="estatus" type="hidden" class="form-control" id="cestatus" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="iddetallecotizacionotros" type="hidden" id="ciddetallecotizacionotros" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#b15fb8"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vcantidad", "none", {validateOn:["blur"],  maxChars:1,  minChars:1});
				var sprytextarea2 = new Spry.Widget.ValidationTextarea("Vconcepto",  { maxChars:255,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vunidad", "none", {validateOn:["blur"],  maxChars:30,  minChars:1});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("Vestadopago", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vestadofacturacion", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});
				var sprytextfield6 = new Spry.Widget.ValidationTextField("Vfactura", "none", {validateOn:["blur"],  maxChars:30,  minChars:1});
				var sprytextfield7 = new Spry.Widget.ValidationTextField("Vestatus", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});
				var sprytextfield1 = new Spry.Widget.ValidationTextField("Vcantidad", "none", {validateOn:["blur"],  maxChars:1,  minChars:1});
				var sprytextarea2 = new Spry.Widget.ValidationTextarea("Vconcepto",  { maxChars:255,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vunidad", "none", {validateOn:["blur"],  maxChars:30,  minChars:1});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("Vestadopago", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vestadofacturacion", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});
				var sprytextfield6 = new Spry.Widget.ValidationTextField("Vfactura", "none", {validateOn:["blur"],  maxChars:30,  minChars:1});
				var sprytextfield7 = new Spry.Widget.ValidationTextField("Vestatus", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});
				
</script>
</body>
</html>