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


$idcortedecaja = 0;

$Opago=new Pago;
$resultado=$Opago->mostrarCorte("EFECTIVO",$idcortedecaja);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
function floattostr( $val)
	{
		preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
		return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');
	}
?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered" id="tablaEfectivo">
        	<tr>
        		
                <th class="columnaDecorada" style="background:#b4d571;"></th>
				<th class="Cidpago">No. Pago</th>
				<th class="Cfechapago">Fecha de pago</th>
				<th class="Cmonto">Monto</th>
				<th class="Cdescripcion">Comentarios</th>
                <th class="Seleccionarefectivo"><input id="seleccionartodoefectivo" type="checkbox" onclick="seleccionarTodoEfectivo();"></th>
      		</tr>
	<?php
	$con=0;
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idpago'] ?>">
        		
                <td class="columnaDecorada" style="background:#b4d571;"></td>
				<td class="Cidpago"><?php echo $filas['idpago']; ?></td>
				<?php
				$fechaNfechapago=date_create($filas['fechapago']);
				$nuevaFecha= date_format($fechaNfechapago, 'd/m/Y');
				?>
				<td class="Cfechapago"><?php echo $nuevaFecha; ?></td>
                <td class="Cmonto" id="<?php echo "totalefectivo".$con ?>"><?php echo floattostr($filas['monto']); ?></td>
				<td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
        		<td class="checkEfectivo"><input id="<?php echo "checkefectivo".$con ?>" class="checkEfectivo" type="checkbox" onclick="recorrerTablaEfectivo('tablaEfectivo','listaSalidaEfectivo');"></td>
                
      		</tr>
    <?php
	$con++;
	} //Fin de while si es tabla ?>
    </table>
	</div><!-- /.box-body -->
      <br/>
    <div class="form-group ">
        <label for="ctotalefectivo" class="col-sm-9 control-label"></label>
        <label for="ctotalefectivo" class="col-sm-1 control-label">Total efectivo:</label>
        <div class="col-sm-2">
            <input value="0.00" name="totalefectivo" readonly="" type="text" class="form-control" style="text-align:right; font-weight: bold;" id="ctotalefectivo">
        </div>
    </div>
   <br/>
    <input value="" name="listaSalidaEfectivo" type="hidden" class="form-control"  id="listaSalidaEfectivo" />
<?php 
$Opago=new Pago;
$resultado=$Opago->mostrarCorte("TARJETA DE DEBITO",$idcortedecaja);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
?>
<br />
 <div class="box box-info" style="border-color:#b4d571">
    <div class="box-header with-border">
        <h3 class="box-title">Tarjeta de debito</h3>
    </div><!-- /.box-header -->
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered" id="tablaTarjetadedebito">
        	<tr>
        		
                <th class="columnaDecorada" style="background:#b4d571;"></th>
				<th class="Cidpago">No. Pago</th>
				<th class="Cfechapago">Fecha de pago</th>
				<th class="Cformapago">Forma de pago</th>
				<th class="Cmonto">Monto</th>
				<th class="Cdescripcion">Comentarios</th>
                <th class="Seleccionartarjetadedebito"><input id="seleccionartodotarjetadedebito" type="checkbox" onclick="seleccionarTodoTarjetadedebito();"></th>
      		</tr>
	<?php
	$con=0;
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
				<td class="Cmonto" id="<?php echo "totaltarjetadedebito".$con ?>"><?php echo floattostr($filas['monto']); ?></td>
				<td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
        		<td class="checkTarjetadedebito"><input id="<?php echo "checktarjetadedebito".$con ?>" class="checkTarjetadedebito" type="checkbox" onclick="recorrerTablaTarjetadedebito('tablaTarjetadedebito','listaSalidaTarjetadedebito');"></td>
      		</tr>
    <?php
	$con++;
	} //Fin de while si es tabla ?>
    </table>
	</div><!-- /.box-body -->
      <br/>
 <div class="form-group ">
        <label for="ctotaltarjetadebito" class="col-sm-9 control-label"></label>
        <label for="ctotaltarjetadebito" class="col-sm-1 control-label">Total tarjeta de debito:</label>
        <div class="col-sm-2">
            <input value="0.00" name="totaltarjetadebito" readonly="" type="text" class="form-control" style="text-align:right; font-weight: bold;" id="ctotaltarjetadedebito">
        </div>
    </div>
 <br/>
    <input value="" name="listaSalidaTarjetadedebito" type="hidden" class="form-control"  id="listaSalidaTarjetadedebito" />
