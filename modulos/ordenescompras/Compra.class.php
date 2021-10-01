<?php 
include_once("../../conexion/Conexion.class.php");
include_once("../../folios/Folio.class.php");
class Compra{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			$consulta="WHERE ((compras.idsucursal LIKE '%".$condicion."%') OR (compras.idproveedor LIKE '%".$condicion."%'))AND compras.idcompra <>'0'";
		}else{
			$consulta="WHERE compras.idcompra <>'0'";
		}
		return $consulta;
	}function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from requisiciones WHERE $campo = '$valor'");
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
	
	function obtenerDatosProveedor($idproducto, $parametrocotizacion){
		$idproveedor=0;
		$precio1=0;
		$nombreproveedor="NO ENCONTRADO";
		
		if ($parametrocotizacion=="precio"){
			$consulta="SELECT
						precioscompra.precio1,
						precioscompra.idproveedor,
						proveedores.nombre AS nombreproveedor
						FROM precioscompra 
						INNER JOIN proveedores ON proveedores.idproveedor=precioscompra.idproveedor
						WHERE precioscompra.idproducto ='$idproducto'
						ORDER BY
						precioscompra.precio1 ASC,
						proveedores.tiemporespuesta ASC,
						proveedores.nivelexistencia DESC,
						proveedores.nivelcalidad DESC
						LIMIT 1";
		}
		
		if ($parametrocotizacion=="tiempo"){
			$consulta="SELECT
						precioscompra.precio1,
						precioscompra.idproveedor,
						proveedores.nombre AS nombreproveedor
						FROM precioscompra 
						INNER JOIN proveedores ON proveedores.idproveedor=precioscompra.idproveedor
						WHERE precioscompra.idproducto ='$idproducto'
						ORDER BY
						proveedores.tiemporespuesta ASC,
						precioscompra.precio1 ASC,
						proveedores.nivelexistencia DESC,
						proveedores.nivelcalidad DESC
						LIMIT 1";
		}
		
		if ($parametrocotizacion=="existencia"){
			$consulta="SELECT
						precioscompra.precio1,
						precioscompra.idproveedor,
						proveedores.nombre AS nombreproveedor
						FROM precioscompra 
						INNER JOIN proveedores ON proveedores.idproveedor=precioscompra.idproveedor
						WHERE precioscompra.idproducto ='$idproducto'
						ORDER BY
						proveedores.nivelexistencia DESC,
						precioscompra.precio1 ASC,
						proveedores.tiemporespuesta ASC,
						proveedores.nivelcalidad DESC
						LIMIT 1";
		}
		
		if ($parametrocotizacion=="calidad"){
			$consulta="SELECT
						precioscompra.precio1,
						precioscompra.idproveedor,
						proveedores.nombre AS nombreproveedor
						FROM precioscompra 
						INNER JOIN proveedores ON proveedores.idproveedor=precioscompra.idproveedor
						WHERE precioscompra.idproducto ='$idproducto'
						ORDER BY
						proveedores.nivelcalidad DESC,
						precioscompra.precio1 ASC,
						proveedores.tiemporespuesta ASC,
						proveedores.nivelexistencia DESC
						LIMIT 1";
		}
		
		if($this->con->conectar()==true){
			$resultadoIn=mysqli_query($this->con->conect,$consulta);
			if(mysqli_num_rows($resultadoIn) > 0){
				$filasIn=mysqli_fetch_array($resultadoIn);
				$idproveedor= $filasIn['idproveedor'];
				$precio1= $filasIn['precio1'];
				$nombreproveedor= $filasIn['nombreproveedor'];
			}
		}
		
		$datosProveedor = array($idproveedor,$nombreproveedor,$precio1);
		return $datosProveedor;
	}
	
	function mostrarProveedores($idproducto){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT
			precioscompra.precio1,
			precioscompra.idproveedor,
			proveedores.nombre AS nombreproveedor,
			proveedores.nivelcalidad AS calidad,
			proveedores.nivelexistencia AS existencia,
			proveedores.tiemporespuesta AS tiempo
			FROM precioscompra
			INNER JOIN proveedores ON proveedores.idproveedor=precioscompra.idproveedor
			WHERE proveedores.estatus<>'eliminado' AND precioscompra.idproducto='$idproducto'
			ORDER BY precioscompra.precio1 ASC
			");
		}
		
	}
	
	function comprobarCompras($idcompra,$idsucursal,$idproveedor,$idscompra,$idssucursales,$idsproveedores){
		$con=0;
		while ($con < count($idscompra)) {
			if ($idssucursales[$con]==$idsucursal and $idsproveedores[$con]==$idproveedor){
				return $idscompra[$con];
			}
			$con++;
		}
		return false;
	}

	
	function guardarAsignacion($idrequisicion,$fecha,$hora,$serie,$folio,$idempleado,$comentarios,$idcompra,$estado, $lista, $modo, $conexion){
		
			$idscompra = array();
			$idssucursales=array();
			$idsproveedores=array();
			$estadoRequisicion="Aceptada";
			
			$arregloIdproducto=$this->descomponerArreglo(5,0,$lista);
			$arregloCantidad=$this->descomponerArreglo(5,1,$lista);
			$arregloCosto=$this->descomponerArreglo(5,2,$lista);
			$arregloIdsucursal=$this->descomponerArreglo(5,3,$lista);
			$arregloIdproveedor=$this->descomponerArreglo(5,4,$lista);
			
			$con=0;
			$validar=true;
			$resdelte=mysqli_query($conexion,"DELETE FROM detallecompras WHERE idcompra='$idcompra'");
			if ($resdelte){
				while ($con < count($arregloIdproducto)){
					$idproducto=$arregloIdproducto[$con];
					$idproveedor=$arregloIdproveedor[$con];
					$idsucursal=$arregloIdsucursal[$con];
					$cantidad=$arregloCantidad[$con];
					$costo=$arregloCosto[$con];
					$monto=$costo*$cantidad;
					
					$idcompra=$this->comprobarCompras($idcompra,$idsucursal,$idproveedor,$idscompra,$idssucursales,$idsproveedores);
					if ($idcompra===false){
						$idcompra=$this->con->generarClave(0).$con; /*Sincronizacion 1 */
						
						array_push($idscompra,$idcompra);
						array_push($idssucursales,$idsucursal);
						array_push($idsproveedores,$idproveedor);
						
						$Ofolio = new Folio;
						$folio=$Ofolio->obtenerFolio("COMPRAS");
						$fechaenvio=$fecha." ".$hora;
						
						if(!mysqli_query($conexion,"INSERT INTO compras (idcompra, fecha, hora, serie, folio, fechavencimiento, idempleado, comentarios, estado, monto, autorizado, idretiro, idsucursal, idproveedor, factura, facturaxml, uuid, idrequisicion, fechaenvio) VALUES ('$idcompra','$fecha','$hora','$serie','$folio','$fecha','$idempleado','$comentarios','$estado','0','NO AUTORIZADO','0','$idsucursal','$idproveedor','','','','$idrequisicion','$fechaenvio')")){
							$validar=false;
						}else{
							if(!mysqli_query($conexion,"UPDATE Folios SET folioactual = folioactual + 1 WHERE idsucursal = '$idsucursal' AND asignacion = 'COMPRAS' AND estatus = 'activo'")){
								$validar=false;
							}
						
						}
						if ($modo=="normal"){
							if ($idproveedor!=0){
								$iddetallecompra=$this->con->generarClave2(0).$con;
								if(!mysqli_query($conexion,"INSERT INTO detallecompras (iddetallecompra, idcompra, idproducto, cantidad, costo, monto, idproveedor, idsucursal, estado) VALUES ('$iddetallecompra','$idcompra','$idproducto','$cantidad','$costo','$monto','$idproveedor','$idsucursal','$estado')")){
									$validar=false;
								}else{ 
									if(!mysqli_query($conexion,"UPDATE detallerequisiciones SET estado='PEDIDO' WHERE idrequisicion='$idrequisicion' AND idproducto='$idproducto'")){
										$validar=false;
									}
								}
							}else{
								$estadoRequisicion="pendiente";
							}
						}else{ //Si el modo es descartar
							if ($idproveedor!=0){
								$iddetallecompra=$this->con->generarClave2(0).$con;
								if(!mysqli_query($conexion,"INSERT INTO detallecompras (iddetallecompra, idcompra, idproducto, cantidad, costo, monto, idproveedor, idsucursal, estado) VALUES ('$iddetallecompra','$idcompra','$idproducto','$cantidad','$costo','$monto','$idproveedor','$idsucursal','$estado')")){
									$validar=false;
								}else{ 
									if(!mysqli_query($conexion,"UPDATE detallerequisiciones SET estado='PEDIDO' WHERE idrequisicion='$idrequisicion' AND idproducto='$idproducto'")){
										$validar=false;
									}
								}
							}else{
								if(!mysqli_query($conexion,"DELETE FROM detallerequisiciones WHERE idrequisicion='$idrequisicion' AND idproducto='$idproducto'")){
									$validar=false;
								}
							}
							
						}
						
					}else{
						$iddetallecompra=$this->con->generarClave2(0).$con;
						if(!mysqli_query($conexion,"INSERT INTO detallecompras (iddetallecompra, idcompra, idproducto, cantidad, costo, monto, idproveedor, idsucursal, estado) VALUES ('$iddetallecompra','$idcompra','$idproducto','$cantidad','$costo','$monto','$idproveedor','$idsucursal','$estado')")){
							$validar=false;
						}
					}
					
					$con++;
				} //Fin de while
				
				if(!$this->actualizarRequisiciones($idrequisicion,$estadoRequisicion,$conexion)){ //Si no se actualizan los estados de las requisiciones
					$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
					$validar=false;
				}
				
			}else{
				$validar=false;
			}
			return $validar;
	}
	
	function guardarAsignacionActualizar($fecha,$idempleado,$comentarios,$idcompra,$estado,$idproveedor, $idsucursal, $lista ,$conexion){
		
			$idscompra = array();
			$idssucursales=array();
			$idsproveedores=array();
			
			$arregloIdproducto=$this->descomponerArreglo(3,0,$lista);
			$arregloCantidad=$this->descomponerArreglo(3,1,$lista);
			$arregloCosto=$this->descomponerArreglo(3,2,$lista);
			
			$con=0;
			$validar=true;
			$resdelte=mysqli_query($conexion,"DELETE FROM detallecompras WHERE idcompra='$idcompra'");
			if ($resdelte){
				while ($con < count($arregloIdproducto)){
					$idproducto=$arregloIdproducto[$con];
					$cantidad=$arregloCantidad[$con];
					$costo=$arregloCosto[$con];
					$monto=$costo*$cantidad;
						
					$iddetallecompra=$this->con->generarClave2(0).$con;
					if(!mysqli_query($conexion,"INSERT INTO detallecompras (iddetallecompra, idcompra, idproducto, cantidad, costo, monto, idproveedor, idsucursal, estado) VALUES ('$iddetallecompra','$idcompra','$idproducto','$cantidad','$costo','$monto','$idproveedor','$idsucursal','$estado')")){
						$validar=false;
					}
					
					$con++;
				}
				$monto=$this->obtenerCostoTotal($idcompra,$this->con->conect);
				if ($monto=="error"){
					$validar=false;
				}else{
					if(!mysqli_query($conexion,"UPDATE compras SET monto='$monto' WHERE idcompra='$idcompra'")){
						$validar=false;
					}
				}
				
			
			}else{
				$validar=false;
			}
			return $validar;
	}


	
	
	function guardar($fecha,$hora,$serie,$folio,$idempleado,$comentarios,$estado,$monto,$lista, $modo, $listaRequisiciones){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['ordenescompras']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$validar = "fracaso";
		
		if($this->con->conectar()==true){
			
				$this->con->conect->autocommit(false); //INICO DE TRANSACCION
				
				//CONSULTA Y ACTUALIZA VARIABLE FOLIO 
				
				
				$idcompra=$this->con->generarClave(2); /*Sincronizacion 1 */
				
				if(true){
					
					/*if(!$this->actualizarRequisiciones($listaRequisiciones,"Aceptada",$this->con->conect)){ //Si no se actualizan los estados de las requisiciones
						$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
						$validar="fracaso@0";
					}else{*/
						if ($this->guardarAsignacion($listaRequisiciones,$fecha,$hora,$serie,$folio,$idempleado,$comentarios,$idcompra,$estado,$lista, $modo, $this->con->conect)){

								$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
								$validar="exito@$idcompra";
						}else{
							$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
							$validar="fracaso@0";
						}
					//}
					
					
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla compras ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return $validar;
				}else{
					return $validar;
				}
			
		}
	}
	
	
	function actualizarRequisiciones($ids, $estado, $conexion){
		if ($ids!=""){
			if(mysqli_query($conexion,"UPDATE requisiciones SET estado='$estado' WHERE idrequisicion IN ($ids)")){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
	
	function actualizar($fecha,$fechavencimiento,$idempleado,$comentarios,$estado,$monto,$idsucursal,$idproveedor,$factura,$idcompra, $lista){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['compras']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$validar = "fracaso";
		
		if($this->con->conectar()==true){
			
			$this->con->conect->autocommit(false); //INICO DE TRANSACCION
			
			
			if(mysqli_query($this->con->conect,"UPDATE compras SET fecha='$fecha', fechavencimiento='$fechavencimiento', idempleado='$idempleado', comentarios='$comentarios', estado='$estado', monto='$monto', idsucursal='$idsucursal', idproveedor='$idproveedor', factura='$factura' WHERE idcompra='$idcompra'")){
				
				if ($this->guardarAsignacionActualizar($fecha,$idempleado,$comentarios,$idcompra,$estado,$idproveedor,$idsucursal,$lista,$this->con->conect)){
					$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
					$validar="exito@$idcompra";
				}else{
					$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
					$validar="fracaso@0";
				}
					
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="modific&oacute; el registro ID: $idcompra, de la tabla compras ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return $validar;
			}else{
				return $validar;
			}
		}
	}


	function actualizarDetalles($fecha,$idempleado,$idsucursal,$comentarios,$estado,$idrequisicion,$lista){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['ordenescompras']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$validar = "fracaso";
		
		if($this->con->conectar()==true){
			
				$this->con->conect->autocommit(false); //INICO DE TRANSACCION
				
				if(mysqli_query($this->con->conect,"UPDATE requisiciones SET fecha='$fecha', idempleado='$idempleado', idsucursal='$idsucursal', comentarios='$comentarios', estado='$estado' WHERE idrequisicion='$idrequisicion'")){
					
					
					if ($this->guardarAsignacion($idrequisicion,$idsucursal,$lista,$this->con->conect)){
						$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
						$validar="exito@$idrequisicion";
					}else{
						$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
						$validar="fracaso";
						exit;
					}
					
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla requisiciones ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito@$idrequisicion";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function obtenerClaveProducto($idproducto,$idproveedor){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT clave FROM productosproveedores WHERE idproducto='$idproducto' AND  idproveedor='$idproveedor'");
			if(mysqli_num_rows($resultado)!=0){
				$extractor = mysqli_fetch_array($resultado);
				$clave=$extractor['clave'];
				return $clave;
			}else{
				return "";
			}
		}
	}
	
	function consultarImpresion($idcompra,$idproveedor){
		$consulta = "SELECT
					SQL_CALC_FOUND_ROWS
					detallecompras.iddetallecompra,
					detallecompras.idcompra,
					detallecompras.idproducto,
					detallecompras.cantidad,
					detallecompras.idproveedor,
					detallecompras.idsucursal,
					productos.nombre AS nombreproducto,
					productos.idunidad,
					unidades.nombre AS unidad
					FROM detallecompras
					INNER JOIN productos ON productos.idproducto=detallecompras.idproducto
					INNER JOIN unidades ON productos.idunidad=unidades.idunidad
					WHERE detallecompras.idcompra='$idcompra' AND detallecompras.idproveedor='$idproveedor'
					";
		if($this->con->conectar()==true){
			$resultado1=mysqli_query($this->con->conect,$consulta);
			$resultado2=mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			return array($resultado1,$extractor["contador"]);
		}
		
	}
	
	
	function mostrarIndividual($idcompra){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT
					compras.idcompra,
					compras.fecha,
					compras.fechavencimiento,
					compras.idempleado,
					compras.comentarios,
					compras.estado,
					compras.monto,
					compras.idsucursal,
					compras.idproveedor,
					compras.factura,
					empleados.nombre AS nombreempleados,
					sucursales.nombre AS nombresucursales,
					proveedores.nombre AS nombreproveedores
					FROM compras 
					INNER JOIN empleados ON compras.idempleado=empleados.idempleado
					INNER JOIN sucursales ON compras.idsucursal=sucursales.idsucursal
					INNER JOIN proveedores ON compras.idproveedor=proveedores.idproveedor
					WHERE idcompra='$idcompra'");
		}
	}
	
	function consultarCodigoProducto($idproducto,$idproveedor){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT
					idproducto,
					idproveedor,
					claveproductoproveedor
					FROM precioscompra 
					WHERE idproducto='$idproducto' AND idproveedor='$idproveedor'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$claveProducto=$extractor["claveproductoproveedor"];
				return $claveProducto;
			}else{
				return "";
			}
		}else{
			return "";
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					requisiciones.idrequisicion,
					requisiciones.tipo,
					requisiciones.concepto,
					requisiciones.fechamovimiento,
					requisiciones.idsucursal,
					requisiciones.numerocomprobante,
					requisiciones.comentarios,
					requisiciones.idreferencia,
					requisiciones.estatus,
					sucursales.nombre AS nombrealmacenes
					FROM requisiciones 
					INNER JOIN sucursales ON requisiciones.idsucursal=sucursales.idsucursal
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function obtenerCosto($idproducto){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT promedio FROM inventario WHERE idproducto = '$idproducto'");
			if(mysqli_num_rows($resultado) > 0){
				while ($filas=mysqli_fetch_array($resultado)) {
					$costo= $filas['promedio'];
				}
				return $costo;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	function obtenerCostoTotal($idcompra, $conexion){
		$resultado=mysqli_query($conexion,"SELECT SUM(monto) AS TotalMonto FROM detallecompras WHERE idcompra = '$idcompra'");
		if($resultado){
			if(mysqli_num_rows($resultado) > 0){
				$filas=mysqli_fetch_array($resultado);
				$campo= $filas["TotalMonto"];
				return $campo;
			}else{
				return 0;
			}
		}else{
			return "error";
		}
	}
	

	
	function obtenerCampo($tabla, $campo, $idcampo, $valorcampo){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT $campo FROM $tabla WHERE $idcampo = '$valorcampo'");
			if(mysqli_num_rows($resultado) > 0){
				while ($filas=mysqli_fetch_array($resultado)) {
					$campo= $filas[0];
				}
				return $campo;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $consultaExtra){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['compras']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					compras.idcompra,
					compras.fecha,
					compras.idempleado,
					compras.comentarios,
					compras.estado,
					compras.monto,
					compras.idsucursal,
					compras.idproveedor,
					compras.factura,
					compras.fechaenvio,
					empleados.nombre AS nombreempleados,
					sucursales.nombre AS nombresucursales,
					proveedores.nombre AS nombreproveedores
					FROM compras 
					INNER JOIN empleados ON compras.idempleado=empleados.idempleado
					INNER JOIN sucursales ON compras.idsucursal=sucursales.idsucursal
					INNER JOIN proveedores ON compras.idproveedor=proveedores.idproveedor
					$where $consultaExtra
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
		if($this->con->conectar()==true){
			$resultado1=mysqli_query($this->con->conect,$consulta);
			$resultado2=mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			return array($resultado1,$extractor["contador"]);
		}
	}
	
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM requisiciones $condicion");
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
	
	function registrarBitacora($accion,$descripcion){
		if($this->con->conectar()==true){
			$idusuario=$_SESSION['idusuario'];
			$usuario=$_SESSION['usuario'];
			$descripcion="El usuario $usuario ".$descripcion;
			$hora=date('H:i');
			$fecha=date('Y-m-d');
			$modulo="requisiciones";
			mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
		}
	}
	
	function eliminarAsignacion($idproducto, $idsucursal, $conexion){
		$validar=true;
	
			$resultado=mysqli_query($conexion,"SELECT * FROM kardex WHERE idproducto ='$idproducto' AND idsucursal='$idsucursal' ORDER BY fechamovimiento ASC");
			if(!$resultado){
				$validar=false;
			}
			$existencia=0;
			$saldo=0;
			$debe=0;
			$haber=0;
			$promedio=0;
			$idkardex=0;
			$contador=0;
			$primeraEntrada=true;
			if(mysqli_num_rows($resultado) > 0){
				while ($filas=mysqli_fetch_array($resultado)) {
					$salida= $filas['salida']; //Obtenemos el tipo de movimiento 0 si es entrada y diferente de 0 es salida
					$idkardex=$filas['idkardex'];
					if ($contador==0){ //Si es el primer registro
						if ($salida=="0"){ //Si el registro es una entrada
							$entrada=$filas['entrada'];
							$costounitario=$filas['costounitario'];
							$promedio=$costounitario;
							$existencia=$existencia+$entrada;
							$haber=0;
							$debe=$entrada*$promedio;
							$saldo=$saldo+$debe;
							if(!mysqli_query($conexion,"UPDATE kardex SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'")){
								$validar=false;
							}
						}else{ //Si el registro es una salida
							$salida=$filas['salida'];
							$costounitario=$filas['costounitario'];
							$promedio=$filas['promedio'];
							$existencia=$filas['existencia'];
							$saldo=$filas['saldo'];
							$debe=0;
							$haber=$filas['haber'];
						}
					}else{ //Si no es el primer registro
						if ($salida=="0"){ //Si el registro es una entrada
							$entrada=$filas['entrada'];
							$costounitario=$filas['costounitario'];
							$existencia=$existencia+$entrada;
							$debe=$entrada*$costounitario;
							$haber=0;
							$saldo=$saldo+$debe;
							$promedio=$saldo/$existencia;
							if(!mysqli_query($conexion,"UPDATE kardex SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'")){
								$validar=false;
							}
						
						}else{ //Si el registro es una salida
							$salida=$filas['salida'];
							$costounitario=$promedio;
							$existencia=$existencia-$salida;
							$haber=$salida*$costounitario;
							$debe=0;
							$saldo=$saldo-$haber;
							if(!mysqli_query($conexion,"UPDATE kardex SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'")){
								$validar=false;
							}
						}
					
					}
					//$this->actualizarInventario($idsucursal,$idproducto,"","0","baja");
					//INICIO ACTUALIZAR INVENTARIO
					
					$tipoActualizacion="baja";
					$ubicacion="";
					$minimo="0";
					
					
					$resultadoIn=mysqli_query($conexion,"SELECT * FROM kardex WHERE idproducto ='$idproducto' AND idsucursal='$idsucursal' ORDER BY fechamovimiento DESC, idkardex DESC LIMIT 1");
					if (!$resultadoIn){ //Si ocurre un error al ejectura el SELECT
						$validar=false;
					}
					if(mysqli_num_rows($resultadoIn) > 0){
						$filasIn=mysqli_fetch_array($resultadoIn);
						$costopromedio= $filasIn['promedio'];
						$saldo= $filasIn['saldo'];
						$existencia= $filasIn['existencia'];
					}else{
						$saldo=0;
						$existencia=0;
						$costopromedio=0;
					}
					
					$resultadoIn=mysqli_query($conexion,"SELECT * FROM kardex WHERE idproducto ='$idproducto' AND idsucursal='$idsucursal' ORDER BY fechamovimiento ASC, idkardex ASC LIMIT 1");
					if (!$resultadoIn){ //Si ocurre un error al ejectura el SELECT
						$validar=false;
					}
					
					if(mysqli_num_rows($resultadoIn) > 0){
						$filasIn=mysqli_fetch_array($resultadoIn);
						$salida= $filasIn['salida'];
						$promediov=$filasIn['promedio'];
					}else{
						$salida=0;
						$promediov=0;
					}
					if ($salida=="0" && $promediov > 0){ //Salida=0 significa que es entrada
						$estado="Costo correctamente calculado";
					}else{
						$estado="Requiere revisar costo";
						$tipoActualizacion="baja";
					}
					
					$resultadoIn=mysqli_query($conexion,"SELECT * FROM inventario WHERE idproducto ='$idproducto' AND idsucursal='$idsucursal'");
					if (!$resultadoIn){ //Si ocurre un error al ejectura el SELECT
						$validar=false;
					}
					if(mysqli_num_rows($resultadoIn) > 0){
						$filasIn=mysqli_fetch_array($resultadoIn);
						$idinventario=$filasIn['idinventario'];
						if ($tipoActualizacion=="alta"){
							if(!mysqli_query($conexion,"UPDATE inventario SET existencia='$existencia', saldo='$saldo', promedio='$costopromedio', existencia='$existencia', ubicacion='$ubicacion', minimo='$minimo', estado='$estado' WHERE idinventario='$idinventario'")){
								$validar=false;
							}
						}else{
							if (!mysqli_query($conexion,"UPDATE inventario SET existencia='$existencia', saldo='$saldo', promedio='$costopromedio', existencia='$existencia', estado='$estado' WHERE idinventario='$idinventario'")){
								$validar=false;
							}
						}
						$costopromedio= $filasIn['promedio'];
						$saldo= $filasIn['saldo'];
						$existencia= $filasIn['existencia'];
					}else{
						$idinventarioS=$this->con->generarClave2(2); /*Sincronizacion 1 */
						if(!mysqli_query($conexion,"INSERT INTO inventario (idinventario, idsucursal, idproducto, existencia, promedio, saldo, minimo, ubicacion, estado) VALUES ('$idinventarioS','$idsucursal','$idproducto','$existencia','$costopromedio','$saldo','$minimo','$ubicacion','$estado')")){
							$validar=false;
						}
					}
					//FIN ACTUALIZAR INVENTARIO
					
					
					
					
					
					
					$contador++;
				} //Fin de while
				
			}else{ //Fin de if resultados num_rows > 0 Sino...
				
				
				//INICIO ACTUALIZAR INVENTARIO
					
					$tipoActualizacion="baja";
					$ubicacion="";
					$minimo="0";
					
					
					$resultadoIn=mysqli_query($conexion,"SELECT * FROM kardex WHERE idproducto ='$idproducto' AND idsucursal='$idsucursal' ORDER BY fechamovimiento DESC, idkardex DESC LIMIT 1");
					if (!$resultadoIn){ //Si ocurre un error al ejectura el SELECT
						$validar=false;
					}
					if(mysqli_num_rows($resultadoIn) > 0){
						$filasIn=mysqli_fetch_array($resultadoIn);
						$costopromedio= $filasIn['promedio'];
						$saldo= $filasIn['saldo'];
						$existencia= $filasIn['existencia'];
					}else{
						$saldo=0;
						$existencia=0;
						$costopromedio=0;
					}
					
					$resultadoIn=mysqli_query($conexion,"SELECT * FROM kardex WHERE idproducto ='$idproducto' AND idsucursal='$idsucursal' ORDER BY fechamovimiento ASC, idkardex ASC LIMIT 1");
					if (!$resultadoIn){ //Si ocurre un error al ejectura el SELECT
						$validar=false;
					}
					
					if(mysqli_num_rows($resultadoIn) > 0){
						$filasIn=mysqli_fetch_array($resultadoIn);
						$salida= $filasIn['salida'];
						$promediov=$filasIn['promedio'];
					}else{
						$salida=0;
						$promediov=0;
					}
					if ($salida=="0" && $promediov > 0){ //Salida=0 significa que es entrada
						$estado="Costo correctamente calculado";
					}else{
						$estado="Requiere revisar costo";
						$tipoActualizacion="baja";
					}
					
					$resultadoIn=mysqli_query($conexion,"SELECT * FROM inventario WHERE idproducto ='$idproducto' AND idsucursal='$idsucursal'");
					if (!$resultadoIn){ //Si ocurre un error al ejectura el SELECT
						$validar=false;
					}
					if(mysqli_num_rows($resultadoIn) > 0){
						$filasIn=mysqli_fetch_array($resultadoIn);
						$idinventario=$filasIn['idinventario'];
						if ($tipoActualizacion=="alta"){
							if(!mysqli_query($conexion,"UPDATE inventario SET existencia='$existencia', saldo='$saldo', promedio='$costopromedio', existencia='$existencia', ubicacion='$ubicacion', minimo='$minimo', estado='$estado' WHERE idinventario='$idinventario'")){
								$validar=false;
							}
						}else{
							if (!mysqli_query($conexion,"UPDATE inventario SET existencia='$existencia', saldo='$saldo', promedio='$costopromedio', existencia='$existencia', estado='$estado' WHERE idinventario='$idinventario'")){
								$validar=false;
							}
						}
						$costopromedio= $filasIn['promedio'];
						$saldo= $filasIn['saldo'];
						$existencia= $filasIn['existencia'];
					}else{
						$idinventarioS=$this->con->generarClave2(2); /*Sincronizacion 1 */
						if(!mysqli_query($conexion,"INSERT INTO inventario (idinventario, idsucursal, idproducto, existencia, promedio, saldo, minimo, ubicacion, estado) VALUES ('$idinventarioS','$idsucursal','$idproducto','$existencia','$costopromedio','$saldo','$minimo','$ubicacion','$estado')")){
							$validar=false;
						}
					}
					//FIN ACTUALIZAR INVENTARIO
				
				
			}
		return $validar;
	}// Fin de funcion
	
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['ordenescompras']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$validar = "exito";
		if($this->con->conectar()==true){
			
			$this->con->conect->autocommit(false); //INICO DE TRANSACCION
			
			
			if ($tipoEliminacion=='real'){
				$con=0;
				$idsproductos[0]=0;
				$idsucursal=0;
				$idsnuevo=explode(",",$ids);
				
				if(!mysqli_query($this->con->conect,"DELETE FROM detallecompras WHERE idcompra IN ($ids)")){
					$validar = "fracaso";
				}else{
					if(mysqli_query($this->con->conect,"DELETE FROM compras WHERE idcompra IN ($ids)")){
						$validar="exito";
					}else{
						$validar = "fracaso";
					}
				}
			}
		}else{
			$validar = "fracaso";
		}
		
		if ($validar=="exito"){
			$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
		}else{
			$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
		}
		return $validar;
	}
	
	
}
?>