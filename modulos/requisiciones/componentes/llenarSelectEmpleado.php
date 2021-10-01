<?php 
	include("../../empleados/Empleado.class.php");
	$Oempleado = new Empleado;

	$usuario = $_SESSION['idregistrorelacionado'];
	$resultado=$Oempleado->consultaGeneral("");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idempleado']; ?>"
        <?php
        	if($filas['idempleado']==$usuario){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>