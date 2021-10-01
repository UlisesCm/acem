<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cliente.class.php');
$Ocliente=new Cliente;
$mensaje="";
$validacion=true;

if (isset($_POST['rfc'])){
	$rfc=htmlentities(trim($_POST['rfc']));
	//$rfc=mysql_real_escape_string($rfc);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo rfc no es correcto</p>";
}

if (isset($_POST['nombre'])){
	$nombre=htmlentities(trim($_POST['nombre']));
	//$nombre=mysql_real_escape_string($nombre);
	
			if(trim($nombre)==""){
				$validacion=false;
				$mensaje=$mensaje."<p>Verifique que el campo nombre sea v&aacute;lido y no exista en la base de datos</p>";
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
}

if (isset($_POST['nic'])){
	$nic=htmlentities(trim($_POST['nic']));
	//$nic=mysql_real_escape_string($nic);
	
			if(trim($nic)==""){
				$nic=htmlentities(trim($_POST['nombre']));
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nic no es correcto</p>";
}

if (isset($_POST['limitecredito'])){
	$limitecredito=htmlentities(trim($_POST['limitecredito']));
	//$limitecredito=mysql_real_escape_string($limitecredito);
	
		if(!validarDecimal($limitecredito)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo limitecredito sea num&eacute;rico</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo limitecredito no es correcto</p>";
}

if (isset($_POST['diascredito'])){
	$diascredito=htmlentities(trim($_POST['diascredito']));
	//$diascredito=mysql_real_escape_string($diascredito);
	
		if(!validarEntero($diascredito)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo diascredito contenga n&uacute;meros enteros</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo diascredito no es correcto</p>";
}

if (isset($_POST['saldo'])){
	$saldo=htmlentities(trim($_POST['saldo']));
	//$saldo=mysql_real_escape_string($saldo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo saldo no es correcto</p>";
}

if (isset($_POST['nombrecontacto'])){
	$nombrecontacto=htmlentities(trim($_POST['nombrecontacto']));
	//$nombrecontacto=mysql_real_escape_string($nombrecontacto);
			if(trim($nombrecontacto)==""){
				$nombrecontacto=htmlentities(trim($_POST['nombre']));
			}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombrecontacto no es correcto</p>";
}

if (isset($_POST['correocontacto'])){
	$correocontacto=htmlentities(trim($_POST['correocontacto']));
	//$correocontacto=mysql_real_escape_string($correocontacto);
	
		/*if(!validarEmail($correocontacto)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo correocontacto sea un email v&aacute;lido</p>";
		}*/
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo correocontacto no es correcto</p>";
}

if (isset($_POST['telefonocontacto'])){
	$telefonocontacto=htmlentities(trim($_POST['telefonocontacto']));
	//$telefonocontacto=mysql_real_escape_string($telefonocontacto);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo telefonocontacto no es correcto</p>";
}
if (isset($_POST['autorizardosis'])){
	$autorizardosis=htmlentities(trim($_POST['autorizardosis']));
	//$autorizardosis=mysql_real_escape_string($autorizardosis);
}else{
	$autorizardosis='no';
}
	
if (isset($_POST['autorizarproductos'])){
	$autorizarproductos=htmlentities(trim($_POST['autorizarproductos']));
	//$autorizarproductos=mysql_real_escape_string($autorizarproductos);
}else{
	$autorizarproductos='no';
}
	

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Ocliente->guardar($rfc,$nombre,$nic,$limitecredito,$diascredito,$saldo,$nombrecontacto,$correocontacto,$telefonocontacto,$autorizardosis,$autorizarproductos,$estatus);
	if($resultado=="exito"){
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
		/*$mensaje=$mensaje.'
				</br>
				<p>
				</br>
        		<form action=\"../../domicilios/nuevo/nuevo.php?n1=clientes&n2=domicilios&n3=nuevodomicilios\" method=\"post\">
                	<input type=\"hidden\" name=\"idcliente\" value=\"<?php echo $filas[\"idcliente\"] ?>\"/>
                    <input type=\"hidden\" name=\"nombre\" value=\"<?php echo $filas[\"nombre\"] ?>\"/>
                    <input type=\"hidden\" name=\"nic\" value=\"<?php echo $filas[\"nic\"] ?>\"/>
                    <button type=\"submit\" class=\"btn btn-default\" value=\"\" title=\"Nuevo domicilio de servicio\"><li class=\"fa fa-map-marker\"></li></button>
                </form>
				</p>';*/

	}
	if($resultado=="nombreExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo nombre ya existe en la base de datos";
	}
	if($resultado=="nicExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo nic ya existe en la base de datos";
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