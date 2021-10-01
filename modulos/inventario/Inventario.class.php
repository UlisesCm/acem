<?php 
include_once("../../conexion/Conexion.class.php");

class Inventario{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		$idsucursal=$_SESSION["idsucursal"];
		if ($condicion!=""){
			$consulta="WHERE ((productos.nombre LIKE '%".$condicion."%') OR (productos.codigo LIKE '%".$condicion."%') OR (productos.modelo LIKE '%".$condicion."%')) AND inventario$idsucursal.idinventario <>'0' AND productos.estatus <> 'eliminado'";
		}else{
			$consulta="WHERE inventario$idsucursal.idinventario <>'0' AND productos.estatus <> 'eliminado'";
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from inventario WHERE $campo = '$valor'");
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

	function guardar($idalmacen,$idproducto,$existencia,$promedio,$saldo,$minimo,$ubicacion,$estado){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['inventario']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$idSync=$this->con->generarClave2(2); /*Sincronizacion 1 */
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO inventario (idinventario, idalmacen, idproducto, existencia, promedio, saldo, minimo, ubicacion, estado) VALUES ('$idSync','$idalmacen','$idproducto','$existencia','$promedio','$saldo','$minimo','$ubicacion','$estado')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla inventario ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($idalmacen,$idproducto,$existencia,$promedio,$saldo,$minimo,$ubicacion,$estado,$idinventario){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['inventario']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE inventario SET idalmacen='$idalmacen', idproducto='$idproducto', existencia='$existencia', promedio='$promedio', saldo='$saldo', minimo='$minimo', ubicacion='$ubicacion', estado='Costo correctamente calculado' WHERE idinventario='$idinventario'")){
					$fechamovimiento=date("Y-m-d");
					$saldo=$promedio*$existencia;
					
					$idmovimiento=$this->con->generarClave(2); /*Sincronizacion 1 */
					$hora=date("H:i:s");
					mysqli_query($this->con->conect,"INSERT INTO movimientos (idmovimiento, tipo, concepto, fechamovimiento, hora, idalmacen, numerocomprobante, comentarios, idreferencia, estatus) VALUES ('$idmovimiento','entrada','ENTRADA DE AJUSTE','$fechamovimiento','$hora','$idalmacen','','Se ha limpiado el historial del producto','0','activo')");
					mysqli_query($this->con->conect,"DELETE FROM kardex WHERE idproducto='$idproducto' AND idalmacen='$idalmacen'");
					
					$idkardex=$this->con->generarClave2(2); /*Sincronizacion 1 */
					$fechamovimiento=$fechamovimiento." ".date("H:i:s");
					mysqli_query($this->con->conect,"INSERT INTO kardex (idkardex, idproducto, fechamovimiento, descripcion, observaciones, entrada, salida, existencia, costounitario, promedio, debe, haber, saldo, idalmacen, idmovimiento, idreferencia, estatus) VALUES ('$idkardex','$idproducto','$fechamovimiento','ENTRADA DE AJUSTE','','$existencia','0','$existencia','$promedio','$promedio','$saldo','0','$saldo','$idalmacen','$idmovimiento','0','activo')");
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idinventario, de la tabla inventario ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	
	
	function actualizarUbicacion($minimo,$ubicacion,$idinventario){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['inventario']['cambiarubicacion'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE inventario SET minimo='$minimo', ubicacion='$ubicacion' WHERE idinventario='$idinventario'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idinventario, de la tabla inventario, cambio de ubicacion o stock minimo";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	
	function bloquear($idinventario){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['inventario']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE inventario SET estatus ='bloqueado' WHERE idinventario = '$idinventario'");
		}
	}
	
	function cambiarEstatus($idinventario,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['inventario']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE inventario SET estatus ='$estatus' WHERE idinventario = '$idinventario'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla inventario ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idinventario){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM inventario WHERE idinventario='$idinventario'");
		}
	}
	
	
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['inventario']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		$idsucursal=$_SESSION["idsucursal"];
		$consulta = "SELECT
					SQL_CALC_FOUND_ROWS
					inventario$idsucursal.idinventario,
					inventario$idsucursal.idproducto,
					inventario$idsucursal.existencia,
					inventario$idsucursal.promedio,
					inventario$idsucursal.saldo,
					inventario$idsucursal.minimo,
					inventario$idsucursal.ubicacion,
					inventario$idsucursal.estado,
					productos.nombre AS nombreproductos,
					productos.estatus AS estatusproducto,
					productos.modelo AS modeloproductos,
					productos.codigo AS codigoproductos
					FROM inventario$idsucursal
					INNER JOIN productos ON inventario$idsucursal.idproducto=productos.idproducto
					$where
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
	
	
	function obtenerCostoTotal($idalmacen){
		if($this->con->conectar()==true){
			if ($idalmacen!="x"){
				$extra="WHERE idalmacen='$idalmacen'";
			}else{
				$extra="";
			}
			$resultado=mysqli_query($this->con->conect,"SELECT SUM(saldo) AS total from inventario $extra");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$numero_filas=$extractor[0];
				return $numero_filas;
			}else{
				return 0;
			}
		}
	}
	
	function obtenerCampo($tabla, $nombrecampo, $idcampo, $valorid){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT $nombrecampo FROM $tabla WHERE $idcampo='$valorid'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				return $extractor["$nombrecampo"];
			}else{
				return "No identificado";
			}
		}
	}
	
