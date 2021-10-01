<?php 
include ("../../seguridad/comprobar_login.php");
if (isset($_POST["idcliente"]) and isset($_POST["nombre"])){
	$idcliente=$_POST["idcliente"];
	$nombre=$_POST["nombre"];
}else{
	header("Location: nuevo.php");
}
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
          <h1>Contacto<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo contacto</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['contactos']['guardar']) or  !isset($_SESSION['permisos']['contactos']['acceso'])){
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
            <div class="box box-info" style="border-color:#ec8800">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
				<div class="form-group ">
                    <label for="cidcliente" class="col-sm-2 control-label">Cliente:</label>
                    <div class="col-sm-5">
                    	
                        
					<input value="<?php echo $idcliente;?>" name="idcliente" type="hidden" class="normal" id="cidcliente" style="width:50px;" />
					<input value="" name="consultaidcliente" type="hidden" class="normal" id="consultaidcliente" style="width:100px;"/>
					<input value="<?php echo $nombre?>" name="autoidcliente" type="text" class="form-control" id="autoidcliente" readonly/>
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cnombrecontacto" class="col-sm-2 control-label">Nombre del contacto:</label>
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
                    <label for="ctelefono" class="col-sm-2 control-label">Teléfono:</label>
                    <div class="col-sm-3">
                    	
                        <input value="" name="telefono" type="text" class="form-control" id="ctelefono" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cemail" class="col-sm-2 control-label">Email:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="email" type="text" class="form-control" id="cemail" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cdepartamento" class="col-sm-2 control-label">Departamento asignado:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="departamento" type="text" class="form-control" id="cdepartamento" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="ccomentarios" class="col-sm-2 control-label">Comentarios:</label>
                    <div class="col-sm-7">
                    	
                        <textarea name="comentarios" id="ccomentarios" class="form-control"></textarea>
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#ec8800"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombrecontacto", "none", {validateOn:["blur"],  maxChars:200,  minChars:1});
				
</script>

</body>
</html>