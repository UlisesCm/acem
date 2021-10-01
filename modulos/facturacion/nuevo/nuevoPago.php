<?php 
include ("../../seguridad/comprobar_login.php");
require('recuperarValoresEmisor.php');
$idalmacen=$_SESSION["idalmacen"];
$idempleado=$_SESSION["idempleado"];

$checkimpuestocedular="";
$mostrarCedular="hide";
$mostrarISH="hide";
$checkish="";
if($impuestocedular=="si"){
	$checkimpuestocedular="checked";
	$mostrarCedular="";
}
if($eshotel==1){
	$checkish="checked";
	$mostrarISH="";
}
?>

<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?>
    <link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/jquery-ui.css" />
    <?php
	/////////////////* MODULO DE FACTURACION INTEGRADO
	if (isset($_SESSION['DATOSPAGO']) && $_SESSION['DATOSPAGO'] !="" && $_SESSION['VECES']==0) {
		echo "<script>var DATOS='".$_SESSION['DATOSPAGO']."'</script>";
		echo "<script>var CARGA='si'</script>";
		echo "<script>var TIPOCOMPROBANTE='".$_SESSION['TIPOCOMPROBANTE']."'</script>";
		echo "<script>var RFCCLIENTEPAGO='".$_SESSION['RFCCLIENTEPAGO']."'</script>";
		echo "<script>var IDCLIENTEPAGO='".$_SESSION['IDCLIENTEPAGO']."'</script>";
		echo "<script>var NOMBRECLIENTEPAGO='".$_SESSION['NOMBRECLIENTEPAGO']."'</script>";
		echo "<script>var FECHAPAGO='".$_SESSION['FECHAPAGO']."'</script>";
		echo "<script>var FORMAPAGO='".$_SESSION['FORMAPAGO']."'</script>";
		$_SESSION["VECES"]=1;
		//unset($_SESSION['DATOSPAGO']);
	}else{
		echo "<script>var DATOS=''</script>";
		echo "<script>var CARGA='no'</script>";
		echo "<script>var TIPO='no'</script>";
		echo "<script>var TIPOCOMPROBANTE='pago'</script>";
		unset($_SESSION['DATOSPAGO']);
		unset($_SESSION['IDCLIENTEPAGO']);
		unset($_SESSION['RFCCLIENTEPAGO']);
		unset($_SESSION['NOMBRECLIENTEPAGO']);
		unset($_SESSION['FECHAPAGO']);
		unset($_SESSION['FORMAPAGO']);
		unset($_SESSION['VECES']);
	}
	/////////////////* MODULO DE FACTURACION INTEGRADO 
	?>
    
	<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="../../../librerias/js/jquery-ui.js"></script>
	<script src="../../../librerias/js/jquery.PrintArea.js"></script>
	<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="../../../plugins/fastclick/fastclick.min.js"></script>
	<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
	<script src="jsPago.js?=v1.1"></script>
	<script src="../../../librerias/js/cookies.js"></script>
	<script src="../../../librerias/js/validaciones.js"></script>
	<script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
    <style>
	.tooltip-inner {
			max-width: 350px;
			/* If max-width does not work, try using width instead */
			width: 350px;
			text-align:justify;
		}
    </style>

