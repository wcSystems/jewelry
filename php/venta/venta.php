<?php
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	$dato = json_decode($_POST["DATO"],true);
	
	if($query->insert(array("CLIENTE"=>$dato["CLIENTE"],"FECHA"=>date("Y-m-d")),"VENTA")){
		$V = (array) $query->select(array("ID"),"VENTA","order by ID desc limit 1")[0];
		$V = $V["ID"];
		
		foreach($dato["PIEZAS"] as $i => $v){
			$temp = (array) $query->select(array("ID"),"INVENTARIO"," where VENDER = 1 and CODIGO = ".$i);
			
			foreach($temp as $indice => $valor){
				if($query->update(array("VENDIDO"=>1),"PIEZA",$valor["ID"])){
					$query->insert(array("VENTA"=>$V,"PIEZA"=>$valor["ID"],"PRECIO"=>$v["PRECIO"],"MONEDA"=>$v["MONEDA"]),"VENTA_PIEZA");
				}
			}
		}
		$util->respuesta("success","Venta ejecutada con exito");
	}
	
	
?>
