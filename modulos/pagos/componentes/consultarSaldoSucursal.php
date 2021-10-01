<?php 
	include("../../sucursales/Sucursal.class.php");
	$Osucursal = new sucursal;
	
	if (isset($_POST['formadepago'])) {
		$formadepago=$_POST['formadepago'];
	}
	$idsucursal = $_SESSION['idsucursal'];
	$resultado=$Osucursal->consultaGeneral(" WHERE idsucursal = $idsucursal");
	if ($filas=mysqli_fetch_array($resultado)) { 
	  echo $filas[$formadepago];
    }
?>