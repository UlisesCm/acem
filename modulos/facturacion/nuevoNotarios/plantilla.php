<page style="width:800px; height:auto; font-family:Arial;font-size:14px; color:#000;">
	<?php
////////////////////////////////////////////////////// COMPLEMENTO NOTARIOS PUBLICOS*********************************	
function dameTipo($tipo){
	if ($tipo==01){$tipo="Terreno";}
	if ($tipo==02){$tipo="Terreno uso comercial";}
	if ($tipo==03){$tipo="Construcción habitacional";}
	if ($tipo==04){$tipo="Construcción uso comercial";}
	if ($tipo==05){$tipo="Uso mixto";}
	return $tipo;
}

function dameEstado($estado){
	if ($estado==01){$estado="AGUASCALIENTES";}
	if ($estado==02){$estado="BAJA CALIFORNIA NORTE";}
	if ($estado==03){$estado="BAJA CALIFORNIA SUR";}
	if ($estado==04){$estado="CAMPECHE";}
	if ($estado==05){$estado="COAHUILA";}
	if ($estado==06){$estado="COLIMA";}
	if ($estado==07){$estado="CHIAPAS";}
	if ($estado==08){$estado="CHIHUAHUA";}
	if ($estado==09){$estado="DISTRITO FEDERAL";}
	if ($estado==10){$estado="DURANGO";}
	if ($estado==11){$estado="GUANAJUATO";}
	if ($estado==12){$estado="GUERRERO";}
	if ($estado==13){$estado="HIDALGO";}
	if ($estado==14){$estado="JALISCO";}
	if ($estado==15){$estado="MEXICO";}
	if ($estado==16){$estado="MICHOACAN";}
	if ($estado==17){$estado="MORELOS";}
	if ($estado==18){$estado="NAYARIT";}
	if ($estado==19){$estado="NUEVO LEON";}
	if ($estado==20){$estado=="OAXACA";}
	if ($estado==21){$estado=="PUEBLA";}
	if ($estado==22){$estado=="QUERETARO";}
	if ($estado==23){$estado=="QUINTANA ROO";}
	if ($estado==24){$estado=="SAN LUIS POTOSI";}
	if ($estado==25){$estado=="SINALOA";}
	if ($estado==26){$estado=="SONORA";}
	if ($estado==27){$estado=="TABASCO";}
	if ($estado==28){$estado=="TAMAULIPAS";}
	if ($estado==29){$estado=="TLAXCALA";}
	if ($estado==30){$estado=="VERACRUZ";}
	if ($estado==31){$estado=="YUCATAN";}
	if ($estado==32){$estado=="ZACATECAS";}
	
	return $estado;
}
////////////////////////////////////////////////////// FIN COMPLEMENTO NOTARIOS PUBLICOS*********************************	

    $color="#000";
	
	// CATALOGO FORMA DE PAGO
			
	if ($formapago=="01"){
		$formapagolabel="EFECTIVO";
	}
	if ($formapago=="02"){
		$formapagolabel="CHEQUE NOMINATIVO";
	}
	if ($formapago=="03"){
		$formapagolabel="TRANSFERENCIA ELECTRÓNICA DE FONDOS";
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
    <td width="720" style="font-size:14px; color:#000;"><?php echo strtoupper(html_entity_decode($rfcReceptor)); ?> | USO DEL CFDI: <?php echo $labeluso." (".$uso.")"; ?></td>
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
    <td height="25" width="90" align="center" style="font-size:14px; background:#F0F0F0;">Clave</td>
    <td height="25" width="100" align="center" style="font-size:14px; background:#F0F0F0;">ID</td>
    <td height="25" width="90" align="center" style="font-size:14px; background:#F0F0F0;">Cantidad</td>
    <td height="25" width="100" align="center" style="font-size:14px; background:#F0F0F0;">Unidad</td>
    <td height="25" width="100" align="center" style="font-size:14px; background:#F0F0F0;">Precio</td>
    <td height="25" width="100" align="center" style="font-size:14px; background:#F0F0F0;">Descuento</td>
    <td height="25" width="100" align="center" style="font-size:14px; background:#F0F0F0;">Importe</td>
  </tr>
  <tr>
  	<td height="5" colspan="8"></td>
  </tr>
	
    <?php
		for ($i=0; $i<count($Array_Cantidad); $i++){
			
		$claveProducto=$Array_ClaveProdServ[$i];
        $NoIdentificacion=$Array_NoIdentificacion[$i];
        $Cantidad=$Array_Cantidad[$i];
        $ClaveUnidad=$Array_ClaveUnidad[$i];
        $Unidad=$Array_Unidad[$i];
        $Descripcion=$Array_Descripcion[$i];
        $ValorUnitario=number_format($Array_ValorUnitario[$i],6,'.','');
        $Importe=number_format($Array_Importe[$i],2,'.','');
        $Descuento=number_format($Array_Descuento[$i]*$Array_Cantidad[$i],2,'.','');
		$Impuestos=$Array_Impuestos_Label[$i];
	?>
    	
        <tr >
            <td height="25" width="10" align="center" bgcolor="#FF0000"></td>
            <td height="15" width="90" align="center" style="font-size:10px;"><?php echo $claveProducto; ?></td>
            <td height="15" width="100" align="center" style="font-size:10px;"><?php echo $NoIdentificacion; ?></td>
            <td height="15" width="90" align="center" style="font-size:10px;"><?php echo $Cantidad; ?></td>
            <td height="15" width="100" align="center" style="font-size:10px;"><?php echo $Unidad; ?></td>
            <td height="15" width="100" align="center" style="font-size:12px;"><?php echo $ValorUnitario; ?></td>
            <td height="15" width="100" align="center" style="font-size:12px;"><?php echo $Descuento; ?></td>
            <td height="15" width="100" align="center" style="font-size:12px;"><?php echo $Importe; ?></td>
        </tr>
          
        <tr bgcolor="#F4F4F4" valign="middle">
            <td width="10" align="center" bgcolor="#FF0000"></td>
            <td width="100" align="center" style="font-size:12px;" colspan="1" valign="middle">DESCRIPCION:</td>
            <td width="100" align="left" style="font-size:12px;" colspan="3" valign="middle"><?php echo $Descripcion; ?></td>
            <td width="100" align="center" style="font-size:12px;" colspan="1" valign="middle">IMPUESTOS:</td>
            <td width="100" align="left" style="font-size:8px; font-style:italic; vertical-align:middle" colspan="2" valign="middle"><?php echo $Impuestos?></td>
        </tr>
        <tr>
            <td height="5" colspan="8"></td>
        </tr>
        
        
		
	<?php } // Fin for?>

</table>
<div style="width:720px; height:10px; border-bottom:solid; border-bottom-color:#CCC; margin-left:10px;"></div>
<table width="720" border="0" style="margin-left:10px;">
  <tr valign="top">
    <td width="370">
    	<table width="370" border="0">
          <?php if ($observaciones!=""){ ?>
          <tr style="color:#517488">
            <td width="110" style="font-size:10px; font-weight:bold;">Observaciones:</td>
            <td width="250" style="font-size:10px;"><?php echo $observaciones ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Importe con letra:</td>
            <td width="250" style="font-size:10px;"><?php 
				echo strtoupper(num2letras($total, false, true, $moneda));
				 ?>
			</td>
          </tr>
          <?php if ($moneda!="MXN"){ ?>
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Tipo de cambio:</td>
            <td width="250" style="font-size:10px;">$<?php echo $tipocambio ?> M.N.</td>
          </tr>
          <?php } ?>
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Método de pago:</td>
            <td width="250" style="font-size:10px;"><?php echo $metodopago; ?></td>
          </tr>
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Forma de pago:</td>
            <td width="250" style="font-size:10px;"><?php echo $formapagolabel." (".$formapago.")"; ?>
            </td>
          </tr>
          
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Lugar de expedición:</td>
            <td width="250" style="font-size:10px;"><?php echo $LugarExpedicion ?></td>
          </tr>
          <?php if ($condicionesDePago != ""){ ?>
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Condiciones de pago:</td>
            <td width="250" style="font-size:10px;"><?php echo $condicionesDePago ?></td>
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
    <td width="350">
    	<table width="350" border="0">
          <tr>
            <td bordercolor="#FFFFFF" width="150" style="font-size:15px;" align="right">SUBTOTAL</td>
            <td width="150" style="font-size:15px;" align="right">
            	<?php echo "$".number_format($subTotal, 2, '.', ',');?>
            </td>
          </tr>
          <?php if ($descuento!=0){ ?>
          <tr>
            <td width="150" style="font-size:15px;" align="right">DESCUENTO</td>
            <td width="150" style="font-size:15px;" align="right">
            	<?php echo "$".number_format($descuento, 2, '.', ',');?>
            </td>
          </tr>
          <?php } ?>
          
          
    
          <tr>
            <td width="150" style="font-size:15px;" align="right">IVA TRASLADADO</td>
            <td width="150" style="font-size:15px;" align="right">
            	<?php echo "$".number_format($ivatrasladado, 2, '.', ',');?>
            </td>
          </tr>
          <?php if ($ivaretenido!=0){ ?>
          <tr>
            <td width="150" style="font-size:15px;" align="right">IVA RETENIDO</td>
            <td width="150" style="font-size:15px;" align="right">
            	<?php echo "$".number_format($ivaretenido, 2, '.', ',');?>
            </td>
          </tr>
          <?php }
			  	if ($isrretenido!=0){ ?>
          <tr>
            <td width="150" style="font-size:15px;" align="right">ISR RETENIDO</td>
            <td width="150" style="font-size:15px;" align="right">
            	<?php echo "$".number_format($isrretenido, 2, '.', ',');?>
			</td>
          </tr>
          <?php }  ?>
		 <?php if ($impuestocedular!=0){ ?>
          <tr>
            <td width="150" style="font-size:15px;" align="right">RET. CEDULAR (<?php echo $tasaimpuestocedular; ?>%)</td>
            <td width="150" style="font-size:15px;" align="right">
            	<?php echo "$".number_format($impuestocedular, 2, '.', ',');?>
			</td>
          </tr>
          <?php }  
		 
				if ($ish!=0){ ?>
          <tr>
            <td width="150" style="font-size:15px;" align="right">ISH (<?php echo $tasaish ?>%)</td>
            <td width="150" style="font-size:15px;" align="right">
            	<?php echo "$".number_format($ish, 2, '.', ',');?>
			</td>
          </tr>
          <?php } ?>          
          <tr>
            <td width="150" style="font-size:15px;" align="right">TOTAL</td>
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


<?php ///////////////////////// COMPLEMENTO NOTARIOS PUBLICOS **********************************************************************************************?>
<div style="width:720px; height:10px; border-bottom:solid; border-bottom-color:#CCC; margin-left:10px;"></div>

<table width="720" border="0" style="margin-left:10px;">
  <tr>
    <td width="720" style="font-size:18px; font-weight:bold;" align="center">COMPLEMENTOS (NOTARIOS PÚBLICOS)</td>
  </tr>
</table>

<div style="width:720px; height:10px; border-bottom:solid; border-bottom-color:#CCC; margin-left:10px;"></div>



<table width="720" border="0" style="margin-left:10px;">
  <tr valign="top">
    <td width="370">
    	<table width="370" border="0">
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Número de Escritura:</td>
            <td width="250" style="font-size:10px;">
				<?php echo $NumInstrumentoNotarial;?>
			</td>
          </tr>
          
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Fecha de Firma:</td>
            <td width="250" style="font-size:10px;">
				<?php  
				$fechaNfecha2=date_create($FechaInstNotarial);
				$nuevaFecha2= date_format($fechaNfecha2, 'd/m/Y');
				echo $nuevaFecha2;
				?>
            </td>
          </tr>
          
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Monto de Operación:</td>
            <td width="250" style="font-size:10px;">
				<?php echo "$".number_format($MontoOperacion, 2, '.', ',');?>
            </td>
          </tr>
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Subtotal:</td>
            <td width="250" style="font-size:10px;">
				<?php echo "$".number_format($SubtotalNotario, 2, '.', ','); ?>
            </td>
          </tr>
          
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">IVA:</td>
            <td width="250" style="font-size:10px;">
				<?php echo "$".number_format($ivaNotario, 2, '.', ','); ?>
            </td>
          </tr>
          
          
        </table>

    </td>
    
    

    <td width="350">
    	<table width="350" border="0">
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">CURP del Notario:</td>
            <td width="250" style="font-size:10px;">
				<?php echo $curpnotario;?>
			</td>
          </tr>
          
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Número de Notaría:</td>
            <td width="250" style="font-size:10px;">
				<?php echo $numeronotaria;?>
            </td>
          </tr>
          
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">No.de  Entidad Federativa:</td>
            <td width="250" style="font-size:10px;">
				<?php echo $entidadfederativa;?>
            </td>
          </tr>
          
          
          <?php if ($adscripcion=""){ ?>
          <tr>
            <td width="110" style="font-size:10px; font-weight:bold;">Adscripción: </td>
            <td width="250" style="font-size:10px;"><?php echo $adscripcion ?></td>
          </tr>
          <?php } ?>
        </table>

    </td>
    
  </tr>
</table>

<div style="width:720px; height:10px; border-bottom:solid; border-bottom-color:#CCC; margin-left:10px;"></div>

<table width="720" border="0" style="margin-left:10px;">
  <tr>
    <td width="720" style="font-size:14px; font-weight:bold;">Lista de Inmuebles</td>
  </tr>
</table>


<table width="720" border="0" style="margin-left:10px;">
  <tr valign="middle">
    <td height="30" width="140" align="center" style="font-size:14px; background:#F0F0F0;">Tipo</td>
    <td height="30" width="570" align="center" style="font-size:14px; background:#F0F0F0;">Domicilio</td>
  </tr>
	<?php
	$con=0;
	$valor=0;
	echo '<tr height="40">';
	foreach ($inmuebles as &$valor) {
		$con=$con+1;
		
		
		if ($con==1){
                       echo "<td height='15'  style='font-size:10px;'>".dameTipo($valor)."</td>";
                    }
					if ($con==2){
                        echo "<td height='15' style='font-size:10px;'>".$valor." ";
                    }
					if ($con==3){
						if ($valor!=""){
                        	echo "No. ".$valor.", ";
						}else{
							echo "S/N, ";
						}
                    }
					if ($con==4){
						if ($valor!=""){
                        	echo "Int. ".$valor.", ";
						}
                    }
					if ($con==5){
						if ($valor!=""){
                        	echo "Col. ".$valor.", ";
						}
                    }
					if ($con==6){
						if ($valor!=""){
                        	echo "Loc. ".$valor.", ";
						}
                    }
					if ($con==8){
						if ($valor!=""){
                        	echo "".$valor.", ";
						}
                    }
					if ($con==9){
						if ($valor!=""){
                        	echo "".dameEstado($valor).", ";
						}
                    }
					if ($con==10){
						if ($valor!=""){
                        	echo "".$valor.", ";
						}
                    }
					if ($con==11){
                        echo "C.P. ".$valor."</td></tr><tr>";
                        $con=0;
                    }
		
	}
	unset($valor); 
	echo "</tr>";
	?>
</table>



<div style="width:720px; height:10px; border-bottom:solid; border-bottom-color:#CCC; margin-left:10px;"></div>


<table width="720" border="0" style="margin-left:10px;">
  <tr>
    <td width="720" style="font-size:14px; font-weight:bold;">Lista de Enajentantes</td>
  </tr>
</table>

<table width="720" border="0" style="margin-left:10px;">
  <tr valign="middle">
    <td height="30" width="140" align="center" style="font-size:14px; background:#F0F0F0;">Nombre</td>
    <td height="30" width="130" align="center" style="font-size:14px; background:#F0F0F0;">Apellido Paterno</td>
    <td height="30" width="130" align="center" style="font-size:14px; background:#F0F0F0;">Apellido Materno</td>
    <td height="30" width="100" align="center" style="font-size:14px; background:#F0F0F0;">RFC</td>
    <td height="30" width="140" align="center" style="font-size:14px; background:#F0F0F0;">CURP</td>
    <td height="30" width="45" align="center" style="font-size:14px; background:#F0F0F0;">%</td>
  </tr>
	<?php
	$con=0;
	$valor=0;
	//$productos="2:::Bolso de mandado:::Pieza:::100:::200:::2:::Bolso de mandado rojo:::Pieza:::100:::200:::2:::Bolso de mandado:::Pieza:::100:::200:::2:::Bolso de mandado:::Pieza:::100:::200";
	//$productos=rtrim($productos,":::");
	//$productos=explode(":::",$productos);
	echo '<tr height="40">';
	foreach ($enajenantes as &$valor) {
		$con=$con+1;
		if ($con==6){
 			echo '<td height="15" style="font-size:10px;">'.$valor."</td></tr><tr>";
				$con=0;
		}else{
			echo '<td height="15" style="font-size:10px;">'.$valor."</td>";
		}
	}
	unset($valor); 
	echo "</tr>";
	?>
</table>



<div style="width:720px; height:10px; border-bottom:solid; border-bottom-color:#CCC; margin-left:10px;"></div>


<table width="720" border="0" style="margin-left:10px;">
  <tr>
    <td width="720" style="font-size:14px; font-weight:bold;">Lista de Adquirientes</td>
  </tr>
</table>

<table width="720" border="0" style="margin-left:10px;">
  <tr valign="middle">
    <td height="30" width="140" align="center" style="font-size:14px; background:#F0F0F0;">Nombre</td>
    <td height="30" width="130" align="center" style="font-size:14px; background:#F0F0F0;">Apellido Paterno</td>
    <td height="30" width="130" align="center" style="font-size:14px; background:#F0F0F0;">Apellido Materno</td>
    <td height="30" width="100" align="center" style="font-size:14px; background:#F0F0F0;">RFC</td>
    <td height="30" width="140" align="center" style="font-size:14px; background:#F0F0F0;">CURP</td>
    <td height="30" width="45" align="center" style="font-size:14px; background:#F0F0F0;">%</td>
  </tr>
	<?php
	$con=0;
	$valor=0;
	//$productos="2:::Bolso de mandado:::Pieza:::100:::200:::2:::Bolso de mandado rojo:::Pieza:::100:::200:::2:::Bolso de mandado:::Pieza:::100:::200:::2:::Bolso de mandado:::Pieza:::100:::200";
	//$productos=rtrim($productos,":::");
	//$productos=explode(":::",$productos);
	echo '<tr height="40">';
	foreach ($adquirientes as &$valor) {
		$con=$con+1;
		if ($con==6){
 			echo '<td height="15" style="font-size:10px;">'.$valor."</td></tr><tr>";
				$con=0;
		}else{
			echo '<td height="15" style="font-size:10px;">'.$valor."</td>";
		}
	}
	unset($valor); 
	echo "</tr>";
	?>
</table>
</page>