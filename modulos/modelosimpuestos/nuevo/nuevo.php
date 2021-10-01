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
          <h1>Modelo de impuestos<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo modelo de impuestos</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['modelosimpuestos']['guardar']) or  !isset($_SESSION['permisos']['modelosimpuestos']['acceso'])){
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
            <div class="box box-info" style="border-color:#aa282c">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
				<div class="form-group ">
                    <label for="cnombre" class="col-sm-2 control-label">Nombre del modelo:</label>
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
                    <label for="cfechaactualizacion" class="col-sm-2 control-label">Última actualización:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo date('Y-m-d'); ?>" name="fechaactualizacion" type="date" required class="form-control" id="cfechaactualizacion" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                    	
                        <input value="activo" name="estatus" type="hidden" class="form-control" id="cestatus" />
            			
						
                    </div>
                </div>
                
                
                
                <!-- Agregar a tabla --> 
                <div class="EB tablita">
                <div class="box-header with-border">
                	<h3 class="box-title">Tabla de impuestos</h3>
              	</div><!-- /.box-header -->
                    
                <div class='row' style="padding:20px; margin-top:0px;">
                    <div class='col-sm-3'>    
                        <div class="form-group">
                        	<label for="ctipo">Tipo de impuesto:</label>
                        	<select id="ctipo" name="tipo" class="form-control">
                            	<option value="RETENCION">RETENCIÓN</option>
                            	<option value="TRASLADO" selected>TRASLADO</option>
                        	</select>
                    	</div>
                    </div>
                    <div class='col-sm-3'>    
                        <div class="form-group">
                        	<label for="cimpuesto">Impuesto:</label>
                        	<select id="cimpuesto" name="impuesto" class="form-control">
                            	<option value="002" selected>IVA</option>
                            	<option value="003">IEPS</option>
                                <option value="001">ISR</option>
                        	</select>
                    	</div>
                    </div>
                    
                    <div class='col-sm-3'>    
                        <div class="form-group">
                        	<label for="cfactor">Factor:</label>
                        	<select id="cfactor" name="factor" class="form-control">
                            	<option value="Tasa" selected>TASA</option>
                            	<option value="Cuota">CUOTA</option>
                                <option value="Exento">EXENTO</option>
                        	</select>
                    	</div>
                    </div>
                    
                    <div class='col-sm-2'>
                        <div class='form-group'>
                            <label for="cvalor">Valor del factor</label>
                            <input value="0" name="valor" type="text" class="form-control" id="cvalor"/>
                        </div>
                    </div>
                    
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="botonAgregarFila">&nbsp;</label>
                            <input value="" name="listaSalida" type="hidden" id="listaSalida"/>
                            <input type="button" value="Agregar" class="form-control btn btn-success" id="botonAgregarFila"/>
                        </div>
                    </div>
                </div>
                <!-- Fin Agregar a tabla --> 
                <!-- Tabla --> 
                <div class="box-body table-responsive no-padding">
                    <table id="tablaSalida" class="table table-hover table-bordered">
                        <thead>
                            <tr style="background:#F3F3F3; color:#666; height:30px; border:1px" align="center">
                                <td width="80" style='display:none'>No.</td>
                                <td width="100">Clave</td>
                                <td width="100">Impuesto</td>
                                <td width="200">Tipo</td>
                                <td width="100">Factor</td>
                                <td width="100">Valor</td>
                                <td width="30" align="center"></td>
                            </tr>
                        </thead>
                        <tbody id="filas" style="background:#FFF; border:1px #666 solid;" align="center">
                        </tbody>
                    </table>
                </div>
                </div>
                <!-- Fina Tabla --> 
                
                
                
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#aa282c"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombre", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
				
</script>

</body>
</html>