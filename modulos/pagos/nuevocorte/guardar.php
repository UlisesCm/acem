<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Pago.class.php');
$Opago=new Pago;
$mensaje="";
$validacion=true;

$listaSalidaEfectivo="";
if (isset($_POST['listaSalidaEfectivo'])){
	$listaSalidaEfectivo=htmlentities(trim($_POST['listaSalidaEfectivo']));
}

$listaSalidaTarjetadedebito="";
if (isset($_POST['listaSalidaTarjetadedebito'])){
	$listaSalidaTarjetadedebito=htmlentities(trim($_POST['listaSalidaTarjetadedebito']));
}
$listaSalidaTarjetadecredito="";
if (isset($_POST['listaSalidaTarjetadecredito'])){
	$listaSalidaTarjetadecredito=htmlentities(trim($_POST['listaSalidaTarjetadecredito']));
}

$listaSalidaCheques="";
if (isset($_POST['listaSalidaCheques'])){
	$listaSalidaCheques=htmlentities(trim($_POST['listaSalidaCheques']));
}

$listaSalidaTransferencias="";
if (isset($_POST['listaSalidaTransferencias'])){
	$listaSalidaTransferencias=htmlentities(trim($_POST['listaSalidaTransferencias']));
}

$listaSalidaDepositos="";
if (isset($_POST['listaSalidaDepositos'])){
	$listaSalidaDepositos=htmlentities(trim($_POST['listaSalidaDepositos']));
}

$listaSalidaNotasdecredito="";
if (isset($_POST['listaSalidaNotasdecredito'])){
	$listaSalidaNotasdecredito=htmlentities(trim($_POST['listaSalidaNotasdecredito']));
}


/*CARGAR ARCHIVO*/
/*if (isset($_FILES['archivo']['name'])){
	$archivonombre=$_FILES['archivo']['name'];
	$archivotemporal=$_FILES['archivo']['tmp_name'];
	$extencionarchivo=pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
	$archivo=basename($_FILES['archivo']['name'],".".$extencionarchivo)."_".generarClave(5).".".$extencionarchivo;
	
	if($archivotemporal==""){
		$archivo="";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo archivo no es correcto</p>";
}*/

if (isset($_POST['totalefectivo'])){
	$totalefectivo=htmlentities(trim($_POST['totalefectivo']));
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo totalefectivo a entregar no es correcto</p>";
}

if (isset($_POST['totaltarjetadebito'])){
	$totaltarjetadebito=htmlentities(trim($_POST['totaltarjetadebito']));
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo totaltarjetadebito a entregar no es correcto</p>";
}

if (isset($_POST['totaltarjetacredito'])){
	$totaltarjetacredito=htmlentities(trim($_POST['totaltarjetacredito']));
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo totaltarjetacredito a entregar no es correcto</p>";
}

if (isset($_POST['totalcheque'])){
	$totalcheque=htmlentities(trim($_POST['totalcheque']));
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo totalcheque a entregar no es correcto</p>";
}

if (isset($_POST['totaltransferencia'])){
	$totaltransferencia=htmlentities(trim($_POST['totaltransferencia']));
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo totaltransferencia a entregar no es correcto</p>";
}

if (isset($_POST['totaldeposito'])){
	$totaldeposito=htmlentities(trim($_POST['totaldeposito']));
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo totaldeposito a entregar no es correcto</p>";
}

if (isset($_POST['totalnotadecredito'])){
	$totalnotadecredito=htmlentities(trim($_POST['totalnotadecredito']));
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo totalnotadecredito a entregar no es correcto</p>";
}

if (isset($_POST['totalaentregar'])){
	$totalaentregar=htmlentities(trim($_POST['totalaentregar']));
	//$formapago=mysql_real_escape_string($formapago);
	if($totalaentregar==0){
		$validacion=false;
		$mensaje=$mensaje."<p>El campo total a entregar no puede ser cero</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo total a entregar no es correcto</p>";
}

//validación de conteo de efectivo
if (isset($_POST['diferencia'])){
	$diferencia=htmlentities(trim($_POST['diferencia']));
	//$formapago=mysql_real_escape_string($formapago);
	if($diferencia >= 1){
		$validacion=false;
		$mensaje=$mensaje."<p>El conteo de efectivo no coincide con el total del corte</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo diferencia no es correcto</p>";
}






if($validacion){
	$resultado=$Opago->guardarCorte($totalefectivo,$totaltarjetadebito,$totaltarjetacredito,$totalcheque,$totaltransferencia,$totaldeposito,$totalnotadecredito,$totalaentregar,$listaSalidaEfectivo,$listaSalidaTarjetadedebito,$listaSalidaTarjetadecredito,$listaSalidaCheques,$listaSalidaTransferencias,$listaSalidaDepositos,$listaSalidaNotasdecredito);
	if($resultado=="exito"){
		/*CARGAR ARCHIVOS*/
		/*$mensajeArchivo="";
		if($archivotemporal!=""){
			$estadoArchivo=cargarArchivo($archivonombre,$extencionarchivo, $archivotemporal, $archivo,"jpg,doc,docx,xls,xlsx,pdf,rar,zip,txt","cotizaciones",0,0,"archivo","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionarchivo. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}*/
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
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