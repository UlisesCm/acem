<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cotizacionproducto.class.php');
$Ocotizacionproducto=new Cotizacionproducto;

require('../../cotizacionesotros/Cotizacionotro.class.php');
$Ocotizacionotro=new Cotizacionotro;

$mensaje="";
$validacion=true;

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
$clienteSeleccionado=true;
$cliente="";
if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	//$idcliente=mysql_real_escape_string($idcliente);
	if(trim($idcliente)==""){//ES NUEVO CLIENTE
	   $clienteSeleccionado=false;
	   if (isset($_POST['autoidcliente'])){
			$cliente=htmlentities(trim($_POST['autoidcliente']));
			//$idusuario=mysql_real_escape_string($idusuario);
			if(trim($cliente)==""){
				  $validacion=false;
				  $mensaje=$mensaje."<p>No se ha seleccionado ni capturado el cliente</p>";
			 }
		}else{
			$validacion=false;
			$mensaje=$mensaje."<p>El campo cliente no es correcto</p>";
		}
	}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcliente no es correcto</p>";
}

if (isset($_POST['telefono'])){
	$telefono=htmlentities(trim($_POST['telefono']));
	//$idusuario=mysql_real_escape_string($idusuario);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo telefono no es correcto</p>";
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

if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	//$idsucursal=mysql_real_escape_string($idsucursal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
}

if (isset($_POST['dividirventa'])){
	$dividirventa="SI";
	//$idsucursal=mysql_real_escape_string($idsucursal);
	
}else{
	$dividirventa="NO";
}

if (isset($_POST['montodivision'])){
	$montodivision=htmlentities(trim($_POST['montodivision']));
	//$idsucursal=mysql_real_escape_string($idsucursal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo montodivision no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
	
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
	$mensaje=$mensaje."<p>Es necesario que ingrese al menos un producto en la lista de productos</p>";
}



