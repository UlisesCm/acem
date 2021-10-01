<?php 
	include("../../sucursales/Sucursal.class.php");
	$Oalmacen = new Sucursal;
	$campo="cp";
	if (isset($_POST['condicion'])) {
		$idselect=$_POST['condicion'];
		if ($idselect=="x"){
			$idselect=$_SESSION['idsucursal'];
			$campo="idsucursal";
		}
	}else{
		$idselect=$_SESSION['idalmacen'];
	}
	$resultado=$Oalmacen->consultaGeneral("WHERE $campo='$idselect'");
	
	$extractor = mysqli_fetch_array($resultado);
	$folio=$extractor["folio"];
	echo $folio;
?>