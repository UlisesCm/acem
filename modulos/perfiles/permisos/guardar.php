<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Perfil.class.php');
$Operfil=new Perfil;
$mensaje="";
$validacion=true;

if (isset($_POST['idperfil'])){
	$idperfil=htmlentities(trim($_POST['idperfil']));
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idperfil no es correcto</php>";
}

$entidades = array();
$cadena="";
$atributo="";
$entidad="";
foreach($_POST as $key => $valor){
	if ($key!="idperfil"){
		if ($key!="submit"){
			$array=explode(":",$valor);
			$entidad= $array[0];
			$atributo= $array[1];
			
			$encontrado=false;
			foreach($entidades as $valor2){
				if ($valor2==$entidad){
					$encontrado=true;
				}
			}
			if($encontrado==false){
				array_push($entidades, $entidad);
				$cadena=$cadena."@".$entidad."|".$atributo;
			}else{
				$cadena=$cadena.",".$atributo;
			}
		}
	}
}

$cadena=substr($cadena, 1);

$permisos=$cadena;

if($validacion){
	$resultado=$Operfil->actualizarPermisos($idperfil,$permisos);
	if($resultado=="exito"){
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado.";
				$cadena=$permisos;
				$arreglo=explode("@",$cadena);
				$con=0;
				while ($con< count($arreglo)){
					$arreglo2=explode("|",$arreglo[$con]);
					
					$arreglo3=explode(",",$arreglo2[1]);
					
					$con2=0;
					while($con2<count($arreglo3)){
						
						$entidad=$arreglo2[0];
						$atributo=$arreglo3[$con2];
						
						$permiso[$entidad][$atributo]=$atributo;
						$con2++;
					}
					$con++;
				}
				if ($idperfil==$_SESSION['idperfil']){
					$_SESSION['permisos']=$permiso;
				}else{
					$mensaje=$mensaje." Los cambios surgirán efecto cuando se vuelva a iniciar sesión";
				}
		
		
	}
	if($resultado=="nombreExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo nombre ya existe en la base de datos";
	}
	if($resultado=="fracaso"){
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);

?>