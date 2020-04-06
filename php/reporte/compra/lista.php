<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../API/query.php";
	include "../../API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../../API/parametro.php";
	
	$D = $_POST["DESDE"];
	$V = $_POST["HASTA"];
	
	$lista = (array) $query->select(array("*"),"VCOMPRA","where FECHA BETWEEN '".$util->tosqldate($D)."' and '".$util->tosqldate($V)."'");
	
	$util->respuesta("success",$lista);
?>
