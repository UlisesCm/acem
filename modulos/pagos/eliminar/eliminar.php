<?php 
include ("../../seguridad/comprobar_login.php");
require('../Pago.class.php');

$Opago=new Pago;
$mensaje="";

if (isset($_REQUEST['ids']) && $_REQUEST['ids'] !="") {
	if($_REQUEST['ids']!="undefined"){
		if(is_array($_REQUEST['ids'])){
			$ids = implode(',', ($_REQUEST['ids']));
		}else{
			$ids=$_REQUEST['ids'];
		}	
		
		if (isset($_POST['tipo'])){
	        $tipo=htmlentities(trim($_POST['tipo']));
        }
		
		if (isset($_POST['tablareferencia'])){
	        $tablareferencia=htmlentities(trim($_POST['tablareferencia']));
        }
		
		if (isset($_POST['idreferencia'])){
	        $idreferencia=htmlentities(trim($_POST['idreferencia']));
        }
		
		if (isset($_POST['estadoliquidacion'])){
	        $estadoliquidacion=htmlentities(trim($_POST['estadoliquidacion']));
        }
		
		if($estadoliquidacion=="LIQUIDADO"){
			$mensaje="fracaso@Operaci&oacute;n fallida@No se puede cancelar el pago ya que la venta ha sido liquidada";	
		}
		else{//eliminar el registro
			if($resultado=$Opago->eliminar($ids, $tipo, $idreferencia, $tablareferencia, "real")){
				if ($resultado=="denegado"){
					$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
				}else{
					$mensaje="exito@Operaci&oacute;n exitosa@Los registos han sido eliminados";
				}
			}else{
				$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
			}
		}
		
		
	}else{
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema la transmisión de datos[002]";
	}
}else{
	$mensaje="aviso@Operaci&oacute;n fallida@No se ha seleccionado ning&uacute;n registro";
}

echo utf8_encode($mensaje);
?>
