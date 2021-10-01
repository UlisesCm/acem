<?php 
	include("../../sucursales/Sucursal.class.php");
	$Osucursal = new Sucursal;
	$resultado=$Osucursal->consultaGeneral(" WHERE estatus <> 'eliminado'");
	
	if (isset($_POST['condicion'])) {
		$idselect=$_POST['condicion'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idsucursal']; ?>"
        <?php
        	if($filas['idsucursal']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
	if($idselect==1){
		echo '<option value="TODAS" selected="selected">TODAS</option>';
	}else{
		echo '<option value="TODAS">TODAS</option>';
	}
?>