<?php
require("../Detallecotizacionotro.class.php");
require("../../clientes/Cliente.class.php"); //Autocompletar
$iddetallecotizacionotros=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Odetallecotizacionotro= new Detallecotizacionotro;
	$resultado=$Odetallecotizacionotro->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idcliente=$extractor["idcliente"];
	$fecha=$extractor["fecha"];
	$cantidad=$extractor["cantidad"];
	$concepto=$extractor["concepto"];
	$unidad=$extractor["unidad"];
	$numeroservicio=$extractor["numeroservicio"];
	$totalservicios=$extractor["totalservicios"];
	$idcotizacionotros=$extractor["idcotizacionotros"];
	$precio=$extractor["precio"];
	$impuestos=$extractor["impuestos"];
	$total=$extractor["total"];
	$idmodeloimpuestos=$extractor["idmodeloimpuestos"];
	$estadopago=$extractor["estadopago"];
	$estadofacturacion=$extractor["estadofacturacion"];
	$factura=$extractor["factura"];
	$estatus=$extractor["estatus"];
	//Autocompletar idcliente
	$Oidcliente=new Cliente;
	$ridcliente=$Oidcliente->mostrarIndividual($idcliente);
	$eidcliente= mysqli_fetch_array($ridcliente);
	$autoidcliente=$eidcliente["nombre"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>