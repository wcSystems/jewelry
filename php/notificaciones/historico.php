<?php
session_start();
include "../conexion.php";
include "../API/util.php";
include "../API/query.php";
$query = new query();
$util = new util();


$resp = (array) $query->select(array("ID","NOTIFICACION"),"NOTIFICACION","where DESTINO = ".$_SESSION["SESION"][0]["ID"]." and VISTO = 1 and ELIM = 0 limit 10");

echo json_encode($resp);


?>
