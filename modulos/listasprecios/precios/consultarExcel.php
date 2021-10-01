<?php
header('Content-type: application/excel');
$filename = 'reporte_filtrado_productos.xls';
header('Content-Disposition: attachment; filename='.$filename);

include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['productos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Listaprecios.class.php');
$Olista=new Listaprecios;


if (isset($_POST['idlistaprecios']) && $_POST['idlistaprecios'] !="") {
	$idlistaprecios = htmlentities(trim($_POST['idlistaprecios']));
	// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$idlistaprecios ="";
}



//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$resultado=$Olista->consultaLibre("SELECT precios.idprecio,
									precios.precio,
									productos.idfamilia,
									productos.nombre as nombreproducto,
									familias.nombre AS nombrefamilia
									FROM precios 
									INNER JOIN productos ON productos.idproducto=precios.idreferencia
									INNER JOIN familias ON productos.idfamilia=familias.idfamilia
									WHERE precios.idlistaprecios='$idlistaprecios'
");
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA


?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
				<th>ID Lista</th>
				<th>ID producto</th>
				<th>Nombre</th>
                <th>Familia</th>
				<th>Precio</th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr>
        		<td></td>
                <td></td>
                <td></td>
                <td></td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
	</div><!-- /.box-body -->

</div>
<?php 
//FIN DEL CODIGO DE PAGINACION
if(mysqli_num_rows($resultado)==0){
	include("../../../componentes/mensaje_no_hay_registros.php");
}
?>