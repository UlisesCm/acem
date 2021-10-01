<?php 
include ("../../seguridad/comprobar_login.php");
require('../Configuracion.class.php');
ini_set("max_execution_time","640");
$Oconfiguracion=new Configuracion;
$mensaje="";
$validacion=true;

if (isset($_POST['idalmacen'])){
	$idalmacen=htmlentities(trim($_POST['idalmacen']));
	$idalmacen=trim($idalmacen);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idalmacen no es correcto</p>";
}


	
if($validacion){
	$resultado=$Oconfiguracion->sincronizar($idalmacen);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}else{
		$mensaje="fracaso@Operaci&oacute;n fallida@$resultado";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);

?>