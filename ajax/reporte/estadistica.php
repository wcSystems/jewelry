

<section id="widget-grid" class="">
	<div class="row">
		<div class="col-md-12">
			<div class="well well-sm ">
				<div class="row no-margin">
					<div class="col-md-6 smart-form no-padding">
						<section class="col col-6 no-margin ">
							<label class="input">
								<i class="icon-prepend fa fa-calendar"></i>
								<input type="text" class="datepicke" id="desde" value="">
								<i class="tooltip tooltip-top-left">Fecha desde:</i>
							</label>
						</section>
						<section class="col col-6 no-margin">
							<label class="input">
								<i class="icon-append fa fa-calendar"></i>
								<input type="text" class="datepicke right" id="hasta" value="">
								<i class="tooltip tooltip-top-right">Fecha hasta:</i>
							</label>
						</section>
					</div>
					<div class="col-md-6 no-padding">
						<section class="col col-6">
							<button class="btn btn-success pull-right" onclick="buscar();">Buscar</button>
						</section>
					</div>
				</div>
			</div>		
		</div>
	</div>
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget" id="wid-id-7" data-widget-editbutton="false">
				<header>
					<span class="widget-icon"><i class="fa fa-bar-chart-o"></i></span>
					<h2>Estadistica</h2>				
				</header>
				<div>
					<div class="jarviswidget-editbox"></div>
					<div class="widget-body no-padding">
						<div id="sales-graph" class="chart no-padding"></div>	
					</div>
				</div>
			</div>
		</article>
		<article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
					<h2>Cantidad en inventario</h2>				
				</header>
				<div>
					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body no-padding">
						<div id="normal-bar-graph" class="chart no-padding"></div>
					</div>
				</div>
			</div>
		</article>
		<article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
					<h2>Estadisticas de contratos activos</h2>				
				</header>
				<div>
					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body no-padding">
						<div id="normal-bar-graph2" class="chart no-padding"></div>
					</div>
				</div>
			</div>
		</article>
	</div>
</section>
<script>
	var plot_1, plot_2, plot_3, plot_4, plot_5, plot_6, plot_7, plot_8;
	var arreglo = JSON.parse('<?php echo json_encode($array); ?>');
	pageSetUp();
	
	var pagefunction = function() {
		var $chrt_border_color = "#efefef";
		var $chrt_grid_color = "#DDD"
		var $chrt_main = "#E24913";			/* red       */
		var $chrt_second = "#6595b4";		/* blue      */
		var $chrt_third = "#FF9F01";		/* orange    */
		var $chrt_fourth = "#7e9d3a";		/* green     */
		var $chrt_fifth = "#BD362F";		/* dark red  */
		var $chrt_mono = "#000";
		
		var now = new Date();
		now.setDate(now.getDate() + 30);
		var d = new Date(); 
		$(".datepicke").datepicker({dateFormat:"dd/mm/yy"});
		$("#desde").val("01/"+(d.getMonth() + 1)+"/"+d.getFullYear());
		$("#hasta").val(now.getDate()+"/"+(d.getMonth() + 1)+"/"+d.getFullYear());
		
		
		
		
		buscar();
		stock();
		contrato();
	};
	
	function buscar(){
		var desde = $("#desde").val();
		var hasta = $("#hasta").val();
		$.ajax({
			url:"php/reporte/estadistica/ingreso.php",
			type:"POST",
			data:{"DESDE":desde,"HASTA":hasta},
			success: function(resp){
				resp = JSON.parse(resp);
				Morris.Area({
					element : 'sales-graph',
					data : resp,
					xkey : 'FECHA',
					ykeys : ['BOLIVARES', 'DOLARES'],
					labels : ['BOLIVARES', 'DOLARES'],
					pointSize : 2,
					hideHover : 'auto'
				});
			
			}
		});
	}; 
	function stock(){
		$.ajax({
			url:"php/reporte/estadistica/stock.php",
			type:"POST",
			success: function(resp){
				resp = JSON.parse(resp);
				Morris.Bar({
				  element: 'normal-bar-graph',
				  data: resp,
				  xkey: 'ARTICULO',
				  ykeys: ['GRAMOS'],
				  labels: ['GRAMOS']
				});
			
			}
		});
	}; 
	function contrato(){
		$.ajax({
			url:"php/reporte/estadistica/contrato.php",
			type:"POST",
			success: function(resp){
				resp = JSON.parse(resp);
				Morris.Bar({
				  element: 'normal-bar-graph2',
				  data: resp,
				  xkey: 'CONCEPTO',
				  ykeys: ['DOLARES'],
				  labels: ['DOLARES']
				});
			
			}
		});
	}; 
	loadScript("js/plugin/morris/raphael.min.js", function(){
		loadScript("js/plugin/morris/morris.min.js", pagefunction);
	});

</script>
