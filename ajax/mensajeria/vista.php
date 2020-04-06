<table id="inbox-table" class="table table-striped table-hover">
	<tbody>
		
		<?php
		
			foreach($correos as $indice => $valor){
					if(isset($valor["VISTO"])){
						$t = ($valor["VISTO"] == 1)?"unread":"";
					}else{
						$t = "";
					}
					$u = ($query->if_exist(array("EMAIL"=>$valor["ID"]),"ADJUNTO"))? "<a href='javascript:void(0);' rel='tooltip' data-placement='left' data-original-title='Archivos Adjuntos' class='txt-color-darken'><i class='fa fa-paperclip fa-lg'></i></a>" : "";
				
					echo "
						<tr id='".$valor["ID"]."' class=' ".$t."'>
							<td class='inbox-table-icon'>
								<div class='checkbox'>
									<label>
										<input data-id='".$valor["ID"]."' type='checkbox' class='mesaje checkbox style-2'>
										<span></span> 
									</label>
								</div>
							</td>
							<td class='inbox-data-from hidden-xs hidden-sm'>
								<div>
									".$valor[$e."NOMBRE"]." 
								</div>
							</td>
							<td class='inbox-data-message'>
								<div>
									".$valor["ASUNTO"]."
								</div>
							</td>
							<td class='inbox-data-attachment hidden-xs'>
								<div>
									".$u."
								</div>
							</td>
							<td class='inbox-data-date hidden-xs'>
								<div>
									".$util->tonormaldate(date("Y-m-d", strtotime($valor["FECHA"])))."
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
		var ID = $this.closest("tr").attr("id");
		loadURL("ajax/mensajeria/<?php echo $d; ?>.php?EMAIL="+ID, $('#inbox-content > .table-wrap'));
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
