
<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['modelosimpuestos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Modeloimpuestos.class.php');


if (isset($_POST['id']) && $_POST['id'] !="") {
$id = htmlentities($_POST['id']);
}else{
	$id ="0";
}

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")

$Omodeloimpuestos=new Modeloimpuestos;
$resultado=$Omodeloimpuestos->consultaLibre("SELECT * FROM impuestos WHERE idmodeloimpuesto='$id'");
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}

// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
$con=0;
$color=1166;
while ($filas=mysqli_fetch_array($resultado)) {
	$con=$con+1; 
	$color=$color+5;
?>
	<tr>
        <td style="display:none"><?php echo $con; ?></td>
        <td class="columnaIzquierda" style="border-left: 10px solid #25c274;"><?php echo $filas['clavesat']; ?></td>
        <td align="center"><?php echo $filas['nombre']; ?></td>
        <td align="center"><?php echo $filas['tipo']; ?></td>
        <td align="center"><?php echo $filas['factor']; ?></td>
        <td align="center"><?php echo $filas['valor']; ?></td>
        
        <td title="Eliminar Fila" class="eliminarFila"><a class="btn btn-default btn-xs"><i class="fa fa-trash-o text-green"></i></a><a></a></td>
    </tr>
	
	
<?php } 
/* if(mysql_num_rows($resultado)==0){
	include("../../../componentes/mensaje_no_hay_registros.php");
} */

?>
