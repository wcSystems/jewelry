<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../API/query.php";
	include "../API/util.php";
	
	$query = new query();
	$util = new util();
	
	$D = $_POST["DATO"];
	
	$A = (array) $query->select(array("FECHA"),"PAGO","where ID = ".$D)[0];
	$A = $A["FECHA"];
	
	if(date("Y-m-d") == $A)
	{
		

		$CONTRATO = (array) $query->select(array("CONTRATO"),"PAGO","where ID = '".$D."' ")[0];
		$CONTRATO = $CONTRATO["CONTRATO"];

		$DIAS_PAGO = (array) $query->select(array("DIAS_PAGO"),"PAGO","where ID = '".$D."' ")[0];
		$DIAS_PAGO = $DIAS_PAGO["DIAS_PAGO"];

		//RENOVACION DE CONTRATO
		$RENOVACION = (array) $query->select(array("RENOVACION"),"CONTRATO","where ID = '".$CONTRATO."' ")[0];
		$RENOVACION = $RENOVACION["RENOVACION"];

		//VENCIMIENTO DE CONTRATO
		$VENCIMIENTO = (array) $query->select(array("VENCIMIENTO"),"CONTRATO","where ID = '".$CONTRATO."' ")[0];
		$VENCIMIENTO = $VENCIMIENTO["VENCIMIENTO"];

		//DEVOLVER LOS DIAS AL CONTRATO
		$RENOVACION = strtotime($RENOVACION. ' -'.$DIAS_PAGO.' days');
		$RENOVACION = date("Y-m-d", $RENOVACION);
		
		
		$VENCIMIENTO = strtotime($VENCIMIENTO. ' -'.$DIAS_PAGO.' days');
    	$VENCIMIENTO = date("Y-m-d", $VENCIMIENTO);

		//cambio
		$query->update(array("RENOVACION"=>$RENOVACION,"VENCIMIENTO"=>$VENCIMIENTO),"CONTRATO",$CONTRATO);



		//$FECHA = (array) $query->select(array("FECHA"),"PAGO","WHERE CONTRATO = ".$CONTRATO." order by ID desc limit 1")[0];
		//$FECHA = $FECHA["FECHA"];
		

		//$vence = date('Y-m-d',strtotime('+'.$DFGDF.' days',strtotime($FECHA))) . PHP_EOL;




		




		//$util->respuesta("success","Pago anulado correctamente");
		echo json_encode($VENCIMIENTO);
		$query->update(array("ELIM"=>1),"PAGO",$D);
		$query->update(array("CANCELADO"=>0),"CONTRATO",$CONTRATO);
	}
	else
	{
		$util->respuesta("error","Solo puede reincorporar Pagos de Fecha actual");
	}
	
?>
