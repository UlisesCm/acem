<?php
header('Content-Type: text/html; charset=UTF-8');
include("qrlib/qrlib.php");
    
 ### 7. ARRAYS QUE CONTIENEN LOS IMPUESTOS TRASLADADOS Y RETENIDOS POR CONCEPTO #############

    // Trasladados.
    $ArrayTraslado_Base = ['2250000', '2400', '17000'];                 // 7.1 Atributo requerido para señalar la base para el cálculo del impuesto, la determinación de la base se realiza de acuerdo con las disposiciones fiscales vigentes. No se permiten valores negativos
    $ArrayTraslado_Impuesto = ['002', '002', '002'];                    // 7.2 Atributo requerido para señalar la clave del tipo de impuesto trasladado aplicable al concepto (consultar catálogos del SAT).
    $ArrayTraslado_TipoFactor = ['Tasa', 'Tasa', 'Tasa'];               // 7.3 Atributo requerido para señalar la clave del tipo de factor que se aplica a la base del impuesto (consultar catálogos del SAT).
    $ArrayTraslado_TasaOCuota = ['0.160000', '0.160000', '0.160000'];   // 7.4 Atributo condicional para señalar el valor de la tasa o cuota del impuesto que se traslada para el presente concepto. Es requerido cuando el atributo TipoFactor tenga una clave que corresponda a Tasa o Cuota (consultar catálogos del SAT).
    $ArrayTraslado_Importe = ['360000', '384', '2720'];                 // 7.5 Atributo condicional para señalar el importe del impuesto trasladado que aplica al concepto. No se permiten valores negativos. Es requerido cuando TipoFactor sea Tasa o Cuota

    // Retenidos.
    $ArrayRetencion_Base = ['225000', '2400', '17000'];                 // 7.6 Atributo requerido para señalar la base para el cálculo de la retención, la determinación de la base se realiza de acuerdo con las disposiciones fiscales vigentes. No se permiten valores negativos.
    $ArrayRetencion_Impuesto = ['002', '002', '002'];                   // 7.7 Atributo requerido para señalar la clave del tipo de impuesto retenido aplicable al concepto (consultar catálogos del SAT).
    $ArrayRetencion_TipoFactor = ['Tasa', 'Tasa', 'Tasa'];              // 7.8 Atributo requerido para señalar la clave del tipo de factor que se aplica a la base del impuesto (consultar catálogos del SAT).
    $ArrayRetencion_TasaOCuota = ['0.160000', '0.160000', '0.160000'];  // 7.9 Atributo requerido para señalar la tasa o cuota del impuesto que se retiene para el presente concepto (consultar catálogos del SAT).
    $ArrayRetencion_Importe = ['36000', '384', '2720'];                 // 7.10 Atributo requerido para señalar el importe del impuesto retenido que aplica al concepto. No se permiten valores negativos.
    
    
### 8 DETERMINANDO TOTALES ###################################################    
    
    // 8.1 Calculando subTotal.
    for ($i=0; $i<count($Array_Importe); $i++){
        
        $subTotal = $subTotal + $Array_Importe[$i];
    }
    
    $subTotal = number_format($subTotal,2,'.',''); 
    
    // 8.2 Total impuestos trasladados.
    for ($i=0; $i<count($ArrayTraslado_Importe); $i++){
        $totalImpuestosTrasladados = $totalImpuestosTrasladados + $ArrayTraslado_Importe[$i];
    }
    
    // 8.3 Total impuestos retenidos.
    for ($i=0; $i<count($ArrayRetencion_Importe); $i++){
        $totalImpuestosRetenidos = $totalImpuestosRetenidos + $ArrayRetencion_Importe[$i];
    }

    // 8.4 Calculando Total.
    $total = $subTotal - $descuento + $totalImpuestosTrasladados - $totalImpuestosRetenidos;
    


