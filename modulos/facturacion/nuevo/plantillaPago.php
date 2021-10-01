<page style="width:800px; height:auto; font-family:Arial;font-size:14px; color:#000;">
	<?php
    $color="#000";
	
	// CATALOGO FORMA DE PAGO
			
	if ($formapago=="01"){
		$formapagolabel="EFECTIVO";
	}
	if ($formapago=="02"){
		$formapagolabel="CHEQUE NOMINATIVO";
	}
	if ($formapago=="03"){
		$formapagolabel="TRANSFERENCIA ELECTRÓNICA";
	}
	if ($formapago=="04"){
		$formapagolabel="TARJETA DE CRÉDITO";
	}
	if ($formapago=="05"){
		$formapagolabel="MONEDERO ELECTRÓNICO";
	}
	if ($formapago=="06"){
		$formapagolabel="DINERO ELECTRÓNICO";
	}
	if ($formapago=="08"){
		$formapagolabel="VALES DE DESPENSA";
	}
	if ($formapago=="12"){
		$formapagolabel="DACIÓN EN PAGO";
	}
	if ($formapago=="13"){
		$formapagolabel="PAGO POR SUBROGACIÓN";
	}
	if ($formapago=="14"){
		$formapagolabel="PAGO POR CONSIGNACIÓN";
	}
	if ($formapago=="15"){
		$formapagolabel="CONDONACIÓN";
	}
	if ($formapago=="17"){
		$formapagolabel="COMPENSACIÓN";
	}
	if ($formapago=="23"){
		$formapagolabel="NOVACIÓN";
	}
	if ($formapago=="24"){
		$formapagolabel="CONFUSIÓN";
	}
	if ($formapago=="25"){
		$formapagolabel="REMISIÓN DE DEUDA";
	}
	if ($formapago=="26"){
		$formapagolabel="PRESCRIPCIÓN O CADUCIDAD";
	}
	if ($formapago=="27"){
		$formapagolabel="A SATISFACCIÓN DEL ACREEDOR";
	}
	if ($formapago=="28"){
		$formapagolabel="TARJETA DE DÉBITO";
	}
	if ($formapago=="29"){
		$formapagolabel="TARJETA DE SERVICIOS";
	}
	if ($formapago=="30"){
		$formapagolabel="APLICACIÓN DE ANTICIPOS";
	}
	if ($formapago=="99"){
		$formapagolabel="POR DEFINIR";
	}
	
	// CATALOGOS REGIMINES EMISOR
	if ($regimenEmisor=="601"){
		$regimenemisorlabel="GENERAL DE LEY PERSONAS MORALES";
	}
	if ($regimenEmisor=="603"){
		$regimenemisorlabel="PERSONAS MORALES CON FINES NO LUCRATIVOS";
	}
	if ($regimenEmisor=="605"){
		$regimenemisorlabel="SUELDOS Y SALARIOS E INGRESOS ASIMILADOS A SALARIOS";
	}
	if ($regimenEmisor=="606"){
		$regimenemisorlabel="ARRENDAMIENTO";
	}
	if ($regimenEmisor=="608"){
		$regimenemisorlabel="DEMÁS INGRESOS";
	}
	if ($regimenEmisor=="609"){
		$regimenemisorlabel="CONSOLIDACIÓN";
	}
	if ($regimenEmisor=="610"){
		$regimenemisorlabel="RESIDENTES EN EL EXTRANJERO SIN ESTABLECIMIENTO PERMANENTE EN MÉXICO";
	}
	if ($regimenEmisor=="611"){
		$regimenemisorlabel="INGRESOS POR DIVIDENDOS (SOCIOS Y ACCIONISTAS)";
	}
	if ($regimenEmisor=="612"){
		$regimenemisorlabel="PERSONAS FÍSICAS CON ACTIVIDADES EMPRESARIALES Y PROFESIONALES";
	}
	if ($regimenEmisor=="614"){
		$regimenemisorlabel="INGRESOS POR INTERESES";
	}
	if ($regimenEmisor=="616"){
		$regimenemisorlabel="SIN OBLIGACIONES FISCALES";
	}
	if ($regimenEmisor=="620"){
		$regimenemisorlabel="SOCIEDADES COOPERATIVAS DE PRODUCCIÓN QUE OPTAN POR DIFERIR SUS INGRESOS";
	}
	if ($regimenEmisor=="621"){
		$regimenemisorlabel="INCORPORACIÓN FISCAL";
	}
	if ($regimenEmisor=="622"){
		$regimenemisorlabel="ACTIVIDADES AGRÍCOLAS, GANADERAS, SILVÍCOLAS Y PESQUERAS";
	}
	if ($regimenEmisor=="623"){
		$regimenemisorlabel="OPCIONAL PARA GRUPOS DE SOCIEDADES";
	}
	if ($regimenEmisor=="624"){
		$regimenemisorlabel="COORDINADOS";
	}
	if ($regimenEmisor=="628"){
		$regimenemisorlabel="HIDROCARBUROS";
	}
	if ($regimenEmisor=="607"){
		$regimenemisorlabel="RÉGIMEN DE ENAJENACIÓN O ADQUISICIÓN DE BIENES";
	}
	if ($regimenEmisor=="629"){
		$regimenemisorlabel="DE LOS REGÍMENES FISCALES PREFERENTES Y DE LAS EMPRESAS MULTINACIONALES";
	}
	if ($regimenEmisor=="630"){
		$regimenemisorlabel="ENAJENACIÓN DE ACCIONES EN BOLSA DE VALORES";
	}
	if ($regimenEmisor=="615"){
		$regimenemisorlabel="RÉGIMEN DE LOS INGRESOS POR OBTENCIÓN DE PREMIOS";
	}

	
	
	
	// CATALOGOS USO DEL CFDI
	if ($uso=="G01"){
   		$labeluso="ADQUISICIÓN DE MERCANCIAS";
	}
    if ($uso=="G02"){
		$labeluso="DEVOLUCIONES, DESCUENTOS O BONIFICACIONES";
	}
    if ($uso=="G03"){
		$labeluso="GASTOS EN GENERAL";
	}
    if ($uso=="I01"){
		$labeluso="CONSTRUCCIONES";
	}
	if ($uso=="I02"){
		$labeluso="MOBILIARIO Y EQUIPO DE OFICINA POR INVERSIONES";
	}
    if ($uso=="I03"){
		$labeluso="EQUIPO DE TRANSPORTE";
	}
    if ($uso=="I04"){
		$labeluso="EQUIPO DE COMPUTO Y ACCESORIOS";
	}
    if ($uso=="I05"){
		$labeluso="DATOS, TROQUELES, MOLDES, MATRICES Y HERRAMIENTAS";
	}
    if ($uso=="I06"){
		$labeluso="COMUNICACIONES TELEFONICAS";
	}
    if ($uso=="I07"){
		$labeluso="COMUNICACIONES SATELITALES";
	}
    if ($uso=="I08"){
		$labeluso="OTRA MAQUINARIA Y EQUIPO";
	}
    if ($uso=="D01"){
		$labeluso="HONORARIOS MEDICOS, DENTALES Y GASTOS HOSPITALARIOS";
	}
    if ($uso=="D02"){
		$labeluso="GASTOS MEDICOS POR INCAPACIDAD O DISCAPACIDAD";
	}
    if ($uso=="D03"){
		$labeluso="GASTOS FUNERALES";
	}
    if ($uso=="D04"){
		$labeluso="DONATIVOS";
	}
    if ($uso=="D05"){
		$labeluso="INTERESES REALES EFECTIVAMENTE PAGADOS POR CREDITOS HIPOTECARIOS";
	}
    if ($uso=="D06"){
		$labeluso="APORTACIONES VOLUNTARIAS AL SAR";
	}
    if ($uso=="D07"){
		$labeluso="PRIMAS POR SEGUROS DE GASTOS MEDICOS";
	}
    if ($uso=="D08"){
		$labeluso="GASTOS DE TRANSPORTACION ESCOLAR OBLIGATORIA";
	}
    if ($uso=="D09"){
		$labeluso="DEPOSITOS EN CUENTAS PARA EL AHORRO, PRIMAS DE PENSIONES";
	}
    if ($uso=="P01"){
		$labeluso="POR DEFINIR";
	}
	
	// CATALOGOS TIPO DE COMPROBANTE
	if ($tipocomprobante=="I"){
   		$labeltipocomprobante="INGRESO";
	}
    if ($tipocomprobante=="E"){
		$labeltipocomprobante="EGRESO";
	}
	if ($tipocomprobante=="P"){
		$labeltipocomprobante="PAGO";
	}
	if ($tipocomprobante=="T"){
		$labeltipocomprobante="TRASLADO";
	}
	if ($tipocomprobante=="N"){
		$labeltipocomprobante="NOMINA";
	}
	
	?>
	<table width="720" border="0" style="margin-left:10px;">
  		<tr height="60">
    		<td width="720">&nbsp;</td>
  		</tr>
  	</table>
	<table width="800" border="0">
      <tr valign="top">
        <td width="150"><img src="<?php 
											if ( $logo=="" ){?>
                                            	../../../dist/img/logo150.jpg
											<?php }else{?> 
												../../empresa/archivosSubidos/empresa/<?php echo $logo; ?>
											<?php } ?> " width="150" height="150"></td>
        <td width="10"></td>
        <td width="300">
            <table width="300" border="0">
              <tr>
                <td style="font-size:18px; font-weight:bold; color:<?php echo $color; ?>;" width="300"><?php echo strtoupper(html_entity_decode($razonsocialEmisor)); ?></td>
              </tr>
              <tr>
                <td style="font-size:16px;" width="300"><?php echo strtoupper(html_entity_decode($rfcEmisor)); ?></td>
              </tr>
              <tr>
                <td style="font-size:12px;" width="300">&nbsp;</td>
              </tr>
              <tr>
                <td style="font-size:12px;" width="300">RÉGIMEN FISCAL: <?php echo $regimenemisorlabel." (".$regimenEmisor.")"; ?></td>
              </tr>
              <tr>
                <td style="font-size:12px;" width="300">Email de contacto: <?php echo $emailEmisor ?></td>
              </tr>
            </table>
    
        </td>
        <td width="10"></td>
        <td width="220">
            <table width="220" border="0" style="border-collapse:collapse; border:solid; border-color:#CCC; border-width:1px">
                  <tr>
                    <td width="227" align="center" style="background:<?php echo $color; ?>; color:#FFF; font-size:10px;">Tipo de comprobante: <?php echo $labeltipocomprobante." (".$tipocomprobante.")"; ?></td>
                  </tr>
            </table>
            <table width="220" border="0" style="border-collapse:collapse; border:solid; border-color:#CCC; border-width:1px">
                  <tr>
                    <td width="227" align="center" style="background:<?php echo $color; ?>; color:#FFF; font-size:10px;">Folio Fiscal</td>
                  </tr>
                  <tr>
                    <td width="227" align="center" style="background:#EBEBEB; font-size:9px;">
                            <?php echo $tim_uuid;  ?>
                    </td>
                  </tr>
            </table>
            <table class="datoschicos" width="220" border="0" style="border-collapse:collapse; border:solid; border-color:#CCC; border-width:1px;">
                  <tr>
                    <td style="font-size:9px;" width="100">Folio de control:</td>
                    <td style="font-size:9px;" width="120"><?php echo $foliointerno; ?></td>
                  </tr>
                  <tr>
                    <td style="font-size:9px;">Fecha de emisión</td>
                    <td style="font-size:9px;"><?php echo $fecha_fact ?></td>
                  </tr>
                  <tr>
                    <td style="font-size:9px;">Fecha de certificacion</td>
                    <td style="font-size:9px;"><?php echo $tim_fecha ?></td>
                  </tr>
                  <tr>
                    <td style="font-size:9px;">Serie del certificado Sat</td>
                    <td style="font-size:9px;"><?php echo $cert_SAT  ?></td>
                  </tr>
                  <tr>
                    <td style="font-size:9px;">Serie del certificado</td>
                    <td style="font-size:9px;"><?php echo $noCertificado; ?></td>
                  </tr>
            </table>
        </td>
      </tr>
