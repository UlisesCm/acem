<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Familia.class.php');
$Ofamilia=new Familia;
$mensaje="";
$validacion=true;

if (isset($_POST['nombre'])){
	$nombre=htmlentities(trim($_POST['nombre']));
	//$nombre=mysql_real_escape_string($nombre);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
}
if (isset($_POST['mostrarendescripcion'])){
	$mostrarendescripcion=htmlentities(trim($_POST['mostrarendescripcion']));
	//$mostrarendescripcion=mysql_real_escape_string($mostrarendescripcion);
}else{
	$mostrarendescripcion='no';
}
	

if (isset($_POST['nombredescripcion'])){
	$nombredescripcion=htmlentities(trim($_POST['nombredescripcion']));
	//$nombredescripcion=mysql_real_escape_string($nombredescripcion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombredescripcion no es correcto</p>";
}

if (isset($_POST['prefijocodigo'])){
	$prefijocodigo=htmlentities(trim($_POST['prefijocodigo']));
	//$prefijocodigo=mysql_real_escape_string($prefijocodigo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo prefijocodigo no es correcto</p>";
}

if (isset($_POST['camposrequeridos'])){
	$camposrequeridos=htmlentities(trim($_POST['camposrequeridos']));
	//$camposrequeridos=mysql_real_escape_string($camposrequeridos);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo camposrequeridos no es correcto</p>";
}

if (isset($_POST['idfamiliamadre'])){
	$idfamiliamadre=htmlentities(trim($_POST['idfamiliamadre']));
	//$idfamiliamadre=mysql_real_escape_string($idfamiliamadre);
	
			if(trim($idfamiliamadre)==""){
				$validacion=false;
				$mensaje=$mensaje."<p>Verifique que el campo idfamiliamadre sea v&aacute;lido y exista en la base de datos</p>";
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idfamiliamadre no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Ofamilia->guardar($nombre,$mostrarendescripcion,$nombredescripcion,$prefijocodigo,$camposrequeridos,$idfamiliamadre,$estatus);
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