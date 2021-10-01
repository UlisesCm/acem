<?php
require("../Persona.class.php");
$idpersona=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Opersona= new Persona;
	$resultado=$Opersona->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$rfc=$extractor["rfc"];
	$razonsocial=$extractor["razonsocial"];
	$usocfdi=$extractor["usocfdi"];
	$calle=$extractor["calle"];
	$numeroexterior=$extractor["numeroexterior"];
	$numerointerior=$extractor["numerointerior"];
	$colonia=$extractor["colonia"];
	$municipio=$extractor["municipio"];
	$localidad=$extractor["localidad"];
	$estado=$extractor["estado"];
	$pais=$extractor["pais"];
	$cp=$extractor["cp"];
	$email=$extractor["email"];
	$mensaje=$extractor["mensaje"];
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