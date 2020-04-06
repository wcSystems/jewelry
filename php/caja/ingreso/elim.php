<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../API/query.php";
	include "../../API/util.php";
	
	$query = new query();
	$util = new util();
	
	$D = $_POST["DATO"];
	
	$A = (array) $query->select(array("FECHA"),"MOVIMIENTO","where ID = ".$D)[0];
	$A = $A["FECHA"];
	
	if(date("Y-m-d") == $A){
		$query->update(array("ELIM"=>1),"MOVIMIENTO",$D);

		$util->respuesta("success","Ingreso anulado correctamente");
	}else{
		$util->respuesta("error","Solo puede reincorporar Ingreso de Fecha actual");
	}
	
?>
