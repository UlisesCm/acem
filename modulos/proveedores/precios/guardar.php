<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Proveedor.class.php');
$Oproveedor=new Proveedor;
$mensaje="";
$validacion=true;



if (isset($_POST['campo'])){
	$campo=htmlentities(trim($_POST['campo']));
	//$nombre=mysql_real_escape_string($nombre);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo campo no es correcto</p>";
}


if (isset($_POST['valor'])){
	$valor=htmlentities(trim($_POST['valor']));
	//$valor=mysql_real_escape_string($valor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo valor no es correcto</p>";
}

if (isset($_POST['idpreciocompra'])){
	$idpreciocompra=htmlentities(trim($_POST['idpreciocompra']));
	//$idpreciocompra=mysql_real_escape_string($idpreciocompra);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idpreciocompra no es correcto</p>";
}


if($validacion){
	$resultado=$Oproveedor->actualizarDato($campo,$valor,$idpreciocompra);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="nombreExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo nombre ya existe en la base de datos";
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