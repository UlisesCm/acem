<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Movimiento.class.php');
$Omovimiento=new Movimiento;
$mensaje="";
$validacion=true;

$hora=date("H:i:s");
$tabla="";
$idreferencia=0;
$estado="";

if (isset($_POST['tipo'])){
	$tipo=htmlentities(trim($_POST['tipo']));
	$tipo=trim($tipo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipo no es correcto</p>";
}

if (isset($_POST['idproveedor'])){
	$idproveedor=htmlentities(trim($_POST['idproveedor']));
	//$nombre=mysql_real_escape_string($nombre);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo proveedor no es correcto</p>";
}

if (isset($_POST['numerocomprobante'])){
	$numerocomprobante=htmlentities(trim($_POST['numerocomprobante']));
	$numerocomprobante=trim($numerocomprobante);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo numerocomprobante no es correcto</p>";
}

if (isset($_POST['concepto'])){
	$concepto=htmlentities(trim($_POST['concepto']));
	$concepto=trim($concepto);
	if ($concepto=="ELIJA UNO"){
		$validacion=false;
		$mensaje=$mensaje."<p>Debe seleccionar el concepto o raz&oacute;n del movimiento</p>";
	}
	/*if ($concepto=="ORDEN DE COMPRA"){
		if ($idproveedor==0){
			$validacion=false;
			$mensaje=$mensaje."<p>Debe elegir un proveedor v&aacute;lido para esta operaci&oacute;n</p>";
		}
		if ($numerocomprobante==""){
			$validacion=false;
			$mensaje=$mensaje."<p>Debe ingresar el n&uacute;mero del comprobante o folio fiscal de la factura</p>";
		}
	}*/
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo concepto no es correcto</p>";
}



if (isset($_POST['fechamovimiento'])){
	$fechamovimiento=htmlentities(trim($_POST['fechamovimiento']));
	$fechamovimiento=trim($fechamovimiento);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechamovimiento no es correcto</p>";
}


if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	$idsucursal=trim($idsucursal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
}

if (isset($_POST['numerocomprobante'])){
	$numerocomprobante=htmlentities(trim($_POST['numerocomprobante']));
	$numerocomprobante=trim($numerocomprobante);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo numerocomprobante no es correcto</p>";
}

if (isset($_POST['comentarios'])){
	$comentarios=htmlentities(trim($_POST['comentarios']));
	$comentarios=trim($comentarios);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo comentarios no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	$estatus=trim($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}

if (isset($_POST['idalmacendestino'])){
	$idalmacendestino=htmlentities(trim($_POST['idalmacendestino']));
	$idalmacendestino=trim($idalmacendestino);
	
}else{
	$idalmacendestino=0;
}

if (isset($_POST['idalmacenX'])){
	$idalmacenX=htmlentities(trim($_POST['idalmacenX']));
	$idalmacenX=trim($idalmacenX);
	
}else{
	$idalmacenX=0;
}

if (isset($_POST['idempleadoX'])){
	$idempleadoX=htmlentities(trim($_POST['idempleadoX']));
	$idempleadoX=trim($idempleadoX);
	
}else{
	$idempleadoX=0;
}

if (isset($_POST['idproveedorX'])){
	$idproveedorX=htmlentities(trim($_POST['idproveedorX']));
	$idproveedorX=trim($idproveedorX);
	
}else{
	$idproveedorX=0;
}

if (isset($_POST['idclienteX'])){
	$idclienteX=htmlentities(trim($_POST['idclienteX']));
	$idclienteX=trim($idclienteX);
	
}else{
	$idclienteX=0;
}

if (isset($_POST['otro'])){
	$otro=htmlentities(trim($_POST['otro']));
	$otro=trim($otro);
	
}else{
	$otro="";
}


if (isset($_POST['listaSalida']) && $_POST['listaSalida']!=""){
	$lista=trim($_POST['listaSalida']);
	$lista= substr($lista, 0, -3);
	$lista=explode(":::",$lista);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>Es necesario que ingrese al menos un producto en la lista</p>";
}

$concentrado=false;
if ($concepto=="CONSIGNACION A CLIENTE" or $concepto=="CONSIGNACION A VENDEDOR" or $concepto=="M CONSIGNACION A CLIENTE" or $concepto=="M CONSIGNACION A VENDEDOR"){
	$concentrado=true;
}
if ($concentrado==true){
	$resultado=$Omovimiento->consultaGeneral(" WHERE numerocomprobante='$numerocomprobante' and tipo='salida'");
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$idcliente= $filas['idcliente'];
		$idempleado= $filas['idempleado'];
		$idalmacen= $filas['idalmacen'];
		$comentarios= $filas['comentarios'];
		$fechamovimiento=date("Y-m-d");
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El n&uacute;mero de comprobante no es v&aacute;lido o no existe</p>";
	}
}else{
	$idcliente=0;
	$idempleado=0;
}





if ($concepto=="CONSIGNACION A CLIENTE"){
	$idalmacen=$idalmacenX;
	$idcliente=$idclienteX;
	$idempleado=0;
	if ($idcliente==0){
		$validacion=false;
		$mensaje=$mensaje."<p>Se requeire que ingrese el nombre del cliente</p>";
	}
}

if ($concepto=="CONSIGNACION A VENDEDOR"){
	$idalmacen=$idalmacenX;
	$idempleado=$idempleadoX;
	$idcliente=0;
	if ($idempleado==0){
		$validacion=false;
		$mensaje=$mensaje."<p>Se requeire que elija el vendedor</p>";
	}
}

if ($concepto=="TRASPASO"){
	$idalmacen=$idalmacendestino;
	$idalmacendestino=$idalmacenX;
	if ($otro!=""){
		$numerocomprobante=$otro;
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>Se requeire que elija un traspaso v&aacute;lido</p>";
	}
	if ($idalmacen!=$idalmacendestino){
		$validacion=false;
		$mensaje=$mensaje."<p>No se puede hacer el traspaso, la sucursal de destino no corresponde con la sucursal seleccionada</p>";
	}
}

if ($concepto=="ORDEN DE COMPRA"){
	$idalmacen=$idalmacenX;
	$idproveedor=$idproveedorX;
	$tabla="compras";
	$idreferencia=$numerocomprobante;
	if ($otro!=""){
		$numerocomprobante=$otro;
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>Se requeire que elija una orden de compra v&aacute;lida</p>";
	}
}

if ($concepto!="TRASPASO"){
	$idalmacendestino=0;
}



if($validacion){
	
	$resultado=$Omovimiento->guardar($tipo,$concepto,$fechamovimiento,$hora,$numerocomprobante,$idsucursal,$tabla,$idreferencia,$comentarios,$estado,$estatus,$lista);
	$resultadoArray=explode("@",$resultado);
	$resultado=$resultadoArray[0];
	$idmovimiento=$resultadoArray[1];
	//crearDirectorio2($tipo,$concepto,$idproveedor,$numerocomprobante);
	
	if($resultado=="exito"){
		$mensaje='exito@Operaci&oacute;n exitosa@El registro ha sido guardado';
		if ($concentrado==true){
			$mensaje=$mensaje.'
				</br>
				<p>
				</br>
        		<form action="descargar.php" method="post">
            		<input name="f" type="hidden" value="'.$numerocomprobante.'-diferencia.pdf"/>
					<button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;Descargar</button>
        		</form>
				</p>
			';
		}else{
			$mensaje=$mensaje.'
				</br>
				<p>
				</br>
        		<form action="descargar.php" method="post">
            		<input name="f" type="hidden" value="'.$numerocomprobante.'-entrada.pdf"/>
					<button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;Descargar</button>
        		</form>
				</p>
			';
		}
	}
	if($resultado=="fracaso"){
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	}
	if($resultado=="denegado"){
		$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}


function crearDirectorio($tipo,$idempleado,$idcliente,$numerocomprobante){
		$Odatos= new Movimiento;
		$clasi="";
		if ($idempleado!=0){
			$clasi="vendedor";
			$nombreSujeto=$Odatos->obtenerCampo("empleados","nombre","idempleado",$idempleado);
		}
		if ($idcliente!=0){
			$clasi="cliente";
			$nombreSujeto=$Odatos->obtenerCampo("clientes","nombre","idcliente",$idcliente);
		}
		
		$rutaEmpresa="../concentrados/";
		if(!is_dir($rutaEmpresa)){ 
			mkdir($rutaEmpresa, 0777);
		}
		$nombreArchivo=$numerocomprobante."-diferencia";
		ob_start();
		include('plantilla.php');
		$content = ob_get_clean();
	
		// convert in PDF
		require_once('../../../librerias/php/html2pdf/html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P', 'Letter', 'fr');
	//      $html2pdf->setModeDebug();
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output($rutaEmpresa.$nombreArchivo.".pdf",'F');
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
		
	}
	
	
	function crearDirectorio2($tipo,$concepto,$idproveedor,$numerocomprobante){
		$Odatos= new Movimiento;
		$idmovimiento=$Odatos->obtenerCampo("movimientos","idmovimiento","numerocomprobante",$numerocomprobante);
		$clasi="";
		$nombreSujeto="";
		if ($idproveedor!=0){
			$clasi="proveedor";
			$nombreSujeto=$Odatos->obtenerCampo("proveedores","nombre","idproveedor",$idproveedor);
		}
		
		
		$rutaEmpresa="../concentrados/";
		if(!is_dir($rutaEmpresa)){ 
			mkdir($rutaEmpresa, 0777);
		}
		$nombreArchivo=$numerocomprobante."-entrada";
		ob_start();
		include('plantilla3.php');
		$content = ob_get_clean();
	
		// convert in PDF
		require_once('../../../librerias/php/html2pdf/html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P', 'Letter', 'fr');
	//      $html2pdf->setModeDebug();
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output($rutaEmpresa.$nombreArchivo.".pdf",'F');
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
		
	}

echo utf8_encode($mensaje);
?>