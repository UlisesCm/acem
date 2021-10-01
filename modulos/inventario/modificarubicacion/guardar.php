<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Inventario.class.php');
$Oinventario=new Inventario;
$mensaje="";
$validacion=true;

if (isset($_POST['idinventario'])){
	$idinventario=htmlentities(trim($_POST['idinventario']));
	//$idinventario=mysql_real_escape_string($idinventario);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idinventario no es correcto</p>";
}


if (isset($_POST['minimo'])){
	$minimo=htmlentities(trim($_POST['minimo']));
	//$minimo=mysql_real_escape_string($minimo);
		if(!validarDecimal($minimo)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo minimo sea num&eacute;rico</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo minimo no es correcto</p>";
}

if (isset($_POST['ubicacion'])){
	$ubicacion=htmlentities(trim($_POST['ubicacion']));
	//$ubicacion=mysql_real_escape_string($ubicacion);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo ubicacion no es correcto</p>";
}


if($validacion){
	$resultado=$Oinventario->actualizarUbicacion($minimo,$ubicacion,$idinventario);
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