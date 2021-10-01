<?php
	require('Seguridad.class.php');
	require('../perfiles/Perfil.class.php');
	error_reporting(E_USER_WARNING | E_USER_NOTICE) ;
	
	$usuario = htmlspecialchars(trim($_POST['usuario']));
	$password = htmlspecialchars(trim($_POST['contrasena']));
	$recordar=htmlspecialchars(trim($_POST['recordar']));
	$Operfil= new Perfil;
	$objLogin=new Seguridad;
		$respuesta = $objLogin->autenticar(array($usuario,$password));
	if ( $respuesta == "error"){
		session_start();
		$_SESSION["autentificado"]="NO";
		setcookie('parlet_root_u','',time()-100);
		setcookie('parlet_root_p','',time()-100);
		header("Location: login.php");
	}else{
				session_start();
				$extractor = mysqli_fetch_array($respuesta);
				$idusuario=$extractor['idusuario'];
				$usuario=$extractor['usuario'];
				$nombre=$extractor['nombre'];
				$foto=$extractor['foto'];
				$empresa=$extractor['empresa'];
				$idperfil=$extractor['idperfil'];
				$idsucursal=$extractor['idsucursal']; //Añadido para controlar la sucursal del inicio de sesión
				$nombresucursal=$extractor['nombresucursal'];
				$coordenadassucursal=$extractor['coordenadassucursal'];
				$nombreperfil=$extractor['nombreperfil'];
				$idregistrorelacionado=$extractor['idregistrorelacionado'];
				$tablarelacionada=$extractor['tablarelacionada'];
				$bitacora=$extractor['bitacora'];
				if ($foto==""){
					$foto="default.jpg";
				}
				
				$_SESSION["autentificado"]= "SI";
				$_SESSION["idusuario"]= $idusuario;
				$_SESSION["idperfil"]= $idperfil;
				$_SESSION["permisos"]= $Operfil->recuperarPermisosLogin($idperfil);
				$_SESSION["usuario"]= $usuario;
				$_SESSION["bitacora"]= $bitacora;
				$_SESSION["nombreusuario"]= $nombre;
				$_SESSION["nombreperfil"]= $nombreperfil;
				$_SESSION["idsucursal"]= $idsucursal;
				$_SESSION["coordenadassucursal"]=$coordenadassucursal;
				$_SESSION["nombresucursal"]=$nombresucursal;
				$_SESSION["foto"]= $foto;
				$_SESSION["idregistrorelacionado"]=$idregistrorelacionado;
				
				//Si el usuario quiere recordar su usuario o contraseña
				if ($recordar=="si"){
					 setcookie("parlet_root_u", $usuario, time()+(60*60*24*365));
					 setcookie("parlet_root_p", $password, time()+(60*60*24*365));
				}else{
					setcookie('parlet_root_u','',time()-100);
					setcookie('parlet_root_p','',time()-100);
				}
				
				$_SESSION["msgsinacceso"]="
				<div id=\"panel_alertasm\" class=\"alert alert-warning alert-dismissable\">
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
					<h4 id=\"notificacionTitulo\"><i class=\"icon fa fa-ban\"></i> Acceso restringido</h4>
					<span id=\"notificacionContenido\">
						Disculpe las molestias, su cuenta no cuenta con los provilegios para realizar esta tarea
					</span>
            	</div>
				";
				header ("Location: ../inicio/inicio/inicio.php");
	}
?>