</head>
  <body class="sidebar-collapse sidebar-mini <?php include("../../../componentes/skin.php");?>">
    <!-- Wrapper es el contenedor principal -->
    <div class="wrapper">
      
      <?php include("../../../componentes/menuSuperior.php");?>
      <?php include("../../../componentes/menuLateral.php");?>

      <!-- Contenido-->
      <div class="content-wrapper">
        <!-- Contenido de la cabecera -->
        <section class="content-header">
          <h1>CFDI | <small><i class="fa fa-user text-yellow"></i>&nbsp;&nbsp;<?php echo $_SESSION['nombreempleado']?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo CFDI</a></li>
          </ol>
        </section>
        
        
        <div class="modal fade" id="modal-respuesta">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="tituloRespuesta">Respuesta del PAC</h3>
              </div>
              <div class="modal-body">
              
                 <div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;">
                    <div class='col-sm-4' align="center"> 
                    	<div class="info-icons" style="color:#32AB81">
                            <span class="fa-stack fa-lg fa-5x">
                              <i class="fa fa-square-o fa-stack-2x"></i>
                              <i class="fa fa-thumbs-o-up fa-stack-1x"></i>
                            </span>
                        </div>
                    </div>
                    <div class='col-sm-8' align="center"> 
                        <h3>¿Qué desea hacer?</h3>
                        <p>El comprobante ha sido timbrado con éxito</p>
                        
                        <form action="../../email/nuevo/nuevo.php" method="post">
                            <input type="hidden" name="xml" value="" id="cxml"/>
                			<input type="hidden" name="pdf" value="" id="cpdf"/>
                    		<input type="hidden" name="email" value="" id="cemail"/>
                    		<input type="hidden" name="cliente" value="" id="ccliente"/>
                    		<input type="hidden" name="rfccliente" value="" id="crfccliente"/>
                            <p>
                            <button type="submit" class="btn btn-success btn-sm" style="width:100%; background:#32AB81;"><i class="fa fa-envelope-o"></i> Enviar al cliente</button>
                            </p>
                        </form>
                        
                        <p><button type="button" class="btn btn-success btn-sm" onClick="window.location='../consultar/vista.php?n1=facturacion&n2=consultarfacturacion'" style="width:100%; background:#32AB81;"><i class="fa fa-clipboard"></i> Consultar comprobantes</button></p>
                        <p><button type="button" class="btn btn-success btn-sm" data-dismiss="modal" style="width:100%; background:#32AB81;"><i class="fa fa-file-code-o"></i> Nuevo comprobate</button></p>
                    </div>
                 </div>
                 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
        
        
        <div class="modal fade" id="modal-error">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="tituloRespuesta">El comprobante no ha sido timbrado</h3>
              </div>
              <div class="modal-body">
              
                 <div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;">
                    <div class='col-sm-4' align="center"> 
                    	<div class="info-icons" style="color:#D81831">
                            <span class="fa-stack fa-lg fa-5x">
                              <i class="fa fa-square-o fa-stack-2x"></i>
                              <i class="fa fa-thumbs-o-down fa-stack-1x"></i>
                            </span>
                        </div>
                    </div>
                    <div class='col-sm-8' align="center"> 
                        <h3 id="subtituloRespuesta">Hay un problema</h3>
                        <p id="mensajeResuesta">Rebice los datos para comprabar que no existen errores</p>
                        
                    </div>
                 </div>
                 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
        
        
        
        
        <div class="modal fade" id="modal-vistaprevia">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Vista previa del CFDI</h3>
              </div>
              <div class="modal-body">
              	<center>
              		<div id="respuestaVista" style="width:800px; border:#CCC 1px solid;"></div>
              	</center>
                 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
        <form class="form-horizontal" name="formulariocep" id="formulariocep" method="post" enctype="multipart/form-data"></form>
        
        <form class="form-horizontal" name="formulario" id="formulario" method="post">
        
        <div class="modal fade" id="modal-default">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Configuración del CFDI</h4>
              </div>
              <div class="modal-body">
                
                
                 <div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;">
                    <div class='col-sm-12'> 
                    
                    	<!-- SERIE Y FOLIO-->
                    	<div class="row" style=" margin:0px; padding:0px 0px 0px 0px;">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="cserie">Serie:</label>
                                    <input value="" name="serie" type="text" class="form-control" id="cserie">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group lcambio">
                                    <label for="cfolio" id="labelcambio">Folio:</label>
                                    <input value="" name="folio" type="text" class="form-control" id="cfolio">
                                </div>
                            </div>
                            <div class="col-sm-3">
                            	<div class="form-group lcambio">
                                <label for="cserie">Tipo de CFDI:</label>
                                <select id="ctipocomprobante" name="tipocomprobante" class="form-control">
                                	<option value="P" selected>Pago</option>
                                </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-5">
                            	<div class="form-group EB">
                                    <label for="selectidalmacen_ajax">Lugar de expedición:</label>
                                	<select id="idalmacen_ajax" name="codigopostal" class="form-control">
                                	</select>
                                </div>
                            </div>
                        </div> 
                        <!-- FIN SERIE Y FOLIO-->
                        
                        <!-- MONEDA Y TIPO DE CAMBIO-->
                    	<div class="row" style=" margin:0px; padding:0px 0px 0px 0px;">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="cmoneda">Moneda:</label>
                                    <select id="cmoneda" name="moneda" class="form-control">
                                        <option value="MXN">PESO MEXICANO</option>
                                        <option value="USD">DOLAR AMERICANO</option>
                                        <option value="USN">DOLAR ESTADOUNIDENSE</option>
                                        <option value="EUR">EURO</option>
                                      </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group lcambio">
                                    <label for="cfolio" id="labelcambio">Tipo de cambio:</label>
                                    <input value="1" name="tipocambio" type="text" class="form-control" id="ctipocambio" disabled>
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cuso">Uso que le dará el cliente a CFDI:</label>
                                    <select id="cuso" name="uso" class="form-control">
                                        <option value="P01" selected>POR DEFINIR</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 hidden">
                                <div class="form-group lcambio">
                                    <label for="cmetodopago">Método de pago:</label>
                                    <select id="cmetodopago" name="metodopago" class="form-control">
                                        <option value="PUE" selected>PAGO EN UNA SOLA EXHIBICION</option>
                                        <option value="PPD">PAGO EN PARCIALIDADES O DIFERIDO</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div> 
                        <!-- FIN MONEDA Y TIPO DE CAMBIO-->
                        
                        <!-- USO DEL CFDI Y CONDICIONES DE PAGO-->
                    	<div class="row" style=" margin:0px; padding:0px 0px 0px 0px;">
                            
                            <div class="col-sm-5 hidden">
                                <div class="form-group lcambio">
                                    <label for="ccondiciones" id="labelcambio">Condiciones de pago:</label>
                                    <input value="" name="condiciones" type="text" class="form-control" id="ccondiciones">
                                </div>
                            </div>
                            
                            
                            
                        
                            
                            
                        </div> 
                        <!-- USO DEL CFDI Y CONDICIONES DE PAGO-->
                        
                         <!-- USO DEL CFDI Y CONDICIONES DE PAGO-->
                    	<div class="row labelBancarizado" style=" margin:0px; padding:0px 0px 0px 0px; display:none">
                        	<div class="col-sm-3">
                                <div class="form-group">
                                    <label for="crfcemisorordenante" id="labelcambio">RFC Emisor ordenante:</label>
                                    <div class="input-group">
                                    	<input value="" name="rfcemisorordenante" type="text" class="form-control" id="crfcemisorordenante">
                                    	<span class="input-group-addon" data-placement="bottom" data-toggle="tooltip" data-html="true" title="<em>Campo opcional</em> <u>Descripción:</u> <b>Se puede registrar la clave del RFC de la entidad emisora de la cuenta origen, es decir, la operadora, el banco, la institución financiera, emisor de monedero electrónico, etc., en caso de ser residente en el extranjero se debe registrar la clave en el RFC genérica XEXX010101000, en caso de que éste no se utilice, la clave en el RFC que se registre debe estar en la lista de claves en el RFC inscritas en el SAT.
