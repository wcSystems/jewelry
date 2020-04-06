<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../API/query.php";
	include "../API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../API/parametro.php";
	include "../API/caja.php";
	
	$D = json_decode($_POST["DATO"],true);

	if(empty($D["SPLIT"]["DIFERENCIA"])){
		$presto = $D["PESO"] * $D["PRECIO"];
	}else{
		$presto = $D["PESO"] * $D["PRECIO"]-$D["SPLIT"]["DIFERENCIA"];
	}
	
	$Bbalance = $Bingreso - $Begreso;
	$Dbalance = $Dingreso - $Degreso;
	
	if($D["MONEDA"] == 1){
		$total = $Dbalance - $presto;
	}else{
		$total = $Bbalance - $presto;
	}
	if($total >= 0){
		if($query->insert(array("ARTICULO"=>$D["ARTICULO"],"DIMENSION"=>$D["PESO"],"DESCRIPCION"=>$D["DESCRIPCION"],"REMATE" => 1),"PIEZA")){
			$PIEZA = $query->select(array("ID"),"PIEZA","order by ID desc limit 1")[0];
			$PIEZA = $PIEZA["ID"];
			
			if($query->insert(array("PIEZA"=>$PIEZA,"CLIENTE"=>$D["CLIENTE"],"MONEDA"=>$D["MONEDA"],"PRECIO"=>$D["PRECIO"],"CONCEPTO"=>4,"FECHA"=>date("Y-m-d")),"COMERCIO")){
				
				$T = (array) $query->select(array("ID"),"COMERCIO","order by ID desc limit 1")[0];
				
					if (isset($D["SPLIT"]["DIFERENCIA"])){
						$query->insert(array("COMPRA"=>$T["ID"],"MONEDA"=>2,"DIFERENCIA"=>$D["SPLIT"]["DIFERENCIA"],"TAZA"=>$D["SPLIT"]["TAZA"]),"SPLIT");
					}
				
				$array = array(
					"MENSAJE"=>"Compra realizada correctamente",
					"ID" => $T["ID"]
				);
				
				$util->respuesta("success",$array);
			}
		}
	}else{

		$util->respuesta("error",array("MENSAJE"=>"No posee suficiente fondos para realizar la compra"));
	}
?>
