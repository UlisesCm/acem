<?php 
include ("../../seguridad/comprobar_login.php");
include_once('../../../librerias/php/thumb.php');
require('../Configuracion.class.php');
$Oconfiguracion=new Configuracion;
$mensaje="";
$validacion=true;

if (isset($_POST['idconfiguracion'])){
	$idconfiguracion=htmlentities(trim($_POST['idconfiguracion']));
	$idconfiguracion=trim($idconfiguracion);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idconfiguracion no es correcto</p>";
}

if (isset($_POST['cabeceraimpresion'])){
	$cabeceraimpresion=htmlentities(trim($_POST['cabeceraimpresion']));
	$cabeceraimpresion=trim($cabeceraimpresion);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cabeceraimpresion no es correcto</p>";
}

if (isset($_POST['pieimpresion'])){
	$pieimpresion=htmlentities(trim($_POST['pieimpresion']));
	$pieimpresion=trim($pieimpresion);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo pieimpresion no es correcto</p>";
}

if (isset($_POST['separadorimpresion'])){
	$separadorimpresion=htmlentities(trim($_POST['separadorimpresion']));
	$separadorimpresion=trim($separadorimpresion);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo separadorimpresion no es correcto</p>";
}
if (isset($_POST['descripcioncompletaimpresion'])){
	$descripcioncompletaimpresion=htmlentities(trim($_POST['descripcioncompletaimpresion']));
	$descripcioncompletaimpresion=trim($descripcioncompletaimpresion);
}else{
	$descripcioncompletaimpresion='no';
}

if (isset($_POST['tipoempresa'])){
	$tipoempresa=htmlentities(trim($_POST['tipoempresa']));
	$tipoempresa=trim($tipoempresa);
}else{
	$tipoempresa='Estandar';
}

if (isset($_POST['cbticket'])){
	$cbticket=htmlentities(trim($_POST['cbticket']));
	$cbticket=trim($cbticket);
}else{
	$cbticket='no';
}

if (isset($_POST['nombreproducticket'])){
	$nombreproducticket=htmlentities(trim($_POST['nombreproducticket']));
	$nombreproducticket=trim($nombreproducticket);
}else{
	$nombreproducticket='no';
}

if (isset($_POST['modeloticket'])){
	$modeloticket=htmlentities(trim($_POST['modeloticket']));
	$modeloticket=trim($modeloticket);
}else{
	$modeloticket='no';
}


if (isset($_POST['generoticket'])){
	$generoticket=htmlentities(trim($_POST['generoticket']));
	$generoticket=trim($generoticket);
}else{
	$generoticket='no';
}

if (isset($_POST['mostrarlogo'])){
	$mostrarlogo=htmlentities(trim($_POST['mostrarlogo']));
	$mostrarlogo=trim($mostrarlogo);
}else{
	$mostrarlogo='no';
}

if (isset($_POST['logoticket'])){
	$logoticket=htmlentities(trim($_POST['logoticket']));
	$logoticketEliminacion=trim($_POST['logoticketEliminacion']);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo logoticket no es correcto</p>";
}

/*CARGAR ARCHIVO*/
if (isset($_FILES['logoticketI']['name'])){
	$logotickettemporal=$_FILES['logoticketI']['tmp_name'];
	$logoticketnombre=$_FILES['logoticketI']['name'];
	$extencionlogoticket=pathinfo($_FILES['logoticketI']['name'], PATHINFO_EXTENSION);
	if($logotickettemporal==""){
		$logoticket=$logoticket;
	}else{
		$logoticket=basename($_FILES['logoticketI']['name'],".".$extencionlogoticket)."_".generarClave(5).".".$extencionlogoticket;
	}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo logoticket no es correcto :/</p>";
}

	
if($validacion){
	$resultado=$Oconfiguracion->actualizar($cabeceraimpresion,$pieimpresion,$separadorimpresion,$descripcioncompletaimpresion,$tipoempresa,$logoticket,$nombreproducticket,$modeloticket,$generoticket,$cbticket,$mostrarlogo,$idconfiguracion);
	if($resultado=="exito"){
		
		/*CARGAR ARCHIVOS*/
		$mensajeArchivo="";
		
		if($logotickettemporal!=""){
			//Elimina la imagen antigua para actualizarla y que no ocupe espacio
			unlink("../archivosSubidos/configuracion/".$logoticketEliminacion);
			$estadoArchivo=cargarArchivo($logoticketnombre,$extencionlogoticket, $logotickettemporal, $logoticket,"jpg","configuracion",100,0,"resize","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionlogoticket. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}
		
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