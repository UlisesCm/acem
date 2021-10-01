<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
require('../Proveedor.class.php');

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
		$campoOrden="idpreciocompra";
	}
}else{
	$campoOrden="idpreciocompra";
}

if (isset($_REQUEST['idproveedor']) && $_REQUEST['idproveedor'] !="") {
	if($_REQUEST['idproveedor']!="undefined"){
		$idproveedor = htmlentities($_REQUEST['idproveedor']);
	}else{
		$idproveedor="0";
	}
}else{
	$idproveedor="0";
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
		$cantidadamostrar="2";
	}
}else{
	$cantidadamostrar="2";
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
$Oprecios=new Proveedor;
$resultado=$Oprecios->mostrarPrecios($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idproveedor);
$filasTotales=$resultado[1];
$resultado=$resultado[0];
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#F90;"></th>
				<th class="Cidprecio">ID</th>
				<th class="Cidproducto">Producto</th>
				<th class="Cclaveproductoproveedor">Codigo de proveedor</th>
                <th class="Cprecio1">Precio 1</th>
                <th class="Ccondicioncantidad1" style="display:none">Condicion Cantidad 1</th>
                <th class="Ccondicionpeso1" style="display:none">Condicion Peso 1</th>
                <th class="Cprecio2" style="display:none">Precio 2</th>
                <th class="Ccondicioncantidad2" style="display:none">Condicion Cantidad 2</th>
                <th class="Ccondicionpeso2" style="display:none">Condicion Peso 2</th>
                <th class="Cprecio3" style="display:none">Precio 3</th>
                <th class="Ccondicioncantidad3" style="display:none">Condicion Cantidad 3</th>
                <th class="Ccondicionpeso3" style="display:none">Condicion Peso 3</th>
                <th class="Cprecio4" style="display:none">Precio 4</th>
                <th class="Ccondicioncantidad4" style="display:none">Condicion Cantidad 4</th>
                <th class="Ccondicionpeso4" style="display:none">Condicion Peso 4</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="idregistro<?php echo $filas['idpreciocompra'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['precios']['eliminar'])){ ?>
                		<?php if($filas['idpreciocompra']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idpreciocompra'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idpreciocompra'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#F90;"></td>
				<td class="Cidprecio"><?php echo $filas['idpreciocompra']; ?></td>
				<td class="Cidreferencia"><?php echo $filas['nombreproducto']; ?></td>
				<td class="Ccodigo">
                <input value="<?php echo $filas['claveproductoproveedor']; ?>" name="claveproductoproveedor<?php echo $filas['idpreciocompra']; ?>" type="text" class="caja" id="claveproductoproveedor<?php echo $filas['idpreciocompra']; ?>" onblur="actualizarDato('claveproductoproveedor<?php echo $filas['idpreciocompra']; ?>','claveproductoproveedor','<?php echo $filas['idpreciocompra']; ?>')"  style="color:#C63">
                </td>
                <td class="Cprecio1">
                <input value="<?php echo $filas['precio1']; ?>" name="precio1<?php echo $filas['idpreciocompra']; ?>" type="text" class="caja initR" id="precio1<?php echo $filas['idpreciocompra']; ?>" onblur="actualizarDato('precio1<?php echo $filas['idpreciocompra']; ?>','precio1','<?php echo $filas['idpreciocompra']; ?>')" onkeypress="return soloNumeros(event,'precio1<?php echo $filas['idpreciocompra']; ?>');"> <a class="btn btn-default btn-xs initR" onclick="abrirModal('<?php echo $filas['idpreciocompra'] ?>','1');"><i class="fa fa-magnet text-red"></i></a>
                </td>
                <td id="cc1<?php echo $filas['idpreciocompra'] ?>"class="Ccondicioncantidad1" style="display:none"><?php echo $filas['condicioncantidad1']; ?></td>
               <td id="cp1<?php echo $filas['idpreciocompra'] ?>" class="Ccondicionpeso1" style="display:none"><?php echo $filas['condicionpeso1']; ?></td>
               
               <td class="Cprecio2" style="display:none">
                <input value="<?php echo $filas['precio2']; ?>" name="precio2<?php echo $filas['idpreciocompra']; ?>" type="text" class="caja initR" id="precio2<?php echo $filas['idpreciocompra']; ?>" onblur="actualizarDato('precio2<?php echo $filas['idpreciocompra']; ?>','precio2','<?php echo $filas['idpreciocompra']; ?>')" onkeypress="return soloNumeros(event,'precio2<?php echo $filas['idpreciocompra']; ?>');"> <a class="btn btn-default btn-xs initR"><i class="fa fa-magnet text-red"></i></a>
                </td>
                <td class="Ccondicioncantidad2" style="display:none"><?php echo $filas['condicioncantidad2']; ?></td>
               <td class="Ccondicionpeso2" style="display:none"><?php echo $filas['condicionpeso2']; ?></td>
               
               <td class="Cprecio3" style="display:none">
                <input value="<?php echo $filas['precio3']; ?>" name="precio3<?php echo $filas['idpreciocompra']; ?>" type="text" class="caja initR" id="precio3<?php echo $filas['idpreciocompra']; ?>" onblur="actualizarDato('precio3<?php echo $filas['idpreciocompra']; ?>','precio3','<?php echo $filas['idpreciocompra']; ?>')" onkeypress="return soloNumeros(event,'precio3<?php echo $filas['idpreciocompra']; ?>');"> <a class="btn btn-default btn-xs initR"><i class="fa fa-magnet text-red"></i></a>
                </td>
                <td class="Ccondicioncantidad3" style="display:none"><?php echo $filas['condicioncantidad3']; ?></td>
               <td class="Ccondicionpeso3" style="display:none"><?php echo $filas['condicionpeso3']; ?></td>
               
               <td class="Cprecio4" style="display:none">
                <input value="<?php echo $filas['precio4']; ?>" name="precio4<?php echo $filas['idpreciocompra']; ?>" type="text" class="caja initR" id="precio4<?php echo $filas['idpreciocompra']; ?>" onblur="actualizarDato('precio4<?php echo $filas['idpreciocompra']; ?>','precio4','<?php echo $filas['idpreciocompra']; ?>')" onkeypress="return soloNumeros(event,'precio4<?php echo $filas['idpreciocompra']; ?>');"> <a class="btn btn-default btn-xs initR"><i class="fa fa-magnet text-red"></i></a>
                </td>
                <td class="Ccondicioncantidad4" style="display:none"><?php echo $filas['condicioncantidad4']; ?></td>
               <td class="Ccondicionpeso4" style="display:none"><?php echo $filas['condicionpeso4']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['precios']['eliminar'])){
						?>
							<?php if($filas['idpreciocompra']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idpreciocompra'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idpreciocompra'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['precios']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=precios&n2=consultarprecios" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idpreciocompra'] ?>"/>
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


</div>
<?php 
paginar($pg, $cantidadamostrar, $filasTotales, $campoOrden, $orden, $busqueda, $tipoVista);
//FIN DEL CODIGO DE PAGINACION
if(mysqli_num_rows($resultado)==0){
	include("../../../componentes/mensaje_no_hay_registros.php");
}
?>