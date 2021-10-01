<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['bitacoracontrol']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Bitacoracontrol.class.php');

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
		$campoOrden="idbitacoracontrol";
	}
}else{
	$campoOrden="idbitacoracontrol";
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
$Obitacoracontrol=new Bitacoracontrol;
$resultado=$Obitacoracontrol->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Obitacoracontrol->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#606060;"></th>
				<th class="Cidbitacoracontrol">Idbitacoracontrol</th>
				<th class="Cfecha">Fecha</th>
				<th class="Chora">Hora</th>
				<th class="Cidusuario">Idusuario</th>
				<th class="Cmodulo">Modulo</th>
				<th class="Caccion">Accion</th>
				<th class="Cdescripcion">Descripcion</th>
				<th class="Cidregistro">Idregistro</th>
				<th class="Ctabla">Tabla</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysql_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idbitacoracontrol'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['bitacoracontrol']['eliminar'])){ ?>
                		<?php if($filas['idbitacoracontrol']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idbitacoracontrol'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idbitacoracontrol'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#606060;"></td>
				<td class="Cidbitacoracontrol"><?php echo $filas['idbitacoracontrol']; ?></td>
				<td class="Cfecha"><?php echo $filas['fecha']; ?></td>
				<td class="Chora"><?php echo $filas['hora']; ?></td>
				<td class="Cidusuario"><?php echo $filas['idusuario']; ?></td>
				<td class="Cmodulo"><?php echo $filas['modulo']; ?></td>
				<td class="Caccion"><?php echo $filas['accion']; ?></td>
				<td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
				<td class="Cidregistro"><?php echo $filas['idregistro']; ?></td>
				<td class="Ctabla"><?php echo $filas['tabla']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['bitacoracontrol']['eliminar'])){
						?>
							<?php if($filas['idbitacoracontrol']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idbitacoracontrol'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idbitacoracontrol'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['bitacoracontrol']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=bitacoracontrol&n2=consultarbitacoracontrol" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idbitacoracontrol'] ?>"/>
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
	while ($filas=mysql_fetch_array($resultado)) {		
?>
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idbitacoracontrol'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#606060 !important; height:120px; padding-top:15px;"><i class="fa fa-Hejemplo.png"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cidbitacoracontrol" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['bitacoracontrol']['eliminar'])){ ?>
						<?php if($filas['idbitacoracontrol']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idbitacoracontrol'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idbitacoracontrol'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['idbitacoracontrol'] ?>
            </span>
    		<span class="info-box-number Cidbitacoracontrol" style="font-weight:normal; color:#606060;"><?php echo $filas['idbitacoracontrol'] ?></span>
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
							if (isset($_SESSION['permisos']['bitacoracontrol']['eliminar'])){ ?>
								<?php if($filas['idbitacoracontrol']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idbitacoracontrol'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idbitacoracontrol'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['bitacoracontrol']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=bitacoracontrol&n2=consultarbitacoracontrol" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idbitacoracontrol'] ?>"/>
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
if(mysql_num_rows($resultado)==0){
	include("../../../componentes/mensaje_no_hay_registros.php");
}
?>