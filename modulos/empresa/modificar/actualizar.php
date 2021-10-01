<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link href="../../../librerias/js/Spry/SpryValidationTextarea.css" rel="stylesheet" type="text/css" /><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link href="../../../librerias/js/Spry/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script>

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
          <h1>Empresa<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar empresa</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['empresa']['modificar']) or  !isset($_SESSION['permisos']['empresa']['acceso'])){
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
            <div class="box box-info" style="border-color:#414141">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
                <div class="box-body">
				<div class="form-group ">
                    <label for="cnombrecomercial" class="col-sm-2 control-label">Nombre comercial:</label>
                    <div class="col-sm-5">
                    	<span id="Vnombrecomercial">
                        <input value="<?php echo $nombrecomercial; ?>" name="nombrecomercial" type="text" class="form-control" id="cnombrecomercial" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="crazonsocial" class="col-sm-2 control-label">Razón social:</label>
                    <div class="col-sm-5">
                    	<span id="Vrazonsocial">
                        <input value="<?php echo $razonsocial; ?>" name="razonsocial" type="text" class="form-control" id="crazonsocial" />
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
                        <input value="<?php echo $rfc; ?>" name="rfc" type="text" class="form-control" id="crfc" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cdomiciliofiscal" class="col-sm-2 control-label">Domicilio fiscal:</label>
                    <div class="col-sm-7">
                    	<span id="Vdomiciliofiscal">
                        <textarea name="domiciliofiscal" id="cdomiciliofiscal" class="form-control"><?php echo $domiciliofiscal; ?></textarea>
            			<span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textareaRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="cregimen" class="col-sm-2 control-label">Regimen:</label>
                    <div class="col-sm-7">
                    	<select id="cregimen" name="regimen" class="form-control">
										<option value="601" <?php 
											if ($regimen=="601"){
												echo 'selected="selected"';
											}
											 ?>>General de Ley Personas Morales</option>
										
										<option value="612" <?php 
											if ($regimen=="612"){
												echo 'selected="selected"';
											}
											 ?>>Personas Físicas con Actividades Empresariales y Profesionales</option>
										
						</select>
                    </div> 
                </div>
				<div class="form-group ">
                    <label for="ctelefono" class="col-sm-2 control-label">Teléfono:</label>
                    <div class="col-sm-3">
                    	<span id="Vtelefono">
                        <input value="<?php echo $telefono; ?>" name="telefono" type="text" class="form-control" id="ctelefono" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cemail" class="col-sm-2 control-label">Email:</label>
                    <div class="col-sm-5">
                    	<span id="Vemail">
                        <input value="<?php echo $email; ?>" name="email" type="text" class="form-control" id="cemail" />
            			<span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="clicenciasssa" class="col-sm-2 control-label">Licencias SSA:</label>
                    <div class="col-sm-5">
                    	<span id="Vlicenciasssa">
                        <input value="<?php echo $licenciasssa; ?>" name="licenciasssa" type="text" class="form-control" id="clicenciasssa" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                	<label for="x" class="col-sm-2 control-label">Logo:</label>
                    <div class="col-sm-5">
                    	<div class="input-group">
                            <input type="file" name="logoI" style="display:none;" id="clogoI" accept=".jpg" onChange="fileinput('logo')"/>
                            <input value="<?php echo $logo; ?>" type="text" name="logo" id="clogo" class="form-control" placeholder="Seleccionar Imagen" readonly >
                            <input value="<?php echo $logo; ?>" type="hidden" name="logoEliminacion" id="clogoEliminacion" >
							<span class="input-group-btn">
                                <a class="btn btn-success" onclick="$('#clogoI').click();">&nbsp;&nbsp;&nbsp;Seleccionar Imagen</a>
                            </span>
                    	</div>        
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cclave_csd" class="col-sm-2 control-label">Clave certificado SAT:</label>
                    <div class="col-sm-5">
                    	<span id="Vclave_csd">
                        <input value="<?php echo $clave_csd; ?>" name="clave_csd" type="text" class="form-control" id="cclave_csd" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                	<label for="x" class="col-sm-2 control-label">Certificado SAT:</label>
                    <div class="col-sm-5">
                    	<div class="input-group">
                            <input type="file" name="cer_csdI" style="display:none;" id="ccer_csdI" accept=".cer" onChange="fileinput('cer_csd')"/>
                            <input value="<?php echo $cer_csd; ?>" type="text" name="cer_csd" id="ccer_csd" class="form-control" placeholder="Seleccionar Archivo" readonly >
                            <input value="<?php echo $cer_csd; ?>" type="hidden" name="cer_csdEliminacion" id="ccer_csdEliminacion" >
							<span class="input-group-btn">
                                <a class="btn btn-warning" onclick="$('#ccer_csdI').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
                            </span>
                    	</div>        
                    </div>
                </div>
			
				<div class="form-group ">
                	<label for="x" class="col-sm-2 control-label">Key Certificado SAT:</label>
                    <div class="col-sm-5">
                    	<div class="input-group">
                            <input type="file" name="key_csdI" style="display:none;" id="ckey_csdI" accept=".key" onChange="fileinput('key_csd')"/>
                            <input value="<?php echo $key_csd; ?>" type="text" name="key_csd" id="ckey_csd" class="form-control" placeholder="Seleccionar Archivo" readonly >
                            <input value="<?php echo $key_csd; ?>" type="hidden" name="key_csdEliminacion" id="ckey_csdEliminacion" >
							<span class="input-group-btn">
                                <a class="btn btn-warning" onclick="$('#ckey_csdI').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
                            </span>
                    	</div>        
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cnumero_csd" class="col-sm-2 control-label">Numero CSD:</label>
                    <div class="col-sm-5">
                    	<span id="Vnumero_csd">
                        <input value="<?php echo $numero_csd; ?>" name="numero_csd" type="text" class="form-control" id="cnumero_csd" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
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
				  <input name="idempresa" type="hidden" id="cidempresa" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#414141"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombrecomercial", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vrazonsocial", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vrfc", "none", {validateOn:["blur"],  maxChars:13,  minChars:1});
				var sprytextarea4 = new Spry.Widget.ValidationTextarea("Vdomiciliofiscal",  { maxChars:200,  minChars:1});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vtelefono", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
				
var sprytextfield6 = new Spry.Widget.ValidationTextField("Vemail", "email", {validateOn:["blur"],  maxChars:150,  minChars:1});
				var sprytextfield7 = new Spry.Widget.ValidationTextField("Vlicenciasssa", "none", {validateOn:["blur"],  maxChars:30,  minChars:1});
				var sprytextfield8 = new Spry.Widget.ValidationTextField("Vclave_csd", "none", {validateOn:["blur"],  maxChars:100,  minChars:1});
				var sprytextfield9 = new Spry.Widget.ValidationTextField("Vnumero_csd", "none", {validateOn:["blur"],  maxChars:50});
				var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombrecomercial", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vrazonsocial", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vrfc", "none", {validateOn:["blur"],  maxChars:13,  minChars:1});
				var sprytextarea4 = new Spry.Widget.ValidationTextarea("Vdomiciliofiscal",  { maxChars:200,  minChars:1});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vtelefono", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
				
var sprytextfield6 = new Spry.Widget.ValidationTextField("Vemail", "email", {validateOn:["blur"],  maxChars:150,  minChars:1});
				var sprytextfield7 = new Spry.Widget.ValidationTextField("Vlicenciasssa", "none", {validateOn:["blur"],  maxChars:30,  minChars:1});
				var sprytextfield8 = new Spry.Widget.ValidationTextField("Vclave_csd", "none", {validateOn:["blur"],  maxChars:100,  minChars:1});
				var sprytextfield9 = new Spry.Widget.ValidationTextField("Vnumero_csd", "none", {validateOn:["blur"],  maxChars:50});
				
</script>
</body>
</html>