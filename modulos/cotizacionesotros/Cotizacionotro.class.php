<?php 
include_once("../../conexion/Conexion.class.php");

include_once("../../folios/Folio.class.php");

class Cotizacionotro{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE (($cotizacionesotros.serie LIKE '%".$condicion."%') OR ($cotizacionesotros.folio LIKE '%".$condicion."%') OR ($cotizacionesotros.monto LIKE '%".$condicion."%') OR ($cotizacionesotros.idcliente LIKE '%".$condicion."%') OR ($cotizacionesotros.idsucursal LIKE '%".$condicion."%') OR ($cotizacionesotros.idempleado LIKE '%".$condicion."%'))AND $cotizacionesotros.estatus ='eliminado'";
			}else{
				$consulta="WHERE (($cotizacionesotros.serie LIKE '%".$condicion."%') OR ($cotizacionesotros.folio LIKE '%".$condicion."%') OR ($cotizacionesotros.monto LIKE '%".$condicion."%') OR ($cotizacionesotros.idcliente LIKE '%".$condicion."%') OR ($cotizacionesotros.idsucursal LIKE '%".$condicion."%') OR ($cotizacionesotros.idempleado LIKE '%".$condicion."%'))AND $cotizacionesotros.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE $cotizacionesotros.estatus ='eliminado'";
			}else{
				$consulta="WHERE $cotizacionesotros.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from $cotizacionesotros WHERE $campo = '$valor'");
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
	
	function descomponerArreglo($elementosPorVuelta,$elementoSeleccionado, $arreglo){
		$totalElementos= count($arreglo);
		if ($totalElementos!=1){
			$con=0;
			$totalVueltas=$totalElementos/$elementosPorVuelta;
			while($con<$totalVueltas){
				$array[$con]= $arreglo[$elementoSeleccionado];
				$elementoSeleccionado=$elementoSeleccionado+$elementosPorVuelta;
				$con++;
			}
			return $array;
		}else{
			return $arreglo;
		}
		
	}
	
	function guardarDetalles($idcotizacionesotros,$lista,$idcliente,$estatus,$idsucursal,$idmodeloimpuestos,$asignacion,$conexion){
			//GUARDAR LOS DETALLES DE LA COTIZACIÓN
			$arregloId=$this->descomponerArreglo(8,0,$lista);
			$arregloFecha=$this->descomponerArreglo(8,1,$lista);//parametros (el numero de campos que completan el primer registro, la posición del arreglo que va a tomar, la lista)
			$arregloCantidad=$this->descomponerArreglo(8,2,$lista);
			$arregloConcepto=$this->descomponerArreglo(8,3,$lista);
			$arregloUnidad=$this->descomponerArreglo(8,4,$lista);
			$arregloPrecio=$this->descomponerArreglo(8,5,$lista);
			$arregloImporte=$this->descomponerArreglo(8,6,$lista);
			$arregloImpuestos=$this->descomponerArreglo(8,7,$lista);
			$con=0;
			$validar=true;
			$totaldeservicios = count($arregloId);
			while ($con < count($arregloId)){
				$fecha=$arregloFecha[$con];
                $fechaFormateada = date("Y-m-d", strtotime($fecha));
				$cantidad=$arregloCantidad[$con];
				$concepto=$arregloConcepto[$con];
				$unidad = $arregloUnidad[$con];
				$precio=$arregloPrecio[$con];
				$totalFila = $arregloImporte[$con];
				$Impuestos =$arregloImpuestos[$con];
				$iddetallecotizacionotros=$this->con->generarClave(1).$con; /*Sincronizacion 1 */
				
				$numservicio = $con + 1;
				
				$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
				$consultaDet = "INSERT INTO $detallecotizacionesotros (iddetallecotizacionotros, idcliente, fecha, cantidad, concepto, unidad, numeroservicio, totalservicios, idcotizacionotros, precio, impuestos, total, idmodeloimpuestos, estadopago, estadofacturacion, factura, estatus) VALUES ('$iddetallecotizacionotros','$idcliente','$fechaFormateada','$cantidad','$concepto','$unidad','$numservicio','$totaldeservicios','$idcotizacionesotros','$precio','$Impuestos','$totalFila','$idmodeloimpuestos','NO PAGADO','NO FACTURADO','-','$estatus')";
				//echo $consultaDet;
				if(!mysqli_query($conexion,$consultaDet)){
					$validar=false;
				}
				$con++;
		   }
		return $validar;
	}

	
	function guardar($serie,$folio,$fecha,$tipo,$monto,$idcliente,$idsucursal,$idempleado,$observaciones,$lista,$impuestos,$subtotal,$idmodeloimpuestos,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesotros']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$idcotizacionesotros=$this->con->generarClave(2); /*Sincronizacion 1 */
		$validar = "fracaso";
		if($this->con->conectar()==true){
			if($this->comprobarCampo("idcotizacionesotros",$idcotizacionesotros, "nuevo")){
				return "idcotizacionesotrosExiste";
			}else{
				$this->con->conect->autocommit(false); //INICO DE TRANSACCION
				
				//CONSULTA Y ACTUALIZA VARIABLE FOLIO 
				$Ofolio = new Folio;
				$folio=$Ofolio->obtenerFolio("OTROS");
				$idusuario = $_SESSION["idusuario"];
				//INCREMENTAR EL FOLIO
				if(mysqli_query($this->con->conect,"UPDATE Folios SET folioactual = folioactual + 1 WHERE idsucursal = '$idsucursal' AND asignacion = 'OTROS' AND estatus = 'activo'")){
					$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
					$consulta = "INSERT INTO $cotizacionesotros (idcotizacionesotros, serie, folio, fecha, tipo, monto, idcliente, idsucursal, idempleado,idusuario, observaciones, estatus) VALUES ('$idcotizacionesotros','$serie','$folio','$fecha','$tipo','$monto','$idcliente','$idsucursal','$idempleado','$idusuario','$observaciones','$estatus')";
					//echo $consulta;
					if(mysqli_query($this->con->conect,$consulta)){
						if($this->guardarDetalles($idcotizacionesotros,$lista,$idcliente,$estatus,$idsucursal,$idmodeloimpuestos,'OTROS',$this->con->conect)){//guarda lso detalles de la cotización
							
							//INCREMENTAR SALDO CLIENTE
							if(mysqli_query($this->con->conect,"UPDATE clientes SET saldo = saldo+$monto WHERE idcliente = $idcliente")){
								$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
							    $validar = "exito";
							}
							else{
								$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
								$validar = "fracaso";
							}
							
						}
						else{
							$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
							$validar = "fracaso";
						}
					}
				}//fin if actualiza folio
				else{
					$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
					$validar = "fracaso";
				}
			}
		}
		return $validar;
	}
	
	function actualizar($serie,$folio,$fecha,$tipo,$monto,$idcliente,$idsucursal,$idempleado,$observaciones,$estatus,$idcotizacionesotros){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesotros']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("idcotizacionesotros",$idcotizacionesotros, "modificar")){
				return "idcotizacionesotrosExiste";
			}else{
				$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
				if(mysqli_query($this->con->conect,"UPDATE $cotizacionesotros SET serie='$serie', folio='$folio', fecha='$fecha', tipo='$tipo', monto='$monto', idcliente='$idcliente', idsucursal='$idsucursal', idempleado='$idempleado', observaciones='$observaciones', estatus='$estatus' WHERE idcotizacionesotros='$idcotizacionesotros'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idcotizacionesotros, de la tabla cotizacionesotros ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function bloquear($idcotizacionesotros){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesotros']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"UPDATE $cotizacionesotros SET estatus ='bloqueado' WHERE idcotizacionesotros = '$idcotizacionesotros'");
		}
	}
	
	function cambiarEstatus($idcotizacionesotros,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesotros']['modificar'])){
			
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
			if(mysqli_query($this->con->conect,"UPDATE $cotizacionesotros SET estatus ='$estatus' WHERE idcotizacionesotros = '$idcotizacionesotros'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla cotizacionesotros ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idcotizacionesotros){
		if($this->con->conectar()==true){
			$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"SELECT * FROM $cotizacionesotros WHERE idcotizacionesotros='$idcotizacionesotros'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
			$resultado=mysqli_query($this->con->conect,"SELECT 
					$cotizacionesotros.idcotizacionesotros,
					$cotizacionesotros.serie,
					$cotizacionesotros.folio,
					$cotizacionesotros.fecha,
					$cotizacionesotros.tipo,
					$cotizacionesotros.monto,
					$cotizacionesotros.idcliente,
					$cotizacionesotros.idsucursal,
					$cotizacionesotros.idempleado,
					$cotizacionesotros.observaciones,
					$cotizacionesotros.estatus,
					Clientes.idcliente AS idclienteClientes,
					Clientes.nombre AS nombrecliente,
					Sucursales.idsucursal AS idsucursalSucursales,
					Sucursales.nombre AS nombresucursal,
					Empleados.idempleado AS idempleadoEmpleados,
					Empleados.nombre AS nombreempleado
					FROM $cotizacionesotros 
					INNER JOIN Clientes ON $cotizacionesotros.idcliente=Clientes.idcliente
					INNER JOIN Sucursales ON $cotizacionesotros.idsucursal=Sucursales.idsucursal
					INNER JOIN Empleados ON $cotizacionesotros.idempleado=Empleados.idempleado
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesotros']['consultar'])){
			return "denegado";
			exit;
		}
		
		$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					$cotizacionesotros.idcotizacionesotros,
					$cotizacionesotros.serie,
					$cotizacionesotros.folio,
					$cotizacionesotros.fecha,
					$cotizacionesotros.tipo,
					$cotizacionesotros.monto,
					$cotizacionesotros.idcliente,
					$cotizacionesotros.idsucursal,
					$cotizacionesotros.idempleado,
					$cotizacionesotros.observaciones,
					$cotizacionesotros.estatus,
					Clientes.idcliente AS idclienteClientes,
					Clientes.nombre AS nombrecliente,
					Sucursales.idsucursal AS idsucursalSucursales,
					Sucursales.nombre AS nombresucursal,
					Empleados.idempleado AS idempleadoEmpleados,
					Empleados.nombre AS nombreempleado
					FROM $cotizacionesotros 
					INNER JOIN Clientes ON $cotizacionesotros.idcliente=Clientes.idcliente
					INNER JOIN Sucursales ON $cotizacionesotros.idsucursal=Sucursales.idsucursal
					INNER JOIN Empleados ON $cotizacionesotros.idempleado=Empleados.idempleado
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
	
	function mostrarA($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcliente, $idsucursal, $filtrarfecha, $fechainicio, $fechafin,$excel=""){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesotros']['consultar'])){
			return "denegado";
			exit;
		}
		
		//$condicion= trim($condicion);
		//$where=$this->armarConsulta($condicion,$papelera);
		$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
		$consultaCliente = "";
		$consultaSucursal = "";
		$consultaFecha = "";
		$limites = "";
		
		if ($idcliente!=""){
			$consultaCliente=" AND $cotizacionesotros.idcliente='$idcliente'";
		}
		if ($idsucursal!="TODAS"){
			$consultaSucursal=" AND $cotizacionesotros.idsucursal='$idsucursal'";
		}
		if ($filtrarfecha=="SI"){
			$consultaFecha=" AND $cotizacionesotros.fecha >= '$fechainicio' AND $cotizacionesotros.fecha <= '$fechafin' ";
		}else{
			$consultaFecha="";
		}
		
		if($papelera){
				$consultaEstatus="AND $cotizacionesotros.estatus ='eliminado'";
		}else{
				$consultaEstatus="AND $cotizacionesotros.estatus <>'eliminado'";
		}
		
		//$SoloAceptados = "AND cotizaciones.estado ='ACEPTADA' ";
		
		if($excel!="SI"){
			$limites="LIMIT $inicial, $cantidadamostrar";
		}
		
		$where="";
		$where="WHERE $cotizacionesotros.idcotizacionesotros<>0 
		$consultaCliente
		$consultaSucursal
		$consultaFecha
		$consultaEstatus";
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					$cotizacionesotros.idcotizacionesotros,
					$cotizacionesotros.serie,
					$cotizacionesotros.folio,
					$cotizacionesotros.fecha,
					$cotizacionesotros.tipo,
					$cotizacionesotros.monto,
					$cotizacionesotros.idcliente,
					$cotizacionesotros.idsucursal,
					$cotizacionesotros.idempleado,
					$cotizacionesotros.observaciones,
					$cotizacionesotros.estatus,
					Clientes.idcliente AS idclienteClientes,
					Clientes.nombre AS nombrecliente,
					Sucursales.idsucursal AS idsucursalSucursales,
					Sucursales.nombre AS nombresucursal,
					Empleados.idempleado AS idempleadoEmpleados,
					Empleados.nombre AS nombreempleado
					FROM $cotizacionesotros 
					INNER JOIN Clientes ON $cotizacionesotros.idcliente=Clientes.idcliente
					INNER JOIN Sucursales ON $cotizacionesotros.idsucursal=Sucursales.idsucursal
					INNER JOIN Empleados ON $cotizacionesotros.idempleado=Empleados.idempleado
					$where
					ORDER BY $campoOrden $orden 
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
			return array ($resultado1,$extractor["contador"]);
		}
	}
	
	
	
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"SELECT * FROM $cotizacionesotros $condicion");
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
		$modulo="cotizacionesotros";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesotros']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
				if (mysqli_query($this->con->conect,"UPDATE $cotizacionesotros SET estatus ='eliminado' WHERE idcotizacionesotros IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla cotizacionesotros ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
				if(mysqli_query($this->con->conect,"DELETE FROM $cotizacionesotros WHERE idcotizacionesotros IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla cotizacionesotros ";
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