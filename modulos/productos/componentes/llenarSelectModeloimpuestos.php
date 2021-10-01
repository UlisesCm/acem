<?php 
	include("../../modelosimpuestos/Modeloimpuestos.class.php");
	$Omodeloimpuestos = new Modeloimpuestos;
	$resultado=$Omodeloimpuestos->consultaGeneral(" WHERE estatus <> 'eliminado'");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idmodeloimpuestos']; ?>"
        <?php
        	if($filas['idmodeloimpuestos']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>