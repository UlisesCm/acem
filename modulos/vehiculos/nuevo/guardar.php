<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Vehiculo.class.php');
$Ovehiculo=new Vehiculo;
$mensaje="";
$validacion=true;

if (isset($_POST['tipo'])){
	$tipo=htmlentities(trim($_POST['tipo']));
	//$tipo=mysql_real_escape_string($tipo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipo no es correcto</p>";
}

if (isset($_POST['marca'])){
	$marca=htmlentities(trim($_POST['marca']));
	//$marca=mysql_real_escape_string($marca);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo marca no es correcto</p>";
}

if (isset($_POST['submarca'])){
	$submarca=htmlentities(trim($_POST['submarca']));
	//$submarca=mysql_real_escape_string($submarca);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo submarca no es correcto</p>";
}

if (isset($_POST['color'])){
	$color=htmlentities(trim($_POST['color']));
	//$color=mysql_real_escape_string($color);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo color no es correcto</p>";
}

if (isset($_POST['placa'])){
	$placa=htmlentities(trim($_POST['placa']));
	//$placa=mysql_real_escape_string($placa);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo placa no es correcto</p>";
}

if (isset($_POST['capacidaddecarga'])){
	$capacidaddecarga=htmlentities(trim($_POST['capacidaddecarga']));
	//$capacidaddecarga=mysql_real_escape_string($capacidaddecarga);
	
		if(!validarEntero($capacidaddecarga)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo capacidaddecarga contenga n&uacute;meros enteros</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo capacidaddecarga no es correcto</p>";
}

if (isset($_POST['anio'])){
	$anio=htmlentities(trim($_POST['anio']));
	//$anio=mysql_real_escape_string($anio);
	
		if(!validarEntero($anio)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo anio contenga n&uacute;meros enteros</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo anio no es correcto</p>";
}

if (isset($_POST['kminicial'])){
	$kminicial=htmlentities(trim($_POST['kminicial']));
	//$kminicial=mysql_real_escape_string($kminicial);
	
		if(!validarEntero($kminicial)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo kminicial contenga n&uacute;meros enteros</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo kminicial no es correcto</p>";
}

if (isset($_POST['kmactual'])){
	$kmactual=htmlentities(trim($_POST['kmactual']));
	//$kmactual=mysql_real_escape_string($kmactual);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo kmactual no es correcto</p>";
}

if (isset($_POST['vigenciaseguro'])){
	$vigenciaseguro=htmlentities(trim($_POST['vigenciaseguro']));
	//$vigenciaseguro=mysql_real_escape_string($vigenciaseguro);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo vigenciaseguro no es correcto</p>";
}

if (isset($_POST['kmultimomantenimiento'])){
	$kmultimomantenimiento=htmlentities(trim($_POST['kmultimomantenimiento']));
	//$kmultimomantenimiento=mysql_real_escape_string($kmultimomantenimiento);
	
		if(!validarEntero($kmultimomantenimiento)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo kmultimomantenimiento contenga n&uacute;meros enteros</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo kmultimomantenimiento no es correcto</p>";
}

if (isset($_POST['fechaultimomantenimiento'])){
	$fechaultimomantenimiento=htmlentities(trim($_POST['fechaultimomantenimiento']));
	//$fechaultimomantenimiento=mysql_real_escape_string($fechaultimomantenimiento);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechaultimomantenimiento no es correcto</p>";
}

if (isset($_POST['tipodecombustible'])){
	$tipodecombustible=htmlentities(trim($_POST['tipodecombustible']));
	//$tipodecombustible=mysql_real_escape_string($tipodecombustible);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipodecombustible no es correcto</p>";
}

if (isset($_POST['frecuenciamantenimientokm'])){
	$frecuenciamantenimientokm=htmlentities(trim($_POST['frecuenciamantenimientokm']));
	//$frecuenciamantenimientokm=mysql_real_escape_string($frecuenciamantenimientokm);
	
		if(!validarEntero($frecuenciamantenimientokm)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo frecuenciamantenimientokm contenga n&uacute;meros enteros</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo frecuenciamantenimientokm no es correcto</p>";
}

if (isset($_POST['frecuenciamantenimientofecha'])){
	$frecuenciamantenimientofecha=htmlentities(trim($_POST['frecuenciamantenimientofecha']));
	//$frecuenciamantenimientofecha=mysql_real_escape_string($frecuenciamantenimientofecha);
	
		if(!validarEntero($frecuenciamantenimientofecha)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo frecuenciamantenimientofecha contenga n&uacute;meros enteros</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo frecuenciamantenimientofecha no es correcto</p>";
}

if (isset($_POST['asignado'])){
	$asignado=htmlentities(trim($_POST['asignado']));
	//$asignado=mysql_real_escape_string($asignado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo asignado no es correcto</p>";
}

if (isset($_POST['estado'])){
	$estado=htmlentities(trim($_POST['estado']));
	//$estado=mysql_real_escape_string($estado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estado no es correcto</p>";
}

if (isset($_POST['idempleado'])){
	$idempleado=htmlentities(trim($_POST['idempleado']));
	//$idempleado=mysql_real_escape_string($idempleado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idempleado no es correcto</p>";
}

if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	//$idsucursal=mysql_real_escape_string($idsucursal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}

if($validacion){
	$resultado=$Ovehiculo->guardar($tipo,$marca,$submarca,$color,$placa,$capacidaddecarga,$anio,$kminicial,$kmactual,$vigenciaseguro,$kmultimomantenimiento,$fechaultimomantenimiento,$tipodecombustible,$frecuenciamantenimientokm,$frecuenciamantenimientofecha,$asignado,$estado,$idempleado,$idsucursal,$estatus);
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