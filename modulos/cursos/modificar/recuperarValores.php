<?php
require("../Cursos.class.php");
$idcurso=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocursos= new Cursos;
	$resultado=$Ocursos->mostrarIndividual($id);
	$resultadoLeccion=$Ocursos->mostrarLeccion2($id);
	$resultadoExamen=$Ocursos->mostrarExamen($id);
	$resultadoExamen2=$Ocursos->mostrarExamen($id);
	
	$extractorExamen = mysqli_fetch_array($resultadoExamen2);
	$idexamen = $extractorExamen['idexamen'];
	$resultadoPreguntas=$Ocursos->mostrarPreguntas($idexamen); //preguntas
	
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$categoria=$extractor["categoria"];
	$icono=$extractor["icono"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>