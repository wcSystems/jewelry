

<?php
	include "../API/query.php";
	include "../API/util.php";
	$query = new query();
	$util = new util();
	$dato = $_POST["DATO"];
	//$temp = (array) $query->select(array("ID"),"INVENTARIO","where CODIGO = ".$dato);
$temp = (array) $query->select(array("ID"),"INVENTARIO","where VENDER = 0 AND CODIGO = '".$dato."' ");
	if($query->insert(array("FECHA"=>date("Y-m-d")),"RETIROV")){
		$RETIROV = (array) $query->select(array("ID"),"RETIROV","order by ID desc limit 1")[0];
		$RETIROV = $RETIROV["ID"];
		foreach($temp as $indice => $valor){
			$query->insert(array("VENTA"=>$RETIROV,"PIEZA"=>$valor["ID"]),"RETIROPV");
			$query->update(array("VENDER"=>1),"PIEZA",$valor["ID"]);
			
		}
	}
	

	return $util->respuesta("success","Piezas retiradas de stock correctamente");
?>

