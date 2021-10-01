<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Movimiento.class.php');
$Omovimiento=new Movimiento;
$mensaje="";
$validacion=true;

if (isset($_POST['numerocomprobante'])){
	$numerocomprobante=htmlentities(trim($_POST['numerocomprobante']));
	$numerocomprobante=trim($numerocomprobante);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo numerocomprobante no es correcto</p>";
}

if (isset($_POST['otro'])){
	$otro=htmlentities(trim($_POST['otro']));
	$otro=trim($otro);
	$numerocomprobante=$otro;
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo orden de compra no es correcto</p>";
}

if($validacion){
	
	$resultadoM=$Omovimiento->consultaLibre("SELECT * FROM traspasos WHERE numerocomprobante='$numerocomprobante'");
	if ($resultadoM){
		$extractorM = mysqli_fetch_array($resultadoM);
	    $idsucursalorigen=$extractorM["idsucursalorigen"];
		$idmovimiento=$extractorM["idmovimiento"];
	}else{
		$idsucursalorigen=0;
	}
	$resultado=$Omovimiento->consultaLibre("SELECT 
	 kardex$idsucursalorigen.idkardex,
	 kardex$idsucursalorigen.idproducto,
	 kardex$idsucursalorigen.salida,
	 kardex$idsucursalorigen.costounitario,
	 productos.nombre AS nombreproducto,
	 productos.codigo AS codigoproducto,
	 unidades.nombre AS unidadmedida
	 FROM
	 kardex$idsucursalorigen
	 INNER JOIN productos ON productos.idproducto=kardex$idsucursalorigen.idproducto
	 INNER JOIN unidades ON unidades.idunidad=productos.idunidad
	 WHERE kardex$idsucursalorigen.idmovimiento='$idmovimiento'");
	while ($filas=mysqli_fetch_array($resultado)) { 
		?>
    	<tr>
        <td style="display:none"><?php echo $filas['idkardex'];?></td>
        <td style="display:none"><?php echo $filas['idproducto']; ?></td>
        <td class="columnaIzquierda" style="border-left: 10px solid #25c274;"><?php echo $filas['codigoproducto'];?></td>
        <td><?php echo $filas['nombreproducto'];?></td>
        <td><?php echo $filas['unidadmedida'];?></td>
        <td><input value="<?php echo $filas['salida'];?>" name="cant<?php echo $filas['idkardex'];?>" type="text" class="caja" id="cant<?php echo $filas['idkardex'];?>" onblur="checarCeros('cant<?php echo $filas['idkardex'];?>','<?php echo $filas['idkardex'];?>')" onkeyup="permitirDecimal('cant<?php echo $filas['idkardex'];?>');" onfocus="activarValidacion('cant<?php echo $filas['idkardex'];?>');" style="color: rgb(0, 0, 255);"></td>
        <td><input value="<?php echo $filas['costounitario'];?>" name="cost<?php echo $filas['idkardex'];?>" type="text" class="caja" id="cost<?php echo $filas['idkardex'];?>" onblur="checarCeros('cost<?php echo $filas['idkardex'];?>','<?php echo $filas['idkardex'];?>')" onkeyup="permitirDecimal('cost<?php echo $filas['idkardex'];?>');" onfocus="activarValidacion('cost<?php echo $filas['idkardex'];?>');" style="color: rgb(255, 0, 0);"></td>
        <td><input value="0" name="pesototal<?php echo $filas['idkardex'];?>" type="text" class="caja" id="pesototal<?php echo $filas['idkardex'];?>" onblur="checarCeros('pesototal<?php echo $filas['idkardex'];?>','<?php echo $filas['idkardex'];?>')" onkeyup="permitirDecimal('pesototal<?php echo $filas['idkardex'];?>');" onfocus="activarValidacion('pesototal<?php echo $filas['idkardex'];?>');" disabled="disabled"></td>
        <td style="display:none"><input value="" name="ubicacion<?php echo $filas['idkardex'];?>" type="text" class="caja" id="ubicacion<?php echo $filas['idkardex'];?>" onblur="checarCeros('ubicacion<?php echo $filas['idkardex'];?>','<?php echo $filas['idkardex'];?>')"></td><td style="display:none"></td><td style="display:none">2961921063038</td>
        <td title="Eliminar Fila" class="eliminarFila"><a class="btn btn-default btn-xs"><i class="fa fa-trash-o text-green"></i></a><a></a></td>
        </tr>
		<?php
	}
}
echo utf8_encode($mensaje);
?>