</table>

<?php //echo html_entity_decode($agregado); ?>

<table width="720" border="0" style="margin-left:10px;">
  <tr height="20">
    <td width="720"></td>
  </tr>
  <tr>
    <td width="720" style="font-size:14px; font-weight:bold;">Datos del cliente</td>
  </tr>
  <tr height="10">
    <td width="720"></td>
  </tr>
  <tr>
    <td width="720" style="font-size:14px;"><?php echo strtoupper(html_entity_decode($razonsocialReceptor)); ?></td>
  </tr>
  <tr>
    <td width="720" style="font-size:14px; color:#000;"><?php echo strtoupper(html_entity_decode($rfcReceptor)); ?></td>
  </tr>
  <tr>
    <td width="720" style="font-size:12px; color:#000;">USO DEL CFDI: <?php echo $labeluso." (".$uso.")"; ?></td>
  </tr>
  <?php if($rfcReceptor=="XEXX010101000"){?>
  <tr>
    <td width="720" style="font-size:12px; color:#000;">RECIDENCIA FISCAL: <?php echo $paisReceptor; ?></td>
  </tr>
  <tr>
    <td width="720" style="font-size:12px; color:#000;">NUMERO REGISTRO DE IDENTIFICACION (TAX ID): <?php echo $numeroExtranjero; ?></td>
  </tr>
  <?php }?>
