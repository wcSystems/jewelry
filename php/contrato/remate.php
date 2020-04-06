<?php
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	
	$C = $_POST["C"];
	$P = $_POST["P"];
	
	if($query->update(array("REMATE"=>1),"CONTRATO",$C)){
		if($query->update(array("REMATE"=>1),"PIEZA",$P)){
			$util->respuesta("success","Contrato Rematado");
		}
	}
?>
