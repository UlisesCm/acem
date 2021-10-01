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
          <h1>Cuentas de Correo<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo Cuenta correo</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentascorreo']['guardar']) or  !isset($_SESSION['permisos']['cuentascorreo']['acceso'])){
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
            <div class="box box-info" style="border-color:#314ba6">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
				<div class="form-group ">
                    <label for="cusuario" class="col-sm-2 control-label">Usuario:</label>
                    <div class="col-sm-3">
                    	<span id="Vusuario">
                        <input value="" name="usuario" type="text" class="form-control" id="cusuario" />
            			<span class="textfieldInvalidFormatMsg">Formato no válido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="ccontrasena" class="col-sm-2 control-label">Contraseña:</label>
                    <div class="col-sm-3">
                    	<span id="Vcontrasena">
                        <input value="" name="contrasena" type="password" class="form-control" id="ccontrasena" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cservidorsmtp" class="col-sm-2 control-label">Servidor SMTP:</label>
                    <div class="col-sm-3">
                    	<span id="Vservidorsmtp">
                        <input value="" name="servidorsmtp" type="text" class="form-control" id="cservidorsmtp" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cservidorpop" class="col-sm-2 control-label">Servidor POP:</label>
                    <div class="col-sm-3">
                    	<span id="Vservidorpop">
                        <input value="" name="servidorpop" type="text" class="form-control" id="cservidorpop" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cpuertosmtp" class="col-sm-2 control-label">Puerto SMTP:</label>
                    <div class="col-sm-2">
                    	
                        <input value="" name="puertosmtp" type="text" class="form-control" id="cpuertosmtp" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cpuertopop" class="col-sm-2 control-label">Puerto POP:</label>
                    <div class="col-sm-2">
                    	
                        <input value="" name="puertopop" type="text" class="form-control" id="cpuertopop" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                    	<label>
                  			<input id="cautenticacionssl" type="checkbox" name="autenticacionssl" value="si" checked="checked">
                  			Requiere conexión segura (SSL)
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
  					<i class="fa fa-cog fa-spin" style="color:#314ba6"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">

var sprytextfield1 = new Spry.Widget.ValidationTextField("Vusuario", "email", {validateOn:["blur"]});
				var sprytextfield2 = new Spry.Widget.ValidationTextField("Vcontrasena", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
				var sprytextfield3 = new Spry.Widget.ValidationTextField("Vservidorsmtp", "none", {validateOn:["blur"],  maxChars:100,  minChars:3});
				var sprytextfield4 = new Spry.Widget.ValidationTextField("Vservidorpop", "none", {validateOn:["blur"],  maxChars:100,  minChars:3});
				
</script>

</body>
</html>