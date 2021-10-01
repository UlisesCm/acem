<?php
session_start();
$empresa=$_SESSION["empresa"];
session_destroy();
header("Location: ../../empresas/".$empresa);
?>