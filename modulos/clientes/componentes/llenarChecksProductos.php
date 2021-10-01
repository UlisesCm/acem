<?php 
	include("../Cliente.class.php");
	$Ocliente= new Cliente;
	if (isset($_POST['idcliente'])) {
		$idcliente=$_POST['idcliente'];
		
	}else{
		$idcliente=0;
	}
	$resultado=$Ocliente->consultaLibre("SELECT * FROM productos");
	
	$con = 0;
	while ($filas=mysqli_fetch_array($resultado)) { ?>
        
	    <div class="col-sm-12">
           <label><input id="producto<?php echo $con?>" type="checkbox" name="productos[]" value="<?php echo $filas['idproducto']?>" <?php echo $Ocliente->comprobarAutorizarProductos($idcliente,$filas['idproducto'])?>>
               <?php 
			   echo $filas['nombre'];
			   ?>
           </label>
        </div>
	<?php
	 $con++;
    }
?>