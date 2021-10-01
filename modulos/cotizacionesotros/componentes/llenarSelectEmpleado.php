<?php 
	include("../../empleados/Empleado.class.php");
	$Oempleado = new Empleado;
	$resultado=$Oempleado->consultaGeneral(" WHERE estatus <> 'eliminado' AND (puesto ='ADMINISTRACION' OR puesto ='VENDEDOR')");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idempleado']; ?>"
        <?php
        	if($filas['idempleado']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>