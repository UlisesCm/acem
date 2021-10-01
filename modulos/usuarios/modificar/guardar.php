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

if (isset($_POST['usuario'])){
	$usuario=htmlentities(trim($_POST['usuario']));
	//$usuario=mysql_real_escape_string($usuario);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo usuario no es correcto</p>";
}

if (isset($_POST['contrasena'])){
	$contrasena=htmlentities(trim($_POST['contrasena']));
	$contrasena=md5($contrasena);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo contrasena no es correcto</p>";
}

if (isset($_POST['estado'])){
	$estado=htmlentities(trim($_POST['estado']));
	//$estado=mysql_real_escape_string($estado);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estado no es correcto</p>";
}

if (isset($_POST['idperfil'])){
	$idperfil=htmlentities(trim($_POST['idperfil']));
	//$idperfil=mysql_real_escape_string($idperfil);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idperfil no es correcto</p>";
}

if (isset($_POST['empresa'])){
	$empresa=htmlentities(trim($_POST['empresa']));
	//$empresa=mysql_real_escape_string($empresa);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo empresa no es correcto</p>";
}
if (isset($_POST['controlaracceso'])){
	$controlaracceso=htmlentities(trim($_POST['controlaracceso']));
	//$controlaracceso=mysql_real_escape_string($controlaracceso);
}else{
	$controlaracceso='no';
}


if (isset($_POST['horainicio'])){
	$horainicio=htmlentities(trim($_POST['horainicio']));
	//$horainicio=mysql_real_escape_string($horainicio);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo horainicio no es correcto</p>";
}

if (isset($_POST['horafin'])){
	$horafin=htmlentities(trim($_POST['horafin']));
	//$horafin=mysql_real_escape_string($horafin);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo horafin no es correcto</p>";
}

if($_POST['tipo']=="Tecnico"){

	if (isset($_POST['idtecnico'])){
		$idregistrorelacionado=htmlentities(trim($_POST['idtecnico']));
		//$idempleado=mysql_real_escape_string($idempleado);
$tablarelacionada='tecnicos';
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo idtecnico no es correcto</p>";
	}

}

if ($_POST['tipo']=="Empleado") {
	if (isset($_POST['idempleado'])){
		$idregistrorelacionado=htmlentities(trim($_POST['idempleado']));
		//$idempleado=mysql_real_escape_string($idempleado);
$tablarelacionada='empleados';
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo idempleado no es correcto</p>";
	}
}

if ($_POST['tipo']=="Cliente") {
	if (isset($_POST['idcliente'])){
		$idregistrorelacionado=htmlentities(trim($_POST['idcliente']));
		//$idempleado=mysql_real_escape_string($idempleado);
$tablarelacionada='clientes';
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo cliente no es correcto</p>";
	}
}


if (isset($_POST['bitacora'])){
	$bitacora=htmlentities(trim($_POST['bitacora']));
	//$bitacora=mysql_real_escape_string($bitacora);
}else{
	$bitacora='no';
}

if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	//$bitacora=mysql_real_escape_string($bitacora);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
}

if($validacion){
	$resultado=$Ousuario->actualizar($nombre,$email,$foto,$usuario,$contrasena,$estado,$idperfil,$empresa,$controlaracceso,$horainicio,$horafin,$idregistrorelacionado,$tablarelacionada,$bitacora, $idusuario,$idsucursal);
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
