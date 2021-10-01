<?php
require("../Familia.class.php");
$idfamilia=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ofamilia= new Familia;
	$resultado=$Ofamilia->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$mostrarendescripcion=$extractor["mostrarendescripcion"];
	$nombredescripcion=$extractor["nombredescripcion"];
	$prefijocodigo=$extractor["prefijocodigo"];
	$camposrequeridos=$extractor["camposrequeridos"];
	$idfamiliamadre=$extractor["idfamiliamadre"];
	$estatus=$extractor["estatus"];
	//Autocompletar idfamiliamadre
	$Oidfamiliamadre=new Familia;
	$ridfamiliamadre=$Oidfamiliamadre->mostrarIndividual($idfamiliamadre);
	$eidfamiliamadre= mysqli_fetch_array($ridfamiliamadre);
	$autoidfamiliamadre=$eidfamiliamadre["nombre"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>