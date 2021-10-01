<?php 
include_once("../../conexion/Conexion.class.php");

class Domicilio extends Conexion{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((domicilios.tipovialidad LIKE '%".$condicion."%') OR (domicilios.calle LIKE '%".$condicion."%') OR (domicilios.nombrecomercial LIKE '%".$condicion."%') OR (domicilios.colonia LIKE '%".$condicion."%') OR (domicilios.cp LIKE '%".$condicion."%') OR (domicilios.ciudad LIKE '%".$condicion."%') OR (domicilios.estado LIKE '%".$condicion."%') OR (domicilios.idcliente LIKE '%".$condicion."%') OR (domicilios.idzona LIKE '%".$condicion."%') OR (domicilios.idsucursal LIKE '%".$condicion."%') OR (domicilios.idempleado LIKE '%".$condicion."%'))AND domicilios.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((domicilios.tipovialidad LIKE '%".$condicion."%') OR (domicilios.calle LIKE '%".$condicion."%') OR (domicilios.nombrecomercial LIKE '%".$condicion."%') OR (domicilios.colonia LIKE '%".$condicion."%') OR (domicilios.cp LIKE '%".$condicion."%') OR (domicilios.ciudad LIKE '%".$condicion."%') OR (domicilios.estado LIKE '%".$condicion."%') OR (domicilios.idcliente LIKE '%".$condicion."%') OR (domicilios.idzona LIKE '%".$condicion."%') OR (domicilios.idsucursal LIKE '%".$condicion."%') OR (domicilios.idempleado LIKE '%".$condicion."%'))AND domicilios.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE domicilios.estatus ='eliminado'";
			}else{
				$consulta="WHERE domicilios.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from domicilios WHERE $campo = '$valor'");
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
	
	function guardarAsignacion($iddomicilio, $lista){
		if($this->con->conectar()==true){
			$con=0;
			mysqli_query($this->con->conect,"DELETE FROM domicilioscontactos WHERE iddomicilio = '$iddomicilio'");
			foreach($lista as $idcontacto){
				$iddomiciliocontacto=$this->con->generarClave(1).$con; /*Sincronizacion 1 */
				mysqli_query($this->con->conect,"INSERT INTO domicilioscontactos(iddomiciliocontacto,iddomicilio,idcontacto) VALUES ('$iddomiciliocontacto','$iddomicilio','$idcontacto')");
				$con++;
			}
			return true;
		}else{
			return false;
		}
	}

	function guardar($idcliente,$tipovialidad,$calle,$noexterior,$nointerior,$nombrecomercial,$colonia,$cp,$ciudad,$estado,$idzona,$coordenadas,$referencia,$observaciones,$idsucursal,$idgirocomercial,$validardosis,$idempleado,$contactos,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['domicilios']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$iddomicilio=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO domicilios (iddomicilio, idcliente, tipovialidad, calle, noexterior, nointerior, nombrecomercial, colonia, cp, ciudad, estado, idzona, coordenadas, referencia, observaciones, idsucursal, idgirocomercial, validardosis, idempleado, estatus) VALUES ('$iddomicilio','$idcliente','$tipovialidad','$calle','$noexterior','$nointerior','$nombrecomercial','$colonia','$cp','$ciudad','$estado','$idzona','$coordenadas','$referencia','$observaciones','$idsucursal','$idgirocomercial','$validardosis','$idempleado','$estatus')")){
					$this->guardarAsignacion($iddomicilio,$contactos);
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla domicilios ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($idcliente,$tipovialidad,$calle,$noexterior,$nointerior,$nombrecomercial,$colonia,$cp,$ciudad,$estado,$idzona,$coordenadas,$referencia,$observaciones,$idsucursal,$idgirocomercial,$validardosis,$idempleado,$contactos,$estatus,$iddomicilio){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['domicilios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE domicilios SET idcliente='$idcliente', tipovialidad='$tipovialidad', calle='$calle', noexterior='$noexterior', nointerior='$nointerior', nombrecomercial='$nombrecomercial', colonia='$colonia', cp='$cp', ciudad='$ciudad', estado='$estado', idzona='$idzona', coordenadas='$coordenadas', referencia='$referencia', observaciones='$observaciones', idsucursal='$idsucursal', idgirocomercial='$idgirocomercial', validardosis='$validardosis', idempleado='$idempleado', estatus='$estatus' WHERE iddomicilio='$iddomicilio'")){
					$this->guardarAsignacion($iddomicilio,$contactos);
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $iddomicilio, de la tabla domicilios ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($iddomicilio){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['domicilios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE domicilios SET estatus ='bloqueado' WHERE iddomicilio = '$iddomicilio'");
		}
	}
	
	function cambiarEstatus($iddomicilio,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['domicilios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE domicilios SET estatus ='$estatus' WHERE iddomicilio = '$iddomicilio'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla domicilios ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($iddomicilio){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM domicilios WHERE iddomicilio='$iddomicilio'");
		}
	}
	
	function comprobarDomicilioContacto($iddomicilio,$idcontacto){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT(*) AS contador FROM domicilioscontactos WHERE iddomicilio='$iddomicilio' AND  idcontacto	='$idcontacto'");
			$extractor = mysqli_fetch_array($resultado);
			$numero_filas=$extractor['contador'];
			/* if ($numero_filas=="0"){
				if ($iddomicilio==0){
				// return "checked=\"checked\"";
			}else{
				return "";
			}
			}else{
				// return "checked=\"checked\"";
			} */
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					domicilios.iddomicilio,
					domicilios.idcliente,
					domicilios.tipovialidad,
					domicilios.calle,
					domicilios.noexterior,
					domicilios.nointerior,
					domicilios.nombrecomercial,
					domicilios.colonia,
					domicilios.cp,
					domicilios.ciudad,
					domicilios.estado,
					domicilios.idzona,
					domicilios.coordenadas,
					domicilios.referencia,
					domicilios.observaciones,
					domicilios.idsucursal,
					domicilios.idgirocomercial,
					domicilios.validardosis,
					domicilios.idempleado,
					domicilios.estatus,
					clientes.nombre AS nombreclientes,
					zonas.nombre AS nombrezonas,
					empleados.nombre AS nombreempleados,
					sucursales.nombre AS nombresucursales,
					giroscomerciales.nombre AS nombregiroscomerciales
					FROM domicilios 
					INNER JOIN clientes ON domicilios.idcliente=clientes.idcliente
					INNER JOIN zonas ON domicilios.idzona=zonas.idzona
					INNER JOIN empleados ON domicilios.idempleado=empleados.idempleado
					INNER JOIN sucursales ON domicilios.idsucursal=sucursales.idsucursal
					INNER JOIN giroscomerciales ON domicilios.idgirocomercial=giroscomerciales.idgirocomercial
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['domicilios']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					domicilios.iddomicilio,
					domicilios.idcliente,
					domicilios.tipovialidad,
					domicilios.calle,
					domicilios.noexterior,
					domicilios.nointerior,
					domicilios.nombrecomercial,
					domicilios.colonia,
					domicilios.cp,
					domicilios.ciudad,
					domicilios.estado,
					domicilios.idzona,
					domicilios.coordenadas,
					domicilios.referencia,
					domicilios.observaciones,
					domicilios.idsucursal,
					domicilios.idgirocomercial,
					domicilios.validardosis,
					domicilios.idempleado,
					domicilios.estatus,
					clientes.nombre AS nombreclientes,
					zonas.nombre AS nombrezonas,
					empleados.nombre AS nombreempleados,
					sucursales.nombre AS nombresucursales,
					giroscomerciales.nombre AS nombregiroscomerciales
					FROM domicilios 
					INNER JOIN clientes ON domicilios.idcliente=clientes.idcliente
					INNER JOIN zonas ON domicilios.idzona=zonas.idzona
					INNER JOIN empleados ON domicilios.idempleado=empleados.idempleado
					INNER JOIN sucursales ON domicilios.idsucursal=sucursales.idsucursal
					INNER JOIN giroscomerciales ON domicilios.idgirocomercial=giroscomerciales.idgirocomercial
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
			return mysqli_query($this->con->conect,"SELECT * FROM domicilios $condicion");
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
		$modulo="domicilios";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['domicilios']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE domicilios SET estatus ='eliminado' WHERE iddomicilio IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla domicilios ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM domicilios WHERE iddomicilio IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla domicilios ";
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