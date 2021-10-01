<?php 
class Conexion{
	var $conect;
	var $BaseDatos;
	var $Servidor;
	var $Usuario;
	var $Clave;
	function Conexion(){
		if (isset($_SESSION['empresa'])){
			$empresa=$_SESSION['empresa'];
		}else{
			session_start();
			$empresa=$_SESSION['empresa'];
		}
		$this->BaseDatos = "imodulac_modulacrm";
		$this->Servidor = "localhost";
		$this->Usuario = "imodulac_root";
		$this->Clave = "kenzzo1988";
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
		mysqli_set_charset($con,'utf8');
		return true;	
	}
}
?>
