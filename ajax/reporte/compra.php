<div class="row">
	<div class="col-md-12">
		<div class="well well-sm ">
			<div class="row no-margin">
				<div class="col-md-6 smart-form no-padding">
					<section class="col col-6 no-margin ">
						<label class="input">
							<i class="icon-prepend fa fa-calendar"></i>
							<input type="text" class="datepicke" id="desde">
							<i class="tooltip tooltip-top-left">Fecha desde:</i>
						</label>
					</section>
					<section class="col col-6 no-margin">
						<label class="input">
							<i class="icon-append fa fa-calendar"></i>
							<input type="text" class="datepicke right" id="hasta">
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
	<div class="col-md-12">
		<div class="col-md-12">
			<section id="widget-grid" class="">
				<div class="row">
					<article class="col-sm-12 col-md-12 col-lg-12" style="padding:0">
						<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
							<header>
								<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
								<h2>Listado de Compras</h2>				
							</header>
							<div class="content">
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body no-padding">
									<table style="border-bottom: 1px solid rgba(0,0,0,.1) !important;" id="dt_basic" class="table table-condensed table-striped table-bordered table-hover" width="100%">
										<thead>			                
											<tr>
												<th>Cliente</th>
												<th>Articulo</th>
												<th>Peso</th>
												<th>Moneda</th>
												<th>Monto</th>
												<th>Fecha</th>
												<th>Estado</th>
												<th rel="tooltip" data-original-title="Reincorporar"><i class="fa fa-share"></i></th>
											</tr>
										</thead>
										<tbody id="tabla-cobros">
											
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
	
	var pagefunction = function() {
		
		$(".datepicke").datepicker({dateFormat:"dd/mm/yy"});
		var d = new Date(); 
		var m = d.getMonth() + 1;
		var y = d.getFullYear();
		$(".datepicke").val(('0' + (d.getDate())).slice(-2)+"/"+('0' + (m)).slice(-2)+"/"+y);
		
		table = $('#dt_basic').DataTable({
			dom: 'Bfrtip',
			buttons: [
            'excel', 'pdf'
			],
			"autoWidth" : true,
			"columnDefs": [
				{ targets: [0,1,2,3,4,5,6], className: "center vertical-center"},
				{ targets: [0], width: "20%"},
				{ targets: [1], width: "20%"},
				{ targets: [2], width: "15%"},
				{ targets: [3], width: "10%"},
				{ targets: [4], width: "10%"},
				{ targets: [5], width: "10%"},
				{ targets: [6], width: "10%"},
				{ targets: [7], width: "10%"},

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
		var desde = $("#desde").val();
		var hasta = $("#hasta").val();
		
		$.ajax({
			url:"php/reporte/compra/lista.php",
			type:"POST",
			data:{"DESDE":desde,"HASTA":hasta},
			success: function(resp){
				resp = JSON.parse(resp);
				$("#dt_basic").dataTable().fnClearTable();
				
				$.each(resp["MENSAJE"],function(indice,valor){
					var d = new Date();
					var E  = (valor["ELIM"] == 0)? "EJECUTADA":"ELIMINADA";
					var ELIM = (d.getFullYear()+"-"+('0' + (d.getMonth()+1)).slice(-2)+"-"+('0' + (d.getDate())).slice(-2) == valor["FECHA"])?"<button class='btn btn-sm btn-danger' onclick='elim("+valor["ID"]+")'><i class='fa fa-share'></i></button>":"";
					
					$("#dt_basic").dataTable().fnAddData([
						valor["CLIENTE"],
						valor["DESCRIPCION"],
						money(valor["DIMENSION"],2)+" "+valor["MEDIDA"],
						valor["MONEDA"],
						"$"+money(valor["PRECIO"]*valor["DIMENSION"]),
						tonormaldate(valor["FECHA"]),
						E,
						ELIM
					]);
				});
			}
		});
	}; 
	
	function elim(id){
		$.ajax({
			url:"php/compra/elim.php",
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