</b>" ><i class="fa fa-question-circle text-blue"></i></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="ccuentaordenante" id="labelcambio">Cuenta ordenante:</label>
                                    <div class="input-group">
                                    	<input value="" name="cuentaordenante" type="text" class="form-control" id="ccuentaordenante">
                                    	<span class="input-group-addon" data-placement="bottom" data-toggle="tooltip" data-html="true" title="<em>Campo opcional</em> <u>Descripción:</u> <b>Se puede registrar el número de la cuenta con la que se realizó el pago, considerar las reglas de obligatoriedad de acuerdo con la columna Cuenta Ordenante del catálogo c_FormaPago publicado en el Portal del SAT.  </br> Puede conformarse desde 10 hasta 50 caracteres.</b>" ><i class="fa fa-question-circle text-blue"></i></span>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="cbancoordenante" id="labelcambio">Nombre del banco:</label>
                                    <div class="input-group">
                                    	<input value="" name="bancoordenante" type="text" class="form-control" id="cbancoordenante">
                                    	<span class="input-group-addon" data-placement="bottom" data-toggle="tooltip" data-html="true" title="<em>Campo opcional para bancos nacionales</em> <u>Descripción:</u> <b>Se puede registrar el nombre del banco ordenante, es requerido en caso de ser extranjero, considerar las reglas de obligatoriedad de acuerdo con la columna Nombre del Banco emisor de la cuenta ordenante en caso de extranjero del catálogo c_FormaPago publicado en el Portal del SAT.</br>
Puede conformarse desde 1 hasta 300 caracteres.</br>
Ejemplo:</br>
Nombre del banco= BANK OF TOKY </b>" ><i class="fa fa-question-circle text-blue"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- USO DEL CFDI Y CONDICIONES DE PAGO-->
                    	<div class="row labelBancarizado" style=" margin:0px; padding:0px 0px 0px 0px; display:none">
                        
                        	<div class="col-sm-3">
                                <div class="form-group">
                                    <label for="crfcemisorbeneficiario" id="labelcambio">RFC Emisor beneficiario:</label>
                                    <div class="input-group">
                                    	<input value="" name="rfcemisorbeneficiario" type="text" class="form-control" id="crfcemisorbeneficiario">
                                    	<span class="input-group-addon" data-placement="bottom" data-toggle="tooltip" data-html="true" title="<em>Campo opcional</em> <u>Descripción:</u> <b>Se puede registrar la clave en el RFC de la entidad operadora de la cuenta destino, es decir, la operadora, el banco, la institución financiera, emisor de monedero electrónico, etc. </br>Considerar las reglas de obligatoriedad de acuerdo con la columna RFC del Emisor Cuenta del beneficiario del catálogo c_FormaPago publicado en el Portal del SAT.
