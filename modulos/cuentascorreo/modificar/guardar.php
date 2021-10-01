<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cuentacorreo.class.php');
$Ocuentacorreo=new Cuentacorreo;
$mensaje="";
$validacion=true;

if (isset($_POST['idcuentacorreo'])){
	$idcuentacorreo=htmlentities(trim($_POST['idcuentacorreo']));
	//$idcuentacorreo=mysql_real_escape_string($idcuentacorreo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcuentacorreo no es correcto</p>";
}

if (isset($_POST['usuario'])){
	$usuario=htmlentities(trim($_POST['usuario']));
	//$usuario=mysql_real_escape_string($usuario);
		if(!validarEmail($usuario)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo usuario sea un email v&aacute;lido</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo usuario no es correcto</p>";
}

if (isset($_POST['contrasena'])){
	$contrasena=htmlentities(trim($_POST['contrasena']));
	//$contrasena=mysql_real_escape_string($contrasena);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo contrasena no es correcto</p>";
}

if (isset($_POST['servidorsmtp'])){
	$servidorsmtp=htmlentities(trim($_POST['servidorsmtp']));
	//$servidorsmtp=mysql_real_escape_string($servidorsmtp);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo servidorsmtp no es correcto</p>";
}

if (isset($_POST['servidorpop'])){
	$servidorpop=htmlentities(trim($_POST['servidorpop']));
	//$servidorpop=mysql_real_escape_string($servidorpop);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo servidorpop no es correcto</p>";
}

if (isset($_POST['puertosmtp'])){
	$puertosmtp=htmlentities(trim($_POST['puertosmtp']));
	//$puertosmtp=mysql_real_escape_string($puertosmtp);
		if(!validarEntero($puertosmtp)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo puertosmtp contenga n&uacute;meros enteros</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo puertosmtp no es correcto</p>";
}

if (isset($_POST['puertopop'])){
	$puertopop=htmlentities(trim($_POST['puertopop']));
	//$puertopop=mysql_real_escape_string($puertopop);
		if(!validarEntero($puertopop)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo puertopop contenga n&uacute;meros enteros</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo puertopop no es correcto</p>";
}
if (isset($_POST['autenticacionssl'])){
	$autenticacionssl=htmlentities(trim($_POST['autenticacionssl']));
	//$autenticacionssl=mysql_real_escape_string($autenticacionssl);
}else{
	$autenticacionssl='no';
}
	

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Ocuentacorreo->actualizar($usuario,$contrasena,$servidorsmtp,$servidorpop,$puertosmtp,$puertopop,$autenticacionssl,$estatus, $idcuentacorreo);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="usuarioExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo usuario ya existe en la base de datos";
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