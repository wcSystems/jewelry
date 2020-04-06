<?php
session_start();
include "../API/util.php";
include "../API/query.php";

$query = new query();
$pass = $_GET["PASS"];

if($query->if_exist(array("ID"=>$_SESSION["SESION"][0]["ID"],"PASS"=>$pass),"USUARIO")){
	$_SESSION["SESION"][0]["LOCKEO"] = 0;
	header("Location: ../../index.php#ajax/inicio.php");

}else{
	header("Location: ../../index.php");

}
