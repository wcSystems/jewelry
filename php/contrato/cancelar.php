<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../API/query.php";
	include "../API/util.php";
	
	$query = new query();
	$util = new util();
	
	$C = $_POST["C"];
	$MONTO = str_replace(",","",$_POST["DATO"]);
	
	$DIAS = (array) $query->select(array("DIAS"),"VCONTRATO","where CONTRATO = ".$C)[0];
	$DIASA = $DIAS["DIAS"];

	if($query->insert(array("DIAS_PAGO"=>$DIASA,"MONTO"=>$MONTO,"FECHA"=>date("Y-m-d"),"CONCEPTO"=>3,"CONTRATO"=>$C),"PAGO"))
	{
		if($query->update(array("RENOVACION"=>date("Y-m-d"),"CANCELADO"=>1),"CONTRATO",$C))
		{
			$util->respuesta("success","Contrato Pagado y finalizado, Imprima el comprobante de cancelacion");
		}
	}
	
	
	
?>
