<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Producto.class.php');
$Oproducto=new Producto;
$mensaje="";
$validacion=true;

if (isset($_POST['nombre'])){
	$nombre=htmlentities($_POST['nombre']);
	$nombre= preg_replace('/\s+/', ' ',$nombre);
	$nombre=trim($nombre);
	//$nombre=mysql_real_escape_string($nombre);
	if ($nombre==""){
		$validacion=false;
		$mensaje=$mensaje."<p>El campo nombre no es correcto, debe seleccionar una familia y elegir las caracteristicas del producto</p>";
	}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
}

if (isset($_POST['idfamilia'])){
	$idfamilia=htmlentities(trim($_POST['idfamilia']));
	//$nombre=mysql_real_escape_string($nombre);
	if ($idfamilia=="0" or $idfamilia==""){
		$validacion=false;
		$mensaje=$mensaje."<p>Debe elegir una familia diferente para clasificar el producto.</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>Debe elegir una familia para clasificar el producto.</p>";
}


if (isset($_POST['codigo'])){
	$codigo=htmlentities(trim($_POST['codigo']));
	//$codigo=mysql_real_escape_string($codigo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo codigo no es correcto</p>";
}
if (isset($_POST['autoclasificar'])){
	$autoclasificar=htmlentities(trim($_POST['autoclasificar']));
	//$autoclasificar=mysql_real_escape_string($autoclasificar);
}else{
	$autoclasificar='no';
}
	

if (isset($_POST['clasificacion'])){
	$clasificacion=htmlentities(trim($_POST['clasificacion']));
	//$clasificacion=mysql_real_escape_string($clasificacion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo clasificacion no es correcto</p>";
}

if (isset($_POST['costo'])){
	$costo=htmlentities(trim($_POST['costo']));
	//$costo=mysql_real_escape_string($costo);
	if ($costo=="" or $costo==0){
		$validacion=false;
		$mensaje=$mensaje."<p>El costo unitario no es v&aacute;lido</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo costo no es correcto</p>";
}

if (isset($_POST['idmodeloimpuestos'])){
	$idmodeloimpuestos=htmlentities(trim($_POST['idmodeloimpuestos']));
	//$idmodeloimpuestos=mysql_real_escape_string($idmodeloimpuestos);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idmodeloimpuestos no es correcto</p>";
}

if (isset($_POST['idcategoria'])){
	$idcategoria=htmlentities(trim($_POST['idcategoria']));
	//$idcategoria=mysql_real_escape_string($idcategoria);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcategoria no es correcto</p>";
}

if (isset($_POST['idunidad'])){
	$idunidad=htmlentities(trim($_POST['idunidad']));
	//$idunidad=mysql_real_escape_string($idunidad);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idunidad no es correcto</p>";
}

if (isset($_POST['marca'])){
	$marca=htmlentities(trim($_POST['marca']));
	//$idmarca=mysql_real_escape_string($idmarca);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo marca no es correcto</p>";
}

if (isset($_POST['pesoteorico'])){
	$pesoteorico=htmlentities(trim($_POST['pesoteorico']));
	//$pesoteorico=mysql_real_escape_string($pesoteorico);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo pesoteorico no es correcto</p>";
}

if (isset($_POST['espesor'])){
	$espesor=htmlentities(trim($_POST['espesor']));
	//$espesor=mysql_real_escape_string($espesor);
	
}else{
	$espesor="";
}

if (isset($_POST['ancho'])){
	$ancho=htmlentities(trim($_POST['ancho']));
	//$ancho=mysql_real_escape_string($ancho);
	
}else{
	$ancho="";
}

if (isset($_POST['color'])){
	$color=htmlentities(trim($_POST['color']));
	//$color=mysql_real_escape_string($color);
	
}else{
	$color="";
}

if (isset($_POST['diametro'])){
	$diametro=htmlentities(trim($_POST['diametro']));
	//$diametro=mysql_real_escape_string($diametro);
	
}else{
	$diametro="";
}

if (isset($_POST['tipo'])){
	$tipo=htmlentities(trim($_POST['tipo']));
	//$tipo=mysql_real_escape_string($tipo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipo no es correcto</p>";
}

if (isset($_POST['modelo'])){
	$modelo=htmlentities(trim($_POST['modelo']));
	$modelo= preg_replace('/\s+/', ' ',$modelo);
	$modelo=trim($modelo);
	//$modelo=mysql_real_escape_string($modelo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo modelo A no es correcto</p>";
}

if (isset($_POST['modelo2'])){
	$modelo2=htmlentities(trim($_POST['modelo2']));
	$modelo2= preg_replace('/\s+/', ' ',$modelo2);
	$modelo2=trim($modelo2);
	//$modelo=mysql_real_escape_string($modelo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo modelo B no es correcto</p>";
}


if (isset($_POST['lado'])){
	$lado=htmlentities(trim($_POST['lado']));
	//$lado=mysql_real_escape_string($lado);
	
}else{
	$lado="";
}

if (isset($_POST['alto'])){
	$alto=htmlentities(trim($_POST['alto']));
	//$alto=mysql_real_escape_string($alto);
	
}else{
	$alto="";
}

if (isset($_POST['largo'])){
	$largo=htmlentities(trim($_POST['largo']));
	//$alto=mysql_real_escape_string($alto);
	
}else{
	$largo="";
}
if (isset($_POST['aplicacion'])){
	$aplicacion=htmlentities(trim($_POST['aplicacion']));
	//$alto=mysql_real_escape_string($alto);
	
}else{
	$aplicacion="";
}

if (isset($_POST['clave'])){
	$clave=htmlentities(trim($_POST['clave']));
	$clave= preg_replace('/\s+/', ' ',$clave);
	$clave=trim($clave);
	//$alto=mysql_real_escape_string($alto);
	
}else{
	$clave="";
}
if (isset($_POST['descripcion'])){
	$descripcion=htmlentities(trim($_POST['descripcion']));
	//$descripcion=mysql_real_escape_string($descripcion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo descripcion no es correcto</p>";
}

if (isset($_POST['variacionpermitidaencosto'])){
	$variacionpermitidaencosto=htmlentities(trim($_POST['variacionpermitidaencosto']));
	//$variacionpermitidaencosto=mysql_real_escape_string($variacionpermitidaencosto);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo variacionpermitidaencosto no es correcto</p>";
}

if (isset($_POST['proveedores'])){
	$proveedores=$_POST['proveedores'];
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>Debe seleccionar al menos un proveedor relacionado</p>";
}

if (isset($_POST['claves'])){
	$claves=$_POST['claves'];
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>Debe seleccionar al menos un proveedor relacionado</p>";
}


if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Oproducto->guardar($idfamilia,$nombre,$codigo,$autoclasificar,$clasificacion,$idmodeloimpuestos,$idcategoria,$idunidad,$marca,$pesoteorico,$espesor,$ancho,$color,$diametro,$tipo,$modelo,$modelo2,$lado,$alto,$largo,$aplicacion,$clave,$descripcion,$variacionpermitidaencosto,$proveedores,$claves,$costo,$estatus);
	if($resultado=="exito"){
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="nombreExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@Ya existe un producto igual en la base de datos";
	}
	if($resultado=="codigoExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El codigo interno autogenerado ya existe en la base de datos";
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