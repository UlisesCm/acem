<?php
require("../Usuario.class.php");
$idusuario=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ousuario= new Usuario;
	$resultado=$Ousuario->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$email=$extractor["email"];
	$foto=$extractor["foto"];
	$usuario=$extractor["usuario"];
	$contrasena=$extractor["contrasena"];
	$estado=$extractor["estado"];
	$idperfil=$extractor["idperfil"];
	$empresa=$extractor["empresa"];
	$controlaracceso=$extractor["controlaracceso"];
	$horainicio=$extractor["horainicio"];
	$horafin=$extractor["horafin"];
	$idregistrorelacionado=$extractor["idregistrorelacionado"];
	$tablarelacionada=$extractor["tablarelacionada"];
	$bitacora=$extractor["bitacora"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>