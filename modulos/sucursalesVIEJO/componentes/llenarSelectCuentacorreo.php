<?php 
	include("../../cuentascorreo/Cuentacorreo.class.php");
	$Ocuentacorreo = new Cuentacorreo;
	$resultado=$Ocuentacorreo->consultaGeneral(" WHERE estatus <> 'eliminado'");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idcuentacorreo']; ?>"
        <?php
        	if($filas['idcuentacorreo']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['usuario']; ?></option>
	<?php
    }
?>