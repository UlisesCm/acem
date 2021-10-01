<?php 
include ("../../seguridad/comprobar_login.php");
require('../Gasto.class.php');
$Ogasto=new Gasto;
$mensaje="";
$validacion=true;

if (isset($_POST['fechaconsulta'])){
	$fecha=htmlentities(trim($_POST['fechaconsulta']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['idcuentaconsulta'])){
	$idcuenta=htmlentities(trim($_POST['idcuentaconsulta']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcuenta no es correcto</p>";
}

if (isset($_POST['chequeconsulta'])){
	$cheque=htmlentities(trim($_POST['chequeconsulta']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cheque no es correcto</p>";
}

if (isset($_POST['descripcion'])){
	$descripcion=htmlentities(trim($_POST['descripcion']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo descripcion no es correcto</p>";
}

if (isset($_POST['totalRetiro'])){
	$monto=htmlentities(trim($_POST['totalRetiro']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo total no es correcto</p>";
}

if (isset($_POST['listaSalida']) && $_POST['listaSalida']!=""){
	$listaSalida=trim($_POST['listaSalida']);
	$listaSalida= substr($listaSalida, 0, -3);
	$listaSalida=explode(":::",$listaSalida);
}else{
	$listaSalida ="0";//no guardar nada
}

if (isset($_POST['listaSalidaGastos']) && $_POST['listaSalidaGastos']!=""){
	$listaSalidaGastos=trim($_POST['listaSalidaGastos']);
	$listaSalidaGastos= substr($listaSalidaGastos, 0, -3);
	$listaSalidaGastos=explode(":::",$listaSalidaGastos);
}else{
	$listaSalidaGastos ="0";//no guardar nada
}

if($listaSalida=="0" && $listaSalidaGastos=="0"){
	$validacion=false;
	$mensaje=$mensaje."<p>Es necesario que seleccione al menos un pago</p>";
}

if($validacion){
	$resultado=$Ogasto->registrarRetiros($fecha,$idcuenta,$cheque,$descripcion,$monto,$listaSalida,$listaSalidaGastos);
	if($resultado=="exito"){
		
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