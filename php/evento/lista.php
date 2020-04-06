<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include "../API/util.php";
	include "../API/query.php";
	
	$query = new query();
	$util = new util();
	
	$mes = $_POST["MES"];
	$ano = $_POST["ANO"];
	
	$resp = (array) $query->select(array("*"),"VEVENTO","where USUARIO = ".$_SESSION["SESION"][0]["ID"]." and (MONTH(DESDE) = '".$mes."' and YEAR(DESDE) = '".$ano."') AND  (MONTH(HASTA) = '".$mes."' and YEAR(HASTA) = '".$ano."')");
	
	echo json_encode($resp);
