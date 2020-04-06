<?php
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	$dato = json_decode($_POST["DATO"],true);
	
	if($query->insert(array("FECHA"=>date("Y-m-d")),"RETIRO")){
		$RETIRO = (array) $query->select(array("ID"),"RETIRO","order by ID desc limit 1")[0];
		$RETIRO = $RETIRO["ID"];
		
		foreach($dato as $indice => $valor){
			if($query->insert(array("RETIRO"=>$RETIRO,"PIEZA"=>$valor),"RETIRO_PIEZA")){
				$query->update(array("RETIRO"=>1),"PIEZA",$valor);
			}
		}
	}
	
	$util->respuesta("success","Piezas retiradas de stock correctamente");
	
	
?>
