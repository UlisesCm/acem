<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
require('../Sucursal.class.php');
$Osucursal=new Sucursal;
$mensaje="";
$validacion=true;

if (isset($_POST['nombre'])){
	$nombre=htmlentities(trim($_POST['nombre']));
	//$nombre=mysql_real_escape_string($nombre);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
}

if (isset($_POST['calle'])){
	$calle=htmlentities(trim($_POST['calle']));
	//$calle=mysql_real_escape_string($calle);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo calle no es correcto</p>";
}

if (isset($_POST['numero'])){
	$numero=htmlentities(trim($_POST['numero']));
	//$numero=mysql_real_escape_string($numero);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo numero no es correcto</p>";
}

if (isset($_POST['colonia'])){
	$colonia=htmlentities(trim($_POST['colonia']));
	//$colonia=mysql_real_escape_string($colonia);
	
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
	
			if(trim($estado)==""){
				$validacion=false;
				$mensaje=$mensaje."<p>Verifique que el campo estado sea v&aacute;lido y exista en la base de datos</p>";
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estado no es correcto</p>";
}

if (isset($_POST['coordenadas'])){
	$coordenadas=htmlentities(trim($_POST['coordenadas']));
	//$estado=mysql_real_escape_string($estado);
	
			if(trim($estado)==""){
				$validacion=false;
				$mensaje=$mensaje."<p>Verifique que el campo coordenadas sea v&aacute;lido y exista en la base de datos</p>";
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo coordenadas no es correcto</p>";
}

if (isset($_POST['telefonocontacto'])){
	$telefonocontacto=htmlentities(trim($_POST['telefonocontacto']));
	//$telefonocontacto=mysql_real_escape_string($telefonocontacto);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo telefonocontacto no es correcto</p>";
}

if (isset($_POST['licenciassa'])){
	$licenciassa=htmlentities(trim($_POST['licenciassa']));
	//$licenciassa=mysql_real_escape_string($licenciassa);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo licenciassa no es correcto</p>";
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
	
		if(!validarEntero($folio)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo folio contenga n&uacute;meros enteros</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo folio no es correcto</p>";
}

if (isset($_POST['idcuentacorreo'])){
	$idcuentacorreo=htmlentities(trim($_POST['idcuentacorreo']));
	//$idcuentacorreo=mysql_real_escape_string($idcuentacorreo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcuentacorreo no es correcto</p>";
}
/*CARGAR ARCHIVO*/
if (isset($_FILES['archivofirma']['name'])){
	$archivofirmanombre=$_FILES['archivofirma']['name'];
	$archivofirmatemporal=$_FILES['archivofirma']['tmp_name'];
	$extencionarchivofirma=pathinfo($_FILES['archivofirma']['name'], PATHINFO_EXTENSION);
	$archivofirma=basename($_FILES['archivofirma']['name'],".".$extencionarchivofirma)."_".generarClave(5).".".$extencionarchivofirma;
	
	if($archivofirmatemporal==""){
		$archivofirma="";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo archivofirma no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Osucursal->guardar($nombre,$calle,$numero,$colonia,$cp,$ciudad,$estado,$coordenadas,$telefonocontacto,$licenciassa,$serie,$folio,$idcuentacorreo,$archivofirma,$estatus);
	if($resultado=="exito"){
		/*CARGAR ARCHIVOS*/
		$mensajeArchivo="";
		
		if($archivofirmatemporal!=""){
			
			$estadoArchivo=cargarArchivo($archivofirmanombre,$extencionarchivofirma, $archivofirmatemporal, $archivofirma,"jpg","sucursales",200,200,"crop","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionarchivofirma. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
		$mensaje=$mensaje.$mensajeArchivo;
	}
	if($resultado=="nombreExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo nombre ya existe en la base de datos";
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