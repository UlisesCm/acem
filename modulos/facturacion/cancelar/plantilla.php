<page style="width:800px; height:auto; font-family:Arial;font-size:14px; color:#666666;">

	<table width="720" border="0" style="margin-left:10px; font-size:20px; font-weight:bold; width:720px;">
  		<tr height="60">
        	<td width="150"><img src="../../../dist/img/logo150.jpg" width="150" height="150"></td>
    		<td width="570" align="center">Acuse de cancelaci&oacute;n de CFDI</td>    
  		</tr>
  	</table>
    <table width="720" border="0" style="margin-left:10px; width:720px;">
          <tr height="40" style="height:40px;">
            <td style="font-weight:bold; width:350px;">Fecha y hora de solicitud:</td>
            <td style="width:370px;"><?php echo $FechaCancelacion; ?></td>
          </tr>
          <tr height="40" style="height:40px;">
            <td style="font-weight:bold; width:350px;">Fecha y hora de cancelaci&oacute;n:</td>
            <td style="width:370px;"><?php echo $FechaCancelacion; ?></td>
          </tr>
          <tr height="40" style="height:40px;">
            <td style="font-weight:bold; width:350px;">RFC Emisor:</td>
            <td style="width:370px;"><?php echo $RFCemisor; ?></td>
          </tr>
    </table>
    
    
    
    
    <table width="720" border="0" style=" border-collapse:collapse; width:720px; margin-left:10px;">
          <tr>
            <td style="font-weight:bold; border:1px solid #CCC; width:450px;">Folio Fiscal</td>
            <td style="font-weight:bold; border:1px solid #CCC; width:270px;">Estado CFDI</td>
          </tr>
          <tr>
            <td style="border:1px solid #CCC; width:450px;"><?php echo $UUIDcancelado; ?></td>
            <td style="border:1px solid #CCC; width:270px;">Cancelado</td>
          </tr>
    </table>
    
    <table width="720" border="0" style="width:720px; margin-left:10px;">
          <tr height="10">
            <td></td>
          </tr>
    </table>
    
    <table width="720" border="0" style="width:720px; margin-left:10px;">
          <tr>
            <td style="font-weight:bold;">Sello digital SAT:</td>
          </tr>
          <tr>
            <td style="width:720px;"><?php 
					$cadena=$SignatureValue;
					$i=0;
					$caracteres=75;
					while($i < strlen($cadena)){
						if($i%$caracteres==0){
							echo ' ';
						}
						echo $cadena[$i];
						$i++;
					}
					?></td>
          </tr>
    </table>

	
</page>