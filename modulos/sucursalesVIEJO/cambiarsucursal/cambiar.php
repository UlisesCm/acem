<?php 
session_start();
if (isset($_POST["id"]) and isset($_POST["nombre"])){
	$_SESSION["idsucursal"]=$_POST["id"];
	$_SESSION["nombresucursal"]=$_POST["nombre"];
	header("Location: ../../inicio/inicio/inicio.php");
}else{
	header("vista.php");
}
?>