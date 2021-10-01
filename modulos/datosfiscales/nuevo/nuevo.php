<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
  <head>
     <?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link href="../../../librerias/js/Spry/SpryValidationTextarea.css" rel="stylesheet" type="text/css" /><link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/jquery-ui.js"></script><script src="../../../librerias/js/cookies.js"></script><script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script><script src="../../../librerias/js/Spry/SpryValidationTextarea.js" type="text/javascript"></script>
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
          <h1>Datofiscal<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo datofiscal</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['datosfiscales']['guardar']) or  !isset($_SESSION['permisos']['datosfiscales']['acceso'])){
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
				     <blockquote style="font-size:14px;">
                        <!--<p><b>Cliente:</b> <?php if (isset($_POST['nombre'])){echo $_GET['nombre'];}else{echo "";}?></p>-->
                        <p><b>Nombre comercial:</b> <?php if (isset($_POST['nic'])){echo $_POST['nic'];}else{echo "";}?></p>
                </blockquote>
                
               
                <div class='form-group'>
                      <label for="cidcliente" class="col-sm-2 control-label">Cliente:</label>
                      <div class='col-sm-5'>
                          <!--<input value="" name="idcliente" type="hidden" class="normal" id="cidcliente" style="width:50px;"/>-->
                          <input value="<?php if (isset($_POST['idcliente'])){echo $_POST['idcliente'];}else{echo "";}?>" name="idcliente" type="hidden" class="form-control" id="cidcliente" />
                          <input value="" name="consultaidcliente" type="hidden" class="normal" id="consultaidcliente" style="width:100px;"/>
                          <input value="<?php if (isset($_POST['nombre'])){echo $_POST['nombre'];}else{echo "";}?>" name="autoidcliente" type="text" class="form-control" id="autoidcliente" />
                          <input value="" name="cotizacionespendientes" type="hidden" class="form-control" id="idcotizacionespendientes" />
                      </div>
                  </div>
			
				
				<div class="form-group ">
                    <label for="cdomiciliocompleto" class="col-sm-2 control-label">Domicilio fiscal:</label>
                    <div class="col-sm-5">
                    	<span id="Vdomiciliocompleto">
                        <textarea name="domiciliocompleto" id="cdomiciliocompleto" class="form-control"></textarea>
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
							<option value="01">Efectivo</option>
							<option value="02">Cheque nominativo</option>
							<option value="03">Transferencia de fondos</option>
							<option value="04">Tarjetas de crédito</option>
							<option value="05">Monederos electrónicos</option>
							<option value="06">Dinero electrónico</option>
							<option value="08">Vales despensa</option>
							<option value="28">Tarjeta de débito</option>
							<option value="30">Aplicación de anticipos</option>
							<option value="99">Por definir</option>
						</select>
                    </div> 
                </div>
				<div class="form-group ">
                  	<label for="cmetodopago" class="col-sm-2 control-label">Método de pago:</label>
                    <div class="col-sm-5">
                    	<select id="cmetodopago" name="metodopago" class="form-control">
							<option value="PPD">Pago en parcialidades o diferido</option>
							<option value="PUE">Pago en una sola exhibición</option>
						</select>
                    </div> 
                </div>
				<div class="form-group ">
                  	<label for="cusocfdi" class="col-sm-2 control-label">Uso de CFDI:</label>
                    <div class="col-sm-5">
                    	<select id="cusocfdi" name="usocfdi" class="form-control">
							<option value="G01">Adquisición de mercancías</option>
							<option value="G02">Devoluciones, descuentos o bonificaciones</option>
							<option value="G03">Gastos en general</option>
							<option value="I01">Construcciones</option>
							<option value="I02">Mobiliario y equipo de oficina por inversiones</option>
							<option value="I03">Equipo de transporte</option>
							<option value="I04">Equipo de computo y accesorios</option>
							<option value="I05">Dados, troqueles, moldes, matrices y herramental</option>
							<option value="I06">Comunicaciones telefónicas</option>
							<option value="I07">Comunicaciones satelitales</option>
							<option value="I08">Otra maquinaria y equipo</option>
							<option value="P01">Por definir</option>
						</select>
                    </div> 
                </div>
				
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-sm-5">
                    	
                        <input value="activo" name="estatus" type="hidden" class="form-control" id="cestatus" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
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
				
</script>

</body>
</html>