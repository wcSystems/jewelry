<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 no-padding">
			<div class="well well-sm">
				<a href="ajax/modal/usuario.php" data-toggle="modal" data-target="#formulario-usuario" rel="tooltip" data-placement="top" data-original-title="Nuevo Usuario"  class="btn btn-success"><i class="fa fa-plus"></i></a>
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
								<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
								<h2>Listado de usuarios</h2>				
							</header>
							<div class="content">
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body no-padding">
									<table style="border: 1px solid rgba(0,0,0,.1) !important;" id="dt_basic" class="table table-condensed table-striped table-bordered table-hover" width="100%">
										<thead>			                
											<tr>
												<th data-hide="Nombre">Nombre</th>
												<th data-hide="Apellido">Apellido</th>
												<th data-hide="Email">Email</th>
												<th data-hide="Habilitado">Habilitado</th>
												<th data-hide="Detalle">Detalle</th>
											</tr>
										</thead>
										<tbody id="tabla-usuarios">
											
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
<div class="modal fade" id="formulario-usuario" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">  
    <div class="modal-dialog">  
        <div class="modal-content"></div>  
    </div>  
</div>

<script>
	


	/* DO NOT REMOVE : GLOBAL FUNCTIONS!
	 *
	 * pageSetUp(); WILL CALL THE FOLLOWING FUNCTIONS
	 *
	 * // activate tooltips
	 * $("[rel=tooltip]").tooltip();
	 *
	 * // activate popovers
	 * $("[rel=popover]").popover();
	 *
	 * // activate popovers with hover states
	 * $("[rel=popover-hover]").popover({ trigger: "hover" });
	 *
	 * // activate inline charts
	 * runAllCharts();
	 *
	 * // setup widgets
	 * setup_widgets_desktop();
	 *
	 * // run form elements
	 * runAllForms();
	 *
	 ********************************
	 *
	 * pageSetUp() is needed whenever you load a page.
	 * It initializes and checks for all basic elements of the page
	 * and makes rendering easier.
	 *
	 */

	pageSetUp();
	
	/*
	 * ALL PAGE RELATED SCRIPTS CAN GO BELOW HERE
	 * eg alert("my home function");
	 * 
	 * var pagefunction = function() {
	 *   ...
	 * }
	 * loadScript("js/plugin/_PLUGIN_NAME_.js", pagefunction);
	 * 
	 * TO LOAD A SCRIPT:
	 * var pagefunction = function (){ 
	 *  loadScript(".../plugin.js", run_after_loaded);	
	 * }
	 * 
	 * OR
	 * 
	 * loadScript(".../plugin.js", run_after_loaded);
	 */

	// PAGE RELATED SCRIPTS

	// pagefunction
	
	var pagefunction = function() {
		
		
			table = $('#dt_basic').DataTable({
			dom: 'Bfrtip',
			buttons: [
           'colvis'
			],
			"autoWidth" : true,
			"columnDefs": [
				{ targets: [0,1,2,3,4], className: "center vertical-center"},
				{ targets: [0], width: "20%"},
				{ targets: [1], width: "20%"},
				{ targets: [2], width: "25%"},
				{ targets: [3], width: "10%"},
				{ targets: [4], width: "5%"},

			]
		});
		
		user();
	};
	
	
	// end pagefunction
	
	// run pagefunction on load
	
	loadScript("js/datatable/jquery.dataTables.min.js", function(){
		loadScript("js/datatable/dataTables.buttons.min.js", function(){
			loadScript("js/datatable/dataTables.responsive.min.js", function(){
				loadScript("js/datatable/buttons.colVis.min.js", pagefunction);
			});
		});
	});

	
function user(){
	$.ajax({
		url:"php/usuario/Lusuario.php",
		type: "POST"
	}).done(function(resp){
		resp = JSON.parse(resp);
		$("#dt_basic").dataTable().fnClearTable();

		$.each(resp["MENSAJE"],function(indice,valor){
			var temp = "";
			if(valor["HABILITADO"] == 1){
				temp = "checked"
			}
			
			$("#dt_basic").dataTable().fnAddData([
				valor["NOMBRE"],
				valor["APELLIDO"],
				valor["EMAIL"],
				"<section class='smart-form'><label class='checkbox-inline'><input data-id='"+valor["ID"]+"' onchange='habilitar("+valor["ID"]+")' type='checkbox' class='checkbox style-0 modulo' "+temp+"><span style='margin-left:21%'></span></label></section>",
				"<button class='btn btn-primary' href='ajax/modal/Eusuario.php?ID="+valor["ID"]+"' data-toggle='modal' data-target='#formulario-usuario'><i class='fa fa-search'></i></button>"
			]);
		});
	});
}

function habilitar(id){
	$.ajax({
		url:"php/usuario/habilitado.php",
		type: "POST",
		data:{ID:id},
		beforeSend: function(){
		
		}
	}).done(function(resp){
		resp = JSON.parse(resp);
		alerta(resp["ESTADO"],resp["MENSAJE"]);
	});
	
	
}

</script>
