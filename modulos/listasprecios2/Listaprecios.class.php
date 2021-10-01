<?php 
include_once("../../conexion/Conexion.class.php");
global $arrayFamilia;
$arrayFamilia=array();
class Listaprecios{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((listasprecios.idlistaprecios LIKE '%".$condicion."%') OR (listasprecios.nombre LIKE '%".$condicion."%'))AND listasprecios.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((listasprecios.idlistaprecios LIKE '%".$condicion."%') OR (listasprecios.nombre LIKE '%".$condicion."%'))AND listasprecios.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE listasprecios.estatus ='eliminado'";
			}else{
				$consulta="WHERE listasprecios.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from listasprecios WHERE $campo = '$valor'");
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

	function guardar($nombre,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['listasprecios']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idlistaprecios=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "nuevo")){
				return "nombreExiste";
			}else{
				if(mysqli_query($this->con->conect,"INSERT INTO listasprecios (idlistaprecios, nombre, estatus) VALUES ('$idlistaprecios','$nombre','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla listasprecios ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizar($nombre,$estatus,$idlistaprecios){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['listasprecios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "modificar")){
				return "nombreExiste";
			}else{
				if(mysqli_query($this->con->conect,"UPDATE listasprecios SET nombre='$nombre', estatus='$estatus' WHERE idlistaprecios='$idlistaprecios'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idlistaprecios, de la tabla listasprecios ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizarDato($campo,$valor,$idprecio){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['listasprecios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if(mysqli_query($this->con->conect,"UPDATE precios SET $campo='$valor' WHERE idprecio='$idprecio'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="modific&oacute; el registro ID: $idlistaprecios, de la tabla listasprecios ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
			
		}
	}
	
	
	
	function comprobarSincronizacion($idreferencia, $idlistaprecios){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT(*) AS contador from precios WHERE idreferencia = '$idreferencia' AND idlistaprecios='$idlistaprecios'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$numero_filas=$extractor["contador"];
					if ($numero_filas=="0"){
						return false;
					}else{
						return true;
					}
			}else{
				return false;
			}
		}
	}
	
	
	function obtenerFamiliasHijas($idfamilia, $conexion){
		global $arrayFamilia;
		$resultado2=mysqli_query($conexion,"SELECT * FROM familias WHERE idfamiliamadre='$idfamilia'");
		if($resultado2){ //Si se obtienen las familias
			while ($filas2=mysqli_fetch_array($resultado2)) { 
				$idfamilia=$filas2['idfamilia'];
				
				if (!in_array($idfamilia, $arrayFamilia)) {
					$this->obtenerFamiliasHijas($idfamilia, $conexion);
				}
				array_push($arrayFamilia,$idfamilia);
			}
		}else{//Si no se obtienen las familias
			return "error";
		}
		
		return "exito";
	}
	
	
	function actualizarPrecios($idfamilia,$porcentaje, $idlista){
		global $arrayFamilia;
		$cadena="";
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['listasprecios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		if (is_numeric ($porcentaje)){
			if($this->con->conectar()==true){
				
				$this->con->conect->autocommit(false); //INICO DE TRANSACCION
				
				$idsfamilias=$this->obtenerFamiliasHijas($idfamilia,$this->con->conect);
				if ($idsfamilias!="error"){
					
					
					foreach ($arrayFamilia as &$valor) {
						$cadena = $cadena.$valor.",";
					}
					$cadena=$idfamilia.",".$cadena;
					$cadena = substr($cadena, 0, -1);
					
					$porciento=($porcentaje/100)+1;
					
					$resultado=mysqli_query($this->con->conect,"UPDATE precios
																INNER JOIN productos ON productos.idproducto=precios.idreferencia
																SET precios.precio=precios.costo*$porciento,
																precios.porcentajeutilidad='$porcentaje'
																WHERE precios.idlistaprecios='$idlista' AND productos.idfamilia IN ($cadena)");
					if($resultado){
						$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
						echo "Los precios de los productos han sido actualizados";
					}else{
						$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
						echo "No se pudo ejecutar la instruccion de actualziacion, elija una familia";
					}
				}else{
					echo "Ha ocurrido un error al obtener las familias hijas";
				}
			}else{
				return "No se pudo conectar con la base de datos";
			}
		}else{
			echo "El porcentaje no es correcto. Ingrese solo numeros";
		}
	}
	
	function sincronizar($idlistaprecios){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['listasprecios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT
			productos.idproducto,
			productos.costo,
			productos.nombre
			FROM productos
			WHERE productos.estatus <> 'eliminado' ");
			while ($filas=mysqli_fetch_array($resultado)) { 
				$idreferencia=$filas['idproducto'];
				$costo=$filas['costo'];
				$nombre=$filas['nombre'];
				mysqli_query($this->con->conect,"UPDATE precios SET descripcion='$nombre', costo='$costo' WHERE idlistaprecios='$idlistaprecios' AND idreferencia='$idreferencia'");
				if($this->comprobarSincronizacion($idreferencia,$idlistaprecios)==false){
					//echo $descripcion;
					mysqli_query($this->con->conect,"INSERT INTO precios (idlistaprecios, idreferencia, descripcion,costo,porcentajeutilidad,porcentajedescuento, precio) VALUES ('$idlistaprecios','$idreferencia','$nombre','$costo','0','0','0')");
				}
			}
			return "exito";
		}else{
			return "fracaso";
		}
	}
	
	function bloquear($idlistaprecios){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['listasprecios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE listasprecios SET estatus ='bloqueado' WHERE idlistaprecios = '$idlistaprecios'");
		}
	}
	
	function cambiarEstatus($idlistaprecios,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['listasprecios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE listasprecios SET estatus ='$estatus' WHERE idlistaprecios = '$idlistaprecios'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla listasprecios ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idlistaprecios){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM listasprecios WHERE idlistaprecios='$idlistaprecios'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					listasprecios.idlistaprecios,
					listasprecios.nombre,
					listasprecios.estatus
					FROM listasprecios 
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['listasprecios']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					listasprecios.idlistaprecios,
					listasprecios.nombre,
					listasprecios.estatus
					FROM listasprecios 
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	
	
	
	
	
	
	function mostrarPrecios($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $idlistaprecios, $exportar=false){
		
		$condicion= trim($condicion);
		if ($condicion!=""){
			$where="WHERE ((precios.descripcion LIKE '%".$condicion."%')) AND precios.idprecio <>'0' AND idlistaprecios='$idlistaprecios'";
		}else{
			$where="WHERE precios.idprecio <>'0' AND idlistaprecios='$idlistaprecios'";
		}
		if ($exportar==false){
			$limit="LIMIT $inicial, $cantidadamostrar";
			
		}else{
			$limit="";
		}
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					precios.idprecio,
					precios.idlistaprecios,
					precios.idreferencia,
					precios.descripcion,
					precios.costo,
					precios.porcentajeutilidad,
					precios.porcentajedescuento,
					precios.precio,
					productos.nombre AS nombreproducto,
					productos.costo AS costoproducto
					FROM precios 
					INNER JOIN productos ON productos.idproducto=precios.idreferencia
					$where
					ORDER BY $campoOrden $orden
					$limit
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
			return mysqli_query($this->con->conect,"SELECT * FROM listasprecios $condicion");
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
		$modulo="listasprecios";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['listasprecios']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE listasprecios SET estatus ='eliminado' WHERE idlistaprecios IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla listasprecios ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM listasprecios WHERE idlistaprecios IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla listasprecios ";
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