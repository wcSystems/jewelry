<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../API/query.php";
	include "../../API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../../API/parametro.php";
	
	$lista = (array) $query->select(array("*"),"MOVIMIENTO","where TIPO = 1 and ELIM = 0 and FECHA = CURDATE()");
	
	$util->respuesta("success",$lista);
?>
