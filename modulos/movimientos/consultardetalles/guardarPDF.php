<?php 
include ("../../seguridad/comprobar_login.php");
require('../../kardex/Kardex.class.php');
require('../Movimiento.class.php');

if (isset($_POST['idmovimiento'])){
	$idmovimiento=$_POST['idmovimiento'];
}else{
	$idmovimiento=0;
}

$Omovimiento=new Movimiento ;
$Okardex= new Kardex;

$resultado=$Omovimiento->consultaGeneral("WHERE idmovimiento='$idmovimiento'");
if ($resultado){
	$extractor = mysqli_fetch_array($resultado);
	$tipo=$extractor["tipo"];
	$concepto=$extractor["concepto"];
	$idalmacen=$extractor["idalmacen"];
	$numerocomprobante=$extractor["numerocomprobante"];
	$comentarios=$extractor["comentarios"];
	$idreferencia=$extractor["idreferencia"];
	$idproveedor=$extractor["idproveedor"];
	$fechaNfechamovimiento=date_create($extractor['fechamovimiento']);
	$nuevaFecha= date_format($fechaNfechamovimiento, 'd/m/Y');
}

$nombreAlmacen=$Okardex->obtenerCampo("almacenes","nombre","idalmacen",$idalmacen);
$nombreProveedor=$Okardex->obtenerCampo("proveedores","nombre","idproveedor",$idproveedor);

		
$rutaEmpresa="../movimientos/";
if(!is_dir($rutaEmpresa)){ 
	mkdir($rutaEmpresa, 0777);
}
$nombreArchivo="movimiento_almacen";
ob_start();
include('plantilla.php');
$content = ob_get_clean();
	
		// convert in PDF
require_once('../../../librerias/php/html2pdf/html2pdf.class.php');
try{
	$html2pdf = new HTML2PDF('P', 'Letter', 'fr');
	//$html2pdf->setModeDebug();
	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output($rutaEmpresa.$nombreArchivo.".pdf",'F');
}catch(HTML2PDF_exception $e) {
	echo $e;
	exit;
}
?>