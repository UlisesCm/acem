<?php 
include_once("../../conexion/Conexion.class.php");
global $arrayFamilia;
$arrayFamilia=array();

class Producto{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE (productos.nombre LIKE '%".$condicion."%') AND productos.estatus ='eliminado'";
			}else{
				$consulta="WHERE (productos.nombre LIKE '%".$condicion."%') AND productos.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE productos.estatus ='eliminado'";
			}else{
				$consulta="WHERE productos.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from productos WHERE $campo = '$valor'");
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

	function guardarAsignacion($idproducto, $lista, $claves){
			if($this->con->conectar()==true){
				$con=0;
				mysqli_query($this->con->conect,"DELETE FROM productosproveedores WHERE idproducto = '$idproducto'");
				foreach($lista as $idproveedor){
					$clave=$claves[$con];
					$idproductoproveedor=$this->con->generarClave(1).$con; /*Sincronizacion 1 */
					mysqli_query($this->con->conect,"INSERT INTO productosproveedores(idproductoproveedor, idproducto, idproveedor, clave) VALUES ('$idproductoproveedor','$idproducto','$idproveedor', '$clave')");
					$con++;
				}
				return true;
			}else{
				return false;
			}
	}
	
	function guardar($idfamilia,$nombre,$codigo,$autoclasificar,$clasificacion,$idmodeloimpuestos,$idcategoria,$idunidad,$marca,$pesoteorico,$espesor,$ancho,$color,$diametro,$tipo,$modelo,$modelo2,$lado,$alto,$largo,$aplicacion,$clave,$descripcion,$variacionpermitidaencosto,$proveedores,$claves,$costo,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['productos']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idproducto=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "nuevo")){
				return "nombreExiste";
			}else{
				if(mysqli_query($this->con->conect,"INSERT INTO productos (idproducto, idfamilia, nombre, codigo, autoclasificar, clasificacion, idmodeloimpuestos, idcategoria, idunidad, marca, pesoteorico, espesor, ancho, color, diametro, tipo, modelo, modelo2, lado,alto, largo, aplicacion, clave, descripcion, variacionpermitidaencosto, costo, estatus, pesoreal) VALUES ('$idproducto','$idfamilia','$nombre','$codigo','$autoclasificar','$clasificacion','$idmodeloimpuestos','$idcategoria','$idunidad','$marca','$pesoteorico','$espesor','$ancho','$color','$diametro','$tipo','$modelo','$modelo2','$lado','$alto','$largo','$aplicacion','$clave','$descripcion','$variacionpermitidaencosto','$costo','$estatus','0')")){
					$this->guardarAsignacion($idproducto,$proveedores, $claves);
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla productos ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizar($idfamilia,$nombre,$codigo,$autoclasificar,$clasificacion,$idmodeloimpuestos,$idcategoria,$idunidad,$marca,$pesoteorico,$espesor,$ancho,$color,$diametro,$tipo,$modelo,$modelo2,$lado,$alto,$largo,$aplicacion,$clave,$descripcion,$variacionpermitidaencosto,$proveedores,$claves,$costo,$estatus,$idproducto){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['productos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "modificar")){
				return "nombreExiste";
			}else{
				if(mysqli_query($this->con->conect,"UPDATE productos SET idfamilia='$idfamilia', nombre='$nombre', codigo='$codigo', autoclasificar='$autoclasificar', clasificacion='$clasificacion', idmodeloimpuestos='$idmodeloimpuestos', idcategoria='$idcategoria', idunidad='$idunidad', marca='$marca', pesoteorico='$pesoteorico', espesor='$espesor', ancho='$ancho', color='$color', diametro='$diametro', tipo='$tipo', modelo='$modelo', modelo2='$modelo2', lado='$lado', alto='$alto',  largo='$largo', aplicacion='$aplicacion', clave='$clave', descripcion='$descripcion', variacionpermitidaencosto='$variacionpermitidaencosto', costo='$costo', estatus='$estatus' WHERE idproducto='$idproducto'")){
					$this->guardarAsignacion($idproducto,$proveedores, $claves);
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idproducto, de la tabla productos ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizarStock($periodoinicio,$periodofin,$stockminimo,$stockmaximo,$idreferencia,$tablareferencia,$idproducto,$idstock){
		if($this->con->conectar()==true){
			$consulta = "SELECT * FROM stocks WHERE idstock='$idstock'";
			$resultado=mysqli_query($this->con->conect,$consulta);
			if(mysqli_num_rows($resultado)>0){
				if(mysqli_query($this->con->conect,"UPDATE stocks SET periodoinicio='$periodoinicio', periodofin='$periodofin', stockminimo='$stockminimo', stockmaximo='$stockmaximo'  WHERE idstock='$idstock'")){
					return "exito@$idstock";
				}else{
					return "fracaso@$idstock";
				}
			}else{
				$idstock=$this->con->generarClave(2); /*Sincronizacion 1 */
				if(mysqli_query($this->con->conect,"INSERT INTO stocks (idstock,idproducto,periodoinicio,periodofin,stockminimo,stockmaximo,idreferencia,tablareferencia) VALUES ('$idstock','$idproducto','$periodoinicio','$periodofin','$stockminimo','$stockmaximo','$idreferencia','$tablareferencia')")){
					return "exito@$idstock";
				}else{
					return "fracaso@$idstock";
				}
			}
		}
	}
	
	function bloquear($idproducto){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['productos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE productos SET estatus ='bloqueado' WHERE idproducto = '$idproducto'");
		}
	}
	
	function cambiarEstatus($idproducto,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['productos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE productos SET estatus ='$estatus' WHERE idproducto = '$idproducto'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla productos ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function obtenerExistencias($idproducto){
		$idsucursal=$_SESSION['idsucursal'];
		$existencia=0;
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT existencia FROM inventario$idsucursal WHERE idproducto = '$idproducto'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$existencia=$extractor["existencia"];
				return $existencia;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	
	function comprobarProveedor($idproducto,$idproveedor){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT
			productosproveedores.idproductoproveedor,
			proveedores.nombre
			FROM productosproveedores
			INNER JOIN proveedores ON proveedores.idproveedor=productosproveedores.idproveedor
			WHERE productosproveedores.idproducto = '$idproducto' AND productosproveedores.idproveedor='$idproveedor'");
			if ($resultado){
				if(mysqli_num_rows($resultado)!=0){
					$extractor = mysqli_fetch_array($resultado);
					$nombreproveedor=$extractor["nombre"];
					
					return array($idproveedor,$nombreproveedor);
				}else{
					return array(0,"NO IDENTIFICADO");
				}
			}else{
				return array(0,"NO IDENTIFICADO");
			}
		}else{
			return array(0,"NO IDENTIFICADO");
		}
	}
	
	function calcularStocks($idproducto){
		$idsucursal=$_SESSION['idsucursal'];
		$existencia=0;
		if($this->con->conectar()==true){
			
			
			$fecha_actual = date("Y-m-d");
			$mesAnterior =date("Y-m-d",strtotime($fecha_actual."- 1 month"));
			$fechaAnteriorA =date("Y-m-d",strtotime($fecha_actual."- 12 month"));
			$fechaAnteriorB= date("Y-m-d",strtotime($fecha_actual."- 10 month"));
			
			$cadenaA="SELECT
			SUM(detallecotizacionesproductos$idsucursal.cantidad) AS cantidadTotal
			FROM detallecotizacionesproductos$idsucursal
			INNER JOIN cotizacionesproductos$idsucursal ON cotizacionesproductos$idsucursal.idcotizacionproducto = detallecotizacionesproductos$idsucursal.idcotizacionproducto
			WHERE
			cotizacionesproductos$idsucursal.fecha >= '$mesAnterior' AND
			cotizacionesproductos$idsucursal.fecha <= '$fecha_actual' AND
			detallecotizacionesproductos$idsucursal.idproducto='$idproducto'";
			
			$cadenaB="SELECT
			SUM(detallecotizacionesproductos$idsucursal.cantidad) AS cantidadTotal
			FROM detallecotizacionesproductos$idsucursal
			INNER JOIN cotizacionesproductos$idsucursal ON cotizacionesproductos$idsucursal.idcotizacionproducto = detallecotizacionesproductos$idsucursal.idcotizacionproducto
			WHERE
			cotizacionesproductos$idsucursal.fecha >= '$fechaAnteriorA' AND
			cotizacionesproductos$idsucursal.fecha <= '$fechaAnteriorB' AND
			detallecotizacionesproductos$idsucursal.idproducto='$idproducto'";
			
			$resultadoA=mysqli_query($this->con->conect, $cadenaA);
			if ($resultadoA){
				$extractorA = mysqli_fetch_array($resultadoA);
				$cantidadA=$extractorA["cantidadTotal"];
			}else{
				$cantidadA=0;
			}
			
			$resultadoB=mysqli_query($this->con->conect, $cadenaB);
			if ($resultadoB){
				$extractorB = mysqli_fetch_array($resultadoB);
				$cantidadB=$extractorB["cantidadTotal"];
			}else{
				$cantidadB=0;
			}
			
			if ($cantidadB>0){
				if ($cantidadA>0){
					$promedio=($cantidadA+$cantidadB)/78; //90 días de 30 dias cada mes, 78 en meses de 26 dias
				}else{
					$promedio=$cantidadB/52; //60 días de 30 dias cada mes, 52 en meses de 26 días
				}
			}else{
				if ($cantidadA>0){
					$promedio=$cantidadA/26; //30 dias cada mes, 26 en meses de 26 días
				}else{
					$promedio=0;
				}
			}
			
			$minimo=30;//Obtener de configuracion dias de stock minimo
			$maximo=90;//Obtener de configuracion dias de stock maximo
			$stockMinimo=$promedio*$minimo;
			$stockMaximo=$promedio*$maximo;
			return array($stockMinimo,$stockMaximo);
			
		}else{
			return array(0,0);
		}
	}
	
	function obtenerStocks($idproducto, $idreferencia, $tablareferencia, $idstock){
		if($this->con->conectar()==true){
			$consulta = "SELECT * FROM stocks WHERE idproducto='$idproducto' and tablareferencia='$tablareferencia' and idreferencia='$idreferencia' and idstock='$idstock'";
			$resultado=mysqli_query($this->con->conect,$consulta);
			if(mysqli_num_rows($resultado)>0){
				$extractor = mysqli_fetch_array($resultado);
				$idstock=$extractor["idstock"];
				$periodoinicio=$extractor["periodoinicio"];
				$periodofin=$extractor["periodofin"];
				$stockminimo=$extractor["stockminimo"];
				$stockmaximo=$extractor["stockmaximo"];
			}else{
				return false;
			}
			return array($idstock,$periodoinicio,$periodofin,$stockminimo,$stockmaximo);
		}else{
			return false;
		}
	}
	
	function mostrarIndividual($idproducto){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM productos WHERE idproducto='$idproducto'");
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $consultaExtra, $excel="no"){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['productos']['consultar'])){
			return "denegado";
			exit;
		}
		
		$limit="";
		if ($excel=="no"){
			$limit="LIMIT $inicial, $cantidadamostrar";
		}
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					productos.idproducto,
					productos.idfamilia,
					productos.nombre,
					productos.codigo,
					productos.autoclasificar,
					productos.clasificacion,
					productos.idmodeloimpuestos,
					productos.idcategoria,
					productos.idunidad,
					productos.marca,
					productos.pesoteorico,
					productos.espesor,
					productos.ancho,
					productos.color,
					productos.diametro,
					productos.tipo,
					productos.modelo,
					productos.modelo2,
					productos.lado,
					productos.alto,
					productos.largo,
					productos.aplicacion,
					productos.clave,
					productos.descripcion,
					productos.variacionpermitidaencosto,
					productos.costo,
					productos.estatus,
					familias.nombre AS nombrefamilias,
					modelosimpuestos.nombre AS nombremodelosimpuestos,
					categorias.nombre AS nombrecategorias,
					unidades.nombre AS nombreunidades
					FROM productos 
					INNER JOIN familias ON productos.idfamilia=familias.idfamilia
					INNER JOIN modelosimpuestos ON productos.idmodeloimpuestos=modelosimpuestos.idmodeloimpuestos
					INNER JOIN categorias ON productos.idcategoria=categorias.idcategoria
					INNER JOIN unidades ON productos.idunidad=unidades.idunidad
					$where $consultaExtra
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
	
	function obtenerCampo($campo, $idproducto){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT $campo FROM productos WHERE idproducto='$idproducto'");
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
	
	function obtenerCampoExtraordinario($campo, $idproducto, $tablaextra, $campoExtra){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT $campo FROM productos WHERE idproducto='$idproducto'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor["$campo"];
				
				$resultado2=mysqli_query($this->con->conect,"SELECT $campoExtra FROM $tablaextra WHERE $campo='$valorCampo'");
				if ($resultado2){
					$extractor2 = mysqli_fetch_array($resultado2);
					$valorCampo2=$extractor2["$campoExtra"];
					return $valorCampo2;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function obtenerPrecios($idproducto){
		$arregloIDLista = array();
		$arregloprecios = array();
		$arregloResultado = array();
		$arreglovalorimpuesto = array();
		if($this->con->conectar()==true){
			$resultado = mysqli_query($this->con->conect,"SELECT * FROM listasprecios WHERE estatus <>'eliminado' ORDER BY nombre ASC");
			while ($filas=mysqli_fetch_array($resultado)) {
                array_push($arregloIDLista,$filas['idlistaprecios']);
				$idlistaprecios = $filas['idlistaprecios'];
                $resultado2 = mysqli_query($this->con->conect,"SELECT * FROM precios WHERE idreferencia = '$idproducto' AND idlistaprecios = '$idlistaprecios'");
			    while ($filas2=mysqli_fetch_array($resultado2)) {
					 array_push($arregloprecios,$filas2['precio']);
				}
            }
			//Armar un arreglo con los impuestos de éste producto
			$resultado3 = mysqli_query($this->con->conect,"SELECT * FROM impuestos INNER JOIN productos ON impuestos.idmodeloimpuesto = productos.idmodeloimpuestos WHERE idproducto = '$idproducto'");
			while ($filas3=mysqli_fetch_array($resultado3)) {
				array_push($arreglovalorimpuesto,$filas3['valor']);
				$costopromedio = $filas3['costo'];//carga el costo promedio de la tabla productos
				$pesoteorico = $filas3['pesoteorico'];//carga el pesoteorico de la tabla productos
				$claveproducto = $filas3['codigo'];//carga el pesoteorico de la tabla productos
			}
		}
		array_push($arregloResultado,$arregloprecios);
		array_push($arregloResultado,$arregloIDLista);
		array_push($arregloResultado,$arreglovalorimpuesto);
		array_push($arregloResultado,$costopromedio);
		array_push($arregloResultado,$pesoteorico);
		array_push($arregloResultado,$claveproducto);
		return  $arregloResultado;
	}
	
	function obtenerFamiliasHijas($idfamilia){
		global $arrayFamilia;
		if($this->con->conectar()==true){
			$resultado2=mysqli_query($this->con->conect,"SELECT * FROM familias WHERE idfamiliamadre='$idfamilia'");
			if($resultado2){ //Si se obtienen las familias
				while ($filas2=mysqli_fetch_array($resultado2)) { 
					$idfamilia=$filas2['idfamilia'];
					
					if (!in_array($idfamilia, $arrayFamilia)) {
						$this->obtenerFamiliasHijas($idfamilia, $this->con->conect);
					}
					array_push($arrayFamilia,$idfamilia);
				}
			}else{//Si no se obtienen las familias
				return "error";
			}
			
			return "exito";
		}else{
			return "error";
		}
	}
	
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM productos $condicion");
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
	
	function obtenerCamposFamilia($idfamilia){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT camposrequeridos FROM familias WHERE idfamilia='$idfamilia' ");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor["camposrequeridos"];
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
		$modulo="productos";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['productos']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE productos SET estatus ='eliminado' WHERE idproducto IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla productos ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM productos WHERE idproducto IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla productos ";
						$this->registrarBitacora("eliminar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function eliminarStock($id){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['productos']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		if($this->con->conectar()==true){
			if(mysqli_query($this->con->conect,"DELETE FROM stocks WHERE idstock ='$id'")){
				return "exito";
			}else{
				return "fracaso";
			}
		}else{
			return "fracaso";
		}
	}
}
?>