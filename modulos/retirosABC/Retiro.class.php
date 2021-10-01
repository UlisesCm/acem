<?php 
include_once("../../conexion/Conexion.class.php");

class Retiro{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((retiros.fecha LIKE '%".$condicion."%') OR (retiros.descripcion LIKE '%".$condicion."%') OR (retiros.monto LIKE '%".$condicion."%') OR (retiros.cheque LIKE '%".$condicion."%') OR (retiros.idcuenta LIKE '%".$condicion."%'))AND retiros.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((retiros.fecha LIKE '%".$condicion."%') OR (retiros.descripcion LIKE '%".$condicion."%') OR (retiros.monto LIKE '%".$condicion."%') OR (retiros.cheque LIKE '%".$condicion."%') OR (retiros.idcuenta LIKE '%".$condicion."%'))AND retiros.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE retiros.estatus ='eliminado'";
			}else{
				$consulta="WHERE retiros.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from retiros WHERE $campo = '$valor'");
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

	function guardar($fecha,$descripcion,$monto,$cheque,$idcuenta,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['retiros']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idretiro=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO retiros (idretiro, fecha, descripcion, monto, cheque, idcuenta, estatus) VALUES ('$idretiro','$fecha','$descripcion','$monto','$cheque','$idcuenta','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla retiros ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($fecha,$descripcion,$monto,$cheque,$idcuenta,$estatus,$idretiro){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['retiros']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE retiros SET fecha='$fecha', descripcion='$descripcion', monto='$monto', cheque='$cheque', idcuenta='$idcuenta', estatus='$estatus' WHERE idretiro='$idretiro'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idretiro, de la tabla retiros ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idretiro){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['retiros']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE retiros SET estatus ='bloqueado' WHERE idretiro = '$idretiro'");
		}
	}
	
	function cambiarEstatus($idretiro,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['retiros']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE retiros SET estatus ='$estatus' WHERE idretiro = '$idretiro'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla retiros ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idretiro){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM retiros WHERE idretiro='$idretiro'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					retiros.idretiro,
					retiros.fecha,
					retiros.descripcion,
					retiros.monto,
					retiros.cheque,
					retiros.idcuenta,
					retiros.estatus,
					cuentasbancarias.idcuenta AS idcuentacuentasbancarias
					FROM retiros 
					INNER JOIN cuentasbancarias ON retiros.idcuenta=cuentasbancarias.idcuenta
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['retiros']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					retiros.idretiro,
					retiros.fecha,
					retiros.descripcion,
					retiros.monto,
					retiros.cheque,
					retiros.idcuenta,
					retiros.estatus,
					cuentasbancarias.cuenta AS cuentabancaria, 
					cuentasbancarias.banco AS bancocuenta 
					FROM retiros 
					INNER JOIN cuentasbancarias ON retiros.idcuenta=cuentasbancarias.idcuenta
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
			return mysqli_query($this->con->conect,"SELECT * FROM retiros $condicion");
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
		$modulo="retiros";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['retiros']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$validar = "exito";;
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//quitar el idretiro de los registros de gastos y compras relacionados
				if (!mysqli_query($this->con->conect,"UPDATE compras SET idretiro ='0' WHERE idretiro IN ($ids)")){
					$validar="fracaso";
				}
				if (!mysqli_query($this->con->conect,"UPDATE gastos SET idretiro ='0' WHERE idretiro IN ($ids)")){
					$validar="fracaso";
				}
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE retiros SET estatus ='eliminado' WHERE idretiro IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla retiros ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
				}else{
					$validar="fracaso";
				}
			}
			
		}
		return $validar;
	}
}
?>