</table>

<table width="720" border="0" style="margin-left:10px;">
  <tr height="15">
    <td width="720">&nbsp;</td>
  </tr>
</table>

<table width="720" border="0" style="margin-left:10px;">
  <tr>
    <td width="720" style="font-size:14px; font-weight:bold;">Conceptos</td>
  </tr>
</table>

<table width="720" border="0" style="margin-left:10px; border-spacing:0px;" cellspacing="0">
  <tr valign="middle">
  	<td height="25" width="10" align="center" bgcolor="#FF0000"></td>
    <td height="25" width="100" align="center" style="font-size:14px; background:#F0F0F0;">Clave</td>
    <td height="25" width="140" align="center" style="font-size:14px; background:#F0F0F0;">Descripción</td>
    <td height="25" width="110" align="center" style="font-size:14px; background:#F0F0F0;">Cantidad</td>
    <td height="25" width="110" align="center" style="font-size:14px; background:#F0F0F0;">Unidad</td>
    <td height="25" width="110" align="center" style="font-size:14px; background:#F0F0F0;">Precio</td>
    <td height="25" width="110" align="center" style="font-size:14px; background:#F0F0F0;">Importe</td>
  </tr>
  <tr>
  	<td height="5" colspan="7"></td>
  </tr>
    	
  <tr>
	<td height="25" width="10" align="center" bgcolor="#FF0000"></td>
	<td height="15" width="100" align="center" style="font-size:10px;">84111506</td>
	<td height="15" width="140" align="center" style="font-size:10px;">Pago</td>
	<td height="15" width="110" align="center" style="font-size:10px;">1</td>
	<td height="15" width="110" align="center" style="font-size:10px;">ACT</td>
	<td height="15" width="110" align="center" style="font-size:12px;">0</td>
	<td height="15" width="110" align="center" style="font-size:12px;">0</td>
   </tr>

