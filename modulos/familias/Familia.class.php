<?php 
include_once("../../conexion/Conexion.class.php");
global $arrayFamilia;
$arrayFamilia=array();
class Familia{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((familias.nombre LIKE '%".$condicion."%') OR (familias.nombredescripcion LIKE '%".$condicion."%') OR (familias.prefijocodigo LIKE '%".$condicion."%'))AND familias.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((familias.nombre LIKE '%".$condicion."%') OR (familias.nombredescripcion LIKE '%".$condicion."%') OR (familias.prefijocodigo LIKE '%".$condicion."%'))AND familias.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE familias.estatus ='eliminado'";
			}else{
				$consulta="WHERE familias.estatus <>'eliminado'";
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
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from familias WHERE $campo = '$valor'");
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

	function guardar($nombre,$mostrarendescripcion,$nombredescripcion,$prefijocodigo,$camposrequeridos,$idfamiliamadre,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['familias']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idfamilia=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO familias (idfamilia, nombre, mostrarendescripcion, nombredescripcion, prefijocodigo, camposrequeridos, idfamiliamadre, estatus) VALUES ('$idfamilia','$nombre','$mostrarendescripcion','$nombredescripcion','$prefijocodigo','$camposrequeridos','$idfamiliamadre','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla familias ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
		}
	}
	
	function actualizar($nombre,$mostrarendescripcion,$nombredescripcion,$prefijocodigo,$camposrequeridos,$idfamiliamadre,$estatus,$idfamilia){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['familias']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$validar = "fracaso";
		if ($idfamilia==$idfamiliamadre){
			return "fracasoFamilias";
		}
		
		if($this->con->conectar()==true){
			
			$this->con->conect->autocommit(false); //INICO DE TRANSACCION
			
			if(mysqli_query($this->con->conect,"UPDATE familias SET nombre='$nombre', mostrarendescripcion='$mostrarendescripcion', nombredescripcion='$nombredescripcion', prefijocodigo='$prefijocodigo', camposrequeridos='$camposrequeridos', idfamiliamadre='$idfamiliamadre', estatus='$estatus' WHERE idfamilia='$idfamilia'")){
				if ($this->recorrerFamiliasHijas($idfamiliamadre,$this->con->conect)=="exito"){
					$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
					$validar="exito";
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idfamilia, de la tabla familias ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
				}else{
					$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASO
				}
				
				return $validar;
			}else{
				return $validar;
			}
			
		}
	}
	
	function actualizarProductos($idfamilia, $prenombre, $campos, $conexion){
		$lista= substr($campos, 0, -3);
		$lista=explode(":::",$lista);
		$arregloCampo=$this->descomponerArreglo(3,0,$lista);
		$arregloOrden=$this->descomponerArreglo(3,1,$lista);
		
		$resultado=mysqli_query($conexion,"SELECT * FROM productos WHERE idfamilia='$idfamilia'");
		if($resultado){ //Si se obtienen los productos
			while ($filas=mysqli_fetch_array($resultado)) { //Recorrer todos los productos de la familia afectada
				$idproducto=$filas["idproducto"];
				$caracteristicas="";
				$con=0;
				while ($con < count($arregloCampo)){
					$campo=$arregloCampo[$con];
					$orden=$arregloOrden[$con];
					if ($orden!="" or $orden!=NULL){
						$caracteristicas=$caracteristicas." ".$filas[$arregloCampo[$con]];
					}
					$con++;
				}// Fin de While campos
				$nombreProducto=$prenombre." ".$caracteristicas;
				$resultado2=mysqli_query($conexion,"UPDATE productos SET nombre='$nombreProducto' WHERE idproducto='$idproducto'");
				if (!$resultado2){
					return "error";
				}
			}// Fin de While Mysqli
		}else{//Si no se obtiene la consulta de prodcutos
			return "error";
		}
		return "exito";
	}
	
	function obtenerPrenombre($idfamilia, $prefijoclave, $conexion){
			$arrayNombres=array();
			$prenombre="";
			$resultado=mysqli_query($conexion,"SELECT * FROM familias WHERE idfamilia='$idfamilia'");
			if ($resultado){ // Si se obtienen las familias
				while ($filas=mysqli_fetch_array($resultado)) { //Recorrer todos los productos de la familia afectada
					$idfamilia=$filas["idfamilia"];
					$mostrarendescripcion=$filas["mostrarendescripcion"];
					$nombredescripcion=$filas["nombredescripcion"];
					$prefijocodigo=$filas["prefijocodigo"];
					$idfamiliamadre=$filas["idfamiliamadre"];
	
					if ($idfamiliamadre==-1){
						$arrayNombres = array_reverse($arrayNombres);
						foreach ($arrayNombres as &$nombre) {
							$prenombre =$prenombre." ".$nombre;
						}
						return $prenombre;
					}else{
						$resultado=mysqli_query($conexion,"SELECT * FROM familias WHERE idfamilia='$idfamiliamadre'");
						if (!$resultado){ //Si no se obtienen nuevamente las familias
							return "error";
						}
					}
					
					if ($mostrarendescripcion=="si"){
						array_push($arrayNombres,$nombredescripcion);
						//$prenombre=$prenombre." ".$nombredescripcion;
						//$prefijoclave=$prefijoclave." ".$prefijocodigo;
					}
				}
			}else{ //Si no se obtienen las familias
				return "error";
			}
	}
	
	function recorrerFamiliasHijas($idfamilia, $conexion){
		global $arrayFamilia;
		$Ofamilia = new Familia;
		$resultado2=mysqli_query($conexion,"SELECT * FROM familias WHERE idfamiliamadre='$idfamilia'");
		if($resultado2){ //Si se obtienen las familias
			while ($filas2=mysqli_fetch_array($resultado2)) { 
				$nombre=$filas2['nombre']; 
				$idfamilia=$filas2['idfamilia'];
				$camposrequeridos=$filas2['camposrequeridos'];
				
				if (!in_array($idfamilia, $arrayFamilia)) {
					$prenombre=$this->obtenerPrenombre($idfamilia,"",$conexion);
					if ($prenombre!="error"){ //Si se obtiene un prenombre válido actualiza el producto
						$resultado3=$this->actualizarProductos($idfamilia,$prenombre,$camposrequeridos,$conexion);
						if ($resultado3!="error"){
							$this->recorrerFamiliasHijas($idfamilia, $conexion);
						}else{ //Si no se actualizaron los productos correctamente
							return "error";
						}
					}else{ //Si no se obtuvo un prenombre válido
						return "error";
					}
				}
				array_push($arrayFamilia,$idfamilia);
			}
		}else{//Si no se obtienen las familias
			return "error";
		}
		return "exito";
	}
	
	
	
	function bloquear($idfamilia){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['familias']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE familias SET estatus ='bloqueado' WHERE idfamilia = '$idfamilia'");
		}
	}
	
	function cambiarEstatus($idfamilia,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['familias']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE familias SET estatus ='$estatus' WHERE idfamilia = '$idfamilia'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla familias ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function obtenerCampo($campo,$valor){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT $campo FROM familias WHERE idfamilia='$valor' ");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor[$campo];
				return $valorCampo;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function mostrarIndividual($idfamilia){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM familias WHERE idfamilia='$idfamilia'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					familias.idfamilia,
					familias.nombre,
					familias.mostrarendescripcion,
					familias.nombredescripcion,
					familias.prefijocodigo,
					familias.camposrequeridos,
					familias.idfamiliamadre,
					familias.estatus
					FROM familias 
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['familias']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					familias.idfamilia,
					familias.nombre,
					familias.mostrarendescripcion,
					familias.nombredescripcion,
					familias.prefijocodigo,
					familias.camposrequeridos,
					familias.idfamiliamadre,
					familias.estatus
					FROM familias
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
			return mysqli_query($this->con->conect,"SELECT * FROM familias $condicion");
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
		$modulo="familias";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		$tipoEliminacion="real";
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['familias']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE familias SET estatus ='eliminado' WHERE idfamilia IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla familias ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM familias WHERE idfamilia IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla familias ";
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