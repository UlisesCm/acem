<?php
require("../Bitacoracontrol.class.php");
$idbitacoracontrol=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Obitacoracontrol= new Bitacoracontrol;
	$resultado=$Obitacoracontrol->mostrarIndividual($id);
	$extractor = mysql_fetch_array($resultado);
	$fecha=$extractor["fecha"];
	$hora=$extractor["hora"];
	$idusuario=$extractor["idusuario"];
	$modulo=$extractor["modulo"];
	$accion=$extractor["accion"];
	$descripcion=$extractor["descripcion"];
	$idregistro=$extractor["idregistro"];
	$tabla=$extractor["tabla"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>