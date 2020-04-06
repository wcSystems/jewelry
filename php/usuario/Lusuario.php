<?php
	session_start();
	include "../API/util.php";
	include "../API/query.php";
	
	$query = new query();
	$util = new util();

	$resp = (array) $query->select(array("*"),"USUARIO");
	
	$util->respuesta("success",$resp);
	
?>
