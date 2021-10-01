<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Domicilio.class.php');
$Odomicilio=new Domicilio;
$mensaje="";
$validacion=true;

if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	//$idcliente=mysql_real_escape_string($idcliente);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcliente no es correcto</p>";
}

if (isset($_POST['tipovialidad'])){
	$tipovialidad=htmlentities(trim($_POST['tipovialidad']));
	//$tipovialidad=mysql_real_escape_string($tipovialidad);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipovialidad no es correcto</p>";
}

if (isset($_POST['calle'])){
	$calle=htmlentities(trim($_POST['calle']));
	//$calle=mysql_real_escape_string($calle);
	
			if(trim($calle)==""){
				$validacion=false;
				$mensaje=$mensaje."<p>Verifique que el campo calle sea v&aacute;lido y exista en la base de datos</p>";
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo calle no es correcto</p>";
}

if (isset($_POST['noexterior'])){
	$noexterior=htmlentities(trim($_POST['noexterior']));
	//$noexterior=mysql_real_escape_string($noexterior);
	
			if(trim($noexterior)==""){
				$validacion=false;
				$mensaje=$mensaje."<p>Verifique que el campo noexterior sea v&aacute;lido y exista en la base de datos</p>";
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo noexterior no es correcto</p>";
}

if (isset($_POST['nointerior'])){
	$nointerior=htmlentities(trim($_POST['nointerior']));
	//$nointerior=mysql_real_escape_string($nointerior);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nointerior no es correcto</p>";
}

if (isset($_POST['nombrecomercial'])){
	$nombrecomercial=htmlentities(trim($_POST['nombrecomercial']));
	//$nombrecomercial=mysql_real_escape_string($nombrecomercial);
	
			if(trim($nombrecomercial)==""){
				$validacion=false;
				$mensaje=$mensaje."<p>Verifique que el campo nombrecomercial sea v&aacute;lido y exista en la base de datos</p>";
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombrecomercial no es correcto</p>";
}

if (isset($_POST['colonia'])){
	$colonia=htmlentities(trim($_POST['colonia']));
	//$colonia=mysql_real_escape_string($colonia);
	
			if(trim($colonia)==""){
				$validacion=false;
				$mensaje=$mensaje."<p>Verifique que el campo colonia sea v&aacute;lido y exista en la base de datos</p>";
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo colonia no es correcto</p>";
}

if (isset($_POST['cp'])){
	$cp=htmlentities(trim($_POST['cp']));
	//$cp=mysql_real_escape_string($cp);
	
		if(!validarEntero($cp)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo cp contenga n&uacute;meros enteros</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cp no es correcto</p>";
}

if (isset($_POST['ciudad'])){
	$ciudad=htmlentities(trim($_POST['ciudad']));
	//$ciudad=mysql_real_escape_string($ciudad);
	
			if(trim($ciudad)==""){
				$validacion=false;
				$mensaje=$mensaje."<p>Verifique que el campo ciudad sea v&aacute;lido y exista en la base de datos</p>";
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo ciudad no es correcto</p>";
}

if (isset($_POST['estado'])){
	$estado=htmlentities(trim($_POST['estado']));
	//$estado=mysql_real_escape_string($estado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estado no es correcto</p>";
}

if (isset($_POST['idzona'])){
	$idzona=htmlentities(trim($_POST['idzona']));
	//$idzona=mysql_real_escape_string($idzona);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idzona no es correcto</p>";
}

if (isset($_POST['coordenadas'])){
	$coordenadas=htmlentities(trim($_POST['coordenadas']));
	//$coordenadas=mysql_real_escape_string($coordenadas);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo coordenadas no es correcto</p>";
}

if (isset($_POST['referencia'])){
	$referencia=htmlentities(trim($_POST['referencia']));
	//$referencia=mysql_real_escape_string($referencia);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo referencia no es correcto</p>";
}

if (isset($_POST['observaciones'])){
	$observaciones=htmlentities(trim($_POST['observaciones']));
	//$observaciones=mysql_real_escape_string($observaciones);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo observaciones no es correcto</p>";
}

if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	//$idsucursal=mysql_real_escape_string($idsucursal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
}

if (isset($_POST['idgirocomercial'])){
	$idgirocomercial=htmlentities(trim($_POST['idgirocomercial']));
	//$idgirocomercial=mysql_real_escape_string($idgirocomercial);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idgirocomercial no es correcto</p>";
}


if (isset($_POST['validardosis'])){
	$validardosis=htmlentities(trim($_POST['validardosis']));
	//$idgirocomercial=mysql_real_escape_string($idgirocomercial);
	
}else{
	$validardosis="no";
}

if (isset($_POST['contactos'])){
	$contactos=$_POST['contactos'];
	//$idgirocomercial=mysql_real_escape_string($idgirocomercial);
	
}else{
	$contactos=array();
}

if (isset($_POST['idempleado'])){
	$idempleado=htmlentities(trim($_POST['idempleado']));
	//$idempleado=mysql_real_escape_string($idempleado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idempleado no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}

if($validacion){
	$resultado=$Odomicilio->guardar($idcliente,$tipovialidad,$calle,$noexterior,$nointerior,$nombrecomercial,$colonia,$cp,$ciudad,$estado,$idzona,$coordenadas,$referencia,$observaciones,$idsucursal,$idgirocomercial,$validardosis,$idempleado,$contactos,$estatus);
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


?>