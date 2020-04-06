<?php
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	$dato = $_POST["DATO"];
	
	$temp = (array) $query->select(array("ID"),"INVENTARIO","where VENDER = 0 AND CODIGO = '".$dato."' ");

	if($query->insert(array("FECHA"=>date("Y-m-d")),"RETIRO")){
		$RETIRO = (array) $query->select(array("ID"),"RETIRO","order by ID desc limit 1")[0];
		$RETIRO = $RETIRO["ID"];
		foreach($temp as $indice => $valor){
			$dos = $query->update(array("RETIRO"=>1),"PIEZA",$valor["ID"]);
			$query->insert(array("RETIRO"=>$RETIRO,"PIEZA"=>$valor["ID"]),"RETIRO_PIEZA");
			
		}
	}


 return $util->respuesta("success","Piezas retiradas de stock correctamente");
?>
