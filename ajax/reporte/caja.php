<div class="row"> 
	<div class="col-md-12 ">
		<div class="well well-sm">
			<div class="row">
				<div class="col-md-12 no-padding">
					<section class="col-md-3 smart-form">
						<label class="input">
							<i class="icon-prepend fa fa-calendar"></i>
							<input id="fecha" class="datepicke" type="text">
						</label>
					</section>
					<section class="col-md-9">
						<button onclick="buscar();" class="btn btn-success pull-right">Buscar</button>
					</section>
				</div>
			</div>
		</div> 
	</div>
</div>
<h1 class="page-title" id="date-title" style="display:block !important"></h1>
<div class="row">
	<div class="col-md-12">
		<h1 class="page-title " style="display:block !important">Dolares</h1>
		<div class="col-md-6 col-xs-6 no-padding" >
			<div class="alert alert-success fade in" style="border-width: 0 5px 0 5px !important">
				<h4>Ingresos</h4>
				<strong><h3 id="Dingreso"><i class="fa-fw fa fa-caret-up"></i>$ 0.00</h3></strong> 
			</div>
		</div>
		<div class="col-md-6 col-xs-6 no-padding">
			<div class="alert alert-danger fade in right" style="border-width: 0 5px 0 5px !important">
				<h4>Egresos</h4>
				<strong><h3 id="Degreso">0.00 $<i class="fa-fw fa fa-caret-down"></i></h3></strong>
			</div>
		</div>
		<div class=" col-xs-12 no-padding">
			<div class="alert alert-info fade in center" style="border-width: 0 5px 0 5px !important">
				<h4>Balance</h4>
				<strong><h3 id="Bdolar">$ 0.00</h3></strong>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h1 class="page-title " style="display:block !important">Bolivares</h1>
		<div class="col-md-6 col-xs-6 no-padding" >
			<div class="alert alert-success fade in" style="border-width: 0 5px 0 5px !important">
				<h4>Ingresos</h4>
				<strong><h3 id="Bingreso"><i class="fa-fw fa fa-caret-up"></i>$ 0.00</h3></strong> 
			</div>
		</div>
		<div class="col-md-6 col-xs-6 no-padding">
			<div class="alert alert-danger fade in right" style="border-width: 0 5px 0 5px !important">
				<h4>Egresos</h4>
				<strong><h3 id="Begreso">0.00 $<i class="fa-fw fa fa-caret-down"></i></h3></strong>
			</div>
		</div>
		<div class="col-xs-12 no-padding">
			<div class="alert alert-info fade in center" style="border-width: 0 5px 0 5px !important">
				<h4>Balance</h4>
				<strong><h3 id="Bboliv">$ 0.00</h3></strong>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12">
			<section id="widget-grid" class="">
				<div class="row">
					<article class="col-sm-12 col-md-12 col-lg-12" style="padding:0">
						<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
							<header>
								<span class="widget-icon"> <i class="fa fa-file"></i> </span>
								<h2>Caja diaria</h2>				
							</header>
							<div class="content">
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body no-padding">
									<table style="border-bottom: 1px solid rgba(0,0,0,.1) !important;" id="dt_basic" class="table table-condensed table-striped table-bordered table-hover" width="100%">
										<thead>			                
											<tr>
												<th>Concepto</th>
												<th>Descripcion</th>
												<th>Moneda</th>
												<th>Monto</th>
												<th>Movimiento</th>
												<th>Estado</th>
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
	pageSetUp();
	
	var pagefunction = function() {
		
		$(".datepicke").datepicker({dateFormat:"dd/mm/yy"});
		var d = new Date;
		$("#fecha").val(d.getDate()+"/"+(d.getMonth() + 1)+"/"+d.getFullYear());
		
		
		
		
		table = $('#dt_basic').DataTable({
			dom: 'Bfrtip',
			buttons: [
            'excel', 'pdf'
			],
			"autoWidth" : true,
			"columnDefs": [
				{ targets: [0,1,2,3,4], className: "center vertical-center"},
				{ targets: [0], width: "20%"},
				{ targets: [1], width: "30%"},
				{ targets: [2], width: "20%"},
				{ targets: [3], width: "10%"},
				{ targets: [4], width: "20%"},
				{ targets: [4], width: "10%"}
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
	
	function buscar(){
		$.ajax({
			url:"php/reporte/caja/lista.php",
			type: "POST",
			data:{"DATO":$("#fecha").val()},
			success: function(resp){
				resp = JSON.parse(resp);
				$("#dt_basic").dataTable().fnClearTable();
				
				var Degreso = 0.00; var Dingreso = 0.00; var Bingreso = 0.00; var Begreso = 0.00;
				
				$.each(resp["MENSAJE"],function(indice,valor){
					if(valor["MOVIMIENTO"] == "SALIDA" && valor["MONEDA"] == "DOLARES" && valor["ESTADO"] != "ANULADO"){
						Degreso = parseFloat(Degreso) + parseFloat(valor["MONTO"]);
					}else if(valor["MOVIMIENTO"] == "ENTRADA" && valor["MONEDA"] == "DOLARES" && valor["ESTADO"] != "ANULADO"){
						Dingreso = parseFloat(Dingreso) + parseFloat(valor["MONTO"]);
					}else if(valor["MOVIMIENTO"] == "SALIDA" && valor["MONEDA"] == "BOLIVARES" && valor["ESTADO"] != "ANULADO"){
						Begreso = parseFloat(Begreso) + parseFloat(valor["MONTO"]);
					}else if(valor["MOVIMIENTO"] == "ENTRADA" && valor["MONEDA"] == "BOLIVARES" && valor["ESTADO"] != "ANULADO"){
						Bingreso = parseFloat(Bingreso) + parseFloat(valor["MONTO"]);
					}
					
					
					$("#dt_basic").dataTable().fnAddData([
						valor["CONCEPTO"],
						valor["DESCRIPCION"],
						valor["MONEDA"],
						"$"+money(valor["MONTO"]),
						valor["MOVIMIENTO"],
						valor["ESTADO"]
					]);
				});
				
				$("#date-title").text($("#fecha").val());
				$("#Dingreso").html('<i class="fa-fw fa fa-caret-up"></i>$ '+money(Dingreso)+'');
				$("#Degreso").html('<i class="fa-fw fa fa-caret-down"></i> '+money(Degreso)+' $');
				$("#Bingreso").html('<i class="fa-fw fa fa-caret-up"></i>$ '+money(Bingreso)+'');
				$("#Begreso").html('<i class="fa-fw fa fa-caret-down"></i>'+money(Begreso)+' $');
				
			}
		});
		$.ajax({
			url:"php/reporte/caja/totalhasta.php",
			type: "POST",
			data:{"DATO":$("#fecha").val()},
			success: function(resp){
				resp = JSON.parse(resp);
				$("#Bdolar").html("$ "+money(resp["TD"]));
				$("#Bboliv").html("$ "+money(resp["TB"]));
			}
		});
	}; 
</script>
