<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
require('../Bitacoravehicular.class.php');
$Obitacoravehicular=new Bitacoravehicular;
$mensaje="";
$validacion=true;

if (isset($_POST['idvehiculo'])){
	$idvehiculo=htmlentities(trim($_POST['idvehiculo']));
	//$idvehiculo=mysql_real_escape_string($idvehiculo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idvehiculo no es correcto</p>";
}

if (isset($_POST['categoria'])){
	$categoria=htmlentities(trim($_POST['categoria']));
	if($categoria=="0"){
		$validacion=false;
	    $mensaje=$mensaje."<p>Debe seleccionar categoria</p>";
	}
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
	
	if($descripcion == "" && $categoria != "COMBUSTIBLES"){
		$validacion=false;
	    $mensaje=$mensaje."<p>El campo descripcion no es correcto</p>";
	}
	
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
	
	if($litros == "" && $categoria == "COMBUSTIBLES"){
		$validacion=false;
		$mensaje=$mensaje."<p>El campo litros no es correcto</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo litros no es correcto</p>";

}

if (isset($_POST['kilometraje'])){
	$kilometraje=htmlentities(trim($_POST['kilometraje']));
	//$kilometraje=mysql_real_escape_string($kilometraje);
	
	if($kilometraje == "" && $categoria == "MANTENIMIENTOS"){
		$validacion=false;
	    $mensaje=$mensaje."<p>El campo kilometraje no es correcto</p>";
	}
	if($kilometraje == "" && $categoria == "COMBUSTIBLES"){
		$validacion=false;
	    $mensaje=$mensaje."<p>El campo kilometraje no es correcto</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo kilometraje no es correcto</p>";
	
}
/*CARGAR ARCHIVO*/
if (isset($_FILES['archivo']['name'])){
	$archivonombre=$_FILES['archivo']['name'];
	$archivotemporal=$_FILES['archivo']['tmp_name'];
	$extencionarchivo=pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
	$archivo=basename($_FILES['archivo']['name'],".".$extencionarchivo)."_".generarClave(5).".".$extencionarchivo;
	
	if($archivonombre == ""){
		$validacion=false;
	    $mensaje=$mensaje."<p>El campo archivo no es correcto</p>";
	}
	
	if($archivotemporal==""){
		$archivo="";
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

if($categoria == "MANTENIMIENTOS"){
	//establecer valores predeterminados a variables que se quedaron en blanco
	$litros=0;
	$tipocombustible="-";
}

if($categoria == "SEGUROS" || $categoria == "PAGO DE CUOTAS" || $categoria  == "OTROS"){
	//establecer valores predeterminados a variables que se quedaron en blanco
	$litros=0;
	$tipocombustible="-";
	$kilometraje=0;
}
if($categoria == "COMBUSTIBLES"){
	//establecer valores predeterminados a variables que se quedaron en blanco
	$descripcion = "-";
}


if($validacion){
	$resultado=$Obitacoravehicular->guardar($idvehiculo,$categoria,$fecha,$descripcion,$tipocombustible,$litros,$kilometraje,$archivo,$estatus);
	if($resultado=="exito"){
		/*CARGAR ARCHIVOS*/
		$mensajeArchivo="";
		
		if($archivotemporal!=""){
			
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