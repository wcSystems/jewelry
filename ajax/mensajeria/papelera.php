<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../../php/API/util.php";
include "../../php/API/query.php";
	
$query = new query();
$util = new util();

$correos = (array) $query->select(array("*"),"VRECIBIDO","where DESTINO = ".$_SESSION["SESION"][0]["ID"]." and ELIM = 1 order by FECHA desc");
$e = "O";
$d = "detalle_recibido";
require "vista.php";
?>
