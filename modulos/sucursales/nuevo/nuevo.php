<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/jquery-ui.js"></script><script src="../../../librerias/js/cookies.js"></script><script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgklWcfzgoPJ2RSW3t2MCuaq1pTXd0qIo"></script>
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
          <h1>Sucursal<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo sucursal</a></li>
          </ol>
        </section>
		 <?php include ("../../../componentes/modalMap.php");?>
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['sucursales']['guardar']) or  !isset($_SESSION['permisos']['sucursales']['acceso'])){
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
            <div class="box box-info" style="border-color:#cf2341">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post" enctype="multipart/form-data">
                <div class="box-body">
				
				<div class="form-group ">
                    <label for="cnombre" class="col-sm-2 control-label">Nombre de la sucursal:</label>
                    <div class="col-sm-5">
                    	<span id="Vnombre">
                        <input value="" name="nombre" type="text" class="form-control" id="cnombre" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="ccalle" class="col-sm-2 control-label">Calle:</label>
                    <div class="col-sm-5">
                    	<span id="Vcalle">
                        <input value="" name="calle" type="text" class="form-control" id="ccalle" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cnumero" class="col-sm-2 control-label">Número:</label>
                    <div class="col-sm-2">
                    	
                        <input value="" name="numero" type="text" class="form-control" id="cnumero" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="ccolonia" class="col-sm-2 control-label">Colonia:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="colonia" type="text" class="form-control" id="ccolonia" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="ccp" class="col-sm-2 control-label">CP:</label>
                    <div class="col-sm-2">
                    	<span id="Vcp">
                        <input value="" name="cp" type="text" class="form-control" id="ccp" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cciudad" class="col-sm-2 control-label">Ciudad:</label>
                    <div class="col-sm-5">
                    	
                        
					<input value="" name="ciudad" type="text" class="form-control" id="autociudad" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cestado" class="col-sm-2 control-label">Estado:</label>
                    <div class="col-sm-5">
                    	
                        
					<input value="" name="estado" type="text" class="form-control" id="autoestado" />
            			
						
                    </div>
                </div>
                
                <div class="form-group ">
                     <label for="ccoordenadas" class="col-sm-2 control-label">Coordenadas:</label>
                    <div class="col-sm-4">
                        
                        <input value="" name="coordenadas" type="text" class="form-control" id="ccoordenadas" readonly/>
                        
                        
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-warning" onClick="javascript:abrirModalDomicilio();"><i class="fa fa-crosshairs"></i> Localizar</a>
                    </div>
                </div>
                
                
                
			
				
				<div class="form-group ">
                    <label for="ctelefonocontacto" class="col-sm-2 control-label">Teléfono de contacto:</label>
                    <div class="col-sm-5">
                    	<span id="Vtelefonocontacto">
                        <input value="" name="telefonocontacto" type="text" class="form-control" id="ctelefonocontacto" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="clicenciassa" class="col-sm-2 control-label">Licencia SSA:</label>
                    <div class="col-sm-3">
                    	
                        <input value="" name="licenciassa" type="text" class="form-control" id="clicenciassa" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cserie" class="col-sm-2 control-label">Serie de facturación:</label>
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
                    <label for="cfolio" class="col-sm-2 control-label">Folio de facturación:</label>
                    <div class="col-sm-2">
                    	
                        <input value="" name="folio" type="text" class="form-control" id="cfolio" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="selectidcuentacorreo_ajax" class="col-sm-2 control-label">Cuenta de correo asignada:</label>
                    <div class="col-sm-5">
                      <select id="idcuentacorreo_ajax" name="idcuentacorreo" class="form-control">
                      </select>
                    </div> 
                </div>
				
				<div class="form-group ">
                	<label for="x" class="col-sm-2 control-label">Archivo de firma:</label>
                    <div class="col-sm-5">
                    	<div class="input-group">
                            <input type="file" name="archivofirma" style="display:none;" id="carchivofirma" accept=".jpg" onChange="fileinput('archivofirma')"/>
                            <input type="text" name="narchivofirma" id="narchivofirma" class="form-control" placeholder="Seleccionar Imagen" disabled="disabled">
                            <span class="input-group-btn">
                                <a class="btn btn-success" onclick="$('#carchivofirma').click();">&nbsp;&nbsp;&nbsp;Seleccionar Imagen</a>
                            </span>
                    	</div>        
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-sm-5">
                    	
                        <input value="activo" name="estatus" type="hidden" class="form-control" id="cestatus" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
            <div id="salida"></div>
                
                <div class="box-footer">
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#cf2341"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombre", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vcalle", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vcp", "none", {validateOn:["blur"],  maxChars:5,  minChars:5});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("Vtelefonocontacto", "none", {validateOn:["blur"],  maxChars:50});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vserie", "none", {validateOn:["blur"],  maxChars:20,  minChars:1});
				
</script>

</body>
</html>