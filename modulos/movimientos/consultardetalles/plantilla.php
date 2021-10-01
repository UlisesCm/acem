<?php
include("../../productos/Producto.class.php");
$consulta="SELECT * FROM kardex WHERE idmovimiento='$idmovimiento' ORDER BY clase ASC";
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
                    <td>
					<b>Número de comprobante:</b>
                    </td>
                    <td><?php echo strtoupper($numerocomprobante)?></td>
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
        <th style="width:3mm; text-align:center;"></th>
        <th style="width:38mm; text-align:center;">CODIGO</th>
        <th style="width:61mm; text-align:center;">PRODUCTO</th>
        <th style="width:10mm; text-align:center;">CANT</th>
        <th style="width:15mm; text-align:center;">P1</th>
        <th style="width:15mm; text-align:center;">P2</th>
        <th style="width:15mm; text-align:center;">P3</th>
        <th style="width:15mm; text-align:center;">P4</th>
    </tr>

<?php
$con=1;
while ($filas=mysqli_fetch_array($resultado)) { 
$idproducto= $filas['idproducto'];
$cantidad= $filas['cantidad'];
$preciopublico= $filas['preciopublico'];
$descuento= $filas['descuento'];
$precio1= $filas['precio1'];
$precio2= $filas['precio2'];
$precio3= $filas['precio3'];
$precio4= $filas['precio4'];
$clase= $filas['clase'];
if ($clase=="sobrante"){
	$clase="*";
}else{
	$clase="";
}
$resultado2=$Oproducto->mostrarIndividual($idproducto);
if(mysqli_num_rows($resultado2) > 0){
	$filas2=mysqli_fetch_array($resultado2);
	$codigo= $filas2['codigo'];
	$modelo= $filas2['modelo'];
	$nombre= $filas2['nombre'];
	$marca= $filas2['nombremarcas'];
	$categoria= $filas2['nombrecategorias'];
	$talla= $filas2['nombretallas'];
	$caracteristicas=$filas2['caracteristicas'];
	if ($talla=="NO APLICA"){
		$talla="";
	}else{
		$talla=" T:".$talla;
	}
	$tipo=$filas2['tipo'];
	$tipo= strtoupper(substr($tipo,0,1));
}else{
	$codigo="NA";
	$nombre="NA";
	$modelo="NA";
	$marca= "NA";
	$categoria="NA";
	$talla= "NA";
	$caracteristicas="NA";
	$tipo="NA";
}
	
?>
  <tr>
  	<td style="width:6mm; text-align:center;" ><?php echo $con; ?></td>
  	<td style="width:3mm; text-align:center;" ><?php echo $clase; ?></td>
    <td style="width:38mm;font-size:9px; padding:2mm;">
    <barcode type="C39" value="<?php echo $codigo; ?>" label="label" style="width:38mm; height:8mm; font-size: 2mm"></barcode>
    </td>
    <td style="font-size:9px; width:61mm;"><?php echo "<b>$tipo</b> ($marca) $nombre $talla / $categoria / <i style='font-size:8px'>$caracteristicas</i>";?></td>
    <td style="width:10mm; text-align:center;" ><?php echo number_format($cantidad,0); ?></td>
   
    <td style="width:15mm" >$<?php echo number_format($precio1,2); ?></td>
    <td style="width:15mm" >$<?php echo number_format($precio2,2); ?></td>
    <td style="width:15mm" >$<?php echo number_format($precio3,2); ?></td>
    <td style="width:15mm" >$<?php echo number_format($precio4,2); ?></td>
  </tr>

<?php 
$con++;
} ?>
</table>
</p>
<!--p>
<table bordercolor="#CCCCCC" border="0" style="border-collapse:collapse; width:200mm;">
	<tr>
        <td style="width:100%">
        	Leyenda del píe de página. Contempalda para poder registrarse un texto con unas 3 líneas de información aproximadamente
        </td>
    </tr>
</table>
</p-->
</page>