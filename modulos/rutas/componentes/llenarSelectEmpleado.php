<?php 
	include("../../empleados/Empleado.class.php");
	$Oempleado = new Empleado;
	$resultado=$Oempleado->consultaGeneral(" WHERE estatus <> 'eliminado' AND (puesto ='CHOFER')");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	?>
	<option value="0" selected="selected">Selecciene chofer...</option>
     <?php  
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idempleado']; ?>"
        
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>