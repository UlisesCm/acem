<?php
function validarRFC($rfc){
	$longitud=strlen($rfc);
	if ($longitud==13){
		$patron = '/^(([A-Z]|[a-z]|\s){1})(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))$/D';
		  if (preg_match($patron, $rfc)) {
            return true;
		  } else {
			return false;
		  }
	}else if($longitud==12){
		 $patron = '/^(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))$/D';
		 if (preg_match($patron, $rfc)) {
            return true;
		  } else {
			return false;
		  }
	}else{
		return false;
	}
}

function validarRFCMoral($rfc){
	$longitud=strlen($rfc);
	if($longitud==12){
		 $patron = '/^(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))$/D';
		 if (preg_match($patron, $rfc)) {
            return true;
		  } else {
			return false;
		  }
	}else{
		return false;
	}
}

function validarRFCFisica($rfc){
	$longitud=strlen($rfc);
	if ($longitud==13){
		$patron = '/^(([A-Z]|[a-z]|\s){1})(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))$/D';
		  if (preg_match($patron, $rfc)) {
            return true;
		  } else {
			return false;
		  }
	}else{
		return false;
	}
}


function validarDecimal($decimal){
	$ultimo = substr($decimal, -1);
	if ($ultimo==".") {
		$decimal=substr($decimal, 0, -1);
	}
	$patron = '/^[0-9]+(\.[0-9]+)?$/D';
	if (preg_match($patron, $decimal)) {
    	return true;
	} else {
		return false;
	}
}

function validarEntero($entero){
	$patron = '/^[[:digit:]]+$/';
	if (preg_match($patron, $entero)) {
    	return true;
	} else {
		return false;
	}
}

function validarFecha($fecha){ //dd/mm/aaaa
	$patron = '/^\d{2}\/\d{2}\/\d{4}$/';
	if (preg_match($patron, $fecha)) {
		$fd=explode("/",$fecha);
		$dia=$fd[0];
		$mes=$fd[1];
		$ano=$fd[2];
		if ($dia>31){
			return false;
		}else if ($mes>12){
			return false;
		}else{
    		return true;
		}
	} else {
		return false;
	}
}


function validarEmail($email){
	$patron = '/^[a-z0-9_\-]+(\.[_a-z0-9\-]+)*@([_a-z0-9\-]+\.)+([a-z]{2}|aero|asia|arpa|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|mx|com.mx|gob|gob.mx)$/D';
	if (preg_match($patron, $email)) {
    	return true;
	} else {
		return false;
	}
}


function descomponerArreglo($elementosPorVuelta,$elementoSeleccionado, $arreglo){
	$totalElementos= count($arreglo);
	if ($totalElementos!=1){
		$con=0;
		$totalVueltas=$totalElementos/$elementosPorVuelta;
		while($con<$totalVueltas){
			$array[$con]= $arreglo[$elementoSeleccionado];
			$elementoSeleccionado=$elementoSeleccionado+$elementosPorVuelta;
			$con++;
		}
		return $array;
	}else{
		return $arreglo;
	}
}

function crearArray($arreglo, $campo, $tablaExtra, $campoExtra, $tipoFuncion){
	$Objeto=new Producto;
	$nuevoArray=array();
	foreach ($arreglo as $clave => $valor) {
		if ($tipoFuncion=="simple"){
			$codigo=$Objeto->obtenerCampo( $campo, $valor);
			array_push($nuevoArray, $codigo);
		}else{
			$codigo=$Objeto->obtenerCampoExtraordinario($campo,$valor,$tablaExtra,$campoExtra);
			array_push($nuevoArray, $codigo);
		}
	}
	return $nuevoArray;
}

function calcularImporteArray($array1,$array2){
	$nuevoArray=array();
	foreach ($array1 as $clave => $valor) {
		$importe=$array1[$clave]*$array2[$clave];
		array_push($nuevoArray, $importe);
	}
	return $nuevoArray;
}

	function cargaAtt(&$nodo, $attr){
        global $xml, $cadena_original;
        $quitar = array('sello'=>1,'noCertificado'=>1,'certificado'=>1);
        foreach ($attr as $key => $val){
            $val = preg_replace('/\s\s+/', ' ', $val);
            $val = trim($val);
            if (strlen($val)>0){
                 $val = utf8_encode(str_replace("|","/",$val));
                 $nodo->setAttribute($key,$val);
                 if (!isset($quitar[$key])) 
                   if (substr($key,0,3) != "xml" &&
                       substr($key,0,4) != "xsi:")
                    $cadena_original .= $val . "|";
            }
         }
     }
	 
     
    # 14.2 Función que integra los nodos al archivo .XML sin integrar a la "Cadena original". 
    function cargaAttSinIntACad(&$nodo, $attr){
        global $xml, $cadena_original;
        $quitar = array('sello'=>1,'noCertificado'=>1,'certificado'=>1);
        foreach ($attr as $key => $val){
            $val = preg_replace('/\s\s+/', ' ', $val);
            $val = trim($val);
            if (strlen($val)>0){
                 $val = utf8_encode(str_replace("|","/",$val));
                 $nodo->setAttribute($key,$val);
                 if (!isset($quitar[$key])) 
                   if (substr($key,0,3) != "xml" && substr($key,0,4) != "xsi:"){
					   $cadena_original .= "|";
				   }
            }
         }
     }     

    
    # 14.3 Funciónes que da formato al "Importe total" como lo requiere el SAT para ser integrado al código QR.
     
    function ProcesImpTot($ImpTot){
        $ImpTot = number_format($ImpTot, 4); // <== Se agregó el 30 de abril de 2017.
        $ArrayImpTot = explode(".", $ImpTot);
        $NumEnt = $ArrayImpTot[0];
        $NumDec = ProcesDecFac($ArrayImpTot[1]);
        
        return $NumEnt.".".$NumDec;
    }
    
    function ProcesDecFac($Num){
        $FolDec = "";
        if ($Num < 10){$FolDec = "00000".$Num;}
        if ($Num > 9 and $Num < 100){$FolDec = $Num."0000";}
        if ($Num > 99 and $Num < 1000){$FolDec = $Num."000";}
        if ($Num > 999 and $Num < 10000){$FolDec = $Num."00";}
        if ($Num > 9999 and $Num < 100000){$FolDec = $Num."0";}
        return $FolDec;
    }

?>

