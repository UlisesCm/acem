<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
require('../../facturacion/Facturacion.class.php');
if(isset($_POST['idtemporal'])){
	$idtemporal=trim($_POST['idtemporal']);
}else{
	$idtemporal=0;
}
$Ofacturacion=new Facturacion ;

$resultado=$Ofacturacion->consultaDetallesFacturacion($idtemporal);
$con=0;
	while ($filas=mysqli_fetch_array($resultado)) { 
		$con++;
		$precio=$filas['precio'];
		$idcotizacionproducto=$filas['idcotizacionproducto'];
		$iddetallecotizacion=$filas['iddetallecotizacion'];
		$idproducto=$filas['idproducto'];
		$cantidad=$filas['cantidad'];
		$monto=$cantidad*$precio;
		$monto=$filas['total'];
		$codigo=$filas['codigoproductos'];
		$nombre=$filas['nombreproductos'];
		$unidad=$filas['unidadproductos'];
		$ticket=$filas['serie']."-".$filas['folio']."/".$filas['subfolio'];
		
		?>
        <tr>
        <td style="display:none"><?php echo $con; ?></td>
        <td style="display:none"><?php echo $idproducto; ?></td>
        <td class="columnaIzquierda" style="border-left: 10px solid #25c274;"><?php echo $codigo."-".$nombre." (Ticket: $ticket)"?></td>
        <td id="unidad<?php echo $con; ?>"><?php echo $unidad; ?></td>
        <td><input value="<?php echo $cantidad; ?>" name="cant<?php echo $con; ?>" type="text" class="caja" id="cant<?php echo $con; ?>" onblur="checarCeros('cant<?php echo $con; ?>','<?php echo $con; ?>')" onkeypress="return soloNumeros(event,'cant<?php echo $con; ?>');" style="color: rgb(0, 0, 255);"></td>
        <td id="precio<?php echo $con; ?>"><?php echo $precio; ?></td>
        <td id="total<?php echo $con; ?>"><?php echo $monto; ?></td><td id="descuento<?php echo $con; ?>" style="display:none">0.000000</td>
        <td id="descuentoT<?php echo $con; ?>">0.00</td>
        <td style="display:none" id="idcotizacionproducto<?php echo $con; ?>"><?php echo $iddetallecotizacion; ?></td>
        <td title="Eliminar Fila" class="eliminarFila"><a class="btn btn-default btn-xs"><i class="fa fa-trash-o text-green"></i></a><a></a></td>
        </tr>
        <?php
	}
 ?>
		