	function obtenerDatoViejo($idalamcen, $idproducto, $nombrecampo){
		$campo=0;
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT $nombrecampo FROM inventarioViejo WHERE idalmacen='$idalamcen' AND idproducto='$idproducto'");
			
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$campo=$extractor["$nombrecampo"];
				if ($campo==""){
					$campo=0;
				}
			}else{
				$campo=0;
			}
		}
		return $campo;
	}
	
	
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM inventario $condicion");
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
		$modulo="inventario";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['inventario']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE inventario SET estatus ='eliminado' WHERE idinventario IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla inventario ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM inventario WHERE idinventario IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla inventario ";
						$this->registrarBitacora("eliminar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	
	function resetear($idalmacen){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['inventario']['resetear'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
			if(mysqli_query($this->con->conect,"DELETE FROM inventario WHERE idalmacen='$idalmacen'")){
				mysqli_query($this->con->conect,"DELETE FROM kardex WHERE idalmacen='$idalmacen'");
					//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="Los registros del almacen $idalmacen han sido reseteados";
					$this->registrarBitacora("eliminar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}//Fin resetear();
	
	
	function repararEspecial($idalmacen){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['inventario']['reparar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT * FROM inventario WHERE idalmacen='6'");
			while ($filas=mysqli_fetch_array($resultado)) {
				$idproducto=$filas["idproducto"];
				$existencia=$filas["existencia"];
				mysqli_query($this->con->conect,"UPDATE inventario SET existencia=existencia+$existencia WHERE idproducto='$idproducto' AND idalmacen='3'");
				mysqli_query($this->con->conect,"DELETE FROM kardex WHERE idproducto='$idproducto'");
				
				$idkardex=$this->con->generarClave(2); /*Sincronizacion 1 */
				$fechamovimiento=date("Y-m-d")." ".date("H:i:s");
				$resultado2=mysqli_query($this->con->conect,"SELECT * FROM inventario WHERE idproducto='$idproducto' AND idalmacen='3'");
				$extractor = mysqli_fetch_array($resultado2);
				$costounitario=$extractor["promedio"];
				$promedio=$extractor["promedio"];
				$existenciaReal=$extractor["existencia"];
				$debe=$promedio*$existencia;
				$haber=0;
				$saldo=$debe;
				$idmovimiento='1';
				$idreferencia='0';
				$estatus='activo';
				$entrada=$existenciaReal;
				$salida='0';
			
				mysqli_query($this->con->conect,"INSERT INTO kardex (idkardex, idproducto, fechamovimiento, descripcion, observaciones, entrada, salida, existencia, costounitario, promedio, debe, haber, saldo, idalmacen, idmovimiento, idreferencia, estatus) VALUES ('$idkardex','$idproducto','$fechamovimiento','AJUSTE DE INVENTARIO AUTOMATICO','Costo correctamente calculado','$entrada','$salida','$existenciaReal','$costounitario','$promedio','$debe','$haber','$saldo','3','$idmovimiento','$idreferencia','$estatus')");
				
				
			}
		}
	}//Fin resetear();
	
	
	function reparar($idalmacen){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['inventario']['reparar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
			$this->con->conect->autocommit(false); //INICO DE TRANSACCIONES
			$controlador=true; // VARIABLE DE CONTROL DE TRANSACCIONES
			
			$resultado=mysqli_query($this->con->conect,"SELECT * FROM inventario WHERE idalmacen='$idalmacen'");
			while ($filas=mysqli_fetch_array($resultado)) {
				$idproducto=$filas["idproducto"];
				$existencia=$filas["existencia"];
				$promedio=$filas["promedio"];
				if($existencia<0){
					$existencia=0;
				}
				$saldo=$existencia*$promedio;
				$estado="Costo correctamente calculado";
				if(!mysqli_query($this->con->conect,"UPDATE inventario SET saldo='$saldo', existencia='$existencia', estado='$estado' WHERE idproducto='$idproducto' AND idalmacen='$idalmacen'")){
					$controlador=false;
				}
				if (!mysqli_query($this->con->conect,"DELETE FROM kardex WHERE idproducto='$idproducto'")){
					$controlador=false;
				}
				
				$idkardex=$this->con->generarClave(2); /*Sincronizacion 1 */
				$fechamovimiento=date("Y-m-d")." ".date("H:i:s");
				$costounitario=$promedio;
				$debe=$promedio*$existencia;
				$haber=0;
				$saldo=$debe;
				$idmovimiento='1';
				$idreferencia='0';
				$estatus='activo';
				$entrada=$existencia;
				$salida='0';
			
				if(!mysqli_query($this->con->conect,"INSERT INTO kardex (idkardex, idproducto, fechamovimiento, descripcion, observaciones, entrada, salida, existencia, costounitario, promedio, debe, haber, saldo, idalmacen, idmovimiento, idreferencia, estatus) VALUES ('$idkardex','$idproducto','$fechamovimiento','AJUSTE DE INVENTARIO AUTOMATICO','Costo correctamente calculado','$entrada','$salida','$existencia','$costounitario','$promedio','$debe','$haber','$saldo','3','$idmovimiento','$idreferencia','$estatus')")){
					$controlador=false;
				}
				
			} //Fin de While
			
			if($controlador){ //PASAMOS LA CONEXION PARA NO PERDER LA TRANSACCION
				$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
				return "exito";
			}else{
				$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
				return "fracaso";
			}
					
		} // Fin de If Conexión
	}//Fin resetear();
}
?>