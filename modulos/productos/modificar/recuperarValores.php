<?php
require("../Producto.class.php");
require("../../categorias/Categoria.class.php"); //Autocompletar
$idproducto=1;
if (isset($_POST['id'])){
	$id=html_entity_decode(trim($_POST['id']));
	$Oproducto= new Producto;
	$resultado=$Oproducto->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idfamilia=html_entity_decode($extractor["idfamilia"]);
	$nombre=html_entity_decode($extractor["nombre"]);
	$codigo=html_entity_decode($extractor["codigo"]);
	$autoclasificar=html_entity_decode($extractor["autoclasificar"]);
	$clasificacion=html_entity_decode($extractor["clasificacion"]);
	$idmodeloimpuestos=html_entity_decode($extractor["idmodeloimpuestos"]);
	$idcategoria=html_entity_decode($extractor["idcategoria"]);
	$idunidad=html_entity_decode($extractor["idunidad"]);
	$marca=html_entity_decode($extractor["marca"]);
	$pesoteorico=html_entity_decode($extractor["pesoteorico"]);
	$espesor=html_entity_decode($extractor["espesor"]);
	$ancho=html_entity_decode($extractor["ancho"]);
	$color=html_entity_decode($extractor["color"]);
	$diametro=html_entity_decode($extractor["diametro"]);
	$tipo=html_entity_decode($extractor["tipo"]);
	$modelo=$extractor["modelo"];
	$modelo2=$extractor["modelo2"];
	$lado=html_entity_decode($extractor["lado"]);
	$alto=html_entity_decode($extractor["alto"]);
	$largo=html_entity_decode($extractor["largo"]);
	$aplicacion=html_entity_decode($extractor["aplicacion"]);
	$clave=$extractor["clave"];
	$descripcion=$extractor["descripcion"];
	$variacionpermitidaencosto=html_entity_decode($extractor["variacionpermitidaencosto"]);
	$costo=$extractor["costo"];
	$estatus=$extractor["estatus"];
	$Gcampos=$Oproducto->obtenerCamposFamilia($idfamilia);
	//Autocompletar idcategoria
	$Oidcategoria=new Categoria;
	$ridcategoria=$Oidcategoria->mostrarIndividual($idcategoria);
	$eidcategoria= mysqli_fetch_array($ridcategoria);
	$autoidcategoria=$eidcategoria["nombre"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>