<?php
	ob_start();
	$nombrePlantilla="plantilla.php";
	if (file_exists("../plantillas/".$_SESSION["empresa"]."_".$nombrePlantilla)){
		$rutaPlantilla="../plantillas/".$_SESSION["empresa"]."_".$nombrePlantilla;
	}else{
		$rutaPlantilla="plantilla.php";
	}
    include($rutaPlantilla);
    $content = ob_get_clean();

    // convert in PDF
    require_once('../../../librerias/php/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
//      $html2pdf->setModeDebug();
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output($rutaEmpresa.$nombreArchivo.".pdf",'F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

?>
