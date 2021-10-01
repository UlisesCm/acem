<?php
require("../Contacto.class.php");
require("../../clientes/Cliente.class.php"); //Autocompletar
$idcontacto=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocontacto= new Contacto;
	$resultado=$Ocontacto->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idcliente=$extractor["idcliente"];
	$nombrecontacto=$extractor["nombrecontacto"];
	$telefono=$extractor["telefono"];
	$email=$extractor["email"];
	$departamento=$extractor["departamento"];
	$comentarios=$extractor["comentarios"];
	//Autocompletar idcliente
	$Oidcliente=new Cliente;
	$ridcliente=$Oidcliente->mostrarIndividual($idcliente);
	$eidcliente= mysqli_fetch_array($ridcliente);
	$autoidcliente=$eidcliente["nombre"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>