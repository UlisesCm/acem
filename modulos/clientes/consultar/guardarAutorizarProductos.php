<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cliente.class.php');
$Ocliente=new Cliente;
$mensaje="";
$validacion=true;

if (isset($_POST['productos'])){
	$productos=$_POST['productos'];
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo productos no es correcto</p>";
}

if (isset($_POST['rotacionminima'])){
	$rotacionminima=$_POST['rotacionminima'];
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo rotacion minima no es correcto</p>";
}


if (isset($_POST['rotacionmaxima'])){
	$rotacionmaxima=$_POST['rotacionmaxima'];
	//$rfc=mysql_real_escape_string($rfc);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo rotacionmaxima no es correcto</p>";
}

if (isset($_POST['estados'])){
	$estados=$_POST['estados'];
	//$rfc=mysql_real_escape_string($rfc);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo rotacionmaxima no es correcto</p>";
}
if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo rotacion maxima no es correcto</p>";
}

if($validacion){
	$resultado=$Ocliente->guardarProductosAutorizados($idcliente,$estados,$productos,$rotacionminima,$rotacionmaxima);
	if($resultado=="exito"){
		$mensaje="exito@Operaci&oacute;n exitosa@Los cambios han sido guardados";
		/*$mensaje=$mensaje.'
				</br>
				<p>
				</br>
        		<form action=\"../../domicilios/nuevo/nuevo.php?n1=clientes&n2=domicilios&n3=nuevodomicilios\" method=\"post\">
                	<input type=\"hidden\" name=\"idcliente\" value=\"<?php echo $filas[\"idcliente\"] ?>\"/>
                    <input type=\"hidden\" name=\"nombre\" value=\"<?php echo $filas[\"nombre\"] ?>\"/>
                    <input type=\"hidden\" name=\"nic\" value=\"<?php echo $filas[\"nic\"] ?>\"/>
                    <button type=\"submit\" class=\"btn btn-default\" value=\"\" title=\"Nuevo domicilio de servicio\"><li class=\"fa fa-map-marker\"></li></button>
                </form>
				</p>';*/

	}
	if($resultado=="nombreExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo nombre ya existe en la base de datos";
	}
	if($resultado=="nicExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo nic ya existe en la base de datos";
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