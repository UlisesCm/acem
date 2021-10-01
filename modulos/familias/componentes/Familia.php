<?php 
	include("../../familias/Familia.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Ofamilia = new Familia;
	$resultado=$Ofamilia->consultaGeneral("WHERE nombre ='$buscar' AND estatus <> 'eliminado'");
	$descripcion = new stdClass();
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['idfamilia'];
	}
	echo json_encode($descripcion);
?>
		