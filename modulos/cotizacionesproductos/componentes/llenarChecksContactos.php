<?php 
	include("../../domicilios/Domicilio.class.php");
	$Odomicilio= new Domicilio;
	if (isset($_POST['idcliente'])) {
		$idcliente=$_POST['idcliente'];
		
	}else{
		$idcliente=0;
	}
	if (isset($_POST['iddomicilio'])) {
		$iddomicilio=$_POST['iddomicilio'];
		
	}else{
		$iddomicilio=0;
	}
	$resultado=$Odomicilio->consultaLibre("SELECT * FROM contactos WHERE idcliente='$idcliente'");
	
	$con = 0;
	while ($filas=mysqli_fetch_array($resultado)) { ?>
        
	    <div class="col-sm-12">
           <label><input id="contacto<?php echo $con?>" type="checkbox" name="contactos[]" value="<?php echo $filas['idcontacto']?>">
               <?php 
			   echo $filas['nombrecontacto']." (".$filas['departamento'].")";
			   ?>
           </label>
        </div>
	<?php
	 $con++;
    }
?>