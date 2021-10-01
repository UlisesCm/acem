<?php
require("../Proveedor.class.php");
$idproveedor=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oproveedor= new Proveedor;
	$resultado=$Oproveedor->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$nivelcalidad=$extractor["nivelcalidad"];
	$nivelexistencia=$extractor["nivelexistencia"];
	$tiemporespuesta=$extractor["tiemporespuesta"];
	$rfc=$extractor["rfc"];
	$tipoprontopago=$extractor["tipoprontopago"];
	$prontopagofactura=$extractor["prontopagofactura"];
	$prontopagorecepcion=$extractor["prontopagorecepcion"];
	$email=$extractor["email"];
	$estatus=$extractor["estatus"];
	
	$pos = strpos($email, "[");
	if($pos===false){
		$arrayemail=explode(",",$email);
		$email="[";
		$con=0;
		while($con < count($arrayemail)){
			$email=$email.'"'.$arrayemail[$con].'"';
			$con++;
			if ($con != count($arrayemail)){
				$email=$email.',';
			}
		}
		$email=$email."]";
	
	}
	
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>