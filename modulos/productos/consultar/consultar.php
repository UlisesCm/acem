<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['productos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Producto.class.php');
$Oproducto=new Producto;

if (isset($_REQUEST['tipoVista']) && $_REQUEST['tipoVista'] !="") {
	if($_REQUEST['tipoVista']!="undefined"){
		$tipoVista = htmlentities($_REQUEST['tipoVista']);
	}else{
		$tipoVista="tabla";
	}
}else{
	$tipoVista="tabla";
}

if (isset($_REQUEST['papelera']) && $_REQUEST['papelera'] =="si") {
		$papelera=true;
}else{
	$papelera=false;
}
if (isset($_REQUEST['campoOrden']) && $_REQUEST['campoOrden'] !="") {
	if($_REQUEST['campoOrden']!="undefined"){
		$campoOrden = htmlentities($_REQUEST['campoOrden']);
	}else{
		$campoOrden="nombre";
	}
}else{
	$campoOrden="nombre";
}

if (isset($_REQUEST['orden']) && $_REQUEST['orden'] !="") {
	if($_REQUEST['orden']!="undefined"){
		$orden = htmlentities($_REQUEST['orden']);
	}else{
		$orden="DESC";
	}
}else{
	$orden="DESC";
}

if (isset($_REQUEST['cantidadamostrar']) && $_REQUEST['cantidadamostrar'] !="") {
	if($_REQUEST['cantidadamostrar']!="undefined"){
		$cantidadamostrar = htmlentities($_REQUEST['cantidadamostrar']);
	}else{
		$cantidadamostrar="20";
	}
}else{
	$cantidadamostrar="20";
}

if (isset($_REQUEST['paginacion']) && $_REQUEST['paginacion'] !="") {
$pg = htmlentities($_REQUEST['paginacion']);
}

if (isset($_REQUEST['busqueda']) && $_REQUEST['busqueda'] !="") {
$busqueda = htmlentities($_REQUEST['busqueda']);
// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$busqueda ="";
}

$consultaExtra="";

if (isset($_REQUEST['marca']) && $_REQUEST['marca'] !="") {
	$marca = htmlentities($_REQUEST['marca']);
	if (trim($marca)!="" and trim($marca)!="null"){
		$consultaExtra=$consultaExtra." AND productos.marca='$marca'";
	}
	// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$marca ="";
}

if (isset($_REQUEST['espesor']) && $_REQUEST['espesor'] !="") {
	$espesor = htmlentities($_REQUEST['espesor']);
	if (trim($espesor)!="" and trim($espesor)!="null"){
		$consultaExtra=$consultaExtra." AND productos.espesor='$espesor'";
	}
	// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$espesor ="";
}

if (isset($_REQUEST['ancho']) && $_REQUEST['ancho'] !="") {
	$ancho = htmlentities($_REQUEST['ancho']);
	if (trim($ancho)!="" and trim($ancho)!="null"){
		$consultaExtra=$consultaExtra." AND productos.ancho='$ancho'";
	}
	// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$ancho ="";
}

if (isset($_REQUEST['diametro']) && $_REQUEST['diametro'] !="") {
	$diametro = htmlentities($_REQUEST['diametro']);
	if (trim($diametro)!="" and trim($diametro)!="null"){
		$consultaExtra=$consultaExtra." AND productos.diametro='$diametro'";
	}
	// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$diametro ="";
}

if (isset($_REQUEST['alto']) && $_REQUEST['alto'] !="") {
	$alto = htmlentities($_REQUEST['alto']);
	if (trim($alto)!="" and trim($alto)!="null"){
		$consultaExtra=$consultaExtra." AND productos.alto='$alto'";
	}
	// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$alto ="";
}

if (isset($_REQUEST['largo']) && $_REQUEST['largo'] !="") {
	$largo = htmlentities($_REQUEST['largo']);
	if (trim($largo)!="" and trim($largo)!="null"){
		$consultaExtra=$consultaExtra." AND productos.largo='$largo'";
	}
	// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$largo ="";
}

