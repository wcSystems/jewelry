<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../API/query.php";
	include "../../API/util.php";
	
	$query = new query();
	$util = new util();
	
	
	$lista = (array) $query->select(array("sum(DIMENSION) as TOTAL","ARTICULO"),"INVENTARIO","group by ARTICULO");
	
	foreach ($lista as $indice => $valor){
		$array[] = array(
			"ARTICULO"=>$valor["ARTICULO"],
			"GRAMOS"=>$valor["TOTAL"]
		);
	}
	
	echo json_encode($array);
?>
