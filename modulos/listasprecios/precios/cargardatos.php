<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
include ("../../../librerias/php/SimpleXLSX.php");
require('../Listaprecios.class.php');
$Olistaprecios=new Listaprecios;
$mensaje="";
$validacion=true;

$xlsx = new SimpleXLSX( 'precios.xlsx' );

foreach ($xlsx->rows() as $columna)
	{
	   $sae = $columna[0];
	   $id = $columna[1];
	   $nombre = $columna[2];
	   $familia = $columna[3];
	   $precio = $columna[4];
	   echo $sae." ".$id." ".$nombre." ".$familia." ".$precio."</br>";
	}

?>