<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../API/util.php";
include "../API/query.php";
	
$query = new query();
$util = new util();

$destino = $_POST["DESTINO"];
$mensaje = $_POST["MENSAJE"];

$destino = str_replace("chat","",$destino);

$query->insert(array("DESTINO"=>$destino,"MENSAJE"=>$mensaje,"ORIGEN"=>$_SESSION["SESION"][0]["ID"]),"CHAT");

?>
