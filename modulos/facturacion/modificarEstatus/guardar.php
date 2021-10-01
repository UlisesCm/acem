<?php 
include ("../../seguridad/comprobar_login.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
require('../Venta.class.php');
$Oventa=new Venta;
$mensaje="";
$validacion=true;

if (isset($_POST['idventa'])){
	$idventa=htmlentities(trim($_POST['idventa']));
	//$idventa=mysql_real_escape_string($idventa);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idventa no es correcto</p>";
}

if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	//$idcliente=mysql_real_escape_string($idcliente);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcliente no es correcto</p>";
}

if (isset($_POST['estado'])){
	$estado=htmlentities(trim($_POST['estado']));
	//$estado=mysql_real_escape_string($estado);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estado no es correcto</p>";
}

if (isset($_POST['fechaliquidacion'])){
	$fechaliquidacion=htmlentities(trim($_POST['fechaliquidacion']));
	//$estado=mysql_real_escape_string($estado);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha de liquidacion no es correcto</p>";
}


if (isset($_POST['facturada'])){
	$facturada=htmlentities(trim($_POST['facturada']));
	//$facturada=mysql_real_escape_string($facturada);
}else{
	$facturada='no';
}
	

if (isset($_POST['archivoFactura'])){
	$archivoFactura=htmlentities(trim($_POST['archivoFactura']));
	$archivoFacturaEliminacion=$_POST['archivoFacturaEliminacion'];
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo archivoFactura no es correcto</p>";
}	
	/*CARGAR ARCHIVO*/
if (isset($_FILES['archivoFacturaI']['name'])){
	$archivoFacturatemporal=$_FILES['archivoFacturaI']['tmp_name'];
	$archivoFacturanombre=$_FILES['archivoFacturaI']['name'];
	$extencionarchivoFactura=pathinfo($_FILES['archivoFacturaI']['name'], PATHINFO_EXTENSION);
	if($archivoFacturatemporal==""){
		$archivoFactura=$archivoFactura;
	}else{
		$archivoFactura=basename($_FILES['archivoFacturaI']['name'],".".$extencionarchivoFactura)."_".generarClave(5).".".$extencionarchivoFactura;
	}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo archivoFactura no es correcto</p>";
}
if (isset($_POST['archivoNota'])){
	$archivoNota=htmlentities(trim($_POST['archivoNota']));
	$archivoNotaEliminacion=$archivoNota;
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo archivoNota no es correcto</p>";
}	
	/*CARGAR ARCHIVO*/
if (isset($_FILES['archivoNotaI']['name'])){
	$archivoNotatemporal=$_FILES['archivoNotaI']['tmp_name'];
	$archivoNotanombre=$_FILES['archivoNotaI']['name'];
	$extencionarchivoNota=pathinfo($_FILES['archivoNotaI']['name'], PATHINFO_EXTENSION);
	if($archivoNotatemporal==""){
		$archivoNota=$archivoNota;
	}else{
		$archivoNota=basename($_FILES['archivoNotaI']['name'],".".$extencionarchivoNota)."_".generarClave(5).".".$extencionarchivoNota;
	}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo archivoNota no es correcto</p>";
}





if (isset($_POST['diferenciaCredito'])){
	$diferenciaCredito=htmlentities(trim($_POST['diferenciaCredito']));
	//$diferenciaCredito=mysql_real_escape_string($diferenciaCredito);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo diferenciaCredito no es correcto</p>";
}
if($validacion){
	$resultado=$Oventa->actualizarEstatus($estado,$facturada,$archivoFactura,$archivoNota,$diferenciaCredito, $fechaliquidacion, $idcliente, $idventa);
	if($resultado=="exito"){
		/*CARGAR ARCHIVOS*/
		$mensajeArchivo="";
		
		if($archivoFacturatemporal!=""){
			//Elimina la imagen antigua para actualizarla y que no ocupe espacio
			unlink("../archivosSubidos/facturas/".$archivoFacturaEliminacion);
			$estadoArchivo=cargarArchivo($archivoFacturanombre,$extencionarchivoFactura, $archivoFacturatemporal, $archivoFactura,"xml,zip,rar,pdf,jpg,jpeg","facturas",0,0,"archivo","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionarchivoFactura. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}
		if($archivoNotatemporal!=""){
			//Elimina la imagen antigua para actualizarla y que no ocupe espacio
			unlink("../archivosSubidos/notascredito/".$archivoNotaEliminacion);
			$estadoArchivo=cargarArchivo($archivoNotanombre,$extencionarchivoNota, $archivoNotatemporal, $archivoNota,"xml,zip,rar,pdf,jpg,jpeg","notascredito",0,0,"archivo","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionarchivoNota. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado. Se intento eliminar $archivoFacturaEliminacion";
		$mensaje=$mensaje.$mensajeArchivo;
	}
	if($resultado=="fracaso"){
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	}
	if($resultado=="denegado"){
		$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);

?>