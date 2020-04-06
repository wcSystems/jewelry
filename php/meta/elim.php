<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../API/query.php";
	include "../API/util.php";
	
	$query = new query();
	$util = new util();
	
	$D = $_POST["DATO"];
	
		$query->update(array("ELIM"=>1),"META",$D);
		$util->respuesta("success","META eliminada correctamente");
	
?>