if (isset($_REQUEST['color']) && $_REQUEST['color'] !="") {
	$color = htmlentities($_REQUEST['color']);
	if (trim($color)!="" and trim($color)!="null"){
		$consultaExtra=$consultaExtra." AND productos.color='$color'";
	}
	// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$color ="";
}

if (isset($_REQUEST['aplicacion']) && $_REQUEST['aplicacion'] !="") {
	$aplicacion = htmlentities($_REQUEST['aplicacion']);
	if (trim($aplicacion)!="" and trim($aplicacion)!="null"){
		$consultaExtra=$consultaExtra." AND productos.aplicacion='$aplicacion'";
	}
	// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$aplicacion ="";
}

if (isset($_REQUEST['tipo']) && $_REQUEST['tipo'] !="") {
	$tipo = htmlentities($_REQUEST['tipo']);
	if (trim($tipo)!="" and trim($tipo)!="null"){
		$consultaExtra=$consultaExtra." AND productos.tipo='$tipo'";
	}
	// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$tipo ="";
}

if (isset($_REQUEST['idfamilia']) && $_REQUEST['idfamilia'] !="") {
	$idfamilia = htmlentities(trim($_REQUEST['idfamilia']));
	// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$idfamilia ="";
}

if (trim($idfamilia)!=""){
	$idsfamilias=$Oproducto->obtenerFamiliasHijas($idfamilia);
	$cadena ="";
	if ($idsfamilias!="error"){
		foreach ($arrayFamilia as &$valor) {
			$cadena = $cadena.$valor.",";
		}
		$cadena=$idfamilia.",".$cadena;
		$cadena = substr($cadena, 0, -1);
		$consultaExtra=$consultaExtra." AND productos.idfamilia IN ($cadena)";
	}
}
			


