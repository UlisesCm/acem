<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
require('../Compra.class.php');

if (isset($_GET['req'])){
	$idcompra=htmlentities(trim($_GET['req']));
	//$idvendedor=mysql_real_escape_string($idvendedor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo req no es correcto</p>";
}

if (isset($_GET['token'])){
	$idproveedor=htmlentities(trim($_GET['token']));
	//$idvendedor=mysql_real_escape_string($idvendedor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo token no es correcto</p>";
}

//Recuperar el nombre del vendedor

$Ocompra=new Compra;
$resultado=$Ocompra->mostrarIndividual($idcompra);
$filas=mysqli_fetch_array($resultado);
$nombreProveedor=$filas['nombreproveedores'];
$nombreSucursal=$filas['nombresucursales'];
$fechaSolicitud=$filas['fecha'];

$resultado2=$Ocompra->consultaLibre("SELECT nombrecomercial, logo FROM empresa WHERE 1");
if ($resultado2){
	$extractor2 = mysqli_fetch_array($resultado2);
	$nombrecomercial=$extractor2["nombrecomercial"];
	$logo=$extractor2["logo"];
}else{
	$nombrecomercial="";
	$logo="";
}

//Consulta para recuperar la lista de códigos
$resultado=$Ocompra->consultarImpresion($idcompra,$idproveedor);
$cantidad=$resultado[1];
$resultado=$resultado[0];

$hojas=$cantidad/30;
$cabecera=true;
$contador=1;
$conh=0;
while ($filas=mysqli_fetch_array($resultado)) { 
	$idproducto=$filas["idproducto"];
	$clave=$Ocompra->obtenerClaveProducto($idproducto,$idproveedor);
	if ($cabecera==true){
		$conh=$conh+1;
	?>
    
    <style type="text/css">
@media all {
   div.saltopagina{
      display: none;
   }
}
 
@media print{
   div.saltopagina{
      display:block;
      page-break-before:always;
   }
 
   /*No imprimir*/
   .oculto {display:none}
} 
</style>

	<page style="width:800px; height:auto; font-family:Arial;font-size:14px; color:#666666;">
	
	<table bordercolor="#CCCCCC" border="1" style="border-collapse:collapse; width:100%">
		<tr>
			<td width="300"><img src="<?php echo "../../../empresas/".$_SESSION["empresa"]."/archivosSubidos/empresa/$logo" ?>" width="100" height="100" /></td>
			<td width="453">
				<table width="453" border="0" style="font-weight:bold; font-size:15px">
					<tr align="left">
						<td width="455">Sucursal: <?php echo $nombreSucursal." / ".$nombrecomercial; ?> 
						</td>
					</tr>
				</table>
				<table width="453" border="0" style="font-size:10px;">
					  <tr>
						<td>No Orden:</td>
						<td><?php echo $idcompra; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<i><?php echo $conh." de ".ceil($hojas)?></i>)</td>
					  </tr>
					  <tr>
						<td>Proveedor:</td>
						<td><b><?php echo $nombreProveedor; ?></b></td>
					  </tr>
					  <tr>
						<td>Fecha:</td>
						<td><?php echo $fechaSolicitud; ?></td>
					  </tr>
				</table>
	
			</td>
		</tr>
	</table>
	<p>
	<table bordercolor="#CCCCCC" border="1" style="border-collapse:collapse; width:100%; font-size:14px">
		<tr bgcolor="#E9E9E9">
			<th align="center" height="30">C&Oacute;DIGO</th>
			<th align="center">PRODUCTO</th>
			<th style="width:4cm" align="center">CANTIDAD</th>
			<th align="center">UNIDAD</th>
			<th align="center"></th>
		</tr>
	
	<?php
	}

	if ($contador==30){
		$contador=1;
		$cabecera=true;
	}else{
		$contador=$contador+1;
		$cabecera=false;
	}
?>

  <tr>
    <td align="left" valign="middle" height="27">&nbsp;&nbsp;<?php echo $clave?></td>
    <td align="left" valign="middle"><?php echo $filas['nombreproducto'] ?></td>
    <td align="center"><?php echo $filas['cantidad'] ?></td>
    <td align="left"><?php echo $filas['unidad'] ?></td>
    <td align="left"></td>
  </tr>

<?php 
	if ($cabecera==true){
		?>
		</table>
		</p>
		</page>
        <?php if ($conh!=$hojas){?>
		<div class="saltopagina"></div>
		<?php 
		}
	}
} // fin de while
?>