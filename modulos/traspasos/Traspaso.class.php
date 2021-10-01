<?php 
include_once("../../conexion/Conexion.class.php");

class Traspaso{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			$consulta="WHERE ((traspasos.numerocomprobante LIKE '%".$condicion."%')) AND traspasos.idtraspaso <>'0'";
		}else{
			$consulta="WHERE traspasos.idtraspaso <>'0'";
		}
		return $consulta;
	}function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from traspasos WHERE $campo = '$valor'");
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

	function guardar($idmovimiento,$idsucursalorigen,$idsucursaldestino,$fechasalida,$fechaentrada,$estado,$numerocomprobante,$idusuariosalida,$idusuarioentrada){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['traspasos']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idtraspaso=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO traspasos (idtraspaso, idmovimiento, idsucursalorigen, idsucursaldestino, fechasalida, fechaentrada, estado, numerocomprobante, idusuariosalida, idusuarioentrada) VALUES ('$idtraspaso','$idmovimiento','$idsucursalorigen','$idsucursaldestino','$fechasalida','$fechaentrada','$estado','$numerocomprobante','$idusuariosalida','$idusuarioentrada')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla traspasos ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($idmovimiento,$idsucursalorigen,$idsucursaldestino,$fechasalida,$fechaentrada,$estado,$numerocomprobante,$idusuariosalida,$idusuarioentrada,$idtraspaso){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['traspasos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE traspasos SET idmovimiento='$idmovimiento', idsucursalorigen='$idsucursalorigen', idsucursaldestino='$idsucursaldestino', fechasalida='$fechasalida', fechaentrada='$fechaentrada', estado='$estado', numerocomprobante='$numerocomprobante', idusuariosalida='$idusuariosalida', idusuarioentrada='$idusuarioentrada' WHERE idtraspaso='$idtraspaso'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idtraspaso, de la tabla traspasos ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idtraspaso){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['traspasos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE traspasos SET estatus ='bloqueado' WHERE idtraspaso = '$idtraspaso'");
		}
	}
	
	function cambiarEstatus($idtraspaso,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['traspasos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE traspasos SET estatus ='$estatus' WHERE idtraspaso = '$idtraspaso'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla traspasos ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idtraspaso){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM traspasos WHERE idtraspaso='$idtraspaso'");
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['traspasos']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					
					traspasos.idtraspaso,
					traspasos.idmovimiento,
					traspasos.idsucursalorigen,
					traspasos.idsucursaldestino,
					traspasos.fechasalida,
					traspasos.fechaentrada,
					traspasos.estado,
					traspasos.numerocomprobante,
					traspasos.idusuariosalida,
					traspasos.idusuarioentrada
					FROM traspasos 
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
			return mysqli_query($this->con->conect,"SELECT * FROM traspasos $condicion");
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
		$modulo="traspasos";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['traspasos']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE traspasos SET estatus ='eliminado' WHERE idtraspaso IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla traspasos ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM traspasos WHERE idtraspaso IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla traspasos ";
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