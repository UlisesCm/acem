<?php 
	include("../../productos/Producto.class.php");
	$Oproducto=new Producto;
	if (isset($_POST['idproducto'])) {
		$idproducto=$_POST['idproducto'];
	}else{
		$idproducto=1;
	}
	
	if (isset($_POST['idproveedor'])) {
		$idproveedor=$_POST['idproveedor'];
	}else{
		$idproveedor=1;
	}
	
	$datosproveedor=$Oproducto->comprobarProveedor($idproducto,$idproveedor);
	$idproveedor=$datosproveedor[0];
	$nombreproveedor=$datosproveedor[1];
	echo $idproveedor."@".$nombreproveedor;
?>	