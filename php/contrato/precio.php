<?php
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	$A = $_POST["A"];
	$M = $_POST["M"];
	$I = $_POST["I"];
	
	$lista = (array) $query->select(array("PRECIO","PORCENTAJE"),"EARTICULO","where ID = ".$A." and MONEDA = ".$M." and PRECIO = ".$I)[0];
	
	$util->respuesta("success",$lista);
?>
