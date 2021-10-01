<?php 
include_once("../../conexion/Conexion.class.php");

class Modeloimpuestos{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((modelosimpuestos.idmodeloimpuestos LIKE '%".$condicion."%') OR (modelosimpuestos.nombre LIKE '%".$condicion."%'))AND modelosimpuestos.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((modelosimpuestos.idmodeloimpuestos LIKE '%".$condicion."%') OR (modelosimpuestos.nombre LIKE '%".$condicion."%'))AND modelosimpuestos.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE modelosimpuestos.estatus ='eliminado'";
			}else{
				$consulta="WHERE modelosimpuestos.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	
	function descomponerArreglo($elementosPorVuelta,$elementoSeleccionado, $arreglo){
		$totalElementos= count($arreglo);
		if ($totalElementos!=1){
			$con=0;
			$totalVueltas=$totalElementos/$elementosPorVuelta;
			while($con<$totalVueltas){
				$array[$con]= $arreglo[$elementoSeleccionado];
				$elementoSeleccionado=$elementoSeleccionado+$elementosPorVuelta;
				$con++;
			}
			return $array;
		}else{
			return $arreglo;
		}
	}
	
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from modelosimpuestos WHERE $campo = '$valor'");
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
	
	function guardarAsignacion($idmodeloimpuesto, $listaImpuestos){
		
		$arregloClave=$this->descomponerArreglo(5,0,$listaImpuestos);
		$arregloImpuesto=$this->descomponerArreglo(5,1,$listaImpuestos);
		$arregloTipo=$this->descomponerArreglo(5,2,$listaImpuestos);
		$arregloFactor=$this->descomponerArreglo(5,3,$listaImpuestos);
		$arregloValor=$this->descomponerArreglo(5,4,$listaImpuestos);
		
		$con=0;
		$validar=true;
		if($this->con->conectar()==true){
			while ($con < count($arregloClave)){
				$clave=$arregloClave[$con];
				$impuesto=$arregloImpuesto[$con];
				$tipo=$arregloTipo[$con];
				$factor=$arregloFactor[$con];
				$valor=$arregloValor[$con];
				
				$idimpuesto=$this->con->generarClave(2);
				
				if(!mysqli_query($this->con->conect,"INSERT INTO impuestos (idimpuesto, clavesat, nombre, tipo, factor, valor, idmodeloimpuesto) VALUES ('$idimpuesto','$clave','$impuesto','$tipo','$factor','$valor','$idmodeloimpuesto')")){
					$validar=false;
				}
				$con++;
			}
		}else{
			$validar=false;
		}
		return $validar;
	}

	function guardar($nombre,$fechaactualizacion,$estatus, $listaImpuestos){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['modelosimpuestos']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idmodeloimpuestos=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "nuevo")){
				return "nombreExiste";
			}else{
				if(mysqli_query($this->con->conect,"INSERT INTO modelosimpuestos (idmodeloimpuestos, nombre, fechaactualizacion, estatus) VALUES ('$idmodeloimpuestos','$nombre','$fechaactualizacion','$estatus')")){
					
					if ($this->guardarAsignacion($idmodeloimpuestos,$listaImpuestos)){
						$validar="exito";
					}else{
						$validar="fracaso";
					}
						
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla modelosimpuestos ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return $validar;
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizar($nombre,$fechaactualizacion,$estatus,$idmodeloimpuestos, $listaImpuestos){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['modelosimpuestos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "modificar")){
				return "nombreExiste";
			}else{
				if(mysqli_query($this->con->conect,"UPDATE modelosimpuestos SET nombre='$nombre', fechaactualizacion='$fechaactualizacion', estatus='$estatus' WHERE idmodeloimpuestos='$idmodeloimpuestos'")){
					
					if (mysqli_query($this->con->conect,"DELETE FROM impuestos WHERE idmodeloimpuesto='$idmodeloimpuestos'")) {
						if ($this->guardarAsignacion($idmodeloimpuestos,$listaImpuestos)){
							$validar="exito";
						}else{
							$validar="fracaso";
						}
					}else{
						$validar="fracaso";
					}
					
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idmodeloimpuestos, de la tabla modelosimpuestos ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return $validar;
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function bloquear($idmodeloimpuestos){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['modelosimpuestos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE modelosimpuestos SET estatus ='bloqueado' WHERE idmodeloimpuestos = '$idmodeloimpuestos'");
		}
	}
	
	function cambiarEstatus($idmodeloimpuestos,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['modelosimpuestos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE modelosimpuestos SET estatus ='$estatus' WHERE idmodeloimpuestos = '$idmodeloimpuestos'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla modelosimpuestos ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idmodeloimpuestos){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM modelosimpuestos WHERE idmodeloimpuestos='$idmodeloimpuestos'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					modelosimpuestos.idmodeloimpuestos,
					modelosimpuestos.nombre,
					modelosimpuestos.fechaactualizacion,
					modelosimpuestos.estatus
					FROM modelosimpuestos 
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['modelosimpuestos']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					modelosimpuestos.idmodeloimpuestos,
					modelosimpuestos.nombre,
					modelosimpuestos.fechaactualizacion,
					modelosimpuestos.estatus
					FROM modelosimpuestos 
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
			return mysqli_query($this->con->conect,"SELECT * FROM modelosimpuestos $condicion");
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
		$modulo="modelosimpuestos";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['modelosimpuestos']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE modelosimpuestos SET estatus ='eliminado' WHERE idmodeloimpuestos IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla modelosimpuestos ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM modelosimpuestos WHERE idmodeloimpuestos IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla modelosimpuestos ";
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