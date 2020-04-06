<?php
session_start();
include "../conexion.php";
include "../API/util.php";
include "../API/query.php";
$query = new query();
$util = new util();

$query->update(array("VISTO"=>1),"NOTIFICACION",$_SESSION["SESION"][0]["ID"],"DESTINO");

?>
