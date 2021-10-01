<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" /><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/jquery-ui.js"></script><script src="../../../librerias/js/cookies.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgklWcfzgoPJ2RSW3t2MCuaq1pTXd0qIo"></script>

<script><?php echo "var idcuentacorreoSeleccionado='$idcuentacorreo';";?></script>

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
          <h1>Sucursal<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar sucursal</a></li>
          </ol>
        </section>
		<?php include ("../../../componentes/modalMap.php");?>
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['sucursales']['modificar']) or  !isset($_SESSION['permisos']['sucursales']['acceso'])){
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
			  <form class="form-horizontal" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
                <div class="box-body">
				<div class="form-group ">
                    <label for="cnombre" class="col-sm-2 control-label">Nombre de la sucursal:</label>
                    <div class="col-sm-5">
                    	<span id="Vnombre">
                        <input value="<?php echo $nombre; ?>" name="nombre" type="text" class="form-control" id="cnombre" />
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
                        <input value="<?php echo $calle; ?>" name="calle" type="text" class="form-control" id="ccalle" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cnumero" class="col-sm-2 control-label">Número:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $numero; ?>" name="numero" type="text" class="form-control" id="cnumero" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ccolonia" class="col-sm-2 control-label">Colonia:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $colonia; ?>" name="colonia" type="text" class="form-control" id="ccolonia" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ccp" class="col-sm-2 control-label">CP:</label>
                    <div class="col-sm-2">
                    	<span id="Vcp">
                        <input value="<?php echo $cp; ?>" name="cp" type="text" class="form-control" id="ccp" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cciudad" class="col-sm-2 control-label">Ciudad:</label>
                    <div class="col-sm-5">
                    	
                        
					<input value="<?php echo $ciudad; ?>" name="ciudad" type="text" class="form-control" id="autociudad" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cestado" class="col-sm-2 control-label">Estado:</label>
                    <div class="col-sm-5">
                    	
                        
					<input value="<?php echo $estado; ?>" name="estado" type="text" class="form-control" id="autoestado" />
            			
						
                    </div>
                </div>
                
                <div class="form-group ">
                     <label for="ccoordenadas" class="col-sm-2 control-label">Coordenadas:</label>
                    <div class="col-sm-3">
                        
                        <input value="" name="coordenadas" type="text" class="form-control" id="ccoordenadas" readonly/>
                        
                        
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-warning" onClick="javascript:abrirModalDomicilio();"><i class="fa fa-crosshairs"></i> Localizar</a>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ctelefonocontacto" class="col-sm-2 control-label">Teléfono de contacto:</label>
                    <div class="col-sm-3">
                    	<span id="Vtelefonocontacto">
                        <input value="<?php echo $telefonocontacto; ?>" name="telefonocontacto" type="text" class="form-control" id="ctelefonocontacto" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="clicenciassa" class="col-sm-2 control-label">Licencia SSA:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $licenciassa; ?>" name="licenciassa" type="text" class="form-control" id="clicenciassa" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cserie" class="col-sm-2 control-label">Serie de facturación:</label>
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
                    <label for="cfolio" class="col-sm-2 control-label">Folio de facturación:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $folio; ?>" name="folio" type="text" class="form-control" id="cfolio" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="selectidcuentacorreo_ajax" class="col-sm-2 control-label">Cuenta de correo asignada:</label>
                    <div class="col-sm-2">
                      <select id="idcuentacorreo_ajax" name="idcuentacorreo" class="form-control">
                      </select>
                    </div> 
                </div>
				<div class="form-group ">
                	<label for="x" class="col-sm-2 control-label">Archivo de firma:</label>
                    <div class="col-sm-2">
                    	<div class="input-group">
                            <input type="file" name="archivofirmaI" style="display:none;" id="carchivofirmaI" accept=".jpg" onChange="fileinput('archivofirma')"/>
                            <input value="<?php echo $archivofirma; ?>" type="text" name="archivofirma" id="carchivofirma" class="form-control" placeholder="Seleccionar Imagen" readonly >
                            <input value="<?php echo $archivofirma; ?>" type="hidden" name="archivofirmaEliminacion" id="carchivofirmaEliminacion" >
							<span class="input-group-btn">
                                <a class="btn btn-success" onclick="$('#carchivofirmaI').click();">&nbsp;&nbsp;&nbsp;Seleccionar Imagen</a>
                            </span>
                    	</div>        
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
				  <input name="idsucursal" type="hidden" id="cidsucursal" value="<?php echo $id;?>"/>
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
				var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombre", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vcalle", "none", {validateOn:["blur"],  maxChars:150,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vcp", "none", {validateOn:["blur"],  maxChars:5,  minChars:5});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("Vtelefonocontacto", "none", {validateOn:["blur"],  maxChars:50});
				var sprytextfield5 = new Spry.Widget.ValidationTextField("Vserie", "none", {validateOn:["blur"],  maxChars:20,  minChars:1});
				
</script>
</body>
</html>