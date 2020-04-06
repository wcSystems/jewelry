<?php
	include "../../API/conexion.php";
	include "../../API/query.php";
	include "../../API/util.php";
	$query = new query();
	$util = new util();
	
	
	$R = $_POST["RANGO"];
	$V = $_POST["VALOR"];
	
	$lista = (array) $query->select(array("*"),"VCONTRATO"," where DIAS ".$R." ".$V);
	
	$util->respuesta("success",$lista);
?>
