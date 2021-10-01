<?php
session_start();
$mensaje="";
if(isset($_SESSION["autentificado"])){
	if ($_SESSION["autentificado"]== "SI"){
		header("Location: ../inicio/inicio/inicio.php");
	}else{
		//$mensaje='<p class="login-box-msg text-red">Los datos de acceso son incorrectos.</p>';
		unset($_SESSION["autentificado"]);
	}
}
if (!isset($_SESSION["empresa"])){
	$_SESSION["empresa"]="modulalite";
	//$mensaje='<p class="login-box-msg text-red">La URL de acceso es incorrecta </br> </br>Verifique que la dirección de su navegador sea similar a "www.suempresa.onixbm.com.mx".</p>';
	unset($_SESSION["autentificado"]);
}

//Verificar si el usuario tiene guardados su usuario y contraseña para recordar
if (isset($_COOKIE["parlet_root_u"]) && isset($_COOKIE["parlet_root_p"])){ // Si existen las cookies de recordar contraseña
	$usuario=$_COOKIE["parlet_root_u"];
	$contrasena=$_COOKIE["parlet_root_p"];
	$recordar="checked";
}else{
	$usuario="";
	$contrasena="";
	$recordar="";
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Modula Software</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="login-page" onLoad="$('#usuario').focus();">
    <div class="login-box">
      <div class="login-logo">
      	<img src="../../dist/img/logo.png"> </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Ingrese sus datos de acceso para iniciar sesión.</p>
        <?php echo $mensaje; ?>
        <form name="login" id="login" method="post" action="autenticar.php">
                
          <!--div class="form-group has-feedback">
            <select id="idalmacen_ajax" name="idalmacen" class="form-control">
            </select>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div-->
          <div class="form-group has-feedback">
            <input id="usuario" name="usuario" type="text" class="form-control" value="<?php echo $usuario; ?>"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="contrasena" type="password" class="form-control" value="<?php echo $contrasena; ?>"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="recordar" value="si" <?php echo $recordar?>> Recordar
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
            </div><!-- /.col -->
          </div>
        </form>

        

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../../plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>