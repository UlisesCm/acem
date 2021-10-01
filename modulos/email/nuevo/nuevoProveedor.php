<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("../../empresa/Empresa.class.php");
include ("../../proveedores/Proveedor.class.php");

$Oempresa=new Empresa;
$Oproveedor= new Proveedor;
//$resultado=$Oempresa->obtenerMensajeEmail(1);
//$extractor = mysql_fetch_array($resultado);
//$mensajeemail=$extractor["mensajeemail"];


if (isset($_POST['pdf']) && trim($_POST['pdf']) !=""){
	$pdf=htmlentities(trim($_POST['pdf']));
	$pdforg=$pdf;
	$pdf=explode("/",$pdf);
	$pdf=$pdf[3];
}else{
	$pdf="";
	$pdforg="";
}

if (isset($_POST['xml']) && trim($_POST['xml']) !=""){
	$xml=htmlentities(trim($_POST['xml']));
	$xmlorg=$xml;
	$xml=explode("/",$xml);
	$xml=$xml[3];
}else{
	$xml="";
	$xmlorg="";
}

if (isset($_POST['idproveedor']) && trim($_POST['idproveedor']) !=""){
	$idproveedor=trim($_POST['idproveedor']);
}else{
	$idproveedor="";
}

if (isset($_POST['idcompra']) && trim($_POST['idcompra']) !=""){
	$idcompra=trim($_POST['idcompra']);
}else{
	$idcompra="";
}

$resultado3=$Oproveedor->consultaGeneral("WHERE idproveedor='$idproveedor'");
if(mysqli_num_rows($resultado3) > 0){
		$filas3=mysqli_fetch_array($resultado3);
		$email=$filas3['email'];
		$proveedor=$filas3['nombre'];
		$mensaje="Solicitud de compra: <a href='http://localhost:9112/acem/modulos/ordenescompras/imprimir/consultar.php?req=$idcompra&token=$idproveedor' target='_blank'>http://localhost:9112/acem/modulos/ordenescompras/imprimir/consultar.php?req=$idcompra&token=$idproveedor</a>";
		
		$pos = strpos($email, "[");
		if($pos===false){
		
			$arrayemail=explode(",",$email);
			$email="[";
			$con=0;
			while($con < count($arrayemail)){
				$email=$email.'"'.$arrayemail[$con].'"';
				$con++;
				if ($con != count($arrayemail)){
					$email=$email.',';
				}
			}
			$email=$email."]";
		}
		
		
		
		$mes=date("m");
		if($mes=="01"){
			$MES="ENERO";
		}
		if($mes=="02"){
			$MES="FEBRERO";
		}
		if($mes=="03"){
			$MES="MARZO";
		}
		if($mes=="04"){
			$MES="ABRIL";
		}
		if($mes=="05"){
			$MES="MAYO";
		}
		if($mes=="06"){
			$MES="JUNIO";
		}
		if($mes=="07"){
			$MES="JULIO";
		}
		if($mes=="08"){
			$MES="AGOSTO";
		}
		if($mes=="09"){
			$MES="SEPTIEMBRE";
		}
		if($mes=="10"){
			$MES="OCTUBRE";
		}
		if($mes=="11"){
			$MES="NOVIEMBRE";
		}
		if($mes=="12"){
			$MES="DICIEMBRE";
		}
		$ano=date("y");
		$ANO=date("Y");
		$mensaje=str_replace("%MES%",$MES,$mensaje);
		$mensaje=str_replace("%mes%",strtolower($MES),$mensaje);
		$mensaje=str_replace("%ano%",$ano,$mensaje);
		$mensaje=str_replace("%ANO%",$ANO,$mensaje);
		
}else{
		$email="[]";

}

?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?>
    <link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
    <link type="text/css" rel="stylesheet" href="../../../librerias/js/editor/jquery-te-1.4.0.css">
    <link rel='stylesheet' href='../../../librerias/js/multiple-email/multiple-emails.css'>
    <script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="../../../plugins/fastclick/fastclick.min.js"></script>
    <script src="../../../dist/js/app.min.js" type="text/javascript"></script>
    <script src="js.js"></script>
    <script src="../../../librerias/js/cookies.js"></script>
    <script src="../../../librerias/js/validaciones.js"></script>
    <script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
    <script type="text/javascript" src="../../../librerias/js/editor/jquery-te-1.4.0.min.js" charset="utf-8"></script>
    <script src='../../../librerias/js/multiple-email/multiple-emails.js'></script>
    


