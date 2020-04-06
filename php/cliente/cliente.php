<?php

	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	$dato = json_decode($_POST["DATO"],true);
	
	if($dato["ID"] == ""){
		if(!$query->if_exist(array("DOCUMENTO"=>$dato["DOCUMENTO"]),"CLIENTE")){
			if($query->insert(array("DOCUMENTO"=>$dato["DOCUMENTO"],"NOMBRE"=>strtoupper($dato["NOMBRE"]),"APELLIDO"=>strtoupper($dato["APELLIDO"]),"DIRECCION"=>$dato["DIRECCION"],"EMAIL"=>$dato["EMAIL"],"TELEFONO"=>$dato["TELEFONO"],"NACIONALIDAD"=>$dato["NACIONALIDAD"],"PROFESION"=>$dato["PROFESION"],"CIVIL"=>$dato["CIVIL"]),"CLIENTE")){
				$T = (array) $query->select(array("ID"),"CLIENTE","WHERE DOCUMENTO = '".$dato["DOCUMENTO"]."'")[0];
				
				$array = array(
					"ID"=>$T["ID"],
					"NOMBRE"=>$dato["NOMBRE"],
					"APELLIDO"=>$dato["APELLIDO"],
					"EMAIL"=>$dato["EMAIL"]
				);
				$resp = array(
					"MENSAJE"=>"Nuevo cliente registrado",
					"CLIENTE"=>$array
					
				);
				
				$util->respuesta("success",$resp);
			}
		}else{
			$util->respuesta("error",array("MENSAJE"=>"Ya existe un cliente con el mismo documento","CLIENTE"=>""));
		}
	}else{
		if($query->update(array("DOCUMENTO"=>$dato["DOCUMENTO"],"NOMBRE"=>strtoupper($dato["NOMBRE"]),"APELLIDO"=>strtoupper($dato["APELLIDO"]),"DIRECCION"=>$dato["DIRECCION"],"EMAIL"=>$dato["EMAIL"],"TELEFONO"=>$dato["TELEFONO"],"NACIONALIDAD"=>$dato["NACIONALIDAD"],"PROFESION"=>$dato["PROFESION"],"CIVIL"=>$dato["CIVIL"]),"CLIENTE",$dato["ID"])){
			$util->respuesta("success",array("MENSAJE"=>"Cliente actualizado","CLIENTE"=>""));
		}
	}
?>
