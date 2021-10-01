<?php 
	include("../../productos/Producto.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Oproducto = new Producto;
	$resultado=$Oproducto->consultaGeneral("WHERE nombre ='$buscar' AND estatus <> 'eliminado'");
	$descripcion = new stdClass();
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$idproducto=$filas['idproducto'];
		$descripcion->id= $filas['idproducto'];
		$descripcion->nombre= $filas['nombre'];
	}
	echo json_encode($descripcion);
?>
		