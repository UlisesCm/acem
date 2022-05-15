<?php

include("../../../librerias/php/mpdf/vendor/autoload.php");
// require('../Asignacionherramientas.class.php');
require('../Cursos.class.php');
include("../../../librerias/php/mpdf/examencalificado.php");

$nombreExamen=$_COOKIE["nombreExamen"];
$nombreAlumno=$_COOKIE["nombreAlumno"];
$calificacionFinal=$_COOKIE["calificacionFinal"];
$idavancecurso=$_COOKIE["idavancecurso"];
$nombreDocente=$_COOKIE["nombreDocente"];
// $nombreExamen= "COOKIE NOMBRE DEL EXAMEN";

function Reporte($nombreExamen, $nombreAlumno, $calificacionFinal, $idavancecurso, $nombreDocente){
    $obtenerplantillacompleta = new clasegeneradorpdf;
    $plantillacompleta=$obtenerplantillacompleta->GeneradorPdf($nombreExamen, $nombreAlumno, $calificacionFinal, $idavancecurso, $nombreDocente);
    return $plantillacompleta;
}
// $nombreExamen= $_COOKIE["nombreExamen"];


Reporte($nombreExamen, $nombreAlumno, $calificacionFinal, $idavancecurso, $nombreDocente);
 ?>
