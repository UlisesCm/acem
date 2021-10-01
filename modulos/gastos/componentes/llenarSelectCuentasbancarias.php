<?php 
	include("../../cuentasbancarias/Cuentasbancarias.class.php");
	$Ocuentasbancarias = new Cuentasbancarias;
	$resultado=$Ocuentasbancarias->consultaGeneral(" WHERE estatus <> 'eliminado'");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idcuenta']; ?>"
        <?php
        	if($filas['idcuenta']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['cuenta']; ?></option>
	<?php
    }
?>