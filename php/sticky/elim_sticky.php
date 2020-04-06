<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include "../API/util.php";
	include "../API/query.php";
	
	$query = new query();
	$util = new util();
	
	$dato = $_POST["DATO"];
	
	if($query->elim($dato,"USUARIO_ANOTADOR","ANOTADOR")){
		if($query->elim($dato,"ANOTADOR")){
			$util->respuesta("success","Nota eliminada");
		}
	}
?>
