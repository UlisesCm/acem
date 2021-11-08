<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cursos.class.php');
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
$Ocursos=new Cursos;
$mensaje="";
$validacion=true;

if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocursos= new Cursos;
	$resultado=$Ocursos->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
  $idcurso=$extractor["idcurso"];
	$nombre=$extractor["nombre"];
	$categoria=$extractor["categoria"];
	$icono=$extractor["icono"];
}

if (isset($_SESSION['idusuario'])){
	$alumno=htmlentities(trim($_SESSION['idusuario']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo alumno no es correcto</p>";
}

if (isset($_POST['docente'])){
	$docente=htmlentities(trim($_POST['docente']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo docente no es correcto</p>";
}

if($validacion){
	$resultado=$Ocursos->guardarInscribir($idcurso, $docente, $alumno);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
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

?>