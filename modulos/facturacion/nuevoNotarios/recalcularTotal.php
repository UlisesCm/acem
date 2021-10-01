<?php 
session_start();
$tipoempresa=$_SESSION["tipoempresa"];
require("../../productos$tipoempresa/Producto.class.php");
$Oproducto=new Producto;

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

$labelISRretenido="hide";
$labelIVAretenido="hide";
$labelIVAtrasladado="hide";
$labelIEPSretenido="hide";
$labelIEPStrasladado="hide";
$labelDescuento="hide";
$labelISH="hide";
$labelImpuestoCedular="hide";

$totalIVAretenido=0;
$totalIVAtrasladado=0;
$totalISRretenido=0;
$totalIEPSretenido=0;
$totalIEPStrasladado=0;

$ivaretenido=0;
$ivatrasladado=0;
$isrretenido=0;
$iepsretenido=0;
$iepstrasladado=0;
$descuento=0;
$subtotal=0;

$DECIMALES=2;

if (isset($_POST['moneda'])){
	$moneda=htmlentities(trim($_POST['moneda']));
	$moneda=trim($moneda);
	if ($moneda=="MXN"){
		$DECIMALES=2;
	}
	if ($moneda=="USD"){
		$DECIMALES=2;
	}
	if ($moneda=="USN"){
		$DECIMALES=2;
	}
	if ($moneda=="EUR"){
		$DECIMALES=2;
	}
}

if (isset($_POST['eshotel'])){
	$eshotel=htmlentities(trim($_POST['eshotel']));
	$eshotel=trim($eshotel);
	if($eshotel==1){
		$tasaish=$_POST['tasaish'];
	}
	
}else{
	$eshotel="0";
	$ish=0;
}

if (isset($_POST['impuestocedular'])){
	$hayimpuestocedular=htmlentities(trim($_POST['impuestocedular']));
	$hayimpuestocedular=trim($hayimpuestocedular);
	if($hayimpuestocedular=="si"){
		$tasaimpuestocedular=$_POST['tasaimpuestocedular'];
	}
	
}else{
	$hayimpuestocedular="no";
	$impuestocedular=0;
}


$lista=trim($_POST['listaSalida']);
$lista= substr($lista, 0, -3);
$lista=explode(":::",$lista);

$arregloIdproducto=descomponerArreglo(4,0,$lista);
$arregloCantidad=descomponerArreglo(4,1,$lista);
$arregloPrecio=descomponerArreglo(4,2,$lista);
$arregloDescuento=descomponerArreglo(4,3,$lista);
			
$con=0;
$validar=true;

while ($con < count($arregloIdproducto)){
	$idproducto=$arregloIdproducto[$con];
	$cantidad=round($arregloCantidad[$con],6);
	$preciounitario=round($arregloPrecio[$con],6);
	$descuentounitario=round($arregloDescuento[$con],6); // ME quede aqui, en lugar de pasar el monto en el array, hay que pasar el descuento
	
	$idmodeloimpuestos=$Oproducto->obtenerCampo("idmodeloimpuestos",$idproducto);
	$resultado=$Oproducto->consultaLibre("SELECT * FROM impuestos WHERE idmodeloimpuesto='$idmodeloimpuestos'");
	
	$subtotal=$subtotal+($cantidad*$preciounitario);
	$descuento=$descuento+(round($cantidad*$descuentounitario,$DECIMALES));
	$subtotal=round($subtotal,$DECIMALES);
	$descuento=round($descuento,$DECIMALES);
	
	if ($descuento!=0){
		$labelDescuento="";
	}
	
	while ($filas=mysqli_fetch_array($resultado)) {
			$clavesat=$filas['clavesat'];
			$impuesto=$filas['nombre'];
			$tipo=$filas['tipo'];
			$factor=$filas['factor'];
			$valor=$filas['valor'];
			
			if ($clavesat=="001"){ // Si es ISR
				if ($tipo=="RETENCION"){
					$totalISRretenido=($cantidad*$preciounitario)*$valor;
					$labelISRretenido="";
					$isrretenido=$isrretenido+$totalISRretenido;
				}
			}// Fin Si es ISR
			if ($clavesat=="002"){ // Si es IVA
				if ($tipo=="RETENCION"){
					$totalIVAretenido=($cantidad*$preciounitario)*$valor;
					$labelIVAretenido="";
					$ivaretenido=$ivaretenido+$totalIVAretenido;
				}
				if ($tipo=="TRASLADO"){
					$totalIVAtrasladado=($cantidad*$preciounitario)*$valor;
					$labelIVAtrasladado="";
					$ivatrasladado=$ivatrasladado+$totalIVAtrasladado;
				}
			}// Fin Si es IVA
			if ($clavesat=="003"){ // Si es IEPS
				if ($tipo=="RETENCION"){
					$totalIEPSretenido=($cantidad*$preciounitario)*$valor;
					$labelIEPSretenido="";
					$iepsretenido=$iepsretenido+$totalIEPSretenido;
				}
				if ($tipo=="TRASLADO"){
					$totalIEPStrasladado=($cantidad*$preciounitario)*$valor;
					$labelIEPStrasladado="";
					$iepstrasladado=$iepstrasladado+$totalIEPStrasladado;
				}
			}// Fin Si es IEPS
			
		} // Fin de while para obtener los impuestos
		
		$con++;
}

//$subtotal=$subtotal+($cantidad*$preciounitario);
//$descuento=$descuento+$descuentounitario;

$isrretenido=round($isrretenido,$DECIMALES);
$ivaretenido=round($ivaretenido,$DECIMALES);
$iepsretenido=round($iepsretenido,$DECIMALES);

