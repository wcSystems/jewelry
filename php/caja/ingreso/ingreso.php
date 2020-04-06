<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../API/query.php";
	include "../../API/util.php";
	
	$query = new query();
	$util = new util();
	
	$D = json_decode($_POST["DATO"],true);
	
	if($query->insert(array("TIPO"=>1,"CONCEPTO"=>$D["CONCEPTO"],"DESCRIPCION"=>$D["DESCRIPCION"],"MONEDA"=>$D["MONEDA"],"MONTO"=>$D["MONTO"],"FECHA"=>date("Y-m-d")),"MOVIMIENTO")){
		$util->respuesta("success","Movimeinto Ingresado en Caja correctamente");
	}
	
	
?>
