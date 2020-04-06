<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
	include "../../php/API/conexion.php";
	include "../../php/API/util.php";
	include "../../php/API/query.php";
	$query = new query();
	$util = new util();
	
	$temp = (array) $query->select(array("*"),"USUARIO","where ID = ".$_SESSION["SESION"][0]["ID"])[0];
	foreach($temp as $indice => $valor){

		$_SESSION["SESION"][0][$indice] = $valor;
	};
	
	//print_r($_SESSION["SESION"][0]);
?>
<div class="modal-body no-padding">  
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-12">
				<section id="widget-grid" class="">
					<div class="row">
						<article class="col-sm-12 col-md-12 col-lg-12" style="padding:0">
							<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" style="margin-bottom:0" data-widget-editbutton="false" data-widget-custombutton="false">
								<div class="content">
									<div class="widget-body no-padding">
										<div class="well well-light well-sm no-margin no-padding">
											<div class="row">
												<div class="col-sm-12">
													<div id="myCarousel" class="carousel fade profile-carousel">
														<div class="air air-bottom-right padding-10">
															<a type="button" onclick="$('#mifondofile').click();" rel="tooltip" data-original-title="Actualizar fondo" href="javascript:void(0);" class="btn txt-color-white bg-color-pinkDark btn-sm"><i class="fa fa-refresh"></i></a>
														</div>
														<div class="air air-top-left padding-10">
															<h4 class="txt-color-white font-md"><?php echo date("D")." ".date("d").", ".date("Y"); ?></h4>
														</div>
														<div class="carousel-inner">
															<div class="item active">
																<img id="mifondo" src="fondo/<?php echo $_SESSION["SESION"][0]["FONDO"] ?>" alt="">
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-12" style="margin-bottom:5%;">
													<div class="row">
														<div class="col-sm-3 profile-pic">
															<img id="miperfil" src="perfil/<?php echo $_SESSION["SESION"][0]["PERFIL"] ?>">
														</div>
														<div class="col-sm-6">
															<h1><?php echo $_SESSION["SESION"][0]["NOMBRE"] ?> <span class="semi-bold"><?php echo $_SESSION["SESION"][0]["APELLIDO"] ?></span>
															<br>
															</h1>
															<ul class="list-unstyled">
																<li>
																	<p  class="text-muted">
																		<i class="fa fa-asterisk"></i>&nbsp;&nbsp;<a href="form-x-editable.html#" id="ESTADO" data-type="select" data-pk="1" data-value="<?php echo $_SESSION["SESION"][0]["ESTADO"] ?>" data-original-title="ESTADO"></a>
																	</p>
																</li>
																<li>
																	<p  class="text-muted">
																		<i class="fa fa-envelope"></i>&nbsp;&nbsp;<a id="MIEMAIL" href="form-x-editable.html#" rel="tooltip" data-placement="right" data-original-title="Correo electronico" class="txt-color-darken"><?php echo $_SESSION["SESION"][0]["EMAIL"] ?></a>
																	</p>
																</li>
																<li>
																	<p  class="text-muted">
																		<i class="fa fa-flag"></i>&nbsp;&nbsp;<a href="form-x-editable.html#" id="MITEMA" data-type="select" data-pk="1" data-value="<?php echo $_SESSION["SESION"][0]["TEMA"] ?>" data-original-title="Estilo S.M.A.R.T"></a>
																	</p>
																</li>
																
															</ul>
															<br>
															<p class="font-md">
																<i>A cerca de mi</i>
															</p>	
															<p>	<a class="txt-color-darken" style="word-break:break-all;display:block" data-type="textarea" id="MIACERCA" href="form-x-editable.html#"><?php echo $_SESSION["SESION"][0]["ACERCA"] ?>
																</a>
															</p>
															<br>
															<input id="mifondofile" type="file" style="visibility:hidden" onchange="fondo($(this)[0].files[0]);">
															<input id="miavatarfile" type="file" style="visibility:hidden" onchange="avatar($(this)[0].files[0]);">
														</div>
														<div class="col-sm-3">
															<h1><small>Opciones</small></h1>
															<div class="col-md-12 no-padding">
																<button id="npass"  rel="popover" data-placement="right" data-original-title="Cambiar Contraseña" data-content="<form class='smart-form' style='min-width:170px'><fieldset class='no-padding'><section class='col col-12 no-padding'><label class='input'><input type='text' placeholder='Contraseña Actual' onkeyup='Pactual=$(this).val();'></label></section><section class='col col-12 no-padding'><label class='input'><input type='text' placeholder='Nueva contraseña' onkeyup='Pnueva=$(this).val();'></label></section><section class='col col-12 no-padding'><label class='input'><input type='text' placeholder='Repita contraseña' onkeyup='PRnueva=$(this).val();'></label></section></fieldset><footer class='no-padding'><button onclick='pass()' id='cpass' type='button' class='btn btn-primary btn-block'>Enviar</button></footer></form>" data-html="true"  class="btn btn-primary"><i class="fa fa-lock"></i></button>
																<button onclick="$('#miavatarfile').click();" rel="tooltip" data-original-title="Cambiar imagen de perfil" class="btn btn-primary"><i class="fa fa-user"></i></button>
															</div>
														</div>
													</div>		
												</div>
												<div class="col-md-12">
													<div class="col-md-12 well well-sm" style="border-top: 1px solid #ddd;">
														<button data-dismiss="modal" class="btn btn-primary center-block">Cerrar</button>
													</div>
												</div>
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
</div>

