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
		"DESCRIPCION" => "",
		"HABILITADO" => 1 
	);
	
	if(isset($_GET["ID"])){
		$objeto = (array) $query->select(array("*"),"DEPOSITO","where ID = ".$_GET["ID"])[0];
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
									<h2>Planilla de deposito</h2>				
								</header>  
								<div class="content">
									<div class="widget-body no-padding">
										<form id="nuevo-form" onSubmit="event.preventDefault();" class="smart-form" action="php/articulo/deposito/deposito.php" method="post">
											<header>Datos del deposito</header>
											<fieldset>
												<section class="col col-12 no-padding no-margin">
													<section class="col col-6">
														<label class="input">
															<i class="icon icon-prepend fa fa-credit-card"></i>
															<input name="nombre" onkeyup="objeto['NOMBRE'] = $(this).val();" type="text" placeholder="Nombre" value="<?php echo $objeto["NOMBRE"]; ?>">
															<i class="tooltip tooltip-top-left">Define el nombre del deposito</i>
														</label>
													</section>
												</section>
												<section class="col col-12">
													<label class="textarea">
														<i class="icon icon-prepend fa fa-pencil"></i>
														<textarea name="descripcion" onkeyup="objeto['DESCRIPCION'] = $(this).val();" rows="5" placeholder="Descripcion" ><?php echo $objeto["DESCRIPCION"]; ?></textarea>
														<i class="tooltip tooltip-top-left">Descripcion del deposito</i>
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
			},
			messages : {
				nombre : {
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
