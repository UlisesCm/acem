<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script><script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextarea.js" type="text/javascript"></script>
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
          <h1>Bitacora Vehicular<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo Bitacora vehicular</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoravehicular']['guardar']) or  !isset($_SESSION['permisos']['bitacoravehicular']['acceso'])){
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
			  <form class="form-horizontal" name="formulario" id="formulario" method="post" enctype="multipart/form-data">
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
                            <option value="0">SELECCIONE CATEGORIA...</option>
							<option value="MANTENIMIENTOS">MANTENIMIENTOS</option>
							<option value="SEGUROS">SEGUROS</option>
							<option value="COMBUSTIBLES">COMBUSTIBLES</option>
							<option value="PAGO DE CUOTAS">PAGO DE CUOTAS</option>
							<option value="OTROS">OTROS</option>
						</select>
                    </div> 
                </div>
				<div class="form-group panelFecha" style="display:none;">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo date('Y-m-d'); ?>" name="fecha" type="date" required class="form-control" id="cfecha" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group panelDescripcion" style="display:none;">
                    <label for="cdescripcion" class="col-sm-2 control-label">Descripción:</label>
                    <div class="col-sm-5">
                    	<span id="Vdescripcion">
                        <textarea name="descripcion" id="cdescripcion" class="form-control"></textarea>
            			<span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textareaRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group panelCombustible" style="display:none;">
                  	<label for="ctipocombustible" class="col-sm-2 control-label">Tipo de combustible:</label>
                    <div class="col-sm-5">
                    	<select id="ctipocombustible" name="tipocombustible" class="form-control">
							<option value="MAGNA">MAGNA</option>
							<option value="PREMIUM">PREMIUM</option>
							<option value="DIESEL">DIESEL</option>
						</select>
                    </div> 
                </div>
				
				<div class="form-group panelLitros" style="display:none;">
                    <label for="clitros" class="col-sm-2 control-label">Litros:</label>
                    <div class="col-sm-2">
                    	
                        <input value="" name="litros" type="text" class="form-control" id="clitros" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group panelKilometraje" style="display:none;">
                    <label for="ckilometraje" class="col-sm-2 control-label">Kilometraje:</label>
                    <div class="col-sm-3">
                    	
                        <input value="" name="kilometraje" type="text" class="form-control" id="ckilometraje" />
            			
						
                    </div>
                </div>
			
				<div class="form-group panelArchivo" style="display:none;">
                	<label for="x" class="col-sm-2 control-label">Archivo:</label>
                    <div class="col-sm-5">
                    	<div class="input-group">
                            <input type="file" name="archivo" style="display:none;" id="carchivo" accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.txt,.pdf,.zip,.rar" onChange="fileinput('archivo')"/>
                            <input type="text" name="narchivo" id="narchivo" class="form-control" placeholder="Seleccionar Archivo" disabled="disabled">
                            <span class="input-group-btn">
                                <a class="btn btn-warning" onclick="$('#carchivo').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
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
                
                <div class="box-footer">
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#72ca68"></i>
			  </div>
              <div id="Salida"></div>
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">

				
</script>

</body>
</html>