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

if (isset($_POST['descripcion'])){
	$descripcion=htmlentities(trim($_POST['descripcion']));
	//$icono=mysql_real_escape_string($icono);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo descripcion no es correcto</p>";
}
// VARIABLES LECCIONES /////////////////////////////////////////////////////////////////
//Input input Contador Lecciones
if (isset($_POST['inputContadorLecciones'])){ //select tipo leccion
	$contadorLecciones=htmlentities(trim($_POST['inputContadorLecciones']));
	//$icono=mysql_real_escape_string($icono);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo Contador-Lecciones no es correcto</p>";
}
// select tipo leccion
$aTipoLecciones = array(); //se declara el arreglo que contiene todos elementos
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
}
//Input Contenido
$aInputLecciones = array(); //se declara el arreglo que contiene todos elementos
for ($i=0; $i <= $contadorLecciones ; $i++) { //recorremos el arreglo en base a la variable contador
	$concatenacion = "contenidoInput".$i;
	switch (isset($_POST[$concatenacion])) {
		case true:
			$contenidoInput=htmlentities(trim($_POST[$concatenacion]));
			array_push($aInputLecciones,$contenidoInput);
			break;
		
		default:
			array_push($aInputLecciones,"error");
			break;
	}
}

//Text Area Contenido
$aTextareaLecciones = array(); //se declara el arreglo que contiene todos elementos
for ($i=0; $i <= $contadorLecciones; $i++) { //recorremos el arreglo en base a la variable contador
	$concatenacion = "contenidoTextArea".$i;
	switch (isset($_POST[$concatenacion])) {
		case true:
			$contenidoTextArea=htmlentities(trim($_POST[$concatenacion]));
		array_push($aTextareaLecciones,$contenidoTextArea);
			break;
		
		default:
		array_push($aTextareaLecciones,"");
			break;
	}
}
/*CARGAR ARCHIVO*/
function generarClave2($longitud){ 
	$cadena="[^A-Z0-9]"; 
	return substr(str_replace($cadena, "", md5(rand())) . 
	str_replace($cadena, "", md5(rand())) . 
	str_replace($cadena, "", md5(rand())), 
	0, $longitud); 
}

$aRecursoTemporal = array();
$aRecursoNombre = array();
$aExtencionRecurso = array();
$aRecurso = array();
$aRecursoExtencion = array();

/* for ($i=0; $i <= $ContadorLecciones ; $i++) { 
	$recursoContador = "recurso".$i;
	$clave = generarClave2(5);
	if (isset($_FILES['recurso0']['name'])){
		$recursotemporal=$_FILES['recurso0']['tmp_name'];
		$recursonombre=$_FILES['recurso0']['name'];
		$extencionrecurso=pathinfo($_FILES['recurso0']['name'], PATHINFO_EXTENSION);
		$recurso=basename($_FILES['recurso0']['name'],".".$extencionrecurso)."_".$clave;
		$recursoExtencion= $recurso.".".$extencionrecurso;
			if($recursotemporal==""){
				$recurso="";
			}
		array_push($aRecursoTemporal,$recursotemporal); //pendiente saber que objeto es el que pusheo al array 
		array_push($aRecursoNombre,$recursonombre); //pendiente saber que objeto es el que pusheo al array 
		array_push($aExtencionRecurso,$extencionrecurso); //pendiente saber que objeto es el que pusheo al array 
		array_push($aRecurso,$recurso); //pendiente saber que objeto es el que pusheo al array 
		array_push($aRecursoExtencion,$recursoExtencion); //pendiente saber que objeto es el que pusheo al array 
		}else{
		array_push($aRecursoTemporal,$recurso); 
		array_push($aRecursoNombre,$recurso); 
		array_push($aExtencionRecurso,$recurso); 
		array_push($aRecurso,$recurso); 
		array_push($aRecursoExtencion,$recurso);
	}
} */
if (isset($_FILES['recurso0']['name'])){
	$recursotemporal=$_FILES['recurso0']['tmp_name'];
	$recursonombre=$_FILES['recurso0']['name'];
	$extencionrecurso=pathinfo($_FILES['recurso0']['name'], PATHINFO_EXTENSION);
	$recurso=basename($_FILES['recurso0']['name'],".".$extencionfactura)."_".generarClave(5);
	$recursoExtencion= $recurso.".".$extencionrecurso;	
	if($recursotemporal==""){
		$frecurso="";
	}
}else{
	$recursonombre = "No se encontro";
	// $validacion=false;
	// $mensaje=$mensaje."<p>El campo recurso no es correcto</p>";
}

