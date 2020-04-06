<?php
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	$lista = (array) $query->select(array("*"),"CLIENTE");
	
	$util->respuesta("success",$lista);
?>
