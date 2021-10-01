<?php
require("../Detallecotizacionproducto.class.php");
$iddetallecotizacion=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Odetallecotizacionproducto= new Detallecotizacionproducto;
	$resultado=$Odetallecotizacionproducto->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$subfolio=$extractor["subfolio"];
	$idproducto=$extractor["idproducto"];
	$cantidad=$extractor["cantidad"];
	$costo=$extractor["costo"];
	$precio=$extractor["precio"];
	$subtotal=$extractor["subtotal"];
	$impuestos=$extractor["impuestos"];
	$total=$extractor["total"];
	$utilidad=$extractor["utilidad"];
	$idcotizacionproducto=$extractor["idcotizacionproducto"];
	$pesounitario=$extractor["pesounitario"];
	$cantidadentregada=$extractor["cantidadentregada"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>