<?php 
include_once("../../conexion/Conexion.class.php");

class Movimiento{
 //constructor	
 	var $con;
 	function Movimiento(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			$consulta="WHERE ((movimientos.fechamovimiento LIKE '%".$condicion."%') OR (almacenes.nombre LIKE '%".$condicion."%') OR (movimientos.concepto LIKE '%".$condicion."%') OR (movimientos.tipo LIKE '%".$condicion."%') OR (movimientos.numerocomprobante LIKE '%".$condicion."%') OR (movimientos.comentarios LIKE '%".$condicion."%'))AND movimientos.estatus <>'eliminado'";
		}else{
			$consulta="WHERE movimientos.estatus <>'eliminado'";
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
	
	function eliminarAsignacion($idproducto, $idalmacen){
			$resultado=mysqli_query($this->con->conect,"SELECT * FROM kardex WHERE idproducto ='$idproducto' AND idalmacen='$idalmacen' ORDER BY fechamovimiento ASC");
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
							mysqli_query($this->con->conect,"UPDATE kardex SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'");
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
							mysqli_query($this->con->conect,"UPDATE kardex SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'");
						
						}else{ //Si el registro es una salida
							$salida=$filas['salida'];
							$costounitario=$promedio;
							$existencia=$existencia-$salida;
							$haber=$salida*$costounitario;
							$debe=0;
							$saldo=$saldo-$haber;
							mysqli_query($this->con->conect,"UPDATE kardex SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'");
						}
					
					}
					$this->actualizarInventario($idalmacen,$idproducto,"","0","baja");
					$contador++;
				} //Fin de while
				
			}else{ //Fin de if resultados num_rows > 0 Sino...
				$this->actualizarInventario($idalmacen,$idproducto,"","0","baja");
			}
	}// Fin de funcion
	
	
	function registrarKardex($idmovimiento,$idproducto,$cantidad,$concepto,$fechamovimiento,$comentarios,$idalmacen){
		$tipo=="salida";
		$con=0;
		$validar=true;
		$ubicacion="";
		$minimo="0";
			
		$resultado=mysqli_query($this->con->conect,"SELECT * FROM kardex WHERE idproducto ='$idproducto' AND idalmacen='$idalmacen' ORDER BY fechamovimiento ASC");
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
				// Si es una salida
				$existencia=$existencia-$salida;
				$debe=0;
				$haber=$salida*$promedio;
				$saldo=$saldo-$haber;
				mysqli_query($this->con->conect,"UPDATE kardex SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'");
					
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
			}
			$idkardexSinc=$this->con->generarClave2(2); /*Sincronizacion 1 */
			$fechamovimiento=$fechamovimiento." ".date("H:i:s");
			if(!mysqli_query($this->con->conect,"INSERT INTO kardex (idkardex, idproducto, fechamovimiento, descripcion, observaciones, entrada, salida, existencia, costounitario, promedio, debe, haber, saldo, idalmacen, idmovimiento, idreferencia, estatus) VALUES ('$idkardexSinc','$idproducto','$fechamovimiento','$concepto','$comentarios','$entrada','$salida','$existencia','$costounitario','$promedio','$debe','$haber','$saldo','$idalmacen','$idmovimiento','0','activo')")){
				$validar=false;
			}else{
				//codigo aki
				$this->actualizarInventario($idalmacen,$idproducto,$ubicacion,$minimo, $salida, "baja");
			}
		return $validar;
	}
	
	
	
	
	function guardarAsignacion($idmovimiento, $tipo, $concepto,$fechamovimiento,$comentarios,$idalmacen,$costo, $lista){
		if ($tipo=="salida"){
			$arregloCampo=$this->descomponerArreglo(2,0,$lista);
			$arregloCantidad=$this->descomponerArreglo(2,1,$lista);
		}
		if ($tipo=="entrada"){
			$arregloCampo=$this->descomponerArreglo(5,0,$lista);
			$arregloCantidad=$this->descomponerArreglo(5,1,$lista);
			$arregloCosto=$this->descomponerArreglo(5,2,$lista);
			$arregloMinimo=$this->descomponerArreglo(5,3,$lista);
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
				$minimo=$arregloMinimo[$con];
			}else{
				$ubicacion="";
				$minimo="0";
			}
			$resultado=mysqli_query($this->con->conect,"SELECT * FROM kardex WHERE idproducto ='$idproducto' AND idalmacen='$idalmacen' ORDER BY fechamovimiento ASC");
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
							mysqli_query($this->con->conect,"UPDATE kardex SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'");	
					}else{ // Si es una salida
							$existencia=$existencia-$salida;
							$debe=0;
							$haber=$salida*$promedio;
							$saldo=$saldo-$haber;
							mysqli_query($this->con->conect,"UPDATE kardex SET debe='$debe', haber='$haber', promedio='$promedio', existencia='$existencia', saldo='$saldo' WHERE idkardex='$idkardex'");
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
			$idkardexSinc=$this->con->generarClave2(2); /*Sincronizacion 1 */
			$fechamovimiento=$fechamovimiento." ".date("H:i:s");
			if(!mysqli_query($this->con->conect,"INSERT INTO kardex (idkardex, idproducto, fechamovimiento, descripcion, observaciones, entrada, salida, existencia, costounitario, promedio, debe, haber, saldo, idalmacen, idmovimiento, idreferencia, estatus) VALUES ('$idkardexSinc','$idproducto','$fechamovimiento','$concepto','$comentarios','$entrada','$salida','$existencia','$costounitario','$promedio','$debe','$haber','$saldo','$idalmacen','$idmovimiento','0','activo')")){
				$validar=false;
			}else{
				//codigo aki
				$this->actualizarInventario($idalmacen,$idproducto,$ubicacion,$minimo, $salida, "alta");
			}
			$con++;
		}
		return $validar;
	}


	function actualizarInventario($idalmacen,$idproducto, $ubicacion, $minimo, $tipoActualizacion){
			$resultado=mysqli_query($this->con->conect,"SELECT * FROM kardex WHERE idproducto ='$idproducto' AND idalmacen='$idalmacen' ORDER BY fechamovimiento DESC, idkardex DESC LIMIT 1");
			if(mysqli_num_rows($resultado) > 0){
				$filas=mysqli_fetch_array($resultado);
				$costopromedio= $filas['promedio'];
				$saldo= $filas['saldo'];
				$existencia= $filas['existencia'];
			}else{
				$saldo=0;
				$existencia=0;
				$costopromedio=0;
			}
			
			$resultado=mysqli_query($this->con->conect,"SELECT * FROM kardex WHERE idproducto ='$idproducto' AND idalmacen='$idalmacen' ORDER BY fechamovimiento ASC, idkardex ASC LIMIT 1");
			if(mysqli_num_rows($resultado) > 0){
				$filas=mysqli_fetch_array($resultado);
				$salida= $filas['salida'];
				$promediov=$filas['promedio'];
			}else{
				$salida=0;
				$promediov=0;
			}
			if ($salida=="0" && $promediov > 0){ //Salida=0 significa que es entrada
				$estado="Costo correctamente calculado";
			}else{
				$estado="Requiere revisar costo";
				$tipoActualizacion=="baja";
			}
			
			$resultado=mysqli_query($this->con->conect,"SELECT * FROM inventario WHERE idproducto ='$idproducto' AND idalmacen='$idalmacen'");
			if(mysqli_num_rows($resultado) > 0){
				$filas=mysqli_fetch_array($resultado);
				$idinventario=$filas['idinventario'];
				if ($tipoActualizacion=="alta"){
					mysqli_query($this->con->conect,"UPDATE inventario SET existencia='$existencia', saldo='$saldo', promedio='$costopromedio', existencia='$existencia', ubicacion='$ubicacion', minimo='$minimo', estado='$estado' WHERE idinventario='$idinventario'");
				}else{
					mysqli_query($this->con->conect,"UPDATE inventario SET existencia='$existencia', saldo='$saldo', promedio='$costopromedio', existencia='$existencia', estado='$estado' WHERE idinventario='$idinventario'");
				}
				$costopromedio= $filas['promedio'];
				$saldo= $filas['saldo'];
				$existencia= $filas['existencia'];
			}else{
				$idinventarioSinc=$this->con->generarClave2(2); /*Sincronizacion 1 */
				mysqli_query($this->con->conect,"INSERT INTO inventario (idinventario, idalmacen, idproducto, existencia, promedio, saldo, minimo, ubicacion, estado) VALUES ('$idinventarioSinc','$idalmacen','$idproducto','$existencia','$costopromedio','$saldo','$minimo','$ubicacion','$estado')");
			}
	}
	
	
	function guardar($tipo,$concepto,$fechamovimiento,$idalmacen,$numerocomprobante,$comentarios,$estatus,$costo,$lista){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['movimientos']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
				$idmovimiento=$this->con->generarClave(2); /*Sincronizacion 1 */
				$hora=date("H:i:s");
				if(mysqli_query($this->con->conect,"INSERT INTO movimientos (idmovimiento, tipo, concepto, fechamovimiento, hora, idalmacen, numerocomprobante, comentarios, estatus) VALUES ('$idmovimiento','$tipo','$concepto','$fechamovimiento','$hora','$idalmacen','$numerocomprobante','$comentarios','$estatus')")){
					
					if ($this->guardarAsignacion($idmovimiento,$tipo,$concepto,$fechamovimiento,$comentarios,$idalmacen,$costo,$lista)){
						$validar="exito";
					}else{
						$validar="fracaso";
					}
					
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla movimientos ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($tipo,$concepto,$fechamovimiento,$idalmacen,$numerocomprobante,$comentarios,$estatus,$idmovimiento){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['movimientos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE movimientos SET tipo='$tipo', concepto='$concepto', fechamovimiento='$fechamovimiento', idalmacen='$idalmacen', numerocomprobante='$numerocomprobante', comentarios='$comentarios', estatus='$estatus' WHERE idmovimiento='$idmovimiento'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idmovimiento, de la tabla movimientos ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idmovimiento){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['movimientos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE movimientos SET estatus ='bloqueado' WHERE idmovimiento = '$idmovimiento'");
		}
	}
	
	function cambiarEstatus($idmovimiento,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['movimientos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE movimientos SET estatus ='$estatus' WHERE idmovimiento = '$idmovimiento'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla movimientos ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
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
			$resultado=mysqli_query($this->con->conect,"SELECT 
					movimientos.idmovimiento,
					movimientos.tipo,
					movimientos.concepto,
					movimientos.fechamovimiento,
					movimientos.idalmacen,
					movimientos.numerocomprobante,
					movimientos.comentarios,
					movimientos.estatus,
					almacenes.nombre AS nombrealmacenes
					FROM movimientos 
					INNER JOIN almacenes ON movimientos.idalmacen=almacenes.idalmacen
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['movimientos']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					movimientos.idmovimiento,
					movimientos.tipo,
					movimientos.concepto,
					movimientos.fechamovimiento,
					movimientos.idalmacen,
					movimientos.numerocomprobante,
					movimientos.comentarios,
					movimientos.estatus,
					almacenes.nombre AS nombrealmacenes
					FROM movimientos 
					INNER JOIN almacenes ON movimientos.idalmacen=almacenes.idalmacen
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM movimientos $condicion");
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
		$idusuario=$_SESSION['idusuario'];
		$usuario=$_SESSION['usuario'];
		$descripcion="El usuario $usuario ".$descripcion;
		$hora=date('H:i');
		$fecha=date('Y-m-d');
		$modulo="movimientos";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	
	
	function eliminar($ids, $tipoEliminacion, $motivo){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['movimientos']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		// Si la eliminacion es de un movimiento
		if ($motivo=="movimiento"){
			if($this->con->conectar()==true){
				
				if ($tipoEliminacion=='real'){
					$con=0;
					$idsproductos[0]=0;
					$idalmacen=0;
					$idsnuevo=explode(",",$ids);
					foreach ($idsnuevo as $idmovimiento){
						$resultado2=mysqli_query($this->con->conect,"SELECT * FROM kardex WHERE idmovimiento='$idmovimiento'");
						while ($filas2=mysqli_fetch_array($resultado2)) {
							$idsproductos[$con]=$filas2['idproducto'];
							$idalmacen=$filas2['idalmacen'];
							$con++;
						}// Fin de while para el llenado de tablas
					}
					mysqli_query($this->con->conect,"DELETE FROM movimientos WHERE idmovimiento IN ($ids)");
					if(mysqli_query($this->con->conect,"DELETE FROM kardex WHERE idmovimiento IN ($ids)")){
						$idsproductos=array_unique($idsproductos);
						foreach ($idsproductos as $idproducto){
							$this->eliminarAsignacion($idproducto,$idalmacen);
						}
						return "exito";
					}else{
						return "fracaso";
					}
				}
			}
		}
		// Fin de si la eliminacion es de un movimiento
		
		//Si la eliminacion es de una venta
		if ($motivo=="venta"){
			if($this->con->conectar()==true){
				
				if ($tipoEliminacion=='real'){
					$con=0;
					$idsproductos[0]=0;
					$idalmacen=0;
					$idsnuevo=explode(",",$ids);
					foreach ($idsnuevo as $idmovimiento){
						$resultado2=mysqli_query($this->con->conect,"SELECT * FROM kardex WHERE idreferencia='$idmovimiento'");
						while ($filas2=mysqli_fetch_array($resultado2)) {
							$idsproductos[$con]=$filas2['idproducto'];
							$idalmacen=$filas2['idalmacen'];
							$con++;
						}// Fin de while para el llenado de tablas
					}
					mysqli_query($this->con->conect,"DELETE FROM detalleventas WHERE idventa IN ($ids)");
					mysqli_query($this->con->conect,"DELETE FROM ventas WHERE idventa IN ($ids)");
					mysqli_query($this->con->conect,"DELETE FROM movimientos WHERE idreferencia IN ($ids)");
					if(mysqli_query($this->con->conect,"DELETE FROM kardex WHERE idreferencia IN ($ids)")){
						$idsproductos=array_unique($idsproductos);
						foreach ($idsproductos as $idproducto){
							$this->eliminarAsignacion($idproducto,$idalmacen);
						}
						return "exito";
					}else{
						return "fracaso";
					}
				}
			}
		}
		//fin si la eliminacion es de una venta
	}
	
	
}
?>