<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../API/util.php";
include "../API/query.php";
	
$query = new query();
$util = new util();

$respuesta["NOTAS"] = (array) $query->select(array("ID","TITULO","FOTO","CUERPO","FECHA","NOMBRE","APELLIDO"),"VANOTADOR","where AUTOR != ".$_SESSION["SESION"][0]["ID"]." and USUARIO = ".$_SESSION["SESION"][0]["ID"]." order by case when AUTOR = 1 then 0 else 1 end,FECHA desc");
$respuesta["PROPIAS"] = (array) $query->select(array("DISTINCT ID","TITULO","FOTO","CUERPO","FECHA","NOMBRE","APELLIDO"),"VANOTADOR","where AUTOR = ".$_SESSION["SESION"][0]["ID"]);
echo json_encode($respuesta);

?>
