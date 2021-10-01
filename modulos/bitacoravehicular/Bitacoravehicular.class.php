<?php 
include_once("../../conexion/Conexion.class.php");

class Bitacoravehicular{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((bitacoravehicular.categoria LIKE '%".$condicion."%') OR (bitacoravehicular.descripcion LIKE '%".$condicion."%'))AND bitacoravehicular.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((bitacoravehicular.categoria LIKE '%".$condicion."%') OR (bitacoravehicular.descripcion LIKE '%".$condicion."%'))AND bitacoravehicular.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE bitacoravehicular.estatus ='eliminado'";
			}else{
				$consulta="WHERE bitacoravehicular.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from bitacoravehicular WHERE $campo = '$valor'");
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

	function guardar($idvehiculo,$categoria,$fecha,$descripcion,$tipocombustible,$litros,$kilometraje,$archivo,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoravehicular']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idbitacoravehicular=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			    $varConsulta = "INSERT INTO bitacoravehicular (idbitacoravehicular, idvehiculo, categoria, fecha, descripcion, tipocombustible, litros, kilometraje, archivo, estatus) VALUES ('$idbitacoravehicular','$idvehiculo','$categoria','$fecha','$descripcion','$tipocombustible','$litros','$kilometraje','$archivo','$estatus')";
				//echo $varConsulta;
				if(mysqli_query($this->con->conect,$varConsulta)){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla bitacoravehicular ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($idvehiculo,$categoria,$fecha,$descripcion,$tipocombustible,$litros,$kilometraje,$archivo,$estatus,$idbitacoravehicular){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoravehicular']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE bitacoravehicular SET idvehiculo='$idvehiculo', categoria='$categoria', fecha='$fecha', descripcion='$descripcion', tipocombustible='$tipocombustible', litros='$litros', kilometraje='$kilometraje', archivo='$archivo', estatus='$estatus' WHERE idbitacoravehicular='$idbitacoravehicular'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idbitacoravehicular, de la tabla bitacoravehicular ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idbitacoravehicular){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoravehicular']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE bitacoravehicular SET estatus ='bloqueado' WHERE idbitacoravehicular = '$idbitacoravehicular'");
		}
	}
	
	function cambiarEstatus($idbitacoravehicular,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoravehicular']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE bitacoravehicular SET estatus ='$estatus' WHERE idbitacoravehicular = '$idbitacoravehicular'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla bitacoravehicular ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idbitacoravehicular){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM bitacoravehicular WHERE idbitacoravehicular='$idbitacoravehicular'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					bitacoravehicular.idbitacoravehicular,
					bitacoravehicular.idvehiculo,
					bitacoravehicular.categoria,
					bitacoravehicular.fecha,
					bitacoravehicular.descripcion,
					bitacoravehicular.tipocombustible,
					bitacoravehicular.litros,
					bitacoravehicular.kilometraje,
					bitacoravehicular.archivo,
					bitacoravehicular.estatus
					FROM bitacoravehicular 
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoravehicular']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					bitacoravehicular.idbitacoravehicular,
					bitacoravehicular.idvehiculo,
					bitacoravehicular.categoria,
					bitacoravehicular.fecha,
					bitacoravehicular.descripcion,
					bitacoravehicular.tipocombustible,
					bitacoravehicular.litros,
					bitacoravehicular.kilometraje,
					bitacoravehicular.archivo,
					bitacoravehicular.estatus
					FROM bitacoravehicular 
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	
	function mostrarA($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $idvehiculo, $filtrarfecha, $fechainicio, $fechafin, $excel=""){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoravehicular']['consultar'])){
			return "denegado";
			exit;
		}
		
		
		$consultaVehiculo = "";
		$consultaFecha = "";
		
		if ($idvehiculo!=""){
			$consultaVehiculo=" AND bitacoravehicular.idvehiculo='$idvehiculo'";
		}
		if ($filtrarfecha=="SI"){
			$consultaFecha=" AND bitacoravehicular.fecha >= '$fechainicio' AND bitacoravehicular.fecha <= '$fechafin' ";
		}else{
			$consultaFecha="";
		}
		
		
		$where="";
		$where="WHERE bitacoravehicular.idbitacoravehicular<>0 
		$consultaVehiculo
		$consultaFecha";
		
		$consulta = "SELECT 
		            SQL_CALC_FOUND_ROWS
					bitacoravehicular.idbitacoravehicular,
					bitacoravehicular.idvehiculo,
					bitacoravehicular.categoria,
					bitacoravehicular.fecha,
					bitacoravehicular.descripcion,
					bitacoravehicular.tipocombustible,
					bitacoravehicular.litros,
					bitacoravehicular.kilometraje,
					bitacoravehicular.archivo,
					bitacoravehicular.estatus,
					vehiculos.tipo AS tipovehiculo,
					vehiculos.marca AS marcavehiculo,
					vehiculos.submarca AS submarcavehiculo, 
					vehiculos.color AS colorvehiculo, 
					vehiculos.placa AS placavehiculo 
					FROM bitacoravehicular 
					INNER JOIN vehiculos ON bitacoravehicular.idvehiculo=vehiculos.idvehiculo
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
		
		
		if($this->con->conectar()==true){
			$resultado1 = mysqli_query($this->con->conect,$consulta);
			$resultado2 =  mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			return array ($resultado1,$extractor["contador"]);
		}
	}
	
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM bitacoravehicular $condicion");
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
		$modulo="bitacoravehicular";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoravehicular']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE bitacoravehicular SET estatus ='eliminado' WHERE idbitacoravehicular IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla bitacoravehicular ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM bitacoravehicular WHERE idbitacoravehicular IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla bitacoravehicular ";
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