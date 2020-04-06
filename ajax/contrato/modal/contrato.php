<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../../../php/API/query.php";
	include "../../../php/API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../../../php/API/parametro.php";
	
	$contrato = (array) $query->select(array("*"),"CONTRATO","where ID = ".$_GET["ID"])[0];
	$cliente = (array) $query->select(array("*"),"CLIENTE","where ID = ".$contrato["CLIENTE"])[0];
	$detalle = (array) $query->select(array("*"),"CONTRATO_PIEZA","where CONTRATO = ".$_GET["ID"])[0];
	$pieza = (array) $query->select(array("*"),"PIEZA","where ID = ".$detalle["PIEZA"])[0];
	$dia = (array) $query->select(array("DIAS"),"VCONTRATO","where CONTRATO = ".$_GET["ID"])[0];
	
	$T = (array) $query->select(array("SUM(MONTO) as MONTO"),"PAGO","where CONCEPTO = 1 and CONTRATO = ".$_GET["ID"])[0];
	if(!isset($T["MONTO"])){
		$T = 0;
	}else{
		$T = $T["MONTO"];
	}
	
	$IPAGAR = ($dia["DIAS"] < 30)? ((($detalle["PRECIO"] * $pieza["DIMENSION"])-$T) * $detalle["PORCENTAJE"]) / 100 : ((((($detalle["PRECIO"] * $pieza["DIMENSION"])-$T) * $detalle["PORCENTAJE"]) / 100) / 30) * $dia["DIAS"];
	$disabled = ($contrato["CANCELADO"] == 1)? "disabled" : "";
