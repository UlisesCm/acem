<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>filtro jQuery</title>
	<!-- FONTAWESOME STYLES-->
    <link href="css/font-awesome.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	
	<div id="container">
		<h1>Filtro <span>jQ</span>uery <img src="img/logo.png"></h1>
		<div class="content">
			<div class="search">
				<input type="text" id="busqueda" placeholder="Buscar ...">
				<i class="fa fa-search"></i>
			</div>
			<ul>
				<li>
					<h3>lorem ipsum</h3>
				</li>
				<li>
					<h3>non ultrices</h3>
				</li>
				<li>
					<h3>In augue lacus</h3>
				</li>
				<li>
					<h3>Maecenas semper</h3>
				</li>
				<li>
					<h3>ridiculus mus</h3>
				</li>
				<li>
					<h3>Vivamus sapien</h3>
				</li>
				<li>
					<h3>augue massa</h3>
				</li>
				<li>
					<h3>Nulla faucibus</h3>
				</li>
				<li>
					<h3>Sed non libero</h3>
				</li>
			</ul>
		</div>
	</div><!-- /container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		var busqueda = $('#busqueda'),
		titulo = $('ul li h3');
		$(titulo).each(function(){
			var li = $(this);
			//si presionamos la tecla
			$(busqueda).keyup(function(){
				//cambiamos a minusculas
				this.value = this.value.toLowerCase();
				//
				var clase = $('.search i');
				if($(busqueda).val() != ''){
					$(clase).attr('class', 'fa fa-times');
				}else{
					$(clase).attr('class', 'fa fa-search');
				}
				if($(clase).hasClass('fa fa-times')){
					$(clase).click(function(){
						//borramos el contenido del input
						$(busqueda).val('');
						//mostramos todas las listas
						$(li).parent().show();
						//volvemos a añadir la clase para mostrar la lupa
						$(clase).attr('class', 'fa fa-search');
					});
				}
				//ocultamos toda la lista
				$(li).parent().hide();
				//valor del h3
				var txt = $(this).val();
				//si hay coincidencias en la búsqueda cambiando a minusculas
				if($(li).text().toLowerCase().indexOf(txt) > -1){
					//mostramos las listas que coincidan
					$(li).parent().show();
				}
			});
		});
	});
</script>

</body>
</html>