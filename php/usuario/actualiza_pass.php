<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include "../API/util.php";
	include "../API/query.php";
	$query = new query();
	$util = new util();
	
	$actual = $_POST["ACTUAL"];
	$nueva = $_POST["NUEVA"];
	
	if($query->if_exist(array("PASS"=>$actual,"ID"=>$_SESSION["SESION"][0]["ID"]),"USUARIO")){
		if($query->update(array("PASS"=>$nueva),"USUARIO",$_SESSION["SESION"][0]["ID"])){
			$util->respuesta("success","Contraseña actualizada");
		}else{
			$util->respuesta("error","Ha ocurrido un error");
		}
	}else{
		$util->respuesta("error","La contraseña ACTUAL introducida no es correcta");
	}
	
?>
