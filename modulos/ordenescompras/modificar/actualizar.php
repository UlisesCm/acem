<?php 
include ("../../seguridad/comprobar_login.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?>
	<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="../../../librerias/js/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/jquery-ui.css" />
    <script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="../../../plugins/fastclick/fastclick.min.js"></script>
    <script src="../../../dist/js/app.min.js" type="text/javascript"></script>
    <script src="js.js"></script>
    <script src="../../../librerias/js/cookies.js"></script>
    <script src="../../../librerias/js/validaciones.js"></script>
    <script><?php echo "var idsucursalSeleccionado='$idsucursal';";?></script>
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
          <h1>Orden de compra<small>Actualizar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nueva compra</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['compras']['guardar']) or  !isset($_SESSION['permisos']['compras']['acceso'])){
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
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
			
				
				<div class="form-group EB">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha de compra:</label>
                    <div class="col-sm-3">
                        <input value="<?php echo $fecha; ?>" name="fecha" type="date" required class="form-control" id="cfecha" readonly/>
                    </div>
                </div>
			
				
				<div class="form-group EB">
                  	<label for="selectidsucursal_ajax" class="col-sm-2 control-label">Sucursal / Almacén:</label>
                    <div class="col-sm-5">
                      <input value="<?php echo $idsucursal?>" name="idsucursal" type="hidden" class="form-control" id="cidsucursal"/>
                      <input value="<?php echo $nombreSucursal?>" name="sucursal" type="text" class="form-control" id="sucursal" readonly/>
                    </div> 
                </div>
                
                <div class="form-group EB">
                  	<label for="selectidsucursal_ajax" class="col-sm-2 control-label">Proveedor:</label>
                    <div class="col-sm-5">
                      <input value="<?php echo $idproveedor?>" name="idproveedor" type="hidden" class="form-control" id="cidproveedor"/>
                      <input value="<?php echo $nombreProveedor?>" name="proveedor" type="text" class="form-control" id="proveedor" readonly/>
                    </div> 
                </div>
				
				<div class="form-group hide">
                    <label for="cidempleado" class="col-sm-2 control-label">Idempleado:</label>
                    <div class="col-sm-2">
                        <input value="<?php echo $idempleado;?>" name="idempleado" type="text" class="form-control" id="cidempleado"/>
                    </div>
                    <div class="col-sm-2">
                        <input type="button" value="Procesar" class="form-control btn btn-success" id="botonProcesar" style="display:none;"/>
                    </div>
                </div>
                
             
			
				
				<div class="form-group">
                    <label for="ccomentarios" class="col-sm-2 control-label">Comentarios:</label>
                    <div class="col-sm-5">
                        <textarea name="comentarios" id="ccomentarios" class="form-control"><?php echo $comentarios; ?></textarea>
                    </div>
                </div>
                
				<div class="form-group">
                    <label for="ccomentarios" class="col-sm-2 control-label">Fecha de vencimiento:</label>
                    <div class="col-sm-3">
                        <input value="<?php echo $fechavencimiento; ?>" name="fechavencimiento" type="date" required class="form-control" id="cfechavencimiento"/>
                    </div>
                </div>
                
				
				<div class="form-group">
                    <label for="cestado" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-sm-3">
                        <select id="cestado" name="estado" class="form-control">
                        <?php if ($estado=="Pendiente" or $estado=="Enviada" or $estado=="Autorizada para recepcion"){ ?>
                            <option value="Pendiente" <?php 
                                if ($estado=="Pendiente"){
                                    echo 'selected="selected"';
                                }
                                 ?>>Pendiente</option>
                        
                            
                            <option value="Enviada" <?php 
                                if ($estado=="Enviada"){
                                    echo 'selected="selected"';
                                }
                                 ?>>Enviada</option>
                            
                            <option value="Autorizada para recepcion" <?php 
                                if ($estado=="Autorizada para recepcion"){
                                    echo 'selected="selected"';
                                }
                                 ?>>Autorizada para recepcion</option>
                                 
                        <?php }?>
                        <?php if ($estado=="Recepcionada"){ ?>  
                            <option value="Recepcionada" <?php 
                                if ($estado=="Recepcionada"){
                                    echo 'selected="selected"';
                                }
                                 ?>>Recepcionada</option>
                        <?php }?>    
                                             
										
						</select>
                    </div>
                </div>
                <div id="ajax_resultado">
                </div>
                <!-- Agregar a tabla --> 
                <div class="EB tablita">
                <div class="box-header with-border">
                	<h3 class="box-title">Tabla de productos</h3>
              	</div><!-- /.box-header -->
                    
                <div class='row' style="padding:20px;">
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
                    
                      
                    <div class='col-sm-1'>
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
                            <label for="nubicacion">Ubicación</label>
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
                            <input value="" name="listaSalida" type="hidden" id="listaSalida"/>
                            <input type="button" value="Agregar" class="form-control btn btn-success" id="botonAgregarFila"/>
                        </div>
                    </div>
                </div>
                <!-- Fin Agregar a tabla --> 
                <table id="tablaSalida" class="table table-hover table-bordered">
                    <thead>
                        <tr style="background:#F3F3F3; color:#666; height:30px; border:1px" align="center">
                            	<td width="80" style='display:none'>No.</td>
                                <td width="80" style='display:none'>ID</td>
                                <td width="100" style='display:none'>Código</td>
                                <td width="200">Producto</td>
                                <td width="100">Unidad</td>
                                <td width="100">Cantidad <span id="totalLista" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Costo Pza<span id="totalLista2" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Costo Kl</td>
                                <td width="100">Monto <span id="totalLista3" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Peso Unitario</td>
                                <td width="100">Peso Real</td>
                                <td width="100">Peso <span id="totalLista4" style="color:#0C0; font-weight:bold">0</span></td>
                                <td width="100">Existencias</td>
                                <td width="100">Stock Mínimo</td>
                                <td width="100">Stock Máximo</td>
                                <td width="100" style='display:none'>idsucursal</td>
                                <td width="100">Sucursal</td>
                                <td width="30" align="center"></td>
                        </tr>
                    </thead>
                    <tbody id="filas" style="background:#FFF; border:1px #666 solid;" align="center">
                    </tbody>
                </table>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                	<input type="hidden" id="cidcompra" name="idcompra" value="<?php echo $id?>">
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