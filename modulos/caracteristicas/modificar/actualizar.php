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
          <h1>Caracteristicas<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar caracteristica</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['caracteristicas']['modificar']) or  !isset($_SESSION['permisos']['caracteristicas']['acceso'])){
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
            <div class="box box-info" style="border-color:#e41d36">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group ">
                  	<label for="ccaracteristica" class="col-sm-2 control-label">Caracteristica:</label>
                    <div class="col-sm-3">
                    	<select id="ccaracteristica" name="caracteristica" class="form-control">
										<option value="espesor" <?php 
											if ($caracteristica=="espesor"){
												echo 'selected="selected"';
											}
											 ?>>Espesor</option>
										
										<option value="ancho" <?php 
											if ($caracteristica=="ancho"){
												echo 'selected="selected"';
											}
											 ?>>Ancho</option>
										
										<option value="color" <?php 
											if ($caracteristica=="color"){
												echo 'selected="selected"';
											}
											 ?>>Color</option>
										
										<option value="diametro" <?php 
											if ($caracteristica=="diametro"){
												echo 'selected="selected"';
											}
											 ?>>Diametro</option>
										
										<option value="lado" <?php 
											if ($caracteristica=="lado"){
												echo 'selected="selected"';
											}
											 ?>>Lado</option>
										
										<option value="alto" <?php 
											if ($caracteristica=="alto"){
												echo 'selected="selected"';
											}
											 ?>>Alto</option>
										
										<option value="largo" <?php 
											if ($caracteristica=="largo"){
												echo 'selected="selected"';
											}
											 ?>>Largo</option>
                                        <option value="tipo" <?php 
											if ($caracteristica=="tipo"){
												echo 'selected="selected"';
											}
											 ?>>Tipo</option>
                                        <option value="marca" <?php 
											if ($caracteristica=="marca"){
												echo 'selected="selected"';
											}
											 ?>>Marca</option>
                                        <option value="aplicacion" <?php 
											if ($caracteristica=="aplicacion"){
												echo 'selected="selected"';
											}
											 ?>>Aplicacion</option>
                                             
                                        
										
						</select>
                    </div> 
					
                </div>
				<div class="form-group ">
                    <label for="cvalor" class="col-sm-2 control-label">Valor:</label>
                    <div class="col-sm-3">
                    	<span id="Vvalor">
                        <input value="<?php echo $valor; ?>" name="valor" type="text" class="form-control" id="cvalor" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
					
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="idcaracteristica" type="hidden" id="cidcaracteristica" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#e41d36"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vvalor", "none", {validateOn:["blur"],  maxChars:30,  minChars:1});
				var sprytextfield1 = new Spry.Widget.ValidationTextField("Vvalor", "none", {validateOn:["blur"],  maxChars:30,  minChars:1});
				
</script>
</body>
</html>