<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['pagos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Pago.class.php');

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
		$campoOrden="idpago";
	}
}else{
	$campoOrden="idpago";
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
$Opago=new Pago;
$resultado=$Opago->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Opago->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#b4d571;"></th>
				<th class="Cidpago">Idpago</th>
				<th class="Cfechapago">Fecha de pago</th>
				<th class="Cformapago">Forma de pago</th>
				<th class="Cmonto">Monto</th>
				<th class="Cdescripcion">Comentarios</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idpago'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['pagos']['eliminar'])){ ?>
                		<?php if($filas['idpago']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idpago'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idpago'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#b4d571;"></td>
				<td class="Cidpago"><?php echo $filas['idpago']; ?></td>
				<?php
				$fechaNfechapago=date_create($filas['fechapago']);
				$nuevaFecha= date_format($fechaNfechapago, 'd/m/Y');
				?>
				<td class="Cfechapago"><?php echo $nuevaFecha; ?></td>
				<td class="Cformapago"><?php echo $filas['formapago']; ?></td>
				<td class="Cmonto"><?php echo $filas['monto']; ?></td>
				<td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['pagos']['eliminar'])){
						?>
							<?php if($filas['idpago']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idpago'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idpago'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['pagos']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=pagos&n2=consultarpagos" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idpago'] ?>"/>
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idpago'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#b4d571 !important; height:120px; padding-top:15px;"><i class="fa fa-dollar"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cidventa" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['pagos']['eliminar'])){ ?>
						<?php if($filas['idpago']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idpago'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idpago'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['idventa'] ?>
            </span>
    		<span class="info-box-number Cfechapago" style="font-weight:normal; color:#b4d571;"><?php echo $filas['fechapago'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['formapago'])!=""){
					$composicion=$composicion."Forma de pago".$filas['formapago'];
				}
				if (trim($filas['descripcion'])!=""){
					$composicion=$composicion." | ".$filas['descripcion'];
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
							if (isset($_SESSION['permisos']['pagos']['eliminar'])){ ?>
								<?php if($filas['idpago']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idpago'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idpago'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['pagos']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=pagos&n2=consultarpagos" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idpago'] ?>"/>
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