<?php 
include_once("../../conexion/Conexion.class.php");
include_once("../../folios/Folio.class.php");
class Requisicion{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			$consulta="WHERE ((sucursales.nombre LIKE '%".$condicion."%') OR (empleados.nombre LIKE '%".$condicion."%'))";
		}else{
			$consulta="WHERE (requisiciones.idrequisicion <>'0')";
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
	
	
	
	function guardarAsignacion($idrequisicion, $idsucursal, $lista ,$conexion){
			
			$arregloIdproducto=$this->descomponerArreglo(3,0,$lista);
			$arregloCantidad=$this->descomponerArreglo(3,1,$lista);
			$arregloCosto=$this->descomponerArreglo(3,2,$lista);
			
			$con=0;
			$validar=true;
			$resdelte=mysqli_query($conexion,"DELETE FROM detallerequisiciones WHERE idrequisicion='$idrequisicion'");
			if ($resdelte){
				while ($con < count($arregloIdproducto)){
					$idproducto=$arregloIdproducto[$con];
					$cantidad=$arregloCantidad[$con];
					$costo=$arregloCosto[$con];
					$monto=$costo*$cantidad;
					
					$iddetallerequisicion=$this->con->generarClave2(2);
					if(!mysqli_query($conexion,"INSERT INTO detallerequisiciones (iddetallerequisicion, idrequisicion, idproducto, cantidad, costo, monto, estado) VALUES ('$iddetallerequisicion','$idrequisicion','$idproducto','$cantidad','$costo','$monto','PENDIENTE')")){
						$validar=false;
					}
					$con++;
				}
			}else{
				$validar=false;
			}
			return $validar;
	}


	
	
	function guardar($fecha,$idempleado,$idsucursal,$comentarios,$estado,$serie,$folio,$hora,$idproveedor,$pesototal,$lista){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['requisiciones']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$validar = "fracaso";
		
		if($this->con->conectar()==true){
			
				$this->con->conect->autocommit(false); //INICO DE TRANSACCION
				
				//CONSULTA Y ACTUALIZA VARIABLE FOLIO 
				$Ofolio = new Folio;
				$folio=$Ofolio->obtenerFolio("REQUISICIONES");
				//INCREMENTAR EL FOLIO
				 if(mysqli_query($this->con->conect,"UPDATE Folios SET folioactual = folioactual + 1 WHERE idsucursal = '$idsucursal' AND asignacion = 'REQUISICIONES' AND estatus = 'activo'")){ //Si anvanza el folio
					$idrequisicion=$this->con->generarClave(2); /*Sincronizacion 1 */
					
					if(mysqli_query($this->con->conect,"INSERT INTO requisiciones (idrequisicion, fecha, idempleado, idsucursal, comentarios, estado, serie, folio, hora, idproveedor, pesototal) VALUES ('$idrequisicion','$fecha','$idempleado','$idsucursal','$comentarios','$estado','$serie','$folio','$hora','$idproveedor','$pesototal')")){
						
						
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
				 }else{ //Si no avanza el folio
					 return "fracaso";
				 }
			
		}
	}


	function actualizar($fecha,$idempleado,$idsucursal,$comentarios,$estado,$idrequisicion,$lista){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['requisiciones']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$validar = "fracaso";
		
		if($this->con->conectar()==true){
			
				$this->con->conect->autocommit(false); //INICO DE TRANSACCION
				if ($estado=="Pendiente"){
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
						return "fracaso@0";
					}
				}else{
					return "fracasoAceptada@0";
				}
			
		}
	}
	
	
	function mostrarIndividual($idrequisicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM requisiciones WHERE idrequisicion='$idrequisicion'");
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
		if (!isset($_SESSION['permisos']['requisiciones']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					requisiciones.idrequisicion,
					requisiciones.fecha,
					requisiciones.idempleado,
					requisiciones.idsucursal,
					requisiciones.comentarios,
					requisiciones.estado,
					sucursales.nombre AS nombresucursales,
					empleados.nombre AS nombreempleado
					FROM requisiciones 
					INNER JOIN sucursales ON requisiciones.idsucursal=sucursales.idsucursal
					INNER JOIN empleados ON requisiciones.idempleado=empleados.idempleado
					$where $consultaExtra
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
					//echo $consulta ;
		if($this->con->conectar()==true){ 
			$resultado1=mysqli_query($this->con->conect,$consulta);
			$resultado2=mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			return array($resultado1,$extractor["contador"]);
		}
	}
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT
					requisiciones.idrequisicion,
					requisiciones.fecha,
					requisiciones.idempleado,
					requisiciones.idsucursal,
					requisiciones.comentarios,
					requisiciones.estado,
					requisiciones.serie,
					requisiciones.folio,
					requisiciones.idproveedor,
					proveedores.nombre AS nombreproveedor,
					sucursales.nombre AS nombresucursales,
					empleados.nombre AS nombreempleado
					FROM requisiciones 
					INNER JOIN sucursales ON requisiciones.idsucursal=sucursales.idsucursal
					INNER JOIN empleados ON requisiciones.idempleado=empleados.idempleado
					INNER JOIN proveedores ON requisiciones.idproveedor=proveedores.idproveedor
					$condicion");
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
		if (!isset($_SESSION['permisos']['requisiciones']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$validar = "exito";
		if($this->con->conectar()==true){
			
			$this->con->conect->autocommit(false); //INICO DE TRANSACCION
			
			
			if ($tipoEliminacion=='real'){
				
				if(!mysqli_query($this->con->conect,"DELETE FROM requisiciones WHERE idrequisicion IN ($ids)")){
					$validar = "fracaso";
				}
				if(!mysqli_query($this->con->conect,"DELETE FROM detallerequisiciones WHERE idrequisicion IN ($ids)")){
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