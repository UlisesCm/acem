<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?>
	<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js?V1"></script>
    <script src="../../../librerias/js/jquery-ui.js?V1"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/jquery-ui.css?V1" />
    <script src="../../../bootstrap/js/bootstrap.min.js?V1" type="text/javascript"></script>
    <script src="../../../plugins/slimScroll/jquery.slimscroll.min.js?V1" type="text/javascript"></script>
    <script src="../../../plugins/fastclick/fastclick.min.js?V1"></script>
    <script src="../../../dist/js/app.min.js?V1" type="text/javascript"></script>
    <script src="js.js?V1"></script>
    <script src="../../../librerias/js/cookies.js?V1"></script>
    <script src="../../../librerias/js/validaciones.js?V1"></script>
    <script src="https://unpkg.com/sticky-table-headers"></script>
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
          <h1>Requisición<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nueva requisición</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content header">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['requisiciones']['guardar']) or  !isset($_SESSION['permisos']['requisiciones']['acceso'])){
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
			
			<?php $herramientas="nuevo"; include("../componentes/herramientas2.php"); ?>
			<?php include("../../../componentes/avisos.php");?>
        
          	<!-- Horizontal Form -->
            <div class="box box-info" style="border-color:#909">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
                <label class= "label pull-right bg-red" style="margin-left:10px;">Folio: <span id="lserie"> </span>-<span id="lfolio"></span></label>
                <label class= "label pull-right bg-yellow">Fecha: <?php echo date('Y-m-d'); ?></label>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
				<div class="form-group hide">
                    <label for="ctipo" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        <input value="entrada" name="tipo" type="hidden" class="form-control" id="ctipo" />
                    </div>
                </div>
                
                
                <div class="form-group hide">
                    <label for="cserie" class="col-sm-2 control-label">Serie:</label>
                    <div class="col-sm-2">
                        <input value="" name="serie" type="text" class="form-control" id="cserie" />
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="cfolio" class="col-sm-2 control-label">Folio:</label>
                    <div class="col-sm-2">
                        <input value="" name="folio" type="text" class="form-control" id="cfolio" />
                    </div>
                </div>
            <!-- Agregar empleado   -->
                <div class="form-group">
                  	<label for="selectidempleado_ajax" class="col-sm-2 control-label">Empleado:</label>
                    <div class="col-sm-5">
                      <select id="idempleado_ajax" name="idempleado" class="form-control">
                      </select>
                    </div> 
                </div>
				
				
				<div class="form-group EB">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha de requisición:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo date('Y-m-d'); ?>" name="fecha" type="date" required class="form-control" id="cfecha" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group EB">
                  	<label for="selectidsucursal_ajax" class="col-sm-2 control-label">Sucursal / Almacén:</label>
                    <div class="col-sm-5">
                      <select id="idsucursal_ajax" name="idsucursal" class="form-control">
                      </select>
                    </div> 
                </div>
			
                <div class="form-group">
                  	<label for="selectidproveedor_ajax" class="col-sm-2 control-label">Proveedor:</label>
                    <div class="col-sm-5">
                      <select id="idproveedor_ajax" name="idproveedor" class="form-control">
                      </select>
                    </div> 
                </div>
			
				
				<div class="form-group">
                    <label for="ccomentarios" class="col-sm-2 control-label">Comentarios:</label>
                    <div class="col-sm-5">
                        <textarea name="comentarios" id="ccomentarios" class="form-control"></textarea>
						
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        <input value="activo" name="estatus" type="hidden" class="form-control" id="cestatus" />
                    </div>
                </div>
                <div id="ajax_resultado">
                </div>
                <!-- Agregar a tabla --> 
                <div class="EB tablita">
                <div class="box-header with-border">
                	<h3 class="box-title">Tabla de productos</h3>
              	</div><!-- /.box-header -->
                    
                <div class='row' style="padding:20px; display:none">
                    <div class='col-sm-3'>    
                        <div class='form-group'>
                            <label for="cnombreproducto">Producto</label>
                            
                            <input value="" name="idproducto" type="hidden" class="normal" id="cidproducto"/>
                            <input value="" name="codigoproducto" type="hidden" class="normal" id="ccodigoproducto"/>
                            <input value="" name="nnombreproducto" type="hidden" class="normal" id="nnombreproducto"/>
                            <input value="" name="consultaidproducto" type="hidden" class="normal" id="consultaidproducto" style="width:100px;"/>
                            <input value="" name="autoidproducto" type="text" class="form-control" id="autoidproducto" />
                        </div>
                    </div>
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="ncantidad">Unidad</label>
                            <input value="" name="nunidad" type="text" class="form-control" id="nunidad" disabled/>
                        </div>
                    </div>
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="ncantidad">Cantidad</label>
                            <input value="1" name="ncantidad" type="text" class="form-control" id="ncantidad"/>
                        </div>
                    </div>
                    <div class='col-sm-1 hide'>
                        <div class='form-group'>
                            <label for="ncosto">Costo</label>
                            <input value="" name="ncosto" type="text" class="form-control" id="ncosto"/>
                        </div>
                    </div>
                    <div class='col-sm-1 hide'>
                        <div class='form-group'>
                            <label for="nminimo">Mínimo</label>
                            <input value="0" name="nminimo" type="text" class="form-control" id="nminimo"/>
                        </div>
                    </div>
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="nstockminimo">Stock minimo</label>
                            <input value="" name="nstockminimo" type="text" class="form-control" id="nstockminimo"/>
                        </div>
                    </div>
                    
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="nstockmaximo">Stock Maximo</label>
                            <input value="" name="nstockmaximo" type="text" class="form-control" id="nstockmaximo"/>
                        </div>
                    </div>
                    
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="nidproducto">ID producto</label>
                            <input value="" name="nidproducto" type="text" class="form-control" id="nidproducto"/>
                        </div>
                    </div>
                    
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="nexistencias">Existencias</label>
                            <input value="" name="nexistencias" type="text" class="form-control" id="nexistencias"/>
                        </div>
                    </div>
                    
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="npesoteorico">Peso Teorico</label>
                            <input value="" name="npesoteorico" type="text" class="form-control" id="npesoteorico"/>
                        </div>
                    </div>
                    
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="nclasificacion">Clasificacion</label>
                            <input value="" name="nclasificacion" type="text" class="form-control" id="nclasificacion"/>
                        </div>
                    </div>
                    
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="botonAgregarFila">&nbsp;</label>
                            <input value="" name="listaSalida" type="hidden" id="listaSalida"/>
                            <input value="" name="pesototal" type="hidden" id="pesototal"/>
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
                                <td width="80" style='display:none'>ID</td>
                                <td width="100" style='display:none'>Código</td>
                                <td width="300">Producto</td>
                                <td width="100">Unidad</td>
                                <td width="100">Cantidad <span id="totalLista" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Costo Pza<span id="totalLista2" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Costo Kl</td>
                                <td width="100">Monto</td>
                                <td width="100">Peso teorico</td>
                                <td width="100">Peso real</td>
                                <td width="100">Peso total</td>
                                <td width="100">Existencias</td>
                                <td width="100">Stock Mínimo</td>
                                <td width="100">Stock Máximo</td>
                                <td width="100">Clasificacion</td>
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
              <div id="mensaje"></div>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#909"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
        <audio id="player" src="sonido.mp3"> </audio>
        <audio id="playerq" src="bien.mp3"> </audio>
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>