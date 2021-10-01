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
          <h1>Ruta<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo ruta</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['rutas']['guardar']) or  !isset($_SESSION['permisos']['rutas']['acceso'])){
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
            <div class="box box-info" style="border-color:#13a840">
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
                        <input value="" name="serie" type="text" class="form-control" id="cserie" />
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
                        <input value="" name="folio" type="text" class="form-control" id="cfolio" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cnombre" class="col-sm-2 control-label">Nombre:</label>
                    <div class="col-sm-3">
                    	<span id="Vnombre">
                        <input value="" name="nombre" type="text" class="form-control" id="cnombre" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo date('Y-m-d'); ?>" name="fecha" type="date" required="required" class="form-control" id="cfecha" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="selectidempleado_ajax" class="col-sm-2 control-label">Chofer:</label>
                    <div class="col-sm-5">
                      <select id="idempleado_ajax" name="idempleado" class="form-control">
                      </select>
                    </div> 
                </div>
				
				
				<div class="form-group ">
                    <label for="cobservacionesruta" class="col-sm-2 control-label">Observaciones ruta:</label>
                    <div class="col-sm-5">
                    	<span id="Vobservacionesruta">
                        <input value="" name="observacionesruta" type="text" class="form-control" id="cobservacionesruta" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cobservacionessalida" class="col-sm-2 control-label">Observaciones salida:</label>
                    <div class="col-sm-5">
                    	<span id="Vobservacionessalida">
                        <input value="" name="observacionessalida" type="text" class="form-control" id="cobservacionessalida" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cautorizada" class="col-sm-2 control-label">Autorizada:</label>
                    <div class="col-sm-3">
                    	<span id="Vautorizada">
                        <input value="" name="autorizada" type="text" class="form-control" id="cautorizada" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
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
  					<i class="fa fa-cog fa-spin" style="color:#13a840"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vserie", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vfolio", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vnombre", "none", {validateOn:["blur"],  maxChars:200,  minChars:1});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("Vobservacionesruta", "none", {validateOn:["blur"],  maxChars:200,  minChars:1});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vobservacionessalida", "none", {validateOn:["blur"],  maxChars:200,  minChars:1});
				var sprytextfield6 = new Spry.Widget.ValidationTextField("Vautorizada", "none", {validateOn:["blur"],  maxChars:13,  minChars:1});
				
</script>

</body>
</html>