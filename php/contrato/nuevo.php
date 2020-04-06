<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../API/caja.php";
	
	$D = json_decode($_POST["DATO"],true);
	$presto = $D["PESO"] * $D["PRECIO"];
	
	$Bbalance = $Bingreso - $Begreso;
	$Dbalance = $Dingreso - $Degreso;
	
	if($D["MONEDA"] == 1){
		$total = $Dbalance - $presto;
	}else{
		$total = $Bbalance - $presto;
	}
	if($total > 0){
		if($query->insert(array("CLIENTE"=>$D["CLIENTE"],"MONEDA"=>$D["MONEDA"],"DURACION"=>$D["DURACION"],"EMISION"=>$util->tosqldate($D["EMISION"]),"VENCIMIENTO"=>$util->tosqldate($D["VENCIMIENTO"]),"RENOVACION"=>$util->tosqldate($D["EMISION"])),"CONTRATO")){
			$CONTRATO = (array) $query->select(array("ID"),"CONTRATO","order by ID desc limit 1")[0];
			if($query->insert(array("ARTICULO"=>$D["ARTICULO"],"DIMENSION"=>$D["PESO"],"DESCRIPCION"=>$D["DESCRIPCION"]),"PIEZA")){
				$PIEZA = (array) $query->select(array("ID"),"PIEZA","order by ID desc limit 1")[0];
				if($query->insert(array("CONTRATO"=>$CONTRATO["ID"],"PIEZA"=>$PIEZA["ID"],"PRECIO"=>$D["PRECIO"],"PORCENTAJE"=>$D["PORCENTAJE"]),"CONTRATO_PIEZA")){
					$array = array(
						"MENSAJE" => "Nuevo contrato emitido correctamente",
						"CONTRATO" => $CONTRATO["ID"]
					);
					
					
					$util->respuesta("success",$array);
				}
			}
		}
	}else{
		$util->respuesta("error",array("MENSAJE"=>"No posee el capital suficientepara generar el contrato"));
	}
?>
