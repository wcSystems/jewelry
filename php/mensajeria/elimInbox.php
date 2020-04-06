<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../API/util.php";
include "../API/query.php";
	
$query = new query();
$util = new util();

$dato = json_decode($_POST["DATO"],true);
$objetivo = $_POST["OBJETIVO"];

switch($objetivo){
	case "INBOX":
		foreach($dato as $indice => $valor){
			$ID = (array) $query->select(array("ID"),"BUZON","where EMAIL = ".$valor." and DESTINO = ".$_SESSION["SESION"][0]["ID"])[0]["ID"];
			$query->update(array("ELIM"=>1),"BUZON",$ID[0]);
		}
		echo "ok";
	break;
};
?>
