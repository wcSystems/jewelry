<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	$puntuacion["CONTRATO"] = 0;
	$puntuacion["COMPRA"] = 0;
	
	$ID = $_POST["DATO"];
	
	$cont = (array) $query->select(array("REMATE","CANCELADO"),"CONTRATO","where CLIENTE = ".$ID);
	
	foreach($cont as $indice => $valor){
		if($valor["REMATE"] == 1){$puntuacion["CONTRATO"] = $puntuacion["CONTRATO"] - 3;};
		if($valor["CANCELADO"] == 1){$puntuacion["CONTRATO"] = $puntuacion["CONTRATO"] + 3;};
	};
	
	$cont = (array) $query->select(array("count(*) as TOTAL"),"VPAGO","where  DESCRIPCION = 'RENOVACION' and CLIENTE = ".$ID);
	
	foreach($cont as $indice => $valor){
		$puntuacion["CONTRATO"] = $puntuacion["CONTRATO"] + $valor["TOTAL"];
	};
	
	$cont = (array) $query->select(array("count(*) as TOTAL"),"COMERCIO","where CONCEPTO = 4 and ELIM = 0 and CLIENTE = ".$ID);
	
	foreach($cont as $indice => $valor){
		$puntuacion["COMPRA"] = $puntuacion["COMPRA"] + $valor["TOTAL"];
	};
	
	$lista["LABEL"] = ["COMPRA","CONTRATO"];
	$lista["DATO"] = [$puntuacion["COMPRA"],$puntuacion["CONTRATO"]];
	
	$util->respuesta("success",$lista);
?>
