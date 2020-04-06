<?php

	$Bingreso = 0;$Begreso = 0;
	$Dingreso = 0;$Degreso = 0;
	// Caja Dolares //
	$pagos = (array) $query->select(array("SUM(MONTO) as MONTO"),"VPAGO","where MONEDA = 1 and ID != 92 and ID != 93")[0];
	$Dingreso = $Dingreso + $pagos["MONTO"];
	
	$ingreso = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 1 and MONEDA = 1 and ELIM = 0")[0];
	$Dingreso = $Dingreso + $ingreso["MONTO"];
	
	$ingreso = (array) $query->select(array("SUM(PRECIO * DIMENSION) as MONTO"),"VVENTA","where MONEDA = 1")[0];
	$Dingreso = $Dingreso + $ingreso["MONTO"];
	
	$egreso = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 2 and MONEDA = 1 and ELIM = 0")[0];
	$Degreso = $Degreso + $egreso["MONTO"];
	
	$contrato = (array) $query->select(array("SUM(ENTREGADO) as MONTO"),"VCONTRATO","where MONEDA = 1")[0];
	$Degreso = $Degreso + $contrato["MONTO"];
	
	$compra = (array) $query->select(array("SUM((DIMENSION * PRECIO) - (DIFERENCIA)) as MONTO"),"VCOMPRA","where MONEDA = 'DOLARES' AND ELIM = 0")[0];
	$Degreso = $Degreso + $compra["MONTO"];
	
	// Caja Bolivares //
	$pagos = (array) $query->select(array("SUM(MONTO) as MONTO"),"VPAGO","where MONEDA = 2 and ID != 92 and ID != 93")[0];
	$Bingreso = $Bingreso + $pagos["MONTO"];
	
	$ingreso = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 1 and MONEDA = 2 and ELIM = 0")[0];
	$Bingreso = $Bingreso + $ingreso["MONTO"];
	
	$ingreso = (array) $query->select(array("SUM(PRECIO * DIMENSION) as MONTO"),"VVENTA","where MONEDA = 2")[0];
	$Bingreso = $Bingreso + $ingreso["MONTO"];
	
	$egreso = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 2 and MONEDA = 2 and ELIM = 0")[0];
	$Begreso = $Begreso + $egreso["MONTO"];
	
	$contrato = (array) $query->select(array("SUM(ENTREGADO) as MONTO"),"VCONTRATO","where MONEDA = 2")[0];
	$Begreso = $Begreso + $contrato["MONTO"];
	
	$compra = (array) $query->select(array("SUM(DIMENSION * PRECIO) as MONTO"),"VCOMPRA","where MONEDA = 'BOLIVARES' AND ELIM = 0")[0];
	$Begreso = $Begreso + $compra["MONTO"];
	
	$compra = (array) $query->select(array("SUM(DIFERENCIA * TAZA) as MONTO"),"VCOMPRA"," WHERE ELIM = 0")[0];
	$Begreso = $Begreso + $compra["MONTO"];
	
?>
