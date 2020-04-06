<?php
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	$id = $_POST["DATO"];
	$M = $_POST["MONEDA"];
	
	$lista = (array) $query->select(array("PORCENTAJE","PRECIO,ID"),"EARTICULO","where ID = ".$id." and MONEDA = ".$M);
	
	$util->respuesta("success",$lista);
?>
