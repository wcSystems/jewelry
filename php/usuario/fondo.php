<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include "../API/util.php";
include "../API/query.php";
	
$query = new query();
$util = new util();

if(!is_dir("../../fondo/")){ 
	mkdir("../../fondo/");
}

$target_dir = "../../fondo/";

$temp = explode(".", $_FILES["archivo"]["name"]);
$newfilename = random_string(20) . '.' . end($temp);

$target_file = $target_dir . $newfilename;

if(move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)){
	$image = new Imagick($target_file);
	$image->cropThumbnailImage(900,600);
	if($image->writeImage("../../fondo/".$newfilename)){
		if($query->update(array("FONDO"=>$newfilename),"USUARIO",$_SESSION["SESION"][0]["ID"])){
			$util->respuesta("success",$newfilename);
		}
	}
};



function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

?>
