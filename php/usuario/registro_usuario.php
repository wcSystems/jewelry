<?php
//-- ---------------------- --//
include "../API/util.php";
include "../API/query.php";
	
$query = new query();
$util = new util();
	
$dato = json_decode($_POST["DATO"],true);

if($query->insert(array("NOMBRE"=>$dato["NOMBRE"],"APELLIDO"=>$dato["APELLIDO"],"EMAIL"=>$dato["EMAIL"],"USUARIO"=>$dato["NOMBRE"],"PASS"=>$dato["PASS"]),"USUARIO")){
	$id = (array) $query->select(array("ID"),"USUARIO","order by ID desc limit 1");
	
	foreach($dato["ACCESO"] as $indice => $valor){
		$query->insert(array("USUARIO"=>$id[0]["ID"],"MENU"=>$valor),"USUARIO_MENU");
	};
	$util->respuesta("success","usuario creado");
}else{
	$util->respuesta("error","Ocurrio un error al registrar el nuevo usuario");

};







?>
