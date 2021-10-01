<?php
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['cotizacionesproductos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Cotizacionproducto.class.php');
$Ocotizacion=new Cotizacionproducto;

$idcotizacionproducto=$_POST['idcotizacionproducto'];
$subfolio=$_POST['subfolio'];

$idtemporal=$Ocotizacion->guardarTemporalSimple($idcotizacionproducto,$subfolio);
if($idtemporal != "fracaso" and $idtemporal != "fracasoFacturada"){
	header("Location: ../../facturacion/nuevo/nuevo.php?idtemporal=$idtemporal");
}else if ($idtemporal == "fracasoFacturada"){
	echo "<script>
		alert('La cotizacion $idcotizacionproducto Y el subfolio $subfolio ya han sido facturados');
		window.close();
		</script>
	";
}else if ($idtemporal == "fracaso"){
	echo "<script>
		alert('Ha ocurrido un eeror al intentar obtener los datos para facturacion, intente de nuevo');
		window.close();
		</script>
	";
}
?>

    