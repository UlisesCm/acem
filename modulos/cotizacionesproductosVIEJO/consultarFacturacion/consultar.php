<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['cotizacionesproductos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Cotizacionproducto.class.php');

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
		$campoOrden="fecha";
	}
}else{
	$campoOrden="fecha";
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

//RECEPCION DE VARIABLES PARA FILTRADO AVANZADO

if (isset($_REQUEST['idcliente']) && $_REQUEST['idcliente'] !="") {
	if($_REQUEST['idcliente']!="undefined"){
		$idcliente = htmlentities($_REQUEST['idcliente']);
	}else{
		$idcliente="";
	}
}else{
	$idcliente="";
}

if (isset($_REQUEST['iddomicilio']) && $_REQUEST['iddomicilio'] !="") {
	if($_REQUEST['iddomicilio']!="undefined"){
		$iddomicilio = htmlentities($_REQUEST['iddomicilio']);
	}else{
		$iddomicilio="";
	}
}else{
	$iddomicilio="";
}

if (isset($_REQUEST['idzona']) && $_REQUEST['idzona'] !="") {
	if($_REQUEST['idzona']!="undefined"){
		$idzona = htmlentities($_REQUEST['idzona']);
	}else{
		$idzona="TODAS";
	}
}else{
	$idzona="TODAS";
}

if (isset($_REQUEST['idsucursal']) && $_REQUEST['idsucursal'] !="") {
	if($_REQUEST['idsucursal']!="undefined"){
		$idsucursal = htmlentities($_REQUEST['idsucursal']);
	}else{
		$idsucursal="0";
	}
}else{
	$idsucursal="0";
}


if (isset($_REQUEST['tipo']) && $_REQUEST['tipo'] !="") {
	if($_REQUEST['tipo']!="undefined"){
		$tipo = htmlentities($_REQUEST['tipo']);
	}else{
		$tipo="";
	}
}else{
	$tipo="";
}

if (isset($_REQUEST['filtrarfecha']) && $_REQUEST['filtrarfecha'] !="") {
	if($_REQUEST['filtrarfecha']!="undefined"){
		$filtrarfecha = htmlentities($_REQUEST['filtrarfecha']);
	}else{
		$filtrarfecha="";
	}
}else{
	$filtrarfecha="";
}

if (isset($_REQUEST['fechainicio']) && $_REQUEST['fechainicio'] !="") {
	if($_REQUEST['fechainicio']!="undefined"){
		$fechainicio = htmlentities($_REQUEST['fechainicio']);
	}else{
		$fechainicio="";
	}
}else{
	$fechainicio="";
}

if (isset($_REQUEST['fechafin']) && $_REQUEST['fechafin'] !="") {
	if($_REQUEST['fechafin']!="undefined"){
		$fechafin = htmlentities($_REQUEST['fechafin']);
	}else{
		$fechafin="";
	}
}else{
	$fechafin="";
}

if (isset($_REQUEST['filtroavanzado']) && $_REQUEST['filtroavanzado'] !="") {
	if($_REQUEST['filtroavanzado']!="undefined"){
		$filtroavanzado = htmlentities($_REQUEST['filtroavanzado']);
	}else{
		$filtroavanzado="No";
	}
}else{
	$filtroavanzado="No";
}

if (isset($_REQUEST['idequipo']) && $_REQUEST['idequipo'] !="") {
	if($_REQUEST['idequipo']!="undefined"){
		$idequipo = htmlentities($_REQUEST['idequipo']);
	}else{
		$idequipo="0";
	}
}else{
	$idequipo="0";
}

if (isset($_REQUEST['idruta']) && $_REQUEST['idruta'] !="") {
	if($_REQUEST['idruta']!="idruta"){
		$idruta = htmlentities($_REQUEST['idruta']);
	}else{
		$idruta="";
	}
}else{
	$idruta="";
}


//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Ocotizacionproducto=new Cotizacionproducto;
//$resultado=$Ocotizacion->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);

if($busqueda == ""){
	//revisar si se esta mandando llamar desde rutas
	if($idruta!=""){
		$resultado=$Ocotizacionproducto->mostrarRuta($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idruta);
	}
	else{
		//checar si la consulta es por consulta de cotizaciones pendientes o si fue un clic al boton de filtrar
		if($filtroavanzado=="Si"){
			$resultado=$Ocotizacionproducto->mostrarFacturacion($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcliente,$iddomicilio,$idzona,$idsucursal,$tipo,$filtrarfecha,$fechainicio,$fechafin);
		}
		else{//consulta pendientes del cliente seleccionado
			$resultado=$Ocotizacionproducto->mostrarPendientes($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcliente,$iddomicilio,$idzona,$tipo);
		}
	}

	$filasTotales=$resultado[1];
	$resultado=$resultado[0];
}
else{
	$resultado=$Ocotizacionproducto->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
	$filasTotales=$resultado[1];
    $resultado=$resultado[0];
}
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
//$filasTotales = $Ocotizacion->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA






if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#649ad0;"></th>
				<th class="Cidcotizacionproducto">ID</th>
				<th class="Cserie">Serie</th>
				<th class="Cfolio">Folio</th>
                <th class="Cfolio">Subfolio</th>
				<th class="Cfecha">Fecha</th>
				
				<th class="Cestadopago">Estado pago</th>
				<th class="Cestadofacturacion">Estado facturación</th>
				
				
				<th class="Ctotal">Total</th>
				<th class="Cidcliente">Cliente</th>
				
                <th class="Cestadoliquidacion">Estado liquidacion</th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idcotizacionproducto'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['cotizacionesproductos']['eliminar'])){ ?>
                		<?php if($filas['idcotizacionproducto']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idcotizacionproducto'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idcotizacionproducto'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#649ad0;"></td>
				<td class="Cidcotizacionproducto"><?php echo $filas['idcotizacionproducto']; ?></td>
				<td class="Cserie"><?php echo $filas['serie']; ?></td>
				<td class="Cfolio"><?php echo $filas['folio']; ?></td>
                <td class="Cfolio"><?php echo $filas['subfolio']; ?></td>
				<?php
				$fechaNfecha=date_create($filas['fecha']);
				$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
				?>
				<td class="Cfecha"><?php echo $nuevaFecha; ?></td>
				<td class="Cestadopago"><?php echo $filas['estadopago']; ?></td>
				<td class="Cestadofacturacion"><?php echo $filas['estadofacturacion']; ?></td>
				
				<td class="Ctotal"><?php echo "$".number_format($filas['TotalDetalles'],2); ?></td>
				
				<td class="Cidcliente"><?php echo $filas['cliente']; ?></td>
                <td class="Cestadoliquidacion"><?php echo $filas['estadoliquidacion']; ?></td>
        		
                 <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['detallecotizacionesotros']['consultar'])){
					?>
						<form target="_blank" action="prepararFactura.php" method="post">
                			<input type="hidden" name="idcotizacionproducto" value="<?php echo $filas['idcotizacionproducto'] ?>"/>
                            <input type="hidden" name="subfolio" value="<?php echo $filas['subfolio'] ?>"/>
                            <button type="submit" class="btn btn-info btn-xs" value="" title="Detalles"><li class="fa fa-list"></li></button>
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idcotizacionproducto'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#649ad0 !important; height:120px; padding-top:15px;"><i class="fa fa-calculator"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cserie" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['cotizacionesproductos']['eliminar'])){ ?>
						<?php if($filas['idcotizacionproducto']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idcotizacionproducto'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idcotizacionproducto'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['serie'] ?>
            </span>
    		<span class="info-box-number Cfolio" style="font-weight:normal; color:#649ad0;"><?php echo $filas['folio'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['fecha'])!=""){
					$composicion=$composicion.", ".$filas['fecha'];
				}
				if (trim($filas['total'])!=""){
					$composicion=$composicion.", ".$filas['total'];
				}
				if (trim($filas['idcliente'])!=""){
					$composicion=$composicion.", ".$filas['idcliente'];
				}
				if (trim($filas['estadoentrega'])!=""){
					$composicion=$composicion.", ".$filas['estadoentrega'];
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
							if (isset($_SESSION['permisos']['cotizacionesproductos']['eliminar'])){ ?>
								<?php if($filas['idcotizacionproducto']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idcotizacionproducto'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idcotizacionproducto'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['cotizacionesproductos']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=ventas&n2=cotizacionesproductos&n3=consultarcotizacionesproductos" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idcotizacionproducto'] ?>"/>
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