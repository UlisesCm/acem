<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Compra.class.php');
$Ocompra=new Compra;
$mensaje="";
$validacion=true;


if (isset($_POST['idcompra'])){
	$idcompra=htmlentities(trim($_POST['idcompra']));
	$idcompra=trim($idcompra);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcompra no es correcto</p>";
}


if (isset($_POST['idempleado'])){
	$idempleado=htmlentities(trim($_POST['idempleado']));
	$idempleado=trim($idempleado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idempleado no es correcto</p>";
}

if (isset($_POST['fecha'])){
	$fecha=htmlentities(trim($_POST['fecha']));
	$fecha=trim($fecha);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['fechavencimiento'])){
	$fechavencimiento=htmlentities(trim($_POST['fechavencimiento']));
	$fechavencimiento=trim($fechavencimiento);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechavencimiento no es correcto</p>";
}


if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	$idsucursal=trim($idsucursal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
}

if (isset($_POST['idproveedor'])){
	$idproveedor=htmlentities(trim($_POST['idproveedor']));
	$idproveedor=trim($idproveedor);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idproveedor no es correcto</p>";
}


if (isset($_POST['comentarios'])){
	$comentarios=htmlentities(trim($_POST['comentarios']));
	$comentarios=trim($comentarios);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo comentarios no es correcto</p>";
}


if (isset($_POST['listaSalida']) && $_POST['listaSalida']!=""){
	$lista=trim($_POST['listaSalida']);
	$lista= substr($lista, 0, -3);
	$lista=explode(":::",$lista);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>Es necesario que ingrese al menos un producto en la lista</p>";
}


if (isset($_POST['estado'])){
	$estado=htmlentities(trim($_POST['estado']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estado no es correcto</p>";
}

if($validacion){
	
	$resultado=$Ocompra->actualizar($fecha,$fechavencimiento,$idempleado,$comentarios,$estado,'0',$idsucursal,$idproveedor,"",$idcompra,$lista);
	$resultadoArray=explode("@",$resultado);
	$resultado=$resultadoArray[0];
	$idmovimiento=$resultadoArray[1];
	
	if($resultado=="exito"){
		$mensaje='exito@Operaci&oacute;n exitosa@El registro ha sido guardado';
	
		$mensaje=$mensaje.'
				</br>
				<p>
				</br>
        		<form action="descargar.php" method="post">
            		<input name="f" type="hidden" value="diferencia.pdf"/>
					<button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;Descargar</button>
        		</form>
				</p>
			';
	}
	if($resultado=="fracaso"){
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	}
	if($resultado=="fracasoAceptada"){
		$mensaje="fracaso@Operaci&oacute;n fallida@La requisici&oacute;n ya ha sido aceptada. No se pueden hacer modificaciones";
	}
	if($resultado=="denegado"){
		$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);
?>