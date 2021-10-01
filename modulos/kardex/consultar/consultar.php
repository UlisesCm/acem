<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['kardex']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Kardex.class.php');

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
$busqueda=mysql_real_escape_string($busqueda);
}else{
	$busqueda ="";
}

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Okardex=new Kardex;
$resultado=$Okardex->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Okardex->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#d90052;"></th>
				<th class="Cidkardex">Idkardex</th>
				<th class="Cidproducto">Producto</th>
				<th class="Cfechamovimiento">Fecha de movimiento</th>
				<th class="Cdescripcion">Descripción</th>
				<th class="Cobservaciones">Observaciones</th>
				<th class="Centrada">Entradas</th>
				<th class="Csalida">Salidas</th>
				<th class="Cexistencia">Existencias</th>
				<th class="Ccostounitario">Costo Unitario</th>
				<th class="Cpromedio">Costo Promedio</th>
				<th class="Cdebe">Debe</th>
				<th class="Chaber">Haber</th>
				<th class="Csaldo">Saldo</th>
				<th class="Cidalmacen">Almacén</th>
				<th class="Cidmovimiento">No.Movimiento</th>
				<th class="Cidreferencia">Referencia</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idkardex'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['kardex']['eliminar'])){ ?>
                		<?php if($filas['idkardex']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idkardex'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idkardex'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#d90052;"></td>
				<td class="Cidkardex"><?php echo $filas['idkardex']; ?></td>
				<td class="Cidproducto"><?php echo $filas['idproducto']; ?></td>
				<?php
				$fechaNfechamovimiento=date_create($filas['fechamovimiento']);
				$nuevaFecha= date_format($fechaNfechamovimiento, 'd/m/Y');
				?>
				<td class="Cfechamovimiento"><?php echo $nuevaFecha; ?></td>
				<td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
				<td class="Cobservaciones"><?php echo $filas['observaciones']; ?></td>
				<td class="Centrada"><?php echo $filas['entrada']; ?></td>
				<td class="Csalida"><?php echo $filas['salida']; ?></td>
				<td class="Cexistencia"><?php echo $filas['existencia']; ?></td>
				<td class="Ccostounitario"><?php echo $filas['costounitario']; ?></td>
				<td class="Cpromedio"><?php echo $filas['promedio']; ?></td>
				<td class="Cdebe"><?php echo $filas['debe']; ?></td>
				<td class="Chaber"><?php echo $filas['haber']; ?></td>
				<td class="Csaldo"><?php echo $filas['saldo']; ?></td>
				<td class="Cidalmacen"><?php echo $filas['idalmacen']; ?></td>
				<td class="Cidmovimiento"><?php echo $filas['idmovimiento']; ?></td>
				<td class="Cidreferencia"><?php echo $filas['idreferencia']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['kardex']['eliminar'])){
						?>
							<?php if($filas['idkardex']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idkardex'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idkardex'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['kardex']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=kardex&n2=consultarkardex" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idkardex'] ?>"/>
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idkardex'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#d90052 !important; height:120px; padding-top:15px;"><i class="fa fa-history"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cidkardex" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['kardex']['eliminar'])){ ?>
						<?php if($filas['idkardex']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idkardex'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idkardex'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['idkardex'] ?>
            </span>
    		<span class="info-box-number Cidkardex" style="font-weight:normal; color:#d90052;"><?php echo $filas['idkardex'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
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
							if (isset($_SESSION['permisos']['kardex']['eliminar'])){ ?>
								<?php if($filas['idkardex']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idkardex'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idkardex'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['kardex']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=kardex&n2=consultarkardex" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idkardex'] ?>"/>
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