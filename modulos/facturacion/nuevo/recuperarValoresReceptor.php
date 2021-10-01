<?php
require("../../clientes/Cliente.class.php");
$idpersona=$idcliente;

$id=htmlentities(trim($idpersona));
$Opersona= new Cliente;
$resultado=$Opersona->mostrarIndividual($id);
$extractor = mysqli_fetch_array($resultado);
$rfcReceptor=$extractor["rfc"];
$razonsocialReceptor=$extractor["nombre"];

?>