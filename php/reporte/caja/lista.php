<?php
	include "../../API/conexion.php";
	include "../../API/query.php";
	include "../../API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../../API/parametro.php";
	
	$D = $_POST["DATO"];
	$lista = array();
	
	$temp = $query->select(array("*"),"VPAGO","where FECHA = '".$util->tosqldate($D)."' and ID != 92 and ID != 93");
	
	foreach($temp as $indice => $valor){
		
		$T = ($valor["ELIM"] == 0)?"EJECUTADO":"ANULADO";
		$lista[] = array(
			"CONCEPTO" => $valor["DESCRIPCION"],
			"DESCRIPCION" => $cliente[$valor["CLIENTE"]]["NOMBRE"]." ".$cliente[$valor["CLIENTE"]]["APELLIDO"],
			"MONEDA" => $moneda[$valor["MONEDA"]]["DESCRIPCION"],
			"MONTO" => $valor["MONTO"],
			"MOVIMIENTO" => "ENTRADA",
			"ESTADO" => $T
		);
	}
	
	$temp = $query->select(array("*"),"VCOMPRA","where FECHA = '".$util->tosqldate($D)."'");
	
	foreach($temp as $indice => $valor){
		$T = ($valor["ELIM"] == 0)?"EJECUTADO":"ANULADO";
		$lista[] = array(
			"CONCEPTO" => "COMPRA",
			"DESCRIPCION" => $valor["DESCRIPCION"]." ".$valor["DIMENSION"]." ".$valor["MEDIDA"],
			"MONEDA" => $valor["MONEDA"],
			"MONTO" => ($valor["PRECIO"]*$valor["DIMENSION"]) - $valor["DIFERENCIA"],
			"MOVIMIENTO" => "SALIDA",
			"ESTADO" => $T
		);
		
		$temp2 = $query->select(array("*"),"VCOMPRA","where ID = ".$valor["ID"]." and FECHA = '".$util->tosqldate($D)."' and DIFERENCIA != 0.00 and TAZA != 0.00");
		
		foreach($temp2 as $indice2 => $valor2){
			$lista[] = array(
				"CONCEPTO" => "SPLIT",
				"DESCRIPCION" => $valor2["DESCRIPCION"]." ".$valor2["DIMENSION"]." ".$valor2["MEDIDA"],
				"MONEDA" => "BOLIVARES",
				"MONTO" =>  $valor2["DIFERENCIA"] * $valor2["TAZA"],
				"MOVIMIENTO" => "SALIDA",
				"ESTADO" => ""
			);

		}
	}
	
	$movi = array(6=>"ABONO CAPITAL",7=>"RETIRO CAPITAL");
	$eti = array(1=>"ENTRADA",2=>"SALIDA");
	
	$temp = $query->select(array("*"),"MOVIMIENTO","where FECHA = '".$util->tosqldate($D)."' and ELIM = 0");
	
	foreach($temp as $indice => $valor){
		
		$T = ($valor["ELIM"] == 0)?"EJECUTADO":"ANULADO";
		$lista[] = array(
			"CONCEPTO" => $movi[$valor["CONCEPTO"]],
			"DESCRIPCION" => $valor["DESCRIPCION"],
			"MONEDA" => $moneda[$valor["MONEDA"]]["DESCRIPCION"],
			"MONTO" => $valor["MONTO"],
			"MOVIMIENTO" => $eti[$valor["TIPO"]],
			"ESTADO" => $T
		);
	}
	
	$temp = $query->select(array("*"),"VCONTRATO","where EMISION = '".$util->tosqldate($D)."'");
	
	foreach($temp as $indice => $valor){
		$lista[] = array(
			"CONCEPTO" => "CONTRATO",
			"DESCRIPCION" => $valor["CLIENTE"],
			"MONEDA" => $moneda[$valor["MONEDA"]]["DESCRIPCION"],
			"MONTO" => $valor["ENTREGADO"],
			"MOVIMIENTO" => "SALIDA",
			"ESTADO" => "EJECUTADO"
		);
	}
	
	$temp = $query->select(array("DESCRIPCION","sum(MONTO) as MONTO","MONEDA"),"VVENTA","where FECHA = '".$util->tosqldate($D)."' group by DESCRIPCION,MONEDA");
	
	foreach($temp as $indice => $valor){
		$lista[] = array(
			"CONCEPTO" => "VENTA",
			"DESCRIPCION" => $valor["DESCRIPCION"],
			"MONEDA" => $moneda[$valor["MONEDA"]]["DESCRIPCION"],
			"MONTO" => $valor["MONTO"],
			"MOVIMIENTO" => "ENTRADA",
			"ESTADO" => "EJECUTADO"
		);
	}
	
	$util->respuesta("success",$lista);
?>
