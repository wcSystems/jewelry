<?php
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	$A = $_POST["A"];
	$M = $_POST["M"];
	
	$lista = (array) $query->select(array("PRECIO"),"CARTICULO","where ID = ".$A." and MONEDA = ".$M."");
	
	$util->respuesta("success",$lista);
?>
