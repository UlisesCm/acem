<?php 
	include("../../vehiculos/Vehiculo.class.php");
	$Ovehiculo = new Vehiculo;
	$resultado=$Ovehiculo->consultaGeneral(" WHERE estatus <> 'eliminado'");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idvehiculo']; ?>"
        <?php
        	if($filas['idvehiculo']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['tipo']." ".$filas['marca']." ".$filas['submarca']." ".$filas['color']." PLACA: ".$filas['placa']; ?></option>
	<?php
    }
?>