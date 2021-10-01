<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['archivos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Archivo.class.php');

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
		$campoOrden="fechamodificacion";
	}
}else{
	$campoOrden="fechamodificacion";
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
$Oarchivo=new Archivo;
$resultado=$Oarchivo->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
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
                <th class="columnaDecorada" style="background:#ebbd45;"></th>
				<th class="Cidarchivo">ID</th>
				<th class="Cpdf">Archivo PDF</th>
				<th class="Cxml">Archivo XML</th>
				<th class="Cserie">Serie</th>
				<th class="Cfolio">Folio</th>
				<th class="Ctipo">Tipo</th>
				<th class="Cfechatimbre">Fecha Timbrado</th>
				<th class="Cemisor">Emisor</th>
				<th class="Crfcemisor">RFC Emisor</th>
				<th class="Creceptor">Receptor</th>
				<th class="Crfcreceptor">RFC Receptor</th>
				<th class="Cmonto">Monto</th>
				<th class="Cuuid">UUID</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idarchivo'] ?>" ondblclick="abrirModal(<?php echo $filas['idarchivo'] ?>);">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['archivos']['eliminar'])){ ?>
                		<?php if($filas['idarchivo']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idarchivo'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idarchivo'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#ebbd45;"></td>
				<td class="Cidarchivo"><?php echo $filas['idarchivo']; ?></td>
				<td class="Cpdf"><?php echo $filas['pdf']; ?></td>
				<td class="Cxml"><?php echo $filas['xml']; ?></td>
				<td class="Cserie"><?php echo $filas['serie']; ?></td>
				<td class="Cfolio"><?php echo $filas['folio']; ?></td>
				<td class="Ctipo"><?php echo $filas['tipo']; ?></td>
				<td class="Cfechatimbre"><?php echo $filas['fechatimbre']; ?></td>
				<td class="Cemisor"><?php echo $filas['emisor']; ?></td>
				<td class="Crfcemisor"><?php echo $filas['rfcemisor']; ?></td>
				<td class="Creceptor"><?php echo $filas['receptor']; ?></td>
				<td class="Crfcreceptor"><?php echo $filas['rfcreceptor']; ?></td>
				<td class="Cmonto"><?php echo $filas['monto']; ?></td>
				<td class="Cuuid"><?php echo $filas['uuid']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['archivos']['eliminar'])){
						?>
							<?php if($filas['idarchivo']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idarchivo'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idarchivo'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['archivos']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=archivos&n2=consultararchivos" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idarchivo'] ?>"/>
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idarchivo'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#ebbd45 !important; height:120px; padding-top:15px;"><i class="fa fa-folder-open"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cpdf" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['archivos']['eliminar'])){ ?>
						<?php if($filas['idarchivo']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idarchivo'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idarchivo'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['pdf'] ?>
            </span>
    		<span class="info-box-number Cxml" style="font-weight:normal; color:#ebbd45;"><?php echo $filas['xml'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['fechamodificacion'])!=""){
					$composicion=$composicion."Última modificación: ".$filas['fechamodificacion'];
				}
				if (trim($filas['tablareferencia'])!=""){
					$composicion=$composicion." | Módulo: ".$filas['tablareferencia'];
				}
				if (trim($filas['idreferencia'])!=""){
					$composicion=$composicion." | Referencia: ".$filas['idreferencia'];
				}
				if (trim($filas['uuid'])!=""){
					$composicion=$composicion." | UUID: ".$filas['uuid'];
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
							if (isset($_SESSION['permisos']['archivos']['eliminar'])){ ?>
								<?php if($filas['idarchivo']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idarchivo'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idarchivo'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['archivos']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=archivos&n2=consultararchivos" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idarchivo'] ?>"/>
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