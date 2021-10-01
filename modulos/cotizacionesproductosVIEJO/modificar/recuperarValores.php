<?php
require("../Cotizacionproducto.class.php");
require("../../clientes/Cliente.class.php"); //Autocompletar
$idcotizacionproducto=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocotizacionproducto= new Cotizacionproducto;
	$resultado=$Ocotizacionproducto->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$serie=$extractor["serie"];
	$folio=$extractor["folio"];
	$fecha=$extractor["fecha"];
	$hora=$extractor["hora"];
	$estadopago=$extractor["estadopago"];
	$estadofacturacion=$extractor["estadofacturacion"];
	$tipo=$extractor["tipo"];
	$subtotal=$extractor["subtotal"];
	$impuestos=$extractor["impuestos"];
	$total=$extractor["total"];
	$costodeventa=$extractor["costodeventa"];
	$utilidad=$extractor["utilidad"];
	$idcliente=$extractor["idcliente"];
	$idusuario=$extractor["idusuario"];
	$idempleado=$extractor["idempleado"];
	$enviaradomicilio=$extractor["enviaradomicilio"];
	$fechaentrega=$extractor["fechaentrega"];
	$horaentregainicio=$extractor["horaentregainicio"];
	$horaentregafin=$extractor["horaentregafin"];
	$prioridad=$extractor["prioridad"];
	$iddomicilio=$extractor["iddomicilio"];
	$coordenadas=$extractor["coordenadas"];
	$observaciones=$extractor["observaciones"];
	$estadoentrega=$extractor["estadoentrega"];
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