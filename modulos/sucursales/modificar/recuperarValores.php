<?php
require("../Sucursal.class.php");
require("../../ciudades/Ciudad.class.php"); //Autocompletar
require("../../estados/Estado.class.php"); //Autocompletar
$idsucursal=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Osucursal= new Sucursal;
	$resultado=$Osucursal->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$calle=$extractor["calle"];
	$numero=$extractor["numero"];
	$colonia=$extractor["colonia"];
	$cp=$extractor["cp"];
	$ciudad=$extractor["ciudad"];
	$estado=$extractor["estado"];
	$telefonocontacto=$extractor["telefonocontacto"];
	$licenciassa=$extractor["licenciassa"];
	$serie=$extractor["serie"];
	$folio=$extractor["folio"];
	$idcuentacorreo=$extractor["idcuentacorreo"];
	$archivofirma=$extractor["archivofirma"];
	$estatus=$extractor["estatus"];
	//Autocompletar ciudad
	$Ociudad=new Ciudad;
	$rciudad=$Ociudad->mostrarIndividual($ciudad);
	$eciudad= mysqli_fetch_array($rciudad);
	$autociudad=$eciudad["nombre"];
	//Autocompletar estado
	$Oestado=new Estado;
	$restado=$Oestado->mostrarIndividual($estado);
	$eestado= mysqli_fetch_array($restado);
	$autoestado=$eestado["nombre"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>