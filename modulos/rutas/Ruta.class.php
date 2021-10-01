<?php 
include_once("../../conexion/Conexion.class.php");

class Ruta{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE rutas.estatus ='eliminado'";
			}else{
				$consulta="WHERE rutas.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE rutas.estatus ='eliminado'";
			}else{
				$consulta="WHERE rutas.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from rutas WHERE $campo = '$valor'");
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
	
	function guardarRuta($serie,$folio,$nombre,$fecha,$idempleado,$observacionesruta,$conexion){
		$validar=true;
		$this->globalIdruta = $this->con->generarClave(2); /*Sincronizacion 1 */
		$consultaDet = "INSERT INTO rutas (idruta, serie, folio, nombre, fecha, idempleado, observacionesruta, observacionessalida, autorizada, estatus) VALUES ('$this->globalIdruta','$serie','$folio','$nombre','$fecha','$idempleado','$observacionesruta','','NO AUTORIZADA','activo')";
		//echo $consultaDet;
		if(!mysqli_query($conexion,$consultaDet)){
			$validar=false;
		}
		return $validar;
	}
	function actualizarCotizacionesdeproducto($lista,$listaSalidaOptima,$listaSalidaCoordenadas,$tipoRuta,$conexion){
		$validar=true;
		if($tipoRuta=="TABLA"){//RUTA SEGUN TABLA
			$idcotizacionproducto = 0;
			//GUARDAR LOS DETALLES DE LA COTIZACIÓN
			$arregloId=$this->descomponerArreglo(2,0,$lista);
			$arregloOrdenordenentrega=$this->descomponerArreglo(2,1,$lista);//parametros (el numero de campos que completan el primer registro, la posición del arreglo que va a tomar, la lista)
			$con=0;
			$validar=false;
			while ($con < count($arregloId)){
				$idcotizacionproducto =$arregloId[$con];
				$ordenentrega =$arregloOrdenordenentrega[$con];
				$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
				$varConsulta = "UPDATE $cotizacionesproductos SET idruta='$this->globalIdruta', ordenentrega ='$ordenentrega', estadoentrega='CARGANDO', estadoliquidacion ='NO LIQUIDADO' WHERE idcotizacionproducto='$idcotizacionproducto' ";
				//echo $varConsulta;
				if(!mysqli_query($conexion,$varConsulta)){	
					return false;
				}
				else{
					$validar=true;
				}
				$con++;
			}
		}
		else{
			//RUTA OPTIMA
		//listaSalidaOptima tiene un arreglo de coordenadas de la generación de la ruta optima según mas
		//listaSalidaCoordenadas tiene un arrreglo de idcotizacionproducto y coordenadas relacionadas el cual vamos a recorrer para comparar y guardar en la cotización el orden que le corresponde
		  $arregloId=$this->descomponerArreglo(2,0,$listaSalidaCoordenadas);
		  $arregloCoordenadas=$this->descomponerArreglo(2,1,$listaSalidaCoordenadas);
		  $arregloCoordenadasOrdenOptimo=$this->descomponerArreglo(1,0,$listaSalidaOptima);
		  
		  //hacer un ciclo para recorrer el arregloCoordenadasOrdenOptimo y buscar en el arreglocoordenadas a que idcotizacionproducto pertenece esa coordenada y en seguida hacer el update con el orden según el contador
		  	$con=0;
			$validar=false;
			$ordenentrega = 1;
			while ($con < count($arregloCoordenadasOrdenOptimo)){
				//buscar que idcotizacionproducto vamos a actualizar con el ordenentrega en curso
				$con2=0;
				while ($con2 < count($arregloCoordenadas)){
					if($arregloCoordenadasOrdenOptimo[$con]==$arregloCoordenadas[$con2]){
					  $idcotizacionproducto=$arregloId[$con2];
					}
					$con2++;
				}
				
				$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
				$varConsulta = "UPDATE $cotizacionesproductos SET idruta='$this->globalIdruta', ordenentrega ='$ordenentrega', estadoentrega='CARGANDO' WHERE idcotizacionproducto='$idcotizacionproducto' ";
				//echo $varConsulta;
				if(!mysqli_query($conexion,$varConsulta)){	
					return false;
				}
				else{
					$validar=true;
				}
				$ordenentrega++;
				$con++;
			}
		}
		return $validar;
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
	
	function actualizarFolio($conexion){
		$idsucursal=$_SESSION["idsucursal"];
		$varConsulta = "UPDATE folios SET folioactual=folioactual+1 WHERE idsucursal='$idsucursal' AND asignacion ='RUTAS' ";
		//echo $varConsulta;
		if(mysqli_query($conexion,$varConsulta)){	
			return true;
		}
		else{
			return false;
		}
	}

	function guardar($serie,$folio,$nombre,$fecha,$idempleado,$observacionesruta,$listaSalida,$listaSalidaOptima,$listaSalidaCoordenadas,$tipoRuta){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['rutas']['guardar'])){
			return "denegado";
			exit;
		}
		
		/////FIN  DE PERMISOS////////
		$validar = "fracaso";
		if($this->con->conectar()==true){
				$this->con->conect->autocommit(false); //INICO DE TRANSACCION
				if($this->guardarRuta($serie,$folio,$nombre,$fecha,$idempleado,$observacionesruta,$this->con->conect)){//guarda el cliente nuevo
				
				   if($this->actualizarCotizacionesdeproducto($listaSalida,$listaSalidaOptima,$listaSalidaCoordenadas,$tipoRuta,$this->con->conect)){//guarda el cliente nuevo
				   
				    	if($this->actualizarFolio($this->con->conect)){//guarda el cliente nuevo
							   //FINALIZAR TRANSACCION
								$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
								$validar = "exito";
								//BITACORA
								if ($_SESSION['bitacora']=="si"){
									$descripcionB="agreg&oacute; un nuevo registro en la tabla rutas ";
									$this->registrarBitacora("guardar",$descripcionB);
								}
					   }
					   else{//actualizar  folio
						   $this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
						   $validar = "fracaso";
					   }
				   }
				   else{//actualizar ctizaciones de producto
					   $this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
					   $validar = "fracaso";
				   }
				}//guardar ruta
				else{
					$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
					$validar = "fracaso";
				}
				
		}
		return $validar;
	}
	
	
	function actualizarCoordenadasDomicilio($iddomicilio,$coordenadas){
		if($this->con->conectar()==true){
				if(mysqli_query($this->con->conect,"UPDATE domicilios SET coordenadas='$coordenadas' WHERE iddomicilio='$iddomicilio'")){
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($serie,$folio,$nombre,$fecha,$idempleado,$observacionesruta,$observacionessalida,$autorizada,$estatus,$idruta){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['rutas']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE rutas SET serie='$serie', folio='$folio', nombre='$nombre', fecha='$fecha', idempleado='$idempleado', observacionesruta='$observacionesruta', observacionessalida='$observacionessalida', autorizada='$autorizada', estatus='$estatus' WHERE idruta='$idruta'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idruta, de la tabla rutas ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idruta){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['rutas']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE rutas SET estatus ='bloqueado' WHERE idruta = '$idruta'");
		}
	}
	
	function cambiarEstatus($idruta,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['rutas']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE rutas SET estatus ='$estatus' WHERE idruta = '$idruta'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla rutas ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idruta){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM rutas WHERE idruta='$idruta'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					rutas.idruta,
					rutas.serie,
					rutas.folio,
					rutas.nombre,
					rutas.fecha,
					rutas.idempleado,
					rutas.observacionesruta,
					rutas.observacionessalida,
					rutas.autorizada,
					rutas.estatus,
					empleados.idempleado AS idempleadoempleados
					FROM rutas 
					INNER JOIN empleados ON rutas.idempleado=empleados.idempleado
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $folio, $filtrarfecha,$fechainicio,$fechafin,$autorizacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['rutas']['consultar'])){
			return "denegado";
			exit;
		}
		
		if ($folio!=""){
			$consultaFolio=" AND rutas.folio = '$folio' ";
		}else{
			$consultaFolio="";
		}
		if ($filtrarfecha=="SI"){
			$consultaFecha=" AND rutas.fecha >= '$fechainicio' AND rutas.fecha <= '$fechafin' ";
		}else{
			$consultaFecha="";
		}
		if ($autorizacion!="AMBAS"){
			$consultaAutorizacion=" AND rutas.autorizada = '$autorizacion' ";
		}else{
			$consultaAutorizacion="";
		}
		$consultaEstatus =" AND rutas.estatus = 'activo' ";
		
		
		$where="WHERE rutas.idruta<>0 
		$consultaFolio
		$consultaFecha
		$consultaAutorizacion
		$consultaEstatus";
		
		
		$consulta = "SELECT 
					rutas.idruta,
					rutas.serie,
					rutas.folio,
					rutas.nombre,
					rutas.fecha,
					rutas.idempleado,
					rutas.observacionesruta,
					rutas.observacionessalida,
					rutas.autorizada,
					rutas.estatus,
					empleados.nombre AS nombreempleado 
					FROM rutas 
					INNER JOIN empleados ON rutas.idempleado=empleados.idempleado
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
					//echo $consulta;
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	
	
	
	function mostrarReenvios($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $folio, $filtrarfecha,$fechainicio,$fechafin,$autorizacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['rutas']['consultar'])){
			return "denegado";
			exit;
		}
		
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		
		if ($folio!=""){
			$consultaFolio=" AND rutas.folio = '$folio' ";
		}else{
			$consultaFolio="";
		}
		if ($filtrarfecha=="SI"){
			$consultaFecha=" AND rutas.fecha >= '$fechainicio' AND rutas.fecha <= '$fechafin' ";
		}else{
			$consultaFecha="";
		}
		if ($autorizacion!="AMBAS"){
			$consultaAutorizacion=" AND rutas.autorizada = '$autorizacion' ";
		}else{
			$consultaAutorizacion="";
		}
		$consultaEstatus =" AND rutas.estatus = 'activo' ";
		
		//$consultaEnvio = " AND $cotizacionesproductos.envio = 'REENVÍO'";
		$consultaEstadoentrega = " AND $cotizacionesproductos.estadoentrega = 'NO ENTREGADO' OR $cotizacionesproductos.estadoentrega = 'ENTREGA PARCIAL'";
		
		$where="WHERE rutas.idruta<>0 
		$consultaFolio
		$consultaFecha
		$consultaAutorizacion
		$consultaEstatus
		$consultaEstadoentrega";
		
		
		$consulta = "SELECT 
					rutas.idruta,
					rutas.serie,
					rutas.folio,
					rutas.nombre,
					rutas.fecha,
					rutas.idempleado,
					rutas.observacionesruta,
					rutas.observacionessalida,
					rutas.autorizada,
					rutas.estatus,
					$cotizacionesproductos.idcotizacionproducto,
					$cotizacionesproductos.envio,
					$cotizacionesproductos.serie AS serieventa,
					$cotizacionesproductos.folio AS folioventa,
					$cotizacionesproductos.estadoentrega AS estadoentregaventa,
					empleados.nombre AS nombreempleado 
					FROM rutas 
					INNER JOIN empleados ON rutas.idempleado=empleados.idempleado
					INNER JOIN $cotizacionesproductos ON rutas.idruta=$cotizacionesproductos.idruta
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
					//echo $consulta;
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	
	function mostrarRutaPorChofer($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera,$autorizacion,$idempleado){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['rutas']['consultar'])){
			return "denegado";
			exit;
		}
		
		
		if ($autorizacion!="AMBAS"){
			$consultaAutorizacion=" AND rutas.autorizada = '$autorizacion' ";
		}else{
			$consultaAutorizacion="";
		}
		$consultaEmpleado =" AND rutas.idempleado = '$idempleado' ";
		$consultaEstatus =" AND rutas.estatus = 'activo' ";
		
		
		$where="WHERE rutas.idruta<>0 
		$consultaAutorizacion
		$consultaEmpleado
		$consultaEstatus";
		
		
		$consulta = "SELECT 
					rutas.idruta,
					rutas.serie,
					rutas.folio,
					rutas.nombre,
					rutas.fecha,
					rutas.idempleado,
					rutas.observacionesruta,
					rutas.observacionessalida,
					rutas.autorizada,
					rutas.estatus,
					empleados.nombre AS nombreempleado 
					FROM rutas 
					INNER JOIN empleados ON rutas.idempleado=empleados.idempleado
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
					//echo $consulta;
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM rutas $condicion");
		}
	}
	
	
	
	function consultaRutasConDevoluciones($idempleado,$estadoliquidacion,$fechainicio,$fechafin){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['rutas']['consultar'])){
			return "denegado";
			exit;
		}
		
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		
		
		$consultaFecha=" AND rutas.fecha >= '$fechainicio' AND rutas.fecha <= '$fechafin' ";
		
		$consultaEstatus =" AND rutas.estatus = 'activo' ";
		
		//$consultaEnvio = " AND $cotizacionesproductos.envio = 'REENVÍO'";
		$consultaEstadoentrega = " AND $cotizacionesproductos.estadoentrega = 'DEVUELTO'";
		
		$where="WHERE rutas.idruta<>0 
		$consultaFecha
		$consultaEstatus
		$consultaEstadoentrega";
		
		
		$consulta = "SELECT 
					rutas.idruta,
					rutas.serie,
					rutas.folio,
					rutas.nombre,
					rutas.fecha,
					rutas.idempleado,
					rutas.observacionesruta,
					rutas.observacionessalida,
					rutas.autorizada,
					rutas.estatus,
					$cotizacionesproductos.idcotizacionproducto,
					$cotizacionesproductos.envio,
					$cotizacionesproductos.serie AS serieventa,
					$cotizacionesproductos.folio AS folioventa,
					empleados.nombre AS nombreempleado 
					FROM rutas 
					INNER JOIN empleados ON rutas.idempleado=empleados.idempleado
					INNER JOIN $cotizacionesproductos ON rutas.idruta=$cotizacionesproductos.idruta
					$where
					";
					//echo $consulta;
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	
	
	function consultaRutasConDevolucionesLista($idempleado,$estadoliquidacion,$fechainicio,$fechafin){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['rutas']['consultar'])){
			return "denegado";
			exit;
		}
		
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		
		
		$consultaFecha=" AND rutas.fecha >= '$fechainicio' AND rutas.fecha <= '$fechafin' ";
		
		$consultaEstatus =" AND rutas.estatus = 'activo' ";
		
		$consultaEmpleado = " AND rutas.idempleado = '$idempleado'";
		
		//$consultaEnvio = " AND $cotizacionesproductos.envio = 'REENVÍO'";
		$consultaEstadoentrega = " AND $cotizacionesproductos.estadoentrega = 'DEVUELTO'";
		
		$where="WHERE rutas.idruta<>0 
		$consultaFecha
		$consultaEstatus
		$consultaEmpleado
		$consultaEstadoentrega";
		
		
		$consulta = "SELECT 
					rutas.idruta,
					rutas.serie,
					rutas.folio,
					rutas.nombre,
					rutas.fecha,
					rutas.idempleado,
					rutas.observacionesruta,
					rutas.observacionessalida,
					rutas.autorizada,
					rutas.estatus,
					$cotizacionesproductos.idcotizacionproducto,
					$cotizacionesproductos.envio,
					$cotizacionesproductos.serie AS serieventa,
					$cotizacionesproductos.folio AS folioventa,
					empleados.nombre AS nombreempleado 
					FROM rutas 
					INNER JOIN empleados ON rutas.idempleado=empleados.idempleado
					INNER JOIN $cotizacionesproductos ON rutas.idruta=$cotizacionesproductos.idruta
					$where
					GROUP BY idempleado
					";
					//echo $consulta;
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	
	function consultaRutasConDevoluciones1($idempleado,$estadoliquidacion,$fechaini,$fechafin){
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		if($fechaini!=""){
			//agregar rnago de fechas a la consulta
			$consultaFecha=" AND rutas.fecha >= '$fechaini' AND rutas.fecha <= '$fechafin' ";
		}
		$consulta = "SELECT 
		rutas.idruta,
		rutas.serie,
		rutas.folio,
		rutas.nombre,
		rutas.fecha,
		rutas.estatus
		FROM rutas 
		INNER JOIN empleados ON rutas.idempleado=empleados.idempleado
		INNER JOIN $cotizacionesproductos ON rutas.idruta = $cotizacionesproductos.idrutaanterior
		WHERE rutas.estatus <> 'eliminado' AND rutas.idempleado = '$idempleado' AND $cotizacionesproductos.estadoentrega = 'DEVUELTO' AND $cotizacionesproductos.estadoliquidacion <>'$estadoliquidacion' $consultaFecha
		GROUP BY rutas.idruta
		";//Id ruta = 0 y idrutaanterior <> 0 porque solamente las notas que hayan llegado hasta este punto tendran el idrutaanterior diferente de cero pero tmb filtrar con idruta= 0 para cuando se vuelva a agregar a una ruta ya se quite de éste reporte.
		echo $consulta;
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,$consulta);
		}
		
	}
	
	
	function consultaRutasEstadoLiquidacion($idempleado,$estadoliquidacion,$fechaini,$fechafin){
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		if($fechaini!=""){
			//agregar rnago de fechas a la consulta
			$consultaFecha=" AND rutas.fecha >= '$fechaini' AND rutas.fecha <= '$fechafin' ";
		}
		$consulta = "SELECT 
		rutas.idruta,
		rutas.serie,
		rutas.folio,
		rutas.nombre,
		rutas.fecha,
		rutas.estatus
		FROM rutas 
		INNER JOIN empleados ON rutas.idempleado=empleados.idempleado
		INNER JOIN $cotizacionesproductos ON rutas.idruta = $cotizacionesproductos.idruta
		WHERE rutas.estatus <> 'eliminado' AND rutas.idempleado = '$idempleado' AND rutas.autorizada = 'AUTORIZADA' AND $cotizacionesproductos.estadoliquidacion ='$estadoliquidacion' $consultaFecha
		GROUP BY rutas.idruta
		";
		//echo $consulta;
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,$consulta);
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
		$modulo="rutas";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['rutas']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE rutas SET estatus ='eliminado' WHERE idruta IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla rutas ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM rutas WHERE idruta IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla rutas ";
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