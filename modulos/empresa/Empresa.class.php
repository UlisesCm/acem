<?php 
include_once("../../conexion/Conexion.class.php");

class Empresa{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE empresa.estatus ='eliminado'";
			}else{
				$consulta="WHERE empresa.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE empresa.estatus ='eliminado'";
			}else{
				$consulta="WHERE empresa.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from empresa WHERE $campo = '$valor'");
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

	function guardar($nombrecomercial,$razonsocial,$rfc,$domiciliofiscal,$regimen,$telefono,$email,$licenciasssa,$logo,$clave_csd,$cer_csd,$key_csd,$numero_csd,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['empresa']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idempresa=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO empresa (idempresa, nombrecomercial, razonsocial, rfc, domiciliofiscal, regimen, telefono, email, licenciasssa, logo, clave_csd, cer_csd, key_csd, numero_csd, estatus) VALUES ('$idempresa','$nombrecomercial','$razonsocial','$rfc','$domiciliofiscal','$regimen','$telefono','$email','$licenciasssa','$logo','$clave_csd','$cer_csd','$key_csd','$numero_csd','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla empresa ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($nombrecomercial,$razonsocial,$rfc,$domiciliofiscal,$regimen,$telefono,$email,$licenciasssa,$logo,$clave_csd,$cer_csd,$key_csd,$numero_csd,$estatus,$idempresa){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['empresa']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE empresa SET nombrecomercial='$nombrecomercial', razonsocial='$razonsocial', rfc='$rfc', domiciliofiscal='$domiciliofiscal', regimen='$regimen', telefono='$telefono', email='$email', licenciasssa='$licenciasssa', logo='$logo', clave_csd='$clave_csd', cer_csd='$cer_csd', key_csd='$key_csd', numero_csd='$numero_csd', estatus='$estatus' WHERE idempresa='$idempresa'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idempresa, de la tabla empresa ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idempresa){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['empresa']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE empresa SET estatus ='bloqueado' WHERE idempresa = '$idempresa'");
		}
	}
	
	function cambiarEstatus($idempresa,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['empresa']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE empresa SET estatus ='$estatus' WHERE idempresa = '$idempresa'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla empresa ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idempresa){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM empresa WHERE idempresa='$idempresa'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					empresa.idempresa,
					empresa.nombrecomercial,
					empresa.razonsocial,
					empresa.rfc,
					empresa.domiciliofiscal,
					empresa.regimen,
					empresa.telefono,
					empresa.email,
					empresa.licenciasssa,
					empresa.logo,
					empresa.clave_csd,
					empresa.cer_csd,
					empresa.key_csd,
					empresa.numero_csd,
					empresa.estatus
					FROM empresa 
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['empresa']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					empresa.idempresa,
					empresa.nombrecomercial,
					empresa.razonsocial,
					empresa.rfc,
					empresa.domiciliofiscal,
					empresa.regimen,
					empresa.telefono,
					empresa.email,
					empresa.licenciasssa,
					empresa.logo,
					empresa.clave_csd,
					empresa.cer_csd,
					empresa.key_csd,
					empresa.numero_csd,
					empresa.estatus
					FROM empresa 
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
			return mysqli_query($this->con->conect,"SELECT * FROM empresa $condicion");
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
		$modulo="empresa";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['empresa']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE empresa SET estatus ='eliminado' WHERE idempresa IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla empresa ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM empresa WHERE idempresa IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla empresa ";
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