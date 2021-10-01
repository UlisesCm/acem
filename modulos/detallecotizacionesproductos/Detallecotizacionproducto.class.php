<?php 
include_once("../../conexion/Conexion.class.php");

class Detallecotizacionproducto{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
	    $detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
		if ($condicion!=""){
			$consulta="WHERE (($detallecotizacionesproductos.idproducto LIKE '%".$condicion."%')) AND $detallecotizacionesproductos.iddetallecotizacion <>'0'";
		}else{
			$consulta="WHERE $detallecotizacionesproductos.iddetallecotizacion <>'0'";
		}
		return $consulta;
	}function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from $detallecotizacionesproductos WHERE $campo = '$valor'");
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

	function guardar($subfolio,$idproducto,$cantidad,$costo,$precio,$subtotal,$impuestos,$total,$utilidad,$idcotizacionproducto,$pesounitario,$cantidadentregada){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesproductos']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
	    $detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
		$iddetallecotizacion=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("iddetallecotizacion",$iddetallecotizacion, "nuevo")){
				return "iddetallecotizacionExiste";
			}else{
				if(mysqli_query($this->con->conect,"INSERT INTO $detallecotizacionesproductos (iddetallecotizacion, subfolio, idproducto, cantidad, costo, precio, subtotal, impuestos, total, utilidad, idcotizacionproducto, pesounitario, cantidadentregada) VALUES ('$iddetallecotizacion','$subfolio','$idproducto','$cantidad','$costo','$precio','$subtotal','$impuestos','$total','$utilidad','$idcotizacionproducto','$pesounitario','$cantidadentregada')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla detallecotizacionesproductos ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizar($subfolio,$idproducto,$cantidad,$costo,$precio,$subtotal,$impuestos,$total,$utilidad,$idcotizacionproducto,$pesounitario,$cantidadentregada,$iddetallecotizacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesproductos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		 $detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
		if($this->con->conectar()==true){
			if($this->comprobarCampo("iddetallecotizacion",$iddetallecotizacion, "modificar")){
				return "iddetallecotizacionExiste";
			}else{
				if(mysqli_query($this->con->conect,"UPDATE $detallecotizacionesproductos SET subfolio='$subfolio', idproducto='$idproducto', cantidad='$cantidad', costo='$costo', precio='$precio', subtotal='$subtotal', impuestos='$impuestos', total='$total', utilidad='$utilidad', idcotizacionproducto='$idcotizacionproducto', pesounitario='$pesounitario', cantidadentregada='$cantidadentregada' WHERE iddetallecotizacion='$iddetallecotizacion'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $iddetallecotizacion, de la tabla detallecotizacionesproductos ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function bloquear($iddetallecotizacion){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesproductos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"UPDATE $detallecotizacionesproductos SET estatus ='bloqueado' WHERE iddetallecotizacion = '$iddetallecotizacion'");
		}
	}
	
	function cambiarEstatus($iddetallecotizacion,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesproductos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
			if(mysqli_query($this->con->conect,"UPDATE $detallecotizacionesproductos SET estatus ='$estatus' WHERE iddetallecotizacion = '$iddetallecotizacion'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla detallecotizacionesproductos ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($iddetallecotizacion){
		if($this->con->conectar()==true){
			$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"SELECT * FROM $detallecotizacionesproductos WHERE iddetallecotizacion='$iddetallecotizacion'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
			$resultado=mysqli_query($this->con->conect,"SELECT 
					$detallecotizacionesproductos.iddetallecotizacion,
					$detallecotizacionesproductos.subfolio,
					$detallecotizacionesproductos.idproducto,
					$detallecotizacionesproductos.cantidad,
					$detallecotizacionesproductos.costo,
					$detallecotizacionesproductos.precio,
					$detallecotizacionesproductos.subtotal,
					$detallecotizacionesproductos.impuestos,
					$detallecotizacionesproductos.total,
					$detallecotizacionesproductos.utilidad,
					$detallecotizacionesproductos.idcotizacionproducto,
					$detallecotizacionesproductos.pesounitario,
					$detallecotizacionesproductos.cantidadentregada,
					Productos.nombre AS nombreproducto 
					FROM $detallecotizacionesproductos 
					INNER JOIN Productos ON $detallecotizacionesproductos.idproducto=Productos.idproducto
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	
	
	function mostrarDevoluciones($idcotizacionproducto){
		$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		$where="WHERE $detallecotizacionesproductos.iddetallecotizacion<>0 AND $cotizacionesproductos.idcotizacionproducto = $idcotizacionproducto AND $detallecotizacionesproductos.cantidad < 0";
		
		$consulta = "SELECT 
		            SQL_CALC_FOUND_ROWS
					$detallecotizacionesproductos.iddetallecotizacion,
					$detallecotizacionesproductos.subfolio,
					$detallecotizacionesproductos.idproducto,
					$detallecotizacionesproductos.cantidad,
					$detallecotizacionesproductos.costo,
					$detallecotizacionesproductos.precio,
					$detallecotizacionesproductos.subtotal,
					$detallecotizacionesproductos.impuestos,
					$detallecotizacionesproductos.total,
					$detallecotizacionesproductos.utilidad,
					$detallecotizacionesproductos.idcotizacionproducto,
					$detallecotizacionesproductos.pesounitario,
					$detallecotizacionesproductos.cantidadentregada,
					$cotizacionesproductos.idruta,
					$cotizacionesproductos.serie,
					$cotizacionesproductos.folio
					FROM $detallecotizacionesproductos 
					INNER JOIN $cotizacionesproductos ON $detallecotizacionesproductos.idcotizacionproducto = $cotizacionesproductos.idcotizacionproducto 
					$where
					";
					//echo $consulta;
		
		if($this->con->conectar()==true){
			$resultado1 = mysqli_query($this->con->conect,$consulta);
			$resultado2 =  mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			return array ($resultado1,$extractor["contador"]);
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesproductos']['consultar'])){
			return "denegado";
			exit;
		}
		
		$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					$detallecotizacionesproductos.iddetallecotizacion,
					$detallecotizacionesproductos.subfolio,
					$detallecotizacionesproductos.idproducto,
					$detallecotizacionesproductos.cantidad,
					$detallecotizacionesproductos.costo,
					$detallecotizacionesproductos.precio,
					$detallecotizacionesproductos.subtotal,
					$detallecotizacionesproductos.impuestos,
					$detallecotizacionesproductos.total,
					$detallecotizacionesproductos.utilidad,
					$detallecotizacionesproductos.idcotizacionproducto,
					$detallecotizacionesproductos.pesounitario,
					$detallecotizacionesproductos.cantidadentregada,
					Productos.nombre AS nombreproducto 
					FROM $detallecotizacionesproductos 
					INNER JOIN Productos ON $detallecotizacionesproductos.idproducto=Productos.idproducto
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
	
	function mostrarTotalProductosAgrupados($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $idcotizacionproducto){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesproductos']['consultar'])){
			return "denegado";
			exit;
		}
		$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		$where="WHERE $detallecotizacionesproductos.iddetallecotizacion<>0 AND $cotizacionesproductos.idcotizacionproducto = $idcotizacionproducto";
		
		$consulta = "SELECT 
		            SQL_CALC_FOUND_ROWS
					SUM($detallecotizacionesproductos.cantidad) AS cantidadtotal,
					SUM($detallecotizacionesproductos.pesounitario) AS pesototal,
					$detallecotizacionesproductos.iddetallecotizacion,
					$detallecotizacionesproductos.subfolio,
					$detallecotizacionesproductos.idproducto,
					$detallecotizacionesproductos.cantidad,
					$detallecotizacionesproductos.costo,
					$detallecotizacionesproductos.precio,
					$detallecotizacionesproductos.subtotal,
					$detallecotizacionesproductos.impuestos,
					$detallecotizacionesproductos.total,
					$detallecotizacionesproductos.utilidad,
					$detallecotizacionesproductos.idcotizacionproducto,
					$detallecotizacionesproductos.pesounitario,
					$detallecotizacionesproductos.cantidadentregada,
					$cotizacionesproductos.idruta,
					Productos.nombre AS nombreproducto 
					FROM $detallecotizacionesproductos 
					INNER JOIN Productos ON $detallecotizacionesproductos.idproducto=Productos.idproducto
					INNER JOIN $cotizacionesproductos ON $detallecotizacionesproductos.idcotizacionproducto = $cotizacionesproductos.idcotizacionproducto 
					$where
					GROUP BY nombreproducto
					LIMIT $inicial, $cantidadamostrar
					";
					//echo $consulta;
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
	
	function mostrarA($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $idcotizacionproducto){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesproductos']['consultar'])){
			return "denegado";
			exit;
		}
		
		$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
		$where="WHERE $detallecotizacionesproductos.iddetallecotizacion<>0 AND $detallecotizacionesproductos.idcotizacionproducto = $idcotizacionproducto ";
		
		$consulta = "SELECT 
		            SQL_CALC_FOUND_ROWS
					$detallecotizacionesproductos.iddetallecotizacion,
					$detallecotizacionesproductos.subfolio,
					$detallecotizacionesproductos.idproducto,
					$detallecotizacionesproductos.cantidad,
					$detallecotizacionesproductos.costo,
					$detallecotizacionesproductos.precio,
					$detallecotizacionesproductos.subtotal,
					$detallecotizacionesproductos.impuestos,
					$detallecotizacionesproductos.total,
					$detallecotizacionesproductos.utilidad,
					$detallecotizacionesproductos.idcotizacionproducto,
					$detallecotizacionesproductos.pesounitario,
					$detallecotizacionesproductos.cantidadentregada,
					Productos.nombre AS nombreproducto 
					FROM $detallecotizacionesproductos 
					INNER JOIN Productos ON $detallecotizacionesproductos.idproducto=Productos.idproducto
					$where
					ORDER BY subfolio ASC
					LIMIT $inicial, $cantidadamostrar
					";
					//echo $consulta;
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
			$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"SELECT * FROM $detallecotizacionesproductos $condicion");
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
		$modulo="detallecotizacionesproductos";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesproductos']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
				if (mysqli_query($this->con->conect,"UPDATE $detallecotizacionesproductos SET estatus ='eliminado' WHERE iddetallecotizacion IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla detallecotizacionesproductos ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
				if(mysqli_query($this->con->conect,"DELETE FROM $detallecotizacionesproductos WHERE iddetallecotizacion IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla detallecotizacionesproductos ";
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