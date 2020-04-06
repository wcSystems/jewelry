<?php
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	$lista = json_decode($_POST["DATO"],true);

	$query->insert(array("FECHA"=>date("Y-m-d")),"RETIROV");
	$RETIROV = (array) $query->select(array("ID"),"RETIROV","order by ID desc limit 1")[0];
	$RETIROV = $RETIROV["ID"];

	foreach($lista as $indice => $valor){
		$query->insert(array("VENTA"=>$RETIROV,"PIEZA"=>$valor),"RETIROPV");
		$query->update(array("VENDER"=>1),"PIEZA",$valor);
	}

	$util->respuesta("success","Se han enviado nuevos articulos a la venta correctamente");
?>
