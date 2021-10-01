<?php 
	include("../../folios/Folio.class.php");
	$OFolio = new Folio;
	
	
	if (isset($_POST['condicion'])) {
		$idselect=$_POST['condicion'];
	}else{
		$idselect=1;
	}
	
	$resultado=$OFolio->consultaGeneral(" WHERE idsucursal = '$idselect' AND (asignacion ='PRODUCTOS' OR asignacion='OTROS') AND estatus <> 'eliminado'");
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['serie']; ?>" tiposerie="<?php echo $filas['asignacion']; ?>"
        <?php
        	if($filas['idfolio']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['serie'] . " (" . $filas['asignacion'] . ")"; ?></option>
	<?php
    }
	if($idselect==1){
		echo '<option value="TODOS" selected="selected" tiposerie="TODOS">TODOS</option>';
	}else{
		echo '<option value="TODOS" selected="selected" tiposerie="TODOS">TODOS</option>';
	}
?>