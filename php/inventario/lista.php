<?php
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	$lista = (array) $query->select(array("*"),"INVENTARIO","where VENDER = 0");
	
	$util->respuesta("success",$lista);
?>
