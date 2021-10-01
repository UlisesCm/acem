<?php
	include("../../sucursales/Sucursal.class.php");
	$Osucursal = new Sucursal;
	$idsucursal=$_SESSION['idsucursal'];
	$resultado=$Osucursal->consultaGeneral(" WHERE estatus <> 'eliminado'");

	if (isset($_POST['condicion'])) {
		$idselect=$_POST['condicion'];
	}else{
		$idselect=$idsucursal;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idsucursal']; ?>"
        <?php
        	if($filas['idsucursal']==$idsucursal){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>
