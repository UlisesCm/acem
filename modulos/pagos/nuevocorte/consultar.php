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
require('../../detallecotizacionesproductos/Detallecotizacionproducto.class.php');

if (isset($_REQUEST['idreferencia']) && $_REQUEST['idreferencia'] !="") {
	$idreferencia=$_REQUEST['idreferencia'];
}else{
	$idreferencia="x";
}

if (isset($_REQUEST['tablareferencia']) && $_REQUEST['tablareferencia'] !="") {
	$tablareferencia=$_REQUEST['tablareferencia'];
}else{
	$tablareferencia="x";
}

function floattostr( $val)
	{
		preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
		return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');
	}



$Opago=new Pago;
$resultado=$Opago->mostrar($idreferencia, $tablareferencia);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>    		
                <th class="columnaDecorada" style="background:#b4d571;"></th>
				<th class="Cidpago">No. Pago</th>
				<th class="Cfechapago">Fecha de pago</th>
				<th class="Cformapago">Forma de pago</th>
				<th class="Cmonto">Monto</th>
				<th class="Cdescripcion">Comentarios</th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>

      		<tr id="iregistro<?php echo $filas['idpago'] ?>">
        		
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
					
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['pagos']['eliminar']) and $filas['estadopago']!="CON REP"){
						?>
							<?php if($filas['idpago']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idpago']?>,'<?php echo $filas['idreferencia']?>','<?php echo $filas['tablareferencia']?>'))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
                        	<div title="No se puede eliminar porque no cuenta con los permisos para realizar esta acción o porque el pago está relacionado con un comprobante electrónico de pago">
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
                            </div>
						<?php
						} ?>
                </td>
                
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
    
    <?php
	$Odetallecotizacionesproductos =new Detallecotizacionproducto;
	$resultado2=$Odetallecotizacionesproductos->mostrarDevoluciones($idreferencia);
	$filasTotales=$resultado2[1];
	$resultado2=$resultado2[0];
	while ($filas=mysqli_fetch_array($resultado2)) { ?>
      		<tr id="iregistro<?php echo $filas['iddetallecotizacion'] ?>">
        		
                <td class="columnaDecorada" style="background:#b4d571;"></td>
				<td class="Cidpago"><?php echo $filas['iddetallecotizacion']; ?></td>
				<td class="Cfolio"><?php "" ?></td>
				<td class="Cformapago"><?php echo "DEVOLUCIÓN" ?></td>
				<td class="Cmonto"><?php echo $filas['total']; ?></td>
				<td class="Cdescripcion"><?php echo "FOLIO VENTA: ".$filas['serie']."-".$filas["folio"];?></td>
        		
                
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
    
    
		</table>
	</div><!-- /.box-body -->

</div>
<?php 
//FIN DEL CODIGO DE PAGINACION
if(mysqli_num_rows($resultado)==0 && mysqli_num_rows($resultado2)==0){
	include("../../../componentes/mensaje_no_hay_registros.php");
}
?>