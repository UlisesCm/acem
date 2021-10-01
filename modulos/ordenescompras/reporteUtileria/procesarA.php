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
echo $idrequisicion;


$Orequisicion= new Compra;

$resultadoP=$Orequisicion->consultaLibre("SELECT
										requisiciones.idrequisicion,
										requisiciones.idsucursal,
										requisiciones.fecha,
										requisiciones.pesototal,
										requisiciones.serie,
										requisiciones.folio,
										proveedores.nombre AS nombreproveedor,
										sucursales.nombre AS nombresucursales
										FROM requisiciones
										INNER JOIN sucursales ON requisiciones.idsucursal=sucursales.idsucursal
										INNER JOIN proveedores ON proveedores.idproveedor=requisiciones.idproveedor
										WHERE requisiciones.idrequisicion='$idrequisicion'");

//PERMISOS
if ($resultadoP=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}

// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA

$con=1000;
while ($filas=mysqli_fetch_array($resultadoP)) { 
	?>
    		
      	<tr>
        <td class="numerorequisicion" style="display:none"><?php echo $con;?></td>
        <td class="idrequisicion" style="display:none"><?php echo $filas["idrequisicion"];?></td>
        <td class="columnaIzquierda fecha" style="border-left: 10px solid #909;"><?php echo $filas["serie"]."-".$filas["folio"]." (".$filas["fecha"].")";?></td>
        <td class="sucursal"><?php echo $filas["nombresucursales"];?></td>
        <td class="idsucursal" style="display:none"><?php echo $filas["idsucursal"];?></td>
        <td class="proveedor"><?php echo $filas["nombreproveedor"];?></td>
        <td class="pesototal"><?php echo number_format($filas["pesototal"],2)."Kg.";?></td>
        <td class="pesototal" style="display:none"><?php echo number_format($filas["pesototal"],2);?></td>
        <td title="Eliminar Fila" class="eliminarFilaR"><a class="btn btn-default btn-xs"><i class="fa fa-trash-o text-green"></i></a></td>
        </tr>
            
    <?php
	$con++;
}//Fin de while si es tabla ?>