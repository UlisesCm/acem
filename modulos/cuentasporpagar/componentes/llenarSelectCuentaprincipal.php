<?php 
	include("../../cuentasprincipales/Cuentaprincipal.class.php");
	$Ocuentaprincipal = new Cuentaprincipal;
	$resultado=$Ocuentaprincipal->consultaGeneral(" WHERE estatus <> 'eliminado'");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idcuentaprincipal']; ?>"
        <?php
        	if($filas['idcuentaprincipal']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>