<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../php/API/query.php";
	include "../../php/API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../../php/API/parametro.php";
	
?>
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12">
			<section id="widget-grid" class="">
				<div class="row">
					<article class="col-sm-12 col-md-12 col-lg-12" style="padding:0">
						<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
							<header>
								<span class="widget-icon"> <i class="fa fa-file"></i> </span>
								<h2>Nuevo Ingreso</h2>				
							</header>
							<div class="content">
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body no-padding">
									<form id="nuevo-form" onSubmit="event.preventDefault();" class="smart-form" action="php/caja/ingreso/ingreso.php" method="post">
										<header>Detalles del ingreso</header>
										<fieldset>
											<section class="col col-12 no-padding no-margin">
												<section class="col col-3">
													<label class="input">
														<i class="icon icon-prepend fa fa-calendar"></i>
														<input name="fecha" class="datepicke" type="text" placeholder="Fecha">
														<i class="tooltip tooltip-top-left">Fecha de caja</i>
													</label>
												</section>
											</section>
											<section class="col col-3">
												<label class="input">
													<i class="icon icon-prepend fa fa-cube"></i>
													<select onchange="objeto['MONEDA'] = $(this).val()" name="moneda" style="text-align-last: center;" class="input-sm col-12 nocaret">
														<option value="0" selected="" disabled="">Moneda</option>
														<?php
															foreach($moneda as $indice => $valor){
																echo "<option value='".$valor["ID"]."'>".$valor["DESCRIPCION"]."</option>";
															}
														?>
													</select>
												</label>
											</section>
											<section class="col col-6 no-padding no-margin">
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-prepend fa fa-cube"></i>
														<select onchange="objeto['CONCEPTO'] = $(this).val()" name="concepto" style="text-align-last: center;" class="input-sm col-12 nocaret">
															<option value="0" selected="" disabled="">Tipo de Ingreso</option>
															<option value="6">Abono Capital</option>
														</select>
													</label>
												</section>
											</section>
											<section class="col col-3">
												<label class="input">
													<i class="icon icon-append fa fa-dollar"></i>
													<input onkeyup="objeto['MONTO'] = ($(this).val() != NaN)? $(this).val() : objeto['MONTO'] ;" name="monto" class="right" type="text" placeholder="Monto">
													<i class="tooltip tooltip-top-right">Monto total de la transaccion</i>
												</label>
											</section>
											<section class="col col-12">
												<label class="textarea">
													<i class="icon-prepend fa fa-pencil"></i>
													<textarea onkeyup="objeto['DESCRIPCION'] = $(this).val()" rows="5"></textarea>
													<i class="tooltip tooltip-top-left">Descripcion de la transaccion (opcional)</i>
												</label>
											</section>
										</fieldset>
										<footer style="border-bottom:1px solid rgba(0,0,0,.1)">
											<section class="col col-12 no-margin">
												<button class="btn btn-success right" type="submit">Ingresar</button>
											</section>
										</footer>
									</form>
									<table style="border-bottom: 1px solid rgba(0,0,0,.1) !important;" id="dt_basic" class="table table-condensed table-striped table-bordered table-hover" width="100%">
										<thead>			                
											<tr>
												<th>Concepto</th>
												<th>Moneda</th>
												<th>Descripcion</th>
												<th>Monto</th>
												<th class="center"><i class="fa fa-trash-o fa-lg"></i></th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</article>
				</div>
			</section>
		</div>
	</div>
</div>

<script>
	var errorClass = 'invalid';
	var errorElement = 'em';
	var objeto = {
		"FECHA" : "",
		"MONEDA" : "0",
		"CONCEPTO" : "0",
		"MONTO" : 0.00,
		"DESCRIPCION" : "Sin descripcion"
	};
	
	var moneda = JSON.parse('<?php echo json_encode($moneda); ?>');
	var concepto = {
		6 : "Abono Capital"
	}
	
	pageSetUp();
	
	var pagefunction = function() {
		
		$(".datepicke").datepicker({dateFormat:"dd/mm/yy"});
		var d = new Date(); 
		var m = d.getMonth() + 1;
		var y = d.getFullYear();
		$("[name='fecha']").val(d.getDate()+"/"+m+"/"+y);
		objeto["FECHA"] = d.getDate()+"/"+m+"/"+y;
		
		table = $('#dt_basic').DataTable({
			dom: 'Bfrtip',
			buttons: [
            'excel', 'pdf'
			],
			"autoWidth" : true,
			"columnDefs": [
				{ targets: [0,1,2,3], className: "center vertical-center"},
				{ targets: [0], width: "15%"},
				{ targets: [1], width: "15%"},
				{ targets: [2], width: "50%"},
				{ targets: [3], width: "15%"}

			]
		});
		buscar();
	};
	
	loadScript("js/datatable/jquery.dataTables.min.js", function(){
		loadScript("js/datatable/dataTables.buttons.min.js", function(){
			loadScript("js/datatable/buttons.flash.min.js", function(){
				loadScript("js/datatable/dataTables.responsive.min.js", function(){
					loadScript("js/datatable/jszip.min.js", function(){
						loadScript("js/datatable/pdfmake.min.js", function(){
							loadScript("js/datatable/vfs_fonts.js", function(){
								loadScript("js/datatable/buttons.html5.min.js", function(){
									loadScript("js/datatable/buttons.print.min.js", function(){
										loadScript("js/datatable/buttons.colVis.min.js", pagefunction);
									});
								});
							});
						});
					});
				});
			});
		});
	});
	
	$(function() {
		$("#nuevo-form").validate({
			errorClass		: errorClass,
			errorElement	: errorElement,
			highlight: function(element) {
		        $(element).parent().removeClass('state-success').addClass("state-error");
		        $(element).removeClass('valid');
		    },
		    unhighlight: function(element) {
		        $(element).parent().removeClass("state-error").addClass('state-success');
		        $(element).addClass('valid');
		    },
			rules : {
				concepto : {
					required : true
				},
				moneda : {
					required : true
				},
				monto : {
					required : true,
					minlength : 1
				},
				
			},
			messages : {
				
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			},
			 submitHandler: function(form) {
				 $(form).ajaxSubmit({data:{DATO:JSON.stringify(objeto)},success: function(resp){resp = JSON.parse(resp);alerta(resp["ESTADO"],resp["MENSAJE"]);buscar();}});
			}
		});
	});
	
	function buscar(){
		$.ajax({
			url:"php/caja/ingreso/lista.php",
			success: function(resp){
				resp = JSON.parse(resp);
				$("#dt_basic").dataTable().fnClearTable();
				
				$.each(resp["MENSAJE"],function(indice,valor){
					var d = new Date();
					var ELIM = (d.getFullYear()+"-"+('0' + (d.getMonth()+1)).slice(-2)+"-"+('0' + (d.getDate())).slice(-2) == resp["MENSAJE"][indice]['FECHA'])?"<button class='btn btn-sm btn-danger' onclick='elim("+valor["ID"]+")'><i class='fa fa-share'></i></button>":"";
					
					$("#dt_basic").dataTable().fnAddData([
						concepto[valor["CONCEPTO"]],
						moneda[valor["MONEDA"]]["DESCRIPCION"],
						valor["DESCRIPCION"],
						"$"+money(valor["MONTO"]),
						ELIM
					]);
				});
			}
		});
	}; 
	
	function elim(id){
		$.ajax({
			url:"php/caja/ingreso/elim.php",
			type:"POST",
			data:{"DATO":id},
			success:function(resp){
				//resp = JSON.parse(resp);
				alerta('success','Ingreso eliminado');
				buscar();
			}
		})
		
	};
</script>
