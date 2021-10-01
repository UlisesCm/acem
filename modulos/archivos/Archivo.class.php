<?php 
include_once("../../conexion/Conexion.class.php");

class Archivo{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			$consulta="WHERE ((archivos.pdf LIKE '%".$condicion."%') OR (archivos.xml LIKE '%".$condicion."%') OR (archivos.folio LIKE '%".$condicion."%') OR (archivos.emisor LIKE '%".$condicion."%') OR (archivos.receptor LIKE '%".$condicion."%') OR (archivos.rfcemisor LIKE '%".$condicion."%') OR (archivos.rfcreceptor LIKE '%".$condicion."%') OR (archivos.uuid LIKE '%".$condicion."%'))AND archivos.idarchivo <>'0'";
		}else{
			$consulta="WHERE archivos.idarchivo <>'0'";
		}
		return $consulta;
	}function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from archivos WHERE $campo = '$valor'");
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

	function guardar($pdf,$xml,$fechamodificacion,$tablareferencia,$idreferencia,$serie="",$folio="",$tipo="",$fechatimbre="",$emisor="",$rfcemisor="",$receptor="",$rfcreceptor="",$monto="",$subtotal="",$uuid=""){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['archivos']['guardar'])){
			return "denegado@0";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idarchivo=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO archivos (idarchivo, pdf, xml, fechamodificacion, tablareferencia, idreferencia, serie, folio, tipo, fechatimbre, emisor, rfcemisor, receptor, rfcreceptor, monto, subtotal, uuid) VALUES ('$idarchivo','$pdf','$xml','$fechamodificacion','$tablareferencia','$idreferencia','$serie','$folio','$tipo','$fechatimbre','$emisor','$rfcemisor','$receptor','$rfcreceptor','$monto','$subtotal','$uuid')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla archivos ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito@$idarchivo";
				}else{
					return "fracaso@0";
				}
			
		}
	}
	
	function actualizarDatos($serie,$folio,$tipo,$fechatimbre,$emisor,$rfcemisor,$receptor,$rfcreceptor,$monto,$subtotal,$uuid,$idarchivo){
		if($this->con->conectar()==true){
			if(mysqli_query($this->con->conect,"UPDATE archivos SET serie='$serie', folio='$folio', tipo='$tipo', fechatimbre='$fechatimbre', emisor='$emisor', rfcemisor='$rfcemisor', receptor='$receptor', rfcreceptor='$rfcreceptor', monto='$monto', subtotal='$subtotal', uuid='$uuid' WHERE idarchivo='$idarchivo'")){
				return "exito";
			}else{
				return "fracaso";
			}
		}else{
			return "fracaso";
		}
	}
	
	
	function actualizar($pdf,$xml,$fechamodificacion,$tablareferencia,$idreferencia,$serie,$folio,$tipo,$fechatimbre,$emisor,$rfcemisor,$receptor,$rfcreceptor,$monto,$uuid,$idarchivo){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['archivos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE archivos SET pdf='$pdf', xml='$xml', fechamodificacion='$fechamodificacion', tablareferencia='$tablareferencia', idreferencia='$idreferencia', serie='$serie', folio='$folio', tipo='$tipo', fechatimbre='$fechatimbre', emisor='$emisor', rfcemisor='$rfcemisor', receptor='$receptor', rfcreceptor='$rfcreceptor', monto='$monto', uuid='$uuid' WHERE idarchivo='$idarchivo'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idarchivo, de la tabla archivos ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idarchivo){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['archivos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE archivos SET estatus ='bloqueado' WHERE idarchivo = '$idarchivo'");
		}
	}
	
	function cambiarEstatus($idarchivo,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['archivos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE archivos SET estatus ='$estatus' WHERE idarchivo = '$idarchivo'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla archivos ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idarchivo){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM archivos WHERE idarchivo='$idarchivo'");
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['archivos']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					
					archivos.idarchivo,
					archivos.pdf,
					archivos.xml,
					archivos.fechamodificacion,
					archivos.tablareferencia,
					archivos.idreferencia,
					archivos.serie,
					archivos.folio,
					archivos.tipo,
					archivos.fechatimbre,
					archivos.emisor,
					archivos.rfcemisor,
					archivos.receptor,
					archivos.rfcreceptor,
					archivos.monto,
					archivos.uuid
					FROM archivos 
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
			return mysqli_query($this->con->conect,"SELECT * FROM archivos $condicion");
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
		$modulo="archivos";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['archivos']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE archivos SET estatus ='eliminado' WHERE idarchivo IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla archivos ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM archivos WHERE idarchivo IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla archivos ";
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