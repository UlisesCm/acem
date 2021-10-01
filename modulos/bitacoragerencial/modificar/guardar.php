<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
require('../Bitacoragerencial.class.php');
$Obitacoragerencial=new Bitacoragerencial;
$mensaje="";
$validacion=true;

if (isset($_POST['idbitacoragerencial'])){
	$idbitacoragerencial=htmlentities(trim($_POST['idbitacoragerencial']));
	//$idbitacoragerencial=mysql_real_escape_string($idbitacoragerencial);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idbitacoragerencial no es correcto</p>";
}

if (isset($_POST['fecha'])){
	$fecha=htmlentities(trim($_POST['fecha']));
	//$fecha=mysql_real_escape_string($fecha);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['evento'])){
	$evento=htmlentities(trim($_POST['evento']));
	//$evento=mysql_real_escape_string($evento);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo evento no es correcto</p>";
}

if (isset($_POST['idusuario'])){
	$idusuario=htmlentities(trim($_POST['idusuario']));
	//$idusuario=mysql_real_escape_string($idusuario);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idusuario no es correcto</p>";
}

if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	//$idsucursal=mysql_real_escape_string($idsucursal);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
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
	$resultado=$Obitacoragerencial->actualizar($fecha,$evento,$idusuario,$idsucursal,$archivo,$estatus, $idbitacoragerencial);
	if($resultado=="exito"){
		/*CARGAR ARCHIVOS*/
		$mensajeArchivo="";
		
		if($archivotemporal!=""){
			//Elimina la imagen antigua para actualizarla y que no ocupe espacio
			unlink("../archivosSubidos/bitacoragerencial/".$archivoEliminacion);
			$estadoArchivo=cargarArchivo($archivonombre,$extencionarchivo, $archivotemporal, $archivo,"jpg","bitacoragerencial",0,0,"archivo","center");
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