?>



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
											
											
											<fieldset>
												<section class="col col-6 no-margin no-padding">
													<header style="margin-bottom:3%">Datos del Articulo</header>
													<section class="col col-6">
														<label class="input">
															<i class="icon icon-prepend fa fa-cube"></i>
															<input value="<?php echo $articulo[$pieza["ARTICULO"]]["DESCRIPCION"]; ?>"  type="text" placeholder="Articulo" readonly>
															<i class="tooltip tooltip-top-left">Articulo</i>
														</label>
													</section>
													<section class="col col-6">
														<label class="input">
															<i class="icon icon-append fa fa-money"></i>
															<input class="right" value="<?php echo $moneda[$contrato["MONEDA"]]["DESCRIPCION"]; ?>" type="text" placeholder="Moneda" readonly>
															<i class="tooltip tooltip-top-left">Moneda</i>
														</label>
													</section>
													<section class="col col-6">
														<label class="input">
															<i class="icon icon-prepend fa fa-dollar"></i>
															<input value="<?php echo $detalle["PORCENTAJE"]; ?>%" type="text" placeholder="Interes" readonly>
															<i class="tooltip tooltip-top-left">Interes</i>
														</label>
													</section>
													<section class="col col-12">
														<label class="input">
															<i class="icon icon-prepend fa fa-envelope"></i>
															<input value="<?php echo $pieza["DIMENSION"]." ".$medida[$articulo[$pieza["ARTICULO"]]["MEDIDA"]]["DESCRIPCION"]; ?>" type="text" placeholder="Peso" readonly>
															<i class="tooltip tooltip-top-left">Peso de la pieza (en gramos)</i>
														</label>
													</section>
													<section class="col col-12">
														<label class="textarea">
															<i class="icon icon-prepend fa fa-pencil"></i>
															<textarea  rows="5" placeholder="Descripcion" readonly><?php echo $pieza["DESCRIPCION"]; ?></textarea>
															<i class="tooltip tooltip-top-left">Descripcion del articulo (opcional)</i>
														</label>
													</section>
												</section>
												<section class="col col-6 no-padding">
													<header style="margin-bottom:3%">Datos del Contrato</header>
													<section class="col col-6">
														<label class="input">
															<i class="icon icon-prepend fa fa-clock-o"></i>
															<input value="<?php echo $contrato["DURACION"]." Dias"; ?>"  type="text" placeholder="Duracion" readonly>
															<i class="tooltip tooltip-top-left">Duracion</i>
														</label>
													</section>
													<section class="col col-6">
														<label class="input">
															<i class="icon icon-append fa fa-dollar"></i>
															<input value="<?php echo number_format(round($detalle["PRECIO"],2),2); ?>" class="right" type="text" placeholder="Precio" readonly>
															<i class="tooltip tooltip-top-right">Precio</i>
														</label>
													</section>
													<section class="col col-6">
														<label class="input ">
															<i class="icon icon-prepend fa fa-dollar"></i>
															<input value="<?php echo number_format(round($detalle["PRECIO"] * $pieza["DIMENSION"],2),2); ?>" class="left" type="text" placeholder="Precio" readonly>
															<i class="tooltip tooltip-top-left">Monto total inicial</i>
														</label>
													</section>
													<section class="col col-6">
														<label class="input state-error">
															<i class="icon-append fa fa-money"></i>
															<input name="montof" class="right"  value="<?php echo number_format(round(($detalle["PRECIO"] * $pieza["DIMENSION"]) - $T,2),2); ?>" type="text" placeholder="Monto" readonly>
															<i class="tooltip tooltip-top-right">Monto total a la fecha</i>
														</label>
													</section>
													<section class="col col-6">
														<label class="input">
															<i class="icon-prepend fa fa-money"></i>
															<input name="intef" value="<?php echo number_format(round(((($detalle["PRECIO"] * $pieza["DIMENSION"])- $T) * $detalle["PORCENTAJE"]) / 100,2),2); ?>" class="left" type="text" placeholder="Monto del Interes" readonly>
															<i class="tooltip tooltip-top-left">Intereses discriminados</i>
														</label>
													</section>
													<section class="col col-6">
														<label class="input">
															<i class="icon-append fa fa-calendar"></i>
															<input class="right" value="<?php echo $util->tonormaldate($contrato["EMISION"]); ?>" type="text" placeholder="Fecha de Emision" readonly>
															<i class="tooltip tooltip-top-right">Fecha de emision del contrato</i>
														</label>
													</section>
													<section class="col col-6">
														<label class="input">
															<i class="icon-prepend fa fa-calendar"></i>
															<input value="<?php echo $util->tonormaldate($contrato["RENOVACION"]); ?>" name="vencimiento" class="left" type="text" placeholder="Fecha de vencimiento">
															<i class="tooltip tooltip-top-left">Fecha de Ultima renovacion</i>
														</label>
													</section>
													<section class="col col-6">
														<label class="input">
															<i class="icon-append fa fa-calendar"></i>
															<input value="<?php echo $util->tonormaldate($contrato["VENCIMIENTO"]); ?>"  name="vencimiento" class="right" type="text" placeholder="Fecha de vencimiento">
															<i class="tooltip tooltip-top-right">Fecha de Vencimiento</i>
														</label>
													</section>
													<section class="col col-6">
														<label class="input">
															<i class="icon-prepend fa fa-dollar"></i>
															<input class="left" value="<?php echo number_format(round(((($detalle["PRECIO"] * $pieza["DIMENSION"])-$T) + ((($detalle["PRECIO"] * $pieza["DIMENSION"])-$T) * $detalle["PORCENTAJE"]) / 100),2),2); ?>" type="text" placeholder="Monto de finiquito de contrato" readonly>
															<i class="tooltip tooltip-top-left">Monto de finiquito</i>
														</label>
													</section>
												</section>
											</fieldset>
											<fieldset>
												<section class="col col-6 no-margin no-padding">
													<header style="margin-bottom:3%">Historial de pagos</header>
													<section class="col col-12">
														<table class="table table-responsive table-bordered table-condensed table-hover">
															<thead>
																<tr>
																	<th class="center" style="width:30%">Fecha</th>
																	<th class="center" style="width:30%">Monto</th>
																	<th class="center" style="width:30%">Concepto</th>
                                                                    <th class="center" style="width:10%"><i class='fa fa-share'></i></th>
                                                                    <th class="center" style="width:10%"><i class='fa fa-envelope'></i></th>
																</tr>
															</thead>
															<tbody>
																<?php
																	$TEMP = (array) $query->select(array("*"),"VPAGO","where CONTRATO = ".$_GET["ID"]);
																	
																	foreach($TEMP as $indice => $valor){
																		$elim = ($valor["FECHA"] == date("Y-m-d"))?"<td class='center'><button type='button' class='btn btn-sm btn-danger' onclick='elim(".$valor["ID"].")'><i class='fa fa-share'></i></button></td>":"<td></td>";
																		
																		echo "
																			<tr class='".$valor["ID"]."row'>
																				<td class='center'>".$util->tonormaldate($valor["FECHA"])."</td>
																				<td class='center'>$".number_format(round($valor["MONTO"],2),2)."</td>
																				<td class='center'>".$valor["DESCRIPCION"]."</td>
                                                                                ".$elim."
                                                                                <td class='center'><a class='btn btn-sm btn-info' target='_blank' href='/ajax/impresion/recibo.php?PAGO=".$valor["ID"]."'><i class='fa fa-envelope'></i></a></td>'
																			</tr>																	
																		";
																	};
																?>
															</tbody>
														</table>
													</section>
												</section>
												<section class="col col-6 no-margin no-padding">
													<header style="margin-bottom:3%">Datos de pago</header>
													<section class="col col-12">
														<h4 style="margin-bottom:3%">Interes a pagar a la Fecha</h4>
														<label class="input state-success">
															<i class="icon-prepend fa fa-dollar"></i>
															<input id="abonar" class="left" value="<?php echo number_format(round($IPAGAR,2),2); ?>" type="text" placeholder="Monto de finiquito de contrato" readonly>
															<i class="tooltip tooltip-top-left">Monto de finiquito</i>
														</label>
													</section>
													<section class="col col-12">
														<h4 style="margin-bottom:3%">Monto para cancelar contrato</h4>
														<label class="input state-error">
															<i class="icon-prepend fa fa-dollar"></i>
															<input id="cancelar" class="left" value="<?php echo number_format(round(((($detalle["PRECIO"] * $pieza["DIMENSION"])-$T) + $IPAGAR),2),2); ?>" type="text" placeholder="Monto de finiquito de contrato" readonly>
															<i class="tooltip tooltip-top-left">Monto de finiquito</i>
														</label>
													</section>
												</section>
											</fieldset>
			
											<footer>
												<section class="col col-12 no-margin">
													
													<button id="cerrar" class="btn btn-danger pull-left" data-dismiss="modal" type="button"><i class="fa fa-times"></i></button>
													<button onclick="imprimir();" class="btn btn-primary pull-left" type="button" ><i class="fa fa-print"></i></button>
													<button onclick="sobre();" class="btn btn-primary pull-left" type="button" ><i class="fa fa-envelope"></i></button>
													<button onclick="cancelo();" id="cancelacion" class="btn btn-warning pull-right" type="button" <?php echo $disabled; ?>><i class="fa fa-share" ></i></button>
													<button onclick="pagando();" id="pago" class="btn btn-success right" type="button" <?php echo $disabled; ?>>Abonar</button>
													<button onclick="parcialE();" id="parcial" class="btn btn-info right" type="button" <?php echo $disabled; ?>>Pago parcial</button>
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
	var diase = <?php echo $dia["DIAS"];?>;
	var pagefunction = function() {
		

	};

	pagefunction();
	
	function pagando(){
		
		if(diase == 0){
			$("#cerrar").click();
			$.SmartMessageBox({
					title : "Indique Cuanto va a abonar a Capital",
					buttons : "[Cancelar][Aceptar]",
					input : "text",
					placeholder : "0.00"
				}, function(ButtonPress, Value) {
					if (ButtonPress == "Aceptar") {
						$.ajax({
							url:"php/contrato/abono.php",
							type:"POST",
                            async: false,
							data:{"DATO":Value,"C":<?php echo $_GET["ID"]; ?>},
							beforeSend: function(){
								$("#pago").attr("disabled","disabled");
							},
							success: function(resp){
								resp = JSON.parse(resp);
								$("#pago").removeAttr("disabled");
								
								alerta('success','Monto Abonado a Capital, Por Favor reimprima el contrato');
								openInNewTab("/ajax/impresion/recibo.php?PAGO="+resp["MENSAJE"]["pago"]);
								buscar();
								$("#cerrar").click();
							}
						})
					}
				});	
		}else{
			V = $("#abonar").val();
			$.SmartMessageBox({
				
					title : "Desea cancelar Intereses por valor de : $"+V+"?",
					buttons : "[Cancelar][Aceptar]",
				}, function(ButtonPress) {
					if (ButtonPress == "Aceptar") {
						$.ajax({
							url:"php/contrato/abono.php",
							type:"POST",
                            async: false,
							data:{"DATO":V,"C":<?php echo $_GET["ID"]; ?>},
							beforeSend: function(){
								$("#pago").attr("disabled","disabled");
							},
							success: function(resp){
								resp = JSON.parse(resp);
								$("#pago").removeAttr("disabled");
								//alerta(resp["ESTADO"],resp["MENSAJE"])
								alerta('success','Monto Abonado a Capital, Por Favor reimprima el contrato');
								openInNewTab("/ajax/impresion/recibo.php?PAGO="+resp["MENSAJE"]["pago"]);
								buscar();
								$("#cerrar").click();
							}
						})
					}
				});	
			
		}
		
		
		
		
		
		
	}
	
    function openInNewTab(url) {
        var win = window.open(url, '_blank');
        win.focus();
        }

	function cancelo(){
		V = $("#cancelar").val();
		$.SmartMessageBox({
				
					title : "Desea cancelar El total del contrato por valor de : $"+V+"?",
					buttons : "[Cancelar][Aceptar]",
				}, function(ButtonPress) {
					if (ButtonPress == "Aceptar") {
						$.ajax({
							url:"php/contrato/cancelar.php",
							type:"POST",
							data:{"DATO":V,"C":<?php echo $_GET["ID"]; ?>},
							beforeSend: function(){
								$("#canelacion").attr("disabled","disabled");
							},
							success: function(resp){
								//resp = JSON.parse(resp);
								$("#cancelacion").removeAttr("disabled");
								alerta('success','Contrato Pagado y Finalizado, Imprima el comprobante de cancelacion')
								
								//alerta('resp["ESTADO"]',resp["MENSAJE"])
								buscar();
								$("#cerrar").click();
							}
						})
					}
				});	
		
		
		
	}
	function imprimir(){
		var win = window.open("ajax/impresion/contrato.php?CONTRATO=<?php echo $_GET["ID"] ?>&MONEDA=<?php echo $moneda[$contrato["MONEDA"]]["DESCRIPCION"]; ?>&INICIO=<?php echo $util->tonormaldate($contrato["RENOVACION"]); ?>&VENCE=<?php echo $util->tonormaldate($contrato["VENCIMIENTO"]); ?>&CLIENTE=<?php echo $contrato["CLIENTE"] ?>&DESCRIPCION=<?php echo $pieza["DESCRIPCION"]; ?>&ARTICULO=<?php echo $articulo[$pieza["ARTICULO"]]["DESCRIPCION"]; ?>&PESO=<?php echo $pieza["DIMENSION"]; ?>&FINIQUITO=<?php echo number_format(round(((($detalle["PRECIO"] * $pieza["DIMENSION"])-$T) + ((($detalle["PRECIO"] * $pieza["DIMENSION"])-$T) * $detalle["PORCENTAJE"]) / 100),2),2); ?>&INTERES=<?php echo number_format(round(((($detalle["PRECIO"] * $pieza["DIMENSION"])- $T) * $detalle["PORCENTAJE"]) / 100,2),2); ?>", '_blank');
		win.focus();
		
	};
	
	function sobre(){
		var win = window.open("ajax/impresion/sobre.php?CONTRATO=<?php echo $_GET["ID"] ?>&MONEDA=<?php echo $moneda[$contrato["MONEDA"]]["DESCRIPCION"]; ?>&INICIO=<?php echo $util->tonormaldate($contrato["RENOVACION"]); ?>&VENCE=<?php echo $util->tonormaldate($contrato["VENCIMIENTO"]); ?>&CLIENTE=<?php echo $contrato["CLIENTE"] ?>&DESCRIPCION=<?php echo $pieza["DESCRIPCION"]; ?>&ARTICULO=<?php echo $articulo[$pieza["ARTICULO"]]["DESCRIPCION"]; ?>&PESO=<?php echo $pieza["DIMENSION"]; ?>&FINIQUITO=<?php echo number_format(round(((($detalle["PRECIO"] * $pieza["DIMENSION"])-$T) + ((($detalle["PRECIO"] * $pieza["DIMENSION"])-$T) * $detalle["PORCENTAJE"]) / 100),2),2); ?>&INTERES=<?php echo number_format(round(((($detalle["PRECIO"] * $pieza["DIMENSION"])- $T) * $detalle["PORCENTAJE"]) / 100,2),2); ?>", '_blank');
		win.focus();
		
	};
	
	function elim(id){
		$.ajax({
			url:"php/contrato/elim.php",
			type:"POST",
			data:{"DATO":id},
			success:function(resp){
		
				alerta('success','Renovacion eliminada correcatamente');
				$('#detalle').modal('hide');
				buscar();
				/*resp = JSON.parse(resp);
				alerta(resp["ESTADO"],resp["MENSAJE"]);
				if(resp["ESTADO"] == "success"){$("."+id+"row").remove()};*/
			}
		})
		
	};
	
	function parcialE(){
		var temp = $("[name='intef']").val();
		console.log(temp);
		$("#cerrar").click();
		$.SmartMessageBox({
			title : "Indique la cantidad de dias a cancelar",
			buttons : "[Cancelar][Aceptar]",
			input : "text",
			placeholder : "0"
		}, function(ButtonPress,valor) {
			if (ButtonPress == "Aceptar") {
				if(valor == NaN || valor > diase){
					alerta("error","El valor ingresado no es valido");
				}else{
					
					temp = (temp / 30) * valor;
					
					$.SmartMessageBox({
						title : "El monto a pagar seria de "+money(temp)+" Dolares totales, esta seguro?",
						buttons : "[Cancelar][Aceptar]"
					}, function(ButtonPress) {
							if (ButtonPress == "Aceptar") {
							$.ajax({
								url:"php/contrato/parcial.php",
								type:"POST",
								data:{"DATO":valor,"C":<?php echo $_GET["ID"]; ?>,"MONTO":temp},
								beforeSend: function(){
									$("#pago").attr("disabled","disabled");
								},
								success: function(resp){
									//resp = JSON.parse(resp);
									$("#pago").removeAttr("disabled");
									//alerta(resp["ESTADO"],resp["MENSAJE"])
									alerta('success','Interes Abonado correctamente, Por Favor reimprima el contrato')
									buscar();
									
								}
							})
						}
						
					});	
				}
			}
		});	
	}
</script>