<script>
	$('[rel="tooltip"]').tooltip(); 
	var temaactual = "<?php echo $_SESSION['SESION'][0]['TEMA'] ?>";
	pageSetUp();
	
	var pagefunction = function() {
		
		var ESTADO = {
			1 : "offline",
			2 : "online",
			3 : "busy"
		}
		
		$('#MIEMAIL').editable({
			url: 'php/usuario/actualiza_perfil.php',
		    type: 'text',
		    pk:1,
		    name: 'EMAIL',
		    title: 'Correo Electronico',
		    success: function(resp) {
				resp = JSON.parse(resp);
				alerta(resp["ESTADO"],resp["MENSAJE"]);
			},
			validate: function(value) {
				if(!checkemail($.trim(value))) {
					return 'No parece ser un Email valido...';
				}
			}
		});
		
		$('#MIACERCA').editable({
			url: 'php/usuario/actualiza_perfil.php',
			name: 'ACERCA',
			pk:1,
			success: function(resp) {
				resp = JSON.parse(resp);
				alerta(resp["ESTADO"],resp["MENSAJE"]);
			}
		});
		$('#MITEMA').editable({
		        source: [{
		            value: "smart-style-0",
		            text: 'Original'
		        }, {
		            value: "smart-style-1",
		            text: 'Dark Elegance'
		        }, {
		            value: "smart-style-2",
		            text: 'Ultra Light'
		        }, {
		            value: "smart-style-3",
		            text: 'Google'
		        }, {
		            value: "smart-style-4",
		            text: 'Pixel Smash'
		        }, {
		            value: "smart-style-5",
		            text: 'Glass'
		        }],
		        url: 'php/usuario/actualiza_perfil.php',
				name: 'TEMA',
				pk:1,
				success: function(resp,newvalue) {
					resp = JSON.parse(resp);
					alerta(resp["ESTADO"],resp["MENSAJE"]);
					$("body").removeClass(temaactual);
					$("body").addClass(newvalue);
				}   
		    });
		    $('#ESTADO').editable({
		        source: [{
		            value: "2",
		            text: 'Conectado'
		        }, {
		            value: "3",
		            text: 'Ocupado'
		        }, {
		            value: "1",
		            text: 'Desconectado'
		        }],
		        url: 'php/usuario/actualiza_perfil.php',
				name: 'ESTADO',
				pk:1,
				success: function(resp,newvalue) {
					$("#miniperfil").attr("class",ESTADO[newvalue]);
					resp = JSON.parse(resp);
					alerta(resp["ESTADO"],resp["MENSAJE"]);
				
				}   
		    });
		
		
	}
	
	loadScript("js/plugin/x-editable/moment.min.js", function(){
		loadScript("js/plugin/x-editable/jquery.mockjax.min.js", function(){
			loadScript("js/plugin/x-editable/x-editable.min.js", function(){
				loadScript("js/plugin/typeahead/typeahead.min.js", pagefunction);
			});
		});
	});	
	
	var Pactual = "";
	var Pnueva = "";
	var PRnueva = "";
	
	function pass(){
		if(Pnueva != PRnueva){
			alerta("error","Las contraseñas no coinciden");
		}else if(Pnueva == "" || PRnueva == ""){
			alerta("error","Nuevos valores invalidos")
		}else{
			enviapass();
		}
	};
	
	function enviapass(){
		$.ajax({
			url  : "php/usuario/actualiza_pass.php",
			type : "POST",
			data:{"ACTUAL":Pactual,"NUEVA":Pnueva},
			beforeSend: function(){
				$("#cpass").attr("disabled","disabled");
			}
		}).done(function(resp){
			$("#cpass").removeAttr("disabled");
			resp = JSON.parse(resp);
			alerta(resp["ESTADO"],resp["MENSAJE"]);
			if(resp["ESTADO"] == "success"){
				$("#npass").click();
			}
		});
		
	}
	
	function fondo(file){
		var resultado = "";
		var datos = new FormData();
		datos.append("archivo",file);	
			
		$.ajax({
			url: 'php/usuario/fondo.php',  
			type: 'POST',
			async: true,
			success: function(resp){
				resp = JSON.parse(resp);
				if(resp["ESTADO"] == "success"){
					alerta("success","Imagen actualizada");
					$("#mifondo").attr("src","fondo/"+resp["MENSAJE"]);
				}
				if(resp.match(/error/g)){
					alert("error al cargar archivo intente de nuevo");
				}	
			},
			data: datos,
			processData: false, 
			contentType: false
		});
		return resultado;
	}
	
	function avatar(file){
		var resultado = "";
		var datos = new FormData();
		datos.append("archivo",file);	
			
		$.ajax({
			url: 'php/usuario/perfil.php',  
			type: 'POST',
			async: true,
			success: function(resp){
				resp = JSON.parse(resp);
				if(resp["ESTADO"] == "success"){
					alerta("success","Imagen actualizada");
					$("#miperfil").attr("src","perfil/"+resp["MENSAJE"]);
					$("#miniperfil").attr("src","perfil/"+resp["MENSAJE"]);
				}
				if(resp.match(/error/g)){
					alert("error al cargar archivo intente de nuevo");
				}	
			},
			data: datos,
			processData: false, 
			contentType: false
		});
		return resultado;
	}
</script>
