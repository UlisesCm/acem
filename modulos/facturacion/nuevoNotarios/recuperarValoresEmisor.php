<?php
require("../../empresa/Empresa.class.php");
$idempresa=1;
if ($idempresa){
	$id=htmlentities(trim($idempresa));
	$Oempresa= new Empresa;
	$resultado=$Oempresa->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$regimenEmisor=$extractor["regimen"];
	$rfcEmisor=$extractor["rfc"];
	$razonsocialEmisor=$extractor["razonsocial"];
	$calle=$extractor["calle"];
	$numeroexterior=$extractor["numeroexterior"];
	$numerointerior=$extractor["numerointerior"];
	$colonia=$extractor["colonia"];
	$entrecalles=$extractor["entrecalles"];
	$municipio=$extractor["municipio"];
	$localidad=$extractor["localidad"];
	$estado=$extractor["estado"];
	$pais=$extractor["pais"];
	$cpEmisor=$extractor["cp"];
	$telefono=$extractor["telefono"];
	$emailEmisor=$extractor["email"];
	$estatus=$extractor["estatus"];
	$clave_csd=$extractor["clave_csd"];
	$cer_csd=$extractor["cer_csd"];
	$key_csd=$extractor["key_csd"];
	$numero_csd=$extractor["numero_csd"];
	$logo=$extractor["logo"];
	$eshotel=$extractor["eshotel"];
	$impuestocedular=$extractor["impuestocedular"];
}
?>