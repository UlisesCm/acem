<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
<head>
<?php include ("../../../componentes/cabecera.php")?>
<link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../librerias/js/jquery-ui.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="general_js.js?v2"></script>

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
?>
<style>
.tooltip-inner {
    white-space:pre-wrap;
}
</style>
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
          <h1>Cobranza<small> Consulta</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Consultar pagos</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['reportes']['pagosycobranza'])){
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
                <h3 class="box-title"><i class="fa fa-filter text-green"></i> Filtrar Resultados</h3>
                
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
                	<div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;">
                    	<div class='col-sm-4'>
                            <div class="form-group">
                            	<label for="selectidalmacen_ajax">Sucursal:</label>
                            	<select id="idalmacen_ajax" name="idalmacen" class="form-control" style="margin-top:2px;">
                            	</select>
                            </div>
                         </div>
                        <div class='col-sm-2'>
                            <div class="form-group">
                           		<label for="cticket" class="col-sm-1 control-label">Ticket:</label>
                            	<input value="" name="ticket" type="text" class="form-control" id="cticket" />
                           	</div>
                        </div>
                        <div class='col-sm-6'>	
                        	<div class="form-group">
                                <label for="cidcliente" class="col-sm-1 control-label">Cliente:</label>
                                <input value="" name="idcliente" type="hidden" class="normal" id="cidcliente" style="width:50px;"/>
                                <input value="" name="consultaidcliente" type="hidden" class="normal" id="consultaidcliente" style="width:100px;"/>
                                <input value="" name="autoidcliente" type="text" class="form-control" id="autoidcliente" />
                        	</div>
                        </div>
                    	
                	</div><!-- /.Fin row -->
                    
                    <div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;">
                    	
                        <div class='col-sm-3'>
                            <div class="form-group">
                            	<label for="cfiltrarfecha">Filtrar por fecha de pago: </label>
                            		<select id="cfiltrarfecha" name="filtrarfecha" class="form-control" style="margin-top:0px;">
                                        <option value="NO">NO</option>
                                        <option value="SI" selected>SI</option>
                                        <!--option value="MIXTO">MIXTO</option-->
                                     </select>
                            </div>
                         </div>
                    	<div class='col-sm-3'>
                            <div class="form-group">
                            	<label for="cfechainicio">de:</label>
                            	<input value="<?php echo date('Y-m-d');?>" name="fechainicio" type="date" required class="form-control" id="cfechainicio" />
                            </div>
                         </div>
                        <div class='col-sm-3'>
                            <div class="form-group">
                           		<label for="cfechafin">a:</label>
                            	<input value="<?php echo date('Y-m-d');?>" name="fechafin" type="date" required class="form-control" id="cfechafin" />
                           	</div>
                        </div>
                        <div class='col-sm-3'>
                            <div class="form-group">
                           		<label for="cdiacobro">Filtrar por día de cobro</label>
                            	<select id="cdiacobro" name="diacobro" class="form-control" style="margin-top:0px;">
                                    <option value="NO APLICA" selected>NO APLICA</option>
                                    <option value="LUNES">LUNES</option>
                                    <option value="MARTES">MARTES</option>
                                    <option value="MIERCOLES">MIERCOLES</option>
                                    <option value="JUEVES">JUEVES</option>
                                    <option value="VIERNES">VIERNES</option>
                                    <option value="SABADO">SABADO</option>
                                    <option value="DOMINGO">DOMINGO</option>
                            	</select>
                           	</div>
                        </div>
                    	
                	</div><!-- /.Fin row -->
                    
                    
                    
                    
                    <div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;"><!-- /.Row -->
                    	
                        
                        <div class='col-sm-2'>
                            <div class="form-group">
                            		<label for="cformapago">Forma de pago: </label>
                            		<select id="cformapago" name="formapago" class="form-control" style="margin-top:2px;">
                                        <option value="" selected>CUALQUIER FORMA DE PAGO</option>
                                        <option value="EFECTIVO">EFECTIVO</option>
                                    	<option value="TARJETA DE DEBITO">TARJETA DE DEBITO</option>
                                    	<option value="TARJETA DE CREDITO">TARJETA DE CREDITO</option>
                                    	<option value="CHEQUE">CHEQUE</option>
                                    	<option value="TRANSFERENCIA">TRANSFERENCIA</option>
                                    	<option value="SALDO A FAVOR">SALDO A FAVOR</option>
                                        <!--option value="MIXTO">MIXTO</option-->
                                     </select>
                            </div>
                		</div>
                        
                        <div class='col-sm-2'>
                            <div class="form-group">
                            		<label for="ctipo">Estatus de la venta: </label>
                            		<select id="ctipo" name="tipo" class="form-control" style="margin-top:2px;">
                                    	<option value="" selected>TODAS LAS VENTAS</option>
                                        <option value="Pendiente">SIN LIQUIDAR</option>
                                        <option value="Liquidada">VENTAS LIQUIDADAS</option>
                                        <option value="fechavencida">FECHA LIMITE VENCIDA</option>
                            		</select>
                            </div>
                		</div>
                        
                        <div class='col-sm-2'>
                            <div class="form-group">
                            		<label for="cfacturada">Ventas facturadas: </label>
                            		<select id="cfacturada" name="facturada" class="form-control" style="margin-top:2px;">
                                    	<option value="" selected>TODAS</option>
                                        <option value="no">SIN FACTURAR</option>
                                        <option value="si">FACTURADAS</option>
                            		</select>
                            </div>
                		</div>
                        
                        
                        <div class='col-sm-2'>
                            <div class="form-group">
                            		<label for="cdomicilio">Clasificación: </label>
                            		<select id="cdomicilio" name="domicilio" class="form-control" style="margin-top:2px;">
                                        <option value="si">SOLO VENTAS A DOMICILIO</option>
                                        <option value="no">SOLO VENTAS EN TIENDA</option>
                                        <option value="todas" selected>TODAS</option>
                            		</select>
                            </div>
                		</div>
                        
                        <div class='col-sm-2 pull-right'>
                            <div class="form-group">
                            		<label for="cdomicilio">&nbsp;</label>
                                    <button type="button" class="btn btn-success pull-right form-control" id="botonFiltrar" style="margin-top:2px;"><i class="fa fa-filter"></i>&nbsp;&nbsp;&nbsp;Filtrar</button>
                            </div>
                		</div>
                    </div><!-- /.Fin row -->
                    
                    
				</div><!-- /.box-body -->
                
              </form>
              
            </div><!-- /.box -->
            <!-- Fin Herramientas de filtrado>
            
            <!-- box -->
            <div class="box box-info" style="border-color:#FC0;">
            	
                <div id="muestra_contenido_ajax" style="min-height:100px;">
            	</div><!-- /din contenido ajax -->
                <div id="loading" class="overlay">
  					<i class="fa fa-cog fa-spin" style="color:#0c63ba"></i>
			  	</div>
                
            </div><!-- Fin box>
			
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>