<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../API/util.php";
include "../API/query.php";
	
$query = new query();
$util = new util();

$total = (array) $query->select(array("*"),"VRECIBIDO","where DESTINO = ".$_SESSION["SESION"][0]["ID"]." and ELIM = 0 and VISTO = 1");
$cont = 0;
foreach($total as $indice => $valor){
	$cont++;
}
echo $cont;
?>
