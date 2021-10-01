<?php
include ("../../seguridad/comprobar_login.php");
$f = $_POST["f"];
$archivo= "../../ventasajuste/archivosSubidos/facturas/$f";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$f\"\n");
    $fp=fopen("$archivo", "r");
    fpassthru($fp);
?>