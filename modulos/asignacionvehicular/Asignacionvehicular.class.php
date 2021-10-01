<?php 
include_once("../../conexion/Conexion.class.php");

class Asignacionvehicular{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			$consulta="WHERE asignacionvehicular.idasignacionvehicular <>'0'";
		}else{
			$consulta="WHERE asignacionvehicular.idasignacionvehicular <>'0'";
		}
		return $consulta;
	}function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from asignacionvehicular WHERE $campo = '$valor'");
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

	function guardar($fecha,$idempleado,$idvehiculo,$observaciones){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['asignacionvehicular']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idasignacionvehicular=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO asignacionvehicular (idasignacionvehicular, fecha, idempleado, idvehiculo, observaciones) VALUES ('$idasignacionvehicular','$fecha','$idempleado','$idvehiculo','$observaciones')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla asignacionvehicular ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($fecha,$idempleado,$idvehiculo,$observaciones,$idasignacionvehicular){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['asignacionvehicular']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE asignacionvehicular SET fecha='$fecha', idempleado='$idempleado', idvehiculo='$idvehiculo', observaciones='$observaciones' WHERE idasignacionvehicular='$idasignacionvehicular'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idasignacionvehicular, de la tabla asignacionvehicular ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idasignacionvehicular){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['asignacionvehicular']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE asignacionvehicular SET estatus ='bloqueado' WHERE idasignacionvehicular = '$idasignacionvehicular'");
		}
	}
	
	function cambiarEstatus($idasignacionvehicular,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['asignacionvehicular']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE asignacionvehicular SET estatus ='$estatus' WHERE idasignacionvehicular = '$idasignacionvehicular'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla asignacionvehicular ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idasignacionvehicular){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM asignacionvehicular WHERE idasignacionvehicular='$idasignacionvehicular'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					asignacionvehicular.idasignacionvehicular,
					asignacionvehicular.fecha,
					asignacionvehicular.idempleado,
					asignacionvehicular.idvehiculo,
					asignacionvehicular.observaciones,
					empleados.idempleado AS idempleadoempleados,
					vehiculos.idvehiculo AS idvehiculovehiculos
					FROM asignacionvehicular 
					INNER JOIN empleados ON asignacionvehicular.idempleado=empleados.idempleado
					INNER JOIN vehiculos ON asignacionvehicular.idvehiculo=vehiculos.idvehiculo
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['asignacionvehicular']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					asignacionvehicular.idasignacionvehicular,
					asignacionvehicular.fecha,
					asignacionvehicular.idempleado,
					asignacionvehicular.idvehiculo,
					asignacionvehicular.observaciones,
					empleados.nombre AS nombreempleado,
					vehiculos.tipo AS tipovehiculo,
					vehiculos.marca AS marcavehiculo,
					vehiculos.submarca AS submarcavehiculo,
					vehiculos.color AS colorvehiculo,
					vehiculos.placa AS placavehiculo
					FROM asignacionvehicular 
					INNER JOIN empleados ON asignacionvehicular.idempleado=empleados.idempleado
					INNER JOIN vehiculos ON asignacionvehicular.idvehiculo=vehiculos.idvehiculo
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
			return mysqli_query($this->con->conect,"SELECT * FROM asignacionvehicular $condicion");
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
		$modulo="asignacionvehicular";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['asignacionvehicular']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE asignacionvehicular SET estatus ='eliminado' WHERE idasignacionvehicular IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla asignacionvehicular ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM asignacionvehicular WHERE idasignacionvehicular IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla asignacionvehicular ";
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