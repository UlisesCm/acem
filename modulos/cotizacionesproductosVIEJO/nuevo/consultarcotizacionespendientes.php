<?php 
require('../Cotizacionproducto.class.php');

if (isset($_REQUEST['idcliente']) && $_REQUEST['idcliente'] !="") {
$idcliente = htmlentities($_REQUEST['idcliente']);
}else{
	$idcliente =0;
}
$Ocotizacionproducto=new Cotizacionproducto;
$resultado = "";

/*$resultado=$Ocotizacionproducto->consultaGeneral("WHERE idcliente = '$idcliente'");

if ($filas=mysqli_fetch_array($resultado)) { 
	  echo "true";
}
else{
	 echo "false";
	
}//Fin de If*/
$cotizacionPendiente = "No";
$resultado=$Ocotizacionproducto->consultaGeneral("WHERE idcliente = '$idcliente' AND tipo = 'COTIZACION' AND estatus = 'activo'");

while ($filas=mysqli_fetch_array($resultado)) { 
$cotizacionPendiente = "Si";
			}
	echo	$cotizacionPendiente
	
			/*if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor["idcotizacionproductos"];
				echo $valorCampo;
			}else{
				echo false;
			}*/
?>

