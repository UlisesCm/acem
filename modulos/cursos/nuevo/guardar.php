<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cursos.class.php');
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
// VARIABLES EXAMEN /////////////////////////////////////////////////////////////////
/* NOTAS Y OBSERVACIONES DE GUARDAR */
/* Buscar traer todas las variables e irlas pusheando a un arreglo, ver la manera de traer el los index */
//Input input Contador Lecciones
if (isset($_POST['inputContadorLecciones'])){ //select tipo leccion
	$ContadorLecciones=htmlentities(trim($_POST['inputContadorLecciones']));
	//$icono=mysql_real_escape_string($icono);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo Contador-Lecciones no es correcto</p>";
}
//select tipo leccion
$aTipoLecciones = array(); //se declara el arreglo que contiene todos elementos
for ($i=0; $i <= $inputContadorLecciones; $i++) { //recorremos el arreglo en base a la variable contador
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
for ($i=0; $i <= $inputContadorLecciones ; $i++) { //recorremos el arreglo en base a la variable contador
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
for ($i=0; $i <= $inputContadorLecciones ; $i++) { //recorremos el arreglo en base a la variable contador
	$concatenacion = "contenidoTextArea".$i;
	if (isset($_POST[$concatenacion])){ 
		$contenidoTextArea=htmlentities(trim($_POST[$concatenacion]));
		array_push($aTextareaLecciones,$contenidoTextArea);
	}else{
		array_push($aTextareaLecciones,"");
	}
}



/* //Cargar Archivo 1
if (isset($_POST['recurso'])){ //select tipo leccion
	$recurso=htmlentities(trim($_POST['recurso']));
	//$icono=mysql_real_escape_string($icono);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo Archivo-1 no es correcto</p>";
}
//Cargar Archivo 2
if (isset($_POST['nrecurso'])){ //select tipo leccion
	$nrecurso=htmlentities(trim($_POST['nrecurso']));
	//$icono=mysql_real_escape_string($icono);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo Archivo-2 no es correcto</p>";
} */



if($validacion){
	$resultado=$Ocursos->guardar($nombre,$categoria,$icono,$ContadorLecciones,$aTipoLecciones);
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
// echo utf8_encode("- Contador Leccion :".$inputContadorLecciones." - ");
// echo utf8_encode(print_r($aTextareaLecciones))


?>