</table>


<table width="720" border="0" style="margin-left:10px;">
  <tr height="15">
    <td width="720">&nbsp;</td>
  </tr>
</table>

<table width="720" border="0" style="margin-left:10px;">
  <tr>
    <td width="720" style="font-size:14px; font-weight:bold;">Documentos relacionados (Facturas pagadas)</td>
  </tr>
</table>

<table width="720" border="0" style="margin-left:10px; border-spacing:0px;" cellspacing="0">
  <tr valign="middle">
  	<td height="25" width="10" align="center" bgcolor="#FF0000"></td>
    <td height="25" width="90" align="center" style="font-size:14px; background:#F0F0F0;">Folio</td>
    <td height="25" width="90" align="center" style="font-size:14px; background:#F0F0F0;">Moneda</td>
    <td height="25" width="100" align="center" style="font-size:14px; background:#F0F0F0;">Metodo Pago</td>
    <td height="25" width="100" align="center" style="font-size:14px; background:#F0F0F0;">Parcialidad</td>
    <td height="25" width="100" align="center" style="font-size:14px; background:#F0F0F0;">Saldo Anterior</td>
    <td height="25" width="100" align="center" style="font-size:14px; background:#F0F0F0;">Monto</td>
    <td height="25" width="100" align="center" style="font-size:14px; background:#F0F0F0;">Saldo Insoluto</td>
  </tr>
  <tr>
  	<td height="5" colspan="8"></td>
  </tr>
	
    <?php
	$arregloUUID=descomponerArreglo(9,0,$lista);
	$arregloFolio=descomponerArreglo(9,1,$lista);
	$arregloMoneda=descomponerArreglo(9,2,$lista);
	$arregloTipoCambio=descomponerArreglo(9,3,$lista);
	$arregloMetodoPago=descomponerArreglo(9,4,$lista);
	$arregloNumParcialidad=descomponerArreglo(9,5,$lista);
	$arregloSaldoAnterior=descomponerArreglo(9,6,$lista);
	$arregloImportePagado=descomponerArreglo(9,7,$lista);
	$arregloSaldoInsoluto=descomponerArreglo(9,8,$lista);
	
	foreach ($arregloUUID as $clave => $valor) {
	?>
    	
        
        <tr>
            <td height="25" width="10" align="center" bgcolor="#FF0000"></td>
            <td height="15" width="90" align="center" style="font-size:10px;"><?php echo $arregloFolio[$clave]; ?></td>
            <td height="15" width="90" align="center" style="font-size:10px;"><?php echo $arregloMoneda[$clave]." (".$arregloTipoCambio[$clave].")"; ?></td>
            <td height="15" width="100" align="center" style="font-size:10px;"><?php echo $arregloMetodoPago[$clave]; ?></td>
            <td height="15" width="100" align="center" style="font-size:10px;"><?php echo $arregloNumParcialidad[$clave]; ?></td>
            <td height="15" width="100" align="center" style="font-size:12px;"><?php echo number_format($arregloSaldoAnterior[$clave],2,'.',''); ?></td>
            <td height="15" width="100" align="center" style="font-size:12px;"><?php echo number_format($arregloImportePagado[$clave],2,'.',''); ?></td>
            <td height="15" width="100" align="center" style="font-size:12px;"><?php echo number_format($arregloSaldoInsoluto[$clave],2,'.',''); ?></td>
        </tr>
        <tr bgcolor="#F4F4F4" valign="middle">
            <td width="10" align="center" bgcolor="#FF0000" colspan="1"></td>
            <td width="100" align="center" style="font-size:14px; font-weight:bold" colspan="7" valign="middle"><?php echo $arregloUUID[$clave];?></td>
        </tr>
        
        
        <tr>
            <td height="5" colspan="8"></td>
        </tr>
        
        
		
	<?php } // Fin for?>

