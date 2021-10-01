<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
<head>
<?php include ("../../../componentes/cabecera.php")?>
 <link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script>
<script src="../../../librerias/js/jquery-ui.js"></script>
<script src="../../../librerias/js/cookies.js"></script>
<script src="../../../librerias/js/validaciones.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgklWcfzgoPJ2RSW3t2MCuaq1pTXd0qIo&callback=initMapRuta"></script>
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
	
	echo '<script>var idsucursalseleccionada="'.$_SESSION['idsucursal'].'";</script>';
	echo '<script>var coordenadassucursal="'.$_SESSION['coordenadassucursal'].'";</script>';
?>
</head>
<body class="sidebar-mini <?php include("../../../componentes/skin.php");?>">
	<!-- Wrapper es el contenedor principal -->
    <div class="wrapper s">
      
      <?php include("../../../componentes/menuSuperior.php");?>
      <?php include("../../../componentes/menuLateral.php");?>
        <?php include ("../../../componentes/modalMap.php");?>
      <!-- Contenido-->
      <div class="content-wrapper">
        <!-- Contenido de la cabecera -->
        <section class="content-header">
          <h1>Rutas<small> Nueva</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Consultar cotizacionproducto</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesproductos']['consultar']) or  !isset($_SESSION['permisos']['cotizacionesproductos']['acceso'])){
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
			
			<?php $herramientas="consultar"; include("../componentes/herramientas.php"); ?>
        	<?php include("../../../componentes/avisos.php");?>
            
             <!-- Herramientas de filtrado-->
            <!-- Horizontal Form -->
            
            
            <div class="box box-info" style="border-color:#13A44D">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-filter text-green"></i> Datos principales</h3>
                 <label class= "label pull-right bg-red" style="margin-left:10px;">Folio: <span id="lserie"> </span>-<span id="lfolio"></span></label>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
                	<div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;">
                     <input value="" name="coordenadas" type="hidden" class="form-control" id="ccoordenadas" readonly/>
                      
                      <div class="form-group hide">
                    	<label for="cserie" class="col-sm-2 control-label">Serie:</label>
                            <div class="col-sm-2">
                                <span id="Vserie">
                                <input value="" name="serie" type="text" class="form-control" id="cserie" />
                            </span>
                            </div>
                        </div>
                   
                        <div class="form-group hide">
                            <label for="cfolio" class="col-sm-2 control-label">Folio:</label>
                            <div class="col-sm-2">
                                <span id="Vfolio">
                                <input value="" name="folio" type="text" class="form-control" id="cfolio" />
                            </span>
                            </div>
                        </div>
                    	
                        <div class="form-group ">
                            <label for="cfecha" class="col-sm-2 control-label">Fecha:</label>
                            <div class="col-sm-4">
                                
                                <input value="<?php echo date('Y-m-d'); ?>" name="fecha" type="date" required class="form-control" id="cfecha" />
                                
                                
                            </div>
                        </div>
                
                        <div class="form-group ">
                            <label for="selectidempleado_ajax" class="col-sm-2 control-label">Chofer:</label>
                            <div class="col-sm-4">
                              <select id="idempleado_ajax" name="idempleado" class="form-control">
                              </select>
                            </div> 
                             <input type="hidden" id="capacidaddeCarga">
                             <input type="hidden" id="nombrevehiculo">
                        </div>
                        
                        <div class="form-group " >
                                <label for="selectzona_ajax" class="col-sm-2 control-label">Zona:</label>
                                <div class="col-sm-4">
                                  <select id="idzona_ajax" name="idzonaruta" class="form-control">
                                  </select>
                                </div> 
                            </div>
                        
                         <div class="form-group ">
                            <label for="nombreruta" class="col-sm-2 control-label">Nombre de la ruta:</label>
                            <div class="col-sm-4">
                              <input id="nombreruta" name="nombre" class="form-control">
                              </input>
                            </div> 
                        </div>
                        
                        <div class="form-group ">
                            <label for="observacionesruta" class="col-sm-2 control-label">Observaciones:</label>
                            <div class="col-sm-4">
                              <input id="observacionesruta" name="observacionesruta" class="form-control">
                              </input>
                            </div> 
                        </div>
                        
                	</div><!-- /.Fin row -->
                    
				</div><!-- /.box-body -->
                <div class="box-footer">
                
				  
                  
                </div><!-- /.box-footer -->
                
             
              
            </div><!-- /.box -->
            <!-- Fin Herramientas de filtrado>
            
            
          	<!-- box -->
            <div class="box box-info" style="border-color:#649ad0">
            	<div class="box-header with-border">
                	<h3 class="box-title">Ventas pendientes de envío</h3>
              	</div><!-- /.box-header -->
                <div id="muestra_contenido_ajax" style="min-height:100px;">
            	</div><!-- /din contenido ajax -->
                <div id="loading" class="overlay">
  					<i class="fa fa-cog fa-spin" style="color:#649ad0"></i>
			  	</div>
                 <div id="salida"></div>
            </div><!-- Fin box>
            
            <!-- box -->
            <div class="box box-info" style="border-color:#25c274">
            	<div class="box-header with-border">
                	<h3 class="box-title">Ruta <input type="hidden" id="listaSalida" name="listaSalida"> <input type="hidden" id="listaSalidaOptima" name="listaSalidaOptima"> <input type="hidden" id="listaSalidaCoordenadas" name="listaSalidaCoordenadas"> <input type="hidden" id="tipoRuta" name="tipoRuta"></h3>
              	</div><!-- /.box-header -->
                <div style="min-height:100px;"> <!-- lista dragable -->
                
                	<table id="tablaOrden" class="table table-hover table-bordered">
                    	<tbody class="handle ui-sortable-handle" id="filas">
                    	</tbody>
                	</table>
                
            	</div><!-- /fin lista dragable -->
                <div class="box-footer">
                        	<div class="row filaEspecial">
                                <div class="col-sm-12">
                                    <div class="form-group ">
                                        <button  type="button" class="btn btn-primary pull-right" id="botonGenerarRutaTabla"><i class="fa fa-location-arrow"></i>&nbsp;&nbsp;&nbsp;Generar ruta</button>
                                        <!--<button  type="hidden" class="btn btn-primary pull-right" id="botonGenerarRutaDistancia"><i class="fa fa-rocket"></i>&nbsp;&nbsp;&nbsp;Ruta óptima</button>-->
                                     </div>
                                </div>
                            </div><!-- /filaespecial-->
                		</div>
            </div><!-- Fin box-->
            
       <div class="row">
        <!-- Left col -->
        <div class="col-md-4">
                 <!-- box -->
                <div class="box box-info" style="border-color:#A46BD1">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos de la ruta</h3>
                    </div><!-- /.box-header -->
                    <div style="min-height:100px;"> <!-- div -->
                        <div id="infoBoxCarga" class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-truck"></i></span>
                            <div class="info-box-content">
                                <span id="SpanNombreVehiculo" class="info-box-text">Vehículo...</span>
                                <span id="SpanCapacidaddeCarga" class="info-box-number">Capacidad: 0.0 Kg.</span>
                                <div class="progress">
                                    <div id="SpanProgressBar" class="progress-bar" style="width: 0%"></div>
                                </div>
                                <span id="SpanTotalKG" class="progress-description">
                                    Total cargado: 0.0 KG
                                </span>
                            </div>
                        </div><!-- /.fin de objeto -->
                        
                      
                      <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>
            
                        <div class="info-box-content">
                          <span class="info-box-text">Total</span>
                          <span id="SpanTotalDinero" class="info-box-number">$0.00</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                      
                      <div class="info-box">
                        <span class="info-box-icon bg-purple"><i class="fa  fa-tachometer"></i></span>
            
                        <div class="info-box-content">
                          <span class="info-box-text">Kilometros de ruta</span>
                          <span class="info-box-number" id="kilometrosRuta">0.0</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                      
                       <div class="info-box">
                        <span class="info-box-icon bg-black"><i class="fa  fa-clock-o"></i></span>
            
                        <div class="info-box-content">
                          <span class="info-box-text">Tiempo</span>
                          <span class="info-box-number" id="tiempoRuta">00:00 Hrs</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    
                    </div><!-- /fin div -->
                </div><!-- Fin box-->
            </div><!-- /fin col -->
            
            
            
            <div class="col-md-8">
                 <!-- box -->
                <div class="box box-info" style="border-color:#A46BD1">
                    <div class="box-header with-border">
                        <h3 class="box-title">Mapa</h3>
                    </div><!-- /.box-header -->
                    <div style="min-height:100px;"> <!-- mapa -->
                    
                    	<div id="mapaRuta" style=" width:100%; height:400px;"></div>
                    
                    </div><!-- /fin mapa-->
                    <div class="box-footer">
                        	<div class="row filaEspecial">
                                <div class="col-sm-12">
                                    <div class="form-group ">
                                        <button type="button" class="btn btn-success pull-right" id="botonAceptar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Aceptar</button>
                                     </div>
                                </div>
                            </div><!-- /filaespecial-->
                		</div>
                </div><!-- Fin box-->
                
            </div><!-- /fin col -->
              
          </div><!-- Fin de row -->
            </form>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>