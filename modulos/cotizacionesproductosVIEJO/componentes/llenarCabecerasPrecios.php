<?php 
	include("../../productos/Producto.class.php");
	$Oproducto = new Producto;
	$resultado=$Oproducto->consultaLibre("SELECT * FROM listasprecios WHERE estatus <>'eliminado' ORDER BY nombre ASC");
	while ($filas=mysqli_fetch_array($resultado)) {?>
    	<div class="col-md-3 colprecio3">
			<input name="preciosMaestros" type="radio" value="pm1" onClick="marcarTodosPrecios(<?php echo $filas['idlistaprecios'];?>)"> <?php echo $filas['nombre'];?>
		</div>
    <?php
	}
?>