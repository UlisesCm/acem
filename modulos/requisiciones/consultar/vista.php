<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
<head>
<?php include ("../../../componentes/cabecera.php")?>
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script>
<script src="../../../librerias/js/cookies.js"></script>
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
?>
<body class="sidebar-mini <?php include("../../../componentes/skin.php");?>">
	<!-- Wrapper es el contenedor principal -->
    <div class="wrapper s">
      
      <?php include("../../../componentes/menuSuperior.php");?>
      <?php include("../../../componentes/menuLateral.php");?>
      <!-- Contenido-->
      <div class="content-wrapper">
        <!-- Contenido de la cabecera -->
        <section class="content-header">
          <h1>Requisiciones<small> Consulta</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Consultar requisiciones</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['requisiciones']['consultar']) or  !isset($_SESSION['permisos']['requisiciones']['acceso'])){
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
            
            <!-- Box Herramientas de filtrado-->
            <div class="box box-info" style="border-color:#13A44D">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-filter text-green"></i> Filtrar Resultados</h3>
                
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
                
                    <div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;"><!-- /.Row -->
                        <div class='col-sm-1'>
                            <div class="form-group">
                            	<label for="cfiltrarfecha">Filtrar fecha: </label>
                            		<select id="cfiltrarfecha" name="filtrarfecha" class="form-control">
                                        <option value="NO" selected>NO</option>
                                        <option value="SI">SI</option>
                                        <!--option value="MIXTO">MIXTO</option-->
                                     </select>
                            </div>
                         </div>
                    	<div class='col-sm-2'>
                            <div class="form-group">
                            	<label for="cfechainicio">Requisiciones de:</label>
                            	<input value="<?php echo date('Y-m-d');?>" name="fechainicio" type="date" required class="form-control" id="cfechainicio" />
                            </div>
                         </div>
                        <div class='col-sm-2'>
                            <div class="form-group">
                           		<label for="cfechafin">a:</label>
                            	<input value="<?php echo date('Y-m-d');?>" name="fechafin" type="date" required class="form-control" id="cfechafin" />
                           	</div>
                        </div>
                        
                        <div class='col-sm-2'>
                            <div class="form-group">
                                <label for="cestado">Estado: </label>
                                <select id="cestado" name="estado" class="form-control">
                                    <option value="Aceptada">ACEPTADAS</option>
                                    <option value="Pendiente" selected>PENDIENTES</option>
                                    <option value="TODAS">TODAS</option>
                                </select>
                            </div>
                		</div>
                        
                        <div class='col-sm-3'>
                            <div class="form-group">
                            	<label for="idsucursal_ajax">Sucursal:</label>
                            	<select id="idsucursal_ajax" name="idsucursal" class="form-control">
                            	</select>
                            </div>
                		</div>
                        
                        <div class='col-sm-2 pull-right'>
                            <div class="form-group">
                            		<label for="cdomicilio">&nbsp;</label>
                                    <button type="button" class="btn btn-success pull-right form-control" id="botonFiltrar"><i class="fa fa-filter"></i>&nbsp;&nbsp;&nbsp;Filtrar</button>
                                     <input value="No" name="filtroavanzado" type="hidden" class="form-control" id="filtroavanzado" />
                            </div>
                		</div>
                    </div><!-- /.Fin row -->
                    
                    
				</div><!-- /.box-body -->
                <div class="box-footer">
                
				  <input name="idcotizacion" type="hidden" id="cidcotizacion" value="<?php if (isset($_POST['idcotizacion'])){echo $_POST['idcotizacion'];}else{echo "";}?>"/>
                  
                </div><!-- /.box-footer -->
                
              </form>
              
            </div><!-- /.box -->
            <!-- Fin Herramientas de filtrado>
            
          	<!-- box -->
            <div class="box box-info" style="border-color:#909">
            	<div class="box-header with-border">
                	<h3 class="box-title">Consulta de registros</h3>
              	</div><!-- /.box-header -->
                <div id="muestra_contenido_ajax" style="min-height:100px;">
            	</div><!-- /din contenido ajax -->
                <div id="loading" class="overlay">
  					<i class="fa fa-cog fa-spin" style="color:#909"></i>
			  	</div>
                
            </div><!-- Fin box>
			
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>