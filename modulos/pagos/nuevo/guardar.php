<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Pago.class.php');
$Opago=new Pago;
$mensaje="";
$validacion=true;

if (isset($_POST['idreferencia'])){
	$idreferencia=htmlentities(trim($_POST['idreferencia']));
	//$idreferencia=mysql_real_escape_string($idreferencia);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idreferencia no es correcto</p>";
}

if (isset($_POST['tablareferencia'])){
	$tablareferencia=htmlentities(trim($_POST['tablareferencia']));
	//$tablareferencia=mysql_real_escape_string($tablareferencia);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tablareferencia no es correcto</p>";
}

if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	//$idcliente=mysql_real_escape_string($idcliente);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcliente no es correcto</p>";
}

if (isset($_POST['idcaja'])){
	$idcaja=htmlentities(trim($_POST['idcaja']));
	//$idcaja=mysql_real_escape_string($idcaja);
	
}else{
	/*$validacion=false;
	$mensaje=$mensaje."<p>El campo idcaja no es correcto</p>";*/
	$idcaja = 0;
}

if (isset($_POST['fechapago'])){
	$fechapago=htmlentities(trim($_POST['fechapago']));
	//$fechapago=mysql_real_escape_string($fechapago);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechapago no es correcto</p>";
}

if (isset($_POST['formapago'])){
	$formapago=htmlentities(trim($_POST['formapago']));
	//$formapago=mysql_real_escape_string($formapago);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo formapago no es correcto</p>";
}

if (isset($_POST['monto'])){
	$monto=htmlentities(trim($_POST['monto']));
	//$monto=mysql_real_escape_string($monto);
	
		if(!validarDecimal($monto)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo monto sea num&eacute;rico</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo monto no es correcto</p>";
}

if (isset($_POST['saldo'])){
	$saldo=htmlentities(trim($_POST['saldo']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo saldo no es correcto</p>";
}

if (isset($_POST['tipo'])){
	$tipo=htmlentities(trim($_POST['tipo']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipo no es correcto</p>";
}

if (isset($_POST['descripcion'])){
	$descripcion=htmlentities(trim($_POST['descripcion']));
	//$descripcion=mysql_real_escape_string($descripcion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo descripcion no es correcto</p>";
}

/*if (isset($_POST['estadoliquidacion'])){
	$estadoliquidacion=htmlentities(trim($_POST['estadoliquidacion']));
	//$descripcion=mysql_real_escape_string($descripcion);
	if($estadoliquidacion == "LIQUIDADO"){
		$validacion=false;
		$mensaje=$mensaje."<p>NO SE PUEDE CANCELAR DEBIDO A QUE YA SE LIQUIDO LA VENTA</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estadoliquidacion no es correcto</p>";
}*/

if($validacion){
	$resultado=$Opago->guardar($idreferencia,$tablareferencia,$idcliente,$idcaja,$fechapago,$formapago,$monto,$saldo,$tipo,$descripcion);
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