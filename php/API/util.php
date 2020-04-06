<?php
class util{
	public function respuesta($codigo,$respuesta = ""){
		$array = array(
			"ESTADO" => $codigo,
			"MENSAJE" => $respuesta
		);
		echo json_encode($array);
	}
	
	public function tosqldate($date){
		$newdate = $date;
		if($date != "" && $date != "0000-00-00" && strpos($date,"-") === false){
		$date = explode("/",$date);
		$date = $date[2]."-".$date[1]."-".$date[0];
		//echo $date;
		$newdate = date('Y-m-d', strtotime($date));
		}
		//echo $date;
		return $newdate;
	}
	
	public function tosqltime($time){

		return date("H:i:s", strtotime($time));
	}
	
	public function tonormaldate($date){
		$newdate = $date;
		if($date != "" && $date != "00/00/0000" && strpos($date,"/") === false){
		$date = explode("-",$date);
		$date = $date[2]."/".$date[1]."/".$date[0];
		//echo $date;
		$newdate = $date;
		}
		return $newdate;
	}
	
	public function condiciones($where){
		$resultado = "where ";
		
		foreach($where as $indice => $valor){
			$temp = (is_numeric($valor["DATO1"]))? "".$valor["DATO1"]."":"'".$valor["DATO1"]."'";
			
			switch($valor["ACCION"]){
				case "IGUAL":
					$resultado .= "".$valor["COLUMNA"]." = ".$temp;
				break;
				
				case "MENOR":
					$resultado .= "".$valor["COLUMNA"]." < ".$temp;
				break;
				
				case "MAYOR":
					$resultado .= "".$valor["COLUMNA"]." > ".$temp;
				break;
				
				case "MENOR-E":
					$resultado .= "".$valor["COLUMNA"]." <= ".$temp;
				break;
				
				case "MAYOR-E":
					$resultado .= "".$valor["COLUMNA"]." >= ".$temp;
				break;
				
				case "LIKE":
					$resultado .= "".$valor["COLUMNA"]." like '%".$valor["DATO1"]."%'";
				break;
				
				case "BETWEEN":
					$resultado .= "".$valor["COLUMNA"]." like '%".$valor["DATO1"]."%'";
				break;
			}
		}
	}
}
?>
