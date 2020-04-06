<?php
	include "../API/conexion.php";
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	
	$lista = (array) $query->select(array("CODIGO","ARTICULO","DEPOSITO","MEDIDA","sum(DIMENSION) as DIMENSION"),"INVENTARIO","where VENDER = 1 group by CODIGO");
	
	
	$util->respuesta("success",$lista);
?>
