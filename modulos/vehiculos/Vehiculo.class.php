<?php 
include_once("../../conexion/Conexion.class.php");

class Vehiculo{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((vehiculos.tipo LIKE '%".$condicion."%') OR (vehiculos.marca LIKE '%".$condicion."%') OR (vehiculos.submarca LIKE '%".$condicion."%') OR (vehiculos.color LIKE '%".$condicion."%') OR (vehiculos.placa LIKE '%".$condicion."%') OR (vehiculos.anio LIKE '%".$condicion."%') OR (vehiculos.asignado LIKE '%".$condicion."%') OR (vehiculos.estado LIKE '%".$condicion."%') OR (vehiculos.idempleado LIKE '%".$condicion."%') OR (vehiculos.idsucursal LIKE '%".$condicion."%'))AND vehiculos.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((vehiculos.tipo LIKE '%".$condicion."%') OR (vehiculos.marca LIKE '%".$condicion."%') OR (vehiculos.submarca LIKE '%".$condicion."%') OR (vehiculos.color LIKE '%".$condicion."%') OR (vehiculos.placa LIKE '%".$condicion."%') OR (vehiculos.anio LIKE '%".$condicion."%') OR (vehiculos.asignado LIKE '%".$condicion."%') OR (vehiculos.estado LIKE '%".$condicion."%') OR (vehiculos.idempleado LIKE '%".$condicion."%') OR (vehiculos.idsucursal LIKE '%".$condicion."%'))AND vehiculos.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE vehiculos.estatus ='eliminado'";
			}else{
				$consulta="WHERE vehiculos.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from vehiculos WHERE $campo = '$valor'");
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

	function guardar($tipo,$marca,$submarca,$color,$placa,$capacidaddecarga,$anio,$kminicial,$kmactual,$vigenciaseguro,$kmultimomantenimiento,$fechaultimomantenimiento,$tipodecombustible,$frecuenciamantenimientokm,$frecuenciamantenimientofecha,$asignado,$estado,$idempleado,$idsucursal,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['vehiculos']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idvehiculo=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			    $varConsulta = "INSERT INTO vehiculos (idvehiculo, tipo, marca, submarca, color, placa, capacidaddecarga, anio, kminicial, kmactual, vigenciaseguro, kmultimomantenimiento, fechaultimomantenimiento, tipodecombustible, frecuenciamantenimientokm, frecuenciamantenimientofecha, asignado, estado, idempleado, idsucursal, estatus) VALUES ('$idvehiculo','$tipo','$marca','$submarca','$color','$placa','$capacidaddecarga','$anio','$kminicial','$kmactual','$vigenciaseguro','$kmultimomantenimiento','$fechaultimomantenimiento','$tipodecombustible','$frecuenciamantenimientokm','$frecuenciamantenimientofecha','$asignado','$estado','$idempleado','$idsucursal','$estatus')";
				// echo $varConsulta;
				if(mysqli_query($this->con->conect,$varConsulta)){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla vehiculos ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($tipo,$marca,$submarca,$color,$placa,$capacidaddecarga,$anio,$kminicial,$kmactual,$vigenciaseguro,$kmultimomantenimiento,$fechaultimomantenimiento,$tipodecombustible,$frecuenciamantenimientokm,$frecuenciamantenimientofecha,$asignado,$estado,$idempleado,$idsucursal,$estatus,$idvehiculo){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['vehiculos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE vehiculos SET tipo='$tipo', marca='$marca', submarca='$submarca', color='$color', placa='$placa', capacidaddecarga='$capacidaddecarga', anio='$anio', kminicial='$kminicial', kmactual='$kmactual', vigenciaseguro='$vigenciaseguro', kmultimomantenimiento='$kmultimomantenimiento', fechaultimomantenimiento='$fechaultimomantenimiento', tipodecombustible='$tipodecombustible', frecuenciamantenimientokm='$frecuenciamantenimientokm', frecuenciamantenimientofecha='$frecuenciamantenimientofecha', asignado='$asignado', estado='$estado', idempleado='$idempleado', idsucursal='$idsucursal', estatus='$estatus' WHERE idvehiculo='$idvehiculo'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idvehiculo, de la tabla vehiculos ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idvehiculo){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['vehiculos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE vehiculos SET estatus ='bloqueado' WHERE idvehiculo = '$idvehiculo'");
		}
	}
	
	function cambiarEstatus($idvehiculo,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['vehiculos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE vehiculos SET estatus ='$estatus' WHERE idvehiculo = '$idvehiculo'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla vehiculos ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idvehiculo){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM vehiculos WHERE idvehiculo='$idvehiculo'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					vehiculos.idvehiculo,
					vehiculos.tipo,
					vehiculos.marca,
					vehiculos.submarca,
					vehiculos.color,
					vehiculos.placa,
					vehiculos.capacidaddecarga,
					vehiculos.anio,
					vehiculos.kminicial,
					vehiculos.kmactual,
					vehiculos.vigenciaseguro,
					vehiculos.kmultimomantenimiento,
					vehiculos.fechaultimomantenimiento,
					vehiculos.tipodecombustible,
					vehiculos.frecuenciamantenimientokm,
					vehiculos.frecuenciamantenimientofecha,
					vehiculos.asignado,
					vehiculos.estado,
					vehiculos.idempleado,
					vehiculos.idsucursal,
					vehiculos.estatus,
					sucursales.idsucursal AS idsucursalsucursales,
					empleados.idempleado AS idempleadoempleados
					FROM vehiculos 
					INNER JOIN sucursales ON vehiculos.idsucursal=sucursales.idsucursal
					INNER JOIN empleados ON vehiculos.idempleado=empleados.idempleado
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['vehiculos']['consultar'])){
			return "denegado";
			exit;
		}
		
		
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					vehiculos.idvehiculo,
					vehiculos.tipo,
					vehiculos.marca,
					vehiculos.submarca,
					vehiculos.color,
					vehiculos.placa,
					vehiculos.capacidaddecarga,
					vehiculos.anio,
					vehiculos.kminicial,
					vehiculos.kmactual,
					vehiculos.vigenciaseguro,
					vehiculos.kmultimomantenimiento,
					vehiculos.fechaultimomantenimiento,
					vehiculos.tipodecombustible,
					vehiculos.frecuenciamantenimientokm,
					vehiculos.frecuenciamantenimientofecha,
					vehiculos.asignado,
					vehiculos.estado,
					vehiculos.idempleado,
					vehiculos.idsucursal,
					vehiculos.estatus,
					sucursales.idsucursal AS idsucursalsucursales
					FROM vehiculos 
					INNER JOIN sucursales ON vehiculos.idsucursal=sucursales.idsucursal
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
					
					//echo $consulta;
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM vehiculos $condicion");
		}
	}
	
	function consultaAsignacionVehicular($idempleado){
		/*if($this->con->conectar()==true){
			$varconsulta = "SELECT * FROM vehiculos
			INNER JOIN asignacionvehicular ON vehiculos.idvehiculo = asignacionvehicular.idvehiculo
			WHERE asignacionvehicular.idempleado = '$idempleado'";
			return mysqli_query($this->con->conect,$varConsulta);
		}*/
		
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT * FROM vehiculos
			INNER JOIN asignacionvehicular ON vehiculos.idvehiculo = asignacionvehicular.idvehiculo
			WHERE asignacionvehicular.idempleado = '$idempleado'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor['tipo']." ".$extractor['marca']." ".$extractor['submarca']." ".$extractor['color']." PLACA: ".$extractor['placa'].",".$extractor['capacidaddecarga'];
				return $valorCampo;
			}else{
				return false;
			}
		}else{
			return false;
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
		$modulo="vehiculos";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['vehiculos']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE vehiculos SET estatus ='eliminado' WHERE idvehiculo IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla vehiculos ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM vehiculos WHERE idvehiculo IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla vehiculos ";
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