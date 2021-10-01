<?php 
	include("../../caracteristicas/Caracteristica.class.php");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=htmlentities($_POST['seleccionado']);
	}else{
		$idselect=1;
	}
	
	if (isset($_POST['campo'])) {
		$campo=$_POST['campo'];
	}else{
		$campo=1;
	}
	
	if (isset($_POST['condicion'])) {
		$condicion=$_POST['condicion'];
	}else{
		$condicion=1;
	}
	
	$Ocaracteristica = new Caracteristica;
	$resultado=$Ocaracteristica->consultaLibre("SELECT valor FROM caracteristicas WHERE caracteristica = '$condicion' ORDER BY valor ASC");
	
	
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['valor']; ?>"
        <?php
        	if($filas['valor']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['valor']; ?></option>
	<?php
    }
?>