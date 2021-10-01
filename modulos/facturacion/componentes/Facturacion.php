<?php 
	include("../../facturacion/Facturacion.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Ofacturacion = new Facturacion;
	$resultado=$Ofacturacion->consultaGeneral("WHERE foliointerno ='$buscar'");
	$descripcion = new stdClass();
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['idfactura'];
	}
	echo json_encode($descripcion);
?>
		