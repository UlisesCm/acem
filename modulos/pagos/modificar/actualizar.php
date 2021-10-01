<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script>

<script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
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
          <h1>Pago<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar pago</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['pagos']['modificar']) or  !isset($_SESSION['permisos']['pagos']['acceso'])){
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
            <div class="box box-info" style="border-color:#b4d571">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group">
                    <label for="cidventa" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idventa; ?>" name="idventa" type="hidden" class="form-control" id="cidventa" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cidventaajuste" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idventaajuste; ?>" name="idventaajuste" type="hidden" class="form-control" id="cidventaajuste" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cidcliente" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idcliente; ?>" name="idcliente" type="hidden" class="form-control" id="cidcliente" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cidcaja" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idcaja; ?>" name="idcaja" type="hidden" class="form-control" id="cidcaja" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cfechapago" class="col-sm-2 control-label">Fecha de pago:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $fechapago; ?>" name="fechapago" type="date" required="required" class="form-control" id="cfechapago" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                  	<label for="cformapago" class="col-sm-2 control-label">Forma de pago:</label>
                    <div class="col-sm-3">
                    	<select id="cformapago" name="formapago" class="form-control">
										<option value="EFECTIVO" <?php 
											if ($formapago=="EFECTIVO"){
												echo 'selected="selected"';
											}
											 ?>>EFECTIVO</option>
										
										<option value="TARJETA DE DEBITO" <?php 
											if ($formapago=="TARJETA DE DEBITO"){
												echo 'selected="selected"';
											}
											 ?>>TARJETA DE DEBITO</option>
										
										<option value="TARJETA DE CREDITO" <?php 
											if ($formapago=="TARJETA DE CREDITO"){
												echo 'selected="selected"';
											}
											 ?>>TARJETA DE CREDITO</option>
										
										<option value="CHEQUE" <?php 
											if ($formapago=="CHEQUE"){
												echo 'selected="selected"';
											}
											 ?>>CHEQUE</option>
										
										<option value="TRANSFERENCIA" <?php 
											if ($formapago=="TRANSFERENCIA"){
												echo 'selected="selected"';
											}
											 ?>>TRANSFERENCIA</option>
										
										<option value="SALDO A FAVOR" <?php 
											if ($formapago=="SALDO A FAVOR"){
												echo 'selected="selected"';
											}
											 ?>>SALDO A FAVOR</option>
										
						</select>
                    </div> 
                </div>
				<div class="form-group">
                    <label for="cmonto" class="col-sm-2 control-label">Monto:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $monto; ?>" name="monto" type="text" class="form-control" id="cmonto" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cdescripcion" class="col-sm-2 control-label">Comentarios:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $descripcion; ?>" name="descripcion" type="text" class="form-control" id="cdescripcion" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="idpago" type="hidden" id="cidpago" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#b4d571"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
</body>
</html>