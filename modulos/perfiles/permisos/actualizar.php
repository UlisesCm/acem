<?php 
include ("../../seguridad/comprobar_login.php");
include("../../../empresas/".$_SESSION["empresa"]."/permisos.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script><script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
<style>
.tablaPermisos{
	width:100%;
	padding-bottom:20px;
}
.cabeceraPermiso{
	height:30px;
	font-size:14px;
	border-left: 20px #2787C0 solid;
	padding-left:20px;
	border-bottom:1px #EEEEEE solid;
	
	-webkit-transition-duration: 0.3s;
	transition-duration: 0.3s;
	-webkit-transition-property: transform;
	transition-property: transform;
	-webkit-transition-timing-function: ease-out;
	transition-timing-function: ease-out;
}

.cabeceraPermiso:hover{
	-webkit-transform: translateX(8px);
	transform: translateX(8px);
	cursor:default;
}
.oculto{
	display:none;
}
.filaPermiso{
	padding-left:30px;
}
</style>
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
          <h1>Perfíl<small> <?php echo $nombre; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="../consultar/vista.php?n1=usuarios&n2=perfiles&n3=consultarperfiles">Consultar Perfíles</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
        	<?php $herramientas="nuevo"; include("../componentes/herramientas.php"); ?>
			<?php include("../../../componentes/avisos.php");?>
    		<!-- Horizontal Form -->
            <div class="box box-info" style="border-color:<?php echo $color; ?>">
              <div class="box-header with-border">
                <h3 class="box-title">Lista de permisos para el perfíl <?php echo $nombre; ?></h3>
              </div><!-- /.box-header -->
              <!-- form start -->
              <div class="box box-body">
			  <form name="formulario" id="formulario" method="post">
    	<?php
		
		$arreglo=explode("@",$entorno);
		$con=0;
		while ($con< count($arreglo)){
			$arreglo2=explode("|",$arreglo[$con]);
			$arregloEntidad=explode("/",$arreglo2[0]);
			$ENTIDAD[$con]=$arregloEntidad[0];
			$TITULOENTIDAD[$con]=$arregloEntidad[1];
			$arreglo3=explode(",",$arreglo2[1]);
			
			$con2=0;
			while($con2<count($arreglo3)){
				$arreglo4=explode(":",$arreglo3[$con2]);
				//$ATRIBUTO=$arreglo4[0];
				//$VALOR=$arreglo4[1];
				$ATRIBUTO[$con][$con2]=$arreglo4[0];
				$VALOR[$con][$con2]=$arreglo4[1];
				
				$con2++;
			}
			$con++;
		}
		
		
		$cadena=$Operfil->recuperarPermisos($id);
		//echo "cadena:".$cadena;
		if ($cadena!=""){
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
		}
		
		
		$con=0;
		?>
                    <table border="0" class="tablaPermisos">
                    <?php
                    while($con<count($ENTIDAD)){
                            ?>
                            <tr>
                                <td class="cabeceraPermiso" onclick="mostrar('<?php echo $ENTIDAD[$con];?>');" style="border-color:<?php echo $color; ?>">Permisos para el módulo: <?php echo strtoupper($TITULOENTIDAD[$con]);?></td>
                            </tr>
                            <?php
                            $con2=0;
                            while ($con2<count($ATRIBUTO[$con])){
                                $entidad=$ENTIDAD[$con];
                                $atributo=$ATRIBUTO[$con][$con2];
                                $descripcion=$VALOR[$con][$con2];
                                if (isset($permiso[$entidad][$atributo])){
                                    $estado="checked='checked'";
                                    
                                }else{
                                    $estado="";
                                }
                                
                                /*if ($id==1){
                                    $estado="checked='checked' disabled='disabled'";
                                }*/
                                ?>
                                
                                <tr class="permiso<?php echo $ENTIDAD[$con];?> oculto">
                                    <td class="filaPermiso">
                                        <div class="checkbox">
                                            <input id="<?php echo $entidad.$atributo ?>" type="checkbox" name="<?php echo $entidad.$atributo ?>" value="<?php echo $entidad.":".$atributo ?>" <?php echo $estado ?>>
                                            <label for="<?php echo $entidad.$atributo ?>"><?php echo $descripcion ?></label>
                                        </div>
                                    </td>
                                </tr>
                                
                                <?php
                                $con2++;
                            }
                            $con++;
                    }
                    
                    ?>
                    </table>
              </div>
                    
              <div class="box-footer">
                <input name="idperfil" type="hidden" id="cidperfil" value="<?php echo $id;?>"/>
                <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
              </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#25c274"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
</body>
</html>