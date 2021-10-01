<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?>
    <link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' href='../../../librerias/js/multiple-email/multiple-emails.css'>
	<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="../../../plugins/fastclick/fastclick.min.js"></script>
	<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
	<script src="js.js"></script>
	<script src="../../../librerias/js/cookies.js"></script>
	<script src="../../../librerias/js/validaciones.js"></script>
	<script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
    <script src='../../../librerias/js/multiple-email/multiple-emails.js'></script>
    <script>
		$(function() {
			$('#current_emails').text($('#example_email').val());
			$('#cemail').val($('#example_email').val());
			$('#example_email').multiple_emails();
			$('#example_email').change( function(){
				$('#current_emails').text($(this).val());
				$('#cemail').val($(this).val());
			});
			
			
		});
	</script>

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
          <h1>Proveedor<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo proveedor</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['proveedores']['guardar']) or  !isset($_SESSION['permisos']['proveedores']['acceso'])){
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
            <div class="box box-info" style="border-color:#e7ec11">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
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
                    <label for="crfc" class="col-sm-2 control-label">RFC:</label>
                    <div class="col-sm-3">
                    	<span id="Vrfc">
                        <input value="" name="rfc" type="text" class="form-control" id="crfc" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="cnivelcalidad" class="col-sm-2 control-label">Nivel de calidad:</label>
                    <div class="col-sm-1">
                    	<select id="cnivelcalidad" name="nivelcalidad" class="form-control">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
                    </div> 
                </div>
				<div class="form-group ">
                  	<label for="cnivelexistencia" class="col-sm-2 control-label">Nivel de existencia:</label>
                    <div class="col-sm-1">
                    	<select id="cnivelexistencia" name="nivelexistencia" class="form-control">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
                    </div> 
                </div>
				<div class="form-group ">
                  	<label for="ctiemporespuesta" class="col-sm-2 control-label">Tiempo de respuesta en dias:</label>
                    <div class="col-sm-1">
                    	<select id="ctiemporespuesta" name="tiemporespuesta" class="form-control">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
                    </div> 
                </div>
                
                <div class="form-group ">
                  	<label for="ctipoprontopago" class="col-sm-2 control-label">Forma de calcular las cuentas por pagar:</label>
                    <div class="col-sm-5">
                    	<select id="ctipoprontopago" name="tipoprontopago" class="form-control">
							<option value="FACTURACION">PRONTO PAGO A PARTIR DE LA FACTURACION</option>
							<option value="RECEPCION">PRONTO PAGO A PARTIR DE LA RECEPCION</option>
						</select>
                    </div> 
                </div>
                
				
                <div class="form-group ">
                    <label for="cprontopagofactura" class="col-sm-2 control-label">Días de pronto pago después de facturación:</label>
                    <div class="col-sm-2">
                        <input value="" name="prontopagofactura" type="text" class="form-control" id="cprontopagofactura" />
            		</div>
                </div>
                
                <div class="form-group ">
                    <label for="cprontopagorecepcion" class="col-sm-2 control-label">Días de pronto pago después de recepción:</label>
                    <div class="col-sm-2">
                        <input value="" name="prontopagorecepcion" type="text" class="form-control" id="cprontopagorecepcion" />
            		</div>
                </div>
                
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-sm-5">
                        <input value="activo" name="estatus" type="hidden" class="form-control" id="cestatus" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="cnombre" class="col-sm-2 control-label">Lista de e-mails:</label>
                    <div class="col-sm-5">
                    	<input type='text' id='example_email' name='example_email' class='form-control' value=''>
                        	<pre id='current_emails' style="display:none;"></pre>
                        <input id="cemail" name="email" type="hidden"> 
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#e7ec11"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombre", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
var sprytextfield2 = new Spry.Widget.ValidationTextField("Vrfc", "none", {validateOn:["blur"],  maxChars:13,  minChars:12});			
</script>

</body>
</html>