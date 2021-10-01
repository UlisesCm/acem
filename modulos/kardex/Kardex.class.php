<?php 
include_once("../../conexion/Conexion.class.php");

class Kardex{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((kardex.idproducto LIKE '%".$condicion."%')) AND kardex.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((kardex.idproducto LIKE '%".$condicion."%')) AND kardex.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE kardex.estatus ='eliminado'";
			}else{
				$consulta="WHERE kardex.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from kardex WHERE $campo = '$valor'");
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

	function guardar($idproducto,$fechamovimiento,$descripcion,$observaciones,$entrada,$salida,$existencia,$costounitario,$promedio,$debe,$haber,$saldo,$idsucursal,$idmovimiento,$idreferencia,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['kardex']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
				$idkardex=$this->con->generarClave(2); /*Sincronizacion 1 */
				$fechamovimiento=$fechamovimiento." ".date("H:i:s");
				if(mysqli_query($this->con->conect,"INSERT INTO kardex (idkardex, idproducto, fechamovimiento, descripcion, observaciones, entrada, salida, existencia, costounitario, promedio, debe, haber, saldo, idsucursal, idmovimiento, idreferencia, estatus) VALUES ('$idkardex','$idproducto','$fechamovimiento','$descripcion','$observaciones','$entrada','$salida','$existencia','$costounitario','$promedio','$debe','$haber','$saldo','$idsucursal','$idmovimiento','$idreferencia','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla kardex ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($idproducto,$fechamovimiento,$descripcion,$observaciones,$entrada,$salida,$existencia,$costounitario,$promedio,$debe,$haber,$saldo,$idsucursal,$idmovimiento,$idreferencia,$estatus,$idkardex){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['kardex']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE kardex SET idproducto='$idproducto', fechamovimiento='$fechamovimiento', descripcion='$descripcion', observaciones='$observaciones', entrada='$entrada', salida='$salida', existencia='$existencia', costounitario='$costounitario', promedio='$promedio', debe='$debe', haber='$haber', saldo='$saldo', idsucursal='$idsucursal', idmovimiento='$idmovimiento', idreferencia='$idreferencia', estatus='$estatus' WHERE idkardex='$idkardex'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idkardex, de la tabla kardex ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idkardex){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['kardex']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE kardex SET estatus ='bloqueado' WHERE idkardex = '$idkardex'");
		}
	}
	
	function cambiarEstatus($idkardex,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['kardex']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE kardex SET estatus ='$estatus' WHERE idkardex = '$idkardex'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla kardex ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idkardex){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM kardex WHERE idkardex='$idkardex'");
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
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					kardex.idkardex,
					kardex.idproducto,
					kardex.fechamovimiento,
					kardex.descripcion,
					kardex.observaciones,
					kardex.entrada,
					kardex.salida,
					kardex.existencia,
					kardex.costounitario,
					kardex.promedio,
					kardex.debe,
					kardex.haber,
					kardex.saldo,
					kardex.idsucursal,
					kardex.idmovimiento,
					kardex.idreferencia,
					kardex.estatus,
					productos.nombre AS nombreproductos,
					sucursales.nombre AS nombresucursales,
					movimientoa.concepto AS conceptomovimientoa
					FROM kardex 
					INNER JOIN productos ON kardex.idproducto=productos.idproducto
					INNER JOIN sucursales ON kardex.idsucursal=sucursales.idsucursal
					INNER JOIN movimientoa ON kardex.idmovimiento=movimientoa.idmovimiento
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		/*
		if (!isset($_SESSION['permisos']['kardex']['consultar'])){
			return "denegado";
			exit;
		}*/
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					kardex.idkardex,
					kardex.idproducto,
					kardex.fechamovimiento,
					kardex.descripcion,
					kardex.observaciones,
					kardex.entrada,
					kardex.salida,
					kardex.existencia,
					kardex.costounitario,
					kardex.promedio,
					kardex.debe,
					kardex.haber,
					kardex.saldo,
					kardex.idsucursal,
					kardex.idmovimiento,
					kardex.idreferencia,
					kardex.estatus,
					productos.nombre AS nombreproductos,
					sucursales.nombre AS nombresucursales,
					movimientos.concepto AS conceptomovimientos
					FROM kardex 
					INNER JOIN productos ON kardex.idproducto=productos.idproducto
					INNER JOIN sucursales ON kardex.idsucursal=sucursales.idsucursal
					INNER JOIN movimientos ON kardex.idmovimiento=movimientos.idmovimiento
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	function consultaGeneral($condicion){
		$idsucursal=$_SESSION["idsucursal"];
		if($this->con->conectar()==true){
			$consulta="SELECT 
					kardex$idsucursal.idkardex,
					kardex$idsucursal.idproducto,
					kardex$idsucursal.fechamovimiento,
					kardex$idsucursal.descripcion,
					kardex$idsucursal.observaciones,
					kardex$idsucursal.entrada,
					kardex$idsucursal.salida,
					kardex$idsucursal.existencia,
					kardex$idsucursal.costounitario,
					kardex$idsucursal.promedio,
					kardex$idsucursal.debe,
					kardex$idsucursal.haber,
					kardex$idsucursal.saldo,
					kardex$idsucursal.idmovimiento,
					kardex$idsucursal.idreferencia,
					kardex$idsucursal.estatus,
					productos.nombre AS nombreproductos,
					productos.codigo AS codigoproductos,
					movimientos$idsucursal.concepto AS conceptomovimiento
					FROM kardex$idsucursal
					INNER JOIN productos ON kardex$idsucursal.idproducto=productos.idproducto
					INNER JOIN movimientos$idsucursal ON kardex$idsucursal.idmovimiento=movimientos$idsucursal.idmovimiento
					$condicion
					ORDER BY kardex$idsucursal.fechamovimiento";
					//echo $consulta;
			return mysqli_query($this->con->conect,$consulta);
		}
	}
	
	function consultaKardex($idsucursal,$idproducto){
		$condicion="WHERE productos.idproducto='$idproducto'";
		if($this->con->conectar()==true){
			$consulta="SELECT 
					kardex$idsucursal.idkardex,
					kardex$idsucursal.idproducto,
					kardex$idsucursal.fechamovimiento,
					kardex$idsucursal.descripcion,
					kardex$idsucursal.observaciones,
					kardex$idsucursal.entrada,
					kardex$idsucursal.salida,
					kardex$idsucursal.existencia,
					kardex$idsucursal.costounitario,
					kardex$idsucursal.promedio,
					kardex$idsucursal.debe,
					kardex$idsucursal.haber,
					kardex$idsucursal.saldo,
					kardex$idsucursal.idmovimiento,
					kardex$idsucursal.idreferencia,
					kardex$idsucursal.estatus,
					productos.nombre AS nombreproductos,
					productos.codigo AS codigoproductos,
					movimientos$idsucursal.concepto AS conceptomovimiento
					FROM kardex$idsucursal
					INNER JOIN productos ON kardex$idsucursal.idproducto=productos.idproducto
					INNER JOIN movimientos$idsucursal ON kardex$idsucursal.idmovimiento=movimientos$idsucursal.idmovimiento
					$condicion
					ORDER BY kardex$idsucursal.fechamovimiento";
			return mysqli_query($this->con->conect,$consulta);
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
	
	function obtenerExistencias($idproducto,$idsucursal){
		if($this->con->conectar()==true){
			if ($idsucursal=="x" or $idsucursal==""){
				$resultado=mysqli_query($this->con->conect,"SELECT SUM(existencia) AS ex FROM inventario$idsucursal WHERE idproducto='$idproducto'");
			}else{
				$resultado=mysqli_query($this->con->conect,"SELECT existencia AS ex FROM inventario$idsucursal WHERE idproducto='$idproducto'");
			}
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor["ex"];
				return $valorCampo;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	
	function obtenerSaldo($idproducto,$idsucursal){
		if($this->con->conectar()==true){
			if ($idsucursal=="x" or $idsucursal==""){
				$resultado=mysqli_query($this->con->conect,"SELECT SUM(saldo) AS ex FROM inventario$idsucursal WHERE idproducto='$idproducto'");
			}else{
				$resultado=mysqli_query($this->con->conect,"SELECT saldo AS ex FROM inventario$idsucursal WHERE idproducto='$idproducto'");
			}
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor["ex"];
				return $valorCampo;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	function obtenerPromedio($idproducto){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT promedio AS ex FROM inventario WHERE idproducto='$idproducto'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor["ex"];
				return $valorCampo;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	function registrarBitacora($accion,$descripcion){
		$idusuario=$_SESSION['idusuario'];
		$usuario=$_SESSION['usuario'];
		$descripcion="El usuario $usuario ".$descripcion;
		$hora=date('H:i');
		$fecha=date('Y-m-d');
		$modulo="kardex";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['kardex']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE kardex SET estatus ='eliminado' WHERE idkardex IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla kardex ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM kardex WHERE idkardex IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla kardex ";
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