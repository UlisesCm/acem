<?php 
include_once("../../conexion/Conexion.class.php");

class Cliente{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((clientes.rfc LIKE '%".$condicion."%') OR (clientes.nombre LIKE '%".$condicion."%') OR (clientes.nic LIKE '%".$condicion."%'))AND clientes.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((clientes.rfc LIKE '%".$condicion."%') OR (clientes.nombre LIKE '%".$condicion."%') OR (clientes.nic LIKE '%".$condicion."%'))AND clientes.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE clientes.estatus ='eliminado'";
			}else{
				$consulta="WHERE clientes.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from clientes WHERE $campo = '$valor'");
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

	function guardar($rfc,$nombre,$nic,$limitecredito,$diascredito,$saldo,$nombrecontacto,$correocontacto,$telefonocontacto,$autorizardosis,$autorizarproductos,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['clientes']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idcliente=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "nuevo")){
				return "nombreExiste";
			}else if($this->comprobarCampo("nic",$nic, "nuevo")){
				return "nicExiste";
			}else{
				if(mysqli_query($this->con->conect,"INSERT INTO clientes (idcliente, rfc, nombre, nic, limitecredito, diascredito, saldo, nombrecontacto, correocontacto, telefonocontacto, autorizardosis, autorizarproductos, estatus) VALUES ('$idcliente','$rfc','$nombre','$nic','$limitecredito','$diascredito','$saldo','$nombrecontacto','$correocontacto','$telefonocontacto','$autorizardosis','$autorizarproductos','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla clientes ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizar($rfc,$nombre,$nic,$limitecredito,$diascredito,$saldo,$nombrecontacto,$correocontacto,$telefonocontacto,$autorizardosis,$autorizarproductos,$estatus,$idcliente){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['clientes']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "modificar")){
				return "nombreExiste";
			}else if($this->comprobarCampo("nic",$nic, "modificar")){
				return "nicExiste";
			}else{
				if(mysqli_query($this->con->conect,"UPDATE clientes SET rfc='$rfc', nombre='$nombre', nic='$nic', limitecredito='$limitecredito', diascredito='$diascredito', saldo='$saldo', nombrecontacto='$nombrecontacto', correocontacto='$correocontacto', telefonocontacto='$telefonocontacto', autorizardosis='$autorizardosis', autorizarproductos='$autorizarproductos', estatus='$estatus' WHERE idcliente='$idcliente'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idcliente, de la tabla clientes ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function bloquear($idcliente){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['clientes']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE clientes SET estatus ='bloqueado' WHERE idcliente = '$idcliente'");
		}
	}
	
	function cambiarEstatus($idcliente,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['clientes']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE clientes SET estatus ='$estatus' WHERE idcliente = '$idcliente'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla clientes ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idcliente){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM clientes WHERE idcliente='$idcliente'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					clientes.idcliente,
					clientes.rfc,
					clientes.nombre,
					clientes.nic,
					clientes.limitecredito,
					clientes.diascredito,
					clientes.saldo,
					clientes.nombrecontacto,
					clientes.correocontacto,
					clientes.telefonocontacto,
					clientes.autorizardosis,
					clientes.autorizarproductos,
					clientes.estatus
					FROM clientes 
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['clientes']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					clientes.idcliente,
					clientes.rfc,
					clientes.nombre,
					clientes.nic,
					clientes.limitecredito,
					clientes.diascredito,
					clientes.saldo,
					clientes.nombrecontacto,
					clientes.correocontacto,
					clientes.telefonocontacto,
					clientes.autorizardosis,
					clientes.autorizarproductos,
					clientes.estatus
					FROM clientes 
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
			return mysqli_query($this->con->conect,"SELECT * FROM clientes $condicion");
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
		$modulo="clientes";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['clientes']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE clientes SET estatus ='eliminado' WHERE idcliente IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla clientes ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM clientes WHERE idcliente IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla clientes ";
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