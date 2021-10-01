<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<?php include ("../../../componentes/cabecera.php")?>
    <link type="text/css" rel="stylesheet" href="../../../librerias/js/editor/jquery-te-1.4.0.css">
    <link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' href='../../../librerias/js/multiple-email/multiple-emails.css'>
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js?V1"></script><script src="../../../librerias/js/cookies.js"></script>

<script src="../../../librerias/js/validaciones.js"></script><script type="text/javascript" src="../../../librerias/js/editor/jquery-te-1.4.0.min.js" charset="utf-8"></script><script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
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
          <h1>Persona<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar persona</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['personas']['modificar']) or  !isset($_SESSION['permisos']['personas']['acceso'])){
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
            <div class="box box-info" style="border-color:#005cd9">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
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
                
                <div class="form-group extranjero" style="display:none;">
                  	<label for="pais" class="col-sm-2 control-label">Recidencia Fiscal:</label>
                    <div class="col-sm-5">
                    	<select id="pais" name="pais" class="form-control">
                        				<option value="AUS" <?php 
											if ($pais=="AUS"){
												echo 'selected="selected"';
											}
											 ?>>Australia</option>
                                             
                                        <option value="AUT" <?php 
											if ($pais=="AUT"){
												echo 'selected="selected"';
											}
											 ?>>Austria</option>
                            
                            			<option value="CAN" <?php 
											if ($pais=="CAN"){
												echo 'selected="selected"';
											}
											 ?>>Canadá</option>
                                        
                                        <option value="CHN" <?php 
											if ($pais=="CHN"){
												echo 'selected="selected"';
											}
											 ?>>China</option>
										
										<option value="COL" <?php 
											if ($pais=="COL"){
												echo 'selected="selected"';
											}
											 ?>>Colombia</option>
										
										<option value="ESP" <?php 
											if ($pais=="ESP"){
												echo 'selected="selected"';
											}
											 ?>>España</option>
										
										<option value="GTM" <?php 
											if ($pais=="GTM"){
												echo 'selected="selected"';
											}
											 ?>>Guatemala</option>
                                             
                                        <option value="JPN" <?php 
											if ($pais=="JPN"){
												echo 'selected="selected"';
											}
											 ?>>Japón</option>
                                             
                                        <option value="TWN" <?php 
											if ($pais=="TWN"){
												echo 'selected="selected"';
											}
											 ?>>Taiwán</option>
                                             
                                        <option value="USA" <?php 
											if ($pais=="USA"){
												echo 'selected="selected"';
											}
											 ?>>Estados Unidos</option>
						</select>
                    </div> 
                </div>
                
                <div class="form-group extranjero" style="display:none;">
                    <label for="cestado" class="col-sm-2 control-label">Número de registro de identidad (TAX ID):</label>
                    <div class="col-sm-5">
                        <input value="<?php echo $estado; ?>" name="estado" type="text" class="form-control" id="cestado" />
						
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="cusocfdi" class="col-sm-2 control-label">Uso predeterminado de CFDI:</label>
                    <div class="col-sm-5">
                    	<select id="cusocfdi" name="usocfdi" class="form-control">
										<option value="G01" <?php 
											if ($usocfdi=="G01"){
												echo 'selected="selected"';
											}
											 ?>>Adquisición de mercancias</option>
										
										<option value="G02" <?php 
											if ($usocfdi=="G02"){
												echo 'selected="selected"';
											}
											 ?>>Devoluciones, descuentos o bonificaciones</option>
										
										<option value="G03" <?php 
											if ($usocfdi=="G03"){
												echo 'selected="selected"';
											}
											 ?>>Gastos en general</option>
										
										<option value="I01" <?php 
											if ($usocfdi=="I01"){
												echo 'selected="selected"';
											}
											 ?>>Construcciones</option>
										
										<option value="I02" <?php 
											if ($usocfdi=="I02"){
												echo 'selected="selected"';
											}
											 ?>>Mobilario y equipo de oficina por inversiones</option>
										
										<option value="I03" <?php 
											if ($usocfdi=="I03"){
												echo 'selected="selected"';
											}
											 ?>>Equipo de transporte</option>
										
										<option value="I04" <?php 
											if ($usocfdi=="I04"){
												echo 'selected="selected"';
											}
											 ?>>Equipo de computo y accesorios</option>
										
										<option value="I05" <?php 
											if ($usocfdi=="I05"){
												echo 'selected="selected"';
											}
											 ?>>Dados, troqueles, moldes, matrices y herramental</option>
										
										<option value="I06" <?php 
											if ($usocfdi=="I06"){
												echo 'selected="selected"';
											}
											 ?>>Comunicaciones telefónicas</option>
										
										<option value="I07" <?php 
											if ($usocfdi=="I07"){
												echo 'selected="selected"';
											}
											 ?>>Comunicaciones satelitales</option>
										
										<option value="I08" <?php 
											if ($usocfdi=="I08"){
												echo 'selected="selected"';
											}
											 ?>>Otra maquinaria y equipo</option>
										
										<option value="D01" <?php 
											if ($usocfdi=="D01"){
												echo 'selected="selected"';
											}
											 ?>>Honorarios médicos, dentales y gastos hospitalarios.</option>
										
										<option value="D02" <?php 
											if ($usocfdi=="D02"){
												echo 'selected="selected"';
											}
											 ?>>Gastos médicos por incapacidad o discapacidad</option>
										
										<option value="D03" <?php 
											if ($usocfdi=="D03"){
												echo 'selected="selected"';
											}
											 ?>>Gastos funerales.</option>
										
										<option value="D04" <?php 
											if ($usocfdi=="D04"){
												echo 'selected="selected"';
											}
											 ?>>Donativos</option>
										
										<option value="D05" <?php 
											if ($usocfdi=="D05"){
												echo 'selected="selected"';
											}
											 ?>>Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).</option>
										
										<option value="D06" <?php 
											if ($usocfdi=="D06"){
												echo 'selected="selected"';
											}
											 ?>>Aportaciones voluntarias al SAR</option>
										
										<option value="D07" <?php 
											if ($usocfdi=="D07"){
												echo 'selected="selected"';
											}
											 ?>>Primas por seguros de gastos médicos.</option>
										
										<option value="D08" <?php 
											if ($usocfdi=="D08"){
												echo 'selected="selected"';
											}
											 ?>>Gastos de transportación escolar obligatoria.</option>
										
										<option value="D09" <?php 
											if ($usocfdi=="D09"){
												echo 'selected="selected"';
											}
											 ?>>Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.</option>
										
										<option value="D10" <?php 
											if ($usocfdi=="D10"){
												echo 'selected="selected"';
											}
											 ?>>Pagos por servicios educativos (colegiaturas)</option>
										
										<option value="P01" <?php 
											if ($usocfdi=="P01"){
												echo 'selected="selected"';
											}
											 ?>>Por definir</option>
										
						</select>
                    </div> 
                </div>
				<div class="form-group hide">
                    <label for="ccalle" class="col-sm-2 control-label">Calle:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $calle; ?>" name="calle" type="hidden" class="form-control" id="ccalle" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cnumeroexterior" class="col-sm-2 control-label">Numeroexterior:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $numeroexterior; ?>" name="numeroexterior" type="hidden" class="form-control" id="cnumeroexterior" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cnumerointerior" class="col-sm-2 control-label">Numerointerior:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $numerointerior; ?>" name="numerointerior" type="hidden" class="form-control" id="cnumerointerior" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="ccolonia" class="col-sm-2 control-label">Colonia:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $colonia; ?>" name="colonia" type="hidden" class="form-control" id="ccolonia" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cmunicipio" class="col-sm-2 control-label">Municipio:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $municipio; ?>" name="municipio" type="hidden" class="form-control" id="cmunicipio" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="clocalidad" class="col-sm-2 control-label">Localidad:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $localidad; ?>" name="localidad" type="hidden" class="form-control" id="clocalidad" />
            			
						
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="ccp" class="col-sm-2 control-label">Cp:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $cp; ?>" name="cp" type="hidden" class="form-control" id="ccp" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cnombre" class="col-sm-2 control-label">Lista de e-mails:</label>
                    <div class="col-sm-5">
                    	<input type='text' id='example_email' name='example_email' class='form-control' value='<?php echo $email; ?>'>
                        	<pre id='current_emails' style="display:none;"></pre>
                        <input id="cemail" name="email" type="hidden"> 
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cmensaje" class="col-sm-2 control-label">Mensaje predeterminado:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $mensaje; ?>" name="mensaje" type="text" class="jqte-test" id="cmensaje" style="width:col-sm-5px;"/>
            			
						
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
				  <input name="idpersona" type="hidden" id="cidpersona" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#005cd9"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper --><script>
$('.jqte-test').jqte();
var jqteStatus = true;
$(".status").click(function(){
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
});
</script>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vrfc", "none", {validateOn:["blur"],  maxChars:13,  minChars:12});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vrazonsocial", "none", {validateOn:["blur"],  maxChars:100,  minChars:1});
				var sprytextfield1 = new Spry.Widget.ValidationTextField("Vrfc", "none", {validateOn:["blur"],  maxChars:13,  minChars:12});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vrazonsocial", "none", {validateOn:["blur"],  maxChars:100,  minChars:1});
				
</script>
</body>
</html>