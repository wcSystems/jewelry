<div class="row">
	<div class="col-md-12">
		<div class="well well-sm">
			<button href="ajax/cliente/modal/nuevo.php" data-toggle="modal" data-target="#detalle" data-placement="right" rel="tooltip" data-original-title="Ingresar Nuevo cliente" class="btn btn-success"><i class="fa fa-plus"></i></button>
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
								<h2>Listado de Clientes</h2>				
							</header>
							<div class="content">
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body no-padding">
									<table style="border-bottom: 1px solid rgba(0,0,0,.1) !important;" id="dt_basic" class="table table-condensed table-striped table-bordered table-hover" width="100%">
										<thead>			                
											<tr>
												<th>Cliente</th>
												<th>Documento</th>
												<th>Telefono</th>
												<th><i class="fa fa-lg fa-search"></i></th>
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
		
		table = $('#dt_basic').DataTable({
			dom: 'Bfrtip',
			buttons: [
            'excel', 'pdf', 'colvis'
			],
			"autoWidth" : true,
			"columnDefs": [
				{ targets: [0,1,2,3], className: "center vertical-center"},
				{ targets: [0], width: "30%"},
				{ targets: [1], width: "30%"},
				{ targets: [2], width: "30%"},
				{ targets: [3], width: "10%"}

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
			url:"php/cliente/lista.php",
			success: function(resp){
				resp = JSON.parse(resp);
				$("#dt_basic").dataTable().fnClearTable();
				
				$.each(resp["MENSAJE"],function(indice,valor){
					$("#dt_basic").dataTable().fnAddData([
						valor["NOMBRE"]+" "+valor["APELLIDO"],
						valor["DOCUMENTO"],
						valor["TELEFONO"],
						"<button class='btn btn-primary' href='ajax/cliente/modal/nuevo.php?ID="+valor["ID"]+"' data-toggle='modal' data-target='#detalle'><i class='fa fa-search'></i></button>"
					]);
				});
			}
		});
	}; 
</script>
