<?php
ini_set("max_execution_time","240");
$numerocomprobante=$_GET['concentrado'];

$rutaEmpresa="../concentrados/";
		if(!is_dir($rutaEmpresa)){ 
			mkdir($rutaEmpresa, 0777);
		}
		$nombreArchivo=$numerocomprobante."-salida";
		ob_start();
		include('plantilla2.php');
		$content = ob_get_clean();
	
		// convert in PDF
		require_once('../../../librerias/php/html2pdf/html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P', 'Letter', 'fr');
	//      $html2pdf->setModeDebug();
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output($rutaEmpresa.$nombreArchivo.".pdf");
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
}