//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$resultado=$Oproducto->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $consultaExtra, "no", $idfamilia);
$filasTotales=$resultado[1];
$resultado=$resultado[0];
	
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#1fba88;"></th>
				<th class="Cidproducto">ID</th>
				<th class="Cnombre">Nombre</th>
				<th class="Cidfamilia">Familia</th>
                <th class="Cidunidad">Unidad</th>
				<th class="Cmarca">Marca</th>
				<th class="Cpesoteorico">Peso teórico</th>
				<th class="Cespesor">Espesor</th>
				<th class="Cancho">Ancho</th>
				<th class="Ccolor">Color</th>
				<th class="Cdiametro">Diametro</th>
				<th class="Ctipo">Tipo</th>
				<th class="Cmodelo">Modelo A</th>
				<th class="Cmodelo2">Modelo B</th>
				<th class="Clado">Lado</th>
				<th class="Calto">Alto</th>
				<th class="Clargo">Largo</th>
				<th class="Caplicacion">Aplicación</th>
				<th class="Cclave">Clave</th>
				<th class="Cdescripcion">Descripción</th>
                <th class="Cautoclasificar">Autoclasificar</th>
				<th class="Cclasificacion">Clasificación</th>
				<th class="Cidmodeloimpuestos">Modelo Impuestos</th>
				<th class="Cidcategoria">Categoría</th>
				<th class="Cvariacionpermitidaencosto">Variación de costo</th>
				<th class="Ccosto">Costo</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idproducto'] ?>" ondblclick="abrirModal(<?php echo $filas['idproducto'] ?>);">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['productos']['eliminar'])){ ?>
                		<?php if($filas['idproducto']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idproducto'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idproducto'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#1fba88;"></td>
				<td class="Cidproducto"><?php echo $filas['idproducto']; ?></td>
				<td class="Cnombre"><b><?php echo $filas['nombre']; ?></b></td>
				<td class="Cidfamilia"><span class="badge" style="background:#668EB3"><?php echo $filas['nombrefamilias']; ?></span></td>
                <td class="Cidunidad"><?php echo $filas['nombreunidades']; ?></td>
				<td class="Cmarca"><?php echo $filas['marca']; ?></td>
				<td class="Cpesoteorico"><?php echo $filas['pesoteorico']; ?></td>
				<td class="Cespesor"><?php echo $filas['espesor']; ?></td>
				<td class="Cancho"><?php echo $filas['ancho']; ?></td>
				<td class="Ccolor"><?php echo $filas['color']; ?></td>
				<td class="Cdiametro"><?php echo $filas['diametro']; ?></td>
				<td class="Ctipo"><?php echo $filas['tipo']; ?></td>
				<td class="Cmodelo"><?php echo $filas['modelo']; ?></td>
				<td class="Cmodelo2"><?php echo $filas['modelo2']; ?></td>
				<td class="Clado"><?php echo $filas['lado']; ?></td>
				<td class="Calto"><?php echo $filas['alto']; ?></td>
				<td class="Clargo"><?php echo $filas['largo']; ?></td>
				<td class="Caplicacion"><?php echo $filas['aplicacion']; ?></td>
				<td class="Cclave"><?php echo $filas['clave']; ?></td>
				<td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
                <td class="Cautoclasificar"><?php echo $filas['autoclasificar']; ?></td>
				<td class="Cclasificacion"><?php echo $filas['clasificacion']; ?></td>
				<td class="Cidmodeloimpuestos"><?php echo $filas['nombremodelosimpuestos']; ?></td>
				<td class="Cidcategoria"><?php echo $filas['nombrecategorias']; ?></td>
				<td class="Cvariacionpermitidaencosto"><?php echo $filas['variacionpermitidaencosto']; ?></td>
				<td class="Ccosto"><?php echo $filas['costo']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['productos']['eliminar'])){
						?>
							<?php if($filas['idproducto']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idproducto'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idproducto'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['productos']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=productos&n2=consultarproductos" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idproducto'] ?>"/>
                            <button type="submit" class="btn btn-success btn-xs" value="" title="Modificar"><li class="fa fa-pencil"></li></button>
                		</form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-success btn-xs disabled"><i class="fa fa-pencil"></i></a>
					<?php
                    }
					?>
                </td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
	</div><!-- /.box-body -->
<?php
}
else{ // Si se ha elegido el tipo lista ?>
	<div class="box-body">
    <?php
	while ($filas=mysqli_fetch_array($resultado)) {		
?>
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idproducto'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#1fba88 !important; height:120px; padding-top:15px;"><i class="fa fa-cube"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cnombre" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['productos']['eliminar'])){ ?>
						<?php if($filas['idproducto']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idproducto'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idproducto'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['nombre'] ?>
            </span>
    		<span class="info-box-number Cidfamilia" style="font-weight:normal; color:#1fba88;"><?php echo $filas['idfamilia'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['idcategoria'])!=""){
					$composicion=$composicion."Categoría: ".$filas['idcategoria'];
				}
				echo $composicion;
				?>
			</span>
			
            <table border="0">
             	<tr>
             		<td style=" padding-right:2px;">
						<?php 
						if (!$papelera){
						?>
							<?php /////PERMISOS////////////////
							if (isset($_SESSION['permisos']['productos']['eliminar'])){ ?>
								<?php if($filas['idproducto']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idproducto'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idproducto'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['productos']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=productos&n2=consultarproductos" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idproducto'] ?>"/>
								<button type="submit" class="btn btn-default"><i class="fa fa-pencil"></i></button>
							</form>
						<?php 
						}else{ ?>
							<a class="btn btn-default disabled"><i class="fa fa-pencil"></i></a>
                        <?php
                        }
						?>
                	</td>
        	 	</tr>
             </table>  
            
    	</div><!-- /.info-box-content -->
    </div><!-- /.box -->
<?php 
		} //Fin de while
}// Fin de sis es lista
?>

</div>
<?php 
paginar($pg, $cantidadamostrar, $filasTotales, $campoOrden, $orden, $busqueda, $tipoVista);
//FIN DEL CODIGO DE PAGINACION
if(mysqli_num_rows($resultado)==0){
	include("../../../componentes/mensaje_no_hay_registros.php");
}
?>