<?php
	include "../../API/conexion.php";
	include "../../API/query.php";
	include "../../API/util.php";
	$query = new query();
	$util = new util();
	
	$dato = $_POST["DATO"];
	
	if($query->elim($dato,"DEPOSITO")){
		$util->respuesta("success","Registro eliminado");
	}
?>
