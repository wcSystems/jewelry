<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include "../API/util.php";
	include "../API/query.php";
	
	
	$query = new query();
	$util = new util();
	
	$dato = json_decode($_POST["DATO"],true);
	$texto = $dato["ASUNTO"];
	include "../notificaciones/modelo.php";
	
	
	
	if($query->insert(array("ASUNTO"=>$dato["ASUNTO"],"CUERPO"=>$dato["CUERPO"],"ORIGEN"=>$_SESSION["SESION"][0]["ID"]),"EMAIL")){
		$EMAIL = (array) $query->select(array("ID"),"EMAIL","order by ID desc limit 1")[0]["ID"];
		foreach($dato["ADJUNTO"] as $indice => $valor){
			$query->insert(array("ARCHIVO"=>$valor,"EMAIL"=>$EMAIL[0],"TIPO"=>"FILE"),"ADJUNTO");
		};
		foreach($dato["DESTINO"] as $indice => $valor){
			$query->insert(array("EMAIL"=>$EMAIL[0],"DESTINO"=>$valor),"BUZON");
			$query->insert(array("NOTIFICACION"=>$correo,"DESTINO"=>$valor),"NOTIFICACION");
		};
		$util->respuesta("success","Mensaje Enviado");
	}else{
		$util->respuesta("success","Ha ocurrido un error y no se pudo enviar el mensaje");
	}
?>
