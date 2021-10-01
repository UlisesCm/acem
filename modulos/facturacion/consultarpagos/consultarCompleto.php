<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['facturacion']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Facturacion.class.php');

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
$Ofacturacion=new Facturacion;
$resultado=$Ofacturacion->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Ofacturacion->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#da123f;"></th>
				<th class="Cidfactura">Idfactura</th>
				<th class="Cfoliointerno">Folio</th>
				<th class="Cfecha">Fecha</th>
				<th class="Ctipo">Tipo</th>
				<th class="Cclasificacion">Clasificación</th>
				<th class="Cemisor">Emisor</th>
				<th class="Crfcemisor">RFC Emisor</th>
				<th class="Creceptor">Receptor</th>
				<th class="Crfcreceptor">RFC Receptor</th>
				<th class="Cmontototal">Monto total</th>
				<th class="Cmontopagado">Monto pagado</th>
				<th class="Cestado">Estado</th>
				<th class="Cfechapago">Fecha de pago</th>
				<th class="Cformapago">Forma de pago</th>
				<th class="Ccuenta">Cuenta</th>
				<th class="Cfoliofiscal">UUID</th>
				<th class="Cobservaciones">Observaciones</th>
				<th class="Crelaciones">Relaciones</th>
				<th class="Carchivo">Archivo</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idfactura'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['facturacion']['eliminar'])){ ?>
                		<?php if($filas['idfactura']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idfactura'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idfactura'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#da123f;"></td>
				<td class="Cidfactura"><?php echo $filas['idfactura']; ?></td>
				<td class="Cfoliointerno"><?php echo $filas['foliointerno']; ?></td>
				<?php
				$fechaNfecha=date_create($filas['fecha']);
				$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
				?>
				<td class="Cfecha"><?php echo $nuevaFecha; ?></td>
				<td class="Ctipo"><?php echo $filas['tipo']; ?></td>
				<td class="Cclasificacion"><?php echo $filas['clasificacion']; ?></td>
				<td class="Cemisor"><?php echo $filas['emisor']; ?></td>
				<td class="Crfcemisor"><?php echo $filas['rfcemisor']; ?></td>
				<td class="Creceptor"><?php echo $filas['receptor']; ?></td>
				<td class="Crfcreceptor"><?php echo $filas['rfcreceptor']; ?></td>
				<td class="Cmontototal"><?php echo $filas['montototal']; ?></td>
				<td class="Cmontopagado"><?php echo $filas['montopagado']; ?></td>
				<td class="Cestado"><?php echo $filas['estado']; ?></td>
				<?php
				$fechaNfechapago=date_create($filas['fechapago']);
				$nuevaFecha= date_format($fechaNfechapago, 'd/m/Y');
				?>
				<td class="Cfechapago"><?php echo $nuevaFecha; ?></td>
				<td class="Cformapago"><?php echo $filas['formapago']; ?></td>
				<td class="Ccuenta"><?php echo $filas['cuenta']; ?></td>
				<td class="Cfoliofiscal"><?php echo $filas['foliofiscal']; ?></td>
				<td class="Cobservaciones"><?php echo $filas['observaciones']; ?></td>
				<td class="Crelaciones"><?php echo $filas['relaciones']; ?></td>
				<td class="Carchivo"><?php echo $filas['archivo']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['facturacion']['eliminar'])){
						?>
							<?php if($filas['idfactura']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idfactura'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idfactura'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['facturacion']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=facturacion&n2=consultarfacturacion" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idfactura'] ?>"/>
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idfactura'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#da123f !important; height:120px; padding-top:15px;"><i class="fa fa-clipboard"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Creceptor" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['facturacion']['eliminar'])){ ?>
						<?php if($filas['idfactura']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idfactura'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idfactura'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['receptor'] ?>
            </span>
    		<span class="info-box-number Crfcreceptor" style="font-weight:normal; color:#da123f;"><?php echo $filas['rfcreceptor'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['foliointerno'])!=""){
					$composicion=$composicion."Folio: ".$filas['foliointerno'];
				}
				if (trim($filas['fecha'])!=""){
					$composicion=$composicion.", Fecha: ".$filas['fecha'];
				}
				if (trim($filas['montototal'])!=""){
					$composicion=$composicion.", Monto: $".$filas['montototal'];
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
							if (isset($_SESSION['permisos']['facturacion']['eliminar'])){ ?>
								<?php if($filas['idfactura']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idfactura'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idfactura'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['facturacion']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=facturacion&n2=consultarfacturacion" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idfactura'] ?>"/>
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