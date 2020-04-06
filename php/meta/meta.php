<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../API/query.php";
	include "../API/util.php";
	
	$query = new query();
	$util = new util();
	
	$D = json_decode($_POST["DATO"],true);
	if(!$query->if_exist(array("MONEDA"=>$D["MONEDA"],"DEFINICION"=>$D["DEFINICION"],"PERIODO"=>$D["ANO"]."-".$D["MES"]."-01"),"VMETA")){
		if($query->insert(array("DEFINICION"=>$D["DEFINICION"],"ARTICULO"=>$D["ARTICULO"],"OBJETIVO"=>$D["OBJETIVO"],"MONEDA"=>$D["MONEDA"],"PERIODO"=>$D["ANO"]."-".$D["MES"]."-01","FECHA"=>date("Y-m-d")),"META")){
			$util->respuesta("success","Nueva meta asignada");
		}
	}else{
			$util->respuesta("error","Ya hay una meta igual para el mismo periodo");
	}
?>
