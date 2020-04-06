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
		"DESCRIPCION" => "",
		"DEPOSITO" => 1,
		"MEDIDA" => 1 
	);
	
	if(isset($_GET["ID"])){
		$objeto = (array) $query->select(array("*"),"ARTICULO","where ID = ".$_GET["ID"])[0];
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
									<h2>Planilla de articulo</h2>				
								</header>  
								<div class="content">
									<div class="widget-body no-padding">
										<form id="nuevo-form" onSubmit="event.preventDefault();" class="smart-form" action="php/articulo/articulo/articulo.php" method="post">
											<header>Datos del deposito</header>
											<fieldset>
												<section class="col col-12">
													<label class="input">
														<i class="icon icon-prepend fa fa-cube"></i>
														<input name="nombre" onkeyup="objeto['DESCRIPCION'] = $(this).val()" type="text" placeholder="Articulo" value="<?php echo $objeto["DESCRIPCION"]; ?>">
														<i class="tooltip tooltip-top-left">Descripcion del articulo</i>
													</label>
												</section>
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-prepend fa fa-cubes"></i>
														<select id="deposito" name="deposito" onchange="objeto['DEPOSITO'] = $(this).val()" style="text-align-last: center;" class="input-sm col-12 nocaret">
															<option  value="0" selected="" disabled="">Desposito</option>
															<?php
																foreach($deposito as $indice => $valor){
																	echo "<option value='".$valor["ID"]."'>".$valor["NOMBRE"]."</option>";
																}
															?>
														</select>
													</label>
												</section>
												<section class="col col-6">
													<label class="input">
														<i class="icon icon-append fa fa-cube"></i>
														<select id="medida" name="medida" onchange="objeto['MEDIDA'] = $(this).val()" style="text-align-last: center;" class="input-sm col-12 nocaret">
															<option value="0" selected="" disabled="">Unidad de medida</option>
															<?php
																foreach($medida as $indice => $valor){
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
													<button style="margin-left:0" class="btn btn-danger pull-left" type="button" data-dismiss="modal">Cerrar</button>
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
			$("#medida").val(objeto["MEDIDA"]);
			$("#deposito").val(objeto["DEPOSITO"]);
		}
	};
	
	pagefunction();
	
	runAllForms();
	
	
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
				nombre : {
					required : true,
				},
				deposito : {
					required : true,
				},
				medida : {
					required : true,
				}
			},
			messages : {
				nombre : {
					required : 'Este campo es obligatorio'
				},
				deposito : {
					required : 'Este campo es obligatorio'
				},
				medida : {
					required : 'Este campo es obligatorio'
				}
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			},
			 submitHandler: function(form) {
				 $(form).ajaxSubmit({data:{DATO:JSON.stringify(objeto)},success: function(resp){resp = JSON.parse(resp);buscar();alerta(resp["ESTADO"],resp["MENSAJE"])}});
			}
		});
	});
	

</script>
