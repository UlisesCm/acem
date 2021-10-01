<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");

?>
<!DOCTYPE html>
<html>
<head>
<?php include ("../../../componentes/cabecera.php")?>
<link rel="stylesheet" href="../../../dist/css/jtree/style.min.css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script>
<script src="../../../librerias/js/jstree.min.js"></script>
<script src="../../../librerias/js/cookies.js"></script>
<script src="../../../librerias/js/validaciones.js"></script>
<script src="../../../librerias/js/jquery.form.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#submitButton').click(function () {
    	    $('#uploadForm').ajaxForm({
    	        target: '#salidaImagen',
    	        url: 'CargarArchivos.php',
    	        beforeSubmit: function () {
    	        	  $("#salidaImagen").hide();
    	        	   if($("#uploadImage").val() == "") {
    	        		   $("#salidaImagen").show();
    	        		   $("#salidaImagen").html("<div class='error'>Elige un archivo para subir.</div>");
                    return false; 
                }
    	            $("#progressDivId").css("display", "block");
    	            var percentValue = '0%';

    	            $('#progressBar').width(percentValue);
    	            $('#percent').html(percentValue);
    	        },
    	        uploadProgress: function (event, position, total, percentComplete) {

    	            var percentValue = percentComplete + '%';
    	            $("#progressBar").animate({
    	                width: '' + percentValue + ''
    	            }, {
    	                duration: 100,
    	                easing: "linear",
    	                step: function (x) {
                        percentText = Math.round(x * 100 / percentComplete);
    	                    $("#percent").text(percentText + "%");
                        if(percentText == "100") {
                        	   $("#salidaImagen").show();
                        }
    	                }
    	            });
    	        },
    	        error: function (response, status, e) {
    	            alert('Ha ocurrido un error durante el proceso de importación. Verifique que el formato del archivo sea correcto e intente nuevamente');
    	        },
    	        
    	        complete: function (xhr) {
    	            if (xhr.responseText && xhr.responseText != "error")
    	            {
    	            	  $("#salidaImagen").html(xhr.responseText);
						  $("#progressBar").width(0);
    	            	  $('#percent').html("0%");
						  $("#lcargando").show();
    	            }
    	            else{  
    	               	$("#salidaImagen").show();
        	            	$("#salidaImagen").html("<div class='error'>Problema al cargar el archivo.</div>");
        	            	$("#progressBar").stop();
    	            }
    	        }
    	    });
    });
});
</script>
<?php 
	if (isset($_GET['busqueda'])){
		echo "<script>
		var busqueda='".$_GET['busqueda']."';
		</script>";
	}else{
		echo '<script>var busqueda="";</script>';
	}
	if (isset($_GET['papelera'])){
		echo '<script>var papelera="si";</script>';
	}else{
		echo '<script>var papelera="no";</script>';
	}