<?php 
$Opago=new Pago;
$resultado=$Opago->mostrarCorte("TARJETA DE CREDITO",$idcortedecaja);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
?>
<br />
 <div class="box box-info" style="border-color:#b4d571">
    <div class="box-header with-border">
        <h3 class="box-title">Tarjeta de crédito</h3>
    </div><!-- /.box-header -->
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered"  id="tablaTarjetadecredito">
        	<tr>
        		
                <th class="columnaDecorada" style="background:#b4d571;"></th>
				<th class="Cidpago">No. Pago</th>
				<th class="Cfechapago">Fecha de pago</th>
				<th class="Cformapago">Forma de pago</th>
				<th class="Cmonto">Monto</th>
				<th class="Cdescripcion">Comentarios</th>
                <th class="Seleccionartarjetadecredito"><input id="seleccionartodotarjetadecredito" type="checkbox" onclick="seleccionarTodoTarjetadecredito();"></th>
      		</tr>
	<?php
	$con=0;
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
				<td class="Cmonto" id="<?php echo "totaltarjetadecredito".$con ?>"><?php echo floattostr($filas['monto']); ?></td>
				<td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
        		<td class="checkTarjetadecredito"><input id="<?php echo "checktarjetadecredito".$con ?>" class="checkTarjetadecredito" type="checkbox" onclick="recorrerTablaTarjetadecredito('tablaTarjetadecredito','listaSalidaTarjetadecredito');"></td>
      		</tr>
      		</tr>
    <?php
	$con++;
	} //Fin de while si es tabla ?>
    </table>
	</div><!-- /.box-body -->
      <br/>
 <div class="form-group ">
        <label for="ctotaltarjetacredito" class="col-sm-9 control-label"></label>
        <label for="ctotaltarjetacredito" class="col-sm-1 control-label">Total tarjeta de crédito:</label>
        <div class="col-sm-2">
            <input value="0.00" name="totaltarjetacredito" readonly="" type="text" class="form-control" style="text-align:right; font-weight: bold;" id="ctotaltarjetacredito">
        </div>
    </div>
 <br/>
  <input value="" name="listaSalidaTarjetadecredito" type="hidden" class="form-control"  id="listaSalidaTarjetadecredito" />
 
 <?php 
$Opago=new Pago;
$resultado=$Opago->mostrarCorte("CHEQUE",$idcortedecaja);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
?>
<br />
 <div class="box box-info" style="border-color:#b4d571">
    <div class="box-header with-border">
        <h3 class="box-title">Cheques</h3>
    </div><!-- /.box-header -->
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered" id="tablaCheques">
        	<tr>
        		
                <th class="columnaDecorada" style="background:#b4d571;"></th>
				<th class="Cidpago">No. Pago</th>
				<th class="Cfechapago">Fecha de pago</th>
				<th class="Cformapago">Forma de pago</th>
				<th class="Cmonto">Monto</th>
				<th class="Cdescripcion">Comentarios</th>
                <th class="Seleccionarcheques"><input id="seleccionartodocheques" type="checkbox" onclick="seleccionarTodoCheques();"></th>
      		</tr>
	<?php
	$con=0;
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
				<td class="Cmonto" id="<?php echo "totalcheques".$con ?>"><?php echo floattostr($filas['monto']); ?></td>
				<td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
        		<td class="checkCheques"><input id="<?php echo "checkcheques".$con ?>" class="checkCheques" type="checkbox" onclick="recorrerTablaCheques('tablaCheques','listaSalidaCheques');"></td>
      		</tr>
    <?php
	$con++;
	} //Fin de while si es tabla ?>
    </table>
	</div><!-- /.box-body -->
      <br/>
 <div class="form-group ">
        <label for="ctotalcheque" class="col-sm-9 control-label"></label>
        <label for="ctotalcheque" class="col-sm-1 control-label">Total cheque:</label>
        <div class="col-sm-2">
            <input value="0.00" name="totalcheque" readonly="" type="text" class="form-control" style="text-align:right; font-weight: bold;" id="ctotalcheque">
        </div>
    </div>
 <br/>
 <input value="" name="listaSalidaCheques" type="hidden" class="form-control"  id="listaSalidaCheques" />
 <?php 
$Opago=new Pago;
$resultado=$Opago->mostrarCorte("TRANSFERENCIA",$idcortedecaja);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
?>
<br />
 <div class="box box-info" style="border-color:#b4d571">
    <div class="box-header with-border">
        <h3 class="box-title">Transferencias</h3>
    </div><!-- /.box-header -->
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered"  id="tablaTransferencias">
        	<tr>
        		
                <th class="columnaDecorada" style="background:#b4d571;"></th>
				<th class="Cidpago">No. Pago</th>
				<th class="Cfechapago">Fecha de pago</th>
				<th class="Cformapago">Forma de pago</th>
				<th class="Cmonto">Monto</th>
				<th class="Cdescripcion">Comentarios</th>
                <th class="Seleccionartransferencias"><input id="seleccionartodotransferencias" type="checkbox" onclick="seleccionarTodoTransferencias();"></th>
      		</tr>
	<?php
	$con=0;
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
				<td class="Cmonto" id="<?php echo "totaltransferencias".$con ?>"><?php echo floattostr($filas['monto']); ?></td>
				<td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
        		<td class="checkTransferencias"><input id="<?php echo "checktransferencias".$con ?>" class="checkTransferencias" type="checkbox" onclick="recorrerTablaTransferencias('tablaTransferencias','listaSalidaTransferencias');"></td>
      		</tr>
    <?php
	$con++;
	} //Fin de while si es tabla ?>
    </table>
	</div><!-- /.box-body -->
      <br/>
 <div class="form-group ">
        <label for="ctotaltransferencia" class="col-sm-9 control-label"></label>
        <label for="ctotaltransferencia" class="col-sm-1 control-label">Total transferencias:</label>
        <div class="col-sm-2">
            <input value="0.00" name="totaltransferencia" readonly="" type="text" class="form-control" style="text-align:right; font-weight: bold;" id="ctotaltransferencia">
        </div>
    </div>
 <br/>
 <input value="" name="listaSalidaTransferencias" type="hidden" class="form-control"  id="listaSalidaTransferencias" />
 <?php 
