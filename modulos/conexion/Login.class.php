<?php 
class Conexion{
	var $conect;
	var $BaseDatos;
	var $Servidor;
	var $Usuario;
	var $Clave;
	function Conexion(){
		$this->BaseDatos = "acem";
		$this->Servidor = "localhost";
		$this->Usuario = "root";
		$this->Clave = "";
	}
	 function conectar() {
		if(!($con=@mysql_connect($this->Servidor,$this->Usuario,$this->Clave))){
			echo"<center><h1>Error al conectar a la base de datos</h1></center>";	
			exit();
		}
		if (!@mysql_select_db($this->BaseDatos,$con)){
			echo "<center><h1>Error al seleccionar la base de datos</h1></center>"; 
			echo  $this->BaseDatos;
			echo "$HOSTNAME";
			exit();
		}
		$this->conect=$con;
		mysql_set_charset('utf8');
		return true;	
	}
}
?>
