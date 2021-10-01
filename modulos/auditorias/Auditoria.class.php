<?php 
include_once("../../conexion/Conexion.class.php");
if (file_exists("../movimientos/Movimiento.class.php")){
	include_once("../movimientos/Movimiento.class.php");
}else{
	include_once("../../movimientos/Movimiento.class.php");
}
global $arrayFamilia;
$arrayFamilia=array();
class Auditoria{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		$idsucursal=$_SESSION['idsucursal'];
		if ($condicion!=""){
			$consulta="WHERE ((auditorias.idsucursal LIKE '%".$condicion."%') OR (auditorias.idfamilia LIKE '%".$condicion."%') OR (auditorias.fecha LIKE '%".$condicion."%'))AND auditorias.idauditoria <>'0' AND auditorias.idsucursal='$idsucursal'";
		}else{
			$consulta="WHERE auditorias.idauditoria <>'0' AND auditorias.idsucursal='$idsucursal'";
		}
		return $consulta;
	}function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from auditorias WHERE $campo = '$valor'");
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
	
	function obtenerFamiliasHijas($idfamilia, $conexion){
		global $arrayFamilia;
		$resultado2=mysqli_query($conexion,"SELECT * FROM familias WHERE idfamiliamadre='$idfamilia'");
		if($resultado2){ //Si se obtienen las familias
			while ($filas2=mysqli_fetch_array($resultado2)) { 
				$idfamilia=$filas2['idfamilia'];
				
				if (!in_array($idfamilia, $arrayFamilia)) {
					$this->obtenerFamiliasHijas($idfamilia, $conexion);
				}
				array_push($arrayFamilia,$idfamilia);
			}
		}else{//Si no se obtienen las familias
			return "error";
		}
		
		return "exito";
	}
	
	function obtenerExistencias($idproducto, $conexion){
		$idsucursal=$_SESSION['idsucursal'];
		$existencia=0;
		//print_r($listaCampos);
		$resultado=mysqli_query($conexion,"SELECT existencia FROM inventario$idsucursal WHERE idproducto = '$idproducto'");
		if ($resultado){
			$extractor = mysqli_fetch_array($resultado);
			$existencia=$extractor["existencia"];
			return $existencia;
		}else{
			return false;
		}
		
	}
	
	
	function guardarAsignacion($idauditoria, $idfamilia ,$conexion){
			global $arrayFamilia;
			$cadena="";
			$validar=true;
			$idsfamilias=$this->obtenerFamiliasHijas($idfamilia,$conexion);
			$conteo=0;
			$diferencia=0;
			$idusuario=$_SESSION['idusuario'];
			$estado="Pendiente";
			$fecha= date("Y-m-d");
			if ($idsfamilias!="error"){
				foreach ($arrayFamilia as &$valor) {
					$cadena = $cadena.$valor.",";
				}
				$cadena=$idfamilia.",".$cadena;
				$cadena = substr($cadena, 0, -1);
			}else{
				return false;
			}
			$con=0;
			$validar=true;
			$resultado=mysqli_query($conexion,"SELECT idproducto FROM productos WHERE idfamilia IN ($cadena) AND estatus <> 'eliminado'");
			if ($resultado){
				while ($filas=mysqli_fetch_array($resultado)) {
					$idproducto=$filas['idproducto'];
					$existencia=$this->obtenerExistencias($idproducto,$conexion);
					if ($existencia===false){
						$validar=false;
					}else{
						$iddetalleauditoria=$this->con->generarClave(2).$con;
						if(!mysqli_query($conexion,"INSERT INTO detalleauditorias (iddetalleauditoria, idauditoria, idproducto, existenciaanterior, existencia, conteo, diferencia, idusuario, estado, fecha) VALUES ('$iddetalleauditoria','$idauditoria','$idproducto','$existencia','$existencia','$conteo','$existencia','$idusuario','$estado','$fecha')")){
							$validar=false;
						}
					}
					$con++;
				}
			}else{
				$validar=false;
			}
			return $validar;
	}

	function guardar($fecha,$idusuario,$idfamilia,$idsucursal,$comentarios,$estado){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['auditorias']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		
		
		if($this->con->conectar()==true){
			$this->con->conect->autocommit(false); //INICO DE TRANSACCION
			$idauditoria=$this->con->generarClave(2); /*Sincronizacion 1 */
			
			if(mysqli_query($this->con->conect,"INSERT INTO auditorias (idauditoria, fecha, idusuario, idfamilia, idsucursal, comentarios, estado) VALUES ('$idauditoria','$fecha','$idusuario','$idfamilia','$idsucursal','$comentarios','$estado')")){
				if ($this->guardarAsignacion($idauditoria,$idfamilia,$this->con->conect)){
					$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla auditorias ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito@$idauditoria";
				}else{
					return "fracasoDetalles";
				}
			}else{
				$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
				return "fracaso";
			}
			
		}
	}
	
	function actualizarDato($iddetalleauditoria,$conteo){		
		if($this->con->conectar()==true){
			$idusuario=$_SESSION['idusuario'];
			if(mysqli_query($this->con->conect,"UPDATE detalleauditorias SET conteo='$conteo', diferencia=(existencia-conteo), estado='Contado', idusuario='$idusuario' WHERE iddetalleauditoria='$iddetalleauditoria'")){
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function actualizar($fecha,$idusuario,$idfamilia,$idsucursal,$comentarios,$estado,$idauditoria){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['auditorias']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE auditorias SET fecha='$fecha', idusuario='$idusuario', idfamilia='$idfamilia', idsucursal='$idsucursal', comentarios='$comentarios', estado='$estado' WHERE idauditoria='$idauditoria'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idauditoria, de la tabla auditorias ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idauditoria){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['auditorias']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE auditorias SET estatus ='bloqueado' WHERE idauditoria = '$idauditoria'");
		}
	}
	
	function ajustarInventario($idauditoria){
		$validar="exito";
		if($this->con->conectar()==true){
			
			$Omovimiento = new Movimiento;
			$idsucursal=$_SESSION['idsucursal'];
			$concepto="AJUSTE";
			$fechamovimiento=date("Y-m-d");
			$hora=date("H:i");
			$numerocomprobante=$idauditoria;
			$tabla="auditorias";
			$idreferencia=$idauditoria;
			$comentarios="Ajuste de inventario a causa de diferencias en la auditoria";
			$estado="";
			$estatus="activo";
			
			$this->con->conect->autocommit(false); //INICO DE TRANSACCION
			
			if(!mysqli_query($this->con->conect,"UPDATE auditorias SET estado='cerrada' WHERE idauditoria='$idauditoria'")){
				$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
				$validar="fracaso";
				exit;
			}
			
			$resultado=mysqli_query($this->con->conect,"SELECT detalleauditorias.iddetalleauditoria, detalleauditorias.idproducto, detalleauditorias.conteo, detalleauditorias.diferencia, productos.costo AS costoproducto FROM detalleauditorias INNER JOIN productos ON productos.idproducto=detalleauditorias.idproducto WHERE detalleauditorias.idauditoria='$idauditoria' AND detalleauditorias.diferencia > 0 AND detalleauditorias.estado <> 'Pendiente'");
			if ($resultado){ //Si existen detalles cuya diferencia sea mayor que cero, requieren una salida.
				$idmovimiento=$this->con->generarClave(2); /*Sincronizacion 1 */
				$tipo="salida";
				$guardarMovimiento=1;
				if(mysqli_num_rows($resultado)>0){
					$guardarMovimiento=mysqli_query($this->con->conect,"INSERT INTO movimientos$idsucursal (idmovimiento, tipo, concepto, fechamovimiento, hora, numerocomprobante, tabla, idreferencia, comentarios, estado, estatus) VALUES ('$idmovimiento','$tipo','$concepto','$fechamovimiento','$hora','$numerocomprobante','$tabla','$idreferencia', '$comentarios', '$estado', '$estatus')");
				}
				
				if($guardarMovimiento){
					while ($filas=mysqli_fetch_array($resultado)) {
						$iddetalleauditoria=$filas['iddetalleauditoria'];
						$idproducto=$filas['idproducto'];
						$conteo=$filas['conteo'];
						$diferencia=abs($filas['diferencia']);
						$costo=$filas['costoproducto'];
						
						$lista=$idproducto.":::".$diferencia;
						$lista=explode(":::",$lista);
						if(!$Omovimiento->guardarAsignacion($idmovimiento,$tipo,$concepto,$fechamovimiento,$comentarios,$idsucursal,$lista,$this->con->conect)){
							$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
							$validar="fracaso";
							exit;
						}
						if(!mysqli_query($this->con->conect,"UPDATE detalleauditorias SET existencia='$conteo', diferencia='0' WHERE iddetalleauditoria='$iddetalleauditoria'")){
							$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
							$validar="fracaso";
							exit;
						}
					}
				}else{
					$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
					$validar="fracaso";
					exit;
				}
			}else{
				$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
				$validar="fracaso";
				exit;
			}
			
			$resultado=mysqli_query($this->con->conect,"SELECT detalleauditorias.iddetalleauditoria, detalleauditorias.idproducto, detalleauditorias.conteo, detalleauditorias.diferencia, productos.costo AS costoproducto FROM detalleauditorias INNER JOIN productos ON productos.idproducto=detalleauditorias.idproducto WHERE detalleauditorias.idauditoria='$idauditoria' AND detalleauditorias.diferencia < 0 AND detalleauditorias.estado <> 'Pendiente'");
			if ($resultado){ //Si existen detalles cuya diferencia sea menor que cero, requieren una entrada.
				$idmovimiento=$this->con->generarClave(2); /*Sincronizacion 1 */
				$tipo="entrada";
				$guardarMovimiento=1;
				if(mysqli_num_rows($resultado)>0){
					$guardarMovimiento=mysqli_query($this->con->conect,"INSERT INTO movimientos$idsucursal (idmovimiento, tipo, concepto, fechamovimiento, hora, numerocomprobante, tabla, idreferencia, comentarios, estado, estatus) VALUES ('$idmovimiento','$tipo','$concepto','$fechamovimiento','$hora','$numerocomprobante','$tabla','$idreferencia', '$comentarios', '$estado', '$estatus')");
				}
				if($guardarMovimiento){
					while ($filas=mysqli_fetch_array($resultado)) {
						$iddetalleauditoria=$filas['iddetalleauditoria'];
						$idproducto=$filas['idproducto'];
						$conteo=$filas['conteo'];
						$diferencia=abs($filas['diferencia']);
						$costo=$filas['costoproducto'];
						
						$lista=$idproducto.":::".$diferencia.":::".$costo.":::0:::0";
						$lista=explode(":::",$lista);
						if(!$Omovimiento->guardarAsignacion($idmovimiento,$tipo,$concepto,$fechamovimiento,$comentarios,$idsucursal,$lista,$this->con->conect)){
							$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
							$validar="fracaso";
							exit;
						}
						if(!mysqli_query($this->con->conect,"UPDATE detalleauditorias SET existencia='$conteo', diferencia='0' WHERE iddetalleauditoria='$iddetalleauditoria'")){
							$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
							$validar="fracaso";
							exit;
						}
					}
				}else{
					$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
					$validar="fracaso";
					exit;
				}
			}else{
				$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
				$validar="fracaso";
				exit;
			}
			
			
		}else{ // Si no se puede conectar a la base de datos
			return $validar;
			exit;
		}
		if ($validar=="exito"){
			$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
			return $validar;
		}else{
			return $validar;
		}
	}
	
	function cambiarEstatus($idauditoria,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['auditorias']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE auditorias SET estatus ='$estatus' WHERE idauditoria = '$idauditoria'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla auditorias ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idauditoria){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT
					auditorias.idauditoria,
					auditorias.fecha,
					auditorias.idusuario,
					auditorias.idfamilia,
					auditorias.idsucursal,
					auditorias.comentarios,
					auditorias.estado,
					usuarios.nombre AS nombreusuarios,
					familias.nombre AS nombrefamilias,
					sucursales.nombre AS nombresucursales
					FROM auditorias 
					INNER JOIN usuarios ON auditorias.idusuario=usuarios.idusuario
					INNER JOIN familias ON auditorias.idfamilia=familias.idfamilia
					INNER JOIN sucursales ON auditorias.idsucursal=sucursales.idsucursal
					WHERE idauditoria='$idauditoria'");
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['auditorias']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					auditorias.idauditoria,
					auditorias.fecha,
					auditorias.idusuario,
					auditorias.idfamilia,
					auditorias.idsucursal,
					auditorias.comentarios,
					auditorias.estado,
					usuarios.nombre AS nombreusuarios,
					familias.nombre AS nombrefamilias,
					sucursales.nombre AS nombresucursales
					FROM auditorias 
					INNER JOIN usuarios ON auditorias.idusuario=usuarios.idusuario
					INNER JOIN familias ON auditorias.idfamilia=familias.idfamilia
					INNER JOIN sucursales ON auditorias.idsucursal=sucursales.idsucursal
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
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM auditorias $condicion");
		}
	}
	
	function consultaLibre($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,$condicion);
		}
	}
	
	function obtenerConfiguracion($campo){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT valor FROM configuracion WHERE concepto='$campo' ");
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
		$modulo="auditorias";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['auditorias']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE auditorias SET estatus ='eliminado' WHERE idauditoria IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla auditorias ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM auditorias WHERE idauditoria IN ($ids)")){
					
					mysqli_query($this->con->conect,"DELETE FROM detalleauditorias WHERE idauditoria IN ($ids)");
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla auditorias ";
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