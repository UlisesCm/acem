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
	
	function comprobarAutorizarProductos($idcliente,$idproducto){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT(*) AS contador FROM productosautorizados WHERE idcliente='$idcliente' AND  idproducto	='$idproducto'");
			$extractor = mysqli_fetch_array($resultado);
			$numero_filas=$extractor['contador'];
			if ($numero_filas=="0"){
				?>
                <option value="SI">SI</option>
                <option value="NO" selected="selected">NO</option>
            <?php
			}else{
			?>
				<option value="SI" selected="selected">SI</option>
                <option value="NO">NO</option>
			<?php
			}
		}
	}
	
	function guardarProductosAutorizados($idcliente, $estados, $productos, $rotacionminima, $rotacionmaxima){
		if($this->con->conectar()==true){
			$con=0;
			mysqli_query($this->con->conect,"DELETE FROM productosautorizados WHERE idcliente = '$idcliente'");
			foreach($productos as $clave=>$valor){
				$idproducto=$productos[$clave];
				$rminima=$rotacionminima[$clave];
				$rmaxima=$rotacionmaxima[$clave];
				$estado=$estados[$clave];
				/*if ($rnminima==""){
					$resultado2=mysqli_query($this->con->conect,"SELECT iniciorotacion FROM productos WHERE idproducto ='$idproducto'");
					$extractor2 = mysqli_fetch_array($resultado2);
					$rotacionminima=$extractor2["iniciorotacion"];
				}
				if ($rmaxima==""){
					$resultado2=mysqli_query($this->con->conect,"SELECT finrotacion FROM productos WHERE idproducto ='$idproducto'");
					$extractor2 = mysqli_fetch_array($resultado2);
					$rotacionmaxima=$extractor2["finrotacion"];
				}*/
				if ($estado=="SI"){
				$idproductoautorizado=$this->con->generarClave(1).$con; /*Sincronizacion 1 */
				mysqli_query($this->con->conect,"INSERT INTO productosautorizados(idproductoautorizado,idcliente,idproducto,rotacionminima,rotacionmaxima) VALUES ('$idproductoautorizado','$idcliente','$idproducto','$rminima','$rmaxima')");
				}
				$con++;
			}
			return "exito";
		}else{
			return "fracaso";
		}
	}
	
	function comprobarRotacion($idcliente,$idproducto,$tipo){
		if ($tipo=="rotacionminima"){
			$campoRotacion="iniciorotacion";
		}else{
			$campoRotacion="finrotacion";
		}
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT $tipo FROM productosautorizados WHERE idcliente='$idcliente' AND  idproducto ='$idproducto'");
			$extractor = mysqli_fetch_array($resultado);
			$numero_filas=$extractor["$tipo"];
			if ($numero_filas==""){
				$resultado2=mysqli_query($this->con->conect,"SELECT $campoRotacion FROM productos WHERE idproducto ='$idproducto'");
				$extractor2 = mysqli_fetch_array($resultado2);
				$iniciorotacion=$extractor2["$campoRotacion"];
			?>
            				
            				<option value="00" <?php if ($iniciorotacion=="00") echo 'selected="selected"';?>>INDEFINIDO</option>
                			<option value="01" <?php if ($iniciorotacion=="01") echo 'selected="selected"';?>>ENERO</option>
							<option value="02" <?php if ($iniciorotacion=="02") echo 'selected="selected"';?>>FEBRERO</option>
                            <option value="03" <?php if ($iniciorotacion=="03") echo 'selected="selected"';?>>MARZO</option>
							<option value="04" <?php if ($iniciorotacion=="04") echo 'selected="selected"';?>>ABRIL</option>
                            <option value="05" <?php if ($iniciorotacion=="05") echo 'selected="selected"';?>>MAYO</option>
							<option value="06" <?php if ($iniciorotacion=="06") echo 'selected="selected"';?>>JUNIO</option>
                            <option value="07" <?php if ($iniciorotacion=="07") echo 'selected="selected"';?>>JULIO</option>
							<option value="08" <?php if ($iniciorotacion=="08") echo 'selected="selected"';?>>AGOSTO</option>
                            <option value="09" <?php if ($iniciorotacion=="09") echo 'selected="selected"';?>>SEPTIEMBRE</option>
							<option value="10" <?php if ($iniciorotacion=="10") echo 'selected="selected"';?>>OCTUBRE</option>
                            <option value="11" <?php if ($iniciorotacion=="12") echo 'selected="selected"';?>>NOVIEMBRE</option>
							<option value="12" <?php if ($iniciorotacion=="12") echo 'selected="selected"';?>>DICIEMBRE</option>
			<?php	
			}else{
				?>
							<option value="00" <?php if ($numero_filas=="00") echo 'selected="selected"';?>>INDEFINIDO</option>
                			<option value="01" <?php if ($numero_filas=="01") echo 'selected="selected"';?>>ENERO</option>
							<option value="02" <?php if ($numero_filas=="02") echo 'selected="selected"';?>>FEBRERO</option>
                            <option value="03" <?php if ($numero_filas=="03") echo 'selected="selected"';?>>MARZO</option>
							<option value="04" <?php if ($numero_filas=="04") echo 'selected="selected"';?>>ABRIL</option>
                            <option value="05" <?php if ($numero_filas=="05") echo 'selected="selected"';?>>MAYO</option>
							<option value="06" <?php if ($numero_filas=="06") echo 'selected="selected"';?>>JUNIO</option>
                            <option value="07" <?php if ($numero_filas=="07") echo 'selected="selected"';?>>JULIO</option>
							<option value="08" <?php if ($numero_filas=="08") echo 'selected="selected"';?>>AGOSTO</option>
                            <option value="09" <?php if ($numero_filas=="09") echo 'selected="selected"';?>>SEPTIEMBRE</option>
							<option value="10" <?php if ($numero_filas=="10") echo 'selected="selected"';?>>OCTUBRE</option>
                            <option value="11" <?php if ($numero_filas=="11") echo 'selected="selected"';?>>NOVIEMBRE</option>
							<option value="12" <?php if ($numero_filas=="12") echo 'selected="selected"';?>>DICIEMBRE</option>
                <?php
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
		$idcontacto=$this->con->generarClave(2); /*Sincronizacion 1 */
		$validar = "fracaso";
		$resconsulta=true;
		if($this->con->conectar()==true){
			$this->con->conect->autocommit(false); //INICO DE TRANSACCION
			
			if($this->comprobarCampo("nombre",$nombre, "nuevo")){
				return "nombreExiste";
			}else if($this->comprobarCampo("nic",$nic, "nuevo")){
				return "nicExiste";
			}else{
				
				if(mysqli_query($this->con->conect,"INSERT INTO clientes (idcliente, rfc, nombre, nic, limitecredito, diascredito, saldo, nombrecontacto, correocontacto, telefonocontacto, autorizardosis, autorizarproductos, comentarios, estatus) VALUES ('$idcliente','$rfc','$nombre','$nic','$limitecredito','$diascredito','$saldo','$nombrecontacto','$correocontacto','$telefonocontacto','$autorizardosis','$autorizarproductos','','$estatus')")){
					/*if ($resultado=mysqli_query($this->con->conect,"SELECT * FROM productos WHERE estatus <> 'eliminado' AND cuadrobasico='SI'")){
						$con=0;
						while ($filas=mysqli_fetch_array($resultado)) {
							$idproductoautorizado=$this->con->generarClave(1).$con;
							$idproducto=$filas["idproducto"];
							$rminima=$filas["iniciorotacion"];
							$rmaxima=$filas["finrotacion"];
							if(mysqli_query($this->con->conect,"INSERT INTO productosautorizados(idproductoautorizado,idcliente,idproducto,rotacionminima,rotacionmaxima) VALUES ('$idproductoautorizado','$idcliente','$idproducto','$rminima','$rmaxima')")){
							}else{
								$resconsulta=false;
							}
							$con++;
						}
					}else{
						$resconsulta=false;
					}*/
					 $resconsulta=true;
					if(mysqli_query($this->con->conect,"INSERT INTO contactos (idcontacto, idcliente, nombrecontacto, telefono, email, departamento, comentarios) VALUES ('$idcontacto','$idcliente','$nombrecontacto','$telefonocontacto','$correocontacto','General','')") and $resconsulta==true){
						$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
						$validar = "exito";
					}else{
						$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
						$validar = "fracaso";
					}
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla clientes ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return $validar;
				}else{
					return $validar; //Aqui falla
				}
			}
		}
	}
	
	function guardarContacto($idcliente,$nombrecontacto,$telefono,$email,$departamento,$comentarios,$conexion){
		
		
		$idcontacto=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		
			
		if(mysqli_query($this->con->conect,"INSERT INTO contactos (idcontacto, idcliente, nombrecontacto, telefono, email, departamento, comentarios) VALUES ('$idcontacto','$idcliente','$nombrecontacto','$telefono','$email','$departamento','$comentarios')")){
					
			return true;
		}else{
			return false;
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