<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	//-- ---------------------- --//
	include "../../php/API/query.php";
	include "../../php/API/util.php";
	
	
	$query = new query();
	$util = new util();
	
	include "../../php/API/caja.php";
	include "../../php/API/cajahoy.php";
?>
<h1 class="page-title" style="display:block !important"><?php echo date("d") ?>/<?php echo date("m") ?>/<?php echo date("Y") ?></h1>
<div class="row">
	<div class="col-md-12">
		<h1 class="page-title " style="display:block !important">Dolares</h1>
		<div class="col-md-6 col-xs-6 no-padding" >
			<div class="alert alert-success fade in" style="border-width: 0 5px 0 5px !important">
				<h4>Ingresos</h4>
				<strong><h3><i class="fa-fw fa fa-caret-up"></i>$ <?php echo number_format($DingresoH,2) ?></h3></strong> 
			</div>
		</div>
		<div class="col-md-6 col-xs-6 no-padding">
			<div class="alert alert-danger fade in right" style="border-width: 0 5px 0 5px !important">
				<h4>Egresos</h4>
				<strong><h3> <?php echo number_format($DegresoH,2) ?> $<i class="fa-fw fa fa-caret-down"></i></h3></strong>
			</div>
		</div>
		<div class=" col-xs-12 no-padding">
			<div class="alert alert-info fade in center" style="border-width: 0 5px 0 5px !important">
				<h4>Balance</h4>
				<strong><h3>$ <?php echo number_format($Dingreso - $Degreso,2) ?></h3></strong>
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
				<strong><h3><i class="fa-fw fa fa-caret-up"></i>$ <?php echo number_format($BingresoH,2) ?></h3></strong> 
			</div>
		</div>
		
		<div class="col-md-6 col-xs-6 no-padding">
			<div class="alert alert-danger fade in right" style="border-width: 0 5px 0 5px !important">
				<h4>Egresos</h4>
				<strong><h3> <?php echo number_format($BegresoH,2) ?> $<i class="fa-fw fa fa-caret-down"></i></h3></strong>
			</div>
		</div>
		<div class="col-xs-12 no-padding">
			<div class="alert alert-info fade in center" style="border-width: 0 5px 0 5px !important">
				<h4>Balance</h4>
				<strong><h3>$ <?php echo number_format($Bingreso - $Begreso,2) ?></h3></strong>
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
				{ targets: [4], width: "20%"}

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
			url:"php/caja/diario/lista.php",
			success: function(resp){
				resp = JSON.parse(resp);
				$("#dt_basic").dataTable().fnClearTable();
				
				$.each(resp["MENSAJE"],function(indice,valor){
					$("#dt_basic").dataTable().fnAddData([
						valor["CONCEPTO"],
						valor["DESCRIPCION"],
						valor["MONEDA"],
						"$"+money(valor["MONTO"]),
						valor["MOVIMIENTO"]
					]);
				});
			}
		});
	}; 
</script>


