<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
require('../Listaprecios.class.php');

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
		$campoOrden="idprecio";
	}
}else{
	$campoOrden="idprecio";
}

if (isset($_REQUEST['idlistaprecios']) && $_REQUEST['idlistaprecios'] !="") {
	if($_REQUEST['idlistaprecios']!="undefined"){
		$idlistaprecios = htmlentities($_REQUEST['idlistaprecios']);
	}else{
		$idlistaprecios="0";
	}
}else{
	$idlistaprecios="0";
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
$Oprecios=new Listaprecios;
$resultado=$Oprecios->mostrarPrecios($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idlistaprecios);
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
                <th class="columnaDecorada" style="background:#000000;"></th>
				<th class="Cidprecio">ID</th>
				<th class="Cidreferencia">Referencia</th>
				<th class="Cdescripcion">Descripción</th>
                <th class="Ccosto">Costo</th>
                <th width="40"></th>
                <th class="Ccosto">Utilidad (%)</th>
                <th class="Ccosto" style="display:none">Descuento (%)</th>
				<th class="Cpreciopublico">Precio</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) {
		$marcadorCosto="";
		$precio=$filas['precio'];
		$costo=$filas['costo'];
		$utilidad=$filas['porcentajeutilidad'];
		
		if(round($costo,4)!=round($filas['costoproducto'],4)){
			$marcadorCosto="
			<span data-placement='bottom' data-toggle='tooltip' data-html='true' title='' data-original-title='<b>El costo aplicado es distinto al costo promedio actual ($".number_format($filas['costoproducto'],2).")</b>'>
				<i class='fa fa-warning text-yellow'></i>
			</span>
			";
		}
		
		if (round($precio,4)!=round($costo*(($utilidad/100)+1),4)){
			$marcadorCosto="
			<span data-placement='bottom' data-toggle='tooltip' data-html='true' title='' data-original-title='<b>El porcentaje de utilidad no coincide con el precio</b>'>
				<i class='fa fa-warning text-red'></i>
			</span>
			";
		}
		
		
		
		
	
	?>
      		<tr id="iregistro<?php echo $filas['idprecio'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['precios']['eliminar'])){ ?>
                		<?php if($filas['idprecio']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idprecio'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idprecio'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#000000;"></td>
				<td class="Cidprecio"><?php echo $filas['idprecio']; ?></td>
				<td class="Cidreferencia"><?php echo $filas['idreferencia']; ?></td>
				<td class="Cdescripcion"><?php echo $filas['nombreproducto']; ?></td>
                <td class="Ccosto">
                <input value="<?php echo $filas['costo']; ?>" name="costo<?php echo $filas['idprecio']; ?>" type="text" class="caja" id="costo<?php echo $filas['idprecio']; ?>" onblur="actualizarDato('costo<?php echo $filas['idprecio']; ?>','costo','<?php echo $filas['idprecio']; ?>')" onkeypress="return soloNumeros(event,'costo<?php echo $filas['idprecio']; ?>');" disabled="disabled" style="color:#999">
                </td>
                <td class="Ccosto">
                <?php echo $marcadorCosto;?>
                </td>
                <td class="Cporcentajeutilidad">
                <input value="<?php echo $filas['porcentajeutilidad']; ?>" name="porcentajeutilidad<?php echo $filas['idprecio']; ?>" type="text" class="caja" id="porcentajeutilidad<?php echo $filas['idprecio']; ?>" onblur="actualizarDato('porcentajeutilidad<?php echo $filas['idprecio']; ?>','porcentajeutilidad','<?php echo $filas['idprecio']; ?>')" onkeypress="return soloNumeros(event,'porcentajeutilidad<?php echo $filas['idprecio']; ?>');">
                </td>
                <td class="Cporcentajedescuento" style="display:none">
                <input value="<?php echo $filas['porcentajedescuento']; ?>" name="porcentajedescuento<?php echo $filas['idprecio']; ?>" type="text" class="caja" id="porcentajedescuento<?php echo $filas['idprecio']; ?>" onblur="actualizarDato('porcentajedescuento<?php echo $filas['idprecio']; ?>','porcentajedescuento','<?php echo $filas['idprecio']; ?>')" onkeypress="return soloNumeros(event,'porcentajedescuento<?php echo $filas['idprecio']; ?>');">
                </td>
				<td class="Cprecio">
                <input value="<?php echo $filas['precio']; ?>" name="precio<?php echo $filas['idprecio']; ?>" type="text" class="caja" id="precio<?php echo $filas['idprecio']; ?>" onblur="actualizarDato('precio<?php echo $filas['idprecio']; ?>','precio','<?php echo $filas['idprecio']; ?>')" onkeypress="return soloNumeros(event,'precio<?php echo $filas['idprecio']; ?>');">
                </td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['precios']['eliminar'])){
						?>
							<?php if($filas['idprecio']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idprecio'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idprecio'] ?>))"><li class="fa fa-recycle"></li></a>
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
                			<input type="hidden" name="id" value="<?php echo $filas['idprecio'] ?>"/>
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