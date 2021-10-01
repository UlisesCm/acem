<?php 
include_once("../../conexion/Conexion.class.php");

class Persona{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((personas.rfc LIKE '%".$condicion."%') OR (personas.razonsocial LIKE '%".$condicion."%'))AND personas.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((personas.rfc LIKE '%".$condicion."%') OR (personas.razonsocial LIKE '%".$condicion."%'))AND personas.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE personas.estatus ='eliminado'";
			}else{
				$consulta="WHERE personas.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from personas WHERE $campo = '$valor'");
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

	function guardar($rfc,$razonsocial,$usocfdi,$calle,$numeroexterior,$numerointerior,$colonia,$municipio,$localidad,$estado,$pais,$cp,$email,$mensaje,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['personas']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idpersona=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO personas (idpersona, rfc, razonsocial, usocfdi, calle, numeroexterior, numerointerior, colonia, municipio, localidad, estado, pais, cp, email, mensaje, estatus) VALUES ('$idpersona','$rfc','$razonsocial','$usocfdi','$calle','$numeroexterior','$numerointerior','$colonia','$municipio','$localidad','$estado','$pais','$cp','$email','$mensaje','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla personas ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($rfc,$razonsocial,$usocfdi,$calle,$numeroexterior,$numerointerior,$colonia,$municipio,$localidad,$estado,$pais,$cp,$email,$mensaje,$estatus,$idpersona){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['personas']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE personas SET rfc='$rfc', razonsocial='$razonsocial', usocfdi='$usocfdi', calle='$calle', numeroexterior='$numeroexterior', numerointerior='$numerointerior', colonia='$colonia', municipio='$municipio', localidad='$localidad', estado='$estado', pais='$pais', cp='$cp', email='$email', mensaje='$mensaje', estatus='$estatus' WHERE idpersona='$idpersona'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idpersona, de la tabla personas ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idpersona){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['personas']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE personas SET estatus ='bloqueado' WHERE idpersona = '$idpersona'");
		}
	}
	
	function cambiarEstatus($idpersona,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['personas']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE personas SET estatus ='$estatus' WHERE idpersona = '$idpersona'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla personas ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idpersona){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM personas WHERE idpersona='$idpersona'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					personas.idpersona,
					personas.rfc,
					personas.razonsocial,
					personas.usocfdi,
					personas.calle,
					personas.numeroexterior,
					personas.numerointerior,
					personas.colonia,
					personas.municipio,
					personas.localidad,
					personas.estado,
					personas.pais,
					personas.cp,
					personas.email,
					personas.mensaje,
					personas.estatus
					FROM personas 
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['personas']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					personas.idpersona,
					personas.rfc,
					personas.razonsocial,
					personas.usocfdi,
					personas.calle,
					personas.numeroexterior,
					personas.numerointerior,
					personas.colonia,
					personas.municipio,
					personas.localidad,
					personas.estado,
					personas.pais,
					personas.cp,
					personas.email,
					personas.mensaje,
					personas.estatus
					FROM personas 
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
			return mysqli_query($this->con->conect,"SELECT * FROM personas $condicion");
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
		$modulo="personas";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['personas']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE personas SET estatus ='eliminado' WHERE idpersona IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla personas ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM personas WHERE idpersona IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla personas ";
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