<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['bitacoravehicular']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Bitacoravehicular.class.php');

if (isset($_REQUEST['idvehiculo']) && $_REQUEST['idvehiculo'] !="") {
	if($_REQUEST['idvehiculo']!="undefined"){
		$idvehiculo = htmlentities($_REQUEST['idvehiculo']);
	}else{
		$idvehiculo="";
	}
}else{
	$idvehiculo="";
}

if (isset($_REQUEST['filtrarfecha']) && $_REQUEST['filtrarfecha'] !="") {
	if($_REQUEST['filtrarfecha']!="undefined"){
		$filtrarfecha = htmlentities($_REQUEST['filtrarfecha']);
	}else{
		$filtrarfecha="";
	}
}else{
	$filtrarfecha="";
}

if (isset($_REQUEST['fechainicio']) && $_REQUEST['fechainicio'] !="") {
	if($_REQUEST['fechainicio']!="undefined"){
		$fechainicio = htmlentities($_REQUEST['fechainicio']);
	}else{
		$fechainicio="";
	}
}else{
	$fechainicio="";
}

if (isset($_REQUEST['fechafin']) && $_REQUEST['fechafin'] !="") {
	if($_REQUEST['fechafin']!="undefined"){
		$fechafin = htmlentities($_REQUEST['fechafin']);
	}else{
		$fechafin="";
	}
}else{
	$fechafin="";
}

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
		$campoOrden="fecha";
	}
}else{
	$campoOrden="fecha";
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

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Obitacoravehicular=new Bitacoravehicular;
$resultado=$Obitacoravehicular->mostrarA($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera,$idvehiculo,$filtrarfecha,$fechainicio,$fechafin);
$filasTotales=$resultado[1];
$resultado=$resultado[0];

if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Obitacoravehicular->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#72ca68;"></th>
				<th class="Cidvehiculo">Vehículo</th>
				<th class="Ccategoria">Categoria</th>
				<th class="Cfecha">Fecha</th>
				<th class="Cdescripcion">Descripción</th>
				<th class="Ctipocombustible">Tipo de combustible</th>
				<th class="Clitros">Litros</th>
				<th class="Ckilometraje">Kilometraje</th>
				<th class="Carchivo">Archivo</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idbitacoravehicular'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['bitacoravehicular']['eliminar'])){ ?>
                		<?php if($filas['idbitacoravehicular']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idbitacoravehicular'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idbitacoravehicular'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#72ca68;"></td>
				<td class="Cidvehiculo"><?php echo $filas['tipovehiculo']." ".$filas['marcavehiculo']." ".$filas['submarcavehiculo']." ".$filas['colorvehiculo']." PLACA: ".$filas['placavehiculo']; ?></td>
				<td class="Ccategoria"><?php echo $filas['categoria']; ?></td>
				<?php
				$fechaNfecha=date_create($filas['fecha']);
				$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
				?>
				<td class="Cfecha"><?php echo $nuevaFecha; ?></td>
				<td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
				<td class="Ctipocombustible"><?php echo $filas['tipocombustible']; ?></td>
				<td class="Clitros"><?php echo $filas['litros']; ?></td>
				<td class="Ckilometraje"><?php echo $filas['kilometraje']; ?></td>
				<td class="Carchivo"><?php echo $filas['archivo']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['bitacoravehicular']['eliminar'])){
						?>
							<?php if($filas['idbitacoravehicular']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idbitacoravehicular'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idbitacoravehicular'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['bitacoravehicular']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=utilerias&n2=controlvehicular&n3=bitacoravehicular&n4=consultarbitacoravehicular" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idbitacoravehicular'] ?>"/>
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idbitacoravehicular'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#72ca68 !important; height:120px; padding-top:15px;"><i class="fa fa-clone"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cidvehiculo" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['bitacoravehicular']['eliminar'])){ ?>
						<?php if($filas['idbitacoravehicular']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idbitacoravehicular'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idbitacoravehicular'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['idvehiculo'] ?>
            </span>
    		<span class="info-box-number Ccategoria" style="font-weight:normal; color:#72ca68;"><?php echo $filas['categoria'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['fecha'])!=""){
					$composicion=$composicion."".$filas['fecha'];
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
							if (isset($_SESSION['permisos']['bitacoravehicular']['eliminar'])){ ?>
								<?php if($filas['idbitacoravehicular']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idbitacoravehicular'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idbitacoravehicular'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['bitacoravehicular']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=utilerias&n2=controlvehicular&n3=bitacoravehicular&n4=consultarbitacoravehicular" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idbitacoravehicular'] ?>"/>
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