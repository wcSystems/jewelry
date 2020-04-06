<?php
	include "../../API/conexion.php";
	include "../../API/query.php";
	include "../../API/util.php";
	$query = new query();
	$util = new util();
	
	$ID = $_POST["DATO"];
	$USO = $_POST["USO"];
	
	$lista = (array) $query->select(array("*"),"PRECIO","where ELIM = 0 and USO = ".$USO." and ARTICULO = ".$ID);
	
	$util->respuesta("success",$lista);
?>
