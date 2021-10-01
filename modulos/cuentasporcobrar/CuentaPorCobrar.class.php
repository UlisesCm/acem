<?php 
include_once("../../conexion/Conexion.class.php");
include_once("../../movimientos/Movimiento.class.php");
class Venta{
 //constructor	
 	var $con;
	var $Omovimiento;
 	function __construct()	 
	{
 		$this->con=new Conexion;
		$this->Omovimiento=new Movimiento;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			$consulta="WHERE ventas.idreferencia <>'0'";
		}else{
			$consulta="WHERE ventas.idreferencia <>'0'";
		}
		return $consulta;
	}
	
	
	function mostrarIndividual($idreferencia){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM ventas WHERE idreferencia='$idreferencia'");
		}
	}
	
	function contarA($condicion, $papelera, $idalmacen, $idcliente, $ticket, $tipo, $filtrarfecha="", $fechainicio="", $fechafin="", $clasificacion="", $formapago="", $idempleado="", $fechaLiquidacion=false, $diacobro, $facturada="", $rfccliente="", $marcarventa="todos"){
		
		$consultaTipo="";
		$consultaCliente="";
		$consultaAlmacen="";
		$consultaTipo="";
		$consultaTicket="";
		$consultaFecha="";
		$consultaFormaPago="";
		$consultaEmpleado="";
		$consultaDiaCobro="";
		$consultaFacturada="";
		$consultaRFC="";
		$joinfacturacion="";
		$camposfacturacion="";
		$consultaDomicilio="";
		
		if ($clasificacion=="CONTADO"){
			if ($formapago==""){
				$consultaFormaPago="AND ventas.formapago <> 'CREDITO'";
			}else{
				$consultaFormaPago="AND ventas.formapago = '$formapago'";
			}
		}
		if ($clasificacion=="CREDITO"){
			$consultaFormaPago="AND ventas.formapago = 'CREDITO'";
		}
		
		if ($filtrarfecha=="SI"){
			if ($fechaLiquidacion){
				$consultaFecha=" AND ventas.fechaLiquidacion >= '$fechainicio' AND ventas.fechaLiquidacion <= '$fechafin' ";
			}else{
				$consultaFecha=" AND ventas.fecha >= '$fechainicio' AND ventas.fecha <= '$fechafin' ";
			}
		}
		if ($facturada=="si"){
				$consultaFacturada=" AND ventas.facturada = 'si'";
		}else if($facturada=="no"){
			$consultaFacturada=" AND ventas.facturada = 'no'";
		}
		
		if ($marcarventa=="si"){
			$consultaDomicilio=" AND ventas.marcarventa = 'si'";
		}
		if ($marcarventa=="no"){
			$consultaDomicilio=" AND ventas.marcarventa <> 'si'";
		}
		
		if ($rfccliente!=""){
			$consultaRFC=" AND facturacion.rfcreceptor = '$rfccliente'";
			$joinfacturacion="INNER JOIN facturacion ON ventas.foliofiscal=facturacion.foliofiscal";
			$camposfacturacion="facturacion.rfcreceptor AS rfcreceptor,";
		}
		
		if ($idcliente!=""){
			$consultaCliente=" AND ventas.idcliente='$idcliente'";
		}
		if ($diacobro!="NO APLICA"){
			$consultaDiaCobro=" AND ventas.diacobro='$diacobro'";
		}
		if ($ticket!=""){
			$ticket=explode(",",$ticket);
			$consultaTicket=$consultaTicket." AND (ventas.ticket='".$ticket[0]."'";
			$con=1;
			while ($con< count($ticket)){
				$consultaTicket=$consultaTicket." OR ventas.ticket='".$ticket[$con]."'";
				$con++;
			}
			$consultaTicket=$consultaTicket.")";
		}
		if ($idalmacen!=""){
			$consultaAlmacen=" AND ventas.idalmacen='$idalmacen'";
		}
		if ($idempleado!=""){
			if ($idempleado!="TODOS"){
				$consultaEmpleado=" AND ventas.idempleado='$idempleado'";
			}
		}
		if ($tipo==""){
			$consultaTipo="";
		}else{
			$consultaTipo=" AND ventas.estado='$tipo'";
			if ($tipo=="fechavencida"){
				$fechaActual=date("Y-m-d");
				$consultaTipo=" AND ventas.fechaplazo < '$fechaActual'";
			}
		}
		
		$condicion= trim($condicion);
		$where="WHERE ventas.idreferencia <>'0' $consultaAlmacen $consultaEmpleado $consultaCliente $consultaTipo $consultaTicket $consultaFecha $consultaFormaPago $consultaDiaCobro $consultaFacturada $consultaRFC $consultaDomicilio";
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					ventas.idreferencia,
					ventas.fecha,
					ventas.hora,
					ventas.formapago,
					ventas.efectivo,
					ventas.credito,
					ventas.tarjetadebito,
					ventas.tarjetacredito,
					ventas.cheque,
					ventas.transferencia,
					ventas.saldoafavor,
					ventas.monedero,
					ventas.cambio,
					ventas.reftarjetadebito,
					ventas.reftarjetacredito,
					ventas.refcheque,
					ventas.reftransferencia,
					ventas.refmonedero,
					ventas.subtotal,
					ventas.iva,
					ventas.ieps,
					ventas.total,
					ventas.estado,
					ventas.idcliente,
					ventas.idcaja,
					ventas.idempleado,
					ventas.idalmacen,
					ventas.ticket,
					ventas.facturada,
					ventas.archivoFactura,
					ventas.archivoNota,
					ventas.diferenciaCredito,
					ventas.fechaLiquidacion,
					ventas.devuelto,
					ventas.totaloriginal,
					ventas.diacobro,
					ventas.foliofiscal,
					ventas.marcarventa,
					clientes.nombre AS nombreclientes,
					personas.rfc AS rfcclientes,
					empleados.nombre AS nombreempleados,
					$camposfacturacion
					almacenes.nombre AS nombrealmacenes
					FROM ventas 
					INNER JOIN clientes ON ventas.idcliente=clientes.idcliente
					INNER JOIN empleados ON ventas.idempleado=empleados.idempleado
					INNER JOIN almacenes ON ventas.idalmacen=almacenes.idalmacen
					INNER JOIN personas ON clientes.idpersona=personas.idpersona
					$joinfacturacion
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrarProductos($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcliente,$idsucursal,$serie,$folio,$tiposerie,$tipo,$filtrarfecha,$fechainicio,$fechafin,$estadopago,$excel=""){
		$consultaCliente = "";
		$consultaSucursal = "";
		$consultaFolio="";
		$consultaEstado = "";
		$consultaFecha = "";
		$consultaEstatus = "";
		$consultaEstadopago="";
		$limites = "";
		
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		
		if ($folio!=""){
			if($tiposerie=="PRODUCTOS" || $tiposerie=="TODOS"){
				if($tiposerie=="TODOS"){
					$consultaFolio=" AND $cotizacionesproductos.folio='$folio'";
				}
				else{
					$consultaFolio=" AND $cotizacionesproductos.serie='$serie'  AND $cotizacionesproductos.folio='$folio'";
				}
				if ($idsucursal!="TODAS"){
					$consultaSucursal=" AND $cotizacionesproductos.idsucursal='$idsucursal'";
				}
			}
			else{
				 $consultaFolio = " AND $cotizacionesproductos.idcotizacionproducto = 0";
			}
		}
		else{
			
			if ($idcliente!=""){
				$consultaCliente=" AND $cotizacionesproductos.idcliente='$idcliente'";
			}
			
			if ($idsucursal!="TODAS"){
				$consultaSucursal=" AND $cotizacionesproductos.idsucursal='$idsucursal'";
			}
			
			if ($estadopago!="AMBAS"){
				$consultaEstadopago=" AND $cotizacionesproductos.estadopago='$estadopago'";
			}
			
			if ($tipo!=""){
				$consultaEstado=" AND $cotizacionesproductos.tipo='$tipo'";
			}
			
			if ($filtrarfecha=="SI"){
				$consultaFecha=" AND $cotizacionesproductos.fecha >= '$fechainicio' AND $cotizacionesproductos.fecha <= '$fechafin' ";
			}else{
				$consultaFecha="";
			}
		}
		
		if($papelera){
				$consultaEstatus="AND $cotizacionesproductos.estatus ='eliminado'";
		}else{
				$consultaEstatus="AND $cotizacionesproductos.estatus <>'eliminado'";
		}
		
		//$SoloAceptados = "AND cotizaciones.estado ='ACEPTADA' ";
		
		if($excel!="SI"){
			$limites="LIMIT $inicial, $cantidadamostrar";
		}
		
		
		$where="";
		$where="WHERE $cotizacionesproductos.idcotizacionproducto<>0 
		$consultaCliente
		$consultaSucursal
		$consultaFolio
		$consultaEstado
		$consultaFecha
		$consultaEstadopago
		$consultaEstatus";
		
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					$cotizacionesproductos.idcotizacionproducto,
					$cotizacionesproductos.serie,
					$cotizacionesproductos.folio,
					$cotizacionesproductos.fecha,
					$cotizacionesproductos.hora,
					$cotizacionesproductos.estadopago,
					$cotizacionesproductos.estadofacturacion,
					$cotizacionesproductos.tipo,
					$cotizacionesproductos.subtotal,
					$cotizacionesproductos.impuestos,
					$cotizacionesproductos.total,
					$cotizacionesproductos.costodeventa,
					$cotizacionesproductos.utilidad,
					$cotizacionesproductos.idcliente,
					$cotizacionesproductos.idusuario,
					$cotizacionesproductos.idempleado,
					$cotizacionesproductos.enviaradomicilio,
					$cotizacionesproductos.fechaentrega,
					$cotizacionesproductos.horaentregainicio,
					$cotizacionesproductos.horaentregafin,
					$cotizacionesproductos.prioridad,
					$cotizacionesproductos.iddomicilio,
					$cotizacionesproductos.observaciones,
					$cotizacionesproductos.estadoentrega,
					$cotizacionesproductos.estadocredito,
					$cotizacionesproductos.descripcioncredito,
					$cotizacionesproductos.estatus,
					domicilios.tipovialidad AS tipovialidad,
					domicilios.calle AS calle,
					domicilios.noexterior AS noexterior,
					domicilios.nointerior AS nointerior,
					domicilios.colonia AS colonia,
					domicilios.ciudad AS ciudad,
					domicilios.estado AS estado,
					domicilios.cp AS cp,
					usuarios.nombre AS usuario,
					empleados.nombre AS vendedor,
					clientes.nombre AS cliente,
					clientes.rfc AS rfccliente,
					sucursales.nombre AS nombresucursal
					FROM $cotizacionesproductos 
					INNER JOIN usuarios ON $cotizacionesproductos.idusuario=usuarios.idusuario
					INNER JOIN empleados ON $cotizacionesproductos.idempleado=empleados.idempleado
					INNER JOIN clientes ON $cotizacionesproductos.idcliente=clientes.idcliente
					INNER JOIN domicilios ON $cotizacionesproductos.iddomicilio=domicilios.iddomicilio
					INNER JOIN sucursales ON $cotizacionesproductos.idsucursal=sucursales.idsucursal
					$where
					GROUP BY $cotizacionesproductos.idcotizacionproducto 
					$limites
					";
		
					//echo $consulta; //REVISAR CONSULTA
		/*if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}*/
		
		if($this->con->conectar()==true){
			$resultado1 = mysqli_query($this->con->conect,$consulta);
			$resultado2 =  mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			//echo $extractor["contador"];
			return array ($resultado1,$extractor["contador"]);
		}
	}
	
	function mostrarOtros($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcliente,$idsucursal,$serie,$folio,$tiposerie,$tipo,$filtrarfecha,$fechainicio,$fechafin,$estadopago,$excel=""){
		$consultaCliente = "";
		$consultaSucursal = "";
		$consultaFolio="";
		$consultaEstado = "";
		$consultaFecha = "";
		$consultaEstadopago ="";
		$consultaEstatus = "";
		$limites = "";
		
		$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
		$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
		
		
		if ($folio!=""){
			if($tiposerie=="OTROS" || $tiposerie=="TODOS"){
				if($tiposerie=="TODOS"){
			    	$consultaFolio=" AND $cotizacionesotros.folio='$folio'";
				}
				else{
					$consultaFolio=" AND $cotizacionesotros.serie='$serie'  AND $cotizacionesotros.folio='$folio'";
				}
				if ($idsucursal!="TODAS"){
					$consultaSucursal=" AND $cotizacionesotros.idsucursal='$idsucursal'";
				}
			}
			else{//NO CONSULTAR NADA
			   $consultaFolio=" AND $cotizacionesotros.idcotizacionesotros = 0";
			}
		}
		else{
			if ($idcliente!=""){
				$consultaCliente=" AND $cotizacionesotros.idcliente='$idcliente'";
			}
			
			
			if ($idsucursal!="TODAS"){
				$consultaSucursal=" AND $cotizacionesotros.idsucursal='$idsucursal'";
			}
			
			if ($estadopago!="AMBAS"){
				$consultaEstadopago=" AND $detallecotizacionesotros.estadopago='$estadopago'";
			}
			
			if ($filtrarfecha=="SI"){
				$consultaFecha=" AND $detallecotizacionesotros.fecha >= '$fechainicio' AND $detallecotizacionesotros.fecha <= '$fechafin' ";
			}else{
				$consultaFecha="";
			}
		}
		
		if($papelera){
				$consultaEstatus="AND $detallecotizacionesotros.estatus ='eliminado'";
		}else{
				$consultaEstatus="AND $detallecotizacionesotros.estatus <>'eliminado'";
		}
		
		//$SoloAceptados = "AND cotizaciones.estado ='ACEPTADA' ";
		
		if($excel!="SI"){
			$limites="LIMIT $inicial, $cantidadamostrar";
		}
		
		
		$where="";
		$where="WHERE $cotizacionesotros.idcotizacionesotros<>0 
		$consultaCliente
		$consultaSucursal
		$consultaFolio
		$consultaEstado
		$consultaFecha
		$consultaEstadopago
		$consultaEstatus";
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					$cotizacionesotros.serie,
					$cotizacionesotros.folio,
					$cotizacionesotros.tipo,
					$cotizacionesotros.idcliente,
					$cotizacionesotros.idempleado,
					$cotizacionesotros.observaciones,
					$detallecotizacionesotros.fecha,
					$detallecotizacionesotros.iddetallecotizacionotros,
					$detallecotizacionesotros.estadopago,
		            $detallecotizacionesotros.estadofacturacion,
					$detallecotizacionesotros.total,
					$detallecotizacionesotros.estatus,
					clientes.nombre AS cliente,
					clientes.rfc AS rfccliente,
					usuarios.nombre AS usuario,
					empleados.nombre AS vendedor,
					sucursales.nombre AS nombresucursal
					FROM $cotizacionesotros 
					INNER JOIN $detallecotizacionesotros ON $cotizacionesotros.idcotizacionesotros=$detallecotizacionesotros.idcotizacionotros
					INNER JOIN empleados ON $cotizacionesotros.idempleado=empleados.idempleado
					INNER JOIN usuarios ON $cotizacionesotros.idusuario=usuarios.idusuario
					INNER JOIN clientes ON $cotizacionesotros.idcliente=clientes.idcliente
					INNER JOIN sucursales ON $cotizacionesotros.idsucursal=sucursales.idsucursal
					$where
					GROUP BY $cotizacionesotros.idcotizacionesotros 
					$limites
					";
		
					// echo $consulta; //REVISAR CONSULTA
		/*if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}*/
		
		if($this->con->conectar()==true){
			$resultado1 = mysqli_query($this->con->conect,$consulta);
			$resultado2 =  mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			//echo $extractor["contador"];
			return array ($resultado1,$extractor["contador"]);
		}
	}
	
	
	
	function mostrarDetalle($idreferencia){
		
		$where="WHERE detalleventas.idreferencia='$idreferencia'";
		
		$consulta = "SELECT 
					detalleventas.iddetalleventa,
					detalleventas.idproducto,
					detalleventas.cantidad,
					detalleventas.precio,
					detalleventas.ieps,
					detalleventas.tasaieps,
					detalleventas.totalieps,
					detalleventas.iva,
					detalleventas.tasaiva,
					detalleventas.totaliva,
					detalleventas.monto,
					detalleventas.idreferencia,
					detalleventas.montocosto,
					detalleventas.utilidad,
					detalleventas.mododevolucion,
					detalleventas.idreferencia,
					detalleventas.cantidaddevuelta,
					productos.nombre AS nombreproducto,
					productos.codigo AS codigoproducto,
					productos.tipo AS tipoproducto,
					productos.idcategoria,
					productos.modelo AS modeloproducto,
					productos.idmarca,
					productos.idtalla,
					categorias.nombre AS categoriaproducto,
					marcas.nombre AS marcaproducto,
					tallas.nombre AS tallaproducto
					FROM detalleventas 
					INNER JOIN productos ON detalleventas.idproducto=productos.idproducto
					INNER JOIN marcas ON productos.idmarca=marcas.idmarca
					INNER JOIN tallas ON productos.idtalla=tallas.idtalla
					INNER JOIN categorias ON productos.idcategoria=categorias.idcategoria
					$where
					ORDER BY detalleventas.iddetalleventa ASC
					";
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	
	function contarB($condicion, $papelera, $idalmacen, $idcliente, $ticket, $tipo){
		$consultaTipo="";
		$consultaCliente="";
		$consultaAlmacen="";
		$consultaTipo="";
		
		if ($idcliente!=""){
			$consultaCliente=" AND ventasajuste.idcliente='$idcliente'";
		}
		if ($tipo!=""){
			$consultaTipo=" AND ventasajuste.estado='$tipo'";
			if ($tipo=="fechavencida"){
				$fechaActual=date("Y-m-d");
				$consultaTipo=" AND ventasajuste.fechalimite < '$fechaActual'";
			}
		}
		
		$condicion= trim($condicion);
		$where= "WHERE ventasajuste.tablareferencia <>'0 $consultaCliente $consultaTipo";
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT * FROM ventasajuste");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrarB($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $idalmacen, $idcliente, $ticket, $tipo){
		$consultaTipo="";
		$consultaCliente="";
		$consultaTipo="";
		
		if ($idcliente!=""){
			$consultaCliente="AND ventasajuste.idcliente='$idcliente'";
		}
		if ($tipo!=""){
			$consultaTipo="AND ventasajuste.estado='$tipo'";
			if ($tipo=="fechavencida"){
				$fechaActual=date("Y-m-d");
				$consultaTipo=" AND ventasajuste.fechalimite < '$fechaActual'";
			}
		}
		
		
		$where= "WHERE ventasajuste.tablareferencia <>'0' $consultaCliente $consultaTipo";
		
		$consulta = "SELECT 
					ventasajuste.tablareferencia,
					ventasajuste.fecha,
					ventasajuste.fechalimite,
					ventasajuste.idcliente,
					ventasajuste.total,
					ventasajuste.descripcion,
					ventasajuste.estado,
					ventasajuste.facturada,
					ventasajuste.archivoFactura,
					ventasajuste.archivoNota,
					ventasajuste.diferenciaCredito,
					ventasajuste.fechaLiquidacion,
					clientes.nombre AS nombreclientes
					FROM ventasajuste 
					INNER JOIN clientes ON ventasajuste.idcliente=clientes.idcliente
					$where
					";
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	
	
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM ventas $condicion");
		}
	}
	
	function obtenerDevoluciones($idreferencia){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT sum(total) AS totaldev FROM devoluciones WHERE idreferencia='$idreferencia'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor[0];
				return $valorCampo;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function obtenerCostos($idreferencia){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT sum(montocosto) AS totalcostos FROM detalleventas WHERE idreferencia='$idreferencia'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor[0];
				return $valorCampo;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	function obtenerPagosVentas($idreferencia,$tablareferencia){
		$totalpagos=0;
		if($this->con->conectar()==true){
			//PAGOS DIRECTOS
			$pagos = "pagos" . $_SESSION["idsucursal"];
			$resultado2=mysqli_query($this->con->conect,"SELECT SUM(monto) AS totalpagos FROM $pagos WHERE idreferencia='$idreferencia' AND tablareferencia = '$tablareferencia'");
			if(mysqli_num_rows($resultado2) > 0){
				$filas2=mysqli_fetch_array($resultado2);
				$totalpagos=$filas2['totalpagos'];
				if (!$totalpagos){
					$totalpagos=0;
				}
			}else{
				$totalpagos=0;
			}
			
			//NOTAS DE CREDITO
			$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
			$resultado3=mysqli_query($this->con->conect,"SELECT SUM(total) AS totalnotasdecredito FROM $detallecotizacionesproductos WHERE $detallecotizacionesproductos.idcotizacionproducto ='$idreferencia' AND total < 0");
			if(mysqli_num_rows($resultado3) > 0){
			
				$filas3=mysqli_fetch_array($resultado3);
				$notasdecredito = $filas3['totalnotasdecredito'];
				$notasdecredito = $notasdecredito * -1;//hacer positivo el monto de notas de credito
				$totalpagos= $totalpagos + $notasdecredito;
			}
			
			return $totalpagos;
		}
	}
	
	function obtenerFechaLiquidacion($idreferencia,$tablareferencia){
		$fechaLiquidacion="";
		if($this->con->conectar()==true){
			$pagos = "pagos" . $_SESSION["idsucursal"];
			$resultado2=mysqli_query($this->con->conect,"SELECT fechapago FROM $pagos WHERE idreferencia='$idreferencia' AND tablareferencia = '$tablareferencia' ORDER BY fechapago DESC");
			if(mysqli_num_rows($resultado2) > 0){
				$filas2=mysqli_fetch_array($resultado2);
				$fechaLiquidacion=$filas2['fechapago'];
			}
			return $fechaLiquidacion;
		}
	}
	
	function obtenerPagosAjuste($tablareferencia){
		$totalpagos=0;
		if($this->con->conectar()==true){
			$resultado2=mysqli_query($this->con->conect,"SELECT SUM(monto) AS totalpagos FROM pagos WHERE tablareferencia='$tablareferencia'");
			if(mysqli_num_rows($resultado2) > 0){
				$filas2=mysqli_fetch_array($resultado2);
				$totalpagos=$filas2['totalpagos'];
			}else{
				$totalpagos=0;
			}
			return $totalpagos;
		}
	}
	
	function consultaLibre($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,$condicion);
		}
	}
	
	
	
}//Fin de la clase
?>