//*****************RECIBIR EL MONTO DE LA COTIZACIÓN DE OTROS PARA EVALUAR SI SE VA A GUARDAR O NO***************************
if (isset($_POST['montootros'])){
	$montootros=htmlentities(trim($_POST['montootros']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo monto no es correcto</p>";
}

if (isset($_POST['serieotros'])){
	$serieotros=htmlentities(trim($_POST['serieotros']));
	//$serie=mysql_real_escape_string($serie);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo serieotros no es correcto</p>";
}

if (isset($_POST['foliootros'])){
	$foliootros=htmlentities(trim($_POST['foliootros']));
	//$folio=mysql_real_escape_string($folio);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo foliootros no es correcto</p>";
}

if (isset($_POST['fechaotros'])){
	$fechaotros=htmlentities(trim($_POST['fechaotros']));
	//$fecha=mysql_real_escape_string($fecha);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechaotros no es correcto</p>";
}

if (isset($_POST['tipootros'])){
	$tipootros=htmlentities(trim($_POST['tipootros']));
	//$tipo=mysql_real_escape_string($tipo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipootros no es correcto</p>";
}

if (isset($_POST['montootros'])){
	$montootros=htmlentities(trim($_POST['montootros']));
	//$monto=mysql_real_escape_string($monto);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo montootros no es correcto</p>";
}

if (isset($_POST['observacionesotros'])){
	$observacionesotros=htmlentities(trim($_POST['observacionesotros']));
	//$observaciones=mysql_real_escape_string($observaciones);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo observacionesotros no es correcto</p>";
}

if (isset($_POST['estatusotros'])){
	$estatusotros=htmlentities(trim($_POST['estatusotros']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatusotros no es correcto</p>";
}

if (isset($_POST['subtotalotros'])){
	$subtotalotros=htmlentities(trim($_POST['subtotalotros']));
	//$idsucursal=mysql_real_escape_string($idsucursal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo subtotalotros no es correcto</p>";
}

if (isset($_POST['impuestosotros'])){
	$impuestosotros=htmlentities(trim($_POST['impuestosotros']));
	//$idsucursal=mysql_real_escape_string($idsucursal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo impuestosotros no es correcto</p>";
}

if (isset($_POST['idmodeloimpuestosotros'])){
	$idmodeloimpuestosotros=htmlentities(trim($_POST['idmodeloimpuestosotros']));
	//$idsucursal=mysql_real_escape_string($idsucursal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idmodeloimpuestosotros no es correcto</p>";
}

if (isset($_POST['listaSalidaOtros']) && $_POST['listaSalidaOtros']!=""){
	$listaOtros=trim($_POST['listaSalidaOtros']);
	$listaOtros= substr($listaOtros, 0, -3);
	$listaOtros=explode(":::",$listaOtros);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>Es necesario que ingrese al menos un servicio en la lista de otros</p>";
}

//*******************************RECEPCION DE VARIABLES DE DOMICILIO*************************

//REVISAR SI DEBEN RECIBIRSE LAS VARIABLES SI NO SALTARSELAS PARA SALTAR LA VALIDACIÓN DE LAS MISMAS

//INICIALIZAR VARIABLES
$idgirocomercial="";
$tipovialidad="";
$calle="";
$noexterior="";
$nointerior="";
$colonia="";
$cp="";
$idzona="";
$nombrecomercial="";
$coordenadas = "";
$estado = "";
$ciudad = "";
$referencia="";
$observacionesdomicilio="";



if (isset($_POST['iddomicilio'])){
	$iddomicilio=htmlentities(trim($_POST['iddomicilio']));
	//$tipovialidad=mysql_real_escape_string($tipovialidad);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo iddomicilio no es correcto</p>";
}
	
$domicilioSeleccionado = true;
if($iddomicilio=="NUEVO" || $iddomicilio=="SELECCIONE DOMICILIO..."){//NO SE SELECCIONÓ DOMICILIO
	$domicilioSeleccionado = false;
}

if($enviaradomicilio == "ENVIO A DOMICILIO"){
	
if($domicilioSeleccionado== false){//NO SE SELECCIONÓ DOMICILIO ENTONCES RECIBIR Y VALIDAR LSO DATOS DE LDOMICILIO
	if (isset($_POST['tipovialidad'])){
		$tipovialidad=htmlentities(trim($_POST['tipovialidad']));
		//$tipovialidad=mysql_real_escape_string($tipovialidad);
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo tipovialidad no es correcto</p>";
	}
	
	if (isset($_POST['calle'])){
		$calle=htmlentities(trim($_POST['calle']));
		//$calle=mysql_real_escape_string($calle);
		
				if(trim($calle)==""){
					$validacion=false;
					$mensaje=$mensaje."<p>Verifique que el campo calle sea v&aacute;lido y exista en la base de datos</p>";
				}
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo calle no es correcto</p>";
	}
	
	if (isset($_POST['noexterior'])){
		$noexterior=htmlentities(trim($_POST['noexterior']));
		//$noexterior=mysql_real_escape_string($noexterior);
		
				if(trim($noexterior)==""){
					$validacion=false;
					$mensaje=$mensaje."<p>Verifique que el campo noexterior sea v&aacute;lido y exista en la base de datos</p>";
				}
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo noexterior no es correcto</p>";
	}
	
	if (isset($_POST['nointerior'])){
		$nointerior=htmlentities(trim($_POST['nointerior']));
		//$nointerior=mysql_real_escape_string($nointerior);
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo nointerior no es correcto</p>";
	}
	
	if (isset($_POST['nombrecomercial'])){
		$nombrecomercial=htmlentities(trim($_POST['nombrecomercial']));
		//$nointerior=mysql_real_escape_string($nointerior);
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo nombrecomercial no es correcto</p>";
	}
	
	if (isset($_POST['colonia'])){
		$colonia=htmlentities(trim($_POST['colonia']));
		//$colonia=mysql_real_escape_string($colonia);
		
				if(trim($colonia)==""){
					$validacion=false;
					$mensaje=$mensaje."<p>Verifique que el campo colonia sea v&aacute;lido y exista en la base de datos</p>";
				}
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
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo estado no es correcto</p>";
	}
	
	if (isset($_POST['idzona2'])){
		$idzona=htmlentities(trim($_POST['idzona2']));
		//$idzona=mysql_real_escape_string($idzona);
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo idzona no es correcto</p>";
	}
	
	if (isset($_POST['coordenadas'])){
		$coordenadas=htmlentities(trim($_POST['coordenadas']));
		//$coordenadas=mysql_real_escape_string($coordenadas);
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo coordenadas no es correcto</p>";
	}
	
	if (isset($_POST['referencia'])){
		$referencia=htmlentities(trim($_POST['referencia']));
		//$referencia=mysql_real_escape_string($referencia);
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo referencia no es correcto</p>";
	}
	
	if (isset($_POST['observacionesdomicilio'])){
		$observacionesdomicilio=htmlentities(trim($_POST['observacionesdomicilio']));
		//$observaciones=mysql_real_escape_string($observaciones);
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo observaciones no es correcto</p>";
	}
	
	if (isset($_POST['idgirocomercial'])){
		$idgirocomercial=htmlentities(trim($_POST['idgirocomercial']));
		//$idgirocomercial=mysql_real_escape_string($idgirocomercial);
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo idgirocomercial no es correcto</p>";
	}
	
	if (isset($_POST['validardosis'])){
		$validardosis=htmlentities(trim($_POST['validardosis']));
		//$idgirocomercial=mysql_real_escape_string($idgirocomercial);
		
	}else{
		$validardosis="no";
	}
	
	if (isset($_POST['contactos'])){
		$contactos=$_POST['contactos'];
		//$idgirocomercial=mysql_real_escape_string($idgirocomercial);
		
	}else{
		$contactos=array();
	}
  }//FIN NO SE SELECCIONO DOMICILIO
}//FIN VALIDACION SI ES ENVIAR A DOMICILIO
else{
	$iddomicilio=0;//para que si no es enviar a domicilio n ose guarde el iddomicilio que esté primero en la lista de los que se cargaron que están ligados a este cliente
}


if($validacion){
	//Guardar cotización de productos
	$resultado=$Ocotizacionproducto->guardar($clienteSeleccionado,$domicilioSeleccionado,$cliente,$telefono,$idgirocomercial,$tipovialidad,$calle,$noexterior,$nointerior,$colonia,$cp,$idzona,$nombrecomercial,$serie,$folio,$fecha,$hora,$estadopago,$estadofacturacion,$tipo,$subtotal,$impuestos,$total,$costodeventa,$utilidad,$observaciones,$idcliente,$idusuario,$idempleado,$idsucursal,$iddomicilio,$enviaradomicilio,$fechaentrega,$horaentregainicio,$horaentregafin,$prioridad,$coordenadas,$ciudad, $estado, $referencia,$observacionesdomicilio,$estadoentrega,$estatus,$lista,$dividirventa,$montodivision,$serieotros,$foliootros,$fechaotros,$tipootros,$montootros,$observacionesotros,$listaOtros,$impuestosotros,$subtotalotros,$idmodeloimpuestosotros,$estatusotros);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="idcotizacionproductoExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo idcotizacionproducto ya existe en la base de datos";
	}
	if($resultado=="clienteExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo cliente ya existe en la base de datos";
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