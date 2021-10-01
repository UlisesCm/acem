<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['requisiciones']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Requisicion.class.php');

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
		$papelera=false; // Cambiar a true en caso de que se requiera trabajar con la papelera
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
$busqueda=trim($busqueda);
}else{
	$busqueda ="";
}

if (isset($_REQUEST['filtrarfecha']) && $_REQUEST['filtrarfecha'] !="") {
	$filtrarfecha = htmlentities($_REQUEST['filtrarfecha']);
	$filtrarfecha=trim($filtrarfecha);
}else{
	$filtrarfecha ="NO";
}

if (isset($_REQUEST['fechainicio']) && $_REQUEST['fechainicio'] !="") {
	$fechainicio = htmlentities($_REQUEST['fechainicio']);
	$fechainicio=trim($fechainicio);
}else{
	$fechainicio = date("Y-m-d");
}

if (isset($_REQUEST['fechafin']) && $_REQUEST['fechafin'] !="") {
	$fechafin = htmlentities($_REQUEST['fechafin']);
	$fechafin=trim($fechafin);
}else{
	$fechafin = date("Y-m-d");
}

if (isset($_REQUEST['estado']) && $_REQUEST['estado'] !="") {
	$estado = htmlentities($_REQUEST['estado']);
	$estado=trim($estado);
}else{
	$estado = "TODOS";
}

if (isset($_REQUEST['idsucursal']) && $_REQUEST['idsucursal'] !="") {
	$idsucursal = htmlentities($_REQUEST['idsucursal']);
	$idsucursal=trim($idsucursal);
}else{
	$idsucursal = "TODOS";
}

$consultaExtra="";
if ($filtrarfecha=="SI"){
	$consultaExtra=$consultaExtra." AND (requisiciones.fecha >= '$fechainicio' AND  requisiciones.fecha <= '$fechafin')";
}
if ($estado!="TODAS"){
	$consultaExtra=$consultaExtra." AND requisiciones.estado='$estado'";
}
if ($idsucursal!="TODAS"){
	$consultaExtra=$consultaExtra." AND requisiciones.idsucursal='$idsucursal'";
}


//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Orequisicion=new Requisicion;
$resultado=$Orequisicion->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $consultaExtra);

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
                <th class="columnaDecorada" style="background:#909;"></th>
				<th class="Cidrequisicion">ID</th>
                <th class="Cidsucursal">Sucursal</th>
				<th class="Cfecha">Fecha del requisicion</th>
				<th class="Cidempleado">Solicitante</th>
                <th class="Cestado">Estado</th>
				<th class="Ccomentarios">Comentarios</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { 
		if ($filas['estado']=="Pendiente"){
			$color="#909";
		}else if ($filas['estado']=="Aceptada"){
			$color="#096";
		}else{
			$color="#D82533";
		}
	?>
    		
      		<tr id="iregistro<?php echo $filas['idrequisicion'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['requisiciones']['eliminar'])){ ?>
                		<?php if($filas['idrequisicion']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idrequisicion'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idrequisicion'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:<?php echo $color; ?>;"></td>
				<td class="Cidrequisicion"><?php echo $filas['idrequisicion']; ?></td>
                <td class="Cidsucursal"><?php echo $filas['nombresucursales']; ?></td>
				<?php
				$fechaNfecha=date_create($filas['fecha']);
				$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
				?>
				<td class="Cfecha"><?php echo $nuevaFecha; ?></td>
                <td class="Cidempleado"><?php echo $filas['nombreempleado']; ?></td>
                <td class="Cestado"><span class="badge" style="background-color:<?php echo $color;?>"><?php echo $filas['estado']; ?></span></td>

				<td class="Ccomentarios"><small><i><?php echo $filas['comentarios']; ?></i></small></td>
        		
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['requisiciones']['modificar'])){
					?>
                        <form action="../modificar/actualizar.php?n1=requisiciones&n2=requisiciones&n3=consultarrequisiciones" method="post">
							<input type="hidden" name="id" value="<?php echo $filas['idrequisicion'] ?>"/>
							<button type="submit" class="btn btn-success btn-xs" value="" title="Ver detalles"><i class="fa fa-eye"></i></button>
						</form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-success btn-xs disabled"><i class="fa fa-pencil"></i></a>
					<?php
                    }
					?>
                </td>
                
                <td style=" padding-right:2px;">
						<?php 
						if (!$papelera){
						?>
							<?php /////PERMISOS////////////////
							if (isset($_SESSION['permisos']['requisiciones']['eliminar'])){ ?>
								<?php if($filas['idrequisicion']==0){ ?>
										<a class="btn btn-danger btn-xs  disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
										<a class="btn btn-danger btn-xs " onclick="(eliminarIndividual(<?php echo $filas['idrequisicion'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-danger btn-xs  disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-danger btn-xs" onclick="(restaurarIndividual(<?php echo $filas['idrequisicion'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
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
	
	if ($filas['estado']=="Pendiente"){
			$color="#909";
		}else{
			$color="#D82533";
		}	
?>
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idrequisicion'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:<?php echo $color; ?> !important; height:120px; padding-top:15px;"><i class="fa fa-edit"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cconcepto" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['requisiciones']['eliminar'])){ ?>
						<?php if($filas['idrequisicion']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idrequisicion'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idrequisicion'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['nombresucursales']; ?>
            </span>
    		<span class="info-box-number Ctipo" style="font-weight:normal; color:<?php echo $color; ?>;"><?php echo $filas['estado'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['fecha'])!=""){
					$composicion=$composicion."Fecha de requsición: ".$filas['fecha'].", Solicitante: ".$filas['nombreempleado'];
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
							if (isset($_SESSION['permisos']['requisiciones']['eliminar'])){ ?>
								<?php if($filas['idrequisicion']==0){ ?>
										<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
										<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idrequisicion'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idrequisicion'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['requisiciones']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=requisiciones&n2=requisiciones&n3=consultarrequisiciones" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idrequisicion'] ?>"/>
                                <button type="submit" class="btn btn-default"><i class="fa fa-eye"></i></button>
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