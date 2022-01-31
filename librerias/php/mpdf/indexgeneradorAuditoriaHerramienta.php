<?php
include("../../../librerias/php/mpdf/vendor/autoload.php");

class clasegeneradorpdf
{
function GeneradorPdf($idtrabajador){
  // Require composer autoload
  // require_once __DIR__ . '../../../librerias/php/mpdf/vendor/autoload.php';
  include("../../../librerias/php/mpdf/PlantillaAuditoriaHerramienta/diseno.php");
  //require_once __DIR__ . '../../../librerias/php/mpdf/plantilla/diseno.php';
  $css = file_get_contents('../../../librerias/php/mpdf/PlantillaAuditoriaHerramienta/style.css');
  date_default_timezone_set('America/Mexico_City');   //obtener la hora
  // clases necesarias

  //$mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'utf-8', 'format' => 'Legal']);
  //$mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'pad']);
$tamanocontenido=-88;

$mpdf = new \Mpdf\Mpdf([
    'setAutoTopMargin' => 'stretch',
    'autoMarginPadding' => $tamanocontenido, 'format' => 'Letter'
]);


  // $mpdf = new \Mpdf\Mpdf([
  //     'setAutoTopMargin' => 'stretch',
  //     'autoMarginPadding' => -58, 'format' => 'Letter'
  // ]);


  $mpdf->SetAuthor('FUMYLIM');
  $valores = headerpdf();    //obtiene el encabezado con los datos y diseño
  $headercondatos=$valores;
  $contenido = disenohtmlcss($idtrabajador);    //obtiene el encabezado con los datos y diseño
  $obtenercontenido=$contenido;



//_______________________________________________________________________________________________

  //$header = headerpdf();  //esta en el index el diseño -> diseño del header
 $footer = Footer(); // esta en el index el diseño   -> diseño del footer

  // Define the Headers before writing anything so they appear on the first page
  $mpdf->SetHTMLHeader($headercondatos, \Mpdf\HTMLParserMode::HTML_BODY,'O');
  $mpdf->SetHTMLFooter($footer);

  //Dibuja tabla ya con los datos
   $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
   $mpdf->WriteHTML($obtenercontenido, \Mpdf\HTMLParserMode::HTML_BODY);
  // $mpdf->WriteHTML($datostotales, \Mpdf\HTMLParserMode::HTML_BODY);


  // $mpdf->WriteHTML($html);
//$mpdf->Output('pd.pdf','D');
  //$mpdf->Output('pd.pdf','I');

return $mpdf->Output('pdc.pdf','D');
}
}
 ?>