$Opago=new Pago;
$resultado=$Opago->mostrarCorte("DEPOSITO",$idcortedecaja);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
?>
<br />
 <div class="box box-info" style="border-color:#b4d571">
    <div class="box-header with-border">
        <h3 class="box-title">Depositos</h3>
    </div><!-- /.box-header -->
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered" id="tablaDepositos">
        	<tr>
        		
                <th class="columnaDecorada" style="background:#b4d571;"></th>
				<th class="Cidpago">No. Pago</th>
				<th class="Cfechapago">Fecha de pago</th>
				<th class="Cformapago">Forma de pago</th>
				<th class="Cmonto">Monto</th>
				<th class="Cdescripcion">Comentarios</th>
                <th class="Seleccionardepositos"><input id="seleccionartododepositos" type="checkbox" onclick="seleccionarTodoDepositos();"></th>
      		</tr>
	<?php
	$con=0;
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
				<td class="Cmonto" id="<?php echo "totaldepositos".$con ?>"><?php echo floattostr($filas['monto']); ?></td>
				<td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
        		<td class="checkDepositos"><input id="<?php echo "checkdepositos".$con ?>" class="checkDepositos" type="checkbox" onclick="recorrerTablaDepositos('tablaDepositos','listaSalidaDepositos');"></td>
      		</tr>
    <?php
	$con++;
	} //Fin de while si es tabla ?>
    </table>
	</div><!-- /.box-body -->
      <br/>
 <div class="form-group ">
        <label for="ctotaldeposito" class="col-sm-9 control-label"></label>
        <label for="ctotaldeposito" class="col-sm-1 control-label">Total depositos:</label>
        <div class="col-sm-2">
            <input value="0.00" name="totaldeposito" readonly="" type="text" class="form-control" style="text-align:right; font-weight: bold;" id="ctotaldeposito">
        </div>
    </div>
 <br/>
  <input value="" name="listaSalidaDepositos" type="hidden" class="form-control"  id="listaSalidaDepositos" />
<?php 
$Opago=new Pago;
$resultado=$Opago->mostrarCorte("NOTAS DE CREDITO",$idcortedecaja);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
?>
<br />
 <div class="box box-info" style="border-color:#b4d571">
    <div class="box-header with-border">
        <h3 class="box-title">Notas de crédito</h3>
    </div><!-- /.box-header -->
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered"  id="tablaNotasdecredito">
        	<tr>
        		
                <th class="columnaDecorada" style="background:#b4d571;"></th>
				<th class="Cidpago">No. Pago</th>
				<th class="Cfechapago">Fecha de pago</th>
				<th class="Cformapago">Forma de pago</th>
				<th class="Cmonto">Monto</th>
				<th class="Cdescripcion">Comentarios</th>
                 <th class="Seleccionarnotasdecredito"><input id="seleccionartodonotasdecredito" type="checkbox" onclick="seleccionarTodoNotasdecredito();"></th>
      		</tr>
	<?php
	$con=0;
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
				<td class="Cmonto" id="<?php echo "totalnotasdecredito".$con ?>"><?php echo floattostr($filas['monto']); ?></td>
				<td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
        		<td class="checkDNotasdecredito"><input id="<?php echo "checknotasdecredito".$con ?>" class="checkNotasdecredito" type="checkbox" onclick="recorrerTablaNotasdecredito('tablaNotasdecredito','listaSalidaNotasdecredito');"></td>
      		</tr>
    <?php
	$con++;
	} //Fin de while si es tabla ?>
    </table>
    <br/>
     <div class="form-group ">
        <label for="ctotalnotadecredito" class="col-sm-9 control-label"></label>
        <label for="ctotalnotadecredito" class="col-sm-1 control-label">Total notas de crédito:</label>
        <div class="col-sm-2">
            <input value="0.00" name="totalnotadecredito" readonly="" type="text" class="form-control" style="text-align:right; font-weight: bold;" id="ctotalnotadecredito">
        </div>
    </div>
     <br/>
      <br/>
      <input value="" name="listaSalidaNotasdecredito" type="hidden" class="form-control"  id="listaSalidaNotasdecredito" />
      
      
</div><!-- /.box-body -->
    


</div>


