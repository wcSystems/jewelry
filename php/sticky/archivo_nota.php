<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../API/util.php";
include "../API/query.php";
	
$query = new query();
$util = new util();

$temp = explode(".", $_FILES["archivo"]["name"]);
$motivo = $_POST["tipo"];

switch($motivo){
	
	case "STICKY":
		$target_dir = "../../img/sticky/";
	break;
	
}

	$newfilename = random_string(20) . '.' . end($temp);
	$target_file = $target_dir . $newfilename;
	move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file);


echo $newfilename;

function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

?>
