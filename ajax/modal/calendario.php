<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include "../../php/API/util.php";
	include "../../php/API/query.php";
	
	$query = new query();
	$util = new util();
	
	$temp = (array) $query->select(array("*"),"COLOR");
	foreach($temp as $indice => $valor){
		$color[$valor["ID"]] = array("FONDO"=>$valor["FONDO"],"TEXTO"=>$valor["TEXTO"],"ID"=>$valor["ID"]);
	}
	$temp = (array) $query->select(array("*"),"ICONO");
	foreach($temp as $indice => $valor){
		$icono[$valor["ID"]] = array("ICONO"=>$valor["ICONO"],"ID"=>$valor["ID"]);
	}
	
	$objeto = array(
		"ID" => "",
		"TITULO" => "Sin Descripcion",
		"CUERPO" => "Sin Descripcion",
		"ICONO" => "1",
		"COLOR" => "1",
		"DESDE"=> date("Y-m-d"),
		"HASTA"=> date("Y-m-d"),
		"ORIGEN" => "",
		"USUARIOS" => []
	);
	if(isset($_GET["ID"])){
		$s = "N";
	}else{
		$s = "S";
	}
	
	if(isset($_GET["ID"])){
		if($query->if_exist(array("ID"=>$_GET["ID"],"ORIGEN"=>$_SESSION["SESION"][0]["ID"]),"EVENTO")){
			$s = "S";
		}
		$objeto = (array) $query->select(array("*"),"EVENTO","where ID = ".$_GET["ID"])[0];
		$temp = (array) $query->select(array("USUARIO"),"USUARIO_CALENDARIO","where EVENTO = ".$_GET["ID"]);
		
		foreach($temp as $indice => $valor){
			if($valor["USUARIO"] != $_SESSION["SESION"][0]["ID"]){
				$objeto["USUARIOS"][] = $valor["USUARIO"];
			}
		}
		
		
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
									<h2>Tarjeta de detalle</h2>				
								</header>  
								<div class="content">
									<div class="widget-body no-padding">
										<form class="smart-form">
											<header>Detalles del evento</header>
											<fieldset>
												<section class="col col-12">
													<label class="input">
														<i class="icon-prepend fa fa-header"></i>
														<input onkeyup="$('#tex').text($(this).val());evento['TITULO'] = $(this).val();" placeholder="El titulo del Evento" type="text" value="<?php echo $objeto["TITULO"]; ?>">
													</label>
												</section>
												<section class="col col-12">
													<label class="textarea">
														<i class="icon-prepend fa fa-header"></i>
														<textarea onkeyup="$('#preview').attr('data-description',$(this).val());evento['CUERPO'] = $(this).val();" placeholder="Detalle del evento" rows="5" type="text"><?php echo $objeto["CUERPO"]; ?></textarea>
													</label>
												</section>
												<section class="col col-6">
													<label class="input">
														<i class="icon-prepend fa fa-calendar"></i>
														<input class="datepicke" onchange="evento['DESDE']= $(this).val();" type="text" value="<?php echo $util->tonormaldate($objeto["DESDE"]); ?>">
													</label>
												</section>
												<section class="col col-6">
													<label class="input">
														<i class="icon-append fa fa-calendar"></i>
														<input class="right datepicke" onchange="evento['HASTA']= $(this).val();" type="text" value="<?php echo $util->tonormaldate($objeto["HASTA"]); ?>">
													</label>
												</section>
											</fieldset>
											<?php if($s == "N"){ echo "<!--";}; ?>
											<footer style="border-bottom:1px solid rgba(0,0,0,.1)">
												
												<section class="col col-6 no-margin">
													<div class="btn-group btn-group-justified " data-toggle="buttons">
														<?php 
															foreach($icono as $indice => $valor){
																echo "
																	<a onclick='$(\"#icon\").attr(\"class\",\"fa ".$valor["ICONO"]."\");evento[\"ICONO\"] = ".$valor["ID"]."' type='button' style='float:none;padding:0' class=' btn btn-default' ><i class='fa ".$valor["ICONO"]."'></i></a>
																";			
															}
														?>
													</div>
												</section>
												<section class="col col-6 no-margin">
													<div class="btn-group btn-group-justified " data-toggle="buttons">
														<?php 
															foreach($color as $indice => $valor){
																echo "
																	<a onclick='$(\"#preview\").attr(\"class\",\"  ".$valor["FONDO"]." ".$valor["TEXTO"]."\");evento[\"COLOR\"] = ".$valor["ID"]."' type='button' style='float:none;padding:0' class=' btn btn-default ".$valor["FONDO"]." ".$valor["TEXTO"]."' ><i class='fa fa-check'></i></a>
																";			
															}
														?>
													</div>
												</section>
											</footer>  
											<?php if($s == "N"){ echo "-->";}; ?>
											<?php if($s == "N"){ echo "<!--";}; ?>
											<header>Vista previa</header>
											<fieldset>
												<section class="col col-12">
													<ul id='external-events' class="list-unstyled">
														<li style="width:100%">
															<span style="position:inherit" id="preview" class="<?php echo $color[$objeto["COLOR"]]["FONDO"] ?> <?php echo $color[$objeto["COLOR"]]["TEXTO"] ?>" data-description="<?php echo $objeto["CUERPO"]; ?>" data-icon="fa-plus"><span id="tex"><?php echo $objeto["TITULO"]; ?> </span><i id="icon" style="top: 10px;right: 20px;float:right;" class=" air air-top-right fa <?php echo $icono[$objeto["ICONO"]]["ICONO"] ?> "></i></span>
														</li>
													</ul>
												</section>
											</fieldset>
											<?php if($s == "N"){ echo "-->";}; ?>
											
											<?php if($s == "N"){ echo "<!--";}; ?>
											<header style="border:0">¿Quien Puede verme?</header>
											<footer style="border-bottom:1px solid rgba(0,0,0,.1)">
												<section class="col col-12 no-margin">
													<button onclick="todos();" type="button" class="btn btn-primary">Todos</button>
													<button onclick="soloyo();" type="button" class="btn btn-primary">Solo yo<button>
												</section>
											</footer>
											<fieldset>
												<?php
													$sub = $query->select(array("ID","NOMBRE","APELLIDO"),"USUARIO","where ID != ".$_SESSION["SESION"][0]["ID"]);
													echo "<div class='col-md-12' style='padding:4%'>";
													foreach($sub as $indice2 => $valor2){
														echo "
															<section class='col col-4'>
																<label class='checkbox-inline'>
																	<input onchange='user()' data-id='".$valor2["ID"]."' type='checkbox' class='checkbox user".$valor2["ID"]." style-0 user'>
																	<span>".$valor2["NOMBRE"]." ".$valor2["APELLIDO"]."</span>
																</label>
															</section>
														";
													}		
												?>
											</fieldset>
											<?php if($s == "N"){ echo "-->";}; ?>
											<footer>
											<?php if($s == "N"){ echo "<!--";}; ?>
											<button id="enviar();" class="btn btn-danger pull-right" type="button" onclick="elimevento(<?php echo $_GET["ID"]; ?>)"><i class="fa fa-trash-o"></i></button>
											<button id="enviar();" class="btn btn-success pull-right" type="button" onclick="guardar()">Guardar Evento</button>
											<?php if($s == "N"){ echo "-->";}; ?>
											<button  class="btn btn-danger pull-left cerrar" type="button" data-dismiss="modal">Cerrar</button>
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
	
	var evento = JSON.parse('<?php echo json_encode($objeto); ?>');
	
	pageSetUp();
	
	var pagefunction = function() {
		$(".datepicke").datepicker({ dateFormat: 'dd/mm/yy' });
		check();
	};
	
	pagefunction();
	
	function soloyo(){
		$(".user").each(function(indice,valor){
			$(this).attr("checked",false);
		});
		
		user();
	};
	
	function todos(){
		$(".user").each(function(indice,valor){
			$(this).attr("checked",true);
		});
		
		user();
	}
	
	function check(){
		$.each(evento["USUARIOS"],function(indice,valor){
			$(".user"+valor).attr("checked",true);
		});
		
	}
	
	function user(){
		var array = [];
		
		$(".user").each(function(indice,valor){
			if($(this).is(":CHECKED")){
				array.push($(this).attr("data-id"));
			}
		});
		
		evento["USUARIOS"] = array;
	}
	
	function guardar(){
		$.ajax({
			url: "php/evento/evento.php",
			type:"POST",
			data: {"DATO": JSON.stringify(evento)},
			beforeSend: function(){
				$("#enviar").attr("disabled","disabled");
			}
		}).done(function(resp){
			$("#enviar").removeAttr("disabled");
			resp = JSON.parse(resp);
			alerta(resp["ESTADO"],resp["MENSAJE"]);
			notas();
		});
	}
	
	
	
	
	
	
</script>
