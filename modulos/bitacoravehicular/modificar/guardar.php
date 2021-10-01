<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
require('../Bitacoravehicular.class.php');
$Obitacoravehicular=new Bitacoravehicular;
$mensaje="";
$validacion=true;

if (isset($_POST['idbitacoravehicular'])){
	$idbitacoravehicular=htmlentities(trim($_POST['idbitacoravehicular']));
	//$idbitacoravehicular=mysql_real_escape_string($idbitacoravehicular);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idbitacoravehicular no es correcto</p>";
}

if (isset($_POST['idvehiculo'])){
	$idvehiculo=htmlentities(trim($_POST['idvehiculo']));
	//$idvehiculo=mysql_real_escape_string($idvehiculo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idvehiculo no es correcto</p>";
}

if (isset($_POST['categoria'])){
	$categoria=htmlentities(trim($_POST['categoria']));
	//$categoria=mysql_real_escape_string($categoria);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo categoria no es correcto</p>";
}

if (isset($_POST['fecha'])){
	$fecha=htmlentities(trim($_POST['fecha']));
	//$fecha=mysql_real_escape_string($fecha);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['descripcion'])){
	$descripcion=htmlentities(trim($_POST['descripcion']));
	//$descripcion=mysql_real_escape_string($descripcion);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo descripcion no es correcto</p>";
}

if (isset($_POST['tipocombustible'])){
	$tipocombustible=htmlentities(trim($_POST['tipocombustible']));
	//$tipocombustible=mysql_real_escape_string($tipocombustible);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipocombustible no es correcto</p>";
}

if (isset($_POST['litros'])){
	$litros=htmlentities(trim($_POST['litros']));
	//$litros=mysql_real_escape_string($litros);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo litros no es correcto</p>";
}

if (isset($_POST['kilometraje'])){
	$kilometraje=htmlentities(trim($_POST['kilometraje']));
	//$kilometraje=mysql_real_escape_string($kilometraje);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo kilometraje no es correcto</p>";
}
if (isset($_POST['archivo'])){
	$archivo=htmlentities(trim($_POST['archivo']));
	$archivoEliminacion=trim($_POST['archivoEliminacion']);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo archivo no es correcto</p>";
}	
	/*CARGAR ARCHIVO*/
if (isset($_FILES['archivoI']['name'])){
	$archivotemporal=$_FILES['archivoI']['tmp_name'];
	$archivonombre=$_FILES['archivoI']['name'];
	$extencionarchivo=pathinfo($_FILES['archivoI']['name'], PATHINFO_EXTENSION);
	if($archivotemporal==""){
		$archivo=$archivo;
	}else{
		$archivo=basename($_FILES['archivoI']['name'],".".$extencionarchivo)."_".generarClave(5).".".$extencionarchivo;
	}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo archivo no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Obitacoravehicular->actualizar($idvehiculo,$categoria,$fecha,$descripcion,$tipocombustible,$litros,$kilometraje,$archivo,$estatus, $idbitacoravehicular);
	if($resultado=="exito"){
		/*CARGAR ARCHIVOS*/
		$mensajeArchivo="";
		
		if($archivotemporal!=""){
			//Elimina la imagen antigua para actualizarla y que no ocupe espacio
			unlink("../archivosSubidos/bitacoravehicular/".$archivoEliminacion);
			$estadoArchivo=cargarArchivo($archivonombre,$extencionarchivo, $archivotemporal, $archivo,"jpg","bitacoravehicular",0,0,"archivo","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionarchivo. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
		$mensaje=$mensaje.$mensajeArchivo;
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