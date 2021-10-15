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
// select tipo leccion
$aTipoLecciones = array(); //se declara el arreglo que contiene todos elementos
for ($i=0; $i <= $ContadorLecciones; $i++) { //recorremos el arreglo en base a la variable contador
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
for ($i=0; $i <= $ContadorLecciones ; $i++) { //recorremos el arreglo en base a la variable contador
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
for ($i=0; $i <= $ContadorLecciones; $i++) { //recorremos el arreglo en base a la variable contador
	$concatenacion = "contenidoTextArea".$i;
	if (isset($_POST[$concatenacion])){ 
		$contenidoTextArea=htmlentities(trim($_POST[$concatenacion]));
		array_push($aTextareaLecciones,$contenidoTextArea);
	}else{
		array_push($aTextareaLecciones,"");
	}
}
/*CARGAR ARCHIVO*/
/* $aRecursoLecciones = array();
for ($i=0; $i < $ContadorLecciones ; $i++) { 
	$recurso = "recurso".$i;
	if (isset($_FILES[$recurso]['name'])){
		$recursotemporal=$_FILES[$recurso]['tmp_name'];
		$recursonombre=$_FILES[$recurso]['name'];
		$extencionrecurso=pathinfo($_FILES[$recurso]['name'], PATHINFO_EXTENSION);
		$recurso=basename($_FILES[$recurso]['name'],".".$extencionrecurso)."_".generarClave(5);
		$recursoExtencion= $recurso.".".$extencionrecurso;
			if($recursotemporal==""){
				$recurso="";
			}
		array_push($aRecursoLecciones,$recursonombre); //pendiente saber que objeto es el que pusheo al array 
		}else{
			array_push($aRecursoLecciones,"");
	}
} */


if($validacion){
	$resultado=$Ocursos->guardar($nombre,$categoria,$icono,$ContadorLecciones,$aTipoLecciones,$aInputLecciones,$aTextareaLecciones);
	if($resultado=="exito"){
		/*CARGAR ARCHIVOS*/
		//ABRE
		$mensajeArchivo="";
		if($facturatemporal!=""){
			
			$estadoArchivo=cargarArchivo($recurso,$extencionrecurso, $recursotemporal, $recursoExtencion,"pdf","garantias",0,0,"archivo","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionfactura. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		} 
		$mensaje=$mensaje.$mensajeArchivo; //CIERRA
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
// echo utf8_encode("- Contador Leccion :".$ContadorLecciones." - ");
// echo utf8_encode(print_r($aTipoLecciones));
