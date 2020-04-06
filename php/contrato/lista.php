<?php
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	$lista = (array) $query->select(array("*"),"VCONTRATO");
	
	$util->respuesta("success",$lista);
?>
