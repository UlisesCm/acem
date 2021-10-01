<?php 
include ("../../seguridad/comprobar_login.php");

ini_set("max_execution_time","640");
$mensaje="";
$validacion=true;



// variables
$dbhost = 'localhost';
$dbname = 'modulalite';
$dbuser = 'root';
$dbpass = '';
 
$backup_file = $dbname. "-" .date("Y-m-d-H-i-s"). ".sql";
 $command= "C:\wamp\bin\mysql\mysql5.6.17\bin\mysqldump --opt --user=$dbuser $dbname > $backup_file";
system($command,$output);


if($output==0){
		$mensaje='exito@Operaci&oacute;n exitosa@El registro ha sido guardado';
		$mensaje=$mensaje.'
				</br>
				<p>
				</br>
        		<form action="descargar.php" method="post">
            		<input name="f" type="hidden" value="'.$backup_file.'"/>
					<button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;Descargar</button>
        		</form>
				</p>
			';
	}
	if($output==1){
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	}
	
	

echo utf8_encode($mensaje);

?>