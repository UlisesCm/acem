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
			$res= $Omodeloimpuestos->consultaLibre("SELECT * FROM impuestos WHERE idmodeloimpuesto = '".$filas['idmodeloimpuestos']."'");
			$cadena="";
			while ($filas2=mysqli_fetch_array($res)) {
				$cadena= $filas2['nombre']. ":" . $filas2['valor'] . ",";
			}
			$cadena= substr($cadena,0,-1);
		?>
        impuestos = "<?php echo $cadena?>"><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>