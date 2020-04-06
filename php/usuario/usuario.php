<?php
	//-- ---------------------- --//
	include "../API/util.php";
	include "../API/query.php";
	
	$query = new query();
	$util = new util();
	
	$respuesta = (array) $query->select(array("*"),"USUARIO");
	
	$util->respuesta("SUCCESS",$respuesta);
?>
