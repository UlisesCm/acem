<?php 
include_once("../../conexion/Conexion.class.php");

class Facturacion{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((facturacion.foliointerno LIKE '%".$condicion."%') OR (facturacion.receptor LIKE '%".$condicion."%') OR (facturacion.rfcreceptor LIKE '%".$condicion."%') OR (facturacion.foliofiscal LIKE '%".$condicion."%'))AND facturacion.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((facturacion.foliointerno LIKE '%".$condicion."%') OR (facturacion.receptor LIKE '%".$condicion."%') OR (facturacion.rfcreceptor LIKE '%".$condicion."%') OR (facturacion.foliofiscal LIKE '%".$condicion."%'))AND facturacion.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE facturacion.estatus ='eliminado'";
			}else{
				$consulta="WHERE facturacion.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from facturacion WHERE $campo = '$valor'");
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

	function guardar($foliointerno,$fecha,$tipo,$clasificacion,$emisor,$rfcemisor,$receptor,$rfcreceptor,$subTotal,$montototal,$montopagado,$estado,$fechapago,$formapago,$cuenta,$foliofiscal,$observaciones,$relaciones,$archivo,$moneda,$tipocambio,$numparcialidad,$idsrelacionadas,$estatus,$tiporelacion,$arregloUUID,$idtemporal,$idsReferencias,$codigopostal){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['facturacion']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idfactura=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
				$this->con->conect->autocommit(false); //INICO DE TRANSACCION
			
				if(mysqli_query($this->con->conect,"INSERT INTO facturacion (idfactura, foliointerno, fecha, tipo, clasificacion, emisor, rfcemisor, receptor, rfcreceptor, montototal, montopagado, estado, fechapago, formapago, cuenta, foliofiscal, observaciones, relaciones, archivo, moneda, tipocambio, numparcialidad, estatus) VALUES ('$idfactura','$foliointerno','$fecha','$tipo','$clasificacion','$emisor','$rfcemisor','$receptor','$rfcreceptor','$montototal','$montopagado','$estado','$fechapago','$formapago','$cuenta','$foliofiscal','$observaciones','$relaciones','$archivo','$moneda','$tipocambio','$numparcialidad','$estatus')")){
					
					if($tiporelacion!=""){
						for ($i=0; $i<count($arregloUUID); $i++){
							$resres=$this->guardarRelacion($foliofiscal, $arregloUUID[$i], $tiporelacion, $tipo, $this->con->conect);
							if (!$resres){
								$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
								return "fracasoRelaciones";
							}
						}
					}
					/////////////////* MODULO DE FACTURACION INTEGRADO
					if ($idtemporal!=0) { //Si se han cargado datos desde la consulta de ventas
						$idsucursal=$_SESSION['idsucursal'];
						if ($tipo=="I"){
							if(!mysqli_query($this->con->conect,"UPDATE detallecotizacionesproductos$idsucursal SET cfdiingreso='$foliofiscal' WHERE iddetallecotizacion IN ($idsReferencias)")){
								$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
								return "fracasoDetalle";
							}
							$resCotizaciones=mysqli_query($this->con->conect,"SELECT idcotizacionproducto FROM detallecotizacionesproductos$idsucursal WHERE iddetallecotizacion IN ($idsReferencias) GROUP BY idcotizacionproducto");
							if(!$resCotizaciones){
								$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
								return "fracasoSelectDetalle";
							}
							
							$contadorTotal=0;
							$contadorFacturadas=0;
							$estadoFactura="FACTURADA";
							$con=0;
							while ($filasC=mysqli_fetch_array($resCotizaciones)) {
								$idcotizacion =$filasC['idcotizacionproducto'];
								$resCount1=mysqli_query($this->con->conect,"SELECT COUNT(*) AS contadorTotal FROM detallecotizacionesproductos$idsucursal WHERE idcotizacionproducto='$idcotizacion'");
								
								if($resCount1){
									$filasN1=mysqli_fetch_array($resCount1);
									$contadorTotal=$filasN1['contadorTotal'];
								}else{
									$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
									return "fracasoContarTotal";
								}
								$resCount2=mysqli_query($this->con->conect,"SELECT COUNT(*) AS contadorFacturadas FROM detallecotizacionesproductos$idsucursal WHERE idcotizacionproducto='$idcotizacion' AND cfdiingreso <> ''");
								
								if($resCount2){
									$filasN2=mysqli_fetch_array($resCount2);
									$contadorFacturadas=$filasN2['contadorFacturadas'];
								}else{
									$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
									return "fracasoContarFacturadas";
								}
								
								if ($contadorFacturadas==$contadorTotal){
									$estadoFactura="FACTURADA";
								}else{
									$estadoFactura="PARCIALMENTE FACTURADA";
								}
								
								if(!mysqli_query($this->con->conect,"UPDATE cotizacionesproductos$idsucursal SET estadofacturacion='$estadoFactura' WHERE idcotizacionproducto='$idcotizacion'")){
									$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
									return "fracasoActualizarCotizacion";
								}
								
								$idarchivo=$this->con->generarClave(1).$con; /*Sincronizacion 1 */
								$pdf=$archivo.".pdf";
								$xml=$archivo.".xml";
								$folios=explode("-",$foliointerno);
								$serie=$folios[0];
								$folio=$folios[1];
								
								if(!mysqli_query($this->con->conect,"INSERT INTO archivos (idarchivo, pdf, xml, fechamodificacion, tablareferencia, idreferencia, serie, folio, tipo, fechatimbre, emisor, rfcemisor, receptor, rfcreceptor, monto, subtotal, uuid) VALUES ('$idarchivo','$pdf','$xml','$fecha','cotizacionesproductos','$idcotizacion','$serie','$folio','$tipo','$fecha','$emisor','$rfcemisor','$receptor','$rfcreceptor','$montototal','$subTotal','$foliofiscal')")){
									$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
									return "fracasoArchivos";
								}
								$con++;
							}//Fin de While Costizaciones
							
							if(!$this->avanzarFolio($codigopostal,$this->con->conect)){
								$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
								return "fracasoFolios";
							}
							
						}
						if ($tipo=="E"){
							$Ofactura->consultaLibre("UPDATE ventas SET archivoNota='$archivo' WHERE idventa IN ($ids)");
						}
						//unset($_SESSION['DATOSFACTURA']);
					}
					/////////////////* MODULO DE FACTURACION INTEGRADO
					
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla facturacion ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					
					$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
					return "exito";
				}else{ //Si no se ejecuto el INSERT INTO facturacion
					$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
					return "fracaso";
				}
			
		}else{ //Si no se conecto a la base de datos
			return "fracaso";
		}
	}
	
	
	function guardarRelacion($uuidHija, $uuidMadre, $tiporelacion, $tipocfdi, $conexion){
		if(mysqli_query($conexion,"INSERT INTO relacionescfdi (uuidhija, uuidmadre, tiporelacion, tipocfdi) VALUES ('$uuidHija','$uuidMadre','$tiporelacion','$tipocfdi')")){
			return true;
		}else{
			return false;
		}
	}
	
	function actualizar($foliointerno,$fecha,$tipo,$clasificacion,$emisor,$rfcemisor,$receptor,$rfcreceptor,$montototal,$montopagado,$estado,$fechapago,$formapago,$cuenta,$foliofiscal,$observaciones,$relaciones,$archivo,$estatus,$idfactura){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['facturacion']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE facturacion SET foliointerno='$foliointerno', fecha='$fecha', tipo='$tipo', clasificacion='$clasificacion', emisor='$emisor', rfcemisor='$rfcemisor', receptor='$receptor', rfcreceptor='$rfcreceptor', montototal='$montototal', montopagado='$montopagado', estado='$estado', fechapago='$fechapago', formapago='$formapago', cuenta='$cuenta', foliofiscal='$foliofiscal', observaciones='$observaciones', relaciones='$relaciones', archivo='$archivo', estatus='$estatus' WHERE idfactura='$idfactura'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idfactura, de la tabla facturacion ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function avanzarFolio($cp, $conexion){
		if(mysqli_query($conexion,"UPDATE sucursales SET folio=folio+1 WHERE cp='$cp'")){
			return true;
		}else{
			return false;
		}
	}
	
	function bloquear($idfactura){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['facturacion']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE facturacion SET estatus ='bloqueado' WHERE idfactura = '$idfactura'");
		}
	}
	
	function cambiarEstatus($idfactura,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['facturacion']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE facturacion SET estatus ='$estatus' WHERE idfactura = '$idfactura'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla facturacion ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	
	
	function mostrarIndividual($idfactura){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM facturacion WHERE idfactura='$idfactura'");
		}
	}
	
	function mostrarIndividualUUID($uuid){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM facturacion WHERE foliofiscal='$uuid'");
		}
	}
	
	function obtenerRelaciones($uuid){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM relacionescfdi WHERE uuidmadre='$uuid'");
		}
	}
	
	function existenRelaciones($uuid){
		if($this->con->conectar()==true){
			$res=mysqli_query($this->con->conect,"SELECT COUNT(*) AS contador FROM relacionescfdi WHERE uuidmadre='$uuid'");
			if ($res){
				$extractor = mysqli_fetch_array($res);
				$numero_filas=$extractor["contador"];
				if ($numero_filas=="0"){
					return "no";
				}else{
					return "si";
				}
			}else{
				return "no";
			}
		}
	}
	
	function contar($condicion, $papelera, $tipo="TODOS"){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		$extra="";
		if ($tipo!="TODOS"){
			$extra=" AND facturacion.tipo='$tipo' OR facturacion.tipo='E'";
		}
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					facturacion.idfactura,
					facturacion.foliointerno,
					facturacion.fecha,
					facturacion.tipo,
					facturacion.clasificacion,
					facturacion.emisor,
					facturacion.rfcemisor,
					facturacion.receptor,
					facturacion.rfcreceptor,
					facturacion.montototal,
					facturacion.montopagado,
					facturacion.estado,
					facturacion.fechapago,
					facturacion.formapago,
					facturacion.cuenta,
					facturacion.foliofiscal,
					facturacion.observaciones,
					facturacion.relaciones,
					facturacion.archivo,
					facturacion.estatus
					FROM facturacion 
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $tipo="TODOS"){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['facturacion']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		if ($campoOrden=="foliointerno"){
			$campoOrden="LENGTH(foliointerno)";
			$campoOrden="cast(SUBSTRING_INDEX(foliointerno, '-', -1) as decimal)";
		}
		$extra="";
		if ($tipo!="TODOS"){
			$extra=" AND facturacion.tipo='$tipo' OR facturacion.tipo='E'";
		}
		$consulta = "SELECT 
					facturacion.idfactura,
					facturacion.foliointerno,
					facturacion.fecha,
					facturacion.tipo,
					facturacion.clasificacion,
					facturacion.emisor,
					facturacion.rfcemisor,
					facturacion.receptor,
					facturacion.rfcreceptor,
					facturacion.montototal,
					facturacion.montopagado,
					facturacion.estado,
					facturacion.fechapago,
					facturacion.formapago,
					facturacion.cuenta,
					facturacion.foliofiscal,
					facturacion.observaciones,
					facturacion.relaciones,
					facturacion.archivo,
					facturacion.estatus
					FROM facturacion 
					$where $extra
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	
	function consultaDetallesFacturacion($idtemporal){
		if($this->con->conectar()==true){
			$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
			$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
			$idcotizacion=0;
			$subfolio=0;
			$resultado=mysqli_query($this->con->conect,"SELECT * FROM facturaciontemporal WHERE clave='$idtemporal'");
			while ($filas=mysqli_fetch_array($resultado)) {
				$idcotizacion=$filas['idcotizacion'];
				$subfolio=$filas['subfolio'];
			}
			$consulta = "SELECT 
						$detallecotizacionesproductos.iddetallecotizacion,
						$detallecotizacionesproductos.idproducto,
						$detallecotizacionesproductos.cantidad,
						$detallecotizacionesproductos.precio,
						$detallecotizacionesproductos.total,
						$detallecotizacionesproductos.idcotizacionproducto,
						$detallecotizacionesproductos.subfolio,
						$cotizacionesproductos.serie AS serie,
						$cotizacionesproductos.folio AS folio,
						productos.nombre AS nombreproductos,
						productos.codigo AS codigoproductos,
						unidades.nombre AS unidadproductos
						FROM $detallecotizacionesproductos 
						INNER JOIN productos ON $detallecotizacionesproductos.idproducto=productos.idproducto
						INNER JOIN unidades ON productos.idunidad=unidades.idunidad
						INNER JOIN $cotizacionesproductos ON $detallecotizacionesproductos.idcotizacionproducto=$cotizacionesproductos.idcotizacionproducto
						WHERE $detallecotizacionesproductos.idcotizacionproducto='$idcotizacion' AND $detallecotizacionesproductos.subfolio='$subfolio';
					";
			return mysqli_query($this->con->conect,$consulta);
		}
	}
	
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM facturacion $condicion");
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
	
	function cancelarTimbre($archivoCancelacion,$estado, $idfactura){
		if($this->con->conectar()==true){
			//print_r($campos);
			if(mysqli_query($this->con->conect,"UPDATE facturacion SET archivo='$archivoCancelacion', estatus ='$estado' WHERE idfactura = '$idfactura'")){
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function registrarBitacora($accion,$descripcion){
		$idusuario=$_SESSION['idusuario'];
		$usuario=$_SESSION['usuario'];
		$descripcion="El usuario $usuario ".$descripcion;
		$hora=date('H:i');
		$fecha=date('Y-m-d');
		$modulo="facturacion";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['facturacion']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE facturacion SET estatus ='eliminado' WHERE idfactura IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla facturacion ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM facturacion WHERE idfactura IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla facturacion ";
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