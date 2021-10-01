<?php 
	include("../../sucursales/Sucursal.class.php");
	$Osucursal = new Sucursal;
	$resultado=$Osucursal->consultaGeneral(" WHERE estatus <> 'eliminado'");
	
	$idselect=$_SESSION['idsucursal'];//autoseleccionar sucursal en uso
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idsucursal']; ?>"
        <?php
        	if($filas['idsucursal']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>