<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../API/util.php";
include "../API/query.php";
	
$query = new query();
$util = new util();
	
$dato = json_decode($_POST["DATO"],true);

if($query->update(array("NOMBRE"=>$dato["NOMBRE"],"APELLIDO"=>$dato["APELLIDO"],"EMAIL"=>$dato["EMAIL"],"USUARIO"=>$dato["NOMBRE"],"PASS"=>$dato["PASS"]),"USUARIO",$dato["ID"])){
	if($query->elim($dato["ID"],"USUARIO_MENU","USUARIO")){
		foreach($dato["ACCESO"] as $indice => $valor){
			$query->insert(array("USUARIO"=>$dato["ID"],"MENU"=>$valor),"USUARIO_MENU");
		};
		$util->respuesta("success","usuario Actualizado");
	};
}else{
	$util->respuesta("error","Ocurrio un error al registrar el nuevo usuario");
};
?>
