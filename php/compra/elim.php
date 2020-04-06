<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../API/query.php";
	include "../API/util.php";
	
	$query = new query();
	$util = new util();
	
	$D = $_POST["DATO"];
	
	$A = (array) $query->select(array("FECHA"),"COMERCIO","where ID = ".$D)[0];
	$A = $A["FECHA"];
	
	if(date("Y-m-d") == $A){
		$query->update(array("ELIM"=>1),"COMERCIO",$D);
		$P = (array) $query->select(array("PIEZA"),"COMERCIO","where ID = ".$D)[0];
		$query->update(array("ELIM"=>1),"PIEZA",$P["PIEZA"]);
		$util->respuesta("success","COMPRA anulada correctamente");
	}else{
		$util->respuesta("error","Solo puede reincorporar Compras de Fecha actual");
	}
	
?>