<script>
	$(function() {
		$('#current_emails').text($('#example_email').val());
		$('#cemail').val($('#example_email').val());
		$('#example_email').multiple_emails();
		$('#example_email').change( function(){
			$('#current_emails').text($(this).val());
			$('#cemail').val($(this).val());
		});
		
		
	});
</script>

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
          <h1>Email<small>Enviar correo electrónico</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo email</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['email']['guardar']) or  !isset($_SESSION['permisos']['email']['acceso'])){
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
            <div class="box box-info" style="border-color:#909">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de envío a <?php echo strtoupper($proveedor)?></h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
                	 <?php if ($xml!=""){?>
                	 <div class="form-group">
                        <label for="cs" class="col-sm-2 control-label">Archivos adjuntos</label>
                        <div class="col-sm-3">
                              <div class="info-box bg-gray" title="<?php echo $pdf; ?>">
                                <span class="info-box-icon bg-red" title="<?php echo $pdf; ?>"><i class="fa fa-file-pdf-o"></i></span>
                                <div class="info-box-content">
                                <span class="info-box-text" title="<?php echo $pdf; ?>"><b>PDF</b></span>
                                  <span class="info-box-text" style="text-transform:none;"><?php echo $pdf; ?></span>
                                  
                                </div>
                              </div>
                        </div>
                        <div class="col-sm-3">
                              <div class="info-box bg-gray">
                                <span class="info-box-icon bg-green" title="<?php echo $xml; ?>"><i class="fa fa-file-code-o"></i></span>
                                <div class="info-box-content">
                                <span class="info-box-text"><b>XML</b></span>
                                  <span class="info-box-text" style="text-transform:none;"><?php echo $xml; ?></span>
                                  
                                </div>
                              </div>
                        </div>
                    </div>
                   	<?php }?>
                
                        
				
				<div class="form-group">
                    <label for="cnombre" class="col-sm-2 control-label">Lista de destinatarios:</label>
                    <div class="col-sm-6">
                    	<input type='text' id='example_email' name='example_email' class='form-control' value='<?php echo $email; ?>'>
                        	<pre id='current_emails' style="display:none;"></pre>
                        <input id="cemail" name="email" type="hidden"> 
                    </div>
                </div>
                
                <div class="form-group ">
                  	<label for="plantilla_ajax" class="col-sm-2 control-label">Plantilla de correo:</label>
                    <div class="col-sm-6">
                      <select id="plantilla_ajax" name="asunto" class="form-control">
                      </select>
                    </div> 
                </div>
                
                <div class="form-group ">
                  	<label for="asunto" class="col-sm-2 control-label">Asunto:</label>
                    <div class="col-sm-6">
                      <input name="asunto" id="casunto" type="text" class='form-control' value="Orden de compra (<?php echo $idcompra ;?>)">
                    </div> 
                </div>
                
                <div class="form-group ">
                    <label for="carchivo" class="col-sm-2 control-label">Mensaje:</label>
                    <div class="col-sm-6">
                        <input value="<?php echo $mensaje; ?>" name="mensaje" type="text" class="jqte-test" id="cmensaje" />
						
                    </div>
                </div>
                
                <div class="form-group hide">
                    <label for="carchivo" class="col-sm-2 control-label">Otros datos:</label>
                    <div class="col-sm-6">
                        <input value="compras" name="tablareferencia" type="text" id="ctablareferencia" />
						<input value="<?php echo $idcompra; ?>" name="idreferencia" type="text" id="cidreferencia" />
                    </div>
                </div>
			
				
				
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                	<input name="xml" type="hidden" class="normal" id="cxml" value="<?php echo $xmlorg;?>"/>
                  <input name="pdf" type="hidden" class="normal" id="cpdf" value="<?php echo $pdforg;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;Enviar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#ec3e4a"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

<script>
$('.jqte-test').jqte();
var jqteStatus = true;
$(".status").click(function(){
	jqteStatus = jqteStatus ? false : true;
	$('.jqte-test').jqte({"status" : jqteStatus})
});
</script>

</body>
</html>