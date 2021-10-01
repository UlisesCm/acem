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

<script><?php echo "var idusuarioSeleccionado='$idusuario';";?></script>

<script><?php echo "var idempleadoSeleccionado='$idempleado';";?></script>

<script><?php echo "var iddomicilioSeleccionado='$iddomicilio';";?></script>

<script><?php echo "var tipoSeleccionado='$tipo';";?></script>

<script><?php echo "var envioSeleccionado='$enviaradomicilio';";?></script>

<script><?php echo "var prioridadSeleccionado='$prioridad';";?></script>

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
          <h1>Cotizacionproducto<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar cotizacionproducto</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesproductos']['modificar']) or  !isset($_SESSION['permisos']['cotizacionesproductos']['acceso'])){
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
            <div class="box box-info" style="border-color:#649ad0">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group">
                    <label for="cserie" class="col-sm-2 control-label">Serie:</label>
                    <div class="col-sm-2">
                    	<span id="Vserie">
                        <input value="<?php echo $serie; ?>" name="serie" type="text" readonly class="form-control" id="cserie" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cfolio" class="col-sm-2 control-label">Folio:</label>
                    <div class="col-sm-2">
                    	<span id="Vfolio">
                        <input value="<?php echo $folio; ?>" name="folio" type="text" readonly class="form-control" id="cfolio" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $fecha; ?>" name="fecha" type="date" required class="form-control" id="cfecha" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="chora" class="col-sm-2 control-label">Hora:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $hora; ?>" name="hora" type="time" required class="form-control" id="chora" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cestadopago" class="col-sm-2 control-label">Estado pago:</label>
                    <div class="col-sm-3">
                    	<span id="Vestadopago">
                        <input value="<?php echo $estadopago; ?>" name="estadopago" type="text" class="form-control" id="cestadopago" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cestadofacturacion" class="col-sm-2 control-label">Estado facturación:</label>
                    <div class="col-sm-3">
                    	<span id="Vestadofacturacion">
                        <input value="<?php echo $estadofacturacion; ?>" name="estadofacturacion" type="text" class="form-control" id="cestadofacturacion" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ctipo" class="col-sm-2 control-label">Tipo:</label>
                    <div class="col-sm-3">
                    	<span id="Vtipo">
                         <select id="ctipo" name="tipo" class="form-control">
                            <option value="VENTA">VENTA</option>
                            <option value="COTIZACION">COTIZACION</option>
                        </select>
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
                
              
			
				<div class="form-group hide">
                    <label for="csubtotal" class="col-sm-2 control-label">Subtotal:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $subtotal; ?>" name="subtotal" type="text" class="form-control" id="csubtotal" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cimpuestos" class="col-sm-2 control-label">Impuestos:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $impuestos; ?>" name="impuestos" type="text" class="form-control" id="cimpuestos" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="ctotal" class="col-sm-2 control-label">Total:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $total; ?>" name="total" type="text" class="form-control" id="ctotal" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="ccostodeventa" class="col-sm-2 control-label">Costo de venta:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $costodeventa; ?>" name="costodeventa" type="text" class="form-control" id="ccostodeventa" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cutilidad" class="col-sm-2 control-label">Utilidad:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $utilidad; ?>" name="utilidad" type="text" class="form-control" id="cutilidad" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cidcliente" class="col-sm-2 control-label">Idcliente:</label>
                    <div class="col-sm-5">
                    	
                        
					<input value="<?php echo $idcliente; ?>" name="idcliente" type="hidden" class="normal" id="cidcliente" style="width:50px;"/>
					<input value="" name="consultaidcliente" name="consultaidcliente" type="hidden" class="normal" id="consultaidcliente" style="width:100px;"/>
					<input value="<?php echo $autoidcliente; ?>" name="autoidcliente" type="text" class="form-control" id="autoidcliente" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="selectidusuario_ajax" class="col-sm-2 control-label">Idusuario:</label>
                    <div class="col-sm-5">
                      <select id="idusuario_ajax" name="idusuario" class="form-control">
                      </select>
                    </div> 
                </div>
				<div class="form-group ">
                  	<label for="selectidempleado_ajax" class="col-sm-2 control-label">Idempleado:</label>
                    <div class="col-sm-5">
                      <select id="idempleado_ajax" name="idempleado" class="form-control">
                      </select>
                    </div> 
                </div>
				<div class="form-group ">
                    <label for="cenviaradomicilio" class="col-sm-2 control-label">Enviar a domicilio:</label>
                    <div class="col-sm-5">
                    	<span id="Venviaradomicilio">
                         <select id="cenviaradomicilio" name="enviaradomicilio" class="form-control">
                            <option value="ENTREGA EN SUCURSAL">ENTREGA EN SUCURSAL</option>
                            <option value="ENVIO A DOMICILIO">ENVIO A DOMICILIO</option>
                        </select>
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cfechaentrega" class="col-sm-2 control-label">Fecha entrega:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $fechaentrega; ?>" name="fechaentrega" type="date" required class="form-control" id="cfechaentrega" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="choraentregainicio" class="col-sm-2 control-label">Hora entrega inicio:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $horaentregainicio; ?>" name="horaentregainicio" type="time" required class="form-control" id="choraentregainicio" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="choraentregafin" class="col-sm-2 control-label">Hora entrega fin:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $horaentregafin; ?>" name="horaentregafin" type="time" required class="form-control" id="choraentregafin" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cprioridad" class="col-sm-2 control-label">Prioridad:</label>
                    <div class="col-sm-2">
                    	<span id="Vprioridad">
                         <select id="cprioridad" name="prioridad" class="form-control">
                             <option value="BAJA">BAJA</option> 
                             <option value="MEDIA">MEDIA</option>
                             <option value="ALTA">ALTA</option>
                        </select>
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
                
                 <div class="form-group panelDomicilio">
                    <label for="selectidempleado_ajax" class="col-sm-2 control-label">Domicilio de entrega:</label>
                    <div class="col-sm-5">
                        <select id="iddomicilio_ajax" name="iddomicilio" class="form-control" onChange="mostrarformulariodomicilio(this.value);">
                              <!--<option value="SELECCIONE DOMICILIO...">SELECCIONE DOMICILIO...</option> 
                              <option value="NUEVO">NUEVO</option> -->
                        </select>
                         <button type="button" class="btn btn-default" id="botonActualizarDomicilios" onclick="llenarSelectDomicilio();">Actualizar</button>
                    </div> 
                </div>
                
				<div class="form-group hide">
                    <label for="ccoordenadas" class="col-sm-2 control-label">Coordenadas:</label>
                    <div class="col-sm-3">
                    	<span id="Vcoordenadas">
                        <input value="<?php echo $coordenadas; ?>" name="coordenadas" type="text" class="form-control" id="ccoordenadas" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cobservaciones" class="col-sm-2 control-label">Observaciones:</label>
                    <div class="col-sm-5">
                    	<span id="Vobservaciones">
                        <textarea name="observaciones" id="cobservaciones" class="form-control"><?php echo $observaciones; ?></textarea>
            			<span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textareaRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cestadoentrega" class="col-sm-2 control-label">Estado entrega:</label>
                    <div class="col-sm-3">
                    	<span id="Vestadoentrega">
                        <input value="<?php echo $estadoentrega; ?>" name="estadoentrega" type="text" class="form-control" id="cestadoentrega" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-sm-5">
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
				  <input name="idcotizacionproducto" type="hidden" id="cidcotizacionproducto" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#649ad0"></i>
			  </div>
               <div id="salida"></div>
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vserie", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vfolio", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vestadopago", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("Vestadofacturacion", "none", {validateOn:["blur"],  maxChars:12,  minChars:1});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vtipo", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield7 = new Spry.Widget.ValidationTextField("Vprioridad", "none", {validateOn:["blur"],  maxChars:5,  minChars:1});
				var sprytextfield11 = new Spry.Widget.ValidationTextField("Vestadoentrega", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});
				var sprytextfield12 = new Spry.Widget.ValidationTextField("Vestatus", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});
				var sprytextfield1 = new Spry.Widget.ValidationTextField("Vserie", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vfolio", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vestadopago", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("Vestadofacturacion", "none", {validateOn:["blur"],  maxChars:12,  minChars:1});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vtipo", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield7 = new Spry.Widget.ValidationTextField("Vprioridad", "none", {validateOn:["blur"],  maxChars:5,  minChars:1});
				var sprytextfield11 = new Spry.Widget.ValidationTextField("Vestadoentrega", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});
				var sprytextfield12 = new Spry.Widget.ValidationTextField("Vestatus", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});
				
</script>
</body>
</html>