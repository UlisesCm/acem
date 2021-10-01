<?php
require("../Facturacion.class.php");
$idfactura=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ofacturacion= new Facturacion;
	$resultado=$Ofacturacion->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$foliointerno=$extractor["foliointerno"];
	$fecha=$extractor["fecha"];
	$tipo=$extractor["tipo"];
	$clasificacion=$extractor["clasificacion"];
	$emisor=$extractor["emisor"];
	$rfcemisor=$extractor["rfcemisor"];
	$receptor=$extractor["receptor"];
	$rfcreceptor=$extractor["rfcreceptor"];
	$montototal=$extractor["montototal"];
	$montopagado=$extractor["montopagado"];
	$estado=$extractor["estado"];
	$fechapago=$extractor["fechapago"];
	$formapago=$extractor["formapago"];
	$cuenta=$extractor["cuenta"];
	$foliofiscal=$extractor["foliofiscal"];
	$observaciones=$extractor["observaciones"];
	$relaciones=$extractor["relaciones"];
	$archivo=$extractor["archivo"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>