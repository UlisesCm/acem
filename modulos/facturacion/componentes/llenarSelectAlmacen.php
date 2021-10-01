<?php 
	include("../../sucursales/Sucursal.class.php");
	$Oalmacen = new Sucursal;
	$resultado=$Oalmacen->consultaGeneral("");
	
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	$idselect=$_SESSION['idsucursal'];
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['cp']; ?>"
        <?php
        	if($filas['idsucursal']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>