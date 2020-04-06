<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include "../API/util.php";
	include "../API/query.php";
	
	$query = new query();
	$util = new util();
	
	$id = $_POST["DATO"];
	
	if($query->elim($id,"USUARIO_CALENDARIO","EVENTO")){
		if($query->elim($id,"EVENTO")){
			$util->respuesta("success","Event eliminado");
		}
	}
