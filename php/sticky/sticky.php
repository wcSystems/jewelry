<?php
session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include "../API/util.php";
	include "../API/query.php";
	
	$query = new query();
	$util = new util();

	$dato = json_decode($_POST["DATO"],true);
	$texto = $dato["TITULO"];
	include "../notificaciones/modelo.php";
	
	if($dato["ID"] == ""){
		if($query->insert(array("TITULO"=>$dato["TITULO"],"CUERPO"=>$dato["CUERPO"],"AUTOR"=>$_SESSION["SESION"][0]["ID"],"FECHA"=>date("Y-m-d"),"FOTO"=>$dato["FOTO"]),"ANOTADOR")){
			$ID = (array) $query->select(array("ID"),"ANOTADOR","order by ID desc limit 1")[0];
			foreach($dato["USUARIOS"] as $indice => $valor){
				$query->insert(array("NOTIFICACION"=>$sticky,"DESTINO"=>$valor),"NOTIFICACION");
				$query->insert(array("USUARIO"=>$valor,"ANOTADOR"=>$ID["ID"]),"USUARIO_ANOTADOR");
			}
			$util->respuesta("success","Nueva nota creada");
		}
		
	}else{
		if($query->update(array("TITULO"=>$dato["TITULO"],"CUERPO"=>$dato["CUERPO"],"FOTO"=>$dato["FOTO"]),"ANOTADOR",$dato["ID"])){
			$query->elim($dato["ID"],"USUARIO_ANOTADOR","ANOTADOR");
			foreach($dato["USUARIOS"] as $indice => $valor){
				$query->insert(array("USUARIO"=>$valor,"ANOTADOR"=>$dato["ID"]),"USUARIO_ANOTADOR");
			}
			$util->respuesta("success","Nota editada");
		}
		
	}




?>
