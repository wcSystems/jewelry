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
	$temp = (array) $query->select(array("SUM(ENTREGADO) as TOTAL"),"VCONTRATO","WHERE EMISION = CURDATE()");
	$deldia["LABEL"] = array() ;
	$deldia["DATO"]= array() ;
	foreach($temp as $indice => $valor){
		$deldia["LABEL"][] = "INVERTIDO";
		$deldia["DATO"][] = $valor["TOTAL"];
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
								<h2>Nuevo Contrato</h2>				
							</header>
							<div class="content">
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body no-padding">
									<form id="nuevo-form" onSubmit="event.preventDefault();" class="smart-form" action="php/contrato/nuevo.php" method="post">
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
										<header>Datos del Articulo</header>
										<fieldset>
											<section class="col col-6">
												<label class="input">
													<i class="icon-prepend fa fa-cube"></i>
													<select onchange="monedas($(this).val());contrato['ARTICULO'] = $(this).val()" name="articulo" style="text-align-last: center;" class="input-sm col-12 nocaret">
														<option value="NA" selected="" disabled="">Articulo</option>
														<?php
															$temp = (array) $query->select(array("distinct ID","DESCRIPCION"),"EARTICULO");
															
															foreach($temp as $indice => $valor){
																echo "<option value='".$valor["ID"]."'>".$valor["DESCRIPCION"]."</option>";
															}
															?>
													</select>
												</label>
											</section>
											<section class="col col-6">
												<label class="input">
													<i class="icon-append fa fa-dollar"></i>
													<select onchange="intereses();contrato['MONEDA'] = $(this).val()" name="moneda" style="text-align-last: center;" class="input-sm col-12 nocaret">
														<option value="NA">Moneda</option>
													</select>
												</label>
											</section>
											<section class="col col-6">
												<label class="input">
													<i class="icon-prepend fa fa-dollar"></i>
													<select onchange="precios();contrato['PORCENTAJE'] = $(this).val()" name="interes" style="text-align-last: center;" class="input-sm col-12 nocaret">
														<option value="NA">Interes mensual</option>
													</select>
												</label>
											</section>
											<section class="col col-12">
												<label class="input">
													<i class="icon icon-prepend fa fa-envelope"></i>
													<input name="peso" onkeyup="contrato['PESO'] = ($(this).val() != NaN)? $(this).val() : contrato['PESO'] ;calculo();" type="text" placeholder="Peso">
													<i class="tooltip tooltip-top-left">Peso de la pieza (en gramos)</i>
												</label>
											</section>
											<section class="col col-12">
												<label class="textarea">
													<i class="icon icon-prepend fa fa-pencil"></i>
													<textarea onkeyup="contrato['DESCRIPCION'] = $(this).val()" rows="5" placeholder="Descripcion"></textarea>
													<i class="tooltip tooltip-top-left">Agrgue una descripcion del articulo (opcional)</i>
												</label>
											</section>
										</fieldset>
										<header>Datos del Contrato</header>
										<fieldset>
											<section class="col col-6">
												<label class="input">
													<i class="icon-prepend fa fa-clock-o"></i>
													<select name="dias" onchange="contrato['DURACION'] = $(this).val()" style="text-align-last: center;" class="input-sm col-12 nocaret">
														<option value="0" selected="" disabled="">Duracion del contrato</option>
														<option value="30">30 Dias</option>
													</select>
												</label>
											</section>
											<section class="col col-6">
												<label class="input">
													<i class="icon-append fa  fa-usd"></i>
													<input name="precio" class="right" type="text" placeholder="Precio" readonly>
													<i class="tooltip tooltip-top-right">Precio por gramo</i>
												</label>
											</section>
											<section class="col col-6">
												<label class="input">
													<i class="icon-prepend fa fa-money"></i>
													<input name="monto" type="text" placeholder="Monto" readonly>
													<i class="tooltip tooltip-top-left">Monto total generado con intereses</i>
												</label>
											</section>
											<section class="col col-6">
												<label class="input">
													<i class="icon-append fa fa-money"></i>
													<input name="inter" class="right" type="text" placeholder="Monto del Interes" readonly>
													<i class="tooltip tooltip-top-right">Intereses discriminados</i>
												</label>
											</section>
											<section class="col col-6">
												<label class="input">
													<i class="icon-prepend fa fa-calendar"></i>
													<input name="emision" type="text" placeholder="Fecha de Emision" readonly>
													<i class="tooltip tooltip-top-left">Fecha de emision del contrato</i>
												</label>
											</section>
											<section class="col col-6">
												<label class="input">
													<i class="icon-append fa fa-calendar"></i>
													<input readonly name="vencimiento" class="right" type="text" placeholder="Fecha de vencimiento">
													<i class="tooltip tooltip-top-right">Fecha de Vencimiento</i>
												</label>
											</section>
											<section class="col col-6">
												<label class="input">
													<i class="icon-prepend fa fa-calendar"></i>
													<input name="final" type="text" placeholder="Monto de finiquito de contrato" readonly>
													<i class="tooltip tooltip-top-left">Monto de finiquito</i>
												</label>
											</section>
										</fieldset>
										<footer>
											<section class="col col-12 no-margin">
												<button class="btn btn-success right" type="submit">Generar Contrato</button>
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
										<header>Dolares invertidos en el dia</header>
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
	
	var contrato = {
		"CLIENTE" : "",
		"ARTICULO" : "",
		"MONEDA" : "",
		"PORCENTAJE" : "",
		"PESO" : "",
		"PRECIO" : "",
		"DURACION" : "",
		"EMISION" : "",
		"VENCIMIENTO" : "",
		"DESCRIPCION" : ""
	
	
	};

	pageSetUp();

	var pagefunction = function() {
		var now = new Date();
		now.setDate(now.getDate() + 30);
		var d = new Date(); 

		$("[name='emision']").val(d.getDate()+"/"+(d.getMonth() + 1)+"/"+d.getFullYear());
		$("[name='vencimiento']").val(now.getDate()+"/"+(now.getMonth() + 1)+"/"+now.getFullYear());
		
		contrato["EMISION"] = $("[name='emision']").val();
		contrato["VENCIMIENTO"] = $("[name='vencimiento']").val();
		
		var  LineConfig, barChartData, RadarConfig, DoughtnutConfig, PolarConfig, PieConfig;
		
		
		barChartData = {
			labels: deldia["LABEL"],
		    datasets: [{
				label: 'Dolares',
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
		contrato["CLIENTE"] = resp["ID"];
		$("[name='first']").val(resp["NOMBRE"]);
		$("[name='last']").val(resp["APELLIDO"]);
		$("[name='mail']").val(resp["EMAIL"]);
	}
	
	function check(V){
		var cont = 0;
		$.each(cliente,function(indice,valor){
			if(valor["DOCUMENTO"] == V){
				contrato["CLIENTE"] = valor["ID"];
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
	



	function intereses(V){
		
		A = $("[name='articulo']").val();
		M = $("[name='moneda']").val();
		
		$.ajax({
			url:"php/contrato/interes.php",
			type:"POST",
			data:{"DATO":A,"MONEDA":M},
			success: function(resp){
				resp = JSON.parse(resp);
				$("[name='interes']").empty();
				$("[name='interes']").append("<option value='0' selected='' disabled=''>Interes mensual</option>");
				$.each(resp["MENSAJE"],function(indice,valor){
					$("[name='interes']").append("<option value='"+valor["PRECIO"]+"'>"+valor["PORCENTAJE"]+"%-"+money(valor["PRECIO"])+"</option>");
				});

				console.log(resp)
			}
		})
	}



	
	function monedas(V){
		$.ajax({
			url:"php/contrato/moneda.php",
			type:"POST",
			data:{"DATO":V},
			success: function(resp){
				resp = JSON.parse(resp);
				$("[name='moneda']").empty();
				$("[name='moneda']").append("<option value='0' selected='' disabled=''>Moneda</option>");
				$.each(resp["MENSAJE"],function(indice,valor){
					$("[name='moneda']").append("<option value='"+valor["MONEDA"]+"'>"+moneda[valor["MONEDA"]]["DESCRIPCION"]+"</option>");
				});
			}
		})
	}
	
	function precios(){
		var A = $("[name='articulo']").val();
		var M = $("[name='moneda']").val();
		var I = $("[name='interes']").val();
		
		$.ajax({
			url:"php/contrato/precio.php",
			type:"POST",
			data:{"A":A,"M":M,"I":I},
			success: function(resp){
				resp = JSON.parse(resp);
				contrato["PORCENTAJE"] = resp["MENSAJE"]["PORCENTAJE"];
				contrato["PRECIO"] = resp["MENSAJE"]["PRECIO"];
				$("[name='precio']").val(money(resp["MENSAJE"]["PRECIO"]));

				calculo()
				console.log(I)


			}
		})
		
	}
	
	function calculo(){
		var monto = contrato["PRECIO"] * contrato["PESO"];
		$("[name='monto']").val(money(monto));
		var interes = (monto * contrato["PORCENTAJE"]) / 100;
		$("[name='inter']").val(money(interes));
		var finiquito = monto + interes
		$("[name='final']").val(money(finiquito));
		
	};
	
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
				interes : {
					required : true
				},
				peso : {
					required : true,
					minlength : 1
				},
				dias : {
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
				 $(form).ajaxSubmit({data:{DATO:JSON.stringify(contrato)},success: function(resp){resp = JSON.parse(resp);alerta(resp["ESTADO"],resp["MENSAJE"]["MENSAJE"]);imprimir(resp["MENSAJE"]["CONTRATO"]);}});
			}
		});
	});
	
	function imprimir(IDE){
		if(IDE != undefined){
			var win = window.open("ajax/impresion/contrato.php?CONTRATO="+IDE+"&INICIO="+contrato["EMISION"]+"&VENCE="+contrato["VENCIMIENTO"]+"&CLIENTE="+contrato["CLIENTE"]+"&DESCRIPCION="+contrato["DESCRIPCION"]+"&ARTICULO="+$("[name='articulo'] option:selected").html()+"&PESO="+contrato["PESO"]+"&FINIQUITO="+$("[name='final']").val()+"&INTERES="+$("[name='inter']").val(), '_blank');
			win.focus();
		};
	};
	
</script>

