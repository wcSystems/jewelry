<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../../php/API/util.php";
include "../../php/API/query.php";
	
$query = new query();
$util = new util();

$correos = (array) $query->select(array("*"),"VRECIBIDO","where DESTINO = ".$_SESSION["SESION"][0]["ID"]." and ELIM = 0 order by FECHA desc");
$e = "O";
$d = "detalle_recibido";

require "vista.php";
?>


<script>
function elim(){
		var t = [];
		$(".mesaje").each(function(){
			if($(this).is(":CHECKED")){
				t.push($(this).attr("data-id"));
			}
		});
		
		$.ajax({
			url:"php/mensajeria/elimInbox.php",
			type:"POST",
			data:{"DATO":JSON.stringify(t),"OBJETIVO":"INBOX"},
			beforeSend: function(){
				$(".deletebutton").attr("disabled","disabled");
			}	
		}).done(function(resp){
			loadURL("ajax/mensajeria/recibido.php", $('#inbox-content > .table-wrap'));
		});
	};


</script>
