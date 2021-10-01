<?php 
	include("../../productos/Producto.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Oproducto = new Producto;
	$resultado=$Oproducto->consultaGeneral("WHERE nombre ='$buscar'");
	$descripcion = new stdClass();
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['idproducto'];
	}
	echo json_encode($descripcion);
?>
		