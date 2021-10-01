<?php
require("../../personas/Persona.class.php");
$idpersona=$idcliente;

$id=htmlentities(trim($idpersona));
$Opersona= new Persona;
$resultado=$Opersona->mostrarIndividual($id);
$extractor = mysqli_fetch_array($resultado);
$rfcReceptor=$extractor["rfc"];
$razonsocialReceptor=$extractor["razonsocial"];

?>