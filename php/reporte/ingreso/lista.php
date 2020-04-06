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
	$H = $_POST["HASTA"];
	
	$lista = (array) $query->select(array("*"),"MOVIMIENTO","where TIPO = 1 and FECHA BETWEEN '".$util->tosqldate($D)."' AND '".$util->tosqldate($H)."' AND ELIM = 0");
	
	$util->respuesta("success",$lista);
?>
