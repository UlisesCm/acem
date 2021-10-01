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
          <h1>Cliente<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo cliente</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['clientes']['guardar']) or  !isset($_SESSION['permisos']['clientes']['acceso'])){
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
            <div class="box box-info" style="border-color:#3d7698">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
				<div class="form-group ">
                    <label for="crfc" class="col-sm-2 control-label">RFC:</label>
                    <div class="col-sm-5">
                    	
                        
					<input value="" name="rfc" type="text" class="form-control" id="autorfc" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cnombre" class="col-sm-2 control-label">Nombre:</label>
                    <div class="col-sm-5">
                    	
                        
					<input value="" name="nombre" type="text" class="form-control" id="autonombre" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cnic" class="col-sm-2 control-label">NIC:</label>
                    <div class="col-sm-5">
                    	
                        
					<input value="" name="nic" type="text" class="form-control" id="autonic" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="climitecredito" class="col-sm-2 control-label">Limite de crédito:</label>
                    <div class="col-sm-3">
                    	
                        <input value="0" name="limitecredito" type="text" value="0" class="form-control" id="climitecredito" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="cdiascredito" class="col-sm-2 control-label">Días de crédito</label>
                    <div class="col-sm-3">
                    	
                        <input value="0" name="diascredito" type="text" value="0"  class="form-control" id="cdiascredito" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="csaldo" class="col-sm-2 control-label">Saldo:</label>
                    <div class="col-sm-5">
                    	
                        <input value="0" name="saldo" type="hidden" class="form-control" id="csaldo" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cnombrecontacto" class="col-sm-2 control-label">Nombre de contacto:</label>
                    <div class="col-sm-5">
                    	<span id="Vnombrecontacto">
                        <input value="" name="nombrecontacto" type="text" class="form-control" id="cnombrecontacto" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="ccorreocontacto" class="col-sm-2 control-label">Correo contacto:</label>
                    <div class="col-sm-5">
                    	<span id="Vcorreocontacto">
                        <input value="" name="correocontacto" type="text" class="form-control" id="ccorreocontacto" />
            			<span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="ctelefonocontacto" class="col-sm-2 control-label">Teléfono de contacto:</label>
                    <div class="col-sm-5">
                    	<span id="Vtelefonocontacto">
                        <input value="" name="telefonocontacto" type="text" class="form-control" id="ctelefonocontacto" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                    	<label>
                  			<input id="cautorizardosis" type="checkbox" name="autorizardosis" value="SI" >
                  			Autorizar dosis
                 		</label>
                    </div>
                </div>
				<div class="form-group hide">
                    <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                    	<label>
                  			<input id="cautorizarproductos" type="checkbox" name="autorizarproductos" value="SI" >
                  			Autorizar productos
                 		</label>
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
  					<i class="fa fa-cog fa-spin" style="color:#3d7698"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
</script>

</body>
</html>