<?php
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	$id = $_POST["DATO"];
	
	$lista = (array) $query->select(array("distinct MONEDA"),"EARTICULO","where ID = ".$id);
	
	$util->respuesta("success",$lista);
?>
