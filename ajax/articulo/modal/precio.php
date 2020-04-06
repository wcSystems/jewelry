<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../../php/API/query.php";
	include "../../../php/API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../../../php/API/parametro.php";
	
	$objeto = array(
		"ARTICULO" => $_GET["ID"],
		"MONEDA" => 1,
		"PRECIO" => 0.00,
		"PORCENTAJE" => 00,
		"USO" => 1
	);
?>

<div class="modal-body no-padding">  
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-12">
				<section id="widget-grid" class="">
					<div class="row">
						<article class="col-sm-12 col-md-12 col-lg-12" style="padding:0">
							<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" style="margin-bottom:0" data-widget-editbutton="false" data-widget-custombutton="false">
								<header>
									<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
									<h2>Planilla de precio</h2>				
								</header>  
								<div class="content">
									<div class="widget-body no-padding">
										<form id="nuevo-form" onSubmit="event.preventDefault();" class="smart-form" action="php/articulo/precio/precio.php" method="post">
											<footer style="border-bottom: 1px solid rgba(0,0,0,.1) !important;">
												
												<section class="col col-12 no-margin btn-group btn-group-justified no-padding">
													<a onclick="objeto['USO'] = 1;setListado(1);$('#head').text('Contratos');$('#hideable').css('visibility','visible');$('.por').css('display','block');" class="btn btn-success" style="float:none" type="button">Contratos</a>
													<a onclick="objeto['USO'] = 2;setListado(2);$('#head').text('Compras');$('#hideable').css('visibility','hidden');$('.por').css('display','none');" class="btn btn-success" style="float:none" type="button">Compras</a>
													<a onclick="objeto['USO'] = 3;setListado(3);$('#head').text('Ventas');$('#hideable').css('visibility','hidden');$('.por').css('display','none');" class="btn btn-success" style="float:none" type="button">Ventas</a>
												</section>
											</footer>
											<header>Datos del precio</header>
											<fieldset>
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-prepend fa fa-cube"></i>
														<input type="text" placeholder="Precio del articulo" value="<?php echo $articulo[$_GET["ID"]]["DESCRIPCION"]; ?>">
														<i class="tooltip tooltip-top-left">Articulo seleccionado</i>
													</label>
												</section>
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-append fa fa-money"></i>
														<select onchange="objeto['MONEDA'] = $(this).val()" id="monedas" name="monedas" style="text-align-last: center;" class="input-sm col-12 nocaret">
															<option selected="" disabled="">Moneda</option>
															<?php
																foreach($moneda as $indice => $valor){
																	echo "<option value='".$valor["ID"]."'>".$valor["DESCRIPCION"]."</option>";
																}
															?>
														</select>
													</label>
												</section>
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-prepend fa fa-money"></i>
														<input onkeyup="objeto['PRECIO'] = parseFloat($(this).val())" name="precio" type="text" placeholder="Precio del articulo">
														<i class="tooltip tooltip-top-left">Precio del articulo</i>
													</label>
												</section>
												<section class="col col-6">
													<label class="input" id="hideable">
														<i class="icon icon-append fa fa-money"></i>
														<input onkeyup="objeto['PORCENTAJE'] = $(this).val()" name="porcentaje" class="right" type="text" value="0" placeholder="Porcentage" >
														<i class="tooltip tooltip-top-right">Porcentaje</i>
													</label>
												</section>
												
											</fieldset>
											<footer style="border-bottom: 1px solid rgba(0,0,0,.1) !important;">
												<section class="col col-12">
													<button class="btn btn-primary pull-right" type="submit">Agregar</button>
												</section>
												
											</footer>
											<header id="head" class="center">Contratos</header>
										</form>
										<section class="col col-12 no-padding">
											<table style="margin-top:0 !important;border-bottom: 1px solid rgba(0,0,0,.1) !important;" id="dt_basic2" class="table table-condensed table-striped table-bordered table-hover" width="100%">
												<thead>			                
													<tr>
														<th class="center">Moneda</th>
														<th class="center">Precio</th>
														<th class="center por">Porcentaje</th>
														<th class="center"><i class="fa fa-lg fa-trash-o"></i></th>
													</tr>
												</thead>
												<tbody id="tabla">
														
												</tbody>
											</table>
										</section>
										<form class="smart-form">
											<footer style="border-bottom: 1px solid rgba(0,0,0,.1) !important;">
												<section class="col col-12 no-margin">
													<button class="btn btn-success pull-right" data-dismiss="modal" type="button">Cerrar</button>
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
</div>


<script>
	var objeto = JSON.parse('<?php echo json_encode($objeto); ?>');
	var articulo = JSON.parse('<?php echo json_encode($articulo); ?>');
	var moneda = JSON.parse('<?php echo json_encode($moneda); ?>');
	
	var errorClass = 'invalid';
	var errorElement = 'em';
	
	pageSetUp();
	
	var pagefunction = function() {
		
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
				monedas : {
					required : true,
				},
				precio : {
					required : true,
					minlength : 1
				},
				porcentaje : {
					required : true,
					digits : true,
					minlength : 1
				}
			},
			messages : {
				monedas : {
					required : 'Este campo es obligatorio'
				},
				precio : {
					required : 'Este campo es obligatorio'
				},
				porcentaje : {
					required : 'Este campo es obligatorio'
				}
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			},
			 submitHandler: function(form) {
				 $(form).ajaxSubmit({data:{DATO:JSON.stringify(objeto)},success: function(resp){resp = JSON.parse(resp);buscar();alerta(resp["ESTADO"],resp["MENSAJE"]);setListado();}});
			}
		});
	
		setListado();
	};
	
	loadScript("js/plugin/jquery-form/jquery-form.min.js", pagefunction);
	
	function setArticulo(D){
		$("#item").empty();
		$("#item").append("<option value='0' selected='' disabled=''>Articulo</option>");
		
		$.each(articulo,function(indice,valor){
			console.log(D);
			if(valor["DEPOSITO"] == D){
				$("#item").append("<option value='"+valor["ID"]+"'>"+valor["DESCRIPCION"]+"</option>");
			}
		});
	}
	
	function setListado(B = "1"){
		$.ajax({
			url:"php/articulo/precio/listado.php",
			type : "POST",
			data: {"DATO":objeto["ARTICULO"],"USO":B},
			success: function(resp){
				resp = JSON.parse(resp);
				$("#tabla").empty();
				
				$.each(resp["MENSAJE"],function(indice,valor){
					var T = (B == 1)?"<td  class='center' style='vertical-align:middle'>"+valor["PORCENTAJE"]+"%</td>":"";
					
					
					$("#tabla").append("<tr><td class='center' style='vertical-align:middle'>"+moneda[valor["MONEDA"]]["DESCRIPCION"]+"</td><td  class='center' style='vertical-align:middle'>$ "+money(valor["PRECIO"])+"</td>"+T+"<td  class='center'><button onclick='elim("+valor["ID"]+")' class='btn btn-danger'><i class='fa fa-trash-o'></i></button></td></tr>");
				});
			}
		})
		
	}
	
	function elim(id){
		$.ajax({
			url: "php/articulo/precio/elim.php",
			type: "POST",
			data:{"DATO":id},
			success: function(resp){
				resp = JSON.parse(resp);
				alerta(resp["ESTADO"],resp["MENSAJE"]);
				setListado();
			}
		});
	}
	
</script>
