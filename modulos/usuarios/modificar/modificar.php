<?php 
include ("../../seguridad/comprobar_login.php");
require('../Usuario.class.php');

$Ousuario=new Usuario;
$mensaje="";

if (isset($_POST['accion']) && $_POST['accion'] !=""){
		$accion=$_POST['accion'];
		if (isset($_POST['id']) && $_POST['id'] !="") {
			$id=$_POST['id'];
			if($Ousuario->bloquear($id,$accion)){
				$mensaje="exito@Operaci&oacute;n exitosa@Los registos han sido modificado";
			}else{
				$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
			}
		}
}

echo utf8_encode($mensaje);


?>