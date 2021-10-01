<?php
	include("../../ordenescompras/Compra.class.php");
	$Ocompra = new Compra;
	$idsucursal=$_SESSION['idsucursal'];
	$resultado=$Ocompra->consultaLibre("SELECT * FROM traspasos WHERE idsucursaldestino='$idsucursal' AND estado='EN TRANSITO'");
	
	if (isset($_POST['condicion'])) {
		$idselect=$_POST['condicion'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['numerocomprobante']; ?>"
        <?php
        	if($filas['idmovimiento']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['numerocomprobante']." (".$filas['fechasalida'].")"; ?></option>
	<?php
    }
	if(mysqli_num_rows($resultado)==0){
		echo "<option value=''>No hay traspasos en tr&aacute;nisito</option>";
	}
?>