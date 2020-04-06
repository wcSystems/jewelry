<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../../php/API/util.php";
include "../../php/API/query.php";
	
$query = new query();
$util = new util();

$correos = (array) $query->select(array("*"),"VENVIADO","where ORIGEN = ".$_SESSION["SESION"][0]["ID"]."  group by ID order by FECHA desc");
$e = "D";
$d = "detalle_enviado";
require "vista.php";
?>
