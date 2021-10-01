<?php 
	include("../../cuentassecundarias/Cuentasecundaria.class.php");
	$Ocuentasecundaria = new Cuentasecundaria;
	$idcuentaprincipal = $_POST["condicion"];
	
	$resultado=$Ocuentasecundaria->consultaGeneral(" WHERE idcuentaprincipal = $idcuentaprincipal AND estatus <> 'eliminado'");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idcuentasecundaria']; ?>"
        <?php
        	if($filas['idcuentasecundaria']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>