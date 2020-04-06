<?php
include "conexion.php";

$temp = (array) $query->select(array("*"),"DEPOSITO");

foreach($temp as $indice => $valor){
	$deposito[$valor["ID"]] = $valor;
}

$temp = (array) $query->select(array("*"),"MEDIDA");

foreach($temp as $indice => $valor){
	$medida[$valor["ID"]] = $valor;
}

$temp = (array) $query->select(array("*"),"MONEDA");

foreach($temp as $indice => $valor){
	$moneda[$valor["ID"]] = $valor;
}

$temp = (array) $query->select(array("*"),"ARTICULO");

foreach($temp as $indice => $valor){
	$articulo[$valor["ID"]] = $valor;
}

$temp = (array) $query->select(array("*"),"CIVIL");

foreach($temp as $indice => $valor){
	$civil[$valor["ID"]] = $valor;
}

$temp = (array) $query->select(array("*"),"NACIONALIDAD");

foreach($temp as $indice => $valor){
	$nacionalidad[$valor["ID"]] = $valor;
}

$temp = (array) $query->select(array("*"),"PROFESION");

foreach($temp as $indice => $valor){
	$profesion[$valor["ID"]] = $valor;
}

$temp = (array) $query->select(array("*"),"CLIENTE");

foreach($temp as $indice => $valor){
	$cliente[$valor["ID"]] = $valor;
}

$temp = (array) $query->select(array("*"),"USO");

foreach($temp as $indice => $valor){
	$uso[$valor["ID"]] = $valor;
}
?>
