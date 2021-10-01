<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['sucursales']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Sucursal.class.php');

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

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Osucursal=new Sucursal;
$resultado=$Osucursal->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Osucursal->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#cf2341;"></th>
				<th class="Cidsucursal">Idsucursal</th>
				<th class="Cnombre">Nombre de la sucursal</th>
				<th class="Ccalle">Calle</th>
				<th class="Cnumero">Número</th>
				<th class="Ccolonia">Colonia</th>
				<th class="Ccp">CP</th>
				<th class="Cciudad">Ciudad</th>
				<th class="Cestado">Estado</th>
				<th class="Ctelefonocontacto">Teléfono de contacto</th>
				<th class="Clicenciassa">Licencia SSA</th>
				<th class="Cserie">Serie de facturación</th>
				<th class="Cfolio">Folio de facturación</th>
				<th class="Cidcuentacorreo">Cuenta de correo asignada</th>
				<th class="Carchivofirma">Archivo de firma</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idsucursal'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['sucursales']['eliminar'])){ ?>
                		<?php if($filas['idsucursal']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idsucursal'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idsucursal'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#cf2341;"></td>
				<td class="Cidsucursal"><?php echo $filas['idsucursal']; ?></td>
				<td class="Cnombre"><?php echo $filas['nombre']; ?></td>
				<td class="Ccalle"><?php echo $filas['calle']; ?></td>
				<td class="Cnumero"><?php echo $filas['numero']; ?></td>
				<td class="Ccolonia"><?php echo $filas['colonia']; ?></td>
				<td class="Ccp"><?php echo $filas['cp']; ?></td>
				<td class="Cciudad"><?php echo $filas['ciudad']; ?></td>
				<td class="Cestado"><?php echo $filas['estado']; ?></td>
				<td class="Ctelefonocontacto"><?php echo $filas['telefonocontacto']; ?></td>
				<td class="Clicenciassa"><?php echo $filas['licenciassa']; ?></td>
				<td class="Cserie"><?php echo $filas['serie']; ?></td>
				<td class="Cfolio"><?php echo $filas['folio']; ?></td>
				<td class="Cidcuentacorreo"><?php echo $filas['usuariocuentascorreo']; ?></td>
				<td class="Carchivofirma"><?php echo $filas['archivofirma']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['sucursales']['eliminar'])){
						?>
							<?php if($filas['idsucursal']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idsucursal'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idsucursal'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['sucursales']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=catalogos&n2=sucursales&n3=consultarsucursales" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idsucursal'] ?>"/>
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idsucursal'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#cf2341 !important; height:120px; padding-top:15px;"><i class="fa fa-home"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cnombre" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['sucursales']['eliminar'])){ ?>
						<?php if($filas['idsucursal']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idsucursal'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idsucursal'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['nombre'] ?>
            </span>
    		<span class="info-box-number Cciudad" style="font-weight:normal; color:#cf2341;"><?php echo $filas['ciudad'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['calle'])!=""){
					$composicion=$composicion."".$filas['calle'];
				}
				if (trim($filas['numero'])!=""){
					$composicion=$composicion.", No. ".$filas['numero'];
				}
				if (trim($filas['colonia'])!=""){
					$composicion=$composicion.", Col. ".$filas['colonia'];
				}
				if (trim($filas['cp'])!=""){
					$composicion=$composicion.", C.P. ".$filas['cp'];
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
							if (isset($_SESSION['permisos']['sucursales']['eliminar'])){ ?>
								<?php if($filas['idsucursal']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idsucursal'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idsucursal'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['sucursales']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=catalogos&n2=sucursales&n3=consultarsucursales" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idsucursal'] ?>"/>
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