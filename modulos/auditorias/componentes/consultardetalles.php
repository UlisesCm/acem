<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['auditorias']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Auditoria.class.php');
if (isset($_POST["idauditoria"])){
	$idauditoria=$_POST["idauditoria"];
}else{
	$idauditoria=0;
}

$Oauditoria= new Auditoria;
$resultado=$Oauditoria->consultaLibre("SELECT
										detalleauditorias.iddetalleauditoria,
										detalleauditorias.idauditoria,
										detalleauditorias.idproducto,
										detalleauditorias.existenciaanterior,
										detalleauditorias.existencia,
										detalleauditorias.conteo,
										detalleauditorias.diferencia,
										detalleauditorias.idusuario,
										detalleauditorias.estado,
										detalleauditorias.fecha,
										auditorias.fecha AS fechaauditorias,
										productos.nombre AS nombreproducto,
										unidades.nombre AS nombreunidad,
										usuarios.nombre AS nombreusuarios
										FROM detalleauditorias 
										INNER JOIN auditorias ON detalleauditorias.idauditoria=auditorias.idauditoria
										INNER JOIN productos ON detalleauditorias.idproducto=productos.idproducto
										INNER JOIN usuarios ON detalleauditorias.idusuario=usuarios.idusuario
										INNER JOIN unidades ON productos.idunidad=unidades.idunidad
										WHERE detalleauditorias.idauditoria='$idauditoria'");

if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA

$con=1000;
while ($filas=mysqli_fetch_array($resultado)) {
	$colorCantidad="blue"; 
	if ($filas["estado"]=='Contado'){
		$colorCantidad="#096";
	}
	$colorDiferencia="#096";
	if ($filas["diferencia"] > 0){
		$colorDiferencia="#C33";
	}
	if ($filas["diferencia"] < 0){
		$colorDiferencia="#FC0";
	}
	?>
    		
      	<tr>
        <td style="display:none"><?php echo $con;?></td>
        <td style="display:none"><?php echo $filas["idproducto"];?></td>
        <td class="columnaIzquierda" style="border-left: 10px solid #9FB580;"><?php echo $filas["nombreproducto"]." -".$filas["estado"];?></td>
        <td><?php echo $filas["nombreunidad"];?></td>
        <td id="existencia<?php echo $con; ?>"><?php echo $filas["existencia"];?></td>
        <td><input value="<?php echo $filas["conteo"];?>" name="cant<?php echo $con;?>" type="text" class="caja" id="cant<?php echo $con;?>" onblur="actualizarDato('cant<?php echo $con;?>','<?php echo $con;?>','<?php echo $filas["iddetalleauditoria"];?>')" onkeyup="permitirDecimal('cant<?php echo $con;?>');" onfocus="activarValidacion('cant<?php echo $con;?>');" style="color: <?php echo $colorCantidad?>;"></td>
        <td style="color:<?php echo $colorDiferencia?>" id="diferencia<?php echo $con?>"><?php echo $filas["diferencia"];?></td>
        <td title="Eliminar Fila" class="eliminarFila"><a class="btn btn-default btn-xs"><i class="fa fa-trash-o text-green"></i></a></td>
        </tr>
            
    <?php
	$con++;
}//Fin de while si es tabla ?>