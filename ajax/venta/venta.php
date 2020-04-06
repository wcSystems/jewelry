<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../php/API/query.php";
	include "../../php/API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../../php/API/parametro.php";
	
	$temp = (array) $query->select(array("ID","MONEDA","PRECIO"),"VARTICULO");
	$arte = array();
	foreach($temp as $indice => $valor){
		$arte[$valor["ID"]][$valor["MONEDA"]][] = $valor["PRECIO"];
	};
	
	
	
?>

<div class="row">
	<div class="col-md-12">
		<div class="well well-sm">
			<button data-placement="right" rel="tooltip" data-original-title="Nueva Venta" class="btn btn-primary"><i class="fa fa-plus"></i></button>
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
						<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
							<header>
								<span class="widget-icon"> <i class="fa fa-file"></i> </span>
								<h2>Nueva Venta</h2>				
							</header>
							<div class="content">
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body no-padding">
									<form class="smart-form">
										<header>Datos del Cliente</header>
										<fieldset>
											<section class="col col-12 no-padding no-margin">
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-prepend fa fa-credit-card"></i>
														<input name="doc" onblur="check($(this).val())" type="text" placeholder="Documento">
														<i class="tooltip tooltip-top-left">Documento del Cliente</i>
													</label>
												</section>
											</section>
											<section class="col col-6">
												<label class="input">
													<i class="icon icon-prepend fa fa-user"></i>
													<input name="first" type="text" placeholder="Nombre" readonly>
													<i class="tooltip tooltip-top-left">Nombre del Cliente</i>
												</label>
											</section>
											<section class="col col-6">
												<label class="input">
													<i class="icon icon-prepend fa fa-user"></i>
													<input name="last" type="text" placeholder="Apellido" readonly>
													<i class="tooltip tooltip-top-left">Apellido del Cliente</i>
												</label>
											</section>
											<section class="col col-12">
												<label class="input">
													<i class="icon icon-prepend fa fa-envelope"></i>
													<input name="mail" type="text" placeholder="Email" readonly>
													<i class="tooltip tooltip-top-left">Correo electronico</i>
												</label>
											</section>
										</fieldset>
										</form>
										<table style="border-bottom: 1px solid rgba(0,0,0,.1) !important;" id="dt_basic" class="table table-condensed table-striped table-bordered table-hover" width="100%">
											<thead>			                
												<tr>
													<th class="center">Deposito</th>
													<th class="center">Articulo</th>
													<th class="center">Peso</th>
													<th class="center">Moneda</th>
													<th class="center">Precio</th>
													<th class="center">Precio Final</th>
													<th class="center" rel="tooltip" data-placement="top" data-original-title="En venta"><i class="fa fa-lg fa-share"></i></th>
												</tr>
											</thead>
											<tbody id="tabla-cobros">
												
											</tbody>
										</table>
										<form class="smart-form">
										<header>Detalle de la compra</header>
										<fieldset>
											<section class="col col-6">
												<label class="input">
													<i class="icon icon-prepend fa fa-dollar"></i>
													<input id='gramos' type="text" placeholder="Total de gramos acumulados" readonly>
													<i class="tooltip tooltip-top-left">Total de Gramos acumulados</i>
												</label>
											</section>	
											<section class="col col-6">
												<section class="col col-6">
													<label class="input state-success">
														<i class="icon icon-append fa fa-dollar"></i>
														<input id="dolares" class="right" type="text" placeholder="Total en dolares" readonly>
														<i class="tooltip tooltip-top-right">Total en dolares</i>
													</label>
												</section>
												<section class="col col-6">
													<label class="input state-error">
														<i class="icon icon-append fa fa-dollar"></i>
														<input id="bolivares" class="right" type="text" placeholder="Total en Bolivares" readonly>
														<i class="tooltip tooltip-top-right">Total en Bolivares</i>
													</label>
												</section>
											</section>
												
										</fieldset>
										<footer>
											<section class="col col-12 no-margin">
												<button id="ejecuta" class="btn btn-success right" type="button" onclick="enviar();">Ejecutar venta</button>
												<button onclick="calculo()" class="btn btn-primary pull-left" type="button">Recalcular precio</button>
											</section>
										</footer>
									</form>
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
	
	var cliente = JSON.parse('<?php echo json_encode($cliente); ?>');
	var arte = JSON.parse('<?php echo json_encode($arte); ?>');
	var moneda = JSON.parse('<?php echo json_encode($moneda); ?>');
	pageSetUp();
	
	var objeto = {
		CLIENTE : "",
		PIEZAS : []
	};
	
	var pagefunction = function() {
		
		table = $('#dt_basic').DataTable({
			dom: 'Bfrtip',
			buttons: [
            'excel', 'pdf'
			],
			"columnDefs": [
				{ targets: [0,1,2,3,4,5,6], className: "center vertical-center"},
				{ targets: [0], width: "15%"},
				{ targets: [1], width: "20%"},
				{ targets: [2], width: "15%"},
				{ targets: [3], width: "20%"},
				{ targets: [4], width: "20%"},
				{ targets: [5], width: "20%"},
				{ targets: [6], width: "10%"}

			],
			"autoWidth" : true
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

	function creado(resp){
		objeto["CLIENTE"] = resp["ID"];
		$("[name='first']").val(resp["NOMBRE"]);
		$("[name='last']").val(resp["APELLIDO"]);
		$("[name='mail']").val(resp["EMAIL"]);
	}
	
	function check(V){
		var cont = 0;
		$.each(cliente,function(indice,valor){
			if(valor["DOCUMENTO"] == V){
				objeto["CLIENTE"] = valor["ID"];
				$("[name='first']").val(valor["NOMBRE"]);
				$("[name='last']").val(valor["APELLIDO"]);
				$("[name='mail']").val(valor["EMAIL"]);
				cont++;
			}
		});
		if(cont == 0){
			$("#nuevo").click();
		}
	}
	
	function buscar(){
		$.ajax({
			url:"php/venta/lista.php",
			success: function(resp){
				resp = JSON.parse(resp);
				$("#dt_basic").dataTable().fnClearTable();
				var I = "";
				$.each(resp["MENSAJE"],function(indice,valor){
					I = "";
					$.each(arte[valor["CODIGO"]],function(indice,valor){
						I += "<option value='"+indice+"'>"+moneda[indice]["DESCRIPCION"]+"</option>";
					});
					
					$("#dt_basic").dataTable().fnAddData([
						valor["DEPOSITO"],
						valor["ARTICULO"],
						valor["DIMENSION"].toFixed(2)+" "+valor["MEDIDA"],
						"<section class='smart-form'><label class='select'><select style='text-align-last:center' class='center "+valor["CODIGO"]+"moneda' onchange='monetizar("+valor["CODIGO"]+","+valor["CODIGO"]+",$(this).val())'><option value='0' selected='' disabled=''>Moneda</option>"+I+"</select></label></section>",
						"<section class='smart-form'><label  class='select'><select style='text-align-last:center' class='"+valor["CODIGO"]+"precio'  onchange='$(\"."+valor["CODIGO"]+"final\").val($(this).val());calculo()'><option value='0' selected='' disabled=''>Precio</option></select></label></section>",
						"<section class='smart-form'><label  class='input'><input onkeyup='calculo();' class='"+valor["CODIGO"]+"final' type='text'></label></section>",
						"<section class='smart-form'><label class='checkbox-inline'><input onchange='calculo();' data-id='"+valor["CODIGO"]+"' data-peso='"+valor["DIMENSION"]+"' type='checkbox' class='checkbox style-0 pieza'><span style='margin-left:21%'></span></label></section>",
					]);
				});
			}
		});
	}; 
	
	function monetizar(CODIGO,ID,MONEDA){
		var I = "";
		
		$.each(arte[CODIGO][MONEDA],function(indice,valor){
			I += "<option value='"+valor+"'>"+money(valor)+"</option>";
		});
		
		$("."+ID+"precio").empty();
		$("."+ID+"precio").append("<option value='0' selected='' disabled=''>Precio</option>");
		$("."+ID+"precio").append(I);
	}
	
	function calculo(){
		var gramos = 0;
		var dolares = 0;
		var bolivares = 0;
		var tempe = [];
		
		
		$(".pieza").each(function(){
			
			if($(this).prop("checked") == true){
				gramos += parseFloat($(this).attr("data-peso"));
				if($("."+$(this).attr("data-id")+"moneda").val() == 1){
					dolares += $(this).attr("data-peso") * $("."+$(this).attr("data-id")+"final").val();
					
					tempe[$(this).attr("data-id")] = {
						PIEZA : $(this).attr("data-id"),
						MONEDA : 1,
						PRECIO : $("."+$(this).attr("data-id")+"final").val()
					};
				}else{
					bolivares += $(this).attr("data-peso") * $("."+$(this).attr("data-id")+"final").val();
					tempe[$(this).attr("data-id")] = {
						PIEZA : $(this).attr("data-id"),
						MONEDA : 2,
						PRECIO : $("."+$(this).attr("data-id")+"final").val()
					};
				}
				
			}
		});
		
		objeto["PIEZAS"] = tempe;
		
		$("#gramos").val(money(gramos));
		$("#dolares").val(money(dolares));
		$("#bolivares").val(money(bolivares));
		
	}
	
	function enviar(){
		$.SmartMessageBox({
				title : "Confirme la Ejecucion de la venta",
				buttons : "[Cancelar][Aceptar]",
			}, function(ButtonPress) {
				if (ButtonPress == "Aceptar") {
					if(objeto["CLIENTE"] == ""){
						alerta("error","Debe seleccionar primero un cliente al cual vender");
					}else if(objeto["PIEZAS"].length == 0){
						alerta("error","No hay piezas seleccionadas");
					}else{
						$.ajax({
							url:"php/venta/venta.php",
							type:"POST",
							data:{"DATO":JSON.stringify(objeto)},
							beforeSend: function(){
								$("#ejecuta").attr("disabled","disabled");
							},
							success: function(resp){
								resp = JSON.parse(resp);
								console.log(resp);
								$("#ejecuta").removeAttr("disabled");
								alerta(resp["ESTADO"],resp["MENSAJE"]);
								inprimir();
								buscar();
							}
						})
					}
				}
		});
	};
	function inprimir(){
		var win = window.open("ajax/impresion/venta.php?DOC=" +$("[name='doc']").val()+"&CLIENTE="+$("[name='first']").val()+" "+$("[name='last']").val()+"",'_blank');
		win.focus();
	}
</script>
