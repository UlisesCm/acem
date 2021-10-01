<?php 
	include("../../rutas/Ruta.class.php");
	$Oruta = new Ruta;
	
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	if (isset($_POST['condicion'])) {
		$idempleado=$_POST['condicion'];
	}else{
		$idempleado=0;
	}
	if (isset($_POST['estadoliquidacion'])) {
		$estadoliquidacion=$_POST['estadoliquidacion'];
	}else{
		$estadoliquidacion="";
	}
	if (isset($_POST['fechaini'])) {
		$fechaini=$_POST['fechaini'];
	}else{
		$fechaini="";
	}
	
	if (isset($_POST['fechafin'])) {
		$fechafin=$_POST['fechafin'];
	}else{
		$fechafin="";
	}
	
	//$resultado=$Oruta->consultaGeneral(" WHERE estatus <> 'eliminado' AND idempleado = '$idempleado' AND autorizada = 'AUTORIZADA' ");
	$resultado=$Oruta->consultaRutasConDevolucionesLista($idempleado,$estadoliquidacion,$fechaini,$fechafin);
	
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idruta']; ?>"
        <?php
        	if($filas['idruta']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['serie']."-".$filas['folio']." ".$filas['nombre']. " ".$filas['fecha']; ?></option>
	<?php
    }
?>