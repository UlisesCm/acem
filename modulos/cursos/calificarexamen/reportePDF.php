<?php

include("../../../librerias/php/mpdf/vendor/autoload.php");
require('../Asignacionherramientas.class.php');
include("../../../librerias/php/mpdf/indexgeneradorAuditoriaHerramienta.php");


function Reporte($idtrabajador){
    $obtenerplantillacompleta = new clasegeneradorpdf;
    $plantillacompleta=$obtenerplantillacompleta->GeneradorPdf($idtrabajador);
    return $plantillacompleta;
}



$idtrabajador=$_COOKIE["idtrabajador"];

Reporte($idtrabajador);
 ?>
