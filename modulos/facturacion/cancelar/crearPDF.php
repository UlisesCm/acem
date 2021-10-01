<?php
	ob_start();
    include('plantilla.php');
    $content = ob_get_clean();

    // convert in PDF
    require_once('../../../librerias/php/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
//      $html2pdf->setModeDebug();
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output($myFile.".pdf",'F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

?>
