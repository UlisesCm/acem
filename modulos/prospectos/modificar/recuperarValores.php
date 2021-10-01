<?php
require("../Cliente.class.php");
$idcliente=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocliente= new Cliente;
	$resultado=$Ocliente->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$rfc=$extractor["rfc"];
	$nombre=$extractor["nombre"];
	$nic=$extractor["nic"];
	$limitecredito=$extractor["limitecredito"];
	$diascredito=$extractor["diascredito"];
	$saldo=$extractor["saldo"];
	$nombrecontacto=$extractor["nombrecontacto"];
	$correocontacto=$extractor["correocontacto"];
	$telefonocontacto=$extractor["telefonocontacto"];
	$autorizardosis=$extractor["autorizardosis"];
	$autorizarproductos=$extractor["autorizarproductos"];
	$estatus=$extractor["estatus"];
	//Autocompletar rfc
	$Orfc=new Cliente;
	$rrfc=$Orfc->mostrarIndividual($rfc);
	$erfc= mysqli_fetch_array($rrfc);
	$autorfc=$erfc["rfc"];
	//Autocompletar nombre
	$Onombre=new Cliente;
	$rnombre=$Onombre->mostrarIndividual($nombre);
	$enombre= mysqli_fetch_array($rnombre);
	$autonombre=$enombre["nombre"];
	//Autocompletar nic
	$Onic=new Cliente;
	$rnic=$Onic->mostrarIndividual($nic);
	$enic= mysqli_fetch_array($rnic);
	$autonic=$enic["nic"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>