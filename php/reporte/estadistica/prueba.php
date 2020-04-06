<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../API/query.php";
	include "../../API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../../API/parametro.php";

	$vencimiento[] = (array) $query->select(array("*"),"VCONTRATO","where REMATE = 0");
	
	$uno = 0;
	$data = array();
	while($uno < count($vencimiento[0])){
        if( $vencimiento[0][$uno]['VENCE'] < 0) {$vencimiento[0][$uno]['VENCE']=0;}
        if( $vencimiento[0][$uno]['DIAS_VENCIDO'] < 0) {$vencimiento[0][$uno]['DIAS_VENCIDO']=0;}
		$data[] = array(
			'vencimiento' => $vencimiento[0][$uno]['VENCIMIENTO'],
            'vence' => $vencimiento[0][$uno]['VENCE'],
            'dias_vencido' => $vencimiento[0][$uno]['DIAS_VENCIDO'],
            'contrato' => $vencimiento[0][$uno]['CONTRATO'],
		);
		$uno = $uno + 1;
	};

	echo json_encode($data);
?>
