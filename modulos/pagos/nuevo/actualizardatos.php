<?php 
include ("../../seguridad/comprobar_login.php");
include ("../Pago.class.php");
//$idreferencia = $_POST['idreferencia'];
$idreferencia = $_POST['idreferencia'];
$tablareferencia = $_POST['tablareferencia'];
$idcliente = $_POST['idcliente'];
$devuelto = 0;
$Opago=new Pago;
$idsucursal=$_SESSION["idsucursal"];
//$idempleado=$_SESSION["idempleado"];
/*$resultado=$Opago->consultaLibre("SELECT * FROM caja WHERE idsucursal='$idsucursal' AND idempleado='$idempleado' ORDER BY idcaja DESC");
if(mysqli_num_rows($resultado) > 0){
	$filas=mysqli_fetch_array($resultado);
	$estado= $filas['estado'];
	if ($estado!="abierta"){
		$idcaja=0;
	}else{
		$idcaja=$filas['idcaja'];
	}
}else{
	$idcaja=0;
}*/



$resultado=$Opago->consultaLibre("SELECT * FROM clientes WHERE idcliente='$idcliente'");
if(mysqli_num_rows($resultado) > 0){
	$filas=mysqli_fetch_array($resultado);
	$nombrecliente=$filas['nombre'];
	$saldocliente=$filas['saldo'];
	$limitecredito=$filas['limitecredito'];
	/*$calificacion=$filas['calificacion'];
		if ($calificacion==0){
			$estrella1="<i class='fa fa-star-o'></i>";
			$estrella2="<i class='fa fa-star-o'></i>";
			$estrella3="<i class='fa fa-star-o'></i>";
			$estrella4="<i class='fa fa-star-o'></i>";
			$estrella5="<i class='fa fa-star-o'></i>";
		}
		if ($calificacion==1){
			$estrella1="<i class='fa fa-star'></i>";
			$estrella2="<i class='fa fa-star-o'></i>";
			$estrella3="<i class='fa fa-star-o'></i>";
			$estrella4="<i class='fa fa-star-o'></i>";
			$estrella5="<i class='fa fa-star-o'></i>";
		}
		if ($calificacion==2){
			$estrella1="<i class='fa fa-star'></i>";
			$estrella2="<i class='fa fa-star'></i>";
			$estrella3="<i class='fa fa-star-o'></i>";
			$estrella4="<i class='fa fa-star-o'></i>";
			$estrella5="<i class='fa fa-star-o'></i>";
		}
		if ($calificacion==3){
			$estrella1="<i class='fa fa-star'></i>";
			$estrella2="<i class='fa fa-star'></i>";
			$estrella3="<i class='fa fa-star'></i>";
			$estrella4="<i class='fa fa-star-o'></i>";
			$estrella5="<i class='fa fa-star-o'></i>";
		}
		if ($calificacion==4){
			$estrella1="<i class='fa fa-star'></i>";
			$estrella2="<i class='fa fa-star'></i>";
			$estrella3="<i class='fa fa-star'></i>";
			$estrella4="<i class='fa fa-star'></i>";
			$estrella5="<i class='fa fa-star-o'></i>";
		}
		if ($calificacion==5){
			$estrella1="<i class='fa fa-star'></i>";
			$estrella2="<i class='fa fa-star'></i>";
			$estrella3="<i class='fa fa-star'></i>";
			$estrella4="<i class='fa fa-star'></i>";
			$estrella5="<i class='fa fa-star'></i>";
		}*/
}

if ($idreferencia!=0){
	$IDTabla = "";
	//DEFINIR QUE CAMPO SE VA A CONSULTAR SEGUN TABLAREFERENCIA
	if($tablareferencia=="cotizacionesproductos"){
		$IDTabla = "idcotizacionproducto";
	}
	if($tablareferencia=="detallecotizacionesotros"){
		$IDTabla = "iddetallecotizacionotros";
	}
	$tablareferenciaConsulta = "$tablareferencia" . $_SESSION["idsucursal"];
	$resultado=$Opago->consultaLibre("SELECT * FROM $tablareferenciaConsulta WHERE $IDTabla='$idreferencia'");
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$fechaventa=$filas['fecha'];
		$totaltotal=$filas['total'];
		//$formapago=$filas['formapago'];
		//$devuelto=$filas['devuelto'];
		$pagos = "pagos" . $_SESSION["idsucursal"];
		$resultado2=$Opago->consultaLibre("SELECT SUM(monto) AS totalpagos FROM $pagos WHERE idreferencia='$idreferencia' AND tablareferencia = '$tablareferencia'");
		if(mysqli_num_rows($resultado2) > 0){
			$filas2=mysqli_fetch_array($resultado2);
			$totalpagos=$filas2['totalpagos'];
		}
	}
}else{
	$resultado=$Opago->consultaLibre("SELECT * FROM ventasajuste WHERE tablareferencia='$tablareferencia'");
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$fechaventa=$filas['fecha'];
		$totaltotal=$filas['total'];
		$formapago="CREDITO";
		$devuelto=0;
		$resultado2=$Opago->consultaLibre("SELECT SUM(monto) AS totalpagos FROM pagos WHERE tablareferencia='$tablareferencia'");
		if(mysqli_num_rows($resultado2) > 0){
			$filas2=mysqli_fetch_array($resultado2);
			$totalpagos=$filas2['totalpagos'];
		}
	}
}
$total=$totaltotal-$devuelto;


echo (number_format($saldocliente,2))."@".(number_format($totalpagos,2))."@".number_format(($total-$totalpagos),2);
?>