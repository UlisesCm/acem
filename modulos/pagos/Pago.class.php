<?php 
include_once("../../conexion/Conexion.class.php");

class Pago{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		$pagos = "pagos" . $_SESSION["idsucursal"];
		if ($condicion!=""){
			$consulta="WHERE (($pagos.descripcion LIKE '%".$condicion."%')) AND $pagos.idpago <>'0'";
		}else{
			$consulta="WHERE $pagos.idpago <>'0'";
		}
		return $consulta;
	}function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$pagos = "pagos" . $_SESSION["idsucursal"];
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from $pagos WHERE $campo = '$valor'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$numero_filas=$extractor["contador"];
				if ($tipoGuardado=='nuevo'){
					if ($numero_filas=="0"){
						return false;
					}else{
						return true;
					}
				}
				if ($tipoGuardado=='modificar'){
					if ($numero_filas=="1" or $numero_filas=="0"){
						return false;
					}else{
						return true;
					}
				}
			}else{
				return false;
			}
		}
	}
	
	function guardarCorte($totalefectivo,$totaltarjetadebito,$totaltarjetacredito,$totalcheque,$totaltransferencia,$totaldeposito,$totalnotadecredito,$totalaentregar,$listaSalidaEfectivo,$listaSalidaTarjetadedebito,$listaSalidaTarjetadecredito,$listaSalidaCheques,$listaSalidaTransferencias,$listaSalidaDepositos,$listaSalidaNotasdecredito){
		$validar="fracaso";
		if($this->con->conectar()==true){
			//INSERTAR REGISTRO CABEZA
			$idcortedecaja=$this->con->generarClave(2); /*Sincronizacion 1 */
			$fecha = date('Y-m-d');
			$hora = date("h:i:s");
			$idsucursal = $_SESSION['idsucursal'];
			$archivo="archivo";
			$consultaDet = "INSERT INTO cortesdecaja (idcortedecaja, fecha, hora, total, idsucursal, archivo, estatus) VALUES ('$idcortedecaja','$fecha','$hora','$totalaentregar','$idsucursal','$archivo','activo')";
			//echo $consultaDet;
			if(mysqli_query($this->con->conect,$consultaDet)){
				$validar="exito";
				//ACTUALIZAR LOS PAGOS INVOLUCRADOS 
				$ids = $listaSalidaEfectivo.$listaSalidaTarjetadedebito.$listaSalidaTarjetadecredito.$listaSalidaCheques.$listaSalidaTransferencias.$listaSalidaDepositos.$listaSalidaNotasdecredito;
				$ids = substr("$ids", 0, -1);
				$Pagos = "Pagos".$_SESSION['idsucursal'];
				$consultaDet = "UPDATE $Pagos SET corte = 'REALIZADO', idcortedecaja = $idcortedecaja WHERE idpago IN ($ids)";
				//echo $consultaDet;
				if(!mysqli_query($this->con->conect,$consultaDet)){
					$validar="fracaso";
				}
				//actualizar saldos
				$consultaDet = "UPDATE Sucursales SET efectivo = efectivo-$totalefectivo, tarjetadedebito=tarjetadedebito-$totaltarjetadebito, tarjetadecredito=tarjetadecredito-$totaltarjetacredito, cheques=cheques-$totalcheque, transferencias=transferencias-$totaltransferencia, depositos=depositos-$totaldeposito, notasdecredito=notasdecredito-$totalnotadecredito WHERE idsucursal = $idsucursal";
				if(!mysqli_query($this->con->conect,$consultaDet)){
					$validar="fracaso";
				}
			}
		}
	    return $validar;
	}

	function guardar($idreferencia,$tablareferencia,$idcliente,$idcaja,$fechapago,$formapago,$monto,$saldo,$tipo,$descripcion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['pagos']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$idSync=$this->con->generarClave(2); /*Sincronizacion 1 */
		if($this->con->conectar()==true){
			    $pagos = "pagos" . $_SESSION["idsucursal"];
			    $consultaDet = "INSERT INTO $pagos (idpago, idreferencia, tablareferencia, idcliente, idcaja, fechapago, formapago, monto, descripcion, estadopago, uuidpago, uuidfactura,corte,idcortedecaja) VALUES ('$idSync','$idreferencia','$tablareferencia','$idcliente','$idcaja','$fechapago','$formapago','$monto','$descripcion', '','','','PENDIENTE',0)";
			
				if(mysqli_query($this->con->conect,$consultaDet)){
					mysqli_query($this->con->conect,"UPDATE clientes SET saldo = saldo-$monto WHERE idcliente = '$idcliente'");
					
					$idsucursal = $_SESSION["idsucursal"];
					if ($formapago=="EFECTIVO"){
						mysqli_query($this->con->conect,"UPDATE sucursales SET efectivo = efectivo+$monto WHERE idsucursal = '$idsucursal'");
					}
					if ($formapago=="TARJETA DE DEBITO"){
						mysqli_query($this->con->conect,"UPDATE sucursales SET tarjetadedebito = tarjetadedebito+$monto WHERE idsucursal = '$idsucursal'");
					}
					if ($formapago=="TARJETA DE CREDITO"){
						mysqli_query($this->con->conect,"UPDATE sucursales SET tarjetadecredito = tarjetadecredito+$monto WHERE idsucursal = '$idsucursal'");
					}
					if ($formapago=="CHEQUE"){
						mysqli_query($this->con->conect,"UPDATE sucursales SET cheques = cheques+$monto WHERE idsucursal = '$idsucursal'");
					}
					if ($formapago=="TRANSFERENCIA"){
						mysqli_query($this->con->conect,"UPDATE sucursales SET transferencias = transferencias+$monto WHERE idsucursal = '$idsucursal'");
					}
					if ($formapago=="DEPOSITO"){
						mysqli_query($this->con->conect,"UPDATE sucursales SET depositos = depositos+$monto WHERE idsucursal = '$idsucursal'");
					}
					
					if ($saldo<=$monto){//MARCAR COMO PAGADA LA VENTA
						$tablareferencia = $tablareferencia . $_SESSION["idsucursal"];
						//analizar que tip ode cotización es la que se está pagando para dar valor al campo IDTABLA correspondiente
						$idtabla = "";
						//echo $tipo;
						if($tipo == "SERVICIOS"){
						    $idtabla = "idcotizacion";
						}
						if($tipo == "PRODUCTOS"){
						    $idtabla = "idcotizacionproducto";
						}
						if($tipo == "OTROS"){
						    $idtabla = "iddetallecotizacionotros";
						}
						mysqli_query($this->con->conect,"UPDATE $tablareferencia SET estadopago = 'PAGADO' WHERE $idtabla = '$idreferencia'");
						//echo "UPDATE $tablareferencia SET estadopago = 'PAGADO' WHERE $idtabla = '$idreferencia'";
					}
					
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla pagos ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
				
			
		}
	}
	
	
	
	function actualizarTipodePago($idreferencia,$tablareferencia,$tipocredito){
		
		if($this->con->conectar()==true){
			    $tablareferencia = $tablareferencia . $_SESSION["idsucursal"];
				$autorizado = "";
				if($tipocredito=="CONTADO"){
					$autorizado = "NO AUTORIZADO";
				}
				else{
					$autorizado = "AUTORIZADO";
				}
				$varConsulta = "UPDATE $tablareferencia SET estadocredito='$autorizado', descripcioncredito='$tipocredito' WHERE idcotizacionproducto ='$idreferencia'";
				if(mysqli_query($this->con->conect,$varConsulta)){
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($idreferencia,$tablareferencia,$idcliente,$idcaja,$fechapago,$formapago,$monto,$descripcion,$idpago){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['pagos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			    $pagos = "pagos" . $_SESSION["idsucursal"];
				if(mysqli_query($this->con->conect,"UPDATE $pagos SET idreferencia='$idreferencia', tablareferencia='$tablareferencia', idcliente='$idcliente', idcaja='$idcaja', fechapago='$fechapago', formapago='$formapago', monto='$monto', descripcion='$descripcion' WHERE idpago='$idpago'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idpago, de la tabla pagos ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idpago){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['pagos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			$pagos = "pagos" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"UPDATE $pagos SET estatus ='bloqueado' WHERE idpago = '$idpago'");
		}
	}
	
	function cambiarEstatus($idpago,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['pagos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			$pagos = "pagos" . $_SESSION["idsucursal"];
			if(mysqli_query($this->con->conect,"UPDATE $pagos SET estatus ='$estatus' WHERE idpago = '$idpago'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla pagos ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idpago){
		if($this->con->conectar()==true){
			$pagos = "pagos" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"SELECT * FROM $pagos WHERE idpago='$idpago'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$pagos = "pagos" . $_SESSION["idsucursal"];
			$resultado=mysqli_query($this->con->conect,"SELECT 
					$pagos.idpago,
					$pagos.idreferencia,
					$pagos.tablareferencia,
					$pagos.idcliente,
					$pagos.idcaja,
					$pagos.fechapago,
					$pagos.formapago,
					$pagos.monto,
					$pagos.descripcion,
					clientes.nombre AS nombreclientes,
					clientes.saldo AS saldoclientes,
					ventas.total AS totalventas,
					ventas.fecha AS fechaventas,
					ventas.estado AS estadoventas,
					ventas.facturada AS facturada,
					ventas.fechaplazo AS fechaplazoventas
					FROM $pagos 
					INNER JOIN clientes ON $pagos.idcliente=clientes.idcliente
					INNER JOIN ventas ON $pagos.idreferencia=ventas.idreferencia
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($idreferencia, $tablareferencia){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['pagos']['consultar'])){
			return "denegado";
			exit;
		}
		$pagos = "pagos" . $_SESSION["idsucursal"];
		
		if ($idreferencia==0){
			$where="WHERE $pagos.tablareferencia='$tablareferencia'";
		}else{
			$where="WHERE $pagos.idreferencia='$idreferencia'";
		}
		
		
		$consulta = "SELECT 
					$pagos.idpago,
					$pagos.idreferencia,
					$pagos.tablareferencia,
					$pagos.idcliente,
					$pagos.idcaja,
					$pagos.fechapago,
					$pagos.formapago,
					$pagos.monto,
					$pagos.descripcion,
					$pagos.estadopago
					FROM $pagos 
					$where
					";
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	
	
	function mostrarCorte($formadePago,$idcortedecaja){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['pagos']['consultar'])){
			return "denegado";
			exit;
		}
		$pagos = "pagos" . $_SESSION["idsucursal"];
		
		$where="";
		if($idcortedecaja==0){//mostrar todo lo pendiente
			$where="WHERE $pagos.formapago='$formadePago' AND corte = 'PENDIENTE'";
		}
		else{//mostrar solo la ocnsula del so detalles del cortedecaja
			$where="WHERE $pagos.formapago='$formadePago' AND idcortedecaja = $idcortedecaja";
		}
		
		$consulta = "SELECT 
					$pagos.idpago,
					$pagos.idreferencia,
					$pagos.tablareferencia,
					$pagos.idcliente,
					$pagos.idcaja,
					$pagos.fechapago,
					$pagos.formapago,
					$pagos.monto,
					$pagos.descripcion,
					$pagos.estadopago
					FROM $pagos 
					$where
					";
					//echo $consulta;
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	
	function mostrarA($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $idalmacen, $idcliente, $ticket, $tipo, $filtrarfecha="NO", $fechainicio="", $fechafin="", $formapago="", $diacobro, $facturada="", $marcarventa="no", $excel="", $estadopago="", $rfccliente="", $facturar="no"){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['pagos']['consultar'])){
			return "denegado";
			exit;
		}
		
		$consultaTipo=""; //
		$consultaCliente=""; //
		$consultaAlmacen=""; //
		$consultaTipo="";
		$consultaTicket=""; //
		$consultaFecha=""; //
		$consultaFormaPago=""; //
		$consultaDiaCobro=""; //
		$consultaFacturada=""; //
		$consultaDomicilio=""; //
		$limites="";
		$consultaEstado="";
		$consultaRFC="";
		
		$pagos = "pagos" . $_SESSION["idsucursal"];
		
		if($estadopago=="SIN REP"){
			$consultaEstado="AND $pagos.estadopago=''";
		}
		if($estadopago=="CON REP"){
			$consultaEstado="AND $pagos.estadopago<>''";
		}
		
		if($rfccliente!=""){
			$consultaRFC="AND facturacion.rfcreceptor='$rfccliente'";
		}
	
		
		if($excel!="SI"){
			$limites="LIMIT $inicial, $cantidadamostrar";
		}
		
		if ($formapago!=""){
			$consultaFormaPago="AND $pagos.formapago = '$formapago'";
		}
		
		if ($filtrarfecha=="SI"){
			$consultaFecha=" AND $pagos.fechapago>= '$fechainicio' AND $pagos.fechapago <= '$fechafin' ";
		}else{
			$consultaFecha="";
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
		
	
		
		if ($idcliente!=""){
			$consultaCliente=" AND $pagos.idcliente='$idcliente'";
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
		
		if ($tipo==""){
			$consultaTipo="";
		}else{
			$consultaTipo=" AND ventas.estado='$tipo'";
			if ($tipo=="fechavencida"){
				$fechaActual=date("Y-m-d");
				$consultaTipo=" AND ventas.fechaplazo < '$fechaActual'";
			}
		}
		
		$where="";
		$where="WHERE ventas.formapago='CREDITO' $consultaTicket $consultaAlmacen $consultaCliente $consultaTipo $consultaFecha $consultaFormaPago $consultaDiaCobro $consultaFacturada $consultaDomicilio $consultaEstado $consultaRFC";
		
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					$pagos.idpago,
					$pagos.idreferencia,
					$pagos.tablareferencia,
					$pagos.idcliente,
					$pagos.idcaja,
					$pagos.fechapago,
					$pagos.formapago,
					$pagos.monto,
					$pagos.descripcion,
					$pagos.estadopago,
					$pagos.uuidpago,
					$pagos.uuidfactura,
					ventas.ticket AS ticket,
					ventas.marcarventa AS marcarventa,
					ventas.estado AS estado,
					ventas.facturada AS facturada,
					clientes.nombre AS nombreclientes,
					almacenes.nombre AS nombrealmacenes
					FROM $pagos
					INNER JOIN clientes ON $pagos.idcliente=clientes.idcliente
					INNER JOIN ventas ON $pagos.idreferencia=ventas.idreferencia
					INNER JOIN facturacion ON facturacion.foliofiscal=ventas.foliofiscal
					INNER JOIN almacenes ON ventas.idalmacen=almacenes.idalmacen
					$where
					ORDER BY $campoOrden $orden 
					$limites
					";
					
		if($this->con->conectar()==true){
			$resultado1=mysqli_query($this->con->conect,$consulta);
			$resultado2=mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$resultado3=$where;
			$extractor = mysqli_fetch_assoc($resultado2);
			return array($resultado1,$extractor["contador"],$resultado3);
		}
	}
	
	
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			$pagos = "pagos" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"SELECT * FROM $pagos $condicion");
		}
	}
	
	function consultaLibre($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,$condicion);
		}
	}
	
	function obtenerConfiguracion($campo){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT $campo FROM configuracion WHERE 1");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor["$campo"];
				return $valorCampo;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function obtenerCliente($rfc){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT idpersona, razonsocial FROM personas WHERE rfc='$rfc'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$nombrepersona=$extractor["razonsocial"];
				$idpersona=$extractor["idpersona"];
				if($rfc=="XAXX010101000"){
					$nombrepersona="PUBLICO EN GENERAL";
				}
				$vars_cliente = array($idpersona, $nombrepersona);
				return $vars_cliente;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function registrarBitacora($accion,$descripcion){
		$idusuario=$_SESSION['idusuario'];
		$usuario=$_SESSION['usuario'];
		$descripcion="El usuario $usuario ".$descripcion;
		$hora=date('H:i');
		$fecha=date('Y-m-d');
		$modulo="pagos";
		if($this->con->conectar()==true){
			mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
		}
	}
	
	function eliminar($ids, $tipo, $idreferencia, $tablareferencia, $tipoEliminacion){
		/////PERMISOS////////////////
		$tablareferencia = $tablareferencia . $_SESSION["idsucursal"];
		if (!isset($_SESSION['permisos']['pagos']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$validar = "exito";
		if($this->con->conectar()==true){
			
			if ($tipoEliminacion=='real'){
				$pagos = "pagos" . $_SESSION["idsucursal"];
				$resultado=mysqli_query($this->con->conect,"SELECT idcliente, monto, formapago from $pagos WHERE idpago IN ($ids)");
				if ($resultado){
					$extractor = mysqli_fetch_array($resultado);
					$monto=$extractor["monto"];
					$formapago=$extractor["formapago"];
					$idcliente=$extractor["idcliente"];
					/*$idreferencia=$extractor["idreferencia"];
					$tablareferencia=$extractor["tablareferencia"];*/
				}else{
					return "fracaso";
					exit;
				}
				//analizar que tip ode cotización es la que se está pagando para dar valor al campo IDTABLA correspondiente
				$idtabla = "";
				if($tipo == "SERVICIOS"){
					$idtabla = "idcotizacion";
				}
				if($tipo == "PRODUCTOS"){
					$idtabla = "idcotizacionproducto";
				}
				if($tipo == "OTROS"){
					$idtabla = "iddetallecotizacionotros";
				}
				
				$pagos = "pagos" . $_SESSION["idsucursal"];
				if(mysqli_query($this->con->conect,"DELETE FROM $pagos WHERE idpago IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla pagos ";
						$this->registrarBitacora("eliminar",$descripcionB);
					}
				}else{
					return "fracaso";
				}
				
				
				
				/*$notasdecredito=0;
				if($tipo == "PRODUCTOS"){
					//CONSULTAR NOTAS DE CREDITO
					$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
					$varConsulta = "SELECT SUM(total) AS totalnotadecredito FROM $detallecotizacionesproductos WHERE idcotizacionproducto='$idcotizacionproducto' AND cantidad < 0";
					$resultado=mysqli_query($this->con->conect,$varConsulta);
					if ($resultado){
						$extractor = mysqli_fetch_array($resultado);
						$notasdecredito = $extractor["totalnotadecredito"];
						$notasdecredito = $notasdecredito *-1;//volverlo positivo
					}
				}*/
					
					//CONSULTAR PAGOS ACTIVOS
					//ACTUALIZAR ESTADOPAGO
				
				//$tablareferencia="cotizacionproducto";
				/*$tablareferenciaConsulta = "$tablareferencia" . $_SESSION["idsucursal"];
				$idcliente=0;
				$Opago = new Pago;
				$resultado = mysqli_query($this->con->conect,"SELECT * FROM $tablareferenciaConsulta WHERE $idtabla ='$idreferencia'");
				if(mysqli_num_rows($resultado) > 0){
					$filas=mysqli_fetch_array($resultado);
					$fechaventa=$filas['fecha'];
					$TotalVenta=$filas['total'];
					$idcliente=$filas['idcliente'];
					//$formapago=$filas['formapago'];
					//$devuelto=$filas['devuelto'];
					//PAGOS DIRECTOS
					$pagos = "pagos" . $_SESSION["idsucursal"];
					$resultado2 = mysqli_query($this->con->conect,"SELECT SUM(monto) AS totalpagos FROM $pagos WHERE idreferencia='$idreferencia' AND tablareferencia = '$tablareferencia'");
					if(mysqli_num_rows($resultado2) > 0){
						$filas2=mysqli_fetch_array($resultado2);
						$totalpagos=$filas2['totalpagos'];
					}
				}*/
				
				//if ($TotalVenta>$totalpagos){//MARCAR COMO PAGADA LA VENTA
				if(!mysqli_query($this->con->conect,"UPDATE $tablareferencia SET estadopago = 'NO PAGADO' WHERE $idtabla = '$idreferencia'")){
					return "fracaso";
				}
				//
				
				//mysqli_query($this->con->conect,"UPDATE $tablareferencia SET estadopago = 'NO PAGADO' WHERE $idtabla = '$idreferencia'");
				
				mysqli_query($this->con->conect,"UPDATE clientes SET saldo = saldo+$monto WHERE idcliente = '$idcliente'");
				
				//actualizar saldos por forma de pago de la sucursal
				$idsucursal = $_SESSION["idsucursal"];
			    
				if ($formapago=="EFECTIVO"){
					mysqli_query($this->con->conect,"UPDATE sucursales SET efectivo = efectivo-$monto WHERE idsucursal = '$idsucursal'");
				}
				if ($formapago=="TARJETA DE DEBITO"){
					mysqli_query($this->con->conect,"UPDATE sucursales SET tarjetadedebito = tarjetadedebito-$monto WHERE idsucursal = '$idsucursal'");
				}
				if ($formapago=="TARJETA DE CREDITO"){
					mysqli_query($this->con->conect,"UPDATE sucursales SET tarjetadecredito = tarjetadecredito-$monto WHERE idsucursal = '$idsucursal'");
				}
				if ($formapago=="CHEQUE"){
					mysqli_query($this->con->conect,"UPDATE sucursales SET cheques = cheques-$monto WHERE idsucursal = '$idsucursal'");
				}
				if ($formapago=="TRANSFERENCIA"){
					mysqli_query($this->con->conect,"UPDATE sucursales SET transferencias = transferencias-$monto WHERE idsucursal = '$idsucursal'");
				}
				if ($formapago=="DEPOSITO"){
					mysqli_query($this->con->conect,"UPDATE sucursales SET depositos = depositos-$monto WHERE idsucursal = '$idsucursal'");
				}
				return "exito";
			}
		}
	}
}
?>