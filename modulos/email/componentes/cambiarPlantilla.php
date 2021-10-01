<?php 
	include("../../plantillasmensajes/Plantillamensaje.class.php");
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	
	$Oplantillamensaje = new Plantillamensaje;
	$resultado=$Oplantillamensaje->consultaGeneral("WHERE idplantillamensaje='$idselect'");
	
	if ($resultado){
		$extractor = mysqli_fetch_array($resultado);
		$mensaje=$extractor["mensaje"];
		$mensaje=html_entity_decode($mensaje);
		$mes=date("m");
		if($mes=="01"){
			$MES="ENERO";
		}
		if($mes=="02"){
			$MES="FEBRERO";
		}
		if($mes=="03"){
			$MES="MARZO";
		}
		if($mes=="04"){
			$MES="ABRIL";
		}
		if($mes=="05"){
			$MES="MAYO";
		}
		if($mes=="06"){
			$MES="JUNIO";
		}
		if($mes=="07"){
			$MES="JULIO";
		}
		if($mes=="08"){
			$MES="AGOSTO";
		}
		if($mes=="09"){
			$MES="SEPTIEMBRE";
		}
		if($mes=="10"){
			$MES="OCTUBRE";
		}
		if($mes=="11"){
			$MES="NOVIEMBRE";
		}
		if($mes=="12"){
			$MES="DICIEMBRE";
		}
		$ano=date("y");
		$ANO=date("Y");
		$mensaje=str_replace("%MES%",$MES,$mensaje);
		$mensaje=str_replace("%mes%",strtolower($MES),$mensaje);
		$mensaje=str_replace("%ano%",$ano,$mensaje);
		$mensaje=str_replace("%ANO%",$ANO,$mensaje);
		
		echo $mensaje;
	}
?>