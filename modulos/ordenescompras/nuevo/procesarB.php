<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['ordenescompras']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Compra.class.php');
require('../../productos/Producto.class.php');
if (isset($_POST["idrequisicion"])){
	$idrequisicion=$_POST["idrequisicion"];
}else{
	$idrequisicion=0;
}

if (isset($_POST["parametrocotizacion"])){
	$parametrocotizacion=$_POST["parametrocotizacion"];
}else{
	$parametrocotizacion="precio";
}



$Oordencompra= new Compra;

$resultadoP=$Oordencompra->consultaLibre("SELECT
										requisiciones.idrequisicion,
										requisiciones.idsucursal,
										requisiciones.idproveedor,
										proveedores.nombre AS nombreproveedor,
										sucursales.nombre AS nombresucursales
										FROM requisiciones
										INNER JOIN sucursales ON requisiciones.idsucursal=sucursales.idsucursal
										INNER JOIN proveedores ON proveedores.idproveedor=requisiciones.idproveedor
										WHERE requisiciones.idrequisicion='$idrequisicion'");
$extractor = mysqli_fetch_array($resultadoP);
$idsucursal=$extractor["idsucursal"];
$nombresucursal=$extractor["nombresucursales"];
$idproveedor=$extractor["idproveedor"];
$nombreproveedor=$extractor["nombreproveedor"];
										
$resultado=$Oordencompra->consultaLibre("SELECT
										detallerequisiciones.iddetallerequisicion,
										detallerequisiciones.idrequisicion,
										detallerequisiciones.idproducto,
										detallerequisiciones.cantidad,
										detallerequisiciones.monto,
										detallerequisiciones.costo,
										detallerequisiciones.estado,
										productos.nombre AS nombreproducto,
										productos.codigo AS codigoproducto,
										productos.pesoteorico AS pesoproducto,
										productos.pesoreal AS pesoreal,
										unidades.nombre AS nombreunidad
										FROM detallerequisiciones
										INNER JOIN productos ON detallerequisiciones.idproducto=productos.idproducto
										INNER JOIN unidades ON productos.idunidad=unidades.idunidad
										WHERE detallerequisiciones.idrequisicion='$idrequisicion' AND detallerequisiciones.estado='PENDIENTE'");

if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA

$con=2000;
$Oproducto=new Producto;
while ($filas=mysqli_fetch_array($resultado)) {
	//$datosProveedor=$Oordencompra->obtenerDatosProveedor($filas["idproducto"],$parametrocotizacion);
	//$idproveedor=$datosProveedor[0];
	//$nombreproveedor=$datosProveedor[1];
	//$costoCompra=$datosProveedor[2];
	
	$costoCompra=$filas["costo"];
	$cantidad=$filas["cantidad"];
	$pesoproducto=$filas["pesoproducto"];
	$pesoreal=$filas["pesoreal"];
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
	?>
    		
      	<tr ondblclick="abrirModal(<?php echo $filas['idproducto'] ?>,'<?php echo $filas["codigoproducto"];?>','<?php echo $filas["nombreproducto"];?>','<?php echo $con?>');">
        <td style="display:none"><?php echo $con;?></td>
        <td style="display:none"><?php echo $filas["idproducto"];?></td>
        <td class="columnaIzquierda codigoproducto" style="border-left: 10px solid #909;"><?php echo $filas["codigoproducto"];?></td>
        <td class="nombreproducto"><?php echo html_entity_decode($filas["nombreproducto"]);?></td>
        <td class="nombreunidad"><?php echo $filas["nombreunidad"];?></td>
        <td class="cantidad"><input value="<?php echo $filas["cantidad"];?>" name="cant<?php echo $con;?>" type="text" class="caja" id="cant<?php echo $con;?>" onblur="calcular('cant','<?php echo $con;?>')" onkeyup="permitirDecimal('cant<?php echo $con;?>');" onfocus="activarValidacion('cant<?php echo $con;?>');" style="color: blue;"></td>
        <td class="costo"><input value="<?php echo $costoCompra;?>" name="cost<?php echo $con;?>" type="text" class="caja" id="cost<?php echo $con;?>" onblur="calcular('cost','<?php echo $con;?>')" onkeyup="permitirDecimal('cost<?php echo $con;?>');" onfocus="activarValidacion('cost<?php echo $con;?>');" style="color: red;"></td>
        
        <td class="costo2"><input value="<?php echo $costo2;?>" name="cost2<?php echo $con;?>" type="text" class="caja" id="cost2<?php echo $con;?>" onblur="calcular('cost2','<?php echo $con;?>')" onkeyup="permitirDecimal('cost2<?php echo $con;?>');" onfocus="activarValidacion('cost2<?php echo $con;?>');" style="color: red;"></td>
        
        <td class="monto"><?php echo $cantidad*$costoCompra;?></td>
        <td class="pesoteoricounitario"><?php echo $pesoproducto;?></td>
        <td class="pesoreal"><?php echo $pesoreal;?></td>
        <td class="pesoteorico"><?php echo $pesototal;?></td>
        <td class="existencias"><?php echo $existencias; ?></td>
        <td class="stockminimo"><?php echo $datosStocks[0] ?></td>
        <td class="stockmaximo"><?php echo $datosStocks[1] ?></td>
        <td id="idsucursal<?php echo $con?>" class="idsucursal" style='display:none'><?php echo $idsucursal;?></td>
        <td id="nombresucursal<?php echo $con?>" class="nombresucursal"><?php echo $nombresucursal;?></td>
        <td id="idproveedor<?php echo $con?>" style='display:none' class="idproveedor"><?php echo $idproveedor?></td>
        <td id="nombreproveedor<?php echo $con?>" class="nombreproveedor"><?php echo $nombreproveedor?></td>
        <td title="Eliminar Fila" class="eliminarFila" width="30"><a class="btn btn-default btn-xs"><i class="fa fa-trash-o text-green"></i></a></td>
        <td title="Elegir proveedor" width="30"><a class="btn btn-default btn-xs" onclick="abrirModal('<?php echo $filas['idproducto'] ?>','<?php echo $con?>');"><i class="fa fa-industry text-blue"></i></a></td>
        </tr>
            
    <?php
	$con++;
}//Fin de while si es tabla ?>