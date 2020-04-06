<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../API/query.php";
	include "../../API/util.php";
	
	$query = new query();
	$util = new util();
	
	$lista = (array) $query->select(array("*"),"RETIROV");
	
	$util->respuesta("success",$lista);
?>
