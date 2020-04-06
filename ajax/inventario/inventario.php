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
	
	$temp = (array) $query->select(array("CODIGO","ARTICULO","sum(DIMENSION) as TOTAL"),"INVENTARIO","where VENDER = 0 GROUP BY ARTICULO,CODIGO");
?>

<div class="row">
	<div class="col-md-12">
		<?php
		
			foreach($temp as $indice => $valor){
				echo "
					<div class='col-md-3 ' style='margin-bottom:2%'>
						<div id='donut-graph".$indice."' class='chart no-padding'></div>
						<div class='btn-group btn-group-justified'>
							<a href='javascript:void(0);' onclick='ventaGlobal(".$valor['CODIGO'].",\"".$valor["ARTICULO"]."\",\"".number_format($valor["TOTAL"],3)."\")' class='btn btn-default'>Vender</a>
							<a href='javascript:void(0);' onclick='retiroGlobal(".$valor['CODIGO'].",\"".$valor["ARTICULO"]."\",\"".number_format($valor["TOTAL"],3)."\")' class='btn btn-default'>Retirar</a>
						</div>
					</div>
					
				";
				
			}
			
		
		?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="well well-sm">
			<div class="row">
				<div class="col-md-12">
				<button onclick="vender()" class="btn btn-success" rel="tooltip" data-placement="right" data-original-title="Enviar a venta las piezas seleccionadas">Vender</button>
				<button onclick="retirar()" class="btn btn-primary" rel="tooltip" data-placement="right" data-original-title="Retirar de Stock Directamente">Retirar</button>
				<button onclick="$('.pieza').prop('checked',false);" class="btn btn-danger pull-right" rel="tooltip" data-placement="bottom" data-original-title="Desmarcar todo"><i class="fa fa-th-list"></i></button>
				<button style="margin-right:1%" onclick="$('.pieza').prop('checked',true);" class="btn btn-primary pull-right" rel="tooltip" data-placement="left" data-original-title="Marcar todo"><i class="fa fa-th-list"></i></button>
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
								<h2>Articulos</h2>				
							</header>
							<div class="content">
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body no-padding">
									<table style="border-bottom: 1px solid rgba(0,0,0,.1) !important;" id="dt_basic" class="table table-condensed table-striped table-bordered table-hover" width="100%">
										<thead>			                
											<tr>
												<th class="center">Deposito</th>
												<th class="center">Articulo</th>
												<th class="center">Peso</th>
												<th class="center">Descripcion</th>
												<th class="center" rel="tooltip" data-placement="top" data-original-title="En venta"><i class="fa fa-lg fa-share"></i></th>
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
			"columnDefs": [
				{ targets: [0,1,2,3,4], className: "center vertical-center"},
				{ targets: [0], width: "15%"},
				{ targets: [1], width: "20%"},
				{ targets: [2], width: "15%"},
				{ targets: [3], width: "40%"},
				{ targets: [4], width: "10%"}

			],
			"autoWidth" : true
		});
		
		<?php
		
			foreach($temp as $indice => $valor){
				echo "
					
					
						if ($('#donut-graph".$indice."').length){ 
							Morris.Donut({
							  element: 'donut-graph".$indice."',
							  data: [{value: ".$valor["TOTAL"].", label: '".$valor["ARTICULO"]."'} ],
							  formatter: function (x) { return x + ' Gramos'}
							});
						}
					
				";
				
			}
			
		
		?>
		
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
										loadScript("js/plugin/morris/raphael.min.js", function(){
											loadScript("js/plugin/morris/morris.min.js", function(){
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
		});
	});
	
	function buscar(){
		$.ajax({
			url:"php/inventario/lista.php",
			success: function(resp){
				resp = JSON.parse(resp);
				$("#dt_basic").dataTable().fnClearTable();
				
				$.each(resp["MENSAJE"],function(indice,valor){
					var temp = (valor["VENDER"] != 0)? "checked":"";
					$("#dt_basic").dataTable().fnAddData([
						valor["DEPOSITO"],
						valor["ARTICULO"],
						valor["DIMENSION"]+" "+valor["MEDIDA"],
						valor["DESCRIPCION"],
						"<section class='smart-form'><label class='checkbox-inline'><input data-id='"+valor["ID"]+"' type='checkbox' class='checkbox style-0 pieza' "+temp+"><span style='margin-left:21%'></span></label></section>",
					]);
				});
			}
		});
	}; 
	
	function vender(){
		var canasta = [];
		$(".pieza").each(function(indice,valor){
			if($(this).is(":checked")){
				canasta.push($(this).attr("data-id"));
			}
		});
		if(canasta.length != 0){
			$.SmartMessageBox({
				title : "Esta apunto de enviar "+canasta.length+" Elementos a la venta, esta seguro?",
				buttons : "[Cancelar][Aceptar]",
			}, function(ButtonPress) {
				if (ButtonPress == "Aceptar") {
					$.ajax({
						url: "php/inventario/venta.php",
						type:"POST",
						data:{"DATO":JSON.stringify(canasta)},
						success: function(resp){
							resp = JSON.parse(resp);
							alerta(resp["ESTADO"],resp["MENSAJE"]);
							imprimirventa();
							buscar();
						}
					})
					
				}
			});	
		}else{
			alerta("error","No hay elementos seleccionados");
		}
		
	}
	
	function retirar(){
		var canasta = [];
		$(".pieza").each(function(indice,valor){
			if($(this).is(":checked")){
				canasta.push($(this).attr("data-id"));
			}
		});
		if(canasta.length != 0){
			$.SmartMessageBox({
				title : "Esta apunto de Retirar de Stock "+canasta.length+" Elementos , esta seguro?",
				buttons : "[Cancelar][Aceptar]",
			}, function(ButtonPress) {
				if (ButtonPress == "Aceptar") {
					$.ajax({
						url: "php/inventario/retiro.php",
						type:"POST",
						data:{"DATO":JSON.stringify(canasta)},
						success: function(resp){
							resp = JSON.parse(resp);
							alerta(resp["ESTADO"],resp["MENSAJE"]);
							buscar();
							imprimir();
						}
					})
					
				}
			});	
		}else{
			alerta("error","No hay elementos seleccionados");
		}
		
	}

	function retiroGlobal(V,A,M){
		$.SmartMessageBox({
				title : "Retiro de "+A+" por un total de "+M+" Gramos, confirmar?",
				buttons : "[Cancelar][Aceptar]",
			}, function(ButtonPress) {
				if (ButtonPress == "Aceptar") {
					$.ajax({
						url: "php/inventario/retiro_global.php",
						type:"POST",
						data:{"DATO":V},
						success: function(resp){
							//resp = JSON.parse(resp);
								console.log(resp);
							alerta('success','hola');
							
							//buscar();
							location.reload()
							imprimir();
						}
					})
					
				}
			});	
	}
	
	function ventaGlobal(V,A,M){
		$.SmartMessageBox({
				title : "Colocar en venta "+A+" por un total de "+M+" Gramos, confirmar?",
				buttons : "[Cancelar][Aceptar]",
			}, function(ButtonPress) {
				if (ButtonPress == "Aceptar") {
					$.ajax({
						url: "php/inventario/venta_global.php",
						type:"POST",
						data:{"DATO":V},
						success: function(resp){
							//resp = JSON.parse(resp);
							console.log(resp);
							alerta('success','venta');
							
							//buscar();
							location.reload()
							imprimirventa();
						}
					})
					
				}
			});	
	}

	function imprimir(){
			var win = window.open("ajax/impresion/retiro.php", '_blank');
			win.focus();
	};
	function imprimirventa(){
			var win = window.open("ajax/impresion/retiro_venta.php", '_blank');
			win.focus();
	};

</script>
