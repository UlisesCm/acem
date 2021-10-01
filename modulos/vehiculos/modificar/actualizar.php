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
          <h1>Vehiculo<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar vehiculo</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['vehiculos']['modificar']) or  !isset($_SESSION['permisos']['vehiculos']['acceso'])){
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
            <div class="box box-info" style="border-color:#52b19c">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
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
                    <label for="cmarca" class="col-sm-2 control-label">Marca:</label>
                    <div class="col-sm-3">
                    	<span id="Vmarca">
                        <input value="<?php echo $marca; ?>" name="marca" type="text" class="form-control" id="cmarca" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="csubmarca" class="col-sm-2 control-label">Sub marca:</label>
                    <div class="col-sm-3">
                    	<span id="Vsubmarca">
                        <input value="<?php echo $submarca; ?>" name="submarca" type="text" class="form-control" id="csubmarca" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ccolor" class="col-sm-2 control-label">Color:</label>
                    <div class="col-sm-3">
                    	<span id="Vcolor">
                        <input value="<?php echo $color; ?>" name="color" type="text" class="form-control" id="ccolor" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cplaca" class="col-sm-2 control-label">Placa:</label>
                    <div class="col-sm-2">
                    	<span id="Vplaca">
                        <input value="<?php echo $placa; ?>" name="placa" type="text" class="form-control" id="cplaca" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ccapacidaddecarga" class="col-sm-2 control-label">Capacidad de carga (Kg):</label>
                    <div class="col-sm-2">
                    	<span id="Vcapacidaddecarga">
                        <input value="<?php echo $capacidaddecarga; ?>" name="capacidaddecarga" type="text" class="form-control" id="ccapacidaddecarga" />
            			
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="canio" class="col-sm-2 control-label">Año:</label>
                    <div class="col-sm-2">
                    	<span id="Vanio">
                        <input value="<?php echo $anio; ?>" name="anio" type="text" class="form-control" id="canio" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ckminicial" class="col-sm-2 control-label">Kmilometraje inicial:</label>
                    <div class="col-sm-3">
                    	<span id="Vkminicial">
                        <input value="<?php echo $kminicial; ?>" name="kminicial" type="text" class="form-control" id="ckminicial" />
            			
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="ckmactual" class="col-sm-2 control-label">Kmactual:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $kmactual; ?>" name="kmactual" type="hidden" class="form-control" id="ckmactual" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cvigenciaseguro" class="col-sm-2 control-label">Vigencia del seguro:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $vigenciaseguro; ?>" name="vigenciaseguro" type="date" required="required" class="form-control" id="cvigenciaseguro" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ckmultimomantenimiento" class="col-sm-2 control-label">Kilometraje último mantenimiento:</label>
                    <div class="col-sm-3">
                    	<span id="Vkmultimomantenimiento">
                        <input value="<?php echo $kmultimomantenimiento; ?>" name="kmultimomantenimiento" type="text" class="form-control" id="ckmultimomantenimiento" />
            			
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cfechaultimomantenimiento" class="col-sm-2 control-label">Fecha último mantenimiento:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $fechaultimomantenimiento; ?>" name="fechaultimomantenimiento" type="date" required="required" class="form-control" id="cfechaultimomantenimiento" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ctipodecombustible" class="col-sm-2 control-label">Tipo de combustible:</label>
                    <div class="col-sm-3">
                    	<span id="Vtipodecombustible">
                        <input value="<?php echo $tipodecombustible; ?>" name="tipodecombustible" type="text" class="form-control" id="ctipodecombustible" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cfrecuenciamantenimientokm" class="col-sm-2 control-label">Frecuencia mantenimiento en kilómetros:</label>
                    <div class="col-sm-3">
                    	<span id="Vfrecuenciamantenimientokm">
                        <input value="<?php echo $frecuenciamantenimientokm; ?>" name="frecuenciamantenimientokm" type="text" class="form-control" id="cfrecuenciamantenimientokm" />
            			
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cfrecuenciamantenimientofecha" class="col-sm-2 control-label">Frecuencia mantenimiento por meses:</label>
                    <div class="col-sm-3">
                    	<span id="Vfrecuenciamantenimientofecha">
                        <input value="<?php echo $frecuenciamantenimientofecha; ?>" name="frecuenciamantenimientofecha" type="text" class="form-control" id="cfrecuenciamantenimientofecha" />
            			
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="casignado" class="col-sm-2 control-label">Asignado:</label>
                    <div class="col-sm-3">
                    	<span id="Vasignado">
                        <input value="<?php echo $asignado; ?>" name="asignado" type="hidden" class="form-control" id="casignado" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="cestado" class="col-sm-2 control-label">Estado:</label>
                    <div class="col-sm-3">
                    	<select id="cestado" name="estado" class="form-control">
										<option value="EXCELENTE" <?php 
											if ($estado=="EXCELENTE"){
												echo 'selected="selected"';
											}
											 ?>>EXCELENTE</option>
										
										<option value="BUENO" <?php 
											if ($estado=="BUENO"){
												echo 'selected="selected"';
											}
											 ?>>BUENO</option>
										
										<option value="REGULAR" <?php 
											if ($estado=="REGULAR"){
												echo 'selected="selected"';
											}
											 ?>>REGULAR</option>
										
										<option value="MALO" <?php 
											if ($estado=="MALO"){
												echo 'selected="selected"';
											}
											 ?>>MALO</option>
										
						</select>
                    </div> 
                </div>
				<div class="form-group hide">
                    <label for="cidempleado" class="col-sm-2 control-label">Idempleado:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $idempleado; ?>" name="idempleado" type="hidden" class="form-control" id="cidempleado" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cidsucursal" class="col-sm-2 control-label">Idsucursal:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $idsucursal; ?>" name="idsucursal" type="hidden" class="form-control" id="cidsucursal" />
            			
						
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
				  <input name="idvehiculo" type="hidden" id="cidvehiculo" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#52b19c"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vtipo", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vmarca", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vsubmarca", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("Vcolor", "none", {validateOn:["blur"],  maxChars:25,  minChars:1});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vplaca", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield6 = new Spry.Widget.ValidationTextField("Vcapacidaddecarga", "none", {validateOn:["blur"],  minChars:1});
				var sprytextfield7 = new Spry.Widget.ValidationTextField("Vanio", "none", {validateOn:["blur"],  maxChars:4,  minChars:1});
				var sprytextfield8 = new Spry.Widget.ValidationTextField("Vkminicial", "none", {validateOn:["blur"],  minChars:1});
				var sprytextfield9 = new Spry.Widget.ValidationTextField("Vkmultimomantenimiento", "none", {validateOn:["blur"],  minChars:1});
				var sprytextfield10 = new Spry.Widget.ValidationTextField("Vtipodecombustible", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield11 = new Spry.Widget.ValidationTextField("Vfrecuenciamantenimientokm", "none", {validateOn:["blur"],  minChars:1});
				var sprytextfield12 = new Spry.Widget.ValidationTextField("Vfrecuenciamantenimientofecha", "none", {validateOn:["blur"],  minChars:1});
				var sprytextfield13 = new Spry.Widget.ValidationTextField("Vasignado", "none", {validateOn:["blur"],  maxChars:11,  minChars:1});
				var sprytextfield1 = new Spry.Widget.ValidationTextField("Vtipo", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vmarca", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vsubmarca", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("Vcolor", "none", {validateOn:["blur"],  maxChars:25,  minChars:1});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vplaca", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield6 = new Spry.Widget.ValidationTextField("Vcapacidaddecarga", "none", {validateOn:["blur"],  minChars:1});
				var sprytextfield7 = new Spry.Widget.ValidationTextField("Vanio", "none", {validateOn:["blur"],  maxChars:4,  minChars:1});
				var sprytextfield8 = new Spry.Widget.ValidationTextField("Vkminicial", "none", {validateOn:["blur"],  minChars:1});
				var sprytextfield9 = new Spry.Widget.ValidationTextField("Vkmultimomantenimiento", "none", {validateOn:["blur"],  minChars:1});
				var sprytextfield10 = new Spry.Widget.ValidationTextField("Vtipodecombustible", "none", {validateOn:["blur"],  maxChars:10,  minChars:1});
				var sprytextfield11 = new Spry.Widget.ValidationTextField("Vfrecuenciamantenimientokm", "none", {validateOn:["blur"],  minChars:1});
				var sprytextfield12 = new Spry.Widget.ValidationTextField("Vfrecuenciamantenimientofecha", "none", {validateOn:["blur"],  minChars:1});
				var sprytextfield13 = new Spry.Widget.ValidationTextField("Vasignado", "none", {validateOn:["blur"],  maxChars:11,  minChars:1});
				
</script>
</body>
</html>