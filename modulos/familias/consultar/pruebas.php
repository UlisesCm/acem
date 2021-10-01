<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['familias']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Familia.class.php');
$Ofamilia= new Familia;
if($Ofamilia->con->conectar()==true){
	$prenombre=$Ofamilia->recorrerFamiliasHijas("0",$Ofamilia->con->conect);
	echo $prenombre;
}
?>