</b>" ><i class="fa fa-question-circle text-blue"></i></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="ccuentabeneficiario" id="labelcambio">Cuenta beneficiario:</label>
                                    <div class="input-group">
                                    	<input value="" name="cuentabeneficiario" type="text" class="form-control" id="ccuentabeneficiario">
                                    	<span class="input-group-addon" data-placement="bottom" data-toggle="tooltip" data-html="true" title="<em>Campo opcional</em> <u>Descripción:</u> <b>Se puede registrar el número de cuenta en donde se recibió el pago. 
</br> Considerar las reglas de obligatoriedad de acuerdo con la columna Cuenta de Benenficiario del catálogo c_FormaPago publicado en el Portal del SAT. 
</br> Puede conformarse desde 10 hasta 50 caracteres. </br> Puede conformarse desde 10 hasta 50 caracteres.</b>" ><i class="fa fa-question-circle text-blue"></i></span>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <!-- USO DEL CFDI Y CONDICIONES DE PAGO-->
                    	<div class="row labelCadena" style=" margin:0px; padding:0px 0px 0px 0px; display:none;">
                        	<div class="col-sm-3">
                            	<div class="form-group lcambio">
                                <label for="cserie">Tipo de cadena de pago:</label>
                                <select id="ctipocadena" name="tipocadena" class="form-control">
                                	<option value="" selected>Ninguna</option>
                                    <option value="01">SPEI</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-sm-7 labelspei" style="display:none">
                            <label for="ccep">Adjunte el CEP xml del SPEI:</label>
                                <div class="input-group form-group">
                                    <input type="file" form="formulariocep" name="archivo" style="display:none;" id="carchivo" accept=".xml" onchange="fileinput('archivo')">
                                    <input type="text" form="formulariocep" name="narchivo" id="narchivo" class="form-control" placeholder="Seleccionar Archivo" disabled="disabled">
                                    <span class="input-group-btn">
                                        <a class="btn btn-warning" onclick="$('#carchivo').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
                                    </span>
                                </div>
                        	</div>
                            
                            <div class="col-sm-2 labelspei" style="display:none">
                            	<div class="form-group">
                                    <label for="ccep" id="labelcambio">&nbsp;</label>
                                	<button type="button" class="btn btn-success form-control" id="botonCargar">Cargar archivo</button>
                                </div>
                            	
                                
                        	</div>
                        </div>
                        
                        <div class="row labelspei" style=" margin:0px; padding:0px 0px 0px 0px; display:none">
                        	<div class="col-sm-3">
                        		<div class="form-group">
                                    <label for="ccertificadopago" id="labelcambio">Certificado del pago:</label>
                                    <div class="input-group">
                                    	<input value="" name="certificadopago" type="text" class="form-control" id="ccertificadopago">
                                    	<span class="input-group-addon" data-placement="bottom" data-toggle="tooltip" data-html="true" title="<em>Campo opcional</em> <u>Descripción:</u> <b>Es el certificado que corresponde al pago, como una cadena de texto en formato base 64 y es requerido en caso de que el tipo de cadena sea SPEI. </br>Puede llenar esta información automáticamente cargando el comprobante electrónico del SPEI (CEP)</b>" ><i class="fa fa-question-circle text-blue"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="ccadenapago" id="labelcambio">Cadena del pago:</label>
                                    <div class="input-group">
                                    	<input value="" name="cadenapago" type="text" class="form-control" id="ccadenapago">
                                    	<span class="input-group-addon" data-placement="bottom" data-toggle="tooltip" data-html="true" title="<em>Campo opcional</em> <u>Descripción:</u> <b>Es la cadena original del comprobante de pago generado por la entidad emisora de la cuenta beneficiaria. Es requerido en caso de que el campo TipoCadPago contenga información. </br> Puede llenar esta información automáticamente cargando el comprobante electrónico del SPEI (CEP)</b>" ><i class="fa fa-question-circle text-blue"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="csellopago" id="labelcambio">Sello del pago:</label>
                                    <div class="input-group">
                                    	<input value="" name="sellopago" type="text" class="form-control" id="csellopago">
                                    	<span class="input-group-addon" data-placement="bottom" data-toggle="tooltip" data-html="true" title="<em>Campo opcional</em> <u>Descripción:</u> <b>Es el sello digital que se asocie al pago. La entidad que emite el comprobante de pago, ingresa una cadena original y el sello digital en una sección de dicho comprobante, este sello digital es el que se debe registrar en este campo. Debe ser expresado como una cadena de texto en formato base 64. Es requerido en caso de que el campo TipoCadPago contenga información. </br>Puede llenar esta información automáticamente cargando el comprobante electrónico del SPEI (CEP)</b>" ><i class="fa fa-question-circle text-blue"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        	
                        
                        
                        <!-- OTROS IMPUESTOS-->
                        <div class="row" style=" margin:0px; padding:0px 0px 0px 0px;">
                        	<div class="col-sm-4">
                                <label>
							    	<input id="cdocumentosrelacionados" type="checkbox" name="documentosrelacionados" value="si">&nbsp; Documentos relacionados
                 				</label>
                            </div>
                            <div class="col-sm-4 right <?php echo $mostrarISH; ?>">
                                <label>
							    	<input id="ceshotel" type="checkbox" name="eshotel" value="1" <?php echo $checkish; ?>>&nbsp; Declarar ISH
                 				</label>
                                <select id="ctasaish" name="tasaish" class="form-control">
                                	<option value="1">1%</option>
                                	<option value="2" selected>2%</option>
                                	<option value="3">3%</option>
                            	</select>
                            </div>
                            
                            
                            
                            <div class="col-sm-4 right <?php echo $mostrarCedular; ?>">
                            	<label>
							        <input id="cimpuestocedular" type="checkbox" name="impuestocedular" value="si" <?php echo $checkimpuestocedular; ?>>&nbsp; Declarar Impuestos Cedulares
                 				</label>
                                <select id="ctasaimpuestocedular" name="tasaimpuestocedular" class="form-control pull-left">
                                	<option value="1">1%</option>
                                	<option value="2">2%</option>
                                	<option value="3">3%</option>
                               	</select>
                            </div>
                           
                        </div>
                        <!--FIN DE OTROS IMUESTOS-->
                        
                      
                      <!-- OBSERVACIONES-->
                    	<div class="row" style=" margin:0px; padding:0px 0px 0px 0px;">
                            <div class="col-sm-12">
                                <div class="form-group lcambio">
                                    <label for="cobservaciones" id="labelcambio">Observaciones:</label>
                                    <textarea class="form-control" id="cobservaciones" name="observaciones"></textarea>
                                </div>
                            </div>
                            
                        </div> 
                        <!--FIN OBSERVACIONES-->
                        
                        
                        
                        
                        
                        
                        
                    </div>
                 </div>
                
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
        
        
        
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['facturacion']['guardar']) or  !isset($_SESSION['permisos']['facturacion']['acceso'])){
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
			<?php //include("../../../componentes/avisos.php");?>
            
            
            <div class="row">
            <div class="col-md-8">
            
            	
                <!-- Horizontal Form -->
                <div class="box box-warning seccionRelaciones" style="border-color:#F03; display:none">
                	<div class="box-header with-border">
                		<h3 class="box-title">Lista de documentos relacionados</h3> <div style="display:none">(TICKET: <span class="numticket"></span>)</div>
                        <label class="label pull-right bg-yellow"><?php echo date('d/m/Y') ?></label>
                	</div><!-- /.box-header -->
                    <!-- Agregar a tabla --> 
                
                <div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;">
                    <div class='col-sm-8'>    
                        <div class='form-group'>
                            <label for="autofoliointerno">Comprobantes relacionados</label>
                            <input value="" name="foliointerno" type="hidden" class="normal" id="cfoliointerno" style="width:50px;"/>
							<input value="" name="consultafoliointerno" type="hidden" class="normal" id="consultafoliointerno" style="width:100px;"/>
							<input value="" name="autofoliointerno" type="text" class="form-control" id="autofoliointerno" />
                        </div>
                    </div>
                    <div class='col-sm-3'>
                        <div class='form-group'>
                            <label for="nuuid">UUID</label>
                            <input value="" name="nuuid" type="text" class="form-control" id="nuuid" disabled/>
                        </div>
                    </div>
                    
                   
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="botonAgregarFila">&nbsp;</label>
                            <input value="" name="listaSalida2" type="hidden" id="listaSalida2"/>
                            <input type="button" value="Agregar" class="form-control btn btn-success" id="botonAgregarFila2"/>
                        </div>
                    </div>
                    
                    
                </div> <!-- Fin row -->
                
                
                <!-- Fin Agregar a tabla --> 
                	<div class="box-body">
                    	<div class="box-body table-responsive no-padding">
                            <table id="tablaSalida2" class="table table-hover table-bordered">
                                <thead>
                                    <tr style="background:#F3F3F3; color:#666; height:30px; border:1px" align="center">
                                        <td width="80" style='display:none'>No.</td>
                                        <td width="400">CFDI Relacionado</td>
                                        <td width="200">UUID</td>
                                        <td width="30" align="center"></td>
                                    </tr>
                                </thead>
                                <tbody id="filas2" style="background:#FFF; border:1px #666 solid;" align="center">
                                </tbody>
                            </table>
                        </div>
                <!-- Fina Tabla --> 
                	</div><!-- /.box-body -->
                	<div class="box-footer">
                	</div><!-- /.box-footer -->
                    <div class="overlay cargando" style="display:none">
            		<i class="fa fa-cog fa-spin" style="color:#0c63ba"></i>
            	</div>
                  
                </div><!-- /.box -->
            
            
            
                <!-- Horizontal Form -->
                <div class="box box-warning" style="border-color:#F03">
                	<div class="box-header with-border">
                		<h3 class="box-title">Lista de cuentas relacionadas (Facturas PPD)</h3> <div style="display:none">(TICKET: <span class="numticket"></span>)</div>
                        <label class="label pull-right bg-yellow"><?php echo date('d/m/Y') ?></label>
                	</div><!-- /.box-header -->
                    <!-- Agregar a tabla --> 
                
                
                <?php 
				/////////////////* MODULO DE FACTURACION INTEGRADO
				if (isset($_SESSION['DATOSPAGO']) && $_SESSION['DATOSPAGO'] !=""){
					$mostrarAgregar="hide";
				}else{
					$mostrarAgregar="";
				}
				/////////////////* FIN MODULO DE FACTURACION INTEGRADO
				?>
                <div class='row <?php echo $mostrarAgregar; ?>' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;">
                    <div class='col-sm-4'>    
                        <div class='form-group'>
                            <label for="cnombreproducto">Facturas</label>
                            
                            <input value="" name="idfacturacion" type="hidden" class="normal" id="cidfacturacion"/>
                            <input value="" name="uuid" type="hidden" class="normal" id="uuid"/>
                            <input value="" name="autoidfacturacion" type="text" class="form-control" id="autoidfacturacion" />
                        </div>
                    </div>
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="ncantidad">Moneda</label>
                            <input value="" name="nmoneda" type="text" class="form-control" id="nmoneda" disabled/>
                        </div>
                    </div>
                    <div class='col-sm-2'>
                        <div class='form-group'>
                            <label for="ncantidad">Tipo de cambio</label>
                            <input value="1" name="ntipocambio" type="text" class="form-control" id="ntipocambio" onkeypress="return soloNumeros(event,'nmonto');"/>
                        </div>
                    </div>
                    
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="numparcialidad">Num parcialidad</label>
                            <input value="0" name="nnumparcialidad" type="text" class="form-control" id="nnumparcialidad" disabled/>
                        </div>
                    </div>
                    
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="nmontototal">Total</label>
                            <input value="0" name="nmontototal" type="text" class="form-control" id="nmontototal" disabled/>
                        </div>
                    </div>
                    
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="ninsoluto">Insoluto</label>
                            <input value="0" name="ninsoluto" type="text" class="form-control" id="ninsoluto" disabled/>
                        </div>
                    </div>
                    
                    <div class='col-sm-2 hide'>
                        <div class='form-group'>
                            <label for="nfolio">Folio</label>
                            <input value="" name="nfoliof" type="text" class="form-control" id="nfoliof" disabled/>
                        </div>
                    </div>
                    
                    <div class='col-sm-2'>
                        <div class='form-group'>
                            <label for="nsaldoanterior">Saldo anterior</label>
                            <input value="0" name="nsaldoanterior" type="text" class="form-control" id="nsaldoanterior" disabled/>
                        </div>
                    </div>
                            
                    <div class='col-sm-2'>
                        <div class='form-group'>
                            <label for="ncosto">Monto del pago</label>
                            <input value="" name="nmonto" type="text" class="form-control" id="nmonto" onkeypress="return soloNumeros(event,'nmonto');"/>
                        </div>
                    </div>
                   
                    
                    <div class='col-sm-1'>
                        <div class='form-group'>
                            <label for="botonAgregarFila">&nbsp;</label>
                            <input value="" name="listaSalida" type="hidden" id="listaSalida"/>
                            <input type="button" value="Agregar" class="form-control btn btn-success" id="botonAgregarFila"/>
                        </div>
                    </div>
                    
                    <div class='col-sm-12'>
                    	<span style="font-size:16px;" class="label label-primary" id="descripcionFactura"></span>
                    </div>
                </div> <!-- Fin row -->
                
                
                <!-- Fin Agregar a tabla --> 
                	<div class="box-body">
                    	<div class="box-body table-responsive no-padding">
                            <table id="tablaSalida" class="table table-hover table-bordered">
                                <thead>
                                    <tr style="background:#F3F3F3; color:#666; height:30px; border:1px" align="center">
                                        <td width="80" style='display:none'>No.</td>
                                        <td width="200">ID</td>
                                        <td width="100">Folio</td>
                                        <td width="100">Moneda</td>
                                        <td width="100">Tipo Cambio</td>
                                        <td width="100">Metodo pago</td>
                                        <td width="100">Num parcialidad</td>
                                        <td width="100">Saldo anterior</td>
                                        <td width="100">Monto pagado</td>
                                        <td width="100">Saldo insoluto</td>
                                        <td width="30" align="center"></td>
                                    </tr>
                                </thead>
                                <tbody id="filas" style="background:#FFF; border:1px #666 solid;" align="center">
                                </tbody>
                            </table>
                        </div>
                <!-- Fina Tabla --> 
                	</div><!-- /.box-body -->
                	<div class="box-footer">
                	</div><!-- /.box-footer -->
                    <div class="overlay cargando" style="display:none">
            		<i class="fa fa-cog fa-spin" style="color:#0c63ba"></i>
            	</div>
                    <div id="respuesta"></div>
                </div><!-- /.box -->
            </div>
            
            <div class="col-md-4">
        
          	<!-- Horizontal Form -->
            <div class="box box-warning" style="border-color:#F03">
              <div class="box-header with-border">
                <h3 class="box-title">Datos del CFDI</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  
                <div class="box-body">
                
                <div class="form-group hide">
                  	<label for="selectidempleado_ajax" class="col-sm-3 control-label">Vendedor:</label>
                    <div class="col-sm-9">
                      <select id="idempleado_ajax" name="idempleado" class="form-control">
                      </select>
                    </div> 
                </div>
				
                <div class="form-group hide">
                	<div class="col-sm-12">
                    	
                        <label for="cidcaja" class="col-sm-3 control-label">Idcaja:</label>
                    </div>
                    <div class="col-sm-3 hide">
                        <input value="<?php echo $idcaja; ?>" name="idcaja" type="hidden" class="form-control" id="cidcaja" />
                    </div>
                </div>
                
                
                <?php
						$habilitarfecha="";
						if (!isset($_SESSION['permisos']['ventas']['modificarfecha'])){
							$habilitarfecha="hide";
						}else{
							$habilitarfecha="";
						}
				?>

				
			
				
				<div class="form-group hide">
                    <label for="chora" class="col-sm-3 control-label">Hora:</label>
                    <div class="col-sm-9">
                        <input value="<?php echo date('H:i'); ?>" name="hora" type="time" required class="form-control" id="chora" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="cidcliente" class="col-sm-4 control-label" style="text-align:left;">Cliente:</label>
                    <div class="col-sm-8">
						<input value="0" name="idcliente" type="hidden" class="normal" id="cidcliente" style="width:50px;"/>
						<input value="" name="consultaidcliente" type="hidden" class="normal" id="consultaidcliente" style="width:100px;"/>
						<input value="PUBLICO EN GENERAL" name="autoidcliente" type="text" class="form-control" id="autoidcliente" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="cfecha" class="col-sm-4 control-label" style="text-align:left;">Fecha del pago:</label>
                    <div class="col-sm-8">
                        <input value="<?php echo date('Y-m-d'); ?>" name="fecha" type="date" required class="form-control" id="cfecha" />
                    </div>
                </div>
                
                <div class="form-group seccionRelaciones" style="display:none;">
                    <label for="ctiporelacion" class="col-sm-4 control-label" style="text-align:left;">Tipo de relación:</label>
                    <div class="col-sm-8">
                      <select id="ctiporelacion" name="tiporelacion" class="form-control">
						<option value="04">SUSTITUCION DE CFDI PREVIOS</option>
                      </select>
                    </div> 
                </div>
			
				
				<div class="form-group">
                    <label for="cformapago" class="col-sm-4 control-label" style="text-align:left;">Forma de pago:</label>
                    <div class="col-sm-8">
                      <select id="cformapago" name="formapago" class="form-control">
						<option value="01">EFECTIVO</option>
						<option value="02">CHEQUE NOMINATIVO</option>
						<option value="03">TRANSFERENCIA ELECTRÓNICA DE FONDOS</option>
						<option value="04">TARJETA DE CRÉDITO</option>
						<option value="05">MONEDERO ELECTRÓNICO</option>
						<option value="06">DINERO ELECTRÓNICO</option>
						<option value="08">VALES DE DESPENSA</option>
						<option value="12">DACIÓN EN PAGO</option>
						<option value="13">PAGO POR SUBROGACIÓN</option>
						<option value="14">PAGO POR CONSIGNACIÓN</option>
						<option value="15">CONDONACIÓN</option>
						<option value="17">COMPENSACIÓN</option>
						<option value="23">NOVACIÓN</option>
						<option value="24">CONFUSIÓN</option>
						<option value="25">REMISIÓN DE DEUDA</option>
						<option value="26">PRESCRIPCIÓN O CADUCIDAD</option>
						<option value="27">A SATISFACCIÓN DEL ACREEDOR</option>
						<option value="28">TARJETA DE DÉBITO</option>
						<option value="29">TARJETA DE SERVICIOS</option>
						<option value="30">APLICACIÓN DE ANTICIPOS</option>
						<option value="99">POR DEFINIR</option>
                      </select>
                    </div> 
                </div>
               
                
                <div class="form-group">
                    <label for="cnumoperacion" class="col-sm-4 control-label" style="text-align:left">No. de operación:</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                        	<input value="" name="numoperacion" type="text" class="form-control" id="cnumoperacion">
                        	<span class="input-group-addon" data-placement="bottom" data-toggle="tooltip" data-html="true" title="<em>Campo opcional</em> <u>Descripción:</u> <b>Se puede registrar el número de cheque, número de autorización, número de referencia, clave de rastreo en caso de ser SPEI, línea de captura o algún número de referencia o identificación análogo que permita identificar la operación correspondiente al pago efectuado.</b>" ><i class="fa fa-question-circle text-blue"></i></span>
                        </div>
                    </div>
                </div>
			
            	<div class="form-group hide">
                    <label for="cticket" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        <input value="" name="ticket" type="hidden" class="form-control" id="cticket" />
                    </div>
                </div>
                
                
				<div class="form-group hide">
                    <label for="ctotal" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        <input value="0" name="total" type="text" class="form-control" id="ctotal" />
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="cestado" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        <input value="Liquidada" name="estado" type="hidden" class="form-control" id="cestado" />
                    </div>
                </div>
			
			
				
				<div class="form-group hide">
                    <label for="cidalmacen" class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        <input value="<?php echo $_SESSION['idalmacen'] ?>" name="idalmacen" type="hidden" class="form-control" id="cidalmacen" />
                    </div>
                </div>
                    <div id="totales">
                        
                        <div class="form-group">
                            <div class="col-sm-4">
                                <h3 style="line-height:0px;">Total:</h3>
                            </div>
                            <div class="col-sm-8">
                                <h3 style="line-height:0px;" id="ltotal">$0.00</h3>
                            </div>
                        </div>
                        
                        
                    </div> <!-- TOTALES -->
                        
			
				</div><!-- /.box-body -->
                
                <div class="box-footer">
                
               
                	<div class='row' style=" margin:0px; padding:10px 10px 0px 10px;">
                    	<div class='col-sm-4'>
                        	<div class='form-group'>
                            	<button type="button" class="form-control btn btn-success" id="vistaPrevia"><i class="fa fa-eye"></i>&nbsp;&nbsp;&nbsp;Vista Previa</button>
                        	</div>
                    	</div>
                		
                        <div class='col-sm-4'>
                        	<div class='form-group'>
                            	
                            	<button type="button" class="form-control btn btn-primary" id="botonConfigurar" data-toggle="modal" data-target="#modal-default"><i class="fa fa-gear"></i>&nbsp;&nbsp;&nbsp;Configurar</button>
                        	</div>
                    	</div>
                        <div class='col-sm-4'>
                        	<div class='form-group'>
                            	
                            	<button type="button" class="form-control btn btn-warning" id="botonGuardar"><i class="fa fa-bell"></i>&nbsp;&nbsp;&nbsp;Timbrar</button>
                        	</div>
                    	</div>
                        
                	</div>
                    <div class='row' style=" margin:0px; padding:10px 10px 0px 10px;">
                    	<div class='col-sm-12'>
                        	<div class='form-group'>
                            	<button type="button" class="form-control btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Nuevo Recibo</button>
                               	<?php //echo $_SESSION["DATOSPAGO"];?>
                        	</div>
                    	</div>
                    </div>
                    
                    
                </div><!-- /.box-footer -->
              
              	<div class="overlay cargando" style="display:none">
            		<i class="fa fa-cog fa-spin" style="color:#0c63ba"></i>
            	</div>
              
            </div><!-- /.box -->
            
            </div>
            
            </div>
            
           
            
        </section><!-- /.content -->
        </form>
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>