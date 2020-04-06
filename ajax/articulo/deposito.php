<div class="row">
	<div class="col-md-12">
		<div class="well well-sm">
			<button href="ajax/articulo/modal/deposito.php" data-toggle="modal" data-target="#detalle" data-placement="right" rel="tooltip" data-original-title="Nuevo deposito" class="btn btn-success"><i class="fa fa-plus"></i></button>
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
								<h2>Depositos</h2>				
							</header>
							<div class="content">
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body no-padding">
									<table style="border-bottom: 1px solid rgba(0,0,0,.1) !important;" id="dt_basic" class="table table-condensed table-striped table-bordered table-hover" width="100%">
										<thead>			                
											<tr>
												<th>Nombre</th>
												<th>Estado</th>
												<th><i class="fa fa-lg fa-search"></i></th>
												<th><i class="fa fa-lg fa-trash-o"></i></th>
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
            'excel', 'pdf'
			],
			"autoWidth" : true,
			"columnDefs": [
				{ targets: [0,1,2,3], className: "center vertical-center"},
				{ targets: [0], width: "70%"},
				{ targets: [1], width: "10%"},
				{ targets: [2], width: "10%"},
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
			url:"php/articulo/deposito/lista.php",
			success: function(resp){
				resp = JSON.parse(resp);
				$("#dt_basic").dataTable().fnClearTable();
				
				$.each(resp["MENSAJE"],function(indice,valor){
					var C = (valor["HABILITADO"] == "1")? "CHECKED" : "";
					$("#dt_basic").dataTable().fnAddData([
						valor["NOMBRE"],
						"<section class='smart-form'><label class='checkbox-inline'><input data-id='"+valor["ID"]+"' onchange='habilitado("+valor["ID"]+",$(this).is(\":CHECKED\"))' type='checkbox' class='checkbox style-0' "+C+"><span style='margin-left:21%'></span></label></section>",
						"<button class='btn btn-primary' href='ajax/articulo/modal/deposito.php?ID="+valor["ID"]+"' data-toggle='modal' data-target='#detalle'><i class='fa fa-search'></i></button>",
						"<button class='btn btn-danger' onclick='elim("+valor["ID"]+")'><i class='fa fa-trash-o'></i></button>"
					]);
				});
			}
		});
	};
	function elim(id){
		$.ajax({
			url: "php/articulo/deposito/elim.php",
			type: "POST",
			data:{"DATO":id},
			success: function(resp){
				resp = JSON.parse(resp);
				alerta(resp["ESTADO"],resp["MENSAJE"]);
				buscar();
			}
		});
	}
	
	function habilitado(id,estado){
		estado = (estado)?1:0;
		$.ajax({
			url: "php/articulo/deposito/habilitado.php",
			type: "POST",
			data:{"DATO":id,"ESTADO":estado},
			success: function(resp){
				resp = JSON.parse(resp);
				alerta(resp["ESTADO"],resp["MENSAJE"]);
				buscar();
			}
		});
	}
</script>
