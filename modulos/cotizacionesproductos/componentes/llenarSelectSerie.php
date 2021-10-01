<?php 
	include("../../folios/Folio.class.php");
	$OFolio = new Folio;
	$idsucursal = $_SESSION["idsucursal"];
	$resultado=$OFolio->consultaGeneral(" WHERE idsucursal = '$idsucursal' AND (asignacion ='PRODUCTOS') AND estatus <> 'eliminado'");
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idfolio']; ?>" tiposerie="<?php echo $filas['asignacion']; ?>"
        ><?php echo $filas['serie'] . " (" . $filas['asignacion'] . ")"; ?></option>
	<?php
    }
		
?>