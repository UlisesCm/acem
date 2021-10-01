<?php 
include_once("../../conexion/Conexion.class.php");

class Datofiscal{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((datosfiscales.idcliente LIKE '%".$condicion."%') OR (datosfiscales.domiciliocompleto LIKE '%".$condicion."%') OR (datosfiscales.formapago LIKE '%".$condicion."%') OR (datosfiscales.metodopago LIKE '%".$condicion."%') OR (datosfiscales.usocfdi LIKE '%".$condicion."%') OR (clientes.nombre LIKE '%".$condicion."%'))AND datosfiscales.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((datosfiscales.idcliente LIKE '%".$condicion."%') OR (datosfiscales.domiciliocompleto LIKE '%".$condicion."%') OR (datosfiscales.formapago LIKE '%".$condicion."%') OR (datosfiscales.metodopago LIKE '%".$condicion."%') OR (datosfiscales.usocfdi LIKE '%".$condicion."%') OR (clientes.nombre LIKE '%".$condicion."%'))AND datosfiscales.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE datosfiscales.estatus ='eliminado'";
			}else{
				$consulta="WHERE datosfiscales.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from datosfiscales WHERE $campo = '$valor'");
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

	function guardar($idcliente,$domiciliocompleto,$formapago,$metodopago,$usocfdi,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['datosfiscales']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$iddatofiscal=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO datosfiscales (iddatofiscal, idcliente, domiciliocompleto, formapago, metodopago, usocfdi, estatus) VALUES ('$iddatofiscal','$idcliente','$domiciliocompleto','$formapago','$metodopago','$usocfdi','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla datosfiscales ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($idcliente,$domiciliocompleto,$formapago,$metodopago,$usocfdi,$estatus,$iddatofiscal){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['datosfiscales']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE datosfiscales SET idcliente='$idcliente', domiciliocompleto='$domiciliocompleto', formapago='$formapago', metodopago='$metodopago', usocfdi='$usocfdi', estatus='$estatus' WHERE iddatofiscal='$iddatofiscal'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $iddatofiscal, de la tabla datosfiscales ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($iddatofiscal){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['datosfiscales']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE datosfiscales SET estatus ='bloqueado' WHERE iddatofiscal = '$iddatofiscal'");
		}
	}
	
	function cambiarEstatus($iddatofiscal,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['datosfiscales']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE datosfiscales SET estatus ='$estatus' WHERE iddatofiscal = '$iddatofiscal'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla datosfiscales ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($iddatofiscal){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM datosfiscales WHERE iddatofiscal='$iddatofiscal'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					datosfiscales.iddatofiscal,
					datosfiscales.idcliente,
					datosfiscales.domiciliocompleto,
					datosfiscales.formapago,
					datosfiscales.metodopago,
					datosfiscales.usocfdi,
					datosfiscales.estatus
					FROM datosfiscales 
					INNER JOIN clientes ON datosfiscales.idcliente=clientes.idcliente
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['datosfiscales']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					datosfiscales.iddatofiscal,
					datosfiscales.idcliente,
					datosfiscales.domiciliocompleto,
					datosfiscales.formapago,
					datosfiscales.metodopago,
					datosfiscales.usocfdi,
					datosfiscales.estatus,
					clientes.nombre AS nombreclientes
					FROM datosfiscales 
					INNER JOIN clientes ON datosfiscales.idcliente=clientes.idcliente
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
			return mysqli_query($this->con->conect,"SELECT * FROM datosfiscales $condicion");
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
		$modulo="datosfiscales";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['datosfiscales']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE datosfiscales SET estatus ='eliminado' WHERE iddatofiscal IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla datosfiscales ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM datosfiscales WHERE iddatofiscal IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla datosfiscales ";
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