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
	if (isset($_POST[$concatenacion])){ 
		$tipoLeccion=htmlentities(trim($_POST[$concatenacion]));
		array_push($aTipoLecciones,$tipoLeccion);
	}else{
		array_push($aTipoLecciones,"");
	}
}
//Input Contenido
$aInputLecciones = array(); //se declara el arreglo que contiene todos elementos
for ($i=0; $i <= $contadorLecciones ; $i++) { //recorremos el arreglo en base a la variable contador
	$concatenacion = "contenidoInput".$i;
	if (isset($_POST[$concatenacion])){ 
		$contenidoInput=htmlentities(trim($_POST[$concatenacion]));
		array_push($aInputLecciones,$contenidoInput);
	}else{
		array_push($aInputLecciones,"");
	}
}

//Text Area Contenido

$aTextareaLecciones = array(); //se declara el arreglo que contiene todos elementos
for ($i=0; $i <= $contadorLecciones; $i++) { //recorremos el arreglo en base a la variable contador
	$concatenacion = "contenidoTextArea".$i;
	if (isset($_POST[$concatenacion])){ 
		$contenidoTextArea=htmlentities(trim($_POST[$concatenacion]));
		array_push($aTextareaLecciones,$contenidoTextArea);
	}else{
		array_push($aTextareaLecciones,"");
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
/*CARGAR ARCHIVO*/
/* if (isset($_FILES['recurso0']['name'])){
	$facturatemporal=$_FILES['recurso0']['tmp_name'];
	$facturanombre=$_FILES['recurso0']['name'];
	$extencionfactura=pathinfo($_FILES['recurso0']['name'], PATHINFO_EXTENSION);
	$factura=basename($_FILES['recurso0']['name'],".".$extencionfactura)."_".generarClave(5);
	$facturaExtencion= $factura.".".$extencionfactura;
	
	if($facturatemporal==""){
		$factura="";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo factura no es correcto</p>";
} */
// VARIABLES EXAMEN /////////////////////////////////////////////////////////////////
/* Contador Preguntas */
if (isset($_POST['inputContadorExamen'])){ //select tipo leccion
	$contadorExamen=htmlentities(trim($_POST['inputContadorExamen']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo Contador-Examen no es correcto</p>";
}
/* Arreglo Contador Respuestas */
/* if (isset($_POST['inputContadorRespuestas'])){ //select tipo leccion
	$contadorRespuestas=htmlentities(trim($_POST['inputContadorRespuestas']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo Contador-Respuesta no es correcto</p>";
} */
/* Valor de Pregunta */
$aValorPregunta = array();
for ($i=0; $i <= $contadorExamen; $i++) { //recorremos el arreglo en base a la variable contador
	$concatenacion = "inputValor".$i;
	if (isset($_POST[$concatenacion])){ 
		$valorPregunta=htmlentities(trim($_POST[$concatenacion]));
		array_push($aValorPregunta,$valorPregunta);
	}else{
		array_push($aValorPregunta,"");
	}
}
/* Tipo pregunta */
$atipoPregunta = array();
for ($i=0; $i <= $contadorExamen; $i++) { //recorremos el arreglo en base a la variable contador
	$concatenacion = "tipopregunta".$i;
	if (isset($_POST[$concatenacion])){ 
		$tipoPregunta=htmlentities(trim($_POST[$concatenacion]));
		array_push($atipoPregunta,$tipoPreguntan);
	}else{
		array_push($aTipoLecciones,"");
	}
}



if($validacion){
	$resultado=$Ocursos->guardar($nombre,$categoria,$icono,$ContadorLecciones,$aTipoLecciones,$aInputLecciones,$aTextareaLecciones,$aRecursoTemporal,$aRecursoNombre,$aExtencionRecurso,$aRecurso,$aRecursoExtencion);
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
echo utf8_encode(" - "."Contador Pregunta :".$contadorExamen." - ");
// echo utf8_encode(" - "."Valor Pregunta :".$contadorExamen." - ");
echo utf8_encode(print_r($atipoPregunta));