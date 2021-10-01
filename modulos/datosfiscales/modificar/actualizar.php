<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextarea.css" rel="stylesheet" type="text/css" /><link href="../../../librerias/js/Spry/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script>

<script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextarea.js" type="text/javascript"></script>
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
          <h1>Datofiscal<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar datofiscal</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['datosfiscales']['modificar']) or  !isset($_SESSION['permisos']['datosfiscales']['acceso'])){
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
            <div class="box box-info" style="border-color:#b44747">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group hide">
                    <label for="cidcliente" class="col-sm-2 control-label">ID: </label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idcliente; ?>" name="idcliente" type="hidden" class="form-control" id="cidcliente" />
            			
						
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="cdomiciliocompleto" class="col-sm-2 control-label">Domicilio fiscal:</label>
                    <div class="col-sm-5">
                    	<span id="Vdomiciliocompleto">
                        <textarea name="domiciliocompleto" id="cdomiciliocompleto" class="form-control"><?php echo $domiciliocompleto; ?></textarea>
            			<span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textareaRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="cformapago" class="col-sm-2 control-label">Forma de pago:</label>
                    <div class="col-sm-5">
                    	<select id="cformapago" name="formapago" class="form-control">
										<option value="01" <?php 
											if ($formapago=="01"){
												echo 'selected="selected"';
											}
											 ?>>Efectivo</option>
										
										<option value="02" <?php 
											if ($formapago=="02"){
												echo 'selected="selected"';
											}
											 ?>>Cheque nominativo</option>
										
										<option value="03" <?php 
											if ($formapago=="03"){
												echo 'selected="selected"';
											}
											 ?>>Transferencia de fondos</option>
										
										<option value="04" <?php 
											if ($formapago=="04"){
												echo 'selected="selected"';
											}
											 ?>>Tarjetas de crédito</option>
										
										<option value="05" <?php 
											if ($formapago=="05"){
												echo 'selected="selected"';
											}
											 ?>>Monederos electrónicos</option>
										
										<option value="06" <?php 
											if ($formapago=="06"){
												echo 'selected="selected"';
											}
											 ?>>Dinero electrónico</option>
										
										<option value="08" <?php 
											if ($formapago=="08"){
												echo 'selected="selected"';
											}
											 ?>>Vales despensa</option>
										
										<option value="28" <?php 
											if ($formapago=="28"){
												echo 'selected="selected"';
											}
											 ?>>Tarjeta de débito</option>
										
										<option value="30" <?php 
											if ($formapago=="30"){
												echo 'selected="selected"';
											}
											 ?>>Aplicación de anticipos</option>
										
										<option value="99" <?php 
											if ($formapago=="99"){
												echo 'selected="selected"';
											}
											 ?>>Por definir</option>
										
						</select>
                    </div> 
                </div>
				<div class="form-group ">
                  	<label for="cmetodopago" class="col-sm-2 control-label">Método de pago:</label>
                    <div class="col-sm-5">
                    	<select id="cmetodopago" name="metodopago" class="form-control">
										<option value="PPD" <?php 
											if ($metodopago=="PPD"){
												echo 'selected="selected"';
											}
											 ?>>Pago en parcialidades o diferido</option>
										
										<option value="PUE" <?php 
											if ($metodopago=="PUE"){
												echo 'selected="selected"';
											}
											 ?>>Pago en una sola exhibición</option>
										
						</select>
                    </div> 
                </div>
				<div class="form-group ">
                  	<label for="cusocfdi" class="col-sm-2 control-label">Uso de CFDI:</label>
                    <div class="col-sm-5">
                    	<select id="cusocfdi" name="usocfdi" class="form-control">
										<option value="G01" <?php 
											if ($usocfdi=="G01"){
												echo 'selected="selected"';
											}
											 ?>>Adquisición de mercancías</option>
										
										<option value="G02" <?php 
											if ($usocfdi=="G02"){
												echo 'selected="selected"';
											}
											 ?>>Devoluciones, descuentos o bonificaciones</option>
										
										<option value="G03" <?php 
											if ($usocfdi=="G03"){
												echo 'selected="selected"';
											}
											 ?>>Gastos en general</option>
										
										<option value="I01" <?php 
											if ($usocfdi=="I01"){
												echo 'selected="selected"';
											}
											 ?>>Construcciones</option>
										
										<option value="I02" <?php 
											if ($usocfdi=="I02"){
												echo 'selected="selected"';
											}
											 ?>>Mobiliario y equipo de oficina por inversiones</option>
										
										<option value="I03" <?php 
											if ($usocfdi=="I03"){
												echo 'selected="selected"';
											}
											 ?>>Equipo de transporte</option>
										
										<option value="I04" <?php 
											if ($usocfdi=="I04"){
												echo 'selected="selected"';
											}
											 ?>>Equipo de computo y accesorios</option>
										
										<option value="I05" <?php 
											if ($usocfdi=="I05"){
												echo 'selected="selected"';
											}
											 ?>>Dados, troqueles, moldes, matrices y herramental</option>
										
										<option value="I06" <?php 
											if ($usocfdi=="I06"){
												echo 'selected="selected"';
											}
											 ?>>Comunicaciones telefónicas</option>
										
										<option value="I07" <?php 
											if ($usocfdi=="I07"){
												echo 'selected="selected"';
											}
											 ?>>Comunicaciones satelitales</option>
										
										<option value="I08" <?php 
											if ($usocfdi=="I08"){
												echo 'selected="selected"';
											}
											 ?>>Otra maquinaria y equipo</option>
										
										<option value="P01" <?php 
											if ($usocfdi=="P01"){
												echo 'selected="selected"';
											}
											 ?>>Por definir</option>
										
						</select>
                    </div> 
                </div>
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $estatus; ?>" name="estatus" type="hidden" class="form-control" id="cestatus" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="iddatofiscal" type="hidden" id="ciddatofiscal" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#b44747"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("Vdomiciliocompleto",  { maxChars:300,  minChars:1});
				var sprytextarea1 = new Spry.Widget.ValidationTextarea("Vdomiciliocompleto",  { maxChars:300,  minChars:1});
				
</script>
</body>
</html>