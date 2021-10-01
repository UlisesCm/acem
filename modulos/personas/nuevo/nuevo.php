<?php 
include ("../../seguridad/comprobar_login.php");
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
<script src="js.js?V1"></script><script src="../../../librerias/js/cookies.js"></script><script src="../../../librerias/js/validaciones.js"></script><script type="text/javascript" src="../../../librerias/js/editor/jquery-te-1.4.0.min.js" charset="utf-8"></script><script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
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
          <h1>Persona<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo persona</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['personas']['guardar']) or  !isset($_SESSION['permisos']['personas']['acceso'])){
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
                        <input value="" name="rfc" type="text" class="form-control" id="crfc" />
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
                        <input value="" name="razonsocial" type="text" class="form-control" id="crazonsocial" />
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
                        	<option value="AUS">Australia</option>
                            <option value="AUT">Austria</option>
                        	<option value="CAN">Canadá</option>
                            <option value="CHN">China</option>
                            <option value="COL">Colombia</option>
                            <option value="ESP">España</option>
                            <option value="GTM">Guatemala</option>
                            <option value="JPN">Japón</option>
                            <option value="TWN" selected>Taiwán</option>
							<option value="USA" selected>Estados Unidos</option>
						</select>
                    </div> 
                </div>
                
                <div class="form-group extranjero" style="display:none;">
                    <label for="cestado" class="col-sm-2 control-label">Número de registro de identidad (TAX ID):</label>
                    <div class="col-sm-5">
                        <input value="" name="estado" type="text" class="form-control" id="cestado" />
						
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="cusocfdi" class="col-sm-2 control-label">Uso predeterminado de CFDI:</label>
                    <div class="col-sm-5">
                    	<select id="cusocfdi" name="usocfdi" class="form-control">
							<option value="G01">Adquisición de mercancias</option>
							<option value="G02">Devoluciones, descuentos o bonificaciones</option>
							<option value="G03">Gastos en general</option>
							<option value="I01">Construcciones</option>
							<option value="I02">Mobilario y equipo de oficina por inversiones</option>
							<option value="I03">Equipo de transporte</option>
							<option value="I04">Equipo de computo y accesorios</option>
							<option value="I05">Dados, troqueles, moldes, matrices y herramental</option>
							<option value="I06">Comunicaciones telefónicas</option>
							<option value="I07">Comunicaciones satelitales</option>
							<option value="I08">Otra maquinaria y equipo</option>
							<option value="D01">Honorarios médicos, dentales y gastos hospitalarios.</option>
							<option value="D02">Gastos médicos por incapacidad o discapacidad</option>
							<option value="D03">Gastos funerales.</option>
							<option value="D04">Donativos</option>
							<option value="D05">Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).</option>
							<option value="D06">Aportaciones voluntarias al SAR</option>
							<option value="D07">Primas por seguros de gastos médicos.</option>
							<option value="D08">Gastos de transportación escolar obligatoria.</option>
							<option value="D09">Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.</option>
							<option value="D10">Pagos por servicios educativos (colegiaturas)</option>
							<option value="P01" selected>Por definir</option>
						</select>
                    </div> 
                </div>
				
				<div class="form-group hide">
                    <label for="ccalle" class="col-sm-2 control-label">Calle:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="calle" type="hidden" class="form-control" id="ccalle" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="cnumeroexterior" class="col-sm-2 control-label">Numeroexterior:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="numeroexterior" type="hidden" class="form-control" id="cnumeroexterior" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="cnumerointerior" class="col-sm-2 control-label">Numerointerior:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="numerointerior" type="hidden" class="form-control" id="cnumerointerior" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="ccolonia" class="col-sm-2 control-label">Colonia:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="colonia" type="hidden" class="form-control" id="ccolonia" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="cmunicipio" class="col-sm-2 control-label">Municipio:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="municipio" type="hidden" class="form-control" id="cmunicipio" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="clocalidad" class="col-sm-2 control-label">Localidad:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="localidad" type="hidden" class="form-control" id="clocalidad" />
            			
						
                    </div>
                </div>
			
				
				
			
				
				<div class="form-group hide">
                    <label for="ccp" class="col-sm-2 control-label">Cp:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="cp" type="hidden" class="form-control" id="ccp" />
            			
						
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
			
				
				<div class="form-group ">
                    <label for="cmensaje" class="col-sm-2 control-label">Mensaje predeterminado:</label>
                    <div class="col-sm-5">
                    	
                        <input value="Estimado cliente, por medio del presente correo le hacemos llegar su comprobante fiscal de manera adjunta. Gracias." name="mensaje" type="text" class="jqte-test" id="cmensaje" />
            			
						
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
</script>

</body>
</html>