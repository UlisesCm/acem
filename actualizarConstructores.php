<?php
function recorrerDirectorios($ruta){
   // abrir un directorio y listarlo recursivo
   if (is_dir($ruta)) {
      if ($dh = opendir($ruta)) {
         while (($file = readdir($dh)) !== false) {
            //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio
            //mostraría tanto archivos como directorios
            //echo "<br>Nombre de archivo: $file : Es un: " . filetype($ruta . $file);
            if (is_dir($ruta . $file) && $file!="." && $file!=".."){
               //solo si el archivo es un directorio, distinto que "." y ".."
               //echo "<br>Directorio: $ruta$file";
               recorrerDirectorios($ruta . $file . "/");
            }else{
				if ($file != "." && $file != ".." && substr($file,-10)==".class.php") {
					
					$nombreClase= substr($file,0,-10);
					file_put_contents("$ruta$file", str_replace("function $nombreClase", "function __construct", file_get_contents("$ruta$file")));
					echo "Directorio: $ruta$file</br>";
				}
			}
         }
      closedir($dh);
      }
   }else
      echo "<br>No es ruta valida";
}
recorrerDirectorios("modulos/")
?>