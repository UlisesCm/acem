<?php 
	include("../../personas/Persona.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Opersona = new Persona;
	$resultado=$Opersona->consultaGeneral("WHERE razonsocial ='$buscar' AND estatus <> 'elimiando'");
	$descripcion = new stdClass();
	$descripcion->saldofavor="0.00";
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['idpersona'];
		$descripcion->uso=$filas['usocfdi];
	}
	echo json_encode($descripcion);
?>
		