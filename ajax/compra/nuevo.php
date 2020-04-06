<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../php/API/query.php";
	include "../../php/API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../../php/API/parametro.php";
	
	$deldia = array();
	$temp = (array) $query->select(array("SUM(DIMENSION) as DIMENSION","DESCRIPCION"),"VCOMPRA","WHERE FECHA = CURDATE() GROUP BY DESCRIPCION");
	$deldia["LABEL"] = array() ;
	$deldia["DATO"]= array() ;
	foreach($temp as $indice => $valor){
		$deldia["LABEL"][] = $valor["DESCRIPCION"];
		$deldia["DATO"][] = $valor["DIMENSION"];
	};
?>

<div class="row">
	<div class="col-md-12">
		<div class="well well-sm">
			<button id="nuevo" href="ajax/cliente/modal/nuevo.php" data-toggle="modal" data-target="#detalle" data-placement="right" rel="tooltip" data-original-title="Ingresar Nuevo cliente" class="btn btn-success"><i class="fa fa-plus"></i></button>
		</div>		
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="col-md-12">
			<section id="widget-grid" class="">
				<div class="row">
					<article class="col-sm-12 col-md-7 col-lg-7" style="padding:0">
						<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
							<header>
								<span class="widget-icon"> <i class="fa fa-file"></i> </span>
								<h2>Nuevo Compra</h2>				
							</header>
							<div class="content">
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body no-padding">
									<form id="nuevo-form" onSubmit="event.preventDefault();" class="smart-form" action="php/compra/compra.php" method="post">
										<header>Datos del Cliente</header>
										<fieldset>
											<section class="col col-12 no-padding no-margin">
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-prepend fa fa-credit-card"></i>
														<input onblur="check($(this).val())" name="doc" type="text" placeholder="Documento">
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
										<header>Datos del articulo</header>
										<fieldset>
											<section class="col col-12 no-padding no-margin">
												<section class="col col-12">
													<label class="input">
														<i class="icon icon-prepend fa fa-cube"></i>
														<select onchange="monedas($(this).val());compra['ARTICULO'] = $(this).val()" name="articulo" style="text-align-last: center;" class="input-sm col-12 nocaret">
														<option value="NA" selected="" disabled="">Articulo</option>
														<?php
															$temp = (array) $query->select(array("distinct ID","DESCRIPCION"),"CARTICULO");
															
															foreach($temp as $indice => $valor){
																echo "<option value='".$valor["ID"]."'>".$valor["DESCRIPCION"]."</option>";
															}
															?>
													</select>
													</label>
												</section>
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-prepend fa fa-money"></i>
														<select onchange="compra['MONEDA'] = $(this).val();precios();" name="moneda" style="text-align-last: center;" class="input-sm col-12 nocaret">
															<option value="NA">Moneda</option>
														</select>
													</label>
												</section>
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-append fa fa-money"></i>
														<select onchange="compra['PRECIO'] = $(this).val();calculo();" name="precio" style="text-align-last: center;" class="input-sm col-12 nocaret">
															<option value="NA">Precio</option>
														</select>
													</label>
												</section>
											</section>
										</fieldset>
										<header>Detalle de la compra</header>
										<fieldset>
											<section class="col col-6">
												<label class="input">
													<i class="icon icon-prepend fa fa-dollar"></i>
													<input name="peso" onkeyup="compra['PESO'] = ($(this).val() != NaN)? $(this).val() : compra['PESO'] ;calculo();" type="text" placeholder="Peso de la pieza (en gramos)">
													<i class="tooltip tooltip-top-left">Peso por gramo de la pieza</i>
												</label>
											</section>	
											<section class="col col-6">
												<label class="input">
													<i class="icon icon-append fa fa-dollar"></i>
													<input name="total" class="right" type="text" placeholder="Precio" readonly>
													<i class="tooltip tooltip-top-right">Precio total de la compra</i>
												</label>
											</section>	
										</fieldset>
										<footer>
											<section class="col col-12 no-margin">
												<button class="btn btn-success right" type="submit" id='ejecutor'>Ejecutar compra</button>
												<button href="ajax/compra/modal/split.php" data-toggle="modal" data-target="#detalle" class="btn btn-primary pull-left" type="button">Realizar Split</button>
											</section>
										</footer>
									</form>
								</div>
							</div>
						</div>
					</article>
					<article class="col-sm-12 col-md-5 col-lg-5" style="padding-right:0">
						<div class="jarviswidget jarviswidget-color-darken" id="wid-id-2" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
							<header>
								<span class="widget-icon"> <i class="fa fa-file"></i> </span>
								<h2>Datos adicionales</h2>				
							</header>
							<div class="content">
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body no-padding">
									<form class="smart-form">
										<header>Compras del dia</header>
										<div class="col-md-12 col-sm-12">
											<canvas id="barChart" height="140"></canvas>
										</div>
										<header>Puntuacion del cliente</header>
										<div class="col-md-12 col-sm-12">
											<canvas id="doughnutChart" height="140"></canvas>
										</div>
									</div>
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
	var moneda = JSON.parse('<?php echo json_encode($moneda); ?>');
	var errorClass = 'invalid';
	var errorElement = 'em';
	
	var deldia = JSON.parse('<?php echo json_encode($deldia); ?>');
	var compra = {
		"CLIENTE" : "",
		"ARTICULO" : "",
		"MONEDA" : "",
		"PESO" : "",
		"PRECIO" : "0",
		"DESCRIPCION" : " ",
		"SPLIT" : []
	};

	pageSetUp();

	var  LineConfig, barChartData, RadarConfig, DoughtnutConfig, PolarConfig, PieConfig;

	var pagefunction = function() {
		barChartData = {
			labels: deldia["LABEL"],
		    datasets: [{
				label: 'Gramos',
		        backgroundColor: "rgba(151,187,205,0.5)",
		        data: deldia["DATO"]
		     }]
		};
		        
		myBar = new Chart(document.getElementById("barChart"), {
	            type: 'bar',
	                data: barChartData,
	                options: {
	                    responsive: true,
	                }
	            });
	};

	loadScript("js/plugin/moment/moment.min.js", function(){
		loadScript("js/plugin/chartjs/chart.min.js", pagefunction);
	}); 
	
	
	function creado(resp){
		compra["CLIENTE"] = resp["ID"];
		$("[name='first']").val(resp["NOMBRE"]);
		$("[name='last']").val(resp["APELLIDO"]);
		$("[name='mail']").val(resp["EMAIL"]);
	}
	
	function check(V){
		var cont = 0;
		$.each(cliente,function(indice,valor){
			if(valor["DOCUMENTO"] == V){
				compra["CLIENTE"] = valor["ID"];
				$("[name='first']").val(valor["NOMBRE"]);
				$("[name='last']").val(valor["APELLIDO"]);
				$("[name='mail']").val(valor["EMAIL"]);
				cont++;
				$.ajax({
					url:"php/cliente/puntuacion.php",
					type:"POST",
					data:{"DATO":valor["ID"]},
					success: function(resp){
						resp = JSON.parse(resp);
						var	DoughtnutConfig = {
			        type: 'doughnut',
			        data: {
			            datasets: [{
			                data: resp["MENSAJE"]["DATO"],
			                backgroundColor: [
			                    "#F7464A",
			                    "#46BFBD",
			                   
			                ],
			                label: 'Dataset 1'
			            }],
			            labels: resp["MENSAJE"]["LABEL"]
			        },
			        options: {
			            responsive: true,
			            legend: {
			                position: 'top',
			            }
			        }
			    };
		        
					    var	myBar = new Chart(document.getElementById("doughnutChart"), DoughtnutConfig);
					
				}
			});
			}	
		});
		if(cont == 0){
			$("#nuevo").click();
		}
	}
	
	function monedas(V){
		$.ajax({
			url:"php/compra/moneda.php",
			type:"POST",
			data:{"DATO":V},
			success: function(resp){
				resp = JSON.parse(resp);
				$("[name='moneda']").empty();
				$("[name='moneda']").append("<option value='0' selected='' disabled=''>Monedas</option>");
				$.each(resp["MENSAJE"],function(indice,valor){
					$("[name='moneda']").append("<option value='"+valor["MONEDA"]+"'>"+moneda[valor["MONEDA"]]["DESCRIPCION"]+"</option>");
				});
			}
		})
	}
	
	function precios(){
		var A = $("[name='articulo']").val();
		var M = $("[name='moneda']").val();
		
		$.ajax({
			url:"php/compra/precio.php",
			type:"POST",
			data:{"A":A,"M":M},
			success: function(resp){
				resp = JSON.parse(resp);
				$("[name='precio']").empty();
				$("[name='precio']").append("<option value='0' selected='' disabled=''>Precio</option>");
				$.each(resp["MENSAJE"],function(indice,valor){
					$("[name='precio']").append("<option value='"+valor["PRECIO"]+"'>"+money(valor["PRECIO"])+"</option>");
				});
			}
		})
		
	}
	
	function calculo(){
		
		$("[name='total']").val(money(compra["PESO"] * compra["PRECIO"]));
		
	}
	
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
				doc : {
					required : true,
					minlength : 1,
					digits:true
				},
				first : {
					required : true,
					minlength : 1
				},
				last : {
					required : true,
					minlength : 1
				},
				direccion : {
					required : true,
					minlength : 1
				},
				email : {
					required : false,
					minlength : 1,
					email:true
				},
				articulo : {
					required : true
				},
				moneda : {
					required : true
				},
				
				peso : {
					required : true,
					minlength : 1
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
				 
				 $.SmartMessageBox({
					title : "Desea realizar una compra por concepto de $"+money(compra["PESO"]*compra["PRECIO"])+" "+moneda[compra["MONEDA"]]["DESCRIPCION"],
					buttons : "[Cancelar][Aceptar]",
				}, function(ButtonPress) {
					if (ButtonPress == "Aceptar") {
						$("#ejecutor").attr("disabled","disabled");
						$(form).ajaxSubmit({data:{DATO:JSON.stringify(compra)},success: function(resp){resp = JSON.parse(resp);alerta(resp["ESTADO"],resp["MENSAJE"]["MENSAJE"]);imprimir(resp["MENSAJE"]["ID"]);$("#ejecutor").removeAttr("disabled");}});
					}
				});	
				 
				 
			}
		});
	});
	
	function imprimir(ID){
		if(ID != undefined){
			var win = window.open("ajax/impresion/compra.php?DOC=" +$("[name='doc']").val()+"&CLIENTE="+$("[name='first']").val()+" "+$("[name='last']").val()+"&ID="+ID+"&MONEDA="+moneda[compra["MONEDA"]]["DESCRIPCION"]+"&MONTO="+money(compra["PESO"]*compra["PRECIO"])+"&TAZA="+money(compra["SPLIT"]["TAZA"])+"&DIFERENCIA="+money(compra["SPLIT"]["DIFERENCIA"]*compra["SPLIT"]["TAZA"])+"&CAMBIO="+money(compra["SPLIT"]["DIFERENCIA"])+"&ARTICULO="+$("[name='articulo'] option:selected").html()+"&PESO="+compra["PESO"]+"", '_blank');
			win.focus();
		}
		
	};
</script>
