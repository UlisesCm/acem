<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['traspasos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Traspaso.class.php');

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
		$campoOrden="fechasalida";
	}
}else{
	$campoOrden="fechasalida";
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
$Otraspaso=new Traspaso;
$resultado=$Otraspaso->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
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
                <th class="columnaDecorada" style="background:#d70207;"></th>
				<th class="Cidtraspaso">ID</th>
				<th class="Cidmovimiento">Movimiento</th>
				<th class="Cidsucursalorigen">Sucursal origen</th>
				<th class="Cidsucursaldestino">Sucursal destino</th>
				<th class="Cfechasalida">Fecha Salida</th>
				<th class="Cfechaentrada">Fecha Entrada</th>
				<th class="Cestado">Estado</th>
				<th class="Cnumerocomprobante">Número Comprobante</th>
				<th class="Cidusuariosalida">Usuario salida</th>
				<th class="Cidusuarioentrada">Usuario entrada</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idtraspaso'] ?>" ondblclick="abrirModal(<?php echo $filas['idtraspaso'] ?>);">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['traspasos']['eliminar'])){ ?>
                		<?php if($filas['idtraspaso']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idtraspaso'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idtraspaso'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#d70207;"></td>
				<td class="Cidtraspaso"><?php echo $filas['idtraspaso']; ?></td>
				<td class="Cidmovimiento"><?php echo $filas['idmovimiento']; ?></td>
				<td class="Cidsucursalorigen"><?php echo $filas['idsucursalorigen']; ?></td>
				<td class="Cidsucursaldestino"><?php echo $filas['idsucursaldestino']; ?></td>
				<?php
				$fechaNfechasalida=date_create($filas['fechasalida']);
				$nuevaFecha= date_format($fechaNfechasalida, 'd/m/Y');
				?>
				<td class="Cfechasalida"><?php echo $nuevaFecha; ?></td>
				<?php
				$fechaNfechaentrada=date_create($filas['fechaentrada']);
				$nuevaFecha= date_format($fechaNfechaentrada, 'd/m/Y');
				?>
				<td class="Cfechaentrada"><?php echo $nuevaFecha; ?></td>
				<td class="Cestado"><?php echo $filas['estado']; ?></td>
				<td class="Cnumerocomprobante"><?php echo $filas['numerocomprobante']; ?></td>
				<td class="Cidusuariosalida"><?php echo $filas['idusuariosalida']; ?></td>
				<td class="Cidusuarioentrada"><?php echo $filas['idusuarioentrada']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['traspasos']['eliminar'])){
						?>
							<?php if($filas['idtraspaso']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idtraspaso'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idtraspaso'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['traspasos']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=traspasos&n2=consultartraspasos" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idtraspaso'] ?>"/>
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idtraspaso'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#d70207 !important; height:120px; padding-top:15px;"><i class="fa fa-exchange"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cidsucursalorigen" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['traspasos']['eliminar'])){ ?>
						<?php if($filas['idtraspaso']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idtraspaso'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idtraspaso'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['idsucursalorigen'] ?>
            </span>
    		<span class="info-box-number Cestado" style="font-weight:normal; color:#d70207;"><?php echo $filas['estado'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['numerocomprobante'])!=""){
					$composicion=$composicion."( ".$filas['numerocomprobante'];
				}
				if (trim($filas['numerocomprobante'])!=""){
					$composicion=$composicion.") Estado: ".$filas['numerocomprobante'];
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
							if (isset($_SESSION['permisos']['traspasos']['eliminar'])){ ?>
								<?php if($filas['idtraspaso']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idtraspaso'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idtraspaso'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['traspasos']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=traspasos&n2=consultartraspasos" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idtraspaso'] ?>"/>
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