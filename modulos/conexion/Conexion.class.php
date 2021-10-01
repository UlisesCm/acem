<?php 
class Conexion{
	var $conect;
	var $BaseDatos;
	var $Servidor;
	var $Usuario;
	var $Clave;
	function __construct(){
		if (isset($_SESSION['empresa'])){
			$empresa=$_SESSION['empresa'];
		}else{
			session_start();
			$empresa=$_SESSION['empresa'];
		}
		
		$this->BaseDatos = "acem";
		$this->Servidor = "localhost";
		$this->Usuario = "root";
		$this->Clave = "";
	}

	 function conectar() {
		if(!($con=mysqli_connect($this->Servidor,$this->Usuario,$this->Clave,$this->BaseDatos))){
			echo"<center><h1>Error al conectar a la base de datos</h1></center>";	
			exit();
		}
		$this->conect=$con;
		mysqli_set_charset($con,'utf8');
		return true;	
	}
	
	//Funcion que genera una clave aleatoria
	function generarClave($numero){
		usleep(10);
		$sufijo=date("zyGis");
		$rand="";
		$caracter= "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$numero; $i++) {
			$rand.= $caracter[rand()%strlen($caracter)];
		}
		return $sufijo.$rand;
	}
	
	//Funcion que genera una clave aleatoria
	function generarClave2($numero){
		usleep(10);
		$sufijo=date("zyGis");
		
		$rand="";
		$caracter= "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$numero; $i++) {
			$rand.= $caracter[rand()%strlen($caracter)];
		}
		$microsegundos=microtime()*1000000;
		return $sufijo.$rand.$microsegundos;
	}
}
?>