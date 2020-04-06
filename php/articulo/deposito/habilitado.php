<?php
	include "../../API/conexion.php";
	include "../../API/query.php";
	include "../../API/util.php";
	$query = new query();
	$util = new util();
	
	$dato = $_POST["DATO"];
	$estado = $_POST["ESTADO"];
	
	if($query->update(array("HABILITADO"=>$estado),"DEPOSITO",$dato)){
		$util->respuesta("success","Registro Actualizado");
	}
?>
