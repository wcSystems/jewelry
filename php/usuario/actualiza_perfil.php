<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include "../API/util.php";
	include "../API/query.php";
	$query = new query();
	$util = new util();
	
	$columna = $_POST["name"];
	$valor = $_POST["value"];
	
	if($query->update(array($columna=>$valor),"USUARIO",$_SESSION["SESION"][0]["ID"])){
		$util->respuesta("success","Datos actualizados");
		
	}
?>
