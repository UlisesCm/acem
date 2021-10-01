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
          <h1>Facturacion<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar facturacion</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['facturacion']['modificar']) or  !isset($_SESSION['permisos']['facturacion']['acceso'])){
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
            <div class="box box-info" style="border-color:#da123f">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group ">
                    <label for="cfoliointerno" class="col-sm-2 control-label">Folio:</label>
                    <div class="col-sm-5">
                    	<span id="Vfoliointerno">
                        <input value="<?php echo $foliointerno; ?>" name="foliointerno" type="text" class="form-control" id="cfoliointerno" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $fecha; ?>" name="fecha" type="date" required class="form-control" id="cfecha" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="ctipo" class="col-sm-2 control-label">Tipo:</label>
                    <div class="col-sm-5">
                    	<select id="ctipo" name="tipo" class="form-control">
										<option value="I" <?php 
											if ($tipo=="I"){
												echo 'selected="selected"';
											}
											 ?>>Ingreso</option>
										
										<option value="T" <?php 
											if ($tipo=="T"){
												echo 'selected="selected"';
											}
											 ?>>Traslado</option>
										
										<option value="P" <?php 
											if ($tipo=="P"){
												echo 'selected="selected"';
											}
											 ?>>Pago</option>
										
										<option value="N" <?php 
											if ($tipo=="N"){
												echo 'selected="selected"';
											}
											 ?>>Nómina</option>
										
						</select>
                    </div> 
                </div>
				<div class="form-group ">
                  	<label for="cclasificacion" class="col-sm-2 control-label">Clasificación:</label>
                    <div class="col-sm-5">
                    	<select id="cclasificacion" name="clasificacion" class="form-control">
										<option value="CONTADO" <?php 
											if ($clasificacion=="CONTADO"){
												echo 'selected="selected"';
											}
											 ?>>CONTADO</option>
										
										<option value="CREDITO" <?php 
											if ($clasificacion=="CREDITO"){
												echo 'selected="selected"';
											}
											 ?>>CREDITO</option>
										
						</select>
                    </div> 
                </div>
				<div class="form-group ">
                    <label for="cemisor" class="col-sm-2 control-label">Emisor:</label>
                    <div class="col-sm-5">
                    	<span id="Vemisor">
                        <input value="<?php echo $emisor; ?>" name="emisor" type="text" class="form-control" id="cemisor" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="crfcemisor" class="col-sm-2 control-label">RFC Emisor:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $rfcemisor; ?>" name="rfcemisor" type="text" class="form-control" id="crfcemisor" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="creceptor" class="col-sm-2 control-label">Receptor:</label>
                    <div class="col-sm-5">
                    	<span id="Vreceptor">
                        <input value="<?php echo $receptor; ?>" name="receptor" type="text" class="form-control" id="creceptor" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="crfcreceptor" class="col-sm-2 control-label">RFC Receptor:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $rfcreceptor; ?>" name="rfcreceptor" type="text" class="form-control" id="crfcreceptor" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cmontototal" class="col-sm-2 control-label">Monto total:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $montototal; ?>" name="montototal" type="text" class="form-control" id="cmontototal" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cmontopagado" class="col-sm-2 control-label">Monto pagado:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $montopagado; ?>" name="montopagado" type="text" class="form-control" id="cmontopagado" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="cestado" class="col-sm-2 control-label">Estado:</label>
                    <div class="col-sm-5">
                    	<select id="cestado" name="estado" class="form-control">
										<option value="PENDIENTE" <?php 
											if ($estado=="PENDIENTE"){
												echo 'selected="selected"';
											}
											 ?>>PENDIENTE</option>
										
										<option value="PAGADO" <?php 
											if ($estado=="PAGADO"){
												echo 'selected="selected"';
											}
											 ?>>PAGADA</option>
										
										<option value="CANCELADA" <?php 
											if ($estado=="CANCELADA"){
												echo 'selected="selected"';
											}
											 ?>>CANCELADA</option>
										
						</select>
                    </div> 
                </div>
				<div class="form-group ">
                    <label for="cfechapago" class="col-sm-2 control-label">Fecha de pago:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $fechapago; ?>" name="fechapago" type="date" required class="form-control" id="cfechapago" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cformapago" class="col-sm-2 control-label">Forma de pago:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $formapago; ?>" name="formapago" type="text" class="form-control" id="cformapago" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ccuenta" class="col-sm-2 control-label">Cuenta:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $cuenta; ?>" name="cuenta" type="text" class="form-control" id="ccuenta" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cfoliofiscal" class="col-sm-2 control-label">UUID:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $foliofiscal; ?>" name="foliofiscal" type="text" class="form-control" id="cfoliofiscal" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cobservaciones" class="col-sm-2 control-label">Observaciones:</label>
                    <div class="col-sm-5">
                    	
                        <textarea name="observaciones" id="cobservaciones" class="form-control"><?php echo $observaciones; ?></textarea>
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="crelaciones" class="col-sm-2 control-label">Relaciones:</label>
                    <div class="col-sm-5">
                    	
                        <textarea name="relaciones" id="crelaciones" class="form-control"><?php echo $relaciones; ?></textarea>
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="carchivo" class="col-sm-2 control-label">Archivo:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $archivo; ?>" name="archivo" type="text" class="form-control" id="carchivo" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $estatus; ?>" name="estatus" type="hidden" class="form-control" id="cestatus" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="idfactura" type="hidden" id="cidfactura" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#da123f"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vfoliointerno", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vemisor", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vreceptor", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
				var sprytextfield1 = new Spry.Widget.ValidationTextField("Vfoliointerno", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vemisor", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vreceptor", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
				
</script>
</body>
</html>