<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['compras']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Compra.class.php');
require('../../productos/Producto.class.php');
$Oproducto=new Producto;
if (isset($_POST["idcompra"])){
	$idcompra=$_POST["idcompra"];
}else{
	$idcompra=0;
}

$Ocompra= new Compra;
$resultado=$Ocompra->consultaLibre("SELECT
										detallecompras.iddetallecompra,
										detallecompras.idcompra,
										detallecompras.idproducto,
										detallecompras.cantidad,
										detallecompras.monto,
										detallecompras.costo,
										productos.nombre AS nombreproducto,
										productos.codigo AS codigoproducto,
										productos.pesoteorico AS pesoproducto,
										productos.pesoreal,
										sucursales.nombre AS nombresucursal,
										compras.idsucursal,
										compras.idproveedor,
										proveedores.nombre AS nombreproveedor,
										unidades.nombre AS nombreunidad
										FROM detallecompras
										INNER JOIN productos ON detallecompras.idproducto=productos.idproducto
										INNER JOIN unidades ON productos.idunidad=unidades.idunidad
										INNER JOIN compras ON compras.idcompra=detallecompras.idcompra
										INNER JOIN sucursales ON sucursales.idsucursal=compras.idsucursal
										INNER JOIN proveedores ON proveedores.idproveedor=compras.idproveedor
										WHERE detallecompras.idcompra='$idcompra'");

if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA

$con=1000;
while ($filas=mysqli_fetch_array($resultado)) { 

	$costoCompra=$filas["costo"];
	$cantidad=$filas["cantidad"];
	$pesoproducto=$filas["pesoproducto"];
	$pesoreal=$filas["pesoreal"];
	$idsucursal=$filas["idsucursal"];
	$nombresucursal=$filas["nombresucursal"];
	$idproveedor=$filas["idproveedor"];
	$nombreproveedor=$filas["nombreproveedor"];
	if ($pesoproducto==""){
		$pesoproducto=0;
	}
	$pesototal=$pesoproducto*$cantidad;
	if ($pesototal!=0){
		$costo2=($cantidad*$costoCompra)/$pesototal;
	}else{
		$costo2=0;
	}
	
	$datosStocks=$Oproducto->calcularStocks($filas['idproducto']);
	$existencias=$Oproducto->obtenerExistencias($filas['idproducto']);
	if ($existencias==""){
		$existencias=0;
	}
	
	$habilitar="";
	if ($pesoreal==0 and $pesoproducto==0){
		$habilitar='disabled="disabled"';
	}
	?>
        
        <tr>
        <td style="display:none"><?php echo $con;?></td>
        <td style="display:none"><?php echo $filas["idproducto"];?></td>
        <td style="display:none" class="columnaIzquierda codigoproducto" style="border-left: 10px solid #909;"><?php echo $filas["codigoproducto"];?></td>
        <td class="columnaIzquierda nombreproducto" style="border-left: 10px solid #909;"><?php echo html_entity_decode($filas["nombreproducto"]);?></td>
        <td class="nombreunidad"><?php echo $filas["nombreunidad"];?></td>
        <td class="cantidad"><input value="<?php echo $filas["cantidad"];?>" name="cant<?php echo $con;?>" type="text" class="caja" id="cant<?php echo $con;?>" onblur="calcular('cant','<?php echo $con;?>')" onkeyup="permitirDecimal('cant<?php echo $con;?>');" onfocus="activarValidacion('cant<?php echo $con;?>');" style="color: blue;"></td>
        <td class="costo"><input value="<?php echo $costoCompra;?>" name="cost<?php echo $con;?>" type="text" class="caja" id="cost<?php echo $con;?>" onblur="calcular('cost','<?php echo $con;?>')" onkeyup="permitirDecimal('cost<?php echo $con;?>');" onfocus="activarValidacion('cost<?php echo $con;?>');" style="color: red;"></td>
        
        <td class="costo2"><input value="<?php echo $costo2;?>" name="cost2<?php echo $con;?>" type="text" class="caja" id="cost2<?php echo $con;?>" onblur="calcular('cost2','<?php echo $con;?>')" onkeyup="permitirDecimal('cost2<?php echo $con;?>');" onfocus="activarValidacion('cost2<?php echo $con;?>');" style="color: red;"  <?php echo $habilitar?>></td>
        
        <td class="monto" id="monto<?php echo $con;?>"><?php echo $cantidad*$costoCompra;?></td>
        <td class="pesoteoricounitario" id="pesoteoricounitario<?php echo $con;?>"><?php echo $pesoproducto;?></td>
        <td class="pesoreal" id="pesoreal<?php echo $con;?>"><?php echo $pesoreal;?></td>
        <td class="pesoteorico">
			<input value="<?php echo $pesototal;?>" name="pesoteorico<?php echo $con;?>" type="text" class="caja" id="pesoteorico<?php echo $con;?>" onblur="calcular('pesoteorico','<?php echo $con;?>')" onkeyup="permitirDecimal('pesoteorico<?php echo $con;?>');" onfocus="activarValidacion('pesoteorico<?php echo $con;?>');" style="color: red;" <?php echo $habilitar?>>
        </td>
        <td class="existencias" id="existencias<?php echo $con;?>"><?php echo $existencias; ?></td>
        <td class="stockminimo" id="stockminimo<?php echo $con;?>"><?php echo $datosStocks[0] ?></td>
        <td class="stockmaximo" id="stockmaximo<?php echo $con;?>"><?php echo $datosStocks[1] ?></td>
        <td id="idsucursal<?php echo $con?>" class="idsucursal" style='display:none'><?php echo $idsucursal;?></td>
        <td id="nombresucursal<?php echo $con?>" class="nombresucursal"><?php echo $nombresucursal;?></td>
        
        <td title="Eliminar Fila" class="eliminarFila" width="30"><a class="btn btn-default btn-xs"><i class="fa fa-trash-o text-green"></i></a></td>
        
        </tr>
            
    <?php
	$con++;
}//Fin de while si es tabla ?>