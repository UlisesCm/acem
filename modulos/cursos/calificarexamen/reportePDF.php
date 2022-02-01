<?php

include("../../../librerias/php/mpdf/vendor/autoload.php");
// require('../Asignacionherramientas.class.php');
require('../Cursos.class.php');
include("../../../librerias/php/mpdf/examencalificado.php");

$nombreExamen=$_COOKIE["nombreExamen"];
// $nombreExamen= "COOKIE NOMBRE DEL EXAMEN";

function Reporte($nombreExamen){
    $obtenerplantillacompleta = new clasegeneradorpdf;
    $plantillacompleta=$obtenerplantillacompleta->GeneradorPdf($nombreExamen);
    return $plantillacompleta;
}
// $nombreExamen= $_COOKIE["nombreExamen"];


Reporte($nombreExamen);
 ?>
