<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../API/query.php";
	include "../../API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../../API/parametro.php";
	
	$DESDE = $util->tosqldate($_POST["DATO"]);

	$Bingreso = 0;$Begreso = 0;
	$Dingreso = 0;$Degreso = 0;
		
	$pagos = (array) $query->select(array("SUM(MONTO) as MONTO"),"VPAGO","where MONEDA = 1 and FECHA <= '".$DESDE."' and ID != 92 and ID != 93")[0];
	$Dingreso = $Dingreso + $pagos["MONTO"];
		
	$ingreso = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 1 and MONEDA = 1 and FECHA <= '".$DESDE."' and ELIM = 0")[0];
	$Dingreso = $Dingreso + $ingreso["MONTO"];
		
	$ingreso = (array) $query->select(array("SUM(PRECIO * DIMENSION) as MONTO"),"VVENTA","where MONEDA = 1 and FECHA <= '".$DESDE."'")[0];
	$Dingreso = $Dingreso + $ingreso["MONTO"];
		
	$egreso = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 2 and MONEDA = 1 and FECHA <= '".$DESDE."' and ELIM = 0")[0];
	$Dingreso = $Dingreso - $egreso["MONTO"];
		
	$contrato = (array) $query->select(array("SUM(ENTREGADO) as MONTO"),"VCONTRATO","where MONEDA = 1 and EMISION <= '".$DESDE."'")[0];
	$Dingreso = $Dingreso - $contrato["MONTO"];
		
	$compra = (array) $query->select(array("SUM((DIMENSION * PRECIO) - (DIFERENCIA)) as MONTO"),"VCOMPRA","where MONEDA = 'DOLARES' AND ELIM = 0 and FECHA <= '".$DESDE."'")[0];
	$Dingreso = $Dingreso - $compra["MONTO"];
		
		
	$pagos = (array) $query->select(array("SUM(MONTO) as MONTO"),"VPAGO","where MONEDA = 2 and FECHA <= '".$DESDE."' and ID != 92 and ID != 93")[0];
	$Bingreso = $Bingreso + $pagos["MONTO"];
		
	$ingreso = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 1 and MONEDA = 2 and FECHA <= '".$DESDE."' and ELIM = 0")[0];
	$Bingreso = $Bingreso + $ingreso["MONTO"];
		
	$ingreso = (array) $query->select(array("SUM(PRECIO * DIMENSION) as MONTO"),"VVENTA","where MONEDA = 2 and FECHA <= '".$DESDE."'")[0];
	$Bingreso = $Bingreso + $ingreso["MONTO"];
	
	$egreso = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 2 and MONEDA = 2 and FECHA <= '".$DESDE."' and ELIM = 0")[0];
	$Bingreso = $Bingreso - $egreso["MONTO"];
		
	$contrato = (array) $query->select(array("SUM(ENTREGADO) as MONTO"),"VCONTRATO","where MONEDA = 2 and EMISION <= '".$DESDE."'")[0];
	$Bingreso = $Bingreso - $contrato["MONTO"];
		
	$compra = (array) $query->select(array("SUM(DIMENSION * PRECIO) as MONTO"),"VCOMPRA","where MONEDA = 'BOLIVARES' AND ELIM = 0 and FECHA <= '".$DESDE."'")[0];
	$Bingreso = $Bingreso - $compra["MONTO"];
		
	$compra = (array) $query->select(array("SUM(DIFERENCIA * TAZA) as MONTO"),"VCOMPRA"," WHERE ELIM = 0 and FECHA <= '".$DESDE."'")[0];
	$Bingreso = $Bingreso - $compra["MONTO"];
		
	$DESDE = date('Y-m-d', strtotime($DESDE. ' + 1 days')); 
	$array = array("TD"=>$Dingreso,"TB"=>$Bingreso);
		
	echo json_encode($array);
?>
