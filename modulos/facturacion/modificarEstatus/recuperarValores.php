<?php
require("../Venta.class.php");
$idventa=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oventa= new Venta;
	$resultado=$Oventa->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	
	$fechaNfecha=date_create($extractor['fecha']);
	$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
	$hora=$extractor["hora"];
	$formapago=$extractor["formapago"];
	$efectivo=$extractor["efectivo"];
	$credito=$extractor["credito"];
	$tarjeta=$extractor["tarjetadebito"];
	$cambio=$extractor["cambio"];
	$referencia=$extractor["reftarjetadebito"];
	$subtotal=$extractor["subtotal"];
	$iva=$extractor["iva"];
	$ieps=$extractor["ieps"];
	$total=$extractor["total"];
	$estado=$extractor["estado"];
	$idcliente=$extractor["idcliente"];
	$idcaja=$extractor["idcaja"];
	$idempleado=$extractor["idempleado"];
	$idalmacen=$extractor["idalmacen"];
	$ticket=$extractor["ticket"];
	$facturada=$extractor["facturada"];
	$plazo=$extractor["plazo"];
	$diacobro=$extractor["diacobro"];
	$frecuenciapago=$extractor["frecuenciapago"];
	$fechaplazo=$extractor["fechaplazo"];
	$archivoFactura=$extractor["archivoFactura"];
	$archivoNota=$extractor["archivoNota"];
	$fechaLiquidacion=$extractor["fechaLiquidacion"];
	$nombrecliente=$extractor["nombreclientes"];
	$nombrealmacen=$extractor["nombrealmacenes"];
	$nombreempleado=$extractor["nombreempleados"];
	
	$totalDevoluciones=$Oventa->obtenerDevoluciones($id);
	$totaltotal=$total;
	$total=$total-$totalDevoluciones;
	$totalPagado=$Oventa->obtenerPagosVentas($id);
	
	$diferenciaCredito=$total-$totalPagado;
	if ($fechaLiquidacion=="0000-00-00"){
		$fechaLiquidacion=date("Y-m-d");
	}

}else{
	header("Location: ../nuevo/nuevo.php");
}
?>