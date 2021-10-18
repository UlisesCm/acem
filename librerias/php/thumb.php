<?php
/*IMAGEN*/
function cargarArchivo($nombreArchivo, $extencionArchivo, $nombreArchivoTemporal, $nombreArchivoNuevo, $extencionesPermitidas="jpg", $directorioDeGuardado="cargadas", $anchoImagen=100, $altoImagen=100, $metodo="crop", $posicionRecorte="left"){
	//obtenemos el archivo a subir
	$file = $nombreArchivo;
	$extension = $extencionArchivo;
	//$empresa=$_SESSION["empresa"];
	$ruta=$ruta="../../../empresas/modulalite/archivosSubidos/$directorioDeGuardado/";
	//Cargamos en un array las extenciones permitidas
	$allowed = explode(",",$extencionesPermitidas);
	if(!in_array(strtolower($extension), $allowed)){
		return "extencionInvalida";
		exit;
	}else{
		//comprobamos si existe un directorio para subir el archivo, si no es así, lo creamos
		if(!is_dir("../../../empresas/modulalite/archivosSubidos/")){ 
			mkdir("../../../empresas/modulalite/archivosSubidos/", 0777);
		}
		if(!is_dir($ruta)){ 
			mkdir($ruta, 0777);
		}
		
		if($metodo=="archivo"){ //Si se ha cargado un archivo
			//comprobamos si el archivo ha subido
			if ($file && move_uploaded_file($nombreArchivoTemporal,$ruta.$nombreArchivoNuevo)){
				return "exito";
			}else{
				return "fracaso";
			}
		}else{ // Si se ha cargado una imagen metodo(crop o resize)
			//comprobamos si el archivo se ha subido
			if ($file && move_uploaded_file($nombreArchivoTemporal,$ruta.$file)){
				
					$nuevaImagen = new thumb();
					$nuevaImagen->loadImage($ruta.$file);
					if ($metodo=="resize"){
						$nuevaImagen->resize($anchoImagen,0); //Ancho deseado (El alto es proporcional al ancho),
					}
					if ($metodo=="crop"){
						$nuevaImagen->crop($anchoImagen,$altoImagen,$posicionRecorte); //Ancho deseado (El alto es proporcional al ancho),
					}
					$nuevaImagen->save($ruta.$nombreArchivoNuevo,100);
					unlink($ruta.$file);
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
}


function generarClaveThumb($longitud){ 
       $cadena="[^A-Z0-9]"; 
       return substr(str_replace($cadena, "", md5(rand())) . 
       str_replace($cadena, "", md5(rand())) . 
       str_replace($cadena, "", md5(rand())), 
       0, $longitud); 
}

error_reporting(0);
class thumb {

var $image;
var $type;
var $width;
var $height;

//---Método de leer la imagen
function loadImage($name) {

//---Tomar las dimensiones de la imagen
$info = getimagesize($name);

$this->width = $info[0];
$this->height = $info[1];
$this->type = $info[2];

//---Dependiendo del tipo de imagen crear una nueva imagen
switch($this->type){
case IMAGETYPE_JPEG:
$this->image = imagecreatefromjpeg($name);
break;
case IMAGETYPE_GIF:
$this->image = imagecreatefromgif($name);
break;
case IMAGETYPE_PNG:
$this->image = imagecreatefrompng($name);
break;
}
}

//---Método de guardar la imagen
function save($name, $quality = 100) {

//---Guardar la imagen en el tipo de archivo correcto
switch($this->type){
case IMAGETYPE_JPEG:
imagejpeg($this->image, $name, $quality);
break;
case IMAGETYPE_GIF:
imagegif($this->image, $name);
break;
case IMAGETYPE_PNG:
$pngquality = floor(($quality - 10) / 10);
imagepng($this->image, $name, $pngquality);
break;
}
}

//---Método de mostrar la imagen sin salvarla
function show() {

//---Mostrar la imagen dependiendo del tipo de archivo
switch($this->type){
case IMAGETYPE_JPEG:
imagejpeg($this->image);
break;
case IMAGETYPE_GIF:
imagegif($this->image);
break;
case IMAGETYPE_PNG:
imagepng($this->image);
break;
}
}

//---Método de redimensionar la imagen sin deformarla
function resize($value, $prop){

//---Determinar la propiedad a redimensionar y la propiedad opuesta
$prop_value = ($prop == 'width') ? $this->width : $this->height;
$prop_versus = ($prop == 'width') ? $this->height : $this->width;

//---Determinar el valor opuesto a la propiedad a redimensionar
$pcent = $value / $prop_value;
$value_versus = $prop_versus * $pcent;

//---Crear la imagen dependiendo de la propiedad a variar
$image = ($prop == 'width') ? imagecreatetruecolor($value, $value_versus) : imagecreatetruecolor($value_versus, $value);

//---Hacer una copia de la imagen dependiendo de la propiedad a variar
switch($prop){

case 'width':
imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value, $value_versus, $this->width, $this->height);
break;

case 'height':
imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value_versus, $value, $this->width, $this->height);
break;

}

//---Actualizar la imagen y sus dimensiones
// $info = getimagesize($name);

$this->width = imagesx($image);
$this->height = imagesy($image);
$this->image = $image;

}

//---Método de extraer una sección de la imagen sin deformarla
function crop($cwidth, $cheight, $pos = 'center') {

//---Dependiendo del tamaño deseado redimensionar primero la imagen a uno de los valores
if($cwidth > $cheight){
$this->resize($cwidth, 'width');
}else{
$this->resize($cheight, 'height');
}

//---Crear la imagen tomando la porción del centro de la imagen redimensionada con las dimensiones deseadas
$image = imagecreatetruecolor($cwidth, $cheight);

switch($pos){

case 'center':
imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
break;

case 'left':
imagecopyresampled($image, $this->image, 0, 0, 0, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
break;

case 'right':
imagecopyresampled($image, $this->image, 0, 0, $this->width - $cwidth, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
break;

case 'top':
imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), 0, $cwidth, $cheight, $cwidth, $cheight);
break;

case 'bottom':
imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), $this->height - $cheight, $cwidth, $cheight, $cwidth, $cheight);
break;

}

$this->image = $image;
}

}
?>