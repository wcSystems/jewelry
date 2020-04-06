<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include "../../php/API/util.php";
	include "../../php/API/query.php";
	
	$query = new query();
	$util = new util();
	
	$objeto = array(
		"ID" => "",
		"TITULO" => "",
		"CUERPO" => "",
		"FOTO" => "NA",
		"USUARIOS" => array()
	);
	
	if(isset($_GET["ID"])){
		
		$objeto = (array) $query->select(array("ID","TITULO","CUERPO","TODO","PERSONAL","FOTO"),"ANOTADOR","where ID = ".$_GET["ID"])[0];
		$temp = (array) $query->select(array("USUARIO"),"USUARIO_ANOTADOR","where ANOTADOR = ".$_GET["ID"]);
		
		foreach($temp as $indice => $valor){
			$objeto["USUARIOS"][] = $valor["USUARIO"];
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
									<h2>Datos del Sticky</h2>				
								</header>  
								<div class="content">
									<div class="widget-body no-padding">
										<form class="smart-form">
											<header>Datos del Sticky</header>
											<fieldset>
												<section class="col col-12">
													<label class="input">
														<i class="icon-prepend fa fa-header"></i>
														<input placeholder="El titulo del Sticky" type="text" onkeyup="sticky['TITULO'] = $(this).val();" value="<?php echo $objeto["TITULO"]; ?>">
													</label>
												</section>
												<section class="col col-12">
													<label class="textarea">
														<i class="icon-prepend fa fa-header"></i>
														<textarea placeholder="El cuerpo del Sticky" rows="5" type="text" onkeyup="sticky['CUERPO'] = $(this).val();"><?php echo $objeto["CUERPO"]; ?></textarea>
													</label>
												</section>
												<section class="col col-12">
													<img id="stickyimage" style="width:100%">
													<?php if($_GET["P"] == "N"){ echo "<!--";}; ?>
													<label for="file" class="input input-file">
														<div class="button"><input type="file" name="file" onchange="stickyimagea($(this)[0].files[0],'sticky','STICKY');">Buscar</div><input value="<?php echo $objeto["FOTO"]; ?>" class="sticky-progress-file" type="text" placeholder="C://..." readonly="">
													</label>
													<div class="progress progress-sm progress-striped active" style="margin-bottom:0">
														<div class="sticky-progress progress-bar bg-color-darken"  role="progressbar" style="width: 0%"></div>
													</div>
													<?php if($_GET["P"] == "N"){ echo "-->";}; ?>
												</section>
											</fieldset>
											<?php if($_GET["P"] == "N"){ echo "<!--";}; ?>
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
											<?php if($_GET["P"] == "N"){ echo "-->";}; ?>
											<footer>
											<?php if($_GET["P"] == "N"){ echo "<!--";}; ?>
											<button id="enviar();" class="btn btn-success pull-right" type="button" onclick="guardar()">Guardar Sticky</button>
											<?php if($_GET["P"] == "N"){ echo "-->";}; ?>
											<button class="btn btn-danger pull-left" type="button" data-dismiss="modal">Cerrar</button>
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
	
	var sticky = JSON.parse('<?php echo json_encode($objeto); ?>');
	
	pageSetUp();
	
	var pagefunction = function() {
		
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
		$.each(sticky["USUARIOS"],function(indice,valor){
			$(".user"+valor).attr("checked",true);
		});
		if(sticky["FOTO"] != "NA"){
			$("#stickyimage").attr("src","img/sticky/"+sticky["FOTO"]);
		}
	}
	
	function user(){
		var array = [];
		
		$(".user").each(function(indice,valor){
			if($(this).is(":CHECKED")){
				array.push($(this).attr("data-id"));
			}
		});
		
		sticky["USUARIOS"] = array;
	}
	
	function guardar(){
		$.ajax({
			url: "php/sticky/sticky.php",
			type:"POST",
			data: {"DATO": JSON.stringify(sticky)},
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
	
	function enviar(){
		nota["SECCION"] = $("#SECCION").val();
		nota["FIRMANTE"] = $("#firmante").val();
		
		
		$.ajax({
			url:"php/sticky/nota.php",
			type:"POST",
			data:{"DATO":JSON.stringify(nota)},
			beforeSend: function(){
				$("#enviar").attr("disabled","disabled");
				alerta("envio","Guardando Nota por favor espere...");
			}
		}).done(function(resp){
			resp = JSON.parse(resp);
			alerta(resp["ESTADO"],resp["MENSAJE"]);
		});
	};
	
	//---------------- abajo es solo la funcion que sube los archivos ------------------//
	
	function stickyimagea(file,id,tipo){
	var resultado = "";
	var datos = new FormData();
	datos.append("archivo",file);	
	datos.append("tipo",tipo);	
	$.ajax({
        url: 'php/sticky/archivo_nota.php',  
        type: 'POST',
        async: true,
        xhr: function() {
			var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = evt.loaded / evt.total;
                    var percentComplete = Math.round(percentComplete * 100);
                    if(percentComplete == 0){
						$('.'+id+'-progress').removeClass("bg-color-green").addClass("bg-color-darken");
					}
                    $('.'+id+'-progress').css("width",percentComplete+"%");
                    if(percentComplete == 100){
						$('.'+id+'-progress').removeClass("bg-color-darken").addClass("bg-color-green");
					}
                }
            }, false);
            return xhr;
        },
        data: datos,
        processData: false, 
        contentType: false
    }).done(function(resp){
		resp = resp.trim();
			if(resp.match(/error/g)){
				alert("error al cargar archivo intente de nuevo");
			}
			
			resultado = resp;
			sticky["FOTO"] = resp;
			$("#stickyimage").attr("src","img/sticky/"+resp);
			
	});
	
	$("."+id+"-progress-file").val(resultado);
}
	
	
	
</script>
