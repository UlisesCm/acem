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
	$resultado=$Omovimiento->consultaLibre("SELECT 
	 detallecompras.iddetallecompra,
	 detallecompras.idproducto,
	 detallecompras.cantidad,
	 detallecompras.costo,
	 productos.nombre AS nombreproducto,
	 productos.codigo AS codigoproducto,
	 productos.pesoteorico,
	 productos.pesoreal,
	 unidades.nombre AS unidadmedida
	 FROM
	 detallecompras
	 INNER JOIN productos ON productos.idproducto=detallecompras.idproducto
	 INNER JOIN unidades ON unidades.idunidad=productos.idunidad
	 WHERE idcompra='$numerocomprobante'");
	while ($filas=mysqli_fetch_array($resultado)) { 
		$pesoteorico=$filas['pesoteorico'];
		$pesoreal=$filas['pesoreal'];
		if ($pesoteorico==""){
			$pesoteorico=0;
		}
		$cantidad=$filas['cantidad'];
		if ($pesoreal!=0){
			$pesototal=$pesoreal*$cantidad;
		}else{
			$pesototal=$pesoteorico*$cantidad;
		}
		$habilitar="";
		if ($pesototal==0){
			$habilitar='disabled="disabled"';
		}
		
		$textoAlert="";
		if ($cantidad!=0){
			$pesoUnitario=$pesototal/$cantidad;
			
			if ($pesoUnitario < $pesoreal or $pesoUnitario < $pesoteorico){
				$textoAlert='<span data-placement="bottom" data-toggle="tooltip" data-html="true" title="" data-original-title="El peso ingresado es mayor al peso real o al peso teórico, por favor conique esta información para cambiar el precio de venta.">
					<i class="fa fa-warning text-yellow"></i>
				</span>';
			}
		}
			
		
		?>
    	<tr>
        <td style="display:none"><?php echo $filas['iddetallecompra'];?></td>
        <td style="display:none"><?php echo $filas['idproducto']; ?></td>
        <td class="columnaIzquierda" style="border-left: 10px solid #25c274;"><?php echo $filas['codigoproducto'];?></td>
        <td><?php echo $filas['nombreproducto'];?></td>
        <td><?php echo $filas['unidadmedida'];?></td>
        <td><input value="<?php echo $filas['cantidad'];?>" name="cant<?php echo $filas['iddetallecompra'];?>" type="text" class="caja" id="cant<?php echo $filas['iddetallecompra'];?>" onblur="checarCeros('cant<?php echo $filas['iddetallecompra'];?>','<?php echo $filas['iddetallecompra'];?>')" onkeyup="permitirDecimal('cant<?php echo $filas['iddetallecompra'];?>');" onfocus="activarValidacion('cant<?php echo $filas['iddetallecompra'];?>');" style="color: rgb(0, 0, 255);"></td>
        <td><input value="<?php echo $filas['costo'];?>" name="cost<?php echo $filas['iddetallecompra'];?>" type="text" class="caja" id="cost<?php echo $filas['iddetallecompra'];?>" onblur="checarCeros('cost<?php echo $filas['iddetallecompra'];?>','<?php echo $filas['iddetallecompra'];?>')" onkeyup="permitirDecimal('cost<?php echo $filas['iddetallecompra'];?>');" onfocus="activarValidacion('cost<?php echo $filas['iddetallecompra'];?>');" style="color: rgb(255, 0, 0);"></td>
        <td>
        <input value="<?php echo $pesototal;?>" name="pesototal<?php echo $filas['iddetallecompra'];?>" type="text" class="caja" id="pesototal<?php echo $filas['iddetallecompra'];?>" onblur="checarCeros('pesototal<?php echo $filas['iddetallecompra'];?>','<?php echo $filas['iddetallecompra'];?>')" onkeyup="permitirDecimal('pesototal<?php echo $filas['iddetallecompra'];?>');" onfocus="activarValidacion('pesototal<?php echo $filas['iddetallecompra'];?>');" <?php echo $habilitar?>>
        </td>
        <td style="display:none"><input value="" name="ubicacion<?php echo $filas['iddetallecompra'];?>" type="text" class="caja" id="ubicacion<?php echo $filas['iddetallecompra'];?>" onblur="checarCeros('ubicacion<?php echo $filas['iddetallecompra'];?>','<?php echo $filas['iddetallecompra'];?>')"></td>
        <td style="display:none"></td>
        <td style="display:none">2961921063038</td>
        <td id="pesoteorico<?php echo $filas['iddetallecompra'];?>"><?php echo $pesoteorico?></td>
        <td id="pesoreal<?php echo $filas['iddetallecompra'];?>"><?php echo $pesoreal?></td>
        <td id="aviso<?php echo $filas['iddetallecompra'];?>">
        <?php echo $textoAlert; ?>
        </td>
        <td title="Eliminar Fila" class="eliminarFila"><a class="btn btn-default btn-xs"><i class="fa fa-trash-o text-green"></i></a><a></a></td>
        </tr>
		<?php
	}
}
echo utf8_encode($mensaje);
?>