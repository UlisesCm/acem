<?php
include("../../productos/Producto.class.php");
$consulta="SELECT
kardex.idkardex,
kardex.idproducto,
kardex.entrada,
kardex.costounitario,
kardex.debe,
kardex.idalmacen,
kardex.idmovimiento,
productos.nombre AS nombreproducto
FROM kardex
INNER JOIN productos ON kardex.idproducto=productos.idproducto
WHERE kardex.idmovimiento='$idmovimiento'
ORDER BY productos.nombre ASC
";


$Oproducto = new Producto;
$resultado=$Oproducto->consultaLibre($consulta); 
?>

<page style="font-family:Arial;font-size:12px; color:#666666;" backtop="0mm" backbottom="5mm" backleft="5mm" backright="5mm">
<p>
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
                    <td>Entrada</td>
                  </tr>
                  <tr>
                    <td><b><?php echo $clasi; ?></b></td>
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
</p>
<p>
<table bordercolor="#CCCCCC" border="1" style="border-collapse:collapse; font-size:10px; width:195mm;">
	<tr bgcolor="#E9E9E9">
    	<th style="width:6mm; text-align:center; height:5mm">NO.</th>
        <th style="width:35mm; text-align:center;">CODIGO</th>
        <th style="width:70mm; text-align:center;">PRODUCTO</th>
        <th style="width:20mm; text-align:center;">CANT</th>
        <th style="width:24mm; text-align:center;">COSTO</th>
        <th style="width:26mm; text-align:center;">IMPORTE</th>
    </tr>

<?php
$con=1;
$cantidadtotal=0;
$montototal=0;
while ($filas=mysqli_fetch_array($resultado)) { 
$idproducto= $filas['idproducto'];
$cantidad= $filas['entrada'];
$costounitario= $filas['costounitario'];
$debe= $filas['debe'];
$nombre= $filas['nombreproducto'];

	
?>

  <tr>
  	<td style="width:6mm; text-align:center;" ><?php echo $con; ?></td>
    <td style="width:35mm;font-size:12px; color:#000">
    <?php echo $filas['idproducto']; ?>
    <!--barcode type="C39" value="<?php //echo $codigo; ?>" label="label" style="width:50mm; height:10mm; font-size: 4mm"></barcode-->
    </td>
    <td style="font-size:9px; width:70mm;"><?php echo "<b style='font-size:12px; color:#000;'>$nombre</i>";?></td>
    <td style="width:20mm; text-align:center;" ><?php echo number_format($cantidad,0); ?></td>
    <td style="width:24mm" >$<?php echo number_format($costounitario,2); ?></td>
    <td style="width:26mm;" >$<?php echo number_format($debe,2); ?></td>
  </tr>
  
<?php 
$con++;
$cantidadtotal=$cantidadtotal+$cantidad;
$montototal=$montototal+$debe;
} ?>
</table>
</p>
<p>
<table bordercolor="#CCCCCC" border="0" style="border-collapse:collapse; width:200mm;">
	<tr>
        <td style="width:195mm">
        	El usuario <?php echo $_SESSION["nombreusuario"];?>. Ingresó la cantidad de <?php echo $cantidadtotal;?> productos, con un costo total de $ <?php echo number_format($montototal,2); ?>
        </td>
    </tr>
</table>
</p>
</page>