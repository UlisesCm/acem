<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Contacto.class.php');
$Ocontacto=new Contacto;
$mensaje="";
$validacion=true;

if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	//$idcliente=mysql_real_escape_string($idcliente);
	
			if(trim($idcliente)==""){
				$validacion=false;
				$mensaje=$mensaje."<p>Verifique que el campo idcliente sea v&aacute;lido y exista en la base de datos</p>";
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcliente no es correcto</p>";
}

if (isset($_POST['nombrecontacto'])){
	$nombrecontacto=htmlentities(trim($_POST['nombrecontacto']));
	//$nombrecontacto=mysql_real_escape_string($nombrecontacto);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombrecontacto no es correcto</p>";
}

if (isset($_POST['telefono'])){
	$telefono=htmlentities(trim($_POST['telefono']));
	//$telefono=mysql_real_escape_string($telefono);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo telefono no es correcto</p>";
}

if (isset($_POST['email'])){
	$email=htmlentities(trim($_POST['email']));
	//$email=mysql_real_escape_string($email);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo email no es correcto</p>";
}

if (isset($_POST['departamento'])){
	$departamento=htmlentities(trim($_POST['departamento']));
	//$departamento=mysql_real_escape_string($departamento);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo departamento no es correcto</p>";
}

if (isset($_POST['comentarios'])){
	$comentarios=htmlentities(trim($_POST['comentarios']));
	//$comentarios=mysql_real_escape_string($comentarios);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo comentarios no es correcto</p>";
}
if($validacion){
	$resultado=$Ocontacto->guardar($idcliente,$nombrecontacto,$telefono,$email,$departamento,$comentarios);
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