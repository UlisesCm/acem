<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Ruta.class.php');
$Oruta=new Ruta;
$mensaje="";
$validacion=true;
$iddomicilio=0;

if (isset($_POST['iddomicilio'])){
	$iddomicilio=htmlentities(trim($_POST['iddomicilio']));
	//SIGNIFICA QUE ES UNA ACTUALIZACIÓN DE COORDENADAS AL DOMICILIO
	if (isset($_POST['coordenadas'])){
		$coordenadas=htmlentities(trim($_POST['coordenadas']));
		//$serie=mysql_real_escape_string($serie);
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo coordenadas no es correcto</p>";
	}
	
}else{
	//SE ESTA GUARDANDO LA RUTA
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
	
	if (isset($_POST['nombre'])){
		$nombre=htmlentities(trim($_POST['nombre']));
		//$nombre=mysql_real_escape_string($nombre);
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
	}
	
	if (isset($_POST['fecha'])){
		$fecha=htmlentities(trim($_POST['fecha']));
		//$fecha=mysql_real_escape_string($fecha);
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
	}
	
	if (isset($_POST['idempleado'])){
		$idempleado=htmlentities(trim($_POST['idempleado']));
		//$idempleado=mysql_real_escape_string($idempleado);
		if($idempleado=="0"){
			$validacion=false;
			$mensaje=$mensaje."<p>El campo idempleado no es correcto</p>";
		}
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo idempleado no es correcto</p>";
	}
	
	if (isset($_POST['observacionesruta'])){
		$observacionesruta=htmlentities(trim($_POST['observacionesruta']));
		//$observacionesruta=mysql_real_escape_string($observacionesruta);
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo observacionesruta no es correcto</p>";
	}
	
	if (isset($_POST['tipoRuta'])){
		$tipoRuta=htmlentities(trim($_POST['tipoRuta']));
		if($tipoRuta==""){
			$validacion=false;
			$mensaje=$mensaje."<p>Debe generar la ruta para poderla guardar</p>";
		}
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>Debe generar la ruta para poderla guardar</p>";
	}
	
	if (isset($_POST['listaSalida']) && $_POST['listaSalida']!=""){
		$listaSalida=trim($_POST['listaSalida']);
		$listaSalida= substr($listaSalida, 0, -3);
		$listaSalida=explode(":::",$listaSalida);
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo listasalida no es correcto</p>";
	}
	
	if (isset($_POST['listaSalidaOptima']) && $_POST['listaSalidaOptima']!=""){
		$listaSalidaOptima=trim($_POST['listaSalidaOptima']);
		$listaSalidaOptima= substr($listaSalidaOptima, 0, -3);
		$listaSalidaOptima=explode(":::",$listaSalidaOptima);
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo listaSalidaOptima no es correcto</p>";
	}
	
	if (isset($_POST['listaSalidaCoordenadas']) && $_POST['listaSalidaCoordenadas']!=""){
		$listaSalidaCoordenadas=trim($_POST['listaSalidaCoordenadas']);
		$listaSalidaCoordenadas= substr($listaSalidaCoordenadas, 0, -3);
		$listaSalidaCoordenadas=explode(":::",$listaSalidaCoordenadas);
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo listaSalidaCoordenadas no es correcto</p>";
	}
	
}



if($validacion){
	if($iddomicilio==0){
		$resultado=$Oruta->guardar($serie,$folio,$nombre,$fecha,$idempleado,$observacionesruta,$listaSalida,$listaSalidaOptima,$listaSalidaCoordenadas,$tipoRuta);
	}
	else{
		$resultado=$Oruta->actualizarCoordenadasDomicilio($iddomicilio,$coordenadas);
	}
	if($resultado=="exito"){
		
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