</table>


<div style="width:720px; height:10px; border-bottom:solid; border-bottom-color:#CCC; margin-left:10px;"></div>
<table width="720" border="0" style="margin-left:10px;">
  <tr valign="top">
    <td width="390">
    	<table width="370" border="0">
        	
          <?php if ($observaciones!=""){ ?>
          <tr style="color:#517488">
            <td width="110" style="font-size:10px; font-weight:bold;">Observaciones:</td>
            <td width="250" style="font-size:10px;"><?php echo $observaciones ?></td>
          </tr>
          <?php } ?>
          
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Lugar de expedición:</td>
            <td width="250" style="font-size:10px;"><?php echo $LugarExpedicion ?></td>
          </tr>
          
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Importe con letra:</td>
            <td width="250" style="font-size:10px;"><?php 
				echo strtoupper(num2letras($total, false, true, $moneda));
				 ?>
			</td>
          </tr>
          
          <tr>
            <td width="150" style="font-size:10px; font-weight:bold;">Versión de complemento:</td>
            <td width="210" style="font-size:10px;">1.0</td>
          </tr>
          
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Fecha del pago:</td>
            <td width="250" style="font-size:10px;"><span style=" font-weight:bold; color:#C00"><?php echo $fecha."T".date("H:i:s"); ?></span></td>
          </tr>
          
          <?php if ($moneda!="MXN"){ ?>
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Tipo de cambio:</td>
            <td width="250" style="font-size:10px;">$<?php echo $tipocambio ?> M.N.</td>
          </tr>
          <?php } ?>
          
          <?php if ($numoperacion!=""){ ?>
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">No. de operación:</td>
            <td width="250" style="font-size:10px;"><?php echo $numoperacion ?></td>
          </tr>
          <?php } ?>
          
          <?php if ($rfcemisorordenante!=""){ ?>
          <tr>
            <td width="150" style="font-size:10px; font-weight:bold;">RFC Emisor Ordenante:</td>
            <td width="210" style="font-size:10px;"><?php echo $rfcemisorordenante ?></td>
          </tr>
          <?php } ?>
          
          <?php if ($cuentaordenante!=""){ ?>
          <tr>
            <td width="150" style="font-size:10px; font-weight:bold;">Cuenta Ordenante:</td>
            <td width="210" style="font-size:10px;"><?php echo $cuentaordenante ?></td>
          </tr>
          <?php } ?>
          
           <?php if ($bancoordenante!=""){ ?>
          <tr>
            <td width="150" style="font-size:10px; font-weight:bold;">Banco Ordenante:</td>
            <td width="210" style="font-size:10px;"><?php echo $bancoordenante ?></td>
          </tr>
          <?php } ?>
          
          <?php if ($rfcemisorbeneficiario!=""){ ?>
          <tr>
            <td width="150" style="font-size:10px; font-weight:bold;">RFC Emisor Ordenante:</td>
            <td width="210" style="font-size:10px;"><?php echo $rfcemisorbeneficiario; ?></td>
          </tr>
          <?php } ?>
          
          <?php if ($cuentabeneficiario!=""){ ?>
          <tr>
            <td width="150" style="font-size:10px; font-weight:bold;">Cuenta Ordenante:</td>
            <td width="210" style="font-size:10px;"><?php echo $cuentabeneficiario ?></td>
          </tr>
          <?php } ?>
          
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Forma de pago:</td>
            <td width="250" style="font-size:10px;">
			<?php
            echo $formapagolabel." (".$formapago.")";
			if ($formapago=='03' && $tipocadena!=""){
				echo " con SPEI";
			}
			?>
            </td>
          </tr>
          
          <?php if ($certificadopago!=""){ ?>
          <tr>
            <td width="150" style="font-size:10px; font-weight:bold;">Certificado de pago:</td>
            <td width="210" style="font-size:10px;"><?php echo $certificadopago ?></td>
          </tr>
          <?php } ?>
          
          
          <?php if ($tiporelacion != ""){ ?>
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Tipo de relación:</td>
            <td width="250" style="font-size:10px;"><?php echo $tiporelacion ?></td>
          </tr>
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">DOCUMENTOS RELACIONADOS:</td>
            <td width="250" style="font-size:10px;"><?php echo  $comprobantesRelacionados ?></td>
          </tr>
          <?php } ?>
         
        </table>

    </td>
    <td width="330">
    	<table width="350" border="0">
          
          <tr>
            <td width="150" style="font-size:15px;" align="right">TOTAL PAGADO:</td>
            <td width="150" style="font-size:15px;" align="right">
				<?php echo "$".number_format($total, 2, '.', ',');?>
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<div style="width:720px; height:10px; border-bottom:solid; border-bottom-color:#CCC; margin-left:10px;"></div>


