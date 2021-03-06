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
          <h1>Pesaje de requisiciones
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Pesaje de requisiciones</a></li>
          </ol>
        </section>
        <?php include ("../componentes/modal.php");?>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['ordenescompras']['guardar']) or  !isset($_SESSION['permisos']['ordenescompras']['acceso'])){
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
            <div class="box box-info" style="border-color:#F90">
              <div class="box-header with-border">
                <h3 class="box-title">Procesar pesos</h3>
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
			
				
				
				<div class="form-group EB hide">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha de orden:</label>
                    <div class="col-sm-3">
                        <input value="<?php echo date('Y-m-d'); ?>" name="fecha" type="date" required class="form-control" id="cfecha" />
                    </div>
                </div>
			
				
				<div class="form-group EB hide">
                  	<label for="cparametrocotizacion" class="col-sm-2 control-label">Par??metro de cotizaci??n:</label>
                    <div class="col-sm-5">
                      <select id="cparametrocotizacion" name="parametrocotizacion" class="form-control">
                      	<option value="precio">MEJOR PRECIO</option>
                        <option value="tiempo">MEJOR TIEMPO DE RESPUESTA</option>
                        <option value="calidad">MEJOR CALIDAD</option>
                        <option value="existencia">MEJOR NIVEL DE EXISTENCIA</option>
                      </select>
                    </div> 
                </div>
                
                <div class="form-group">
                  	<label for="idsucursal_ajax" class="col-sm-2 control-label">Sucursal:</label>
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
                    <label for="cidempleado" class="col-sm-2 control-label">No. Requisici??n:</label>
                    <div class="col-sm-2 hide">
                        <input value="<?php echo $_SESSION["idregistrorelacionado"];?>" name="idempleado" type="hidden" class="form-control" id="cidempleado"/>
                    </div>
                    <div class="col-sm-5">
                      <select id="idrequisicion_ajax" name="idrequisicion" class="form-control">
                      </select>
                    </div> 
                    <div class="col-sm-2">
                        <input type="button" value="Procesar" class="form-control btn btn-warning" id="botonProcesar"/>
                        <input value="" name="listaSalida" type="hidden" id="listaSalida"/>
                    </div>
                </div>
                
                
			
				
				<div class="form-group hide">
                    <label for="ccomentarios" class="col-sm-2 control-label">Comentarios:</label>
                    <div class="col-sm-5">
                        <textarea name="comentarios" id="ccomentarios" class="form-control"></textarea>
						
                    </div>
                </div>
                
                <div class="box-header with-border">
                	<h3 class="box-title">Tabla de requisiciones</h3>
              	</div><!-- /.box-header -->
                
                <div class="form-group" style="padding-top:20px;">
                    <div class="col-sm-10">
                    	<div class="box-body table-responsive no-padding">
                            <table id="tablaRequisiciones" class="table table-hover table-bordered">
                                <thead>
                                    <tr style="background:#F3F3F3; color:#666; height:30px; border:1px" align="center">
                                        <td width="80" style='display:none'>No.</td>
                                        <td width="80" style='display:none'>ID</td>
                                        <td width="100">Requisicion</td>
                                        <td width="200">Sucursal</td>
                                        <td width="200" style="display:none">idSucursal</td>
                                        <td width="200">Proveedor</td>
                                        <td width="200">Peso total</td>
                                        <td width="200" style="display:none">Peso total</td>
                                        <td width="30" align="center"></td>
                                    </tr>
                                </thead>
                                <tbody id="filasRequisiciones" style="background:#FFF; border:1px #666 solid;" align="center">
                                </tbody>
                            </table>
                            <span class="pull-right" id="totalKilos" style="font-size:16px; font-weight:bold; color:#096; padding-right:60px;"></span>
						</div>	
                    </div>
                </div>
                
                <div class="form-group hide">
                    <label for="clistaRequisicion" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        <input name="listaRequisiciones" type="text" class="form-control" id="listaRequisiciones" />
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
                <div class="box-header with-border hide">
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
                            <label for="nminimo">M??nimo</label>
                            <input value="0" name="nminimo" type="text" class="form-control" id="nminimo"/>
                        </div>
                    </div>
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="nubicacion">Ubicaci??n</label>
                            <input value="" name="nubicacion" type="text" class="form-control" id="nubicacion"/>
                        </div>
                    </div>
                    
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="ncontenidoneto">Contenido Neto</label>
                            <input value="" name="ncontenidoneto" type="text" class="form-control" id="ncontenidoneto"/>
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
                            <label for="nprecio1">Precio</label>
                            <input value="" name="nprecio1" type="text" class="form-control" id="nprecio1"/>
                        </div>
                    </div>
                    
                     <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="npesoteorico">Peso teorico</label>
                            <input value="" name="npesoteorico" type="text" class="form-control" id="npesoteorico"/>
                        </div>
                    </div>
                    
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="nidproveedor">idproveedor</label>
                            <input value="" name="nidproveedor" type="text" class="form-control" id="nidproveedor"/>
                        </div>
                    </div>
                    
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="nnombreproveedor">Proveedor</label>
                            <input value="" name="nnombreproveedor" type="text" class="form-control" id="nnombreproveedor"/>
                        </div>
                    </div>
                    
                    
                    
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="botonAgregarFila">&nbsp;</label>
                            
                            <input type="button" value="Agregar" class="form-control btn btn-success" id="botonAgregarFila"/>
                        </div>
                    </div>
                </div>
                <!-- Fin Agregar a tabla --> 
                <!-- Tabla --> 
                <div class="box-body table-responsive no-padding hide">
                    
                    
                    <table id="tablaSalidaP" class="table table-hover table-bordered" style="display:none">
                        <thead>
                            <tr style="background:#F3F3F3; color:#666; height:30px; border:1px" align="center">
                                <td width="80" style='display:none'>No.</td>
                                <td width="80" style='display:none'>ID</td>
                                <td width="100" style='display:none'>C??digo</td>
                                <td width="200">Producto</td>
                                <td width="100">Medida</td>
                                <td width="100">Cantidad <span id="totalLista" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Costo <span id="totalLista2" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Monto <span id="totalLista3" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Peso Unitario</td>
                                <td width="100">Unidades <span id="totalLista4" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100" style='display:none'>idsucursal</td>
                                <td width="100">Sucursal</td>
                                <td width="150" style='display:none'>idproveedor</td>
                                <td width="100">Proveedor</td>
                                <td width="30" align="center"></td>
                                <td width="30" align="center"></td>
                            </tr>
                        </thead>
                        <tbody id="filasP" style="background:#FFF; border:1px #666 solid;" align="center">
                        </tbody>
                    </table>
                    
                    <table id="tablaSalida" class="table table-hover table-bordered">
                        <thead>
                            <tr style="background:#F3F3F3; color:#666; height:30px; border:1px" align="center">
                                <td width="80" style='display:none'>No.</td>
                                <td width="80" style='display:none'>ID</td>
                                <td width="100" style='display:none'>C??digo</td>
                                <td width="200">Producto</td>
                                <td width="100">Medida</td>
                                <td width="100">Cantidad <span id="totalLista" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Costo <span id="totalLista2" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Monto <span id="totalLista3" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Peso Unitario</td>
                                <td width="100">Unidades <span id="totalLista4" style="color:#0C0; font-weight:bold; display:none">0</span></td>
                                <td width="100" style='display:none'>idsucursal</td>
                                <td width="100">Sucursal</td>
                                <td width="150" style='display:none'>idproveedor</td>
                                <td width="100">Proveedor</td>
                                <td width="30" align="center"></td>
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
                </div><!-- /.box-footer -->
              </form>
              <div id="mensaje"></div>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#F90"></i>
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