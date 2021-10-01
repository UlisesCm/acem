<?php 
session_start();
$_SESSION["empresa"]="modulalite";
header('Location: ../../modulos/seguridad/login.php');
?>
