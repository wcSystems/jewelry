<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../API/query.php";
	include "../API/util.php";
	
	$query = new query();
	$util = new util();
	
	$C = $_POST["C"];
	$MONTO = $_POST["DATO"];
	
	$DIAS = (array) $query->select(array("DIAS"),"VCONTRATO","where CONTRATO = ".$C)[0];
	$DIASA = $DIAS["DIAS"];
	if($DIAS["DIAS"] > 0)
	{
		if($query->insert(array("DIAS_PAGO"=>$DIASA,"MONTO"=>$MONTO,"FECHA"=>date("Y-m-d"),"CONCEPTO"=>2,"CONTRATO"=>$C),"PAGO"))
		{
			$VENCIMIENTO = (array) $query->select(array("VENCIMIENTO"),"CONTRATO","where ID = ".$C)[0];
			$VENCIMIENTO = $VENCIMIENTO["VENCIMIENTO"];
			
			$grabar = ($DIAS <= 30)? $VENCIMIENTO : date("Y-m-d");
			
			$vence = date('Y-m-d',strtotime('+30 days',strtotime($grabar))) . PHP_EOL;
			
			if($query->update(array("RENOVACION"=>$grabar,"VENCIMIENTO"=>$vence),"CONTRATO",$C))
			{
                $pago = (array) $query->select(array("ID"),"PAGO","where CONTRATO = ".$C." order by ID desc limit 1")[0];
				$util->respuesta("success",["mensaje" => "Interes Abonados correctamente, Por Favor reimprima el contrato","pago" => $pago["ID"]]);
			}
		}
	}
	else
	{
		if($query->insert(array("DIAS_PAGO"=>$DIASA,"MONTO"=>$MONTO,"FECHA"=>date("Y-m-d"),"CONCEPTO"=>1,"CONTRATO"=>$C),"PAGO"))
		{
            $pago = (array) $query->select(array("ID"),"PAGO","where CONTRATO = ".$C." order by ID desc limit 1")[0];
			$util->respuesta("success",["mensaje" => "Monto Abonado a Capital, Por Favor reimprima el contrato", "pago" => $pago["ID"]]);

		}

	}
	
	
	
?>
