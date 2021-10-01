<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['domicilios']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Domicilio.class.php');

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
		$campoOrden="calle";
	}
}else{
	$campoOrden="calle";
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
$Odomicilio=new Domicilio;
$resultado=$Odomicilio->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Odomicilio->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA

if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#2ea737;"></th>
                <th class="Cidcliente">Cliente</th>
                <th class="Cnombrecomercial">Nombre comercial</th>
				<th class="Ctipovialidad">Domicilio</th>
				
				
				
				
				<th class="Cidzona">Zona</th>
				<th class="Creferencia">Referencia</th>
				<th class="Cobservaciones">Observaciones</th>
				<th class="Cidsucursal">Sucursal</th>
				<th class="Cidgirocomercial">Giro comercial</th>
				
				<th class="Cidempleado">Ejecutivo de cuenta</th>
				<th width="40" class="sticky-column"></th>
                <th width="40" class="sticky-column"></th>
                <th width="40" class="sticky-column"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) {
		$domicilio=$filas['tipovialidad']." ".$filas['calle']." No. ".$filas['noexterior'];
		if($filas['nointerior']!=""){
			$domicilio=$domicilio.", Int ". $filas['nointerior'];
		}
		if($filas['colonia']!=""){
			$domicilio=$domicilio.", Col". $filas['colonia'];
		}
		$domicilio=$domicilio.", ".$filas['ciudad'].", ".$filas['estado'].", CP: ".$filas['cp'];
		?> 
      		<tr id="iregistro<?php echo $filas['iddomicilio'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['domicilios']['eliminar'])){ ?>
                		<?php if($filas['iddomicilio']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['iddomicilio'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['iddomicilio'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#2ea737;"></td>
                <td class="Cidcliente"><?php echo $filas['nombreclientes']; ?></td>
                <td class="Cnombrecomercial"><?php echo $filas['nombrecomercial']; ?></td>
				<td class="Ctipovialidad"><i><small><?php echo $domicilio; ?></small></i></td>
				
				
				<td class="Cidzona"><?php echo $filas['nombrezonas']; ?></td>
				<td class="Creferencia"><?php echo $filas['referencia']; ?></td>
				<td class="Cobservaciones"><i><small><?php echo $filas['observaciones']; ?></small></i></td>
				<td class="Cidsucursal"><?php echo $filas['nombresucursales']; ?></td>
				<td class="Cidgirocomercial"><?php echo $filas['nombregiroscomerciales']; ?></td>
				
				<td class="Cidempleado"><?php echo $filas['nombreempleados']; ?></td>
        		<td class="sticky-column">
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['domicilios']['eliminar'])){
						?>
							<?php if($filas['iddomicilio']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['iddomicilio'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['iddomicilio'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td class="sticky-column">
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['domicilios']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=clientes&n2=domicilios&n3=consultardomicilios" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['iddomicilio'] ?>"/>
                            <button type="submit" class="btn btn-success btn-xs" value="" title="Modificar"><li class="fa fa-pencil"></li></button>
                		</form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-success btn-xs disabled"><i class="fa fa-pencil"></i></a>
					<?php
                    }
					?>
                </td>
                
                <td class="sticky-column">
                	<a class="btn btn-danger btn-xs" target="_blank" href="https://www.google.com/maps/@<?php echo $filas['coordenadas']?>,19z?hl=es-ES" style="background:#F66; border-color:#F36"><i class="fa fa-crosshairs"></i></a>
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['iddomicilio'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#2ea737 !important; height:120px; padding-top:15px;"><i class="fa fa-map-marker"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Ccalle" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['domicilios']['eliminar'])){ ?>
						<?php if($filas['iddomicilio']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['iddomicilio'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['iddomicilio'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['calle'] ?>
            </span>
    		<span class="info-box-number Cnoexterior" style="font-weight:normal; color:#2ea737;"><?php echo $filas['noexterior'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['colonia'])!=""){
					$composicion=$composicion.", ".$filas['colonia'];
				}
				if (trim($filas['cp'])!=""){
					$composicion=$composicion.", ".$filas['cp'];
				}
				if (trim($filas['ciudad'])!=""){
					$composicion=$composicion.", ".$filas['ciudad'];
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
							if (isset($_SESSION['permisos']['domicilios']['eliminar'])){ ?>
								<?php if($filas['iddomicilio']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['iddomicilio'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['iddomicilio'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['domicilios']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=clientes&n2=domicilios&n3=consultardomicilios" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['iddomicilio'] ?>"/>
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