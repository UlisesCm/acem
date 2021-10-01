<?php 
include_once("../conexion/Conexion.class.php");

/*
$nombreTabla='clientes';
$clavePrimaria='idcliente';
$campoUsuario='email';
$campoContrasena='contrasena'; 
*/

class Seguridad{
 	//constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
 	}
	
	//funcion activar cuenta
	function activar($id){
		if($this->con->conectar()==true){
			//print_r($campos);
			$filas=mysqli_query($this->con->conect,"SELECT count(*) as numero_filas FROM clientes WHERE idcliente = '".$id."'");
			$extractor = mysqli_fetch_array($filas);
			$numero_filas=$extractor['numero_filas'];
			if ($numero_filas>=1){
				$cons=mysqli_query($this->con->conect,"SELECT activo FROM clientes WHERE idcliente = '".$id."'");
				$extractor2 = mysqli_fetch_array($cons);
				$activo=$extractor2['activo'];
				if($activo==0){
					mysqli_query($this->con->conect,"UPDATE clientes SET activo = 1 WHERE idcliente = '".$id."'");
					return 0;
				}else{
					return 1;
				}
				
				
			}
			if ($numero_filas==0){
				return 2;
			}
			
		}
	}
	
	
	function autenticar($campos){
		if($this->con->conectar()==true){
			//print_r($campos);
			$filas=mysqli_query($this->con->conect,"SELECT count(*) as numero_filas from usuarios WHERE usuario  = '".$campos[0]."' AND contrasena  = '".md5($campos[1])."' AND estado='activo'");
			$extractor = mysqli_fetch_array($filas);
			$numero_filas=$extractor['numero_filas'];
			if ($numero_filas==0){
				return "error";
			}else{
				return mysqli_query($this->con->conect,"SELECT usuarios.idusuario,
									usuarios.usuario,
									usuarios.nombre,
									usuarios.foto,
									usuarios.idperfil,
									usuarios.empresa,
									usuarios.idregistrorelacionado,
									usuarios.tablarelacionada,
									usuarios.bitacora,
									usuarios.idsucursal,
									sucursales.nombre AS nombresucursal,
									sucursales.coordenadas AS coordenadassucursal,
									perfiles.nombre AS nombreperfil
									FROM usuarios
									INNER JOIN perfiles ON usuarios.idperfil=perfiles.idperfil
									INNER JOIN sucursales ON usuarios.idsucursal=sucursales.idsucursal
									WHERE usuarios.usuario = '".$campos[0]."' AND usuarios.contrasena  = '".md5($campos[1])."' AND usuarios.estado='activo'
									
									");
			}
			
		}
	}
	
	function recuperarPermisos($idperfil){
		if($this->con->conectar()==true){
			//print_r($campos);
			$filas=mysqli_query($this->con->conect,"SELECT count(*) as numero_filas from permisos WHERE idperfil  = '".$idperfil."'");
			$extractor = mysqli_fetch_array($filas);
			$numero_filas=$extractor['numero_filas'];
			if ($numero_filas==0){
				return "";
			}else{
				$filas=mysqli_query($this->con->conect,"SELECT * from permisos WHERE idperfil  = '".$idperfil."'");
				$extractor = mysqli_fetch_array($filas);
				$cadena=$extractor['permiso'];
				
				$arreglo=explode("@",$cadena);
				$con=0;
				while ($con< count($arreglo)){
					$arreglo2=explode("|",$arreglo[$con]);
					$arregloEntidad=explode("/",$arreglo2[0]);
					
					
					$arreglo3=explode(",",$arreglo2[1]);
					
					$con2=0;
					while($con2<count($arreglo3)){
						
						$entidad=$arregloEntidad[0];
						$atributo=$arreglo3[$con2];
						
						$permiso[$entidad][$atributo]=$atributo;
						$con2++;
					}
					$con++;
				}
				return $permiso;
			}
			
		}
	}
	
	function recordar($usuario){
		if($this->con->conectar()==true){
			//print_r($campos);
			$filas=mysqli_query($this->con->conect,"SELECT usuario, contrasena FROM usuarios WHERE usuario  = '".$usuario."'");
			$numeroFilas = mysqli_num_rows($filas);
			if ($numeroFilas){
				$extractor = mysqli_fetch_array($filas);
				$contrasena=$extractor['contrasena'];
				return $contrasena;
			}else{
				return "error";
			}
			
		}
	}
	
}
?>