<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include "../API/util.php";
	include "../API/query.php";
	
	$query = new query();
	$util = new util();
	
	
	$dato = json_decode($_POST["DATO"],true);
	
	if($dato["ID"] == ""){
		if($query->insert(array("TITULO"=>$dato["TITULO"],"CUERPO"=>$dato["CUERPO"],"DESDE"=>$util->tosqldate($dato["DESDE"]),"HASTA"=>$util->tosqldate($dato["HASTA"]),"COLOR"=>$dato["COLOR"],"ICONO"=>$dato["ICONO"],"ORIGEN"=>$_SESSION["SESION"][0]["ID"]),"EVENTO")){
			$ID = (array) $query->select(array("ID"),"EVENTO","order by ID desc limit 1")[0];
			
			foreach($dato["USUARIOS"] as $indice => $valor){
				$query->insert(array("USUARIO"=>$valor,"EVENTO"=>$ID["ID"]),"USUARIO_CALENDARIO");
			}
			$query->insert(array("USUARIO"=>$_SESSION["SESION"][0]["ID"],"EVENTO"=>$ID["ID"]),"USUARIO_CALENDARIO");
			$util->respuesta("success","Nuevo Evento Registrado");	
		}
	}else{
		if($query->update(array("TITULO"=>$dato["TITULO"],"CUERPO"=>$dato["CUERPO"],"DESDE"=>$util->tosqldate($dato["DESDE"]),"HASTA"=>$util->tosqldate($dato["HASTA"]),"COLOR"=>$dato["COLOR"],"ICONO"=>$dato["ICONO"]),"EVENTO",$dato["ID"])){
			if($query->elim($dato["ID"],"USUARIO_CALENDARIO","EVENTO")){
				foreach($dato["USUARIOS"] as $indice => $valor){
					$query->insert(array("USUARIO"=>$valor,"EVENTO"=>$dato["ID"]),"USUARIO_CALENDARIO");
				}
				$query->insert(array("USUARIO"=>$_SESSION["SESION"][0]["ID"],"EVENTO"=>$dato["ID"]),"USUARIO_CALENDARIO");
				$util->respuesta("success","Evento Editado");
			}
		}
		
	}
