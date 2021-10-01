<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['cuentasporpagar']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Gasto.class.php');

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
		$campoOrden="idproveedor";
	}
}else{
	$campoOrden="idproveedor";
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
$Ogasto=new Gasto;
$resultado=$Ogasto->mostrarComprasCancelar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Ogasto->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
 <form class="form-horizontal" name="formulario" id="formulario" method="post">
    <div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered" id="tablaCompras">
        	<tr>
                <th class="columnaDecorada" style="background:#ef7769;"></th>
				<th class="Cidcompra" style="display:none">ID</th>
                <th class="Cfechacompra">Fecha factura</th>
                <th class="Cfechavencimientocompra">Fecha vencimiento</th>
				<th class="Cidproveedor">Proveedor</th>
                <th class="Cdescripcion">Descripcion</th>
				<th class="Cfactura">Factura</th>
				<th class="Ctotal">Total</th>
                <th width="40"></th>
      		</tr>
	<?php
	$con=0;
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idcompra'] ?>">
        		
                <td class="columnaDecorada" style="background:#ef7769;"></td>
				<td class="Cidcompra" style="display:none"><?php echo $filas['idcompra']; ?></td>
                <td class="Cfechafacturacompra"><?php echo $filas['fecha']; ?></td>
                <td class="Cfechavencimientocompra"><?php echo $filas['fechavencimiento']; ?></td>
				<td class="Cidproveedorcompra"><?php echo $Ogasto->ObtenerDatosProveedor($filas['idprov']); ?></td>
				<td class="Ccomentarioscompra"><?php echo $filas['comentarios']; ?></td>
				<td class="Cfacturacompra"></td>
				<td class="Ctotal" id="<?php echo "totalcompras".$con ?>"><?php echo $filas['monto']; ?></td>
                <td>
					<?php /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['cuentasporpagar']['eliminar'])){
                    ?>
                      <a class="btn btn-danger btn-xs" title="Cancelar" onclick="(eliminarIndividual(<?php echo $filas['idcompra'] ?>))"><li class="fa fa-close"></li></a>
                    <?php 
                    }else{ ?>
                        <a class="btn btn-danger btn-xs disabled"><i class="fa fa-close"></i></a>
                    <?php
                    }
                    ?>
                </td>
      		</tr>
    <?php 
	$con++;
	}//Fin de while si es tabla ?>
		</table>
        
	 <?php if(mysqli_num_rows($resultado)==0){
		include("../../../componentes/mensaje_no_hay_registros.php");
		}
     ?>
	</div><!-- /.box-body -->
     
     <input value="" name="listaSalida" type="hidden" class="form-control"  id="listaSalida" />
<?php


//TABLA GASTOS
//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$resultado=$Ogasto->mostrarGastosCancelar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Ogasto->contar($busqueda, $papelera);
?>
<br />
<div class="box box-info" style="border-color:#ef7769">
    <div class="box-header with-border">
        <h3 class="box-title">Proveedores varios (gastos)</h3>
    </div><!-- /.box-header -->

<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered" id = "tablaGastos">
        	<tr>
                <th class="columnaDecorada" style="background:#ef7769;"></th>
				<th class="Cidgasto" style="display:none">ID</th>
                <th class="Cfechafactura">Fecha factura</th>
                <th class="Cfechavencimiento">Fecha vencimiento</th>
				<th class="Cidcuentaprincipal" style="display:none">Cuenta principal</th>
				<th class="Cidcuentasecundaria" style="display:none">Cuenta secundaria</th>
				<th class="Cidproveedor">Proveedor</th>
                <th class="Cbeneficiario">Beneficiario</th>
                <th class="Cdescripcion">Descripcion</th>
				<th class="Cfactura">Factura</th>
				<th class="Cidmodeloimpuestos" style="display:none">Modelo impuestos</th>
				<th class="Csubtotal" style="display:none">Subtotal</th>
				<th class="Cimpuestos" style="display:none">Impuestos</th>
				<th class="Ctotal">Total</th>
                <th class="Cautorización" style="display:none">Autorización</th>
				<th class="Cidretiro" style="display:none">Retiro</th>
				<th width="40"></th>
      		</tr>
	<?php
	$con = 0;
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idgasto'] ?>">
                <td class="columnaDecorada" style="background:#ef7769;"></td>
				<td class="Cidgasto" style="display:none"><?php echo $filas['idgasto']; ?></td>
                <td class="Cfechafactura"><?php echo $filas['fechafactura']; ?></td>
                <td class="Cfechavencimiento"><?php echo $filas['fechavencimiento']; ?></td>
				<td class="Cidcuentaprincipal" style="display:none"><?php echo $filas['nombrecuentaprincipal']; ?></td>
				<td class="Cidcuentasecundaria" style="display:none"><?php echo $filas['nombrecuentasecundaria']; ?></td>
				<td class="Cidproveedor"><?php echo $filas['nombreproveedor']; ?></td>
                <td class="Cbeneficiario"><?php echo $filas['beneficiario']; ?></td>
                <td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
				<td class="Cfactura"><?php echo $filas['factura']; ?></td>
				<td class="Cidmodeloimpuestos" style="display:none"><?php echo $filas['nombremodeloimpuestos']; ?></td>
				<td class="Csubtotal" style="display:none"><?php echo $filas['subtotal']; ?></td>
				<td class="Cimpuestos" style="display:none"><?php echo $filas['impuestos']; ?></td>
				<td class="Ctotal" id="<?php echo "totalgastos".$con ?>"><?php echo $filas['total']; ?></td>
                <td class="Cautorizacion" style="display:none"><?php echo $filas['autorizado']; ?></td>
				<td class="Cidretiro" style="display:none"><small><?php echo $Ogasto->ObtenerDatosRetiro($filas['idretiro']); ?></small></td>
                <td>
					<?php /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['cuentasporpagar']['eliminar'])){
                    ?>
                      <a class="btn btn-danger btn-xs" title="Cancelar" onclick="(eliminarIndividualGasto(<?php echo $filas['idgasto'] ?>))"><li class="fa fa-close"></li></a>
                    <?php 
                    }else{ ?>
                        <a class="btn btn-danger btn-xs disabled"><i class="fa fa-close"></i></a>
                    <?php
                    }
                    ?>
                </td>
      		</tr>
    <?php
	$con++;
	}//Fin de while si es tabla ?>
		</table>
     <?php if(mysqli_num_rows($resultado)==0){
		include("../../../componentes/mensaje_no_hay_registros.php");
		}
     ?>
     
     <input value="" name="listaSalidaGastos" type="hidden" class="form-control"  id="listaSalidaGastos" />
    </form>
	</div><!-- /.box-body -->
    
    </div>
    
<?php

}
else{ // Si se ha elegido el tipo lista ?>
	<div class="box-body">
    <?php
	while ($filas=mysqli_fetch_array($resultado)) {		
?>
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idgasto'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#ef7769 !important; height:120px; padding-top:15px;"><i class="fa fa-money"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cidcuentaprincipal" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['gastos']['eliminar'])){ ?>
						<?php if($filas['idgasto']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idgasto'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idgasto'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['idcuentaprincipal'] ?>
            </span>
    		<span class="info-box-number Cidcuentasecundaria" style="font-weight:normal; color:#ef7769;"><?php echo $filas['idcuentasecundaria'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['total'])!=""){
					$composicion=$composicion."".$filas['total'];
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
							if (isset($_SESSION['permisos']['gastos']['eliminar'])){ ?>
								<?php if($filas['idgasto']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idgasto'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idgasto'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['gastos']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=compras&n2=gastos&n3consultargastos" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idgasto'] ?>"/>
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

?>