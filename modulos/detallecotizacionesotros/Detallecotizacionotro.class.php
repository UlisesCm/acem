<?php 
include_once("../../conexion/Conexion.class.php");

class Detallecotizacionotro{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE (($detallecotizacionesotros.idcliente LIKE '%".$condicion."%') OR ($detallecotizacionesotros.concepto LIKE '%".$condicion."%') OR ($detallecotizacionesotros.total LIKE '%".$condicion."%') OR ($detallecotizacionesotros.estadopago LIKE '%".$condicion."%') OR ($detallecotizacionesotros.estadofacturacion LIKE '%".$condicion."%') OR ($detallecotizacionesotros.factura LIKE '%".$condicion."%'))AND $detallecotizacionesotros.estatus ='eliminado'";
			}else{
				$consulta="WHERE (($detallecotizacionesotros.idcliente LIKE '%".$condicion."%') OR ($detallecotizacionesotros.concepto LIKE '%".$condicion."%') OR ($detallecotizacionesotros.total LIKE '%".$condicion."%') OR ($detallecotizacionesotros.estadopago LIKE '%".$condicion."%') OR ($detallecotizacionesotros.estadofacturacion LIKE '%".$condicion."%') OR ($detallecotizacionesotros.factura LIKE '%".$condicion."%'))AND $detallecotizacionesotros.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE $detallecotizacionesotros.estatus ='eliminado'";
			}else{
				$consulta="WHERE $detallecotizacionesotros.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from $detallecotizacionesotros WHERE $campo = '$valor'");
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

	function guardar($idcliente,$fecha,$cantidad,$concepto,$unidad,$numeroservicio,$totalservicios,$idcotizacionotros,$precio,$impuestos,$total,$idmodeloimpuestos,$estadopago,$estadofacturacion,$factura,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesotros']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$iddetallecotizacionotros=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("iddetallecotizacionotros",$iddetallecotizacionotros, "nuevo")){
				return "iddetallecotizacionotrosExiste";
			}else{
				$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
				if(mysqli_query($this->con->conect,"INSERT INTO $detallecotizacionesotros (iddetallecotizacionotros, idcliente, fecha, cantidad, concepto, unidad, numeroservicio, totalservicios, idcotizacionotros, precio, impuestos, total, idmodeloimpuestos, estadopago, estadofacturacion, factura, estatus) VALUES ('$iddetallecotizacionotros','$idcliente','$fecha','$cantidad','$concepto','$unidad','$numeroservicio','$totalservicios','$idcotizacionotros','$precio','$impuestos','$total','$idmodeloimpuestos','$estadopago','$estadofacturacion','$factura','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla detallecotizacionesotros ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizar($idcliente,$fecha,$cantidad,$concepto,$unidad,$numeroservicio,$totalservicios,$idcotizacionotros,$precio,$impuestos,$total,$idmodeloimpuestos,$estadopago,$estadofacturacion,$factura,$estatus,$iddetallecotizacionotros){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesotros']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("iddetallecotizacionotros",$iddetallecotizacionotros, "modificar")){
				return "iddetallecotizacionotrosExiste";
			}else{
				$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
				if(mysqli_query($this->con->conect,"UPDATE $detallecotizacionesotros SET idcliente='$idcliente', fecha='$fecha', cantidad='$cantidad', concepto='$concepto', unidad='$unidad', numeroservicio='$numeroservicio', totalservicios='$totalservicios', idcotizacionotros='$idcotizacionotros', precio='$precio', impuestos='$impuestos', total='$total', idmodeloimpuestos='$idmodeloimpuestos', estadopago='$estadopago', estadofacturacion='$estadofacturacion', factura='$factura', estatus='$estatus' WHERE iddetallecotizacionotros='$iddetallecotizacionotros'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $iddetallecotizacionotros, de la tabla detallecotizacionesotros ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizarDato($campo,$valor,$iddetallecotizacionotros,$idmodeloimpuestos,$cantidad){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesotros']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		//CALCULAR LOS IMPUESTOS Y ACTUALIZAR PRECIO
		$impuestos = 0;
		$total = 0;
		if($this->con->conectar()==true){
			//REVISAR SI LA ACTUALIZACIÓN ES DE PRECIO O FECHA
			if($idmodeloimpuestos == "Fecha"){
				//ACTUALIZAR FECHA
					   if($this->con->conectar()==true){
						   $detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
							if(mysqli_query($this->con->conect,"UPDATE $detallecotizacionesotros SET $campo='$valor' WHERE iddetallecotizacionotros='$iddetallecotizacionotros'")){
								   //BITACORA
									if ($_SESSION['bitacora']=="si"){
										$descripcionB="modific&oacute; el registro ID: $iddetallecotizacionotros, de la tabla iddetallecotizacion";
										$this->registrarBitacora("modificar",$descripcionB);
									}
									return "exito@SeActualizoFecha@SeActualizoFecha";
								}else{
									return "fracaso";
								}
						
						}//fin IF conectar
						else{
							return "fracaso";
						}
			}
			else{
				    $resultado=mysqli_query($this->con->conect,"SELECT * FROM impuestos WHERE idmodeloimpuesto = $idmodeloimpuestos");
					if ($resultado){
						$extractor = mysqli_fetch_array($resultado);
					    $subtotal = $cantidad * $valor;
						if($extractor["nombre"] == "IVA" && $extractor["tipo"] == "TRASLADO"){
							$valorimpuesto = $extractor["valor"];
							$impuestos = $subtotal * $valorimpuesto;
						}
						$total = $subtotal + $impuestos;
						
					   //ACTUALIZAR EL PRECIO
					   if($this->con->conectar()==true){
						   //OBTENER EL PRECIO ACTUAL PARA SACAR LA DIFERENCIA Y ACTUALIZAR EL SALDO DEL CLIENTE
						   //obtener el MONTO TOTAL ACTUAL idcotizacion otrosy idcliente que tambien se ocuparan DEL DETALLE COTIZACIONOTROS
							$totalActual = 0;
							$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
							$resultado=mysqli_query($this->con->conect,"SELECT total,idcliente,idcotizacionotros FROM $detallecotizacionesotros where iddetallecotizacionotros = $iddetallecotizacionotros");
							$totalActual = 0;
							$idcliente = 0;
							$idcotizacionotros = 0;
							if ($resultado){
								$extractor = mysqli_fetch_array($resultado);
								$totalActual = $extractor["total"];
								$idcliente = $extractor["idcliente"];
								$idcotizacionotros = $extractor["idcotizacionotros"];
							}
							
							//ACTUALIZAR EL SALDO DEL CLIENTE
							$diferencia = $totalActual - $total;
							//multiplicamos la diferencia por -1 para que se invierta de positivo a negativo o viceversa para efectos de aplicarsela al saldo del cliente 
							$diferencia = $diferencia*-1;
							/*if($diferencia>0){//como fue diferencia positiva se debe restar pro lo tanto la convertimos en negativo
							   $diferencia = $diferencia*-1;
							}
							else{//si es diferencia negativa la convertimos a positivo porque debe sumarse
							   $diferencia = $diferencia*-1;
							}*/
							if(mysqli_query($this->con->conect,"UPDATE clientes SET saldo = saldo +($diferencia) WHERE idcliente = $idcliente")){
								//ACTUALIZAR PRECIO DE DETALLECOTIZACIÓNOTROS
								if(mysqli_query($this->con->conect,"UPDATE $detallecotizacionesotros SET $campo='$valor', impuestos = $impuestos, total = $total WHERE iddetallecotizacionotros='$iddetallecotizacionotros'")){
									//ACTUALIZAR EL TOTAL DE LA COTIZACIÓN
									//obtener la suma de todos los servicios de esta cotización
									$resultado=mysqli_query($this->con->conect,"SELECT SUM(total) AS Suma FROM $detallecotizacionesotros where idcotizacionotros = $idcotizacionotros");
									if ($resultado){
										$extractor = mysqli_fetch_array($resultado);
										$sumaTotalDetalles = $extractor["Suma"];
									}
									//actualizar el monto de la cotizacion
									$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
									if(mysqli_query($this->con->conect,"UPDATE $cotizacionesotros SET monto='$sumaTotalDetalles' WHERE idcotizacionesotros ='$idcotizacionotros'")){
										return "exito@$impuestos@$total";
									}
									else{
										return "fracaso";
									}
									
								}else{
									return "fracaso";
								}
					       }//FIN if update clientes saldo
						
						}//fin IF conectar
						else{
							return "fracaso";
						}
					}//fin if resultado
					else{
						return "fracaso";
					}
			}//fin if Fecha
		}//fin IF conectar
		else{
			return "fracaso";
		}
	}
	
	function bloquear($iddetallecotizacionotros){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesotros']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"UPDATE $detallecotizacionesotros SET estatus ='bloqueado' WHERE iddetallecotizacionotros = '$iddetallecotizacionotros'");
		}
	}
	
	function cambiarEstatus($iddetallecotizacionotros,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesotros']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
			if(mysqli_query($this->con->conect,"UPDATE $detallecotizacionesotros SET estatus ='$estatus' WHERE iddetallecotizacionotros = '$iddetallecotizacionotros'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla detallecotizacionesotros ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($iddetallecotizacionotros){
		if($this->con->conectar()==true){
			$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"SELECT * FROM $detallecotizacionesotros WHERE iddetallecotizacionotros='$iddetallecotizacionotros'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
			$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
			$resultado=mysqli_query($this->con->conect,"SELECT 
					$detallecotizacionesotros.iddetallecotizacionotros,
					$detallecotizacionesotros.idcliente,
					$detallecotizacionesotros.fecha,
					$detallecotizacionesotros.cantidad,
					$detallecotizacionesotros.concepto,
					$detallecotizacionesotros.unidad,
					$detallecotizacionesotros.numeroservicio,
					$detallecotizacionesotros.totalservicios,
					$detallecotizacionesotros.idcotizacionotros,
					$detallecotizacionesotros.precio,
					$detallecotizacionesotros.impuestos,
					$detallecotizacionesotros.total,
					$detallecotizacionesotros.idmodeloimpuestos,
					$detallecotizacionesotros.estadopago,
					$detallecotizacionesotros.estadofacturacion,
					$detallecotizacionesotros.factura,
					$detallecotizacionesotros.estatus,
					Clientes.idcliente AS idclienteClientes,
					Clientes.nombre AS nombrecliente,
					$cotizacionesotros.idcotizacionesotros AS idcotizacionotrosCotizacionesotros,
					$cotizacionesotros.folio AS folio,
					$cotizacionesotros.serie AS serie,
					Modelosimpuestos.idmodeloimpuestos AS idmodeloimpuestosModelosimpuestos,
					Modelosimpuestos.nombre AS modeloimpuestos
					FROM $detallecotizacionesotros 
					INNER JOIN Clientes ON $detallecotizacionesotros.idcliente=Clientes.idcliente
					INNER JOIN $cotizacionesotros ON $detallecotizacionesotros.idcotizacionotros=$cotizacionesotros.idcotizacionesotros
					INNER JOIN Modelosimpuestos ON $detallecotizacionesotros.idmodeloimpuestos=Modelosimpuestos.idmodeloimpuestos
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesotros']['consultar'])){
			return "denegado";
			exit;
		}
		
		$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					$detallecotizacionesotros.iddetallecotizacionotros,
					$detallecotizacionesotros.idcliente,
					$detallecotizacionesotros.fecha,
					$detallecotizacionesotros.cantidad,
					$detallecotizacionesotros.concepto,
					$detallecotizacionesotros.unidad,
					$detallecotizacionesotros.numeroservicio,
					$detallecotizacionesotros.totalservicios,
					$detallecotizacionesotros.idcotizacionotros,
					$detallecotizacionesotros.precio,
					$detallecotizacionesotros.impuestos,
					$detallecotizacionesotros.total,
					$detallecotizacionesotros.idmodeloimpuestos,
					$detallecotizacionesotros.estadopago,
					$detallecotizacionesotros.estadofacturacion,
					$detallecotizacionesotros.factura,
					$detallecotizacionesotros.estatus,
					Clientes.idcliente AS idclienteClientes,
					Clientes.nombre AS nombrecliente,
					$cotizacionesotros.idcotizacionesotros AS idcotizacionotrosCotizacionesotros,
					$cotizacionesotros.folio AS folio,
					$cotizacionesotros.serie AS serie,
					Modelosimpuestos.idmodeloimpuestos AS idmodeloimpuestosModelosimpuestos,
					Modelosimpuestos.nombre AS modeloimpuestos
					FROM $detallecotizacionesotros 
					INNER JOIN Clientes ON $detallecotizacionesotros.idcliente=Clientes.idcliente
					INNER JOIN $cotizacionesotros ON $detallecotizacionesotros.idcotizacionotros=$cotizacionesotros.idcotizacionesotros
					INNER JOIN Modelosimpuestos ON $detallecotizacionesotros.idmodeloimpuestos=Modelosimpuestos.idmodeloimpuestos
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
		/*if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}*/
		
		if($this->con->conectar()==true){
			
			$resultado1 = mysqli_query($this->con->conect,$consulta);
			$resultado2 =  mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			return array ($resultado1,$extractor["contador"]);
		}
	}
	
	function mostrarA($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcliente,$idsucursal,$filtrarfecha,$fechainicio,$fechafin,$idcotizacionesotros,$iddetallecotizacionotros,$excel=""){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesotros']['consultar'])){
			return "denegado";
			exit;
		}
		
		$limites = "";
		$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
		$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
		if($idcotizacionesotros !="" || $iddetallecotizacionotros !=""){//CONSULTAR LOS DETALLES DE ESTA COTIZACION O DETALLE EN ESPECIFICO
		    if($idcotizacionesotros !="" ){
				$where="WHERE $detallecotizacionesotros.iddetallecotizacionotros<>0 AND $detallecotizacionesotros.idcotizacionotros = $idcotizacionesotros ";
			}
			if($iddetallecotizacionotros !="" ){
				$where="WHERE $detallecotizacionesotros.iddetallecotizacionotros<>0 AND $detallecotizacionesotros.iddetallecotizacionotros = $iddetallecotizacionotros ";
			}
		}
		else{//REALIZAR CONSULTA SEGUN LO SELECCIONADO EN LOS FILTROS
		        $consultaCliente = "";
				$consultaSucursal = "";
				$consultaFecha = "";
				
				
				if ($idcliente!=""){
					$consultaCliente=" AND $detallecotizacionesotros.idcliente='$idcliente' ";
				}
				
				if ($idsucursal!="TODAS"){
					$consultaSucursal=" AND $cotizacionesotros.idsucursal='$idsucursal' ";
				}
				
				if ($filtrarfecha=="SI"){
					$consultaFecha=" AND $detallecotizacionesotros.fecha >= '$fechainicio' AND $detallecotizacionesotros.fecha <= '$fechafin' ";
				}else{
					$consultaFecha="";
				}
				
				if($papelera){
						$consultaEstatus="AND $detallecotizacionesotros.estatus ='eliminado' ";
				}else{
						$consultaEstatus="AND $detallecotizacionesotros.estatus <>'eliminado' ";
				}
				
				
				$where="";
				$where="WHERE $detallecotizacionesotros.iddetallecotizacionotros<>0 
				$consultaCliente
				$consultaSucursal
				$consultaFecha
				$consultaEstatus";
		}
		
		if($excel!="SI"){
			$limites="LIMIT $inicial, $cantidadamostrar";
		}
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					$detallecotizacionesotros.iddetallecotizacionotros,
					$detallecotizacionesotros.idcliente,
					$detallecotizacionesotros.fecha,
					$detallecotizacionesotros.cantidad,
					$detallecotizacionesotros.concepto,
					$detallecotizacionesotros.unidad,
					$detallecotizacionesotros.numeroservicio,
					$detallecotizacionesotros.totalservicios,
					$detallecotizacionesotros.idcotizacionotros,
					$detallecotizacionesotros.precio,
					$detallecotizacionesotros.impuestos,
					$detallecotizacionesotros.total,
					$detallecotizacionesotros.idmodeloimpuestos,
					$detallecotizacionesotros.estadopago,
					$detallecotizacionesotros.estadofacturacion,
					$detallecotizacionesotros.factura,
					$detallecotizacionesotros.estatus,
					Clientes.idcliente AS idclienteClientes,
					Clientes.nombre AS nombrecliente,
					$cotizacionesotros.idcotizacionesotros AS idcotizacionotrosCotizacionesotros,
					$cotizacionesotros.folio AS folio,
					$cotizacionesotros.serie AS serie,
					Modelosimpuestos.idmodeloimpuestos AS idmodeloimpuestosModelosimpuestos,
					Modelosimpuestos.nombre AS modeloimpuestos
					FROM $detallecotizacionesotros 
					INNER JOIN Clientes ON $detallecotizacionesotros.idcliente=Clientes.idcliente
					INNER JOIN $cotizacionesotros ON $detallecotizacionesotros.idcotizacionotros=$cotizacionesotros.idcotizacionesotros
					INNER JOIN Modelosimpuestos ON $detallecotizacionesotros.idmodeloimpuestos=Modelosimpuestos.idmodeloimpuestos
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
					//echo $consulta;// REVISAR CONSULTA
		/*if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}*/
		
		if($this->con->conectar()==true){
			
			$resultado1 = mysqli_query($this->con->conect,$consulta);
			$resultado2 =  mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			return array ($resultado1,$extractor["contador"]);
		}
	}
	
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"SELECT * FROM $detallecotizacionesotros $condicion");
		}
	}
	
	function consultaLibre($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,$condicion);
		}
	}
	
	function obtenerConfiguracion($campo){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT $campo FROM configuracion WHERE concepto='$campo' ");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor["valor"];
				return $valorCampo;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function registrarBitacora($accion,$descripcion,$idcontrol="",$tablacontrol="",$clasificacion="",$extra=""){
		$idusuario=$_SESSION['idusuario'];
		$usuario=$_SESSION['usuario'];
		$descripcion="El usuario $usuario ".$descripcion;
		$hora=date('H:i');
		$fecha=date('Y-m-d');
		$modulo="detallecotizacionesotros";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesotros']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
				if (mysqli_query($this->con->conect,"UPDATE $detallecotizacionesotros SET estatus ='eliminado' WHERE iddetallecotizacionotros IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla detallecotizacionesotros ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
				if(mysqli_query($this->con->conect,"DELETE FROM $detallecotizacionesotros WHERE iddetallecotizacionotros IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla detallecotizacionesotros ";
						$this->registrarBitacora("eliminar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
}
?>