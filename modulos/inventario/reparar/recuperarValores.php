<?php
require("../Inventario.class.php");
require("../../productos/Producto.class.php"); //Autocompletar
$idinventario=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oinventario= new Inventario;
	$resultado=$Oinventario->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idalmacen=$extractor["idalmacen"];
	$idproducto=$extractor["idproducto"];
	$existencia=$extractor["existencia"];
	$promedio=$extractor["promedio"];
	$saldo=$extractor["saldo"];
	$minimo=$extractor["minimo"];
	$ubicacion=$extractor["ubicacion"];
	$estado=$extractor["estado"];
	//Autocompletar idproducto
	$Oidproducto=new Producto;
	$ridproducto=$Oidproducto->mostrarIndividual($idproducto);
	$eidproducto= mysqli_fetch_array($ridproducto);
	$autoidproducto=$eidproducto["nombre"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>