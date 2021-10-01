<?php 
	include("../../domicilios/Domicilio.class.php");
	
	if (isset($_POST['condicion'])) {
		$condicion=" AND domicilios.idcliente = '" . $_POST['condicion']. "'";
		
	}else{
		$condicion="";
	}
	
	$Odomicilio = new Domicilio;
	$resultado=$Odomicilio->consultaGeneral(" WHERE domicilios.estatus <> 'eliminado' $condicion");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['iddomicilio']; ?>"
        <?php
        	if($filas['iddomicilio']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['tipovialidad'] . " " . $filas['calle'] . " NO EXT. " . $filas['noexterior'] . " NO INT. " . $filas['nointerior'] . " COL. " . $filas['colonia']. " " . $filas['ciudad']. " " . $filas['estado'] . " CP. " . $filas['cp']; ?></option>
	<?php
    }
	echo '<option value="TODOS">TODOS</option>';
?>