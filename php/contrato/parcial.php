<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../API/query.php";
	include "../API/util.php";
	
	$query = new query();
	$util = new util();
	
	$C = $_POST["C"];
	$DIASA = $_POST["DATO"];
	$MONTO = $_POST["MONTO"];
	
	$DIAS = (array) $query->select(array("DIAS"),"VCONTRATO","where CONTRATO = '".$C."' ")[0];
	$dura = (array) $query->select(array("DURACION"),"CONTRATO","where ID = '".$C."' ")[0];
	
	if($query->insert(array("DIAS_PAGO"=>$DIASA,"MONTO"=>$MONTO,"FECHA"=>date("Y-m-d"),"CONCEPTO"=>2,"CONTRATO"=>$C),"PAGO"))
	{
			$VENCIMIENTO = (array) $query->select(array("VENCIMIENTO"),"CONTRATO","where ID = '".$C."' ")[0];
			$VENCIMIENTO = $VENCIMIENTO["VENCIMIENTO"];
			
			$RENOVACION = (array) $query->select(array("RENOVACION"),"CONTRATO","where ID = '".$C."' ")[0];
			$RENOVACION = $RENOVACION["RENOVACION"];
			
			$renovacion = date('Y-m-d',strtotime('+'.$DIASA.' days',strtotime($RENOVACION))) . PHP_EOL;
			
			$vence = date('Y-m-d',strtotime('+'.$dura["DURACION"].' days',strtotime($renovacion))) . PHP_EOL;
			
			if($query->update(array("RENOVACION"=>$renovacion,"VENCIMIENTO"=>$vence),"CONTRATO",$C))
			{
				$util->respuesta("success","Interes Abonados correctamente, Por Favor reimprima el contrato");
			}
	}
	
	
	
	
?>