<table width="720" border="0" style="margin-left:10px;">
  <tr valign="top">
    <td width="180">
    
    <?php 
	//QRcode::png($Cadena, 'test.png', 'H', 3, 2); 
	echo '<img src="'.$filename.'" width="150" height="150">';
	?>
    </td>
    <td width="350">
    	<table bordercolor="#CCCCCC" width="525" border="1" style="border-collapse:collapse;">
              <tr valign="middle">
                <td height="20" width="525" style="font-size:12px;" align="center">Este documento es una representación impresa de un CFDI V3.3</td>
              </tr>
        </table>
        
        
        <?php if ($cadenapago!=""){ ?>
        <table width="525" border="0">
              <tr>
                <td width="525" style="font-size:9px; color:<?php echo $color; ?>;" align="left">Cadena original del pago</td>
              </tr>
        </table>
        <table bordercolor="#CCCCCC" width="525" border="1" style="border-collapse:collapse;">
              <tr>
                <td width="525" style="font-size:8px; font-weight:lighter;" align="left">
                	<?php 
					$cadena=str_replace("&#124;","|",$cadenapago);
					$i=0;
					$caracteres=110;
					while($i < strlen($cadena)){
						if($i%$caracteres==0){
							echo ' ';
						}
						echo $cadena[$i];
						$i++;
					}
					?>
                </td>
              </tr>
        </table>
        <?php }?>
        
        <?php if ($sellopago!=""){ ?>
        <table width="525" border="0">
              <tr>
                <td width="525" style="font-size:9px; color:<?php echo $color; ?>;" align="left">Sello del pago</td>
              </tr>
        </table>
        <table bordercolor="#CCCCCC" width="525" border="1" style="border-collapse:collapse;">
              <tr>
                <td width="525" style="font-size:8px; font-weight:lighter;" align="left">
                	<?php 
					$cadena=$sellopago;
					$i=0;
					$caracteres=110;
					while($i < strlen($cadena)){
						if($i%$caracteres==0){
							echo ' ';
						}
						echo $cadena[$i];
						$i++;
					}
					?>
                </td>
              </tr>
        </table>
        <?php }?>
        
        
        <table width="525" border="0">
              <tr>
                <td width="525" style="font-size:9px; color:<?php echo $color; ?>;" align="left">Cadena original del complemento de certificación digital del SAT</td>
              </tr>
        </table>
        <table bordercolor="#CCCCCC" width="525" border="1" style="border-collapse:collapse;">
              <tr>
                <td width="525" style="font-size:8px; font-weight:lighter;" align="left">
                	<?php 
					$cadena = "||".$tim_uuid."|".$tim_fecha."|".$sello_CFD."|".$cert_SAT."||";
					$i=0;
					$caracteres=110;
					while($i < strlen($cadena)){
						if($i%$caracteres==0){
							echo ' ';
						}
						echo $cadena[$i];
						$i++;
					}
					?>
                </td>
              </tr>
        </table>
        
        
        <table width="525" border="0">
              <tr>
                <td width="525" style="font-size:9px; color:<?php echo $color; ?>;" align="left">Sello digital del CFDI</td>
              </tr>
        </table>
        <table bordercolor="#CCCCCC" width="525" border="1" style="border-collapse:collapse;">
              <tr>
                <td width="525" style="font-size:8px; font-weight:lighter;" align="left">
                	<?php 
					$cadena=$sello_CFD;
					$i=0;
					$caracteres=110;
					while($i < strlen($cadena)){
						if($i%$caracteres==0){
							echo ' ';
						}
						echo $cadena[$i];
						$i++;
					}
					?>
                </td>
              </tr>
        </table>
        
        
        <table width="525" border="0">
              <tr>
                <td width="525" style="font-size:9px; color:<?php echo $color; ?>;" align="left">Sello digital SAT</td>
              </tr>
        </table>
        <table bordercolor="#CCCCCC" width="525" border="1" style="border-collapse:collapse;">
              <tr>
                <td width="525" style="font-size:8px; font-weight:lighter;" align="left">
                	<?php 
					$cadena=$sello_SAT;
					$i=0;
					$caracteres=110;
					while($i < strlen($cadena)){
						if($i%$caracteres==0){
							echo ' ';
						}
						echo $cadena[$i];
						$i++;
					}
					?>
                </td>
              </tr>
        </table>
        
        
    </td>
  </tr>
</table>


</page>