<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../API/util.php";
include "../API/query.php";
	
$query = new query();
$util = new util();

$e = $_POST["PARTNER"];
$e = str_replace("chat","",$e);

$temp["MENSAJE"] = (array) $query->select(array("*"),"VCHAT","where VISTO = 1 and (ORIGEN = ".$e." and DESTINO = ".$_SESSION["SESION"][0]["ID"].") or (ORIGEN = ".$_SESSION["SESION"][0]["ID"]." and DESTINO = ".$e.") order by FECHA desc limit 10");
$temp["MENSAJE"] = array_reverse($temp["MENSAJE"]);
$temp["ORIGEN"] = $e;
echo json_encode($temp);

?>