// VARIABLES EXAMEN /////////////////////////////////////////////////////////////////////////////////////
/* Contador Preguntas */
if (isset($_POST['inputContadorExamen'])){ //select tipo leccion
	$contadorExamen=htmlentities(trim($_POST['inputContadorExamen']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo Contador-Examen no es correcto</p>";
}
/* NOMBRE DEL EXAMEN */
if (isset($_POST['nombreExamen'])){ //select tipo leccion
	$nombreExamen=htmlentities(trim($_POST['nombreExamen']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo Nombre del Examen no es correcto</p>";
}
/* Arreglo Contador Respuestas */
if (isset($_POST['inputContadorRespuestas'])){ //select tipo leccion
	$contadorRespuestas=htmlentities(trim($_POST['inputContadorRespuestas']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo Contador-Respuesta no es correcto</p>";
}
$aContadorRespuestas = array();
$aContadorRespuestas = explode(",",$contadorRespuestas);

/* Valor de Pregunta */
$aValorPregunta = array();
for ($i=0; $i <= $contadorExamen; $i++) { //recorremos el arreglo en base a la variable contador
	$concatenacion = "inputValor".$i;
	switch (isset($_POST[$concatenacion])) {
		case true:
			$valorPregunta=htmlentities(trim($_POST[$concatenacion]));
			array_push($aValorPregunta,$valorPregunta);
			break;
		
		default:
			array_push($aValorPregunta,"");
			break;
	}
}
/* Tipo pregunta */
$aTipoPregunta = array();
for ($i=0; $i <= $contadorExamen; $i++) { //recorremos el arreglo en base a la variable contador
	$concatenacion = "tipoPregunta".$i;
	switch (isset($_POST[$concatenacion])) {
		case true:
			$tipoPregunta=htmlentities(trim($_POST[$concatenacion]));
			array_push($aTipoPregunta,$tipoPregunta);
			break;
		
		default:
			array_push($aTipoPregunta,"");
			break;
	}
}
/* Input Pregunta */
$aInputPregunta = array();
for ($i=0; $i <= $contadorExamen; $i++) { //recorremos el arreglo en base a la variable contador
	$concatenacion = "inputPregunta".$i;
	switch (isset($_POST[$concatenacion])) {
		case true:
			$inputPregunta=htmlentities(trim($_POST[$concatenacion]));
			array_push($aInputPregunta,$inputPregunta);
			break;
		
		default:
			array_push($aInputPregunta,"");
			break;
	}
}

/* textArea Pregunta */
$aTextareaPregunta = array();
for ($i=0; $i <= $contadorExamen; $i++) { //recorremos el arreglo en base a la variable contador
	$concatenacion = "textareaPregunta".$i;
	switch (isset($_POST[$concatenacion])) {
		case true:
			$textareaPregunta=htmlentities(trim($_POST[$concatenacion]));
			array_push($aTextareaPregunta,$textareaPregunta);
			break;
		
		default:
			array_push($aTextareaPregunta,"eliminado");
			break;
	}
}
// RESPUESTAS ////////////////////////////////////////////////////////////////////////////////////////
/* SE CREA UN ARREGLO BIDIMIENCIONAL PARA GUARDAR LAS RESPUESTAS*/
$aaInputRespuesta = array();
for ($x=0; $x <= $contadorExamen; $x++) {
	array_push($aaInputRespuesta, array());
	$contador = $aContadorRespuestas[$x];
	for ($y=0; $y <= $contador; $y++) {
		$concatenacion = "inputRespuesta".$x.$y;		
		switch (isset($_POST[$concatenacion])) {
			case true:
				$inputRespuesta=htmlentities(trim($_POST[$concatenacion]));
				array_push($aaInputRespuesta[$x],$inputRespuesta);
				break;
			
			default:
				array_push($aaInputRespuesta[$x],"eliminado");
				break;
			}
	} 
}
/* Arreglo BIDIMENCIONAL PARA GUARDAR VALOR DE CHECKBOX */
$aaCheckboxRespuesta = array();
for ($x=0; $x <= $contadorExamen; $x++) {
	array_push($aaCheckboxRespuesta, array());
	$contador = $aContadorRespuestas[$x];
	for ($y=0; $y <= $contador; $y++) {
		// $concatenacion = "checkboxRespuesta".$x.$y;		
		switch (isset($_POST[$concatenacion])) {
			case true:
				$checkboxRespuesta=htmlentities(trim($_POST[$concatenacion]));
				array_push($aaCheckboxRespuesta[$x],$checkboxRespuesta);
				break;
			
			default:
				array_push($aaCheckboxRespuesta[$x],"off");
				break;
			}
	} 
}


if($validacion){
	$resultado=$Ocursos->guardar(
		$nombre,// datos generales del curso
		$categoria,
		$icono,
		$descripcion,
		$contadorLecciones,// Lecciones
		$aTipoLecciones,
		$aInputLecciones,
		$aTextareaLecciones,
		$aRecursoTemporal,
		$aRecursoNombre,
		$aExtencionRecurso,
		$aRecurso,
		$aRecursoExtencion,
		$contadorExamen,// Examen
		$nombreExamen,
		$aValorPregunta, // PREGUNTAS
		$aTipoPregunta,
		$aTextareaPregunta,
		$aInputPregunta,
		$aContadorRespuestas,// PREGUNTAS
		$aaInputRespuesta,
		$aaCheckboxRespuesta
	);
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
echo utf8_encode(" - "."Nombre del Recurso :".$recursonombre." - ");
// echo utf8_encode(" - "."Contador inputRespuesta :".$inputRespuesta." - ");
// echo utf8_encode(print_r($aaCheckboxRespuesta));

