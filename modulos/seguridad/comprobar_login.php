<?php
session_start();
if ($_SESSION["autentificado"] != "SI") {
		header("Location: ../../seguridad/login.php");
		exit();
}
?>