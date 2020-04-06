<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../API/util.php";
include "../API/query.php";
	
$query = new query();
$util = new util();

$temp["CHAT"] = (array) $query->select(array("*"),"VCHAT","where VISTO = 0 and DESTINO = ".$_SESSION["SESION"][0]["ID"]);
$temp["ESTADO"] = (array) $query->select(array("ID","ESTADO"),"USUARIO","where ID != ".$_SESSION["SESION"][0]["ID"]);
//$temp["HISTORIAL"] = (array) $query->select(array("*"),"VCHAT","where VISTO = 1 and (ORIGEN = ".$destino." and DESTINO = ".$_SESSION["SESION"][0]["ID"].") or (ORIGEN = ".$_SESSION["SESION"][0]["ID"]." and DESTINO = ".$destino.") order by FECHA asc limit 10");
$query->update(array("VISTO"=>1),"CHAT",$_SESSION["SESION"][0]["ID"],"DESTINO");

$util->respuesta("success",$temp);

?>