### 11. CREACIÓN Y ALMACENAMIENTO DEL ARCHIVO .XML (CFDI) ANTES DE SER TIMBRADO ###################
    
    #== 11.1 Creación de la variable de tipo DOM, aquí se conforma el XML a timbrar posteriormente.
    $xml = new DOMdocument('1.0', 'UTF-8'); 
    $root = $xml->createElement("cfdi:Comprobante");
    $root = $xml->appendChild($root); 
    
    $cadena_original='||';
    $noatt=  array();
    
    #== 11.2 Se crea e inserta el primer nodo donde se declaran los namespaces ======
    cargaAtt($root, array("xsi:schemaLocation"=>"http://www.sat.gob.mx/cfd/3",
            "xmlns:cfdi"=>"http://www.sat.gob.mx/cfd/3",
            "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance"
        )
    );
    
    #== 11.3 Rutina de integración de nodos =========================================
    cargaAtt($root, array(
             "Version"=>"3.3", 
             "Serie"=>$fact_serie,
             "Folio"=>$fact_folio,
             "Fecha"=>date("Y-m-d")."T".date("H:i:s"),
             "FormaPago"=>$formaDePago,
             "NoCertificado"=>$noCertificado,
             "CondicionesDePago"=>$condicionesDePago,
             "SubTotal"=>$subTotal,
             "Descuento"=>$descuento,
             "Moneda"=>$moneda,
             "TipoCambio"=>$TipoCambio,
             "Total"=>$total,
             "TipoDeComprobante"=>$fact_tipcompr,
             "MetodoPago"=>$metodoDePago,
             "LugarExpedicion"=>$LugarExpedicion
          )
       );

    
//    $emisor = $xml->createElement("cfdi:CfdiRelacionados");
//    $emisor = $root->appendChild($emisor);
//    cargaAtt($emisor, array("TipoRelacion"=>"01"));
//    
//    $CfdiRel = $xml->createElement("cfdi:CfdiRelacionado");
//    $CfdiRel = $emisor->appendChild($CfdiRel);
//    cargaAtt($CfdiRel, array("UUID"=>"A39DA66B-52CA-49E3-879B-5C05185B0EF7"));    

    
    
    $emisor = $xml->createElement("cfdi:Emisor");
    $emisor = $root->appendChild($emisor);
    cargaAtt($emisor, array("Rfc"=>$emisor_rfc,
                            "Nombre"=>$emisor_rs,
                            "RegimenFiscal"=>"601"
                             )
                        );
    
    
    $receptor = $xml->createElement("cfdi:Receptor");
    $receptor = $root->appendChild($receptor);
    cargaAtt($receptor, array("Rfc"=>$receptor_rfc,
                    "Nombre"=>$receptor_rs,
                    "UsoCFDI"=>"G01"
                )
            );
    
    
    $conceptos = $xml->createElement("cfdi:Conceptos");
    $conceptos = $root->appendChild($conceptos);
    
    #== 11.4 Ciclo "for", recopilación de datos de artículos e integración de sus respectivos nodos =
    
    for ($i=0; $i<count($Array_Cantidad); $i++){
       	
        $concepto = $xml->createElement("cfdi:Concepto");
        $concepto = $conceptos->appendChild($concepto);
        cargaAtt($concepto, array(
               "ClaveProdServ"=>$Array_ClaveProdServ[$i],
               "NoIdentificacion"=>$Array_NoIdentificacion[$i],
               "Cantidad"=>$Array_Cantidad[$i],
               "ClaveUnidad"=>$Array_ClaveUnidad[$i],
               "Unidad"=>$Array_Unidad[$i],
               "Descripcion"=>$Array_Descripcion[$i],
               "ValorUnitario"=>number_format($Array_ValorUnitario[$i],2,'.',''),
               "Importe"=>number_format($Array_Importe[$i],2,'.',''),
               "Descuento"=>number_format($Array_Descuento[$i],2,'.','')
            )
        );
    
        $impuestos = $xml->createElement("cfdi:Impuestos");
        $impuestos = $concepto->appendChild($impuestos);

            $Traslados = $xml->createElement("cfdi:Traslados");
            $Traslados = $impuestos->appendChild($Traslados);
            
                $Traslado = $xml->createElement("cfdi:Traslado");
                $Traslado = $Traslados->appendChild($Traslado);
                
                    cargaAtt($Traslado, array(
                           "Base"=>number_format($ArrayTraslado_Base[$i],2,'.',''),
                           "Impuesto"=>$ArrayTraslado_Impuesto[$i],
                           "TipoFactor"=>$ArrayTraslado_TipoFactor[$i],
                           "TasaOCuota"=>$ArrayTraslado_TasaOCuota[$i],
                           "Importe"=>number_format($ArrayTraslado_Importe[$i],2,'.','')
                        ) 
                    );                    
                  
        
            $Retenciones = $xml->createElement("cfdi:Retenciones");
            $Retenciones = $impuestos->appendChild($Retenciones);
            
                $Retencion = $xml->createElement("cfdi:Retencion");
                $Retencion = $Retenciones->appendChild($Retencion);
                
                    cargaAtt($Retencion, array(
                           "Base"=>number_format($ArrayRetencion_Base[$i],2,'.',''),
                           "Impuesto"=>$ArrayRetencion_Impuesto[$i],
                           "TipoFactor"=>$ArrayRetencion_TipoFactor[$i],
                           "TasaOCuota"=>$ArrayRetencion_TasaOCuota[$i],
                           "Importe"=>number_format($ArrayRetencion_Importe[$i],2,'.','')
                        ) 
                    );
              
}

