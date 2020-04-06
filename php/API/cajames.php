<?php

	$BingresoM = 0;$BegresoM = 0;
	$DingresoM = 0;$DegresoM = 0;
	// Caja Dolares //
	$pagosM = (array) $query->select(array("SUM(MONTO) as MONTO"),"VPAGO","where MONEDA = 1 and ID != 92 and ID != 93 AND MONTH(FECHA) = MONTH(CURRENT_DATE)")[0];
	$DingresoM = $DingresoM + $pagosM["MONTO"];
	
	$ingresoM = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 1 and MONEDA = 1 AND MONTH(FECHA) = MONTH(CURRENT_DATE) and ELIM = 0")[0];
	$DingresoM = $DingresoM + $ingresoM["MONTO"];
	
	$ingresoM = (array) $query->select(array("SUM(PRECIO * DIMENSION) as MONTO"),"VVENTA","where MONEDA = 1 AND MONTH(FECHA) = MONTH(CURRENT_DATE)")[0];
	$DingresoM = $DingresoM + $ingresoM["MONTO"];
	
	$egresoM = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 2 and MONEDA = 1 AND MONTH(FECHA) = MONTH(CURRENT_DATE) and ELIM = 0")[0];
	$DegresoM = $DegresoM + $egresoM["MONTO"];
	
	$contratoM = (array) $query->select(array("SUM(ENTREGADO) as MONTO"),"VCONTRATO","where MONEDA = 1 AND MONTH(EMISION) = MONTH(CURRENT_DATE)")[0];
	$DegresoM = $DegresoM + $contratoM["MONTO"];
	
	$compraM = (array) $query->select(array("SUM((DIMENSION * PRECIO)- DIFERENCIA)  as MONTO"),"VCOMPRA","where MONEDA = 'DOLARES' AND ELIM = 0 AND MONTH(FECHA) = MONTH(CURRENT_DATE)")[0];
	$DegresoM = $DegresoM + $compraM["MONTO"];
	
	// Caja Bolivares //
	$pagosM = (array) $query->select(array("SUM(MONTO) as MONTO"),"VPAGO","where MONEDA = 2 and ID != 92 and ID != 93 AND MONTH(FECHA) = MONTH(CURRENT_DATE)")[0];
	$BingresoM = $BingresoM + $pagosM["MONTO"];
	
	$ingresoM = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 1 and MONEDA = 2 AND MONTH(FECHA) = MONTH(CURRENT_DATE) and ELIM = 0")[0];
	$BingresoM = $BingresoM + $ingresoM["MONTO"];
	
	$ingresoM = (array) $query->select(array("SUM(PRECIO * DIMENSION) as MONTO"),"VVENTA","where MONEDA = 2 AND MONTH(FECHA) = MONTH(CURRENT_DATE)")[0];
	$BingresoM = $BingresoM + $ingresoM["MONTO"];
	
	$egresoM = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 2 and MONEDA = 2 AND MONTH(FECHA) = MONTH(CURRENT_DATE) and ELIM = 0")[0];
	$BegresoM = $BegresoM + $egresoM["MONTO"];
	
	$contratoM = (array) $query->select(array("SUM(ENTREGADO) as MONTO"),"VCONTRATO","where MONEDA = 2 AND MONTH(EMISION) = MONTH(CURRENT_DATE)")[0];
	$BegresoM = $BegresoM + $contratoM["MONTO"];
	
	$compraM = (array) $query->select(array("SUM(DIMENSION * PRECIO) as MONTO"),"VCOMPRA","where MONEDA = 'BOLIVARES' AND ELIM = 0 AND MONTH(FECHA) = MONTH(CURRENT_DATE)")[0];
	$BegresoM = $BegresoM + $compraM["MONTO"];
	
	$compraM = (array) $query->select(array("SUM(DIFERENCIA * TAZA) as MONTO"),"VCOMPRA","where  ELIM = 0 AND MONTH(FECHA) = MONTH(CURRENT_DATE)")[0];
	$BegresoM = $BegresoM + $compraM["MONTO"];
	
?>