?>
</head>
<body class="sidebar-mini <?php include("../../../componentes/skin.php");?>">
	<!-- Wrapper es el contenedor principal -->
    <div class="wrapper s">
      
      <?php include("../../../componentes/menuSuperior.php");?>
      <?php include("../../../componentes/menuLateral.php");?>
      <!-- Contenido-->
      <div class="content-wrapper">
        <!-- Contenido de la cabecera -->
        <section class="content-header">
          <h1>Listas de precios<small> Consulta</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Consultar listaprecios</a></li>
          </ol>
        </section>
        
        <form class="form-horizontal" name="formularioFamilias" id="formularioFamilias" method="post">
        <div class="modal fade" id="modal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="tituloModal">Actualizar Precios por Familias</h3>
              </div>
              <div class="modal-body" id="contenidoModal">
              
                 <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alerta!</h4>
                    Las acciones que realice no podrán ser reversibles. Use esta herramienta bajo su responabilidad. Los precios se actualizarán según la familia que seleccione y todos los productos de las familias hijas también se verán afectados. El precio antes de impuestos se calculará de acuerdo al porcentaje de ganancia especificado y se aplicará al costo del producto.
                 </div>
                 
                 <div id="arbol_ajax" style="max-height:400px; overflow:scroll"></div>
                 </br>
                 <div class="row">
                    <div class="form-group ">
                        <label for="cidmovimiento" class="col-sm-3 control-label">Porcetaje de ganancia:</label>
                        <div class="col-sm-2">
                            <input value="" name="familia" type="hidden" class="form-control" id="familia">
                            <input value="" name="idfamilia" type="hidden" class="form-control" id="cidfamilia">
                            <input name="idlista" type="hidden" id="cidlista" value="<?php echo $id;?>"/>
                            <input value="" name="porcentaje" type="text" class="form-control" id="cporcentaje">
                        </div>
                        <div class="col-sm-5">
                        	<div id="loading2" class="overlay" style="display:none">
  								<i class="fa fa-cog fa-spin" style="color:#ffaf09"></i> Espere mientras se actualiza la lista de precios...
			  				</div>
                            <button type="button" class="btn btn-success" id="botonActualizarPrecios">Actualizar Precios</button>
                        </div>
                    </div>
                </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        </form>
        
        
        
        
        
        
        <div class="modal fade" id="modal2">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  	<span aria-hidden="true">&times;</span></button>
                	<h3 class="modal-title" id="tituloModal"><i class="fa fa-file-excel-o text-green"></i> Cargar listas de precios</h3>
              </div>
              <div class="modal-body" id="contenidoModal">
              
                 <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alerta!</h4>
                    Las acciones que realice no podrán ser reversibles. Use esta herramienta bajo su responabilidad.
                 </div>
                 
                 </br>
                 <div class="row">
                 	<div class="col-md-12">
                        <div class="form-container"> 
                          <form class="form-inline"  id="uploadForm" name="frmupload" method="post" enctype="multipart/form-data">
                            <div class="form-group mx-sm-3 mb-2">
                              <input type="file" id="uploadImage" name="uploadImage" />
                              <input name="idlista" type="hidden" id="cidlista" value="<?php echo $id;?>"/>
                            </div>
                            <button id="submitButton" type="submit" class="btn btn-primary mb-2" name='btnSubmit'>Cargar archivo</button>
                          </form>
                          </br>
                          <div class='progress' id="progressDivId">
                            <div class='progress-bar' id='progressBar'></div>
                            <div class='percent' id='percent'>0%</div>
                          </div>
                          <div style="height: 10px;"></div>
                          <div id='salidaImagen'></div>
                        </div> <!-- Fin Form-container -->
                    </div> 
                    
                    <div class="col-md-12" style="display:none" id="lcargando">
                        <span><i class="fa fa-refresh fa-spin text-green fa-2x"></i>&nbsp; Importando registros, este proceso puede durar varios minutos, espere por favor.</span>
                    </div>    
                </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      
        
        
		
		<!-- Contenido principal -->
        <section class="content">
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['listasprecios']['modificar']) or  !isset($_SESSION['permisos']['listasprecios']['acceso'])){
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
			
			<?php $herramientas="consultar"; include("../componentes/herramientas3.php"); ?>
        	<?php include("../../../componentes/avisos.php");?>
          	<!-- Horizontal Form -->
            <div class="box box-info" style="border-color:#4232cd">
              <div class="box-header with-border">
                <h3 class="box-title"><?php echo $nombre?></h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group hide">
                    <label for="cnombre" class="col-sm-2 control-label">Nombre de la lista:</label>
                    <div class="col-sm-5">
                    	<span id="Vnombre">
                        <input value="<?php echo $nombre; ?>" name="nombre" type="text" class="form-control" id="cnombre" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $estatus; ?>" name="estatus" type="hidden" class="form-control" id="cestatus" />
            			
						
                    </div>
                </div>

              
              
              	<input name="idlistaprecios" type="hidden" id="cidlistaprecios" value="<?php echo $id;?>"/>
              	<div id="muestra_contenido_ajax" style="min-height:100px;">
            	</div><!-- /din contenido ajax -->
              
              </form>  
              </div><!-- /.box-body -->
                
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#4232cd"></i>
			  </div>
              
            </div><!-- /.box -->
			
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>