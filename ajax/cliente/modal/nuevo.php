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
		"ID" => "",
		"NOMBRE" => "",
		"APELLIDO" => "",
		"DOCUMENTO" => "",
		"DIRECCION" => "Sin Definir",
		"EMAIL" => "Sin definir",
		"TELEFONO" => "0",
		"NACIONALIDAD" => 0,
		"CIVIL" => 0,
		"PROFESION" => 0
	
	);
	
	if(isset($_GET["ID"])){
		$objeto = (array) $query->select(array("*"),"CLIENTE","where ID = ".$_GET["ID"])[0];
	}
	
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
									<h2>Planilla de cliente</h2>				
								</header>  
								<div class="content">
									<div class="widget-body no-padding">
										<form id="nuevo-form-2" onSubmit="event.preventDefault();" class="smart-form" action="php/cliente/cliente.php" method="post">
											<header>Datos del Cliente</header>
											<fieldset>
												<section class="col col-12 no-padding no-margin">
													<section class="col col-6">
														<label class="input">
															<i class="icon icon-prepend fa fa-credit-card"></i>
															<input name="documento" onkeyup="objeto['DOCUMENTO'] = $(this).val()" type="text" placeholder="Documento" value="<?php echo $objeto["DOCUMENTO"]; ?>">
															<i class="tooltip tooltip-top-left">Documento del Cliente</i>
														</label>
													</section>
												</section>
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-prepend fa fa-user"></i>
														<input name="nombre" onkeyup="objeto['NOMBRE'] = $(this).val()" type="text" placeholder="Nombre" value="<?php echo $objeto["NOMBRE"]; ?>">
														<i class="tooltip tooltip-top-left">Nombre del Cliente</i>
													</label>
												</section>
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-prepend fa fa-user"></i>
														<input name="apellido" onkeyup="objeto['APELLIDO'] = $(this).val()" type="text" placeholder="Apellido" value="<?php echo $objeto["APELLIDO"]; ?>">
														<i class="tooltip tooltip-top-left">Apellido del Cliente</i>
													</label>
												</section>
												<section class="col col-12">
													<label class="input">
														<i class="icon icon-prepend fa fa-user"></i>
														<input name="direccion" onkeyup="objeto['DIRECCION'] = $(this).val()" type="text" placeholder="Direccion" value="<?php echo $objeto["DIRECCION"]; ?>">
														<i class="tooltip tooltip-top-left">Direccion</i>
													</label>
												</section>
											</fieldset>
											<header>Datos de contacto</header>
											<fieldset>
												<section class="col col-12">
													<label class="input">
														<i class="icon icon-prepend fa fa-envelope"></i>
														<input name="email" onkeyup="objeto['EMAIL'] = $(this).val()" type="text" placeholder="Correo electronico" value="<?php echo $objeto["EMAIL"]; ?>">
														<i class="tooltip tooltip-top-left">Correo electronico</i>
													</label>
												</section>
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-prepend fa fa-envelope"></i>
														<input name="telefono" onkeyup="objeto['TELEFONO'] = $(this).val()" type="text" placeholder="Telefono" value="<?php echo $objeto["TELEFONO"]; ?>">
														<i class="tooltip tooltip-top-left">Telefono</i>
													</label>
												</section>
											</fieldset>
											<header>Datos adicionales</header>
											<fieldset>
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-prepend fa fa-credit-card"></i>
														<select id="nacionalidad" name="nacionalidad" onchange="objeto['NACIONALIDAD'] = $(this).val()" style="text-align-last: center;" class="input-sm col-12 nocaret">
															<option value="0" selected="" disabled="">Nacionalidad</option>
															<?php
																foreach($nacionalidad as $indice => $valor){
																	echo "<option value='".$valor["ID"]."'>".$valor["DESCRIPCION"]."</option>";
																}
															?>
														</select>
													</label>
												</section>
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-append fa fa-credit-card"></i>
														<select id="civil" name="civil" onchange="objeto['CIVIL'] = $(this).val()" style="text-align-last: center;" class="input-sm col-12 nocaret">
															<option value="0" selected="" disabled="">Estado Civil</option>
															<?php
																foreach($civil as $indice => $valor){
																	echo "<option value='".$valor["ID"]."'>".$valor["DESCRIPCION"]."</option>";
																}
															?>
														</select>
													</label>
												</section>
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-prepend fa fa-file"></i>
														<select id="profesion" name="profesion" onchange="objeto['PROFESION'] = $(this).val()" style="text-align-last: center;" class="input-sm col-12 nocaret">
															<option value="0" selected="" disabled="">Profesion</option>
															<?php
																foreach($profesion as $indice => $valor){
																	echo "<option value='".$valor["ID"]."'>".$valor["DESCRIPCION"]."</option>";
																}
															?>
														</select>
													</label>
												</section>
											</fieldset>
											<footer>
												<section class="col col-12 no-margin">
													<button class="btn btn-success pull-right" type="submit">Guardar</button>
													<button style="margin-left:0" class="btn btn-danger pull-left" type="button" id="cerrajero" data-dismiss="modal">Cerrar</button>
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
	var errorClass = 'invalid';
	var errorElement = 'em';
	
	pageSetUp();
	
	var pagefunction = function() {
		if(objeto["ID"] != ""){
			$("#nacionalidad").val(objeto["NACIONALIDAD"]);
			$("#civil").val(objeto["CIVIL"]);
			$("#profesion").val(objeto["PROFESION"]);
		}
	};
	
	pagefunction();
	
	runAllForms();
	
	
	$(function() {
		$("#nuevo-form-2").validate({
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
				documento : {
					required : true,
					minlength : 1,
					digits:true
				},
				nombre : {
					required : true,
					minlength : 1
				},
				apellido : {
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
				telefono : {
					required : false,
					minlength : 1,
					digits:true
				},
				profesion : {
					required : true
				},
				civil : {
					required : true
				},
				nacionalidad : {
					required : true
				},
			},
			messages : {
				nombre : {
					required : 'Este campo es obligatorio'
				},
				apellido : {
					required : 'Este campo es obligatorio'
				},
				documento : {
					required : 'Este campo es obligatorio'
				}
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			},
			 submitHandler: function(form) {
				 $(form).ajaxSubmit({data:{DATO:JSON.stringify(objeto)},success: function(resp){resp = JSON.parse(resp);alerta(resp["ESTADO"],resp["MENSAJE"]["MENSAJE"]);creado(resp["MENSAJE"]["CLIENTE"]);$("#cerrajero").click();}});
			}
		});
	});

</script>
