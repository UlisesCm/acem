<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cotizacionproducto.class.php');
$Ocotizacionproducto=new Cotizacionproducto;
$mensaje="";
$validacion=true;

if (isset($_POST['idcotizacionproducto'])){
	$idcotizacionproducto=htmlentities(trim($_POST['idcotizacionproducto']));
	//$idcotizacionproducto=mysql_real_escape_string($idcotizacionproducto);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcotizacionproducto no es correcto</p>";
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

if (isset($_POST['fecha'])){
	$fecha=htmlentities(trim($_POST['fecha']));
	//$fecha=mysql_real_escape_string($fecha);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['hora'])){
	$hora=htmlentities(trim($_POST['hora']));
	//$hora=mysql_real_escape_string($hora);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo hora no es correcto</p>";
}

if (isset($_POST['estadopago'])){
	$estadopago=htmlentities(trim($_POST['estadopago']));
	//$estadopago=mysql_real_escape_string($estadopago);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estadopago no es correcto</p>";
}

if (isset($_POST['estadofacturacion'])){
	$estadofacturacion=htmlentities(trim($_POST['estadofacturacion']));
	//$estadofacturacion=mysql_real_escape_string($estadofacturacion);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estadofacturacion no es correcto</p>";
}

if (isset($_POST['tipo'])){
	$tipo=htmlentities(trim($_POST['tipo']));
	//$tipo=mysql_real_escape_string($tipo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipo no es correcto</p>";
}

if (isset($_POST['subtotal'])){
	$subtotal=htmlentities(trim($_POST['subtotal']));
	//$subtotal=mysql_real_escape_string($subtotal);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo subtotal no es correcto</p>";
}

if (isset($_POST['impuestos'])){
	$impuestos=htmlentities(trim($_POST['impuestos']));
	//$impuestos=mysql_real_escape_string($impuestos);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo impuestos no es correcto</p>";
}

if (isset($_POST['total'])){
	$total=htmlentities(trim($_POST['total']));
	//$total=mysql_real_escape_string($total);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo total no es correcto</p>";
}

if (isset($_POST['costodeventa'])){
	$costodeventa=htmlentities(trim($_POST['costodeventa']));
	//$costodeventa=mysql_real_escape_string($costodeventa);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo costodeventa no es correcto</p>";
}

if (isset($_POST['utilidad'])){
	$utilidad=htmlentities(trim($_POST['utilidad']));
	//$utilidad=mysql_real_escape_string($utilidad);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo utilidad no es correcto</p>";
}

if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	//$idcliente=mysql_real_escape_string($idcliente);
			if(trim($idcliente)==""){
				$validacion=false;
				$mensaje=$mensaje."<p>Verifique que el campo idcliente sea v&aacute;lido y exista en la base de datos</p>";
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcliente no es correcto</p>";
}

if (isset($_POST['idusuario'])){
	$idusuario=htmlentities(trim($_POST['idusuario']));
	//$idusuario=mysql_real_escape_string($idusuario);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idusuario no es correcto</p>";
}

if (isset($_POST['idempleado'])){
	$idempleado=htmlentities(trim($_POST['idempleado']));
	//$idempleado=mysql_real_escape_string($idempleado);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idempleado no es correcto</p>";
}

if (isset($_POST['enviaradomicilio'])){
	$enviaradomicilio=htmlentities(trim($_POST['enviaradomicilio']));
	//$enviaradomicilio=mysql_real_escape_string($enviaradomicilio);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo enviaradomicilio no es correcto</p>";
}

if (isset($_POST['fechaentrega'])){
	$fechaentrega=htmlentities(trim($_POST['fechaentrega']));
	//$fechaentrega=mysql_real_escape_string($fechaentrega);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechaentrega no es correcto</p>";
}

if (isset($_POST['horaentregainicio'])){
	$horaentregainicio=htmlentities(trim($_POST['horaentregainicio']));
	//$horaentregainicio=mysql_real_escape_string($horaentregainicio);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo horaentregainicio no es correcto</p>";
}

if (isset($_POST['horaentregafin'])){
	$horaentregafin=htmlentities(trim($_POST['horaentregafin']));
	//$horaentregafin=mysql_real_escape_string($horaentregafin);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo horaentregafin no es correcto</p>";
}

if (isset($_POST['prioridad'])){
	$prioridad=htmlentities(trim($_POST['prioridad']));
	//$prioridad=mysql_real_escape_string($prioridad);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo prioridad no es correcto</p>";
}

if (isset($_POST['iddomicilio'])){
	$iddomicilio=htmlentities(trim($_POST['iddomicilio']));
	//$domicilioentrega=mysql_real_escape_string($domicilioentrega);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo iddomicilio no es correcto</p>";
}

if (isset($_POST['coordenadas'])){
	$coordenadas=htmlentities(trim($_POST['coordenadas']));
	//$coordenadas=mysql_real_escape_string($coordenadas);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo coordenadas no es correcto</p>";
}

if (isset($_POST['observaciones'])){
	$observaciones=htmlentities(trim($_POST['observaciones']));
	//$observaciones=mysql_real_escape_string($observaciones);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo observaciones no es correcto</p>";
}

if (isset($_POST['estadoentrega'])){
	$estadoentrega=htmlentities(trim($_POST['estadoentrega']));
	//$estadoentrega=mysql_real_escape_string($estadoentrega);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estadoentrega no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Ocotizacionproducto->actualizar($serie,$folio,$fecha,$hora,$estadopago,$estadofacturacion,$tipo,$subtotal,$impuestos,$total,$costodeventa,$utilidad,$idcliente,$idusuario,$idempleado,$enviaradomicilio,$fechaentrega,$horaentregainicio,$horaentregafin,$prioridad,$iddomicilio,$coordenadas,$observaciones,$estadoentrega,$estatus, $idcotizacionproducto);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="idcotizacionproductoExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo idcotizacionproducto ya existe en la base de datos";
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