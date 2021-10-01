<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['requisiciones']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Requisicion.class.php');
require('../../productos/Producto.class.php');
if (isset($_POST["idrequisicion"])){
	$idrequisicion=$_POST["idrequisicion"];
}else{
	$idrequisicion=0;
}

$Orequisicion= new Requisicion;
$resultado=$Orequisicion->consultaLibre("SELECT
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
										productos.clasificacion,
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

$con=2000;
$Oproducto=new Producto;
while ($filas=mysqli_fetch_array($resultado)) { 
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
	
	$habilitar="";
	if ($pesoreal==0 and $pesoproducto==0){
		$habilitar='disabled="disabled"';
	}
	?>
        
        <tr>
        <td style="display:none"><?php echo $con;?></td>
        <td style="display:none"><?php echo $filas["idproducto"];?></td>
        <td style="display:none"><?php echo $filas["codigoproducto"];?></td>
        <td class="columnaIzquierda" style="border-left: 10px solid #909;"><?php echo $filas["nombreproducto"];?></td>
        <td><?php echo $filas["nombreunidad"];?></td>
        <td>
            <input value="<?php echo $filas["cantidad"];?>" name="cant<?php echo $con;?>" type="text" class="caja" id="cant<?php echo $con;?>" onblur="calcular('cant','<?php echo $con;?>')" onkeyup="permitirDecimal('cant<?php echo $con;?>');" onfocus="activarValidacion('cant<?php echo $con;?>');" style="color: rgb(255, 0, 0);">
        </td>
        <td>
            <input value="<?php echo $filas["costo"];?>" name="cost<?php echo $con;?>" type="text" class="caja" id="cost<?php echo $con;?>" onblur="calcular('cost','<?php echo $con;?>')" onkeyup="permitirDecimal('cost<?php echo $con;?>');" onfocus="activarValidacion('cost<?php echo $con;?>');" style="color: rgb(0, 0, 255);">
        </td>
        <td>
            <input value="<?php echo $costo2?>" name="cost2<?php echo $con;?>" type="text" class="caja" id="cost2<?php echo $con;?>" onblur="calcular('cost2','<?php echo $con;?>')" onkeyup="permitirDecimal('cost2<?php echo $con;?>');" onfocus="activarValidacion('cost2<?php echo $con;?>');" <?php echo $habilitar?>>
        </td>
        <td id="monto<?php echo $con;?>"><?php echo $cantidad*$costoCompra;?></td>
        <td id="pesoteoricounitario<?php echo $con;?>"><?php echo $pesoproducto;?></td>
        <td id="pesoreal<?php echo $con;?>"><?php echo $pesoreal;?></td>
        <td>
            <input value="<?php echo $pesototal?>" name="pesoteorico<?php echo $con;?>" type="text" class="caja" id="pesoteorico<?php echo $con;?>" onblur="calcular('pesoteorico','<?php echo $con;?>')" onkeyup="permitirDecimal('pesoteorico<?php echo $con;?>');" onfocus="activarValidacion('pesoteorico<?php echo $con;?>');" <?php echo $habilitar?>>
        </td>
        <td id="existancias<?php echo $con;?>"><?php echo $existencias; ?></td>
        <td id="stockminimo<?php echo $con;?>"><?php echo $datosStocks[0] ?></td>
        <td id="stockmaximo<?php echo $con;?>"><?php echo $datosStocks[1] ?></td>
        <td><?php echo $filas["clasificacion"];?></td>
        <td title="Eliminar Fila" class="eliminarFila">
            <a class="btn btn-default btn-xs"><i class="fa fa-trash-o text-green"></i></a>
        </td>
		</tr>
            
    <?php
	$con++;
}//Fin de while si es tabla ?>