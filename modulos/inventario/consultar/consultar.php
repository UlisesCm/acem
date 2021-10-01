<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['inventario']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Inventario.class.php');

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
		$campoOrden="idproducto";
	}
}else{
	$campoOrden="idproducto";
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

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Oinventario=new Inventario;
$resultado=$Oinventario->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
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
                <th class="columnaDecorada" style="background:#3972ce;"></th>
				<th class="Cidinventario" style="display:none">ID</th>
                <th class="Cidproducto">ID</th>
                <th class="Cidproducto" style="display:none">Serie</th>
				<th class="Cidproducto">Producto</th>
				<th class="Cexistencia">Existencia</th>
				<th class="Cpromedio">Costo Promedio</th>
				<th class="Csaldo">Saldo</th>
				<th class="Cminimo" style="display:none">Stock Mínimo</th>
				<th class="Cubicacion" style="display:none">Ubicación</th>
				<th class="Cestado">Estatus</th>
				<th width="40" style="display:none"></th>
                <th width="40" style="display:none"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) {
		$colorEstado="#096";
		if ($filas['estado']!="Costo correctamente calculado"){
			$colorEstado="#E80941";
		}
		?>
      		<tr id="iregistro<?php echo $filas['idinventario'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['inventario']['eliminar'])){ ?>
                		<?php if($filas['idinventario']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idinventario'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idinventario'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#3972ce;"></td>
                <td class="Cidinventario" style="display:none"><?php echo $filas['idinventario']; ?></td>
                <td class="Cidproducto"><?php echo $filas['idproducto']; ?></td>
                <td class="Cidproducto" style="display:none"><?php echo $filas['modeloproductos']; ?></td>
				<td class="Cidproducto"><b><?php echo $filas['nombreproductos']; ?></b></td>
				<td class="Cexistencia"><span class="badge" style="background:#3972ce"><?php echo number_format($filas['existencia'],2); ?></span></td>
				<td class="Cpromedio"><?php echo "$".number_format($filas['promedio'],2); ?></td>
				<td class="Csaldo"><?php echo "$".number_format($filas['saldo'],2); ?></td>
				<td class="Cminimo" style="display:none"><?php echo $filas['minimo']; ?></td>
				<td class="Cubicacion" style="display:none"><?php echo $filas['ubicacion']; ?></td>
				<td class="Cestado"><small style="color:<?php echo $colorEstado;?>"><i><?php echo $filas['estado']; ?></i></small></td>
        		<td style="display:none">
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['inventario']['eliminar'])){
						?>
							<?php if($filas['idinventario']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idinventario'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idinventario'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td style="display:none">
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['inventario']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=inventario&n2=consultarinventario" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idinventario'] ?>"/>
                            <button type="submit" class="btn btn-success btn-xs" value="" title="Modificar"><li class="fa fa-pencil"></li></button>
                		</form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-success btn-xs disabled"><i class="fa fa-pencil"></i></a>
					<?php
                    }
					?>
                </td>
                <td style="display:none">
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['inventario']['cambiarubicacion'])){
					?>
						<form action="../modificarubicacion/actualizar.php?n1=inventario&n2=consultarinventario" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idinventario'] ?>"/>
                            <button type="submit" class="btn btn-primary btn-xs" value="" title="Modificar"><li class="fa fa-crosshairs"></li></button>
                		</form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-primary btn-xs disabled"><i class="fa fa-crosshairs"></i></a>
					<?php
                    }
					?>
                </td>
                
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['inventario']['cambiarubicacion'])){
					?>
						<form action="../../kardex/consultardetalles/vista.php?n1=movimientos&n2=inventario&n3=consultarkardex&idproducto=0&idalmacen=2951911570065" method="post">
                			<input type="hidden" name="idproducto" value="<?php echo $filas['idproducto'] ?>"/>
                            <input type="hidden" name="idsucursal" value="<?php echo $_SESSION['idsucursal'] ?>"/>
                            <button type="submit" class="btn btn-primary btn-xs" value="" title="Consultar Kardex"><li class="fa fa-crosshairs"></li></button>
                		</form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-primary btn-xs disabled"><i class="fa fa-crosshairs"></i></a>
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idinventario'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#3972ce !important; height:120px; padding-top:15px;"><i class="fa fa-server"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cidproducto" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['inventario']['eliminar'])){ ?>
						<?php if($filas['idinventario']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idinventario'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idinventario'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['nombreproductos'] ?>
            </span>
    		<span class="info-box-number Cexistencia" style="font-weight:normal; color:#3972ce;"><?php echo $filas['existencia'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['codigoproductos'])!=""){
					$composicion=$composicion."Código: ".$filas['codigoproductos'];
				}
				if (trim($filas['promedio'])!=""){
					$composicion=$composicion.", Costo promedio: $".$filas['promedio'];
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
							if (isset($_SESSION['permisos']['inventario']['eliminar'])){ ?>
								<?php if($filas['idinventario']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idinventario'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idinventario'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px; display:none">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['inventario']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=inventario&n2=consultarinventario" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idinventario'] ?>"/>
								<button type="submit" class="btn btn-default"><i class="fa fa-pencil"></i></button>
							</form>
						<?php 
						}else{ ?>
							<a class="btn btn-default disabled"><i class="fa fa-pencil"></i></a>
                        <?php
                        }
						?>
                	</td>
                    
                    <td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['inventario']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=inventario&n2=consultarinventario" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idinventario'] ?>"/>
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