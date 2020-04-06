<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../API/query.php";
	include "../../API/util.php";
	
	$query = new query();
	$util = new util();
	
	$lista1 = (array) $query->select(array("sum(MONTO) as MONTO"),"VPAGO","where REMATE = 0 and CANCELADO = 0")[0];
	$lista2 = (array) $query->select(array("sum(TOTAL) as TOTAL"),"VCONTRATO","where REMATE = 0 and CANCELADO = 0")[0];
	$lista3 = (array) $query->select(array("sum(ENTREGADO) as ENTREGADO"),"VCONTRATO","where REMATE = 0 and CANCELADO = 0")[0];
	
	$array = array(array("CONCEPTO"=>"INVERTIDO","DOLARES"=>$lista3["ENTREGADO"]),array("CONCEPTO"=>"PROYECTADO","DOLARES"=>$lista2["TOTAL"]),array("CONCEPTO"=>"RECAUDADO","DOLARES"=>$lista1["MONTO"]),
	);
	
	echo json_encode($array);
?>
