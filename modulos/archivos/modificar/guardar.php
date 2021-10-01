<?php 
include ("../../seguridad/comprobar_login.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
require('../Archivo.class.php');
$Oarchivo=new Archivo;
$mensaje="";
$validacion=true;

if (isset($_POST['idarchivo'])){
	$idarchivo=htmlentities(trim($_POST['idarchivo']));
	//$idarchivo=mysql_real_escape_string($idarchivo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idarchivo no es correcto</p>";
}
if (isset($_POST['pdf'])){
	$pdf=htmlentities(trim($_POST['pdf']));
	$pdfEliminacion=trim($_POST['pdfEliminacion']);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo pdf no es correcto</p>";
}	
	/*CARGAR ARCHIVO*/
if (isset($_FILES['pdfI']['name'])){
	$pdftemporal=$_FILES['pdfI']['tmp_name'];
	$pdfnombre=$_FILES['pdfI']['name'];
	$extencionpdf=pathinfo($_FILES['pdfI']['name'], PATHINFO_EXTENSION);
	if($pdftemporal==""){
		$pdf=$pdf;
	}else{
		$pdf=basename($_FILES['pdfI']['name'],".".$extencionpdf)."_".generarClave(5).".".$extencionpdf;
	}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo pdf no es correcto</p>";
}
if (isset($_POST['xml'])){
	$xml=htmlentities(trim($_POST['xml']));
	$xmlEliminacion=trim($_POST['xmlEliminacion']);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo xml no es correcto</p>";
}	
	/*CARGAR ARCHIVO*/
if (isset($_FILES['xmlI']['name'])){
	$xmltemporal=$_FILES['xmlI']['tmp_name'];
	$xmlnombre=$_FILES['xmlI']['name'];
	$extencionxml=pathinfo($_FILES['xmlI']['name'], PATHINFO_EXTENSION);
	if($xmltemporal==""){
		$xml=$xml;
	}else{
		$xml=basename($_FILES['xmlI']['name'],".".$extencionxml)."_".generarClave(5).".".$extencionxml;
	}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo xml no es correcto</p>";
}

if (isset($_POST['fechamodificacion'])){
	$fechamodificacion=htmlentities(trim($_POST['fechamodificacion']));
	//$fechamodificacion=mysql_real_escape_string($fechamodificacion);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechamodificacion no es correcto</p>";
}

if (isset($_POST['tablareferencia'])){
	$tablareferencia=htmlentities(trim($_POST['tablareferencia']));
	//$tablareferencia=mysql_real_escape_string($tablareferencia);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tablareferencia no es correcto</p>";
}

if (isset($_POST['idreferencia'])){
	$idreferencia=htmlentities(trim($_POST['idreferencia']));
	//$idreferencia=mysql_real_escape_string($idreferencia);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idreferencia no es correcto</p>";
}

if (isset($_POST['serie'])){
	$serie=htmlentities(trim($_POST['serie']));
	//$serie=mysql_real_escape_string($serie);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo serie no es correcto</p>";
}

if (isset($_POST['folio'])){
	$folio=htmlentities(trim($_POST['folio']));
	//$folio=mysql_real_escape_string($folio);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo folio no es correcto</p>";
}

if (isset($_POST['tipo'])){
	$tipo=htmlentities(trim($_POST['tipo']));
	//$tipo=mysql_real_escape_string($tipo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipo no es correcto</p>";
}

if (isset($_POST['fechatimbre'])){
	$fechatimbre=htmlentities(trim($_POST['fechatimbre']));
	//$fechatimbre=mysql_real_escape_string($fechatimbre);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechatimbre no es correcto</p>";
}

if (isset($_POST['emisor'])){
	$emisor=htmlentities(trim($_POST['emisor']));
	//$emisor=mysql_real_escape_string($emisor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo emisor no es correcto</p>";
}

if (isset($_POST['rfcemisor'])){
	$rfcemisor=htmlentities(trim($_POST['rfcemisor']));
	//$rfcemisor=mysql_real_escape_string($rfcemisor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo rfcemisor no es correcto</p>";
}

if (isset($_POST['receptor'])){
	$receptor=htmlentities(trim($_POST['receptor']));
	//$receptor=mysql_real_escape_string($receptor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo receptor no es correcto</p>";
}

if (isset($_POST['rfcreceptor'])){
	$rfcreceptor=htmlentities(trim($_POST['rfcreceptor']));
	//$rfcreceptor=mysql_real_escape_string($rfcreceptor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo rfcreceptor no es correcto</p>";
}

if (isset($_POST['monto'])){
	$monto=htmlentities(trim($_POST['monto']));
	//$monto=mysql_real_escape_string($monto);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo monto no es correcto</p>";
}

if (isset($_POST['uuid'])){
	$uuid=htmlentities(trim($_POST['uuid']));
	//$uuid=mysql_real_escape_string($uuid);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo uuid no es correcto</p>";
}
if($validacion){
	$resultado=$Oarchivo->actualizar($pdf,$xml,$fechamodificacion,$tablareferencia,$idreferencia,$serie,$folio,$tipo,$fechatimbre,$emisor,$rfcemisor,$receptor,$rfcreceptor,$monto,$uuid, $idarchivo);
	if($resultado=="exito"){
		/*CARGAR ARCHIVOS*/
		$mensajeArchivo="";
		
		if($pdftemporal!=""){
			//Elimina la imagen antigua para actualizarla y que no ocupe espacio
			unlink("../archivosSubidos/archivos/".$pdfEliminacion);
			$estadoArchivo=cargarArchivo($pdfnombre,$extencionpdf, $pdftemporal, $pdf,"pdf","archivos",0,0,"archivo","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionpdf. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}
		if($xmltemporal!=""){
			//Elimina la imagen antigua para actualizarla y que no ocupe espacio
			unlink("../archivosSubidos/archivos/".$xmlEliminacion);
			$estadoArchivo=cargarArchivo($xmlnombre,$extencionxml, $xmltemporal, $xml,"xml","archivos",0,0,"archivo","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionxml. " del archivo, no es v&aacute;lida. ";
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