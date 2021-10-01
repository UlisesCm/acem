<!DOCTYPE html>
<html>
<head>
<?php include ("../../../componentes/cabecera.php")?>
<link rel="stylesheet" href="../../../dist/css/jtree/style.min.css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../librerias/js/jquery.form.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#submitButton').click(function () {
		alert("entro");
    	    $('#uploadForm').ajaxForm({
    	        target: '#salidaImagen',
    	        url: 'CargarArchivos.php',
    	        beforeSubmit: function () {
    	        	  $("#salidaImagen").hide();
    	        	   if($("#uploadImage").val() == "") {
    	        		   $("#salidaImagen").show();
    	        		   $("#salidaImagen").html("<div class='error'>Elige un archivo para subir.</div>");
                    return false; 
                }
    	            $("#progressDivId").css("display", "block");
    	            var percentValue = '0%';

    	            $('#progressBar').width(percentValue);
    	            $('#percent').html(percentValue);
    	        },
    	        uploadProgress: function (event, position, total, percentComplete) {

    	            var percentValue = percentComplete + '%';
    	            $("#progressBar").animate({
    	                width: '' + percentValue + ''
    	            }, {
    	                duration: 100,
    	                easing: "linear",
    	                step: function (x) {
                        percentText = Math.round(x * 100 / percentComplete);
    	                    $("#percent").text(percentText + "%");
                        if(percentText == "100") {
                        	   $("#salidaImagen").show();
                        }
    	                }
    	            });
    	        },
    	        error: function (response, status, e) {
    	            alert('Oops something went.');
    	        },
    	        
    	        complete: function (xhr) {
    	            if (xhr.responseText && xhr.responseText != "error")
    	            {
    	            	  $("#salidaImagen").html(xhr.responseText);
    	            }
    	            else{  
    	               	$("#salidaImagen").show();
        	            	$("#salidaImagen").html("<div class='error'>Problema al cargar el archivo.</div>");
        	            	$("#progressBar").stop();
    	            }
    	        }
    	    });
    });
});
</script>
<?php 
	if (isset($_GET['busqueda'])){
		echo "<script>
		var busqueda='".$_GET['busqueda']."';
		</script>";
	}else{
		echo '<script>var busqueda="";</script>';
	}
	if (isset($_GET['papelera'])){
		echo '<script>var papelera="si";</script>';
	}else{
		echo '<script>var papelera="no";</script>';
	}
?>
</head>
<body class="sidebar-mini <?php include("../../../componentes/skin.php");?>">

        
<div class="container">
  <h3 class="mt-5">Subir imagen con progress bar usando jquery php</h3>
  <hr>
  <div class="row">
    <div class="col-12 col-md-12"> 
      <!-- Contenido -->
<div class="form-container"> 
  <form class="form-inline"  id="uploadForm" name="frmupload" method="post" enctype="multipart/form-data">
    <div class="form-group mx-sm-3 mb-2">
      <input type="file" id="uploadImage" name="uploadImage" />
    </div>
    <button id="submitButton" type="submit" class="btn btn-primary mb-2" name='btnSubmit'>Cargar imagen</button>
  </form>
  <div class='progress' id="progressDivId">
    <div class='progress-bar' id='progressBar'></div>
    <div class='percent' id='percent'>0%</div>
  </div>
  <div style="height: 10px;"></div>
  <div id='salidaImagen'></div>
 </div> <!-- Fin Form-container -->     
      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 
  
</div>
<!-- Fin container -->

</body>
</html>