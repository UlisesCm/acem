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
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Oinventario->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#3972ce;"></th>
				<th class="Cidinventario" style="display:none">ID</th>
                <th class="Cidalmacen">Almacén</th>
                <th class="Cidproducto">Código</th>
                <th class="Cidproducto">Serie</th>
				<th class="Cidproducto">Producto</th>
				<th class="Cexistencia">Existencia Nueva</th>
                <th class="Cexistencia">Existencia Vieja</th>
                <th class="Csaldo">Diferencia</th>
				<th class="Cpromedio">Costo Promedio</th>
				<th width="40"></th>
                <th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) {
		$existenciaVieja=$Oinventario->obtenerDatoViejo($filas['idalmacen'],$filas['idproducto'],"existencia");
		$diferencia=$filas['existencia']-$existenciaVieja;
		if ($diferencia==0){
			$colorExistencia="#096";
		}else if($diferencia>0){
			$colorExistencia="#F90";
		}else if ($diferencia<0){
			$colorExistencia="#F03";
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
                <td class="Cidalmacen"><?php echo $filas['nombrealmacenes']; ?></td>
                <td class="Cidproducto"><?php echo $filas['codigoproductos']; ?></td>
                <td class="Cidproducto"><?php echo $filas['modeloproductos']; ?></td>
				<td class="Cidproducto"><?php echo $filas['nombreproductos']; ?></td>
               	<td class="Cexistencia"><?php echo $filas['existencia']; ?></td>
				<td class="Cexistencia"><?php echo $existenciaVieja ?></td>
                <td class="Cexistencia"><span class="badge" style="background:<?php echo $colorExistencia?>"><?php echo $diferencia; ?></span></td>
				<td class="Cpromedio"><?php echo $filas['promedio']; ?></td>
        		<td>
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
                <td>
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
                <td>
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
			<?php echo $filas['idproducto'] ?>
            </span>
    		<span class="info-box-number Cexistencia" style="font-weight:normal; color:#3972ce;"><?php echo $filas['existencia'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['idalmacen'])!=""){
					$composicion=$composicion."Almacén: ".$filas['idalmacen'];
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