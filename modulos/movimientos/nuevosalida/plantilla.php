<?php
include("../../productos/Producto.class.php");
$consulta="SELECT
concentrados.idconcentrado,
concentrados.idproducto,
concentrados.tipo,
concentrados.cantidad,
concentrados.preciopublico,
concentrados.descuento,
concentrados.precio1,
concentrados.precio2,
concentrados.precio3,
concentrados.precio4,
concentrados.idalmacen,
concentrados.idmovimiento,
concentrados.idcliente,
concentrados.idempleado,
concentrados.estado,
concentrados.numerocomprobante,
productos.nombre AS nombreproducto,
productos.codigo AS codigobarras,
productos.modelo AS modeloproducto,
productos.caracteristicas AS caracteristicasproducto,
productos.idmarca,
productos.idcategoria,
productos.idtalla,
tallas.nombre AS nombretallas,
categorias.nombre AS nombrecategorias,
marcas.nombre AS nombremarcas
FROM concentrados
INNER JOIN productos ON concentrados.idproducto=productos.idproducto
INNER JOIN marcas ON productos.idmarca=marcas.idmarca
INNER JOIN categorias ON productos.idcategoria=categorias.idcategoria
INNER JOIN tallas ON productos.idtalla=tallas.idtalla
WHERE concentrados.numerocomprobante='$numerocomprobante' AND concentrados.tipo='salida'
ORDER BY marcas.nombre ASC, productos.codigo ASC
";


$Oconcentrado=new Movimiento;
$Oproducto = new Producto;
$resultado=$Oconcentrado->consultaLibre($consulta); 
?>

<page style="font-family:Arial;font-size:12px; color:#666666;" backtop="0mm" backbottom="5mm" backleft="5mm" backright="5mm">

<table bordercolor="#CCCCCC" border="1" style="border-collapse:collapse; width:195mm;">
	<tr>
    	<td style="width:120mm"><img src="../../../dist/css/imagenes/logo.jpg" width="300" height="70" /></td>
        <td style="width:75mm">
        	<table border="0" style="font-weight:bold; font-size:20px; width:75mm">
            	<tr align="center">
        			<td style="width:75mm">
                    	 <?php echo $numerocomprobante; ?>
                    </td>
                </tr>
            </table>
        	<table border="0" style="font-size:10px;width:75mm">
                  <tr>
                    <td><b>Tipo:</b></td>
                    <td><?php echo strtoupper($tipo); ?></td>
                  </tr>
                  <tr>
                    <td><?php
                    if ($clasi=="vendedor"){
                    	echo "<b>Vendedor:</b>";
                    }
					if ($clasi=="cliente"){
                    	echo "<b>Cliente:</b>";
                    }
                    ?>
                    </td>
                    <td><?php echo strtoupper(html_entity_decode($nombreSujeto)); ?></td>
                  </tr>
                  <tr>
                    <td><b>Fecha:</b></td>
                    <td><?php echo date('d/m/Y'); ?></td>
                  </tr>
			</table>

        </td>
    </tr>
</table>

<p>
<table bordercolor="#CCCCCC" border="1" style="border-collapse:collapse; font-size:10px; width:195mm;">
	<tr bgcolor="#E9E9E9">
    	<th style="width:6mm; text-align:center; height:5mm">NO.</th>
        <th style="width:35mm; text-align:center;">CODIGO</th>
        <th style="width:50mm; text-align:center;">PRODUCTO</th>
        <th style="width:10mm; text-align:center;">CANT</th>
        <th style="width:14mm; text-align:center;">P.P</th>
        <th style="width:10mm; text-align:center;">DESC</th>
        <th style="width:14mm; text-align:center;">P1</th>
        <th style="width:14mm; text-align:center;">P2</th>
        <th style="width:14mm; text-align:center;">P3</th>
        <th style="width:14mm; text-align:center;">P4</th>
    </tr>

<?php
$con=1;
$cantidadtotal=0;
while ($filas=mysqli_fetch_array($resultado)) { 
$idproducto= $filas['idproducto'];
$cantidad= $filas['cantidad'];
$preciopublico= $filas['preciopublico'];
$descuento= $filas['descuento'];
$precio1= $filas['precio1'];
$precio2= $filas['precio2'];
$precio3= $filas['precio3'];
$precio4= $filas['precio4'];

$codigo= $filas['codigobarras'];
$modelo= $filas['modeloproducto'];
$nombre= $filas['nombreproducto'];
$marca= $filas['nombremarcas'];
$categoria= $filas['nombrecategorias'];
$talla= $filas['nombretallas'];
$caracteristicas=$filas['caracteristicasproducto'];
	if ($talla=="NO APLICA"){
		$talla="";
	}else{
		$talla=" T:".$talla;
	}
	$tipo=$filas['tipo'];
	$tipo= strtoupper(substr($tipo,0,1));

	
?>

  <tr>
  	<td style="width:6mm; text-align:center;" ><?php echo $con; ?></td>
    <td style="width:35mm;font-size:12px; color:#000">
    <?php echo $codigo; ?>
    <!--barcode type="C39" value="<?php echo $codigo; ?>" label="label" style="width:50mm; height:10mm; font-size: 4mm"></barcode-->
    </td>
    <td style="font-size:9px; width:50mm;"><?php echo "<b>$tipo</b> <b style='font-size:12px; color:#000;'>($marca)</b> $nombre $talla / $categoria / <i style='font-size:8px'>$caracteristicas</i>";?></td>
    <td style="width:10mm; text-align:center;" ><?php echo number_format($cantidad,0); ?></td>
    <td style="width:14mm" >$<?php echo number_format($preciopublico,2); ?></td>
    <td style="width:10mm; text-align:center;" ><?php echo number_format($descuento,0); ?>%</td>
    <td style="width:14mm" >$<?php echo number_format($precio1,2); ?></td>
    <td style="width:14mm" >$<?php echo number_format($precio2,2); ?></td>
    <td style="width:14mm" >$<?php echo number_format($precio3,2); ?></td>
    <td style="width:14mm" >$<?php echo number_format($precio4,2); ?></td>
  </tr>
  
<?php 
$con++;
$cantidadtotal=$cantidadtotal+$cantidad;
} ?>
</table>
</p>
<p>
<table bordercolor="#CCCCCC" border="0" style="border-collapse:collapse; width:200mm;">
	<tr>
        <td style="width:195mm">
        	El vendedor <?php echo strtoupper(html_entity_decode($nombreSujeto)); ?>, asume la responsabilidad de los <?php echo $cantidadtotal;?> productos que se le han sido consignados a la fecha, autorizados por <?php echo $_SESSION["nombreusuario"];?>.
            <p>
            Habiendo constatado la veracidad del documento, firman por aceptación: Consignatario:_______________________________. Autoriza:_____________________________.
            </p> 
        </td>
    </tr>
</table>
</p>
</page>