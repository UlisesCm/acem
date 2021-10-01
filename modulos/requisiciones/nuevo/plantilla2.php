<?php
include("../../productos/Producto.class.php");

if (isset($_POST['listaSalida']) && $_POST['listaSalida']!=""){
	$lista=trim($_POST['listaSalida']);
	$lista= substr($lista, 0, -3);
	$lista=explode(":::",$lista);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>Es necesario que ingrese al menos un producto en la lista</p>";
}


$consulta="SELECT * FROM kardex WHERE idmovimiento='$idmovimientosalida'";
$Oconcentrado=new Movimiento;
$Oproducto = new Producto;
$con2=0;
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
                    <td>ENTRADA DE TRASPASO | DIFERENCIA</td>
                  </tr>
                  <tr>
                    <td>Almacén de Origen:</td>
                    <td><?php echo strtoupper(html_entity_decode($nombreAlmacen1)); ?></td>
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
        <th style="width:10mm; text-align:center;">CANTIDAD</th>
    </tr>

<?php
$con=1;
while ($filas=mysqli_fetch_array($resultado)) { 
	$idproducto= $filas['idproducto'];
	$cantidad1= $filas['salida'];
	$idalmacen= $filas['idalmacen'];
	$idmovimiento= $filas['idmovimiento'];
	$resultado2=$Oconcentrado->consultaLibre("SELECT * FROM kardex WHERE idproducto='$idproducto' AND idmovimiento='$idmovimientoentrada'");
		$con=0;
		if(mysqli_num_rows($resultado2) > 0){
			while ($filas2=mysqli_fetch_array($resultado2)) { 
				$cantidad2=$filas2['entrada'];
				$diferencia=$cantidad1-$cantidad2;
				if ($diferencia > 0){ //Si hay una diferencia de la cantidad del producto que sale y la que entra se crea una diferencia ?>
					<tr>
						<td style="width:6mm; text-align:center;" ><?php echo $con; ?></td>
						<td style="width:3mm; text-align:center;" ></td>
						<td style="width:38mm;font-size:9px; padding:2mm;">
						<barcode type="C39" value="<?php echo $codigo; ?>" label="label" style="width:38mm; height:8mm; font-size: 2mm"></barcode>
						</td>
						<td style="font-size:9px; width:61mm;"><?php echo $idproducto; ?></td>
						<td style="width:10mm; text-align:center;" ><?php echo number_format($diferencia,0); ?></td>
					</tr>
                <?php
				}else if ($diferencia < 0){
					$diferencia=$diferencia*(-1); ?>
					<tr>
						<td style="width:6mm; text-align:center;" ><?php echo $con; ?></td>
						<td style="width:3mm; text-align:center;" ></td>
						<td style="width:38mm;font-size:9px; padding:2mm;">
						<barcode type="C39" value="<?php echo $codigo; ?>" label="label" style="width:38mm; height:8mm; font-size: 2mm"></barcode>
						</td>
						<td style="font-size:9px; width:61mm;"><?php echo $idproducto; ?></td>
						<td style="width:10mm; text-align:center;" ><?php echo number_format($diferencia,0); ?></td>
					</tr>
                <?php
				}
				$con++;
			}
		}else{
			//Si no se encuentra ninguna entrada es porque no regresaron los productos y crea una diferencia ?>
            		<tr>
						<td style="width:6mm; text-align:center;" ><?php echo $con; ?></td>
						<td style="width:3mm; text-align:center;" ></td>
						<td style="width:38mm;font-size:9px; padding:2mm;">
						<barcode type="C39" value="<?php echo $codigo; ?>" label="label" style="width:38mm; height:8mm; font-size: 2mm"></barcode>
						</td>
						<td style="font-size:9px; width:61mm;"><?php echo $idproducto; ?></td>
						<td style="width:10mm; text-align:center;" ><?php echo number_format($cantidad1,0); ?></td>
					</tr>
		<?php
		}
		$con2++;
		
?>
  

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