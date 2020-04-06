<div class="modal-body no-padding">  
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-12">
				<section id="widget-grid" class="">
					<div class="row">
						<article class="col-sm-12 col-md-12 col-lg-12" style="padding:0">
							<div class="jarviswidget" id="wid-id-1" style="margin-bottom:0" data-widget-editbutton="false" data-widget-custombutton="false">
								<header>
									<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
									<h2>Detalle del Contrato</h2>				
								</header>  
								<div class="content">
									<div class="jarviswidget-editbox">	
									</div>
									<div class="widget-body no-padding">
										<form class="smart-form">
											<header>Realizar Split de Monto</header>
											<fieldset>
												<section class="col col-12 no-padding no-margin">
													<section class="col col-6">
														<label class="input">
															<i class="icon-prepend fa fa-money"></i>
															<input type="text" name="Ntotal" readonly>
															<i class="tooltip tooltip-top-left">Monto Original a cancelar (en dolares)</i>
														</label>
													</section>
												</section>
												<section class="col col-6">
														<label class="input">
															<i class="icon-prepend fa fa-dollar"></i>
															<input type="text" name="cancelar" value="0.00" onkeyup="acancelar()">
															<i class="tooltip tooltip-top-left">Monto a cancelar (En dolares)</i>
														</label>
													</section>
													<section class="col col-6">
														<label class="input">
															<i class="icon-append fa fa-dollar"></i>
															<input type="text" name="diferencia" value="0.00" readonly>
															<i class="tooltip tooltip-top-right">Diferencia por cancelar</i>
														</label>
													</section>
													<section class="col col-12 no-margin no-padding">
														<section class="col col-6">
															<label class="input">
																<i class="icon-prepend fa fa-dollar"></i>
																<input type="text" name="tasa" value="0.00" onkeyup="acancelar()">
																<i class="tooltip tooltip-top-left">Tasa de cambio</i>
															</label>
														</section>
													</section>
													<section class="col col-6">
														<label class="input">
															<i class="icon-prepend fa fa-dollar"></i>
															<input type="text" name="restante" value="0.00" readonly>
															<i class="tooltip tooltip-top-left">Restante a cancelar (en bolivares)</i>
														</label>
													</section>
											</fieldset>
			
											<footer>
												<section class="col col-12 no-margin">
													<button class="btn btn-success right" type="button"onclick="valida();">Ejecutar compra</button>
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
	
	pageSetUp();
	
	var pagefunction2 = function() {
		$("[name='Ntotal']").val(money(compra["PRECIO"]*compra["PESO"]));
		

	};

	pagefunction2();
	
	function valida(){
		if($("[name='cancelar']").val() > compra["PRECIO"]*compra["PESO"]){
			alerta("error","El monto a cancelar en dolares no puede superar el precio original");
		}else{
			$('#ejecutor').click();
		}
	}
	
	function acancelar(){
		var VAL = $("[name='cancelar']").val();
		$("[name='diferencia']").val(money((compra["PRECIO"]*compra["PESO"])-VAL));
		var tasa = $("[name='tasa']").val();
		
		$("[name='restante']").val(money(((compra["PRECIO"]*compra["PESO"])-VAL) * tasa));
		
		var temp = {
			"DIFERENCIA" : (compra["PRECIO"]*compra["PESO"])-VAL,
			"TAZA" : $("[name='tasa']").val()
			
		};
		compra["SPLIT"] = temp;
	}
