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
										sucursales.nombre AS nombresucursales
										FROM requisiciones
										INNER JOIN sucursales ON requisiciones.idsucursal=sucursales.idsucursal
										WHERE requisiciones.idrequisicion='$idrequisicion'");
$extractor = mysqli_fetch_array($resultadoP);
$idsucursal=$extractor["idsucursal"];
$nombresucursal=$extractor["nombresucursales"];
										
$resultado=$Oordencompra->consultaLibre("SELECT
										detallerequisiciones.iddetallerequisicion,
										detallerequisiciones.idrequisicion,
										detallerequisiciones.idproducto,
										detallerequisiciones.cantidad,
										detallerequisiciones.monto,
										detallerequisiciones.costo,
										productos.nombre AS nombreproducto,
										productos.codigo AS codigoproducto,
										productos.pesoteorico AS pesoproducto,
										unidades.nombre AS nombreunidad
										FROM detallerequisiciones
										INNER JOIN productos ON detallerequisiciones.idproducto=productos.idproducto
										INNER JOIN unidades ON productos.idunidad=unidades.idunidad
										WHERE detallerequisiciones.idrequisicion='$idrequisicion'");

if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA

$con=1000;
while ($filas=mysqli_fetch_array($resultado)) {
	$datosProveedor=$Oordencompra->obtenerDatosProveedor($filas["idproducto"],$parametrocotizacion);
	$idproveedor=$datosProveedor[0];
	$nombreproveedor=$datosProveedor[1];
	$costoCompra=$datosProveedor[2];
	$cantidad=$filas["cantidad"];
	$pesoproducto=$filas["pesoproducto"];
	$pesoTotal=$cantidad*$pesoproducto;
	$unidadMedida=$filas["nombreunidad"];
	if ($pesoproducto!=0){
		//Si el producto se compra por kilos
		$cantidad=$cantidad*$pesoproducto;
		$costoCompra=$costoCompra/$cantidad;
		$unidadMedida="KILO";
		$pesoTotal=$cantidad/$pesoproducto;
	}else{
		$pesoTotal=$cantidad;
	}
	?>
    		
      	<tr ondblclick="abrirModal(<?php echo $filas['idproducto'] ?>,'<?php echo $filas["codigoproducto"];?>','<?php echo $filas["nombreproducto"];?>','<?php echo $con?>');">
        <td style="display:none"><?php echo $con;?></td>
        <td style="display:none"><?php echo $filas["idproducto"];?></td>
        <td class="columnaIzquierda codigoproducto" style="border-left: 10px solid #909;"><?php echo $filas["codigoproducto"];?></td>
        <td class="nombreproducto"><?php echo html_entity_decode($filas["nombreproducto"]);?></td>
        <td class="nombreunidad"><?php echo $unidadMedida;?></td>
        <td class="cantidad"><input value="<?php echo $cantidad;?>" name="cant<?php echo $con;?>" type="text" class="caja" id="cant<?php echo $con;?>" onblur="checarCeros('cant<?php echo $con;?>','<?php echo $con;?>')" onkeyup="permitirDecimal('cant<?php echo $con;?>');" onfocus="activarValidacion('cant<?php echo $con;?>');" style="color: blue;"></td>
        <td class="costo"><input value="<?php echo $costoCompra;?>" name="cost<?php echo $con;?>" type="text" class="caja" id="cost<?php echo $con;?>" onblur="checarCeros('cost<?php echo $con;?>','<?php echo $con;?>')" onkeyup="permitirDecimal('cost<?php echo $con;?>');" onfocus="activarValidacion('cost<?php echo $con;?>');" style="color: red;"></td>
        <td class="monto"><?php echo $cantidad*$costoCompra;?></td>
        <td class="pesoteoricounitario"><?php echo $pesoproducto;?></td>
        
        <td class="unidades"><input value="<?php echo $pesoTotal;?>" name="unidades<?php echo $con;?>" type="text" class="caja" id="unidades<?php echo $con;?>" onblur="checarCeros('unidades<?php echo $con;?>','<?php echo $con;?>')" onkeyup="permitirDecimal('unidades<?php echo $con;?>');" onfocus="activarValidacion('unidades<?php echo $con;?>');" style="color: red;"></td>
        
        <td style="display:none"><input value="0" name="minimo<?php echo $con;?>" type="text" class="caja" id="minimo<?php echo $con;?>" onblur="checarCeros('minimo<?php echo $con;?>','<?php echo $con;?>')" onkeyup="permitirDecimal('minimo<?php echo $con;?>');" onfocus="activarValidacion('minimo<?php echo $con;?>');"></td>
        <td style="display:none"><input value="" name="ubicacion<?php echo $con;?>" type="text" class="caja" id="ubicacion<?php echo $con;?>" onblur="checarCeros('ubicacion<?php echo $con;?>','<?php echo $con;?>')"></td>
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