<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextarea.css" rel="stylesheet" type="text/css" /><link href="../../../librerias/js/Spry/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script>

<script><?php echo "var idvehiculoSeleccionado='$idvehiculo';";?></script>

<script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextarea.js" type="text/javascript"></script>
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
          <h1>Bitacoravehicular<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar bitacoravehicular</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoravehicular']['modificar']) or  !isset($_SESSION['permisos']['bitacoravehicular']['acceso'])){
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
            <div class="box box-info" style="border-color:#72ca68">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
                <div class="box-body">
				<div class="form-group ">
                  	<label for="selectidvehiculo_ajax" class="col-sm-2 control-label">Vehículo:</label>
                    <div class="col-sm-5">
                      <select id="idvehiculo_ajax" name="idvehiculo" class="form-control">
                      </select>
                    </div> 
                </div>
				<div class="form-group ">
                  	<label for="ccategoria" class="col-sm-2 control-label">Categoria:</label>
                    <div class="col-sm-5">
                    	<select id="ccategoria" name="categoria" class="form-control">
										<option value="MANTENIMIENTOS" <?php 
											if ($categoria=="MANTENIMIENTOS"){
												echo 'selected="selected"';
											}
											 ?>>MANTENIMIENTOS</option>
										
										<option value="SEGUROS" <?php 
											if ($categoria=="SEGUROS"){
												echo 'selected="selected"';
											}
											 ?>>SEGUROS</option>
										
										<option value="COMBUSTIBLES" <?php 
											if ($categoria=="COMBUSTIBLES"){
												echo 'selected="selected"';
											}
											 ?>>COMBUSTIBLES</option>
										
										<option value="PAGO DE CUOTAS" <?php 
											if ($categoria=="PAGO DE CUOTAS"){
												echo 'selected="selected"';
											}
											 ?>>PAGO DE CUOTAS</option>
										
										<option value="OTROS" <?php 
											if ($categoria=="OTROS"){
												echo 'selected="selected"';
											}
											 ?>>OTROS</option>
										
						</select>
                    </div> 
                </div>
				<div class="form-group ">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $fecha; ?>" name="fecha" type="date" required="required" class="form-control" id="cfecha" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cdescripcion" class="col-sm-2 control-label">Descripción:</label>
                    <div class="col-sm-5">
                    	<span id="Vdescripcion">
                        <textarea name="descripcion" id="cdescripcion" class="form-control"><?php echo $descripcion; ?></textarea>
            			<span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textareaRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="ctipocombustible" class="col-sm-2 control-label">Tipo de combustible:</label>
                    <div class="col-sm-5">
                    	<select id="ctipocombustible" name="tipocombustible" class="form-control">
										<option value="MAGNA" <?php 
											if ($tipocombustible=="MAGNA"){
												echo 'selected="selected"';
											}
											 ?>>MAGNA</option>
										
										<option value="PREMIUM" <?php 
											if ($tipocombustible=="PREMIUM"){
												echo 'selected="selected"';
											}
											 ?>>PREMIUM</option>
										
										<option value="DIESEL" <?php 
											if ($tipocombustible=="DIESEL"){
												echo 'selected="selected"';
											}
											 ?>>DIESEL</option>
										
						</select>
                    </div> 
                </div>
				<div class="form-group ">
                    <label for="clitros" class="col-sm-2 control-label">Litros:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $litros; ?>" name="litros" type="text" class="form-control" id="clitros" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="ckilometraje" class="col-sm-2 control-label">Kilometraje:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $kilometraje; ?>" name="kilometraje" type="text" class="form-control" id="ckilometraje" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                	<label for="x" class="col-sm-2 control-label">Archivo:</label>
                    <div class="col-sm-3">
                    	<div class="input-group">
                            <input type="file" name="archivoI" style="display:none;" id="carchivoI" accept=".jpg" onChange="fileinput('archivo')"/>
                            <input value="<?php echo $archivo; ?>" type="text" name="archivo" id="carchivo" class="form-control" placeholder="Seleccionar Archivo" readonly >
                            <input value="<?php echo $archivo; ?>" type="hidden" name="archivoEliminacion" id="carchivoEliminacion" >
							<span class="input-group-btn">
                                <a class="btn btn-warning" onclick="$('#carchivoI').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
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
				  <input name="idbitacoravehicular" type="hidden" id="cidbitacoravehicular" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#72ca68"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("Vdescripcion",  { maxChars:255,  minChars:1});
				var sprytextarea1 = new Spry.Widget.ValidationTextarea("Vdescripcion",  { maxChars:255,  minChars:1});
				
</script>
</body>
</html>