<?php
	include "../../API/conexion.php";
	include "../../API/query.php";
	include "../../API/util.php";
	$query = new query();
	$util = new util();
	
	$dato = json_decode($_POST["DATO"],true);
	
	if($dato["ID"] == ""){
		if(!$query->if_exist(array("DESCRIPCION"=>$dato["DESCRIPCION"]),"ARTICULO")){
			if($query->insert(array("DESCRIPCION"=>$dato["DESCRIPCION"],"DEPOSITO"=>$dato["DEPOSITO"],"MEDIDA"=>$dato["MEDIDA"]),"ARTICULO")){
				$util->respuesta("success","Nuevo registro creado");
			}
		}else{
			$util->respuesta("error","Ya existe un registro con el mismo nombre");
		}
	}else{
		if($query->update(array("DESCRIPCION"=>$dato["DESCRIPCION"],"DEPOSITO"=>$dato["DEPOSITO"],"MEDIDA"=>$dato["MEDIDA"]),"ARTICULO",$dato["ID"])){
			$util->respuesta("success","Registro actualizado");
		}
	}
?>
