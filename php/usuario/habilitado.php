<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../API/util.php";
include "../API/query.php";
	
$query = new query();
$util = new util();
	
$dato = $_POST["ID"];

$habilitado = (array) $query->select(array("HABILITADO"),"USUARIO","where ID = ".$dato);

if($habilitado[0]["HABILITADO"] == 0){ $habilitado = 1; }else{ $habilitado = 0;};

if($query->update(array("HABILITADO"=>$habilitado),"USUARIO",$dato)){
	$util->respuesta("success","Registro actualizado");
}else{
	$util->respuesta("error","No se puedo actualizar el registro");
};
?>
