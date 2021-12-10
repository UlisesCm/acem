<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cursos.class.php');
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
$Ocursos=new Cursos;
$mensaje="";
$validacion=true;

// GUARDAR DATOS GENERALES DEL CURSO //////////////////////////////////////////////
if (isset($_POST['nombre'])){
	$nombre=htmlentities(trim($_POST['nombre']));
	//$nombre=mysql_real_escape_string($nombre);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
}

if (isset($_POST['categoria'])){
	$categoria=htmlentities(trim($_POST['categoria']));
	
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

if (isset($_POST['descripcion'])){
	$descripcion=htmlentities(trim($_POST['descripcion']));
	//$icono=mysql_real_escape_string($icono);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo descripcion no es correcto</p>";
}

//VARIABLES RESPUESTAS DE EXAMEN ///////////////////////////////////////////////////////
if (isset($_POST['contadorPregunta'])){ //INT
	$contadorPreguntas=htmlentities(trim($_POST['contadorPregunta']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo contador de Preguntas no es correcto</p>";
}

if (isset($_POST['idexamen'])){ //INT
	$idexamen=htmlentities(trim($_POST['idexamen']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo contador de idexamen no es correcto</p>";
}

if (isset($_POST['arregloPregunta'])){ //INT
	$arregloPreguntas=htmlentities(trim($_POST['arregloPregunta']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo contador de arreglo pregunta no es correcto</p>";
}
$aPreguntas = array();
$aPreguntas = explode(",",$arregloPreguntas); 


if (isset($_POST['arregloRespuesta'])){ //INT
	$arregloRespuestas=htmlentities(trim($_POST['arregloRespuesta']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo contador de arreglo pregunta no es correcto</p>";
}
$aRespuestas = array();
$aRespuestas = explode(",",$arregloRespuestas); 


//REFERENCIA
/* $aTipoLecciones = array(); //se declara el arreglo que contiene todos elementos
for ($i=0; $i <= $contadorLecciones; $i++) { //recorremos el arreglo en base a la variable contador
	$concatenacion = "tipoLeccion".$i;
	switch (isset($_POST[$concatenacion])) {
		case true:
			$tipoLeccion=htmlentities(trim($_POST[$concatenacion]));
			array_push($aTipoLecciones,$tipoLeccion);
			break;
		
		default:
			array_push($aTipoLecciones,"");
			break;
	}
} */


if($validacion){
	$resultado=$Ocursos->enviarExamen($contadorPreguntas, $aPreguntas, $aRespuestas, $idexamen);
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
// echo utf8_encode(" - "."Value Radio :".$radio." - ");
// echo utf8_encode(" - "."Contador inputRespuesta :".$inputRespuesta." - ");
// echo utf8_encode(print_r($aTextareaLecciones));

