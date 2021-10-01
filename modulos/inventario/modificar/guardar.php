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

if (isset($_POST['idalmacen'])){
	$idalmacen=htmlentities(trim($_POST['idalmacen']));
	//$idalmacen=mysql_real_escape_string($idalmacen);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idalmacen no es correcto</p>";
}

if (isset($_POST['idproducto'])){
	$idproducto=htmlentities(trim($_POST['idproducto']));
	//$idproducto=mysql_real_escape_string($idproducto);
			if(trim($idproducto)==""){
				$validacion=false;
				$mensaje=$mensaje."<p>Verifique que el campo idproducto sea v&aacute;lido y exista en la base de datos</p>";
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idproducto no es correcto</p>";
}

if (isset($_POST['existencia'])){
	$existencia=htmlentities(trim($_POST['existencia']));
	//$existencia=mysql_real_escape_string($existencia);
		if(!validarDecimal($existencia)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo existencia sea num&eacute;rico</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo existencia no es correcto</p>";
}

if (isset($_POST['promedio'])){
	$promedio=htmlentities(trim($_POST['promedio']));
	//$promedio=mysql_real_escape_string($promedio);
		if(!validarDecimal($promedio)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo promedio sea num&eacute;rico</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo promedio no es correcto</p>";
}

if (isset($_POST['saldo'])){
	$saldo=htmlentities(trim($_POST['saldo']));
	//$saldo=mysql_real_escape_string($saldo);
		if(!validarDecimal($saldo)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo saldo sea num&eacute;rico</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo saldo no es correcto</p>";
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

if (isset($_POST['estado'])){
	$estado=htmlentities(trim($_POST['estado']));
	//$estado=mysql_real_escape_string($estado);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estado no es correcto</p>";
}
if($validacion){
	$resultado=$Oinventario->actualizar($idalmacen,$idproducto,$existencia,$promedio,$saldo,$minimo,$ubicacion,$estado, $idinventario);
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