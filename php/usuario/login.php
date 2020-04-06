<?php
	session_start();
	include "../API/util.php";
	include "../API/query.php";
	
	$query = new query();
	$util = new util();
	
	$USER = $_POST["USER"];
	$pass = $_POST["PASS"];
	
	if($query->if_exist(array("USUARIO"=>$USER,"PASS"=>$pass),"USUARIO")){
		$session = (array) $query->select(array("*"),"USUARIO","where USUARIO = '".$USER."' and PASS = '".$pass."' and HABILITADO = 1");
		foreach($session as $indice => $valor){
			$_SESSION["SESION"][$indice] = $valor;
		};
		//print_r($_SESSION[0]["NOMBRE"]);
		
		$temp = (array) $query->select(array("*"),"VMENU","where USUARIO = ".$_SESSION["SESION"][0]["ID"]);
		$menus = array();
		
		foreach($temp as $indice => $valor){
			if(!isset($menus[$valor["PADRE"]])){
				$temp2 = (array) $query->select(array("ID","NOMBRE","ICONO"),"MENU","WHERE ID = ".$valor["PADRE"]."");
				//print_r($temp2);
				$menus[$temp2[0]["ID"]] = array(
					"MENU" => array(
						"NOMBRE" => $temp2[0]["NOMBRE"],
						"ICONO" => $temp2[0]["ICONO"]
					),
					"SUB" => array()
				);
			};
			
			$menus[$valor["PADRE"]]["SUB"][] = array(
				"NOMBRE" => $valor["NOMBRE"],
				"ICONO" => $valor["ICONO"],
				"LINK" => $valor["LINK"]				
			);
		}
		
		$_SESSION["SESION"][0]["ACCESOS"] = $menus;
		$_SESSION["SESION"][0]["LOCKEO"] = 0;
		echo "ok";
	}else{
	
		echo "no";
	}
	
?>
