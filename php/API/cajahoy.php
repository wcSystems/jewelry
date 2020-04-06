<?php

	$BingresoH = 0;$BegresoH = 0;
	$DingresoH = 0;$DegresoH = 0;
	// Caja Dolares //
	$pagosH = (array) $query->select(array("SUM(MONTO) as MONTO"),"VPAGO","where MONEDA = 1 and ID != 92 and ID != 93 AND FECHA = CURDATE()")[0];
	$DingresoH = $DingresoH + $pagosH["MONTO"];
	
	$ingresoH = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 1 and MONEDA = 1 AND FECHA = CURDATE() and ELIM = 0")[0];
	$DingresoH = $DingresoH + $ingresoH["MONTO"];
	
	$ingresoH = (array) $query->select(array("SUM(PRECIO * DIMENSION) as MONTO"),"VVENTA","where MONEDA = 1 AND FECHA = CURDATE()")[0];
	$DingresoH = $DingresoH + $ingresoH["MONTO"];
	
	$egresoH = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 2 and MONEDA = 1 AND FECHA = CURDATE() and ELIM = 0")[0];
	$DegresoH = $DegresoH + $egresoH["MONTO"];
	
	$contratoH = (array) $query->select(array("SUM(ENTREGADO) as MONTO"),"VCONTRATO","where MONEDA = 1 AND EMISION = CURDATE()")[0];
	$DegresoH = $DegresoH + $contratoH["MONTO"];
	
	$compraH = (array) $query->select(array("SUM((DIMENSION * PRECIO)- DIFERENCIA)  as MONTO"),"VCOMPRA","where MONEDA = 'DOLARES' AND ELIM = 0 AND FECHA = CURDATE()")[0];
	$DegresoH = $DegresoH + $compraH["MONTO"];
	
	// Caja Bolivares //
	$pagosH = (array) $query->select(array("SUM(MONTO) as MONTO"),"VPAGO","where MONEDA = 2 and ID != 92 and ID != 93 AND FECHA = CURDATE()")[0];
	$BingresoH = $BingresoH + $pagosH["MONTO"];
	
	$ingresoH = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 1 and MONEDA = 2 AND FECHA = CURDATE() and ELIM = 0")[0];
	$BingresoH = $BingresoH + $ingresoH["MONTO"];
	
	$ingresoH = (array) $query->select(array("SUM(PRECIO * DIMENSION) as MONTO"),"VVENTA","where MONEDA = 2 AND FECHA = CURDATE()")[0];
	$BingresoH = $BingresoH + $ingresoH["MONTO"];
	
	$egresoH = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 2 and MONEDA = 2 AND FECHA = CURDATE() and ELIM = 0")[0];
	$BegresoH = $BegresoH + $egresoH["MONTO"];
	
	$contratoH = (array) $query->select(array("SUM(ENTREGADO) as MONTO"),"VCONTRATO","where MONEDA = 2 AND EMISION = CURDATE()")[0];
	$BegresoH = $BegresoH + $contratoH["MONTO"];
	
	$compraH = (array) $query->select(array("SUM(DIMENSION * PRECIO) as MONTO"),"VCOMPRA","where MONEDA = 'BOLIVARES' AND ELIM = 0 AND FECHA = CURDATE()")[0];
	$BegresoH = $BegresoH + $compraH["MONTO"];
	
	$compraH = (array) $query->select(array("SUM(DIFERENCIA * TAZA) as MONTO"),"VCOMPRA","where  ELIM = 0 AND FECHA = CURDATE()")[0];
	$BegresoH = $BegresoH + $compraH["MONTO"];
	
?>
