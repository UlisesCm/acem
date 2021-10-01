<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" /><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script>

<script><?php echo "var idperfilSeleccionado='$idperfil';";?></script>

<script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
</head>
  <body class="sidebar-mini <?php include("../../../componentes/skin.php");?>">
    <!-- Wrapper es el contenedor principal -->
    <div class="wrapper">
      
      <?php include("../../../componentes/menuSuperior.php");?>
      <?php include("../../../componentes/menuLateral.php");?>

      <!-- Contenido-->
      <div class="content-wrapper">
        <!-- Contenido de la cabecera -->
        <section class="content-header">
          <h1>Usuario<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar usuario</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		
			
			<?php $herramientas="nuevo"; include("../componentes/herramientas.php"); ?>
			<?php include("../../../componentes/avisos.php");?>
        
          	<!-- Horizontal Form -->
            <div class="box box-primary" style="border-color:#1c81f0">
            
            
            
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle center-block" src="../../../empresas/<?php echo $_SESSION["empresa"];?>/archivosSubidos/usuarios/<?php echo $_SESSION["foto"];?>" alt="User profile picture">
    
                  <h3 class="profile-username text-center"><?php echo $nombre; ?> <a class="btn btn-primary btn-xs" onclick="mostrarPanel1();">&nbsp;<i class="fa fa-pencil"></i></a></h3>
    
                  <p class="text-muted text-center"><?php echo $_SESSION["nombreperfil"]; ?></p>
                  <p class="text-muted text-center text-blue"><?php echo $email; ?></p>
    
                  <p class="text-muted text-center"><a class="btn btn-primary btn-xs" onclick="mostrarPanel2();">&nbsp;<i class="fa  fa-edit"></i>&nbsp; Cambiar contraseña</a></p>
                  
    			  <div style="display:none;" id="panel1"><!-- /.Panel 1 -->
                  <div class="box-header with-border">
                    <h3 class="box-title">Modificar datos de perfil</h3>
                  </div><!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" name="formulario1" id="formulario1" method="post" enctype="multipart/form-data" >
                    <div class="box-body">
                    <div class="form-group ">
                        <label for="cnombre" class="col-sm-2 control-label">Nombre completo:</label>
                        <div class="col-sm-5">
                            <span id="Vnombre">
                            <input value="<?php echo $nombre; ?>" name="nombre" type="text" class="form-control" id="cnombre" />
                            <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                        <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                        </span>
                        </div>
                    </div>
                
                    <div class="form-group ">
                        <label for="cemail" class="col-sm-2 control-label">Correo electrónico:</label>
                        <div class="col-sm-5">
                            <span id="Vemail">
                            <input value="<?php echo $email; ?>" name="email" type="text" class="form-control" id="cemail" />
                            <span class="textfieldInvalidFormatMsg">Formato no válido.</span>
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                        </span>
                        </div>
                    </div>
                
                    <div class="form-group ">
                        <label for="x" class="col-sm-2 control-label">Fotografía:</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="file" name="fotoI" style="display:none;" id="cfotoI" accept=".jpg" onChange="fileinput('foto')"/>
                                <input value="<?php echo $foto; ?>" type="text" name="foto" id="cfoto" class="form-control" placeholder="Seleccionar Imagen" readonly >
                                <input value="<?php echo $foto; ?>" type="hidden" name="fotoEliminacion" id="cfotoEliminacion" >
                                <span class="input-group-btn">
                                    <a class="btn btn-success" onclick="$('#cfotoI').click();">&nbsp;&nbsp;&nbsp;Seleccionar Imagen</a>
                                </span>
                            </div>        
                        </div>
                    </div>
                
                    
                    <div class="form-group ">
                        <label for="ccontrasena" class="col-sm-2 control-label"></label>
                        <div class="col-sm-5">
                            <input name="idusuario" type="hidden" id="cidusuario1" value="<?php echo $id;?>"/>
                      		<button type="button" class="btn btn-primary pull-right" id="botonGuardar1"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                        </div>
                    </div>
                
                    
                </div><!-- /.box-body -->
                    
                    
                  </form>
                  <div id="loading" class="overlay" style="display:none">
                        <i class="fa fa-cog fa-spin" style="color:#1c81f0"></i>
                  </div>
                  </div><!-- /.Panel 1 -->
                  
                  
                  
                  
                  <div style="display:none;" id="panel2"><!-- /.Panel 2 -->
                  
                  <div class="box-header with-border">
                    <h3 class="box-title">Cambiar contraseña</h3>
                  </div><!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" name="formulario2" id="formulario2" method="post" enctype="multipart/form-data" >
                    <div class="box-body">
                
                    <div class="form-group ">
                        <label for="ccontrasena" class="col-sm-2 control-label">Contraseña Actual:</label>
                        <div class="col-sm-3">
                            <span id="Vcontrasena">
                            <input value="" name="contrasena" type="password" class="form-control" id="ccontrasena" />
                            <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                        <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                        </span>
                        </div>
                    </div>
                    
                    
                     <div class="form-group ">
                        <label for="ccontrasena2" class="col-sm-2 control-label">Nueva Contraseña:</label>
                        <div class="col-sm-3">
                            <span id="Vcontrasena2">
                            <input value="" name="contrasena2" type="password" class="form-control" id="ccontrasena2" />
                            <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                        <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                        </span>
                        </div>
                    </div>
                    
                     <div class="form-group ">
                        <label for="ccontrasena3" class="col-sm-2 control-label">Repetir Contraseña:</label>
                        <div class="col-sm-3">
                            <span id="Vcontrasena3">
                            <input value="" name="contrasena3" type="password" class="form-control" id="ccontrasena3" />
                            <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
                        <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span>
                        </span>
                        </div>
                    </div>
                    
                    
                    <div class="form-group ">
                        <label for="ccontrasena" class="col-sm-2 control-label"></label>
                        <div class="col-sm-3">
                            <input name="idusuario" type="hidden" id="cidusuario2" value="<?php echo $id;?>"/>
                      		<button type="button" class="btn btn-primary pull-right" id="botonGuardar2"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                        </div>
                    </div>
                    
                </div><!-- /.box-body -->
                    
                    
                  </form>
                  <div id="loading" class="overlay" style="display:none">
                        <i class="fa fa-cog fa-spin" style="color:#1c81f0"></i>
                  </div>
                  
                  </div><!-- /.Panel 2 -->
                  
                  
                  
                </div>
            
            
              
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombre", "none", {validateOn:["blur"],  maxChars:100,  minChars:2});
				
var sprytextfield2 = new Spry.Widget.ValidationTextField("Vemail", "email", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("Vcontrasena", "none", {validateOn:["blur"],  maxChars:12,  minChars:6});
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombre", "none", {validateOn:["blur"],  maxChars:100,  minChars:2});
var sprytextfield5 = new Spry.Widget.ValidationTextField("Vcontrasena2", "none", {validateOn:["blur"],  maxChars:12,  minChars:6});				
var sprytextfield6 = new Spry.Widget.ValidationTextField("Vcontrasena3", "none", {validateOn:["blur"],  maxChars:12,  minChars:6});
				
</script>
</body>
</html>