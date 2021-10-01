<?php 
include_once("../../conexion/Conexion.class.php");

class Movimiento{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		$idsucursal=$_SESSION["idsucursal"];
		if ($condicion!=""){
			$consulta="WHERE ((movimientos$idsucursal.fechamovimiento LIKE '%".$condicion."%') OR (movimientos$idsucursal.concepto LIKE '%".$condicion."%') OR (movimientos$idsucursal.tipo LIKE '%".$condicion."%') OR (movimientos$idsucursal.numerocomprobante LIKE '%".$condicion."%') OR (movimientos$idsucursal.comentarios LIKE '%".$condicion."%'))AND movimientos$idsucursal.estatus <>'eliminado'";
		}else{
			$consulta="WHERE movimientos$idsucursal.estatus <>'eliminado'";
		}
		return $consulta;
	}function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from movimientos WHERE $campo = '$valor'");
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
	
	function guardarTraspaso($idmovimiento,$idsucursalorigen,$idsucursaldestino,$fechasalida,$fechaentrada,$estado,$numerocomprobante,$idusuariosalida,$idusuarioentrada, $conexion){
		$idtraspaso=$this->con->generarClave(2); /*Sincronizacion 1 */
		if(mysqli_query($conexion,"INSERT INTO traspasos (idtraspaso, idmovimiento, idsucursalorigen, idsucursaldestino, fechasalida, fechaentrada, estado, numerocomprobante, idusuariosalida, idusuarioentrada) VALUES ('$idtraspaso','$idmovimiento','$idsucursalorigen','$idsucursaldestino','$fechasalida','$fechaentrada','$estado','$numerocomprobante','$idusuariosalida','$idusuarioentrada')")){
			return true;
		}else{
			return false;
		}
	}
	
	function guardarAsignacion($idmovimiento, $tipo, $concepto,$fechamovimiento,$comentarios,$idsucursal, $lista ,$conexion){
			if ($tipo=="salida"){
				if ($concepto=="VENTA"){
					$arregloCampo=$this->descomponerArreglo(10,0,$lista);
					$arregloCantidad=$this->descomponerArreglo(10,1,$lista);
				}else{
					$arregloCampo=$this->descomponerArreglo(2,0,$lista);
					$arregloCantidad=$this->descomponerArreglo(2,1,$lista);
				}
			
			}
			if ($tipo=="entrada"){
				$arregloCampo=$this->descomponerArreglo(5,0,$lista);
				$arregloCantidad=$this->descomponerArreglo(5,1,$lista);
				$arregloCosto=$this->descomponerArreglo(5,2,$lista);
				$arregloPeso=$this->descomponerArreglo(5,3,$lista);
				$arregloUbicacion=$this->descomponerArreglo(5,4,$lista);
			}
			
			$con=0;
			$validar=true;
			while ($con < count($arregloCampo)){
				$idproducto=$arregloCampo[$con];
				$cantidad=$arregloCantidad[$con];
				if ($tipo=="entrada"){
					$costo=$arregloCosto[$con];
					$ubicacion=$arregloUbicacion[$con];
					if ($cantidad!=0){
						$pesounitario=$arregloPeso[$con]/$cantidad;
					}else{
						$pesounitario=$arregloPeso[$con];
					}
				}else{
					$ubicacion="";
					$minimo="0";
				}
				$resultado=mysqli_query($conexion,"SELECT * FROM kardex$idsucursal WHERE idproducto ='$idproducto' ORDER BY fechamovimiento ASC");
				if (!$resultado){ //Si ocurre un error al ejectur el SELECT
					$validar=false;
				}
				$existencia=0;
				$saldo=0;
				$debe=0;
				$haber=0;
				$promedio=0;
				$idkardex=0;
				$primeraEntrada=true;
				if(mysqli_num_rows($resultado) > 0){
					while ($filas=mysqli_fetch_array($resultado)) {
						$salida= $filas['salida'];
						$idkardex=$filas['idkardex'];
						if ($salida=="0"){ //Si la salida es 0 entonces significa que es una entrada
								$entrada=$filas['entrada'];
								$costounitario=$filas['costounitario'];
								$existencia=$existencia+$entrada;
								if ($primeraEntrada==true){
									$debe=$costounitario*$existencia;
									$primeraEntrada=false;
								}else{
									$debe=$costounitario*$entrada;
								}
								$haber=0;
								$saldo=$saldo+$debe;
								$promedio=$saldo/$existencia;
								if (!mysqli_query($conexion,"UPDATE kardex$idsucursal SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'")){
									$validar=false;
								}
						}else{ // Si es una salida
								$existencia=$existencia-$salida;
								$debe=0;
								$haber=$salida*$promedio;
								$saldo=$saldo-$haber;
								if (!mysqli_query($conexion,"UPDATE kardex$idsucursal SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'")){
									$validar=false;
								}
						}
					}
					
				}
				if ($tipo=="salida"){ //Si es salida
					$salida=$cantidad;
					$entrada=0;
					$existencia=$existencia-$salida;
					$costounitario=$promedio;
					$promedio=$promedio;
					$debe=0;
					$haber=$salida*$promedio;
					$saldo=$saldo-$haber;
				}else{ // Si es entrada
					$salida=0;
					$entrada=$cantidad;
					$existencia=$existencia+$entrada;
					$costounitario=$costo;
					if ($primeraEntrada==true){
						$debe=$existencia*$costo;
					}else{
						$debe=$cantidad*$costo;
					}
					$haber=0;
					$saldo=$saldo+$debe;
					$promedio=$saldo/$existencia;
				}
				$idkardexS=$this->con->generarClave2(2); /*Sincronizacion 1 */
				$fechamovimientoNew=$fechamovimiento." ".date("H:i:s");
			
				if(!mysqli_query($conexion,"INSERT INTO kardex$idsucursal (idkardex, idproducto, fechamovimiento, descripcion, observaciones, entrada, salida, existencia, costounitario, promedio, debe, haber, saldo, idmovimiento, idreferencia, estatus) VALUES ('$idkardexS','$idproducto','$fechamovimientoNew','$concepto','$comentarios','$entrada','$salida','$existencia','$costounitario','$promedio','$debe','$haber','$saldo','$idmovimiento','0','activo')")){
					$validar=false;
				}else{
					//codigo aki 
					//$this->actualizarInventario($idsucursal,$idproducto,$ubicacion,$minimo, $salida, "alta");
					
					//INICIO ACTUALIZAR INVENTARIO
					
					$tipoActualizacion="alta";
					
					
					$resultadoIn=mysqli_query($conexion,"SELECT * FROM kardex$idsucursal WHERE idproducto ='$idproducto' ORDER BY fechamovimiento DESC, idkardex DESC LIMIT 1");
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
					
					$resultadoIn=mysqli_query($conexion,"SELECT * FROM kardex$idsucursal WHERE idproducto ='$idproducto' ORDER BY fechamovimiento ASC, idkardex ASC LIMIT 1");
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
					
					$resultadoIn=mysqli_query($conexion,"SELECT * FROM inventario$idsucursal WHERE idproducto ='$idproducto'");
					if (!$resultadoIn){ //Si ocurre un error al ejectura el SELECT
						$validar=false;
					}
					if(mysqli_num_rows($resultadoIn) > 0){
						$filasIn=mysqli_fetch_array($resultadoIn);
						$idinventario=$filasIn['idinventario'];
						if ($tipoActualizacion=="alta"){
							if(!mysqli_query($conexion,"UPDATE inventario$idsucursal SET existencia='$existencia', saldo='$saldo', promedio='$costopromedio', existencia='$existencia', ubicacion='$ubicacion', minimo='0', estado='$estado' WHERE idinventario='$idinventario'")){
								$validar=false;
							}
							if(!mysqli_query($conexion,"UPDATE productos SET costo='$costopromedio' WHERE idproducto='$idproducto'")){
								$validar=false;
							}
							if ($pesounitario!=0){
								if(!mysqli_query($conexion,"UPDATE productos SET pesoreal='$pesounitario' WHERE idproducto='$idproducto'")){
									$validar=false;
								}
							}
						}else{
							if (!mysqli_query($conexion,"UPDATE inventario$idsucursal SET existencia='$existencia', saldo='$saldo', promedio='$costopromedio', existencia='$existencia', estado='$estado' WHERE idinventario='$idinventario'")){
								$validar=false;
							}
							if(!mysqli_query($conexion,"UPDATE productos SET costo='$costopromedio' WHERE idproducto='$idproducto'")){
								$validar=false;
							}
							if ($pesounitario!=0){
								if(!mysqli_query($conexion,"UPDATE productos SET pesoreal='$pesounitario' WHERE idproducto='$idproducto'")){
									$validar=false;
								}
							}
						}
						$costopromedio= $filasIn['promedio'];
						$saldo= $filasIn['saldo'];
						$existencia= $filasIn['existencia'];
					}else{
						$idinventarioS=$this->con->generarClave2(2); /*Sincronizacion 1 */
						if(!mysqli_query($conexion,"INSERT INTO inventario$idsucursal (idinventario, idproducto, existencia, promedio, saldo, minimo, ubicacion, estado) VALUES ('$idinventarioS','$idproducto','$existencia','$costopromedio','$saldo','0','$ubicacion','$estado')")){
							$validar=false;
						}
						if(!mysqli_query($conexion,"UPDATE productos SET costo='$costopromedio' WHERE idproducto='$idproducto'")){
							$validar=false;
						}
						if ($pesounitario!=0){
							if(!mysqli_query($conexion,"UPDATE productos SET pesoreal='$pesounitario' WHERE idproducto='$idproducto'")){
								$validar=false;
							}
						}
					}
					
					//FIN ACTUALIZAR INVENTARIO
				}
				$con++;
			}
			return $validar;
	}
	
	
	
	function guardar($tipo,$concepto,$fechamovimiento,$hora,$numerocomprobante,$idsucursal,$tabla,$idreferencia,$comentarios,$estado,$estatus,$lista){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['movimientos']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$validar = "fracaso@1";
		
		if($this->con->conectar()==true){
			
			
			
				$this->con->conect->autocommit(false); //INICO DE TRANSACCION
				
				$idmovimiento=$this->con->generarClave(2); /*Sincronizacion 1 */
				if ($idreferencia==""){
					$idreferencia=$numerocomprobante;
				}
				if(mysqli_query($this->con->conect,"INSERT INTO movimientos$idsucursal (idmovimiento, tipo, concepto, fechamovimiento, hora, numerocomprobante, tabla, idreferencia, comentarios, estado, estatus) VALUES ('$idmovimiento','$tipo','$concepto','$fechamovimiento','$hora','$numerocomprobante','$tabla','$idreferencia', '$comentarios', '$estado', '$estatus')")){
					
					
					if ($concepto=="ORDEN DE COMPRA"){
						$idusuariosalida=$_SESSION['idusuario'];
						if (!mysqli_query($this->con->conect,"UPDATE compras SET estado='Recepcionada' WHERE idcompra='$numerocomprobante'")){
							$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
							echo "A";
							return "fracaso@1";
						}
					}
					
					if ($concepto=="TRASPASO" and $tipo=="salida"){
						$idusuariosalida=$_SESSION['idusuario'];
						if (!$this->guardarTraspaso($idmovimiento,$idsucursal,$idreferencia,$fechamovimiento,"2000-01-01","EN TRANSITO",$numerocomprobante,$idusuariosalida,'0',$this->con->conect)){
							$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
							echo "B";
							return "fracaso@1";
						}
					}
					
					if ($concepto=="TRASPASO" and $tipo=="entrada"){
						$idusuarioentrada=$_SESSION['idusuario'];
						if (!mysqli_query($this->con->conect,"UPDATE traspasos SET estado='RECEPCIONADO', fechaentrada='$fechamovimiento', idusuarioentrada='$idusuarioentrada' WHERE numerocomprobante='$numerocomprobante'")){
							$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
							echo "C";
							return "fracaso@1";
						}
						$resultado=mysqli_query($this->con->conect,"SELECT idsucursalorigen FROM traspasos WHERE numerocomprobante='$numerocomprobante'");
						if($resultado){
							$filas=mysqli_fetch_array($resultado);
							$idsucursalorigen= $filas['idsucursalorigen'];
						
							if (!mysqli_query($this->con->conect,"UPDATE movimientos$idsucursalorigen SET estado='RECEPCIONADO' WHERE numerocomprobante='$numerocomprobante'")){
								$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
								echo "D";
								return "fracaso@1";
							}
						}else{
							$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
							echo "E";
							return "fracaso@1";
						}
					}
					
					
					if ($this->guardarAsignacion($idmovimiento,$tipo,$concepto,$fechamovimiento,$comentarios,$idsucursal,$lista,$this->con->conect)){
						$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
						$validar="exito@$idmovimiento";
					}else{
						$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
						echo "F";
						return "fracaso@1";
					}
					
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla movimientos ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito@$idmovimiento";
				}else{
					echo "G";
					return "fracaso@1";
				}
			
		}
	}

	function guardarRef($tipo,$concepto,$fechamovimiento,$hora,$numerocomprobante,$idsucursal,$tabla,$idreferencia,$comentarios,$estado,$estatus,$lista,$conexion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['movimientos']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$validar = false;
				//$this->con->conect->autocommit(false); //INICO DE TRANSACCION
				
				$idmovimiento=$this->con->generarClave(2); /*Sincronizacion 1 */
				
				if(mysqli_query($conexion,"INSERT INTO movimientos$idsucursal (idmovimiento, tipo, concepto, fechamovimiento, hora, numerocomprobante, tabla, idreferencia, comentarios, estado, estatus) VALUES ('$idmovimiento','$tipo','$concepto','$fechamovimiento','$hora','$numerocomprobante','$tabla','$idreferencia', '$comentarios', '$estado', '$estatus')")){
					//echo "INSERT INTO movimientos$idsucursal (idmovimiento, tipo, concepto, fechamovimiento, hora, numerocomprobante, tabla, idreferencia, comentarios, estado, estatus) VALUES ('$idmovimiento','$tipo','$concepto','$fechamovimiento','$hora','$numerocomprobante','$tabla','$idreferencia', '$comentarios', '$estado', '$estatus')";
					
					if ($this->guardarAsignacion($idmovimiento,$tipo,$concepto,$fechamovimiento,$comentarios,$idsucursal,$lista,$conexion)){
						//$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
						$validar=true;
					}else{
						//$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
						$validar=false;
						exit;
					}
					
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla movimientos ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return $validar;
				}else{
					return $validar;
				}
		
	}
	
	function mostrarIndividual($idmovimiento){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM movimientos WHERE idmovimiento='$idmovimiento'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$idsucursal=$_SESSION["idsucursal"];
			$resultado=mysqli_query($this->con->conect,"SELECT 
					movimientos$idsucursal.idmovimiento,
					movimientos$idsucursal.tipo,
					movimientos$idsucursal.concepto,
					movimientos$idsucursal.fechamovimiento,
					movimientos$idsucursal.hora,
					movimientos$idsucursal.numerocomprobante,
					movimientos$idsucursal.tabla,
					movimientos$idsucursal.idreferencia,
					movimientos$idsucursal.comentarios,
					movimientos$idsucursal.estado,
					movimientos$idsucursal.estatus
					FROM movimientos$idsucursal
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

	function obtenerFolioCompra($idcompra){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT serie,folio FROM compras WHERE idcompra ='$idcompra'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);

				if(isset($extractor["serie"]) && isset($extractor["folio"])){
					$serie=$extractor["serie"];
					$folio=$extractor["folio"];
					$valorCampo = $serie."-".$folio;
				} else {
					$valorCampo = "-";
				}
			    return $valorCampo;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $consultaExtra){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['movimientos']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		$idsucursal=$_SESSION["idsucursal"];
		$consulta = "SELECT 
					movimientos$idsucursal.idmovimiento,
					movimientos$idsucursal.tipo,
					movimientos$idsucursal.concepto,
					movimientos$idsucursal.fechamovimiento,
					movimientos$idsucursal.hora,
					movimientos$idsucursal.numerocomprobante,
					movimientos$idsucursal.tabla,
					movimientos$idsucursal.idreferencia,
					movimientos$idsucursal.comentarios,
					movimientos$idsucursal.estado,
					movimientos$idsucursal.estatus
					FROM movimientos$idsucursal
					$where $consultaExtra
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			$idsucursal=$_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"SELECT * FROM movimientos$idsucursal $condicion");
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
			$modulo="movimientos";
			mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
		}
	}
	
	function eliminarAsignacion($idproducto, $idsucursal, $conexion){
		$validar=true;
	
			$resultado=mysqli_query($conexion,"SELECT * FROM kardex$idsucursal WHERE idproducto ='$idproducto' ORDER BY fechamovimiento ASC");
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
			$costounitario=0;
			if(mysqli_num_rows($resultado) > 0){
				while ($filas=mysqli_fetch_array($resultado)) {
					
					$salida= $filas['salida']; //Obtenemos el tipo de movimiento 0 si es entrada y diferente de 0 es salida
					$idkardex=$filas['idkardex'];
					echo "Tipo: $salida"."Existencia: ".$existencia.", Costo:".$costounitario."      ";
					if ($contador==0){ //Si es el primer registro
						if ($salida=="0"){ //Si el registro es una entrada
							$entrada=$filas['entrada'];
							$costounitario=$filas['costounitario'];
							$promedio=$costounitario;
							$existencia=$existencia+$entrada;
							$haber=0;
							$debe=$entrada*$promedio;
							$saldo=$saldo+$debe;
							if(!mysqli_query($conexion,"UPDATE kardex$idsucursal SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'")){
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
							if(!mysqli_query($conexion,"UPDATE kardex$idsucursal SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'")){
								$validar=false;
							}
						
						}else{ //Si el registro es una salida
							$salida=$filas['salida'];
							$costounitario=$promedio;
							$existencia=$existencia-$salida;
							$haber=$salida*$costounitario;
							$debe=0;
							$saldo=$saldo-$haber;
							if(!mysqli_query($conexion,"UPDATE kardex$idsucursal SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'")){
								$validar=false;
							}
						}
					
					}
					//FIN ACTUALIZAR INVENTARIO
					if(!$this->actualizarInventario($idsucursal,$idproducto,"","0","baja",$conexion)){
						$validar=false;
					}
					
					$contador++;
				} //Fin de while
				
			}else{ //Fin de if resultados num_rows > 0 Sino...
				
					//FIN ACTUALIZAR INVENTARIO
					if(!$this->actualizarInventario($idsucursal,$idproducto,"","0","baja",$conexion)){
						$validar=false;
					}
			}
		return $validar;
	}// Fin de funcion
	
	function actualizarInventario($idsucursal, $idproducto, $ubicacion, $minimo, $tipoActualizacion, $conexion){
		//INICIO ACTUALIZAR INVENTARIO
		$validar=true;
		$resultadoIn=mysqli_query($conexion,"SELECT * FROM kardex$idsucursal WHERE idproducto ='$idproducto' ORDER BY fechamovimiento DESC, idkardex DESC LIMIT 1");
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
		
		$resultadoIn=mysqli_query($conexion,"SELECT * FROM kardex$idsucursal WHERE idproducto ='$idproducto' ORDER BY fechamovimiento ASC, idkardex ASC LIMIT 1");
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
		
		$resultadoIn=mysqli_query($conexion,"SELECT * FROM inventario$idsucursal WHERE idproducto ='$idproducto'");
		if (!$resultadoIn){ //Si ocurre un error al ejectura el SELECT
			$validar=false;
		}
		if(mysqli_num_rows($resultadoIn) > 0){
			$filasIn=mysqli_fetch_array($resultadoIn);
			$idinventario=$filasIn['idinventario'];
			if ($tipoActualizacion=="alta"){
				if(!mysqli_query($conexion,"UPDATE inventario$idsucursal SET existencia='$existencia', saldo='$saldo', promedio='$costopromedio', existencia='$existencia', ubicacion='$ubicacion', minimo='0', estado='$estado' WHERE idinventario='$idinventario'")){
					$validar=false;
				}
				
				if(!mysqli_query($conexion,"UPDATE productos SET costo='$costopromedio' WHERE idproducto='$idproducto'")){
					$validar=false;
				}
		
			}else{
				if (!mysqli_query($conexion,"UPDATE inventario$idsucursal SET existencia='$existencia', saldo='$saldo', promedio='$costopromedio', existencia='$existencia', estado='$estado' WHERE idinventario='$idinventario'")){
					$validar=false;
				}
				if(!mysqli_query($conexion,"UPDATE productos SET costo='$costopromedio' WHERE idproducto='$idproducto'")){
					$validar=false;
				}
			}
			$costopromedio= $filasIn['promedio'];
			$saldo= $filasIn['saldo'];
			$existencia= $filasIn['existencia'];
		}else{
			$idinventarioS=$this->con->generarClave2(2); /*Sincronizacion 1 */
			if(!mysqli_query($conexion,"INSERT INTO inventario$idsucursal (idinventario, idproducto, existencia, promedio, saldo, minimo, ubicacion, estado) VALUES ('$idinventarioS','$idproducto','$existencia','$costopromedio','$saldo','0','$ubicacion','$estado')")){
				$validar=false;
			}
			if(!mysqli_query($conexion,"UPDATE productos SET costo='$costopromedio' WHERE idproducto='$idproducto'")){
				$validar=false;
			}
		}
		
		
					
		//FIN ACTUALIZAR INVENTARIO
		return $validar;
	}
	
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['movimientos']['eliminar'])){
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
				$idsucursal=$_SESSION["idsucursal"];
				$idsnuevo=explode(",",$ids);
				foreach ($idsnuevo as $idmovimiento){
					$resultado2=mysqli_query($this->con->conect,"SELECT * FROM kardex$idsucursal WHERE idmovimiento='$idmovimiento'");
					if (!$resultado2){
						$validar = "fracaso";
					}
					while ($filas2=mysqli_fetch_array($resultado2)) {
						$idsproductos[$con]=$filas2['idproducto'];
						$con++;
					}// Fin de while para el llenado de tablas
				}
				/*if(!mysqli_query($this->con->conect,"DELETE FROM concentrados WHERE idmovimiento IN ($ids)")){
					$validar = "fracaso";
				}*/
				//echo "DELETE FROM movimientos$idsucursal WHERE idmovimiento IN ($ids)";
				if(!mysqli_query($this->con->conect,"DELETE FROM movimientos$idsucursal WHERE idmovimiento IN ($ids)")){
					$validar = "fracaso";
				}
				if(mysqli_query($this->con->conect,"DELETE FROM kardex$idsucursal WHERE idmovimiento IN ($ids)")){
					$idsproductos=array_unique($idsproductos);
					foreach ($idsproductos as $idproducto){
						if (!$this->eliminarAsignacion($idproducto,$idsucursal,$this->con->conect)){
							$validar = "fracaso";
						}
					}
				}else{
					$validar = "fracaso";
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