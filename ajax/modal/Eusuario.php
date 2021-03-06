<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
	include "../../php/API/conexion.php";
	include "../../php/API/util.php";
	include "../../php/API/query.php";
	$query = new query();
	$util = new util();
	
	$id = $_GET["ID"];
	
	$dato = $query->select(array("*"),"USUARIO","where ID = ".$id);
	$dato = $dato[0];
	$menu = $query->select(array("MENU"),"USUARIO_MENU","where USUARIO = ".$id);
	
	$acceso = array();
	foreach($menu as $indice => $valor){
		$acceso[] = $valor["MENU"];
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
									<h2>Editar Usuario</h2>				
								</header>  
								<div class="content">
									<div class="widget-body no-padding">
										<form id="FORM" class="smart-form">
											<header>Datos principales</header>
											<fieldset>
												<section class="col col-6">
													<h5 style="margin-bottom:1%">Nombre</h5>
													<label class="input">
														<i class="icon-prepend fa fa-user"></i>
														<input value="<?php echo $dato["NOMBRE"]; ?>" onkeyup="usuario['NOMBRE'] = $(this).val();" type="text">
													</label>
												</section>
												<section class="col col-6">
													<h5 style="margin-bottom:1%;text-align:right">Apellido</h5>
													<label class="input">
														<i class="icon-append fa fa-user"></i>
														<input value="<?php echo $dato["APELLIDO"]; ?>" onkeyup="usuario['APELLIDO'] = $(this).val()" type="text">
													</label>
												</section>
												<section class="col col-12" style="width:100%">
													<h5 style="margin-bottom:1%;">Correo electronico</h5>
													<label class="input">
														<i class="icon-prepend fa fa-envelope"></i>
														<input value="<?php echo $dato["EMAIL"]; ?>" onkeyup="usuario['EMAIL'] = $(this).val()" type="text">
													</label>
												</section>
												<section class="col col-6">
													<h5 style="margin-bottom:1%;">Contraseña</h5>
													<label class="input">
														<i class="icon-prepend fa fa-lock"></i>
														<input value="<?php echo $dato["PASS"]; ?>" onkeyup="usuario['PASS'] = $(this).val()" type="password">
													</label>
												</section>
												<section class="col col-6">
													<h5 style="margin-bottom:1%;">Repita Contraseña</h5>
													<label class="input">
														<i class="icon-append fa fa-lock"></i>
														<input value="<?php echo $dato["PASS"]; ?>" onkeyup="usuario['REPASS'] = $(this).val()" type="password">
													</label>
												</section>
											</fieldset>
											<header>Accesos</header>
											<fieldset>
												<?php
													$menus = array();
													$padre = (array) $query->select(array("ID","NOMBRE"),"MENU","where PADRE = 0");
													
													foreach($padre as $indice => $valor){
														
														
														echo "<header>".$valor["NOMBRE"]."</header>";
														$sub = $query->select(array("ID","NOMBRE"),"MENU","where PADRE = ".$valor["ID"]);
														echo "<div class='col-md-12' style='padding:4%'>";
														foreach($sub as $indice2 => $valor2){
															$temp = "";
															foreach($acceso as $indice3 => $valor3){
																if($valor2["ID"] == $valor3){
																	$temp = "CHECKED";
																}
															}
															echo "
																<section class='col col-4'>
																	<label class='checkbox-inline'>
																		<input onchange='modulo()' data-id='".$valor2["ID"]."' type='checkbox' class='checkbox style-0 modulo12' ".$temp.">
																		<span>".$valor2["NOMBRE"]."</span>
																	</label>
																</section>
															";
														}
														echo "</div>";
													}
												?>
											</fieldset>
										<footer>
											<div class="col-md-12">
												<button data-dismiss="modal" type="button" class="btn btn-danger">Cerrar</button>
												<button id="envia" onclick="valida();" type="button" class="btn btn-success">Actualizar</button>
											</div>
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
	
$(document).ready(function(){
	modulo();
});
	
var usuario = {
	"ID" : "<?php echo $id; ?>",
	"NOMBRE" : "<?php echo $dato['NOMBRE']; ?>",
	"APELLIDO" : "<?php echo $dato['APELLIDO']; ?>",
	"EMAIL" :"<?php echo $dato['EMAIL']; ?>",
	"PASS" : "<?php echo $dato['PASS']; ?>",
	"REPASS" :"<?php echo $dato['PASS']; ?>",
	"ACCESO" : []
	
};

function valida(){
	
	if(usuario["PASS"] != usuario["REPASS"]){
		alerta("error","Las contraseñal no coinciden");
	}else if(usuario["NOMBRE"] == ""){
		alerta("error","El campo 'NOMBRE' no puede estar vacio");
	}else{
		enviar();
	}
}

function modulo(){
	var temp = [];
	usuario["ACCESO"] = [];
	$(".modulo12").each(function(){
		if($(this).is(":checked")){
			console.log($(this).attr("data-id"));
			temp.push($(this).attr("data-id"));
		}
	});
	usuario["ACCESO"] = temp;
}

function enviar(){
	$.ajax({
		url: "php/usuario/editar_usuario.php",
		type: "POST",
		data:{"DATO":JSON.stringify(usuario)},
		beforeSend:function(){
			$("#envia").attr("disabled","disabled");
			alerta("envio","Editando usuario...");
		}
	}).done(function(resp){
		$("#envia").removeAttr("disabled");
		resp = JSON.parse(resp);
		alerta(resp["ESTADO"],resp["MENSAJE"]);
		user();
	});	
}

</script>
