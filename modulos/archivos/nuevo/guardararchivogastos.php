<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');

$mensaje="";
$validacion=true;

/*CARGAR ARCHIVO*/
if (isset($_FILES['archivo']['name'])){
	$archivonombre=$_FILES['archivo']['name'];
	$archivotemporal=$_FILES['archivo']['tmp_name'];
	$extencionarchivo=pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
	$archivo=basename($_FILES['archivo']['name'],".".$extencionarchivo)."_".generarClave(5).".".$extencionarchivo;
	
	if($archivotemporal==""){
		$archivo="";
		$validacion=false;
		$mensaje=$mensaje."<p>El campo archivo es obligatorio</p>";
	}
	
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo archivo no es correcto</p>";
}

if($archivotemporal!=""){
	$estadoArchivo=cargarArchivo($archivonombre,$extencionarchivo, $archivotemporal, $archivo,"jpg,doc,docx,xls,xlsx,csv,pdf,rar,zip,txt","cursos",0,0,"archivo","center");
	if ($estadoArchivo=="exito"){
		echo utf8_encode($archivo);
	}else if ($estadoArchivo=="extencionInvalida"){
		echo utf8_encode("fracaso");
	}else{
		echo utf8_encode("fracaso");
	}
}
else{
	echo utf8_encode("fracaso");
}
?>