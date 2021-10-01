<?php 
	include("../../domicilios/Domicilio.class.php");
	$tabla=htmlentities($_POST['tabla']);
	$campo=htmlentities($_POST['campo']);
	$valor=htmlentities($_POST['valor']);
	$Odomicilio = new Domicilio;
	$resultado=$Odomicilio->consultaLibre("SELECT COUNT( * ) AS contador FROM $tabla WHERE $campo = '$valor'");
	if ($resultado){
		$extractor = mysqli_fetch_array($resultado);
		$numero_filas=$extractor["contador"];
		if ($numero_filas=="0"){
			echo "noexiste";
		}else{
			echo "existe";
		}
				
	}else{
		echo "noexiste";
	}
?>