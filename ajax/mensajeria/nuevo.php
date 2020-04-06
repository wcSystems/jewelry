<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../../php/API/util.php";
include "../../php/API/query.php";
	
$query = new query();
$util = new util();

$destinos = $query->select(array("ID","NOMBRE","APELLIDO"),"USUARIO","where ID != ".$_SESSION["SESION"][0]["ID"]);

?>

<h2 class="email-open-header">
	Redactar un nuevo Correo
	<a href="javascript:void(0);" rel="tooltip" data-placement="left" data-original-title="Imprimir" class="txt-color-darken pull-right"><i class="fa fa-print"></i></a>	
</h2>

<form enctype="multipart/form-data" action="dummy.php" method="POST" class="form-horizontal" id="email-compose-form">

	<div class="inbox-info-bar no-padding">
		<div class="row">
			<div class="form-group">
				<label class="control-label col-md-1"><strong>Para</strong></label>
				<div class="col-md-11">
					<select id="destino" multiple style="width:100%" class="select2" data-select-search="true">
						<?php 
							foreach($destinos as $indice => $valor){
								echo "<option value='".$valor["ID"]."'>".$valor["NOMBRE"]." ".$valor["APELLIDO"]."</option>";
								
							}
						?>
					</select>
					<!--<em><a href="javascript:void(0);" class="show-next" rel="tooltip" data-placement="bottom" data-original-title="Carbon Copy">CC</a></em>-->
				</div>
			</div>
		</div>	
	</div>
	
	<div class="inbox-info-bar no-padding hidden">
		<div class="row">
			<div class="form-group">
				<label class="control-label col-md-1"><strong>CC</strong></label>
				<div class="col-md-11">
					<select multiple style="width:100%" class="select2" data-select-search="true">
						<?php 
							foreach($destinos as $indice => $valor){
								echo "<option value='".$valor["ID"]."'>".$valor["NOMBRE"]." ".$valor["APELLIDO"]."</option>";
								
							}
						?>
					</select>
					<em><a href="javascript:void(0);" class="show-next" rel="tooltip" data-placement="bottom" data-original-title="Blind Carbon Copy">BCC</a></em>
				</div>
			</div>
		</div>	
	</div>

	<div class="inbox-info-bar no-padding hidden">
		<div class="row">
			<div class="form-group">
				<label class="control-label col-md-1"><strong>BCC</strong></label>
				<div class="col-md-11">
					<select multiple style="width:100%" class="select2" data-select-search="true">
						<?php 
							foreach($destinos as $indice => $valor){
								echo "<option value='".$valor["ID"]."'>".$valor["NOMBRE"]." ".$valor["APELLIDO"]."</option>";
								
							}
						?>
					</select>
				</div>
			</div>
		</div>	
	</div>
	
	<div class="inbox-info-bar no-padding">
		<div class="row">
			<div class="form-group">
				<label class="control-label col-md-1"><strong>Asunto</strong></label>
				<div class="col-md-11">
					<input id="asunto" class="form-control" placeholder="Describa el asunto" type="text">
					<em><a href="javascript:void(0);" class="show-next" rel="tooltip" data-placement="bottom" data-original-title="Adjuntar archivos"><i class="fa fa-paperclip fa-lg"></i></a></em>
				</div>
			</div>
		</div>	
	</div>

	<div class="inbox-info-bar no-padding hidden">
		<div class="row">
			<div class="form-group">
				<label class="control-label col-md-1"><strong>Adjuntos</strong></label>
				<div class="col-md-11">
					<input id="files" class="form-control fileinput" type="file" multiple="multiple">
				</div>
			</div>
		</div>	
	</div>
	
	<div class="inbox-message no-padding">
	
		<div id="emailbody">
			
		</div>	
	</div>
	
	<div class="inbox-compose-footer">

	<button onclick="loadInbox();" class="btn btn-danger" type="button">
		Cancelar
	</button>
		
	

	<button data-loading-text="&lt;i class='fa fa-refresh fa-spin'&gt;&lt;/i&gt; &nbsp; Sending..." class="btn btn-primary pull-right" type="button" id="send">
		Enviar <i class="fa fa-arrow-circle-right fa-lg"></i>
	</button>


	</div>

</form>

<script>
	
	var EMAIL = {
		"DESTINO" : "",
		"ASUNTO" : "",
		"CUERPO" : "",
		"ADJUNTO" : []
	};
	
	runAllForms();

	$(".table-wrap [rel=tooltip]").tooltip();

	loadScript("js/plugin/summernote/summernote.min.js", iniEmailBody);

	function iniEmailBody() {
	    $('#emailbody').summernote({
	        height: '500px',
	        focus: false,
	        tabsize: 2
	    });
	}

	$(".show-next").click(function () {
	    $this = $(this);
	    $this.hide();
	    $this.parent().parent().parent().parent().parent().next().removeClass("hidden");
	})

	 $("#send").click(function () {
		 
		 EMAIL["DESTINO"] = $("#destino").val();
		 EMAIL["ASUNTO"] = $("#asunto").val();
		 EMAIL["CUERPO"] = $("#emailbody").summernote("code");
		
		var $btn = $(this);
		$btn.button('loading');

	    // wait for animation to finish and execute send script
	    setTimeout(function () {
	       valida();
	    }, 1000); // how long do you want the delay to be? 
	});
	
	function valida(){
		if(EMAIL["DESTINO"].length == 0){
			alerta("error","No ha seleccionado ningun destinatario");
		}else if(EMAIL["CUERPO"].trim() == ""){
			alerta("error","El cuerpo del mensaje esta vacio");
		}else{
			archivo();
			enviar();
		}
	}
	
	function enviar(){
		$.ajax({
			url:"php/mensajeria/send.php",
			type:"POST",
			data:{"DATO":JSON.stringify(EMAIL)}
		}).done(function(resp){
			resp = JSON.parse(resp);
			alerta(resp["ESTADO"],resp["MENSAJE"]);
			if(resp["ESTADO"] == "success"){
				loadInbox();
			}
		})
	};
	
	function archivo(){
	var cont = 0;
		for (var i = 0; i < $("#files")[0].files.length; ++i) {
			var datos = new FormData();
			datos.append("archivo",$("#files")[0].files[i]);
			$.ajax({
			url: "php/mensajeria/adjunto.php",  
			type: 'POST',
			async: false,
			xhr: function() {
				var xhr = new window.XMLHttpRequest();
			
				return xhr;
			},
			data: datos,
			processData: false, 
			contentType: false
			}).done(function(resp){
				EMAIL["ADJUNTO"].push(resp);
			});
		}

	}
	
	
	
	
</script>