$ivatrasladado=round($ivatrasladado,$DECIMALES);
$iepstrasladado=round($iepstrasladado,$DECIMALES);

$impuestosretenidos=$isrretenido+$ivaretenido+$iepsretenido;
$impuestosretenidos=round($impuestosretenidos,$DECIMALES);
$impuestostrasladados=$ivatrasladado+$iepstrasladado;
$impuestostrasladados=round($impuestostrasladados,$DECIMALES);
$descuento=round($descuento,$DECIMALES);
$subtotal=round($subtotal,$DECIMALES);

if($eshotel==1){
	$ish=($tasaish/100)*$subtotal;
	$labelISH="";
}
	
if($hayimpuestocedular=="si"){
	$impuestocedular=($tasaimpuestocedular/100)*$subtotal;
	$labelImpuestoCedular="";
}


$total=$subtotal-$descuento+$impuestostrasladados-$impuestosretenidos-$impuestocedular+$ish;
$total=round($total,$DECIMALES);
		
?>
        				<div class="form-group">
                            <div class="col-sm-5">
                                <h3 style="line-height:0px;">Subtotal:</h3>
                            </div>
                            <div class="col-sm-7">
                                <h3 style="line-height:0px;" id="lsubtotal">$<?php echo number_format($subtotal,$DECIMALES); ?></h3>
                                <input id="subtotal" value="<?php echo $subtotal; ?>" type="hidden"/>
                            </div>
                        </div>
                        
                        <div class="form-group <?php echo $labelDescuento; ?>">
                            <div class="col-sm-5">
                                <h3 style="line-height:0px;">Descuento:</h3>
                            </div>
                            <div class="col-sm-7">
                                <h3 style="line-height:0px;">$<?php echo number_format($descuento,$DECIMALES); ?></h3>
                                <input id="descuento" value="<?php echo $descuento; ?>" type="hidden"/>
                            </div>
                        </div>
                        
                         <div class="form-group <?php echo $labelIVAtrasladado; ?>">
                            <div class="col-sm-5">
                                <h3 style="line-height:0px;">IVA trasladado:</h3>
                            </div>
                            <div class="col-sm-7">
                                <h3 style="line-height:0px;">$<?php echo number_format($ivatrasladado,$DECIMALES); ?></h3>
                                <input id="ivatrasladado" value="<?php echo $ivatrasladado; ?>" type="hidden"/>
                            </div>
                        </div>
                        
                         <div class="form-group <?php echo $labelIEPStrasladado; ?>">
                            <div class="col-sm-5">
                                <h3 style="line-height:0px;">IEPS trasladado:</h3>
                            </div>
                            <div class="col-sm-7">
                                <h3 style="line-height:0px;">$<?php echo number_format($iepstrasladado,$DECIMALES); ?></h3>
                                <input id="iepstrasladado" value="<?php echo $iepstrasladado; ?>" type="hidden"/>
                            </div>
                        </div>
                        
                        <div class="form-group <?php echo $labelISRretenido; ?>">
                            <div class="col-sm-5">
                                <h3 style="line-height:0px;">ISR retenido:</h3>
                            </div>
                            <div class="col-sm-7">
                                <h3 style="line-height:0px;">$<?php echo number_format($isrretenido,$DECIMALES); ?></h3>
                                <input id="isrretenido" value="<?php echo $isrretenido; ?>" type="hidden"/>
                            </div>
                        </div>
                        
                        <div class="form-group <?php echo $labelIVAretenido; ?>">
                            <div class="col-sm-5">
                                <h3 style="line-height:0px;">IVA retenido:</h3>
                            </div>
                            <div class="col-sm-7">
                                <h3 style="line-height:0px;">$<?php echo number_format($ivaretenido,$DECIMALES); ?></h3>
                                <input id="ivaretenido" value="<?php echo $ivaretenido; ?>" type="hidden"/>
                            </div>
                        </div>
                        
                        <div class="form-group lieps <?php echo $labelIEPSretenido?>">
                            <div class="col-sm-5">
                                <h3 style="line-height:0px;">IEPS retenido:</h3>
                            </div>
                            <div class="col-sm-7">
                                <h3 style="line-height:0px;">$<?php echo number_format($iepsretenido,$DECIMALES); ?></h3>
                                <input id="iepsretenido" value="<?php echo $iepsretenido; ?>" type="hidden"/>
                            </div>
                        </div>
                        
                        
                        <div class="form-group lic <?php echo $labelImpuestoCedular?>">
                            <div class="col-sm-5">
                                <h3 style="line-height:0px;">Cedulares (<?php echo $tasaimpuestocedular; ?>%)</h3>
                            </div>
                            <div class="col-sm-7">
                                <h3 style="line-height:0px;">$<?php echo number_format($impuestocedular,$DECIMALES); ?></h3>
                            </div>
                        </div>
                        
                        <div class="form-group lish <?php echo $labelISH ?>">
                            <div class="col-sm-5">
                                <h3 style="line-height:0px;">ISH (<?php echo $tasaish; ?>%)</h3>
                            </div>
                            <div class="col-sm-7">
                                <h3 style="line-height:0px;">$<?php echo number_format($ish,$DECIMALES); ?></h3>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-5">
                                <h3 style="line-height:0px;">Total:</h3>
                            </div>
                            <div class="col-sm-7">
                                <h3 style="line-height:0px;" id="ltotal">$<?php echo number_format($total,$DECIMALES); ?></h3>
                            </div>
                        </div>
                        <?php ?>