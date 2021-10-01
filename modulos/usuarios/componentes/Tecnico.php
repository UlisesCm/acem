<?php
	include("../../tecnicos/Tecnico.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Otecnico = new Tecnico;
	$resultado=$Otecnico->consultaGeneral("WHERE nombre ='$buscar' AND estatus <> 'eliminado'");
	$descripcion = new stdClass();
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['idtecnico'];
	}
	echo json_encode($descripcion);
?>
