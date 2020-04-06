<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../../php/API/util.php";
include "../../php/API/query.php";
	
$query = new query();
$util = new util();

if(!isset($_POST["A"])){
	$where = "where DESTINO = ".$_SESSION["SESION"][0]["ID"]." and ELIM = 0";
}else if($_POST["A"] == "S"){

	$where = "where ORIGEN = ".$_SESSION["SESION"][0]["ID"]." and ELIM = 0";
}else if($_POST["A"] == "T"){
	$where = "where DESTINO = ".$_SESSION["SESION"][0]["ID"]." and ELIM = 1";
}

$correos = (array) $query->select(array("*"),"VRECIBIDO",$where);
?>

<table id="inbox-table" class="table table-striped table-hover">
	<tbody>
		
		<?php
		
			foreach($correos as $indice => $valor){
					echo "
						<tr id='".$valor["ID"]."' class=''>
							<td class='inbox-table-icon'>
								<div class='checkbox'>
									<label>
										<input type='checkbox' class='checkbox style-2'>
										<span></span> 
									</label>
								</div>
							</td>
							<td class='inbox-data-from hidden-xs hidden-sm'>
								<div>
									".$valor[$e."NOMBRE"]." ".$valor[$e."APELLIDO"]."
								</div>
							</td>
							<td class='inbox-data-message'>
								<div>
									".$valor["ASUNTO"]."
								</div>
							</td>
							<td class='inbox-data-attachment hidden-xs'>
								<div>
									<a href='javascript:void(0);' rel='tooltip' data-placement='left' data-original-title='FILES: rocketlaunch.jpg, timelogs.xsl' class='txt-color-darken'><i class='fa fa-paperclip fa-lg'></i></a>
								</div>
							</td>
							<td class='inbox-data-date hidden-xs'>
								<div>
									".$valor["FECHA"]."
								</div>
							</td>
						</tr>	
					";
			}
		?>


	</tbody>
</table>

<script>
	
	//Gets tooltips activated
	$("#inbox-table [rel=tooltip]").tooltip();

	$("#inbox-table input[type='checkbox']").change(function() {
		$(this).closest('tr').toggleClass("highlight", this.checked);
	});

	$("#inbox-table .inbox-data-message").click(function() {
		$this = $(this);
		getMail($this);
	})
	$("#inbox-table .inbox-data-from").click(function() {
		$this = $(this);
		getMail($this);
	})
	function getMail($this) {
		//console.log($this.closest("tr").attr("id"));
		loadURL("ajax/email-opened.html", $('#inbox-content > .table-wrap'));
	}


	$('.inbox-table-icon input:checkbox').click(function() {
		enableDeleteButton();
	})

	$(".deletebutton").click(function() {
		$('#inbox-table td input:checkbox:checked').parents("tr").rowslide();
		//$(".inbox-checkbox-triggered").removeClass('visible');
		//$("#compose-mail").show();
	});

	function enableDeleteButton() {
		var isChecked = $('.inbox-table-icon input:checkbox').is(':checked');

		if (isChecked) {
			$(".inbox-checkbox-triggered").addClass('visible');
			//$("#compose-mail").hide();
		} else {
			$(".inbox-checkbox-triggered").removeClass('visible');
			//$("#compose-mail").show();
		}
	}
	
</script>
