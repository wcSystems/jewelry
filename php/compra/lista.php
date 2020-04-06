<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../API/query.php";
	include "../API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../API/parametro.php";
	
	$temp = $query->select(array("*"),"VCOMPRA","where  ELIM = 0");
	
	foreach($temp as $indice => $valor){
		$lista[] = array(
		"ID" => $valor["ID"],
			"CONCEPTO" => "COMPRA",
			"ARTICULO" => $valor["DESCRIPCION"],
			"DIMENSION" => $valor["DIMENSION"],
			"MEDIDA" => $valor["MEDIDA"],
 			"DESCRIPCION" => $valor["DESCRIPCION"]." ".$valor["DIMENSION"]." ".$valor["MEDIDA"],
			"MONEDA" => $valor["MONEDA"],
			"MONTO" => ($valor["PRECIO"]*$valor["DIMENSION"]) - $valor["DIFERENCIA"],
			"MOVIMIENTO" => "SALIDA",
			"CLIENTE" => $valor["CLIENTE"],
			"FECHA" => $valor["FECHA"]
		);
		
		$temp2 = $query->select(array("*"),"VCOMPRA","where ID = ".$valor["ID"]." and FECHA = CURDATE() and ELIM = 0 and DIFERENCIA != 0.00 and TAZA != 0.00");
		
		foreach($temp2 as $indice2 => $valor2){
			$lista[] = array(
			"ID" => $valor["ID"],
				"CONCEPTO" => "SPLIT",
				"CLIENTE" => $valor["CLIENTE"],
				"ARTICULO" => $valor["DESCRIPCION"],
			"DIMENSION" => $valor["DIMENSION"],
			"MEDIDA" => $valor["MEDIDA"],
				"DESCRIPCION" => $valor2["DESCRIPCION"]." ".$valor2["DIMENSION"]." ".$valor2["MEDIDA"],
				"MONEDA" => "BOLIVARES",
				"MONTO" =>  $valor2["DIFERENCIA"] * $valor2["TAZA"],
				"MOVIMIENTO" => "SALIDA",
				"FECHA" => $valor["FECHA"]
			);

		}
	}
	
	$util->respuesta("success",$lista);
?>