#== 11.5 Impuestos retenidos y trasladados ==========================================

$Impuestos = $xml->createElement("cfdi:Impuestos");
$Impuestos = $root->appendChild($Impuestos);

    $Retenciones = $xml->createElement("cfdi:Retenciones");
    $Retenciones = $Impuestos->appendChild($Retenciones);    

        $Retencion = $xml->createElement("cfdi:Retencion");
        $Retencion = $Retenciones->appendChild($Retencion);

            cargaAtt($Retencion, array(
                   "Impuesto"=>"002",
                   "Importe"=>number_format($totalImpuestosRetenidos,2,'.','')
                ) 
            );

            cargaAtt($Impuestos, array(
                            "TotalImpuestosRetenidos"=>number_format($totalImpuestosRetenidos,2,'.','')
                        )
                    );
            
            
    $Traslados = $xml->createElement("cfdi:Traslados");
    $Traslados = $Impuestos->appendChild($Traslados);

        $Traslado = $xml->createElement("cfdi:Traslado");
        $Traslado = $Traslados->appendChild($Traslado);

            cargaAtt($Traslado, array(
                   "Impuesto"=>"002",
                   "TipoFactor"=>"Tasa",
                   "TasaOCuota"=>"0.160000",
                   "Importe"=>number_format($totalImpuestosTrasladados,2,'.','')
                ) 
            );    
            
            cargaAtt($Impuestos, array(
                    "TotalImpuestosTrasladados"=>number_format($totalImpuestosTrasladados,2,'.','')
                )
            );

                         
    $complemento = $xml->createElement("cfdi:Complemento");
    $complemento = $root->appendChild($complemento);
    
    #== 11.6 Termina de conformarse la "Cadena original" con doble ||
    $cadena_original .= "|";   
    
