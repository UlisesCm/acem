<?php
require("../Cotizacionotro.class.php");
$idcotizacionesotros=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocotizacionotro= new Cotizacionotro;
	$resultado=$Ocotizacionotro->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$serie=$extractor["serie"];
	$folio=$extractor["folio"];
	$fecha=$extractor["fecha"];
	$tipo=$extractor["tipo"];
	$monto=$extractor["monto"];
	$idcliente=$extractor["idcliente"];
	$idsucursal=$extractor["idsucursal"];
	$idempleado=$extractor["idempleado"];
	$observaciones=$extractor["observaciones"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>