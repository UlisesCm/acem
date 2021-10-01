<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
require('../Usuario.class.php');
$Ousuario=new Usuario;
$mensaje="";
$validacion=true;

if (isset($_POST['idusuario'])){
	$idusuario=htmlentities(trim($_POST['idusuario']));
	//$idusuario=mysql_real_escape_string($idusuario);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idusuario no es correcto</p>";
}

if (isset($_POST['nombre'])){
	$nombre=htmlentities(trim($_POST['nombre']));
	//$nombre=mysql_real_escape_string($nombre);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
}

if (isset($_POST['email'])){
	$email=htmlentities(trim($_POST['email']));
	//$email=mysql_real_escape_string($email);
		if(!validarEmail($email)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo email sea un email v&aacute;lido</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo email no es correcto</p>";
}
if (isset($_POST['foto'])){
	$foto=htmlentities(trim($_POST['foto']));
	$fotoEliminacion=trim($_POST['fotoEliminacion']);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo foto no es correcto</p>";
}	
	/*CARGAR ARCHIVO*/
if (isset($_FILES['fotoI']['name'])){
	$fototemporal=$_FILES['fotoI']['tmp_name'];
	$fotonombre=$_FILES['fotoI']['name'];
	$extencionfoto=pathinfo($_FILES['fotoI']['name'], PATHINFO_EXTENSION);
	if($fototemporal==""){
		$foto=$foto;
	}else{
		$foto=basename($_FILES['fotoI']['name'],".".$extencionfoto)."_".generarClave(5).".".$extencionfoto;
	}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo foto no es correcto</p>";
}


	
if($validacion){
	$resultado=$Ousuario->modificarDatos($nombre,$email,$foto,$idusuario);
	if($resultado=="exito"){
		/*CARGAR ARCHIVOS*/
		$mensajeArchivo="";
		
		if($fototemporal!=""){
			//Elimina la imagen antigua para actualizarla y que no ocupe espacio
			unlink("../archivosSubidos/usuarios/".$fotoEliminacion);
			$estadoArchivo=cargarArchivo($fotonombre,$extencionfoto, $fototemporal, $foto,"jpg","usuarios",160,160,"crop","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionfoto. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
		$mensaje=$mensaje.$mensajeArchivo;
		//Actualziamos las variables de sesión
		if($foto!=""){
			$_SESSION["foto"]=$foto;
		}
		$_SESSION["nombreusuario"]=$nombre;
	}
	if($resultado=="usuarioExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo usuario ya existe en la base de datos";
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