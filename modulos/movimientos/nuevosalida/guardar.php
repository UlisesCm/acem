<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Movimiento.class.php');
$Omovimiento=new Movimiento;
$mensaje="";
$validacion=true;

$hora=date("H:i:s");
$tabla="";
$idreferencia=0;
$estado="";

if (isset($_POST['tipo'])){
	$tipo=htmlentities(trim($_POST['tipo']));
	$tipo=trim($tipo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipo no es correcto</p>";
}

if (isset($_POST['concepto'])){
	$concepto=htmlentities(trim($_POST['concepto']));
	$concepto=trim($concepto);
	if ($concepto=="ELIJA UNO"){
		$validacion=false;
		$mensaje=$mensaje."<p>Debe seleccionar el concepto o raz&oacute;n del movimiento</p>";
	}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo concepto no es correcto</p>";
}

if (isset($_POST['fechamovimiento'])){
	$fechamovimiento=htmlentities(trim($_POST['fechamovimiento']));
	$fechamovimiento=trim($fechamovimiento);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechamovimiento no es correcto</p>";
}

if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	$idsucursal=trim($idsucursal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
}

if (isset($_POST['idsucursaldestino'])){
	$idsucursaldestino=htmlentities(trim($_POST['idsucursaldestino']));
	$idsucursaldestino=trim($idsucursaldestino);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo almacen destino no es correcto</p>";
}

if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	$idcliente=trim($idcliente);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cliente no es correcto</p>";
}

if (isset($_POST['idempleado'])){
	$idempleado=htmlentities(trim($_POST['idempleado']));
	$idempleado=trim($idempleado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo vendedor no es correcto</p>";
}

if (isset($_POST['numerocomprobante'])){
	$numerocomprobante=htmlentities(trim($_POST['numerocomprobante']));
	$numerocomprobante=trim($numerocomprobante);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo numerocomprobante no es correcto</p>";
}

if (isset($_POST['comentarios'])){
	$comentarios=htmlentities(trim($_POST['comentarios']));
	$comentarios=trim($comentarios);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo comentarios no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	$estatus=trim($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}

if (isset($_POST['listaSalida']) && $_POST['listaSalida']!=""){
	$lista=trim($_POST['listaSalida']);
	$lista= substr($lista, 0, -3);
	$lista=explode(":::",$lista);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>Es necesario que ingrese al menos un producto en la lista</p>";
}

if ($concepto=="TRASPASO"){
	if ($idsucursal==$idsucursaldestino){
		$validacion=false;
		$mensaje=$mensaje."<p>No se puede hacer un traspaso al mismo almac&eacute;n o sucursal</p>";
	}else{
		$tabla="sucursaldestino";
		$idreferencia= $idsucursaldestino;
		$estado="EN TRANSITO";
	}
}

if ($concepto=="CONSIGNACION A CLIENTE"){
	$idempleado=0;
	if ($idcliente==0){
		$validacion=false;
		$mensaje=$mensaje."<p>Se requeire que ingrese el nombre del cliente</p>";
	}
}

if ($concepto=="CONSIGNACION A VENDEDOR"){
	$idcliente=0;
	if ($idempleado==0){
		$validacion=false;
		$mensaje=$mensaje."<p>Se requeire que elija el vendedor</p>";
	}
}

$concentrado=false;
if ($concepto=="CONSIGNACION A CLIENTE" or $concepto=="CONSIGNACION A VENDEDOR" or $concepto=="M CONSIGNACION A CLIENTE" or $concepto=="M CONSIGNACION A VENDEDOR"){
	$concentrado=true;
}



if($validacion){
	if ($concentrado==true){ // Si el movimiento es un concentrado
		$resultado=$Omovimiento->guardar2($tipo,$concepto,$fechamovimiento,$idsucursal,$numerocomprobante,$comentarios,$estatus,"0","0",$idcliente,$idempleado,$lista);
		//crearDirectorio2($tipo,$idempleado,$idcliente,$numerocomprobante);
	}else{ // Si el movimiento no es un concentraro
		$resultado=$Omovimiento->guardar($tipo,$concepto,$fechamovimiento,$hora,$numerocomprobante,$idsucursal,$tabla,$idreferencia,$comentarios,$estado,$estatus,$lista);
		$resultadoArray=explode("@",$resultado);
		$resultado=$resultadoArray[0];
		$idmovimiento=$resultadoArray[1];
		//crearDirectorio($tipo,$idsucursal,$idsucursaldestino,$numerocomprobante);
		
	}
	if($resultado=="exito"){
		$mensaje='exito@Operaci&oacute;n exitosa@El registro ha sido guardado';
		if ($concentrado==true or $concepto=="TRASPASO"){
			$mensaje=$mensaje.'
				</br>
				<p>
				</br>
        		<form action="descargar.php" method="post">
            		<input name="f" type="hidden" value="'.$numerocomprobante.'-salida.pdf"/>
					<button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;Descargar</button>
        		</form>
				</p>
			';
		}
		
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

function crearDirectorio2($tipo,$idempleado,$idcliente,$numerocomprobante){
		$Odatos= new Movimiento;
		$clasi="";
		if ($idempleado!=0){
			$clasi="vendedor";
			$nombreSujeto=$Odatos->obtenerCampo("empleados","nombre","idempleado",$idempleado);
		}
		if ($idcliente!=0){
			$clasi="cliente";
			$nombreSujeto=$Odatos->obtenerCampo("clientes","nombre","idcliente",$idcliente);
		}
		
		$rutaEmpresa="../concentrados/";
		if(!is_dir($rutaEmpresa)){ 
			mkdir($rutaEmpresa, 0777);
		}
		$nombreArchivo=$numerocomprobante."-salida";
		ob_start();
		include('plantilla.php');
		$content = ob_get_clean();
	
		// convert in PDF
		require_once('../../../librerias/php/html2pdf/html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P', 'Letter', 'fr');
	//      $html2pdf->setModeDebug();
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output($rutaEmpresa.$nombreArchivo.".pdf",'F');
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
}

function crearDirectorio($tipo,$idsucursal,$idsucursaldestino,$numerocomprobante){
		$Odatos= new Movimiento;
		$clasi="";
		$idmovimiento=$Odatos->obtenerCampo("movimientos","idmovimiento","numerocomprobante",$numerocomprobante);
		$nombreAlmacen1=$Odatos->obtenerCampo("almacenes","nombre","idsucursal",$idsucursal);
		$nombreAlmacen2=$Odatos->obtenerCampo("almacenes","nombre","idsucursal",$idsucursaldestino);
		
		
		$rutaEmpresa="../concentrados/";
		if(!is_dir($rutaEmpresa)){ 
			mkdir($rutaEmpresa, 0777);
		}
		$nombreArchivo=$numerocomprobante."-salida";
		ob_start();
		include('plantilla3.php');
		$content = ob_get_clean();
	
		// convert in PDF
		require_once('../../../librerias/php/html2pdf/html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P', 'Letter', 'fr');
	//      $html2pdf->setModeDebug();
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output($rutaEmpresa.$nombreArchivo.".pdf",'F');
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
}

echo utf8_encode($mensaje);

?>