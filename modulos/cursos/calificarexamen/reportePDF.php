<?php

include("../../../librerias/php/mpdf/vendor/autoload.php");
// require('../Asignacionherramientas.class.php');
require('../Cursos.class.php');
include("../../../librerias/php/mpdf/examencalificado.php");

$nombreExamen=$_COOKIE["nombreExamen"];
$nombreAlumno=$_COOKIE["nombreAlumno"];
// $nombreExamen= "COOKIE NOMBRE DEL EXAMEN";

function Reporte($nombreExamen, $nombreAlumno){
    $obtenerplantillacompleta = new clasegeneradorpdf;
    $plantillacompleta=$obtenerplantillacompleta->GeneradorPdf($nombreExamen, $nombreAlumno);
    return $plantillacompleta;
}
// $nombreExamen= $_COOKIE["nombreExamen"];


Reporte($nombreExamen, $nombreAlumno);
 ?>
