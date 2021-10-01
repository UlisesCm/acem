<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['usuarios']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Usuario.class.php');

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
$busqueda=trim($busqueda);
}else{
	$busqueda ="";
}

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Ousuario=new Usuario;
$resultado=$Ousuario->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Ousuario->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#227ee6;"></th>
				<th class="Cidusuario">ID</th>
				<th class="Cnombre">Nombre</th>
				<th class="Cemail">E-mail</th>
				<th class="Cusuario">Usuario</th>
				<th class="Cidperfil">Perfil</th>
				<th class="Cbitacora">Bitácora</th>
                <th class="Csucursal">Sucursal</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idusuario'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['usuarios']['eliminar'])){ ?>
                		<?php if($filas['idusuario']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idusuario'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idusuario'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#227ee6;"></td>
				<td class="Cidusuario"><?php echo $filas['idusuario']; ?></td>
				<td class="Cnombre"><?php echo $filas['nombre']; ?></td>
				<td class="Cemail"><?php echo $filas['email']; ?></td>
				<td class="Cusuario"><?php echo $filas['usuario']; ?></td>
				<td class="Cidperfil"><span class="badge" style="background-color:<?php echo $filas['colorperfiles'];?>"><?php echo $filas['nombreperfiles']; ?></span></td>
				<td class="Cbitacora"><?php echo $filas['bitacora']; ?></td>
                <td class="Cbitacora"><?php echo $filas['nombresucursal']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['usuarios']['eliminar'])){
						?>
							<?php if($filas['idusuario']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idusuario'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idusuario'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['usuarios']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=configuracion&n2=usuarios&n3=usuarios&n4=consultarusuarios" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idusuario'] ?>"/>
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idusuario'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:<?php echo $filas['colorperfiles'] ?> !important; height:120px; padding-top:15px;"><i class="fa fa-user"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cnombre" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['usuarios']['eliminar'])){ ?>
						<?php if($filas['idusuario']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idusuario'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idusuario'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['nombre'] ?>
            </span>
    		<span class="info-box-number Cusuario" style="font-weight:normal; color:<?php echo $filas['colorperfiles'] ?>;"><?php echo $filas['usuario'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['email'])!=""){
					$composicion=$composicion."Email: ".$filas['email'].", Miembro del perfil: ".$filas['nombreperfiles'];
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
							if (isset($_SESSION['permisos']['usuarios']['eliminar'])){ ?>
								<?php if($filas['idusuario']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idusuario'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idusuario'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['usuarios']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=configuracion&n2=usuarios&n3=usuarios&n4=consultarusuarios" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idusuario'] ?>"/>
								<button type="submit" class="btn btn-default"><i class="fa fa-pencil"></i></button>
							</form>
						<?php 
						}else{ ?>
							<a class="btn btn-default disabled"><i class="fa fa-pencil"></i></a>
                        <?php
                        }
						?>
                	</td>
                    
                   <!-- <td style=" padding-right:2px;">
                <?php /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['usuarios']['email']) || $_SESSION['idperfil']=='1'){
                    ?>
                    <form action="../../email/nuevo/nuevo.php" method="post">
                    	<input type="hidden" name="email" value="<?php //echo $filas['email'] ?>"/>
                    	<input type="hidden" name="cliente" value="<?php //echo $filas['nombre'] ?>"/>
                    	<button type="submit" class="btn btn-default" title="Enviar email"><i class="fa fa-envelope-o"></i></button>
                    </form>
                <?php } ?>
                	</td>-->
                    
                    <td style=" padding-right:2px;">
            	<?php /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['usuarios']['bloquear']) || $_SESSION['idperfil']=='1'){
                    ?>
                        <?php if($filas['idperfil']==1){ ?>
                        	<a id="bloquear<?php echo $filas['idusuario'] ?>" class="btn btn-default disabled"><i class="fa fa-lock"></i></a>
                            
                        <?php }else{ ?>
                            <?php if($filas['estado']=="activo"){ ?>
                            	<a id="bloquear<?php echo $filas['idusuario'] ?>" class="btn btn-default bloquear" onclick="bloquear(<?php echo $filas['idusuario'] ?>);" title="Bloquear"><i class='fa fa-lock'></i></a>
                            <?php }else{ ?>
                            	<a id="bloquear<?php echo $filas['idusuario'] ?>" class="btn btn-default desbloquear" onclick="bloquear(<?php echo $filas['idusuario'] ?>);" title="Desbloquear"><i class='fa fa-unlock'></i></a>
                                
                            <?php } ?>
                        <?php } ?>
                <?php } ?>
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