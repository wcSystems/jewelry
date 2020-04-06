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
						<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
							<header>
								<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
								<h2>Definicion de metas</h2>				
							</header>
							<div class="content">
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body no-padding">
									<form id="nuevo-form" onSubmit="event.preventDefault();" class="smart-form" action="php/meta/meta.php" method="post">
										<header>Definir Nueva Meta</header>
										<fieldset>
											<section class="col col-12">
												<section class="col col-3">
													<label class="input">
														<i class="icon-prepend fa fa-cube"></i>
														<select onchange="meta['DEFINICION']=$(this).val();cambio($(this).val());" name="definicion" style="text-align-last: center;" class="input-sm col-12 nocaret">
															<option value="NA" selected="" disabled="">Definiciones</option>
															<option value=1>Compra</option>
															<option value=2>Contrato</option>
														</select>
													</label>
												</section>
											</section>
											<section class="col col-12">
												<section class="col col-3">
													<label class="input">
														<i class="icon-prepend fa fa-calendar"></i>
														<input name="periodo" type="text" class="datepicke">
													</label>
												</section>
												<section class="col col-3">
													<label class="input">
														<i class="icon-prepend fa fa-cube"></i>
														<select onchange="meta['MONEDA']=$(this).val();" name="moneda" style="text-align-last: center;" class="input-sm col-12 nocaret">
															<option value="NA" selected="" disabled="">Moneda</option>
															<option value=1>Dolares</option>
															<option value=2>Bolivares</option>
														</select>
													</label>
												</section>
												<section class="col col-3">
													<label class="select">
														
														<select onchange="meta['ARTICULO']=$(this).val();" name="articulo" style="text-align-last: center;" class="input-sm col-12 nocaret">
															<option value="NA" selected="" disabled="">Articulo</option>
															<?php 
																foreach($articulo as $indice => $valor){
																	echo "<option value='".$valor["DESCRIPCION"]."'>".$valor["DESCRIPCION"]."</option>";
																}
															?>
														</select>
													</label>
												</section>
												<section class="col col-3">
													<label class="input">
														<i class="icon-append fa fa-dollar"></i>
														<input name="objetivo" onkeyup="meta['OBJETIVO'] = ($(this).val() != NaN )? $(this).val() : meta['OBJETIVO'];" type="text" >
													</label>
												</section>
											</section>
										</fieldset>
										<footer  style="border-bottom: 1px solid rgba(0,0,0,.1) !important;">
											<section class="col col-12 no-margin">
												<button type="submit" class="btn btn-success">Apuntar meta</button>
											</section>
										</footer>
										<header>Lista de Metas</header>
									</form>
									<table style="border-bottom: 1px solid rgba(0,0,0,.1) !important;" id="dt_basic" class="table table-condensed table-striped table-bordered table-hover" width="100%">
										<thead>			                
											<tr>
												<th>Meta</th>
												<th>Articulo</th>
												<th>Periodo</th>
												<th>Objetivo</th>
												<th>Moneda</th>
												<th rel="tooltip" data-original-title="Eliminar"><i class="fa fa-trash-o"></i></th>
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
<div class="modal fade" id="detalle" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">  
    <div class="modal-dialog">  
        <div class="modal-content"></div>  
    </div>  
</div>

<script>
pageSetUp();

	var meta = {
		"DEFINICION":0,
		"ARTICULO":0,
		"MES":0,
		"ANO":0,
		"MONEDA":0,
		"OBJETIVO":0
	};
	var errorClass = 'invalid';
	var errorElement = 'em';
	
	var pagefunction = function() {
		
		$(".datepicke").datepicker({
		  changeMonth: true,
		  changeYear: true,
		  dateFormat: "MM yy",
		  showButtonPanel: true,
		  currentText: "Este mes",
		  onChangeMonthYear: function (year, month, inst) {
			$(this).val($.datepicker.formatDate('MM yy', new Date(year, month - 1, 1)));
		  },
		  onClose: function(dateText, inst) {
			var month = $(".ui-datepicker-month :selected").val();
			var year = $(".ui-datepicker-year :selected").val();
			$(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
			meta["MES"] = ('0' +(parseInt(month)+1)).slice(-2);
			meta["ANO"] = year;
		  }
		}).focus(function () {
		  $(".ui-datepicker-calendar").hide();
		});
		
		table = $('#dt_basic').DataTable({
			dom: 'Bfrtip',
			buttons: [
            'excel', 'pdf'
			],
			"autoWidth" : true,
			"columnDefs": [
				{ targets: [0,1,2,3,4], className: "center vertical-center"},
				{ targets: [0], width: "20%"},
				{ targets: [1], width: "20%"},
				{ targets: [2], width: "20%"},
				{ targets: [3], width: "20%"},
				{ targets: [4], width: "10%"},
				{ targets: [5], width: "10%"}

			]
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
				definicion : {
					required : true
				},
				periodo : {
					required : true
				},
				moneda : {
					required : true
				},
				objetivo : {
					required : true
				},
			},
			messages : {
				first : {
					required : 'Este campo es obligatorio'
				},
				last : {
					required : 'Este campo es obligatorio'
				},
				doc : {
					required : 'Este campo es obligatorio'
				}
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			},
			 submitHandler: function(form) {
				 $(form).ajaxSubmit({data:{DATO:JSON.stringify(meta)},success: function(resp){resp = JSON.parse(resp);alerta(resp["ESTADO"],resp["MENSAJE"]);buscar();}});
			}
		});
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
	
	function cambio(V){
		$("[name='moneda']").empty();
		if(V == 1){
			$("[name='moneda']").append("<option value='0' selected='' disabled=''>Medida</option>");
			$("[name='moneda']").append("<option value='1'>Gramos</option>");
			$("[name='articulo']").removeAttr("disabled");
			$("[name='articulo']").parent().removeClass("state-disabled");
		}else{
			$("[name='moneda']").append("<option value='0' selected='' disabled=''>Moneda</option>");
			$("[name='moneda']").append("<option value='1'>Dolares</option>");
			$("[name='moneda']").append("<option value='2'>Bolivares</option>");
			$("[name='articulo']").attr("disabled","disabled");
			$("[name='articulo']").parent().addClass("state-disabled");
		}
		
		
	}
	
	function buscar(){
		$.ajax({
			url:"php/meta/lista.php",
			success: function(resp){
				resp = JSON.parse(resp);
				$("#dt_basic").dataTable().fnClearTable();
				
				$.each(resp["MENSAJE"],function(indice,valor){
					var d = new Date();
					var f = new Date( Date.parse(valor["FECHA"]))
					var ELIM = (('0' + (d.getMonth()+1)).slice(-2) == ('0' + (f.getMonth()+1)).slice(-2) )?"<button onclick='elim("+valor["ID"]+")' class='btn btn-danger btn-sm'><i class='fa fa-trash-o'></i></button>":"";
					$("#dt_basic").dataTable().fnAddData([
						valor["DEFINICION"],
						valor["ARTICULO"],
						valor["PERIODO"],
						money(valor["OBJETIVO"]),
						valor["MONEDA"],
						ELIM
					]);
				});
			}
		});
	}; 
	
	function elim(id){
		$.ajax({
			url:"php/meta/elim.php",
			type:"POST",
			data:{"DATO":id},
			success:function(resp){
				resp = JSON.parse(resp);
				alerta(resp["ESTADO"],resp["MENSAJE"]);
				buscar();
			}
		})
		
	};


</script>
