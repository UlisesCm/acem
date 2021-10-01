<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script>

<script><?php echo "var idclienteSeleccionado='$idcliente';";?></script>

<script><?php echo "var idsucursalSeleccionado='$idsucursal';";?></script>

<script><?php echo "var idempleadoSeleccionado='$idempleado';";?></script>

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
          <h1>Cotizacionotro<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar cotizacionotro</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesotros']['modificar']) or  !isset($_SESSION['permisos']['cotizacionesotros']['acceso'])){
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
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group ">
                    <label for="cserie" class="col-sm-2 control-label">Serie:</label>
                    <div class="col-sm-2">
                    	<span id="Vserie">
                        <input value="<?php echo $serie; ?>" name="serie" type="text" class="form-control" id="cserie" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cfolio" class="col-sm-2 control-label">Folio:</label>
                    <div class="col-sm-2">
                    	<span id="Vfolio">
                        <input value="<?php echo $folio; ?>" name="folio" type="text" class="form-control" id="cfolio" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $fecha; ?>" name="fecha" type="date" required="required" class="form-control" id="cfecha" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ctipo" class="col-sm-2 control-label">Tipo:</label>
                    <div class="col-sm-3">
                    	<span id="Vtipo">
                        <input value="<?php echo $tipo; ?>" name="tipo" type="text" class="form-control" id="ctipo" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cmonto" class="col-sm-2 control-label">Monto:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $monto; ?>" name="monto" type="text" class="form-control" id="cmonto" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="selectidcliente_ajax" class="col-sm-2 control-label">Cliente:</label>
                    <div class="col-sm-3">
                      <select id="idcliente_ajax" name="idcliente" class="form-control">
                      </select>
                    </div> 
                </div>
				<div class="form-group ">
                  	<label for="selectidsucursal_ajax" class="col-sm-2 control-label">Sucursal:</label>
                    <div class="col-sm-3">
                      <select id="idsucursal_ajax" name="idsucursal" class="form-control">
                      </select>
                    </div> 
                </div>
				<div class="form-group ">
                  	<label for="selectidempleado_ajax" class="col-sm-2 control-label">Vendedor:</label>
                    <div class="col-sm-3">
                      <select id="idempleado_ajax" name="idempleado" class="form-control">
                      </select>
                    </div> 
                </div>
				<div class="form-group ">
                    <label for="cobservaciones" class="col-sm-2 control-label">Observaciones:</label>
                    <div class="col-sm-5">
                    	<span id="Vobservaciones">
                        <input value="<?php echo $observaciones; ?>" name="observaciones" type="text" class="form-control" id="cobservaciones" />
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
				  <input name="idcotizacionesotros" type="hidden" id="cidcotizacionesotros" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vserie", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vfolio", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vtipo", "none", {validateOn:["blur"],  maxChars:13,  minChars:1});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("Vobservaciones", "none", {validateOn:["blur"],  maxChars:200,  minChars:1});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vestatus", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});
				var sprytextfield1 = new Spry.Widget.ValidationTextField("Vserie", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vfolio", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vtipo", "none", {validateOn:["blur"],  maxChars:13,  minChars:1});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("Vobservaciones", "none", {validateOn:["blur"],  maxChars:200,  minChars:1});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vestatus", "none", {validateOn:["blur"],  maxChars:15,  minChars:1});
				
</script>
</body>
</html>