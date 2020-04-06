<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include "../API/util.php";
include "../API/query.php";


$_SESSION["SESION"][0]["LOCKEO"] = 1;

header("Location: ../../index.php");

?>
