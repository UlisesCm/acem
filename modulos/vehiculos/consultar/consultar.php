<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['vehiculos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Vehiculo.class.php');

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
		$campoOrden="idempleado";
	}
}else{
	$campoOrden="idempleado";
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
$Ovehiculo=new Vehiculo;
$resultado=$Ovehiculo->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Ovehiculo->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#52b19c;"></th>
				<th class="Ctipo">Tipo</th>
				<th class="Cmarca">Marca</th>
				<th class="Csubmarca">Sub marca</th>
				<th class="Ccolor">Color</th>
				<th class="Cplaca">Placa</th>
				<th class="Ccapacidaddecarga">Capacidad de carga (Kg)</th>
				<th class="Canio">Año</th>
				<th class="Ckminicial">Kmilometraje inicial</th>
				<th class="Cvigenciaseguro">Vigencia del seguro</th>
				<th class="Ckmultimomantenimiento">Kilometraje último mantenimiento</th>
				<th class="Cfechaultimomantenimiento">Fecha último mantenimiento</th>
				<th class="Ctipodecombustible">Tipo de combustible</th>
				<th class="Cfrecuenciamantenimientokm">Frecuencia mantenimiento en kilómetros</th>
				<th class="Cfrecuenciamantenimientofecha">Frecuencia mantenimiento por meses</th>
				<th class="Cestado">Estado</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idvehiculo'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['vehiculos']['eliminar'])){ ?>
                		<?php if($filas['idvehiculo']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idvehiculo'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idvehiculo'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#52b19c;"></td>
				<td class="Ctipo"><?php echo $filas['tipo']; ?></td>
				<td class="Cmarca"><?php echo $filas['marca']; ?></td>
				<td class="Csubmarca"><?php echo $filas['submarca']; ?></td>
				<td class="Ccolor"><?php echo $filas['color']; ?></td>
				<td class="Cplaca"><?php echo $filas['placa']; ?></td>
				<td class="Ccapacidaddecarga"><?php echo $filas['capacidaddecarga']; ?></td>
				<td class="Canio"><?php echo $filas['anio']; ?></td>
				<td class="Ckminicial"><?php echo $filas['kminicial']; ?></td>
				<?php
				$fechaNvigenciaseguro=date_create($filas['vigenciaseguro']);
				$nuevaFecha= date_format($fechaNvigenciaseguro, 'd/m/Y');
				?>
				<td class="Cvigenciaseguro"><?php echo $nuevaFecha; ?></td>
				<td class="Ckmultimomantenimiento"><?php echo $filas['kmultimomantenimiento']; ?></td>
				<?php
				$fechaNfechaultimomantenimiento=date_create($filas['fechaultimomantenimiento']);
				$nuevaFecha= date_format($fechaNfechaultimomantenimiento, 'd/m/Y');
				?>
				<td class="Cfechaultimomantenimiento"><?php echo $nuevaFecha; ?></td>
				<td class="Ctipodecombustible"><?php echo $filas['tipodecombustible']; ?></td>
				<td class="Cfrecuenciamantenimientokm"><?php echo $filas['frecuenciamantenimientokm']; ?></td>
				<td class="Cfrecuenciamantenimientofecha"><?php echo $filas['frecuenciamantenimientofecha']; ?></td>
				<td class="Cestado"><?php echo $filas['estado']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['vehiculos']['eliminar'])){
						?>
							<?php if($filas['idvehiculo']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idvehiculo'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idvehiculo'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['vehiculos']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=catalogos&n2=vehiculos&n3=consultarvehiculos" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idvehiculo'] ?>"/>
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idvehiculo'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#52b19c !important; height:120px; padding-top:15px;"><i class="fa fa-truck"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Ctipo" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['vehiculos']['eliminar'])){ ?>
						<?php if($filas['idvehiculo']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idvehiculo'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idvehiculo'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['placa'] ?>
            </span>
    		<span class="info-box-number Cmarca" style="font-weight:normal; color:#52b19c;"><?php echo $filas['tipo']." - ".$filas['marca'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['submarca'])!=""){
					$composicion=$composicion."".$filas['submarca'];
				}
				if (trim($filas['color'])!=""){
					$composicion=$composicion.", ".$filas['color'];
				}
				if (trim($filas['anio'])!=""){
					$composicion=$composicion.", ".$filas['anio'];
				}
				if (trim($filas['asignado'])!=""){
					$composicion=$composicion.", ".$filas['asignado'];
				}
				if (trim($filas['estado'])!=""){
					$composicion=$composicion.", ".$filas['estado'];
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
							if (isset($_SESSION['permisos']['vehiculos']['eliminar'])){ ?>
								<?php if($filas['idvehiculo']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idvehiculo'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idvehiculo'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['vehiculos']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=catalogos&n2=vehiculos&n3=consultarvehiculos" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idvehiculo'] ?>"/>
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