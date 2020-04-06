<?php
	include "../../API/conexion.php";
	include "../../API/query.php";
	include "../../API/util.php";
	$query = new query();
	$util = new util();
	
	$dato = json_decode($_POST["DATO"],true);
	
	if($dato["ID"] == ""){
		if($query->insert(array("USO"=>$dato["USO"],"ARTICULO"=>$dato["ARTICULO"],"MONEDA"=>$dato["MONEDA"],"PRECIO"=>$dato["PRECIO"],"PORCENTAJE"=>$dato["PORCENTAJE"]),"PRECIO")){
			$util->respuesta("success","Nuevo registro creado");
		}
	}
?>
