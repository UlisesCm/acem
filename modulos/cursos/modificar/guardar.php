<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cursos.class.php');
$Ocursos=new Cursos;
$mensaje="";
$validacion=true;

if (isset($_POST['idcurso'])){
	$idcurso=htmlentities(trim($_POST['idcurso']));
	//$idcurso=mysql_real_escape_string($idcurso);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcurso no es correcto</p>";
}

if (isset($_POST['nombre'])){
	$nombre=htmlentities(trim($_POST['nombre']));
	//$nombre=mysql_real_escape_string($nombre);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
}

if (isset($_POST['categoria'])){
	$categoria=htmlentities(trim($_POST['categoria']));
	//$categoria=mysql_real_escape_string($categoria);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo categoria no es correcto</p>";
}

if (isset($_POST['icono'])){
	$icono=htmlentities(trim($_POST['icono']));
	//$icono=mysql_real_escape_string($icono);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo icono no es correcto</p>";
}

//LECCIONES /////////////////////////////////////////////
if (isset($_POST['contadorLecciones'])){
	$contadorLecciones=htmlentities(trim($_POST['contadorLecciones']));
}else{
	$contadorLecciones="no paso";
}

if (isset($_POST['cadenaLecciones'])){
	$cadenaLecciones=htmlentities(trim($_POST['cadenaLecciones']));
}else{
	$cadenaLecciones="no pasa 2";
}

$aIdLecciones = array(); 
$aIdLecciones = explode(":::", $cadenaLecciones ); 
$aIdLecciones = array_filter($aIdLecciones);

$aContenidoLecciones = array(); 
for ($i=1; $i < $contadorLecciones+1 ; $i++) { 
	$leccionTemp = $aIdLecciones[$i];
	switch (isset($_POST[$leccionTemp])) {
		case true:
		$contenidoLeccion=htmlentities(trim($_POST[$leccionTemp]));
		array_push($aContenidoLecciones, $contenidoLeccion);
			break;
		
		default:
		array_push($aContenidoLecciones,"Switch default");
			break;
		}
}
//NOMBRE DEL EXAMEN
if (isset($_POST['nombreExamen'])){
	$nombreExamen=htmlentities(trim($_POST['nombreExamen']));
}else{
	$nombreExamen="sin nombre";
}
if (isset($_POST['idexamen'])){
	$idexamen=htmlentities(trim($_POST['idexamen']));
}else{
	$idexamen="sin nombre";
}
// PREGUNTAS /////////////////////////////////////////////////////////////////////////
if (isset($_POST['contadorPreguntas'])){
	$contadorPreguntas=htmlentities(trim($_POST['contadorPreguntas']));
}else{
	$contadorPreguntas="sin nombre";
}
if (isset($_POST['cadenaPreguntas'])){
	$cadenaPreguntas=htmlentities(trim($_POST['cadenaPreguntas']));
}else{
	$cadenaPreguntas="sin nombre";
}
$aIdPreguntas = array(); 
$aIdPreguntas = explode(":::", $cadenaPreguntas); 
$aIdPreguntas = array_filter($aIdPreguntas);

$aContenidoPreguntas = array(); 
for ($i=1; $i < $contadorPreguntas+1 ; $i++) { 
	$PreguntasTemp = $aIdPreguntas[$i];
	switch (isset($_POST[$PreguntasTemp])) {
		case true:
		$contenidoPregunta=htmlentities(trim($_POST[$PreguntasTemp]));
		array_push($aContenidoPreguntas, $contenidoPregunta);
			break;
		
		default:
		array_push($aContenidoPreguntas,  "Switch default");
			break;
		}
}
//RESPUESTAS//////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['contadorRespuestas'])){
	$contadorRespuestas=htmlentities(trim($_POST['contadorRespuestas']));
}else{
	$contadorRespuestas="sin nombre";
}

if (isset($_POST['cadenaRespuestas'])){
	$cadenaRespuestas=htmlentities(trim($_POST['cadenaRespuestas']));
}else{
	$cadenaRespuestas="sin nombre";
}

$aIdRespuestas = array(); 
$aIdRespuestas = explode(":::", $cadenaRespuestas); 
$aIdRespuestas = array_filter($aIdRespuestas);

$aContenidoRespuestas = array(); 
for ($i=1; $i < $contadorRespuestas+1 ; $i++) { 
	$respuestasTemp = $aIdRespuestas[$i];
	switch (isset($_POST[$respuestasTemp])) {
		case true:
		$contenidoRespuesta=htmlentities(trim($_POST[$respuestasTemp]));
		array_push($aContenidoRespuestas, $contenidoRespuesta);
			break;
		
		default:
		array_push($aContenidoRespuestas,"Switch default");
			break;
		}
}
//RESPUESTA - CHECKBOX Y RADIO///////////////////////////////

if (isset($_POST['cadenaCheckbox'])){
	$cadenaCheckbox=htmlentities(trim($_POST['cadenaCheckbox']));
}else{
	$cadenaCheckbox="sin nombre";
}
$aRespuestasCheck = array(); 
$aRespuestasCheck = explode(":::", $cadenaCheckbox); 
$aRespuestasCheck = array_filter($aRespuestasCheck);

$aContenidoCheck = array(); 
for ($i=1; $i < $contadorRespuestas+1 ; $i++) { 
	$respuestasCheckTemp = $aRespuestasCheck[$i];
/* 	$respuestasTemp = $aIdRespuestas[$i];
	if (isset($_POST[$respuestasCheckTemp]) && ($respuestasCheckTemp == $respuestasTemp)) {
		# code...
	} */
	switch (isset($_POST[$respuestasCheckTemp])) {
		case true:
		$contenidoRespuesta=htmlentities(trim($_POST[$respuestasCheckTemp]));
		array_push($aContenidoCheck, $contenidoRespuesta);
			break;
		
		default:
		array_push($aContenidoCheck,"Switch default");
			break;
		}
	}
$aRespuestasCorrecto = array();
for ($i=0; $i < $contadorRespuestas; $i++) { 
	if ($aContenidoCheck[$i] == $aIdRespuestas[$i+1]) {
		array_push($aRespuestasCorrecto, "on");
	} else {
		array_push($aRespuestasCorrecto, "off");
	}
}

if($validacion){

	$resultado=$Ocursos->actualizar($nombre,$categoria,$icono, $idcurso);
	$Ocursos->modificarLeccion($contadorLecciones, $aIdLecciones, $aContenidoLecciones);
	$Ocursos->modificarPregunta($contadorPreguntas, $aIdPreguntas, $aContenidoPreguntas);
	$Ocursos->modificarRespuesta($contadorRespuestas, $aIdRespuestas, $aContenidoRespuestas, $aRespuestasCorrecto);
	$Ocursos->modificarNombreExamen($idexamen, $nombreExamen);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="nombreExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo nombre ya existe en la base de datos";
	}
	if($resultado=="fracaso"){
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	}
	if($resultado=="denegado"){
		$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);
// echo utf8_encode(" - "."Contador LECCION :".$contadorLecciones);
// echo utf8_encode(" - "."Contador CADENA LECCIONES :".$cadenaLecciones." - ");
// echo utf8_encode(print_r($aContenidoCheck));
// echo utf8_encode(print_r($aRespuestasCorrecto));
// echo utf8_encode(print_r($aIdLecciones));

?>