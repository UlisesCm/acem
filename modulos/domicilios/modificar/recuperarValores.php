<?php
require("../Domicilio.class.php");
require("../../ciudades/Ciudad.class.php"); //Autocompletar
$iddomicilio=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Odomicilio= new Domicilio;
	$resultado=$Odomicilio->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idcliente=$extractor["idcliente"];
	$tipovialidad=$extractor["tipovialidad"];
	$calle=$extractor["calle"];
	$noexterior=$extractor["noexterior"];
	$nointerior=$extractor["nointerior"];
	$nombrecomercial=$extractor["nombrecomercial"];
	$colonia=$extractor["colonia"];
	$cp=$extractor["cp"];
	$ciudad=$extractor["ciudad"];
	$estado=$extractor["estado"];
	$idzona=$extractor["idzona"];
	$coordenadas=$extractor["coordenadas"];
	$referencia=$extractor["referencia"];
	$observaciones=$extractor["observaciones"];
	$idsucursal=$extractor["idsucursal"];
	$idgirocomercial=$extractor["idgirocomercial"];
	$validardosis=$extractor["validardosis"];
	$idempleado=$extractor["idempleado"];
	$estatus=$extractor["estatus"];
	//Autocompletar calle
	$Ocalle=new Domicilio;
	$rcalle=$Ocalle->mostrarIndividual($calle);
	$ecalle= mysqli_fetch_array($rcalle);
	$autocalle=$ecalle["calle"];
	//Autocompletar noexterior
	$Onoexterior=new Domicilio;
	$rnoexterior=$Onoexterior->mostrarIndividual($noexterior);
	$enoexterior= mysqli_fetch_array($rnoexterior);
	$autonoexterior=$enoexterior["noexterior"];
	//Autocompletar nombrecomercial
	$Onombrecomercial=new Domicilio;
	$rnombrecomercial=$Onombrecomercial->mostrarIndividual($nombrecomercial);
	$enombrecomercial= mysqli_fetch_array($rnombrecomercial);
	$autonombrecomercial=$enombrecomercial["nombrecomercial"];
	//Autocompletar colonia
	$Ocolonia=new Domicilio;
	$rcolonia=$Ocolonia->mostrarIndividual($colonia);
	$ecolonia= mysqli_fetch_array($rcolonia);
	$autocolonia=$ecolonia["colonia"];
	//Autocompletar ciudad
	$Ociudad=new Ciudad;
	$rciudad=$Ociudad->mostrarIndividual($ciudad);
	$eciudad= mysqli_fetch_array($rciudad);
	$autociudad=$eciudad["nombre"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>