//        $file = fopen($SendaCFDI."CadenaOriginal_Factura_".$NoFac.".txt", "w");
//        fwrite($file, $cadena_original . PHP_EOL);
//        fclose($file);
//        chmod($SendaCFDI."CadenaOriginal_Factura_".$NoFac.".txt", 0777);      
    
    #=== Muestra la cadena original (opcional a mostrar) =======================
    echo '<div style="font-size: 11pt; color: #000099; ; font-family: Verdana, Arial, Helvetica, sans-serif;">';
    echo 'CADENA ORIGINAL';
    echo '</div>';
    echo '<div style="font-size: 9pt; color: #000000; ; font-family: Verdana, Arial, Helvetica, sans-serif;">';
    echo $cadena_original;
    echo '</div><br>';
    
    #== 11.7 Proceso para obtener el sello digital del archivo .pem.key ========
    $keyid = openssl_get_privatekey(file_get_contents($SendaPEMS.$file_key));
    openssl_sign($cadena_original, $crypttext, $keyid, OPENSSL_ALGO_SHA256);
    openssl_free_key($keyid);
    

    #== 11.8 Se convierte la cadena digital a Base 64 ==========================
    $sello = base64_encode($crypttext);    
    
    #=== Muestra el sello (opcional a mostrar) =================================
    echo '<div style="font-size: 11pt; color: #000099; ; font-family: Verdana, Arial, Helvetica, sans-serif;">';
    echo 'SELLO';
    echo '</div>';
    echo '<div style="font-size: 9pt; color: #000000; ; font-family: Verdana, Arial, Helvetica, sans-serif;">';
    echo $sello;
    echo '</div><br>';    
    
    #== 11.9 Proceso para extraer el certificado del sello digital ============
    $file = $SendaPEMS.$file_cer;      // Ruta al archivo
    $datos = file($file);
    $certificado = ""; 
    $carga=false;  
    for ($i=0; $i<sizeof($datos); $i++){
        if (strstr($datos[$i],"END CERTIFICATE")) $carga=false;
        if ($carga) $certificado .= trim($datos[$i]);

        if (strstr($datos[$i],"BEGIN CERTIFICATE")) $carga=true;
    } 
    
    #=== Muestra el certificado del sello digital (opcional a mostrar) =========
    echo '<div style="font-size: 11pt; color: #000099; ; font-family: Verdana, Arial, Helvetica, sans-serif;">';
    echo 'CERTIFICADO DEL SELLO DIGITAL';
    echo '</div>';
    echo '<div style="font-size: 9pt; color: #000000; ; font-family: Verdana, Arial, Helvetica, sans-serif;">';
    echo $certificado;
    echo '</div><br>';    
    
    #== 11.10 Se continua con la integración de nodos ===========================   
    $root->setAttribute("Sello",$sello);
    $root->setAttribute("Certificado",$certificado);   # Certificado.
    
    
    #== Fin de la integración de nodos =========================================
    
    
    $NomArchCFDI = $SendaCFDI."PreCFDI-33_Factura_".$NoFac.".xml";
    
    
    #=== 11.12 Se guarda el archivo .XML antes de ser timbrado =======================
    $cfdi = $xml->saveXML();
    $xml->formatOutput = true;             
//    $xml->save($NomArchCFDI); // Guarda el archivo .XML (sin timbrar) en el directorio predeterminado.
    unset($xml);
    
    #=== 11.13 Se dan permisos de escritura al archivo .xml. =========================
//    chmod($NomArchCFDI, 0777); 
    
    
##### FIN DE LA CREACIÓN DEL ARCHIVO .XML ANTES DE SER TIMBRADO ####################################################   
    
    
    
    


        
    
    
### 14. FUNCIONES DEL MÓDULO #########################################################
        
    # 14.1 Función que integra los nodos al archivo .XML y forma la "Cadena original".
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
        global $xml;
        $quitar = array('sello'=>1,'noCertificado'=>1,'certificado'=>1);
        foreach ($attr as $key => $val){
            $val = preg_replace('/\s\s+/', ' ', $val);
            $val = trim($val);
            if (strlen($val)>0){
                 $val = utf8_encode(str_replace("|","/",$val));
                 $nodo->setAttribute($key,$val);
                 if (!isset($quitar[$key])) 
                   if (substr($key,0,3) != "xml" &&
                       substr($key,0,4) != "xsi:");
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
    

   
    
    
    