<?php
	include "../../API/conexion.php";
	include "../../API/query.php";
	include "../../API/util.php";
	$query = new query();
	$util = new util();

	include "../../php/API/parametro.php";
	
	
	$f1 = $_POST["f1"];
	$f2 = $_POST["f2"];
	
	if($_POST["f1"] != '' && $_POST["f2"] != ''){
		$variable =  "AND VENCIMIENTO BETWEEN '".$f1."' and '".$f2."'";
	}else {
		$variable = '';
	}
	$lista = (array) $query->select(array("*"),"VCONTRATO"," where REMATE = 1 ". $variable);
	
	$arr = [];
	foreach ($lista as $key => $value) {
		$detalle = (array) $query->select(array("*"),"CONTRATO_PIEZA","where CONTRATO = ".$value['CONTRATO'])[0];
		$pieza = (array) $query->select(array("*"),"PIEZA","where ID = ".$detalle["PIEZA"])[0];
		$value['vecesPago'] = count((array) $query->select(array("id"),"VPAGO","where CONTRATO = ".$value['CONTRATO']));
		$value['PIEZA'] = $pieza["DIMENSION"];
		array_push($arr,$value);
	}



	$util->respuesta("success",$arr);
?>
