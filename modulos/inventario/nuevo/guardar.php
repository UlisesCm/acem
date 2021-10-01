<?php 
include ("../../seguridad/comprobar_login.php");
require('../Inventario.class.php');
$Oinventario=new Inventario;
$mensaje="";
$validacion=true;

if (isset($_POST['idalmacen'])){
	$idalmacen=htmlentities(trim($_POST['idalmacen']));
	$idalmacen=trim($idalmacen);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idalmacen no es correcto</p>";
}

if (isset($_POST['idproducto'])){
	$idproducto=htmlentities(trim($_POST['idproducto']));
	$idproducto=trim($idproducto);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idproducto no es correcto</p>";
}

if (isset($_POST['existencia'])){
	$existencia=htmlentities(trim($_POST['existencia']));
	$existencia=trim($existencia);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo existencia no es correcto</p>";
}

if (isset($_POST['promedio'])){
	$promedio=htmlentities(trim($_POST['promedio']));
	$promedio=trim($promedio);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo promedio no es correcto</p>";
}

if (isset($_POST['saldo'])){
	$saldo=htmlentities(trim($_POST['saldo']));
	$saldo=trim($saldo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo saldo no es correcto</p>";
}

if (isset($_POST['minimo'])){
	$minimo=htmlentities(trim($_POST['minimo']));
	$minimo=trim($minimo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo minimo no es correcto</p>";
}

if (isset($_POST['ubicacion'])){
	$ubicacion=htmlentities(trim($_POST['ubicacion']));
	$ubicacion=trim($ubicacion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo ubicacion no es correcto</p>";
}

if (isset($_POST['estado'])){
	$estado=htmlentities(trim($_POST['estado']));
	$estado=trim($estado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estado no es correcto</p>";
}
if($validacion){
	$resultado=$Oinventario->guardar($idalmacen,$idproducto,$existencia,$promedio,$saldo,$minimo,$ubicacion,$estado);
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