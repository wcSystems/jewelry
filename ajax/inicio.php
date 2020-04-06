<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	include "../php/API/query.php";
	include "../php/API/util.php";
	
	$query = new query();
	$util = new util();
	
	include "../php/API/parametro.php";
	include "../php/API/caja.php";
	include "../php/API/cajames.php";
	
	$DISPONIBLE = $Dingreso - $Degreso;
	
	
	$total = cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y"));
	$cont = 1;
	while( $cont <= $total ){

		$DESDE = date("Y")."-".date("m")."-".$cont;

		$Bingreso = 0;$Begreso = 0;
		$Dingreso = 0;$Degreso = 0;
		
		$contrato = (array) $query->select(array("SUM(ENTREGADO) as MONTO"),"VCONTRATO","where MONEDA = 1 and EMISION = '".$DESDE."'")[0];
		$Dingreso = $Dingreso + $contrato["MONTO"];
		
		$compra = (array) $query->select(array("SUM((DIMENSION * PRECIO) - (DIFERENCIA)) as MONTO"),"VCOMPRA","where MONEDA = 'DOLARES' AND ELIM = 0 and FECHA = '".$DESDE."'")[0];
		$Dingreso = $Dingreso + $compra["MONTO"];
		
		
	
		$array[] = array("FECHA"=>$DESDE,"DOLARES"=>$Dingreso,2);
		
		$cont++;
		
	}
	
	$_SESSION['INC_METAS'] = 1;
	
?>



<div class="row">
	<div class="col-md-12">
		<div class="col-md-12">
			<section id="widget-grid" class="">
				<div class="row">
					<article class="col-sm-12 col-md-12 col-lg-12" >
						<div class="jarviswidget" id="wid-id-0" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
						<header>
							<span class="widget-icon"> <i class="glyphicon glyphicon-stats txt-color-darken"></i> </span>
							<h2>Informacion de interes </h2>
						</header>
						<div class="no-padding">
							<div class="jarviswidget-editbox">

							</div>
							<div class="widget-body">
								<div class="row no-space">



									<div class="col-md-12 col-sm-12">
										<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
											<div id="morris-chart" class="chart-large txt-color-blue"></div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 show-stats">
											<div class="row">
												<?php 
													if($query->if_exist(array("MONEDA"=>"DOLARES","DEFINICION"=>"CONTRATO","PERIODO"=>"".date("Y")."-".date("m")."-01" ),"VMETA")){
														$T = (Array) $query->select(array("SUM(OBJETIVO) AS OBJETIVO"),"VMETA","where MONEDA = 'DOLARES' AND DEFINICION = 'CONTRATO' AND MONTH(CURRENT_DATE) = MONTH(PERIODO) ")[0];
														$T = (empty($T))? 0 : $T;
														$CUMPLIDO = (array) $query->select(array("SUM(ENTREGADO) as MONTO"),"VCONTRATO","Where MONTH(CURRENT_DATE) = MONTH(EMISION)")[0];
														$CUMPLIDO = (empty($CUMPLIDO))? 0 : $CUMPLIDO;
														$porcentaje = ($CUMPLIDO["MONTO"] * 100) / $T["OBJETIVO"];
													}else{
														$porcentaje = 0;
														$CUMPLIDO["MONTO"] = 0;
														$T["OBJETIVO"] = 0;
													}
												?>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <span class="text"> Meta de Contrato alcanzados <span class="pull-right">$<?php echo number_format($CUMPLIDO["MONTO"],2)." / $".number_format($T["OBJETIVO"],2); ?></span> </span>
													<div class="progress">
														<div class="progress-bar bg-color-blueDark" style="width: <?php echo $porcentaje; ?>%;"></div>
													</div> 
												</div>






												<div class="contenedor-g"> 
													<?php 
														$ART = $query->select(array("ID_ARTICULO,ARTICULO"),"VMETA","WHERE DEFINICION = 'COMPRA' GROUP BY ARTICULO,ID_ARTICULO");
														$id = count($ART);
														foreach ($ART as $key => $value) {
															$CUMPLIDO = (array) $query->select(array("SUM(DIMENSION) as TOTAL"),"VCOMPRA","Where MONTH(CURRENT_DATE) = MONTH(FECHA) and MEDIDA = 'Gramos' and ELIM = 0 AND ID_ARTICULO = ".$ART[$key]['ID_ARTICULO'])[0];
															$T = (array) $query->select(array("SUM(OBJETIVO) AS OBJETIVO"),"VMETA","where DEFINICION = 'COMPRA' AND MONTH(CURRENT_DATE) = MONTH(PERIODO) AND ID_ARTICULO = '".$ART[$key]['ID_ARTICULO']."' ")[0];
															if($T["OBJETIVO"] > 0){$porcentaje = ($CUMPLIDO["TOTAL"] * 100) / $T["OBJETIVO"];}else{$porcentaje = 0;}
															
															echo '<div style="display:none" class="metas-clases col-xs-12 col-sm-12 col-md-12 col-lg-12"> <span class="text"> Meta de compras alcanzado '.$ART[$key]['ARTICULO'].' <span class="pull-right">'.number_format($CUMPLIDO["TOTAL"],2)." / ".number_format($T["OBJETIVO"],2).'</span> </span>
																	<div class="progress">
																		<div class="progress-bar bg-color-blue" style="width:'.$porcentaje.'%"></div>
																	</div> 
																</div>';
														}
													?>
												</div>









												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <span class="text"> Saldo disponible en dolares<span class="pull-right">$ <?php echo number_format($DISPONIBLE,2); ?></span> </span>
													<div class="progress">
														<div class="progress-bar bg-color-blue" style="width: 100%;"></div>
													</div> 
												</div>
												<?php
												
												$total = cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y"));
												
												$porcentaje = (date("d") * 100) / $total;
												?>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <span class="text"> Dias transcurridos para cerrar las metas <span class="pull-right"><?php echo date("d")." / ".$total; ?></span> </span>
													<div class="progress">
														<div class="progress-bar bg-color-greenLight" style="width: <?php echo $porcentaje; ?>%;"></div>
													</div> 
												</div>









												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<button id="btn-metas" onclick="incrementar()" class="btn btn-primary" style="width:100%">METAS</button>
												</div> 
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<button class="btn btn-primary" style="width:100%">FILTRAR</button>
												</div>








											</div>
										</div>
									</div>

									




									<div class="col-md-12">
										<div class="show-stat-microcharts no-margin" >




















											<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 center" style="height : 100%">
												<?php
												
													//$ESPERADO = (Array) $query->select(array("SUM((ENTREGADO * PORCENTAJE) / 100) as TOTAL"),"VCONTRATO","WHERE REMATE = 0 and CANCELADO = 0 AND MONTH(CURRENT_DATE) = MONTH(VENCIMIENTO)")[0];
													$ESPERADO = (Array) $query->select(array("SUM(PAGAR) as TOTAL"),"VCONTRATO","WHERE REMATE = 0 and CANCELADO = 0 ")[0];
													$RECAUDADO = (array) $query->select(array("SUM(MONTO) as MONTO"),"VPAGO","where REMATE = 0 and CANCELADO = 0 and DESCRIPCION = 'RENOVACION' AND MONTH(CURRENT_DATE) = MONTH(FECHA)")[0];
													$caret = ($RECAUDADO > $ESPERADO)? "fa-caret-up":"fa-caret-down";
													$color = ($RECAUDADO > $ESPERADO)? "bg-color-green":"bg-color-red";
													$porcentaje = ($ESPERADO["TOTAL"] == 0)? 0 : ($RECAUDADO["MONTO"] * 100) / $ESPERADO["TOTAL"];
												?>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<h5 class=""> Intereses Recaudos / Esperados <i class="fa icon-color-bad"></i> </h5>
												<div class="easy-pie-chart txt-color-orangeDark" data-percent="<?php echo $porcentaje; ?>" data-pie-size="80">
													<span class="percent percent-sign"><?php echo $porcentaje; ?></span>
												</div>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<span class="easy-pie-title"> Detalle </span>
													<ul class="smaller-stat ">
														<li style="width:50%;display:inline-block;">
															<span style="min-width:70px;text-align:center !important" class="label center bg-color-green"> <i class="fa <?php echo $caret; ?>"></i> <?php echo number_format($RECAUDADO["MONTO"],2) ?></span>
															
														</li>
														<li style="display:inline-block;">
														<span style="min-width:70px;text-align:center !important" class="label center bg-color-red"><i class="fa fa-caret-right"></i> <?php echo number_format($ESPERADO["TOTAL"],2) ?></span>	
														</li>
													</ul>
												</div>
											</div>

























											<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 center" style="height : 100%">
												<?php
													$ESPERADO = (Array) $query->select(array("COUNT(*) as TOTAL"),"VCONTRATO","WHERE REMATE = 0 and CANCELADO = 0")[0];
													$RECAUDADO = (array) $query->select(array("COUNT(*) as MONTO"),"VCONTRATO","where REMATE = 0 and CANCELADO = 0 and DIAS > DURACION")[0];


													$caret = ($RECAUDADO > $ESPERADO)? "fa-caret-up":"fa-caret-down";
													$color = ($RECAUDADO > $ESPERADO)? "bg-color-green":"bg-color-red";
													$porcentaje = ($ESPERADO["TOTAL"] == 0)? 0 : ($RECAUDADO["MONTO"] * 100) / $ESPERADO["TOTAL"];
												?>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<h5 class=""> Contratos vencidos <i class="fa icon-color-bad"></i> </h5>
													<div class="easy-pie-chart txt-color-greenLight" data-percent="<?php echo $porcentaje; ?>" data-pie-size="80">
														<span class="percent percent-sign"><?php echo $porcentaje; ?> </span>
													</div>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<span class="easy-pie-title"> Detalle </span>
													<ul class="smaller-stat ">
														<li style="width:50%;display:inline-block;">
														<span style="min-width:70px;text-align:center !important" class="label bg-color-red"><i class="fa <?php echo $caret; ?>"></i> <?php echo $RECAUDADO["MONTO"] ?></span>
														</li>
														<li style="display:inline-block;">
															<span style="min-width:70px;text-align:center !important" class="label bg-color-green"><i class="fa fa-caret-right"></i> <?php echo $ESPERADO["TOTAL"] ?></span>
															
														</li>
													</ul>
													
												</div>
											</div>







































											<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 center" style="height : 100%">
												<?php



													$Dingreso = 0;$Degreso = 0;



													$pagos = (array) $query->select(array("SUM(MONTO) as MONTO"),"VPAGO","where MONEDA = 1 AND MONTH(CURRENT_DATE) = MONTH(FECHA) and ID != 92 and ID != 93")[0];
													$Dingreso = $Dingreso + $pagos["MONTO"];
													
													$ingreso = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 1 and MONEDA = 1 and ELIM = 0 AND MONTH(CURRENT_DATE) = MONTH(FECHA)")[0];
													$Dingreso = $Dingreso + $ingreso["MONTO"];
													
													$ingreso = (array) $query->select(array("SUM(PRECIO * DIMENSION) as MONTO"),"VVENTA","where MONEDA = 1 AND MONTH(CURRENT_DATE) = MONTH(FECHA)")[0];
													$Dingreso = $Dingreso + $ingreso["MONTO"];
													
													$contrato = (array) $query->select(array("SUM(ENTREGADO) as MONTO"),"VCONTRATO","where MONEDA = 1 AND MONTH(CURRENT_DATE) = MONTH(RENOVACION)")[0];
													$Degreso = $Degreso + $contrato["MONTO"];
													






													if($Dingreso > 0){$porcentaje = ($Degreso * 100) / $Dingreso;}else{$porcentaje = 0;}

														
													$caret = ($Degreso > $Dingreso)? "fa-caret-up":"fa-caret-down";
													$color = ($Degreso > $Dingreso)? "bg-color-green":"bg-color-red";
												?>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<h5 class=""> Dolares usados en contratos <i class="fa icon-color-bad"></i> </h5>
												<div class="easy-pie-chart txt-color-blue" data-percent="<?php echo $porcentaje; ?>" data-pie-size="80">
													<span class="percent percent-sign"><?php echo $porcentaje; ?> </span>
												</div>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<span class="easy-pie-title"> Detalle </span>
													<ul class="smaller-stat ">
														<li style="width:50%;display:inline-block;">
															<span style="min-width:70px;text-align:center !important" class="label bg-color-blueDark"><i class="fa fa-caret-right"></i> <?php echo number_format($Degreso,2) ?></span>
														</li>
														<li style="display:inline-block;">
															<span style="min-width:70px;text-align:center !important" class="label bg-color-blueDark "><i class="fa fa-caret-right"></i> <?php echo number_format($Dingreso,2) ?></span>
														</li>
													</ul>
													
												</div>
											</div>























											<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 center" style="height : 100%">
												<?php
													$Dingreso = 0;$Degreso = 0;
													$pagos = (array) $query->select(array("SUM(MONTO) as MONTO"),"VPAGO","where MONEDA = 1 AND MONTH(CURRENT_DATE) = MONTH(FECHA) and ID != 92 and ID != 93")[0];
													$Dingreso = $Dingreso + $pagos["MONTO"];
													
													$ingreso = (array) $query->select(array("SUM(MONTO) as MONTO"),"MOVIMIENTO","where TIPO = 1 and MONEDA = 1 and ELIM = 0 AND MONTH(CURRENT_DATE) = MONTH(FECHA)")[0];
													$Dingreso = $Dingreso + $ingreso["MONTO"];
													
													$ingreso = (array) $query->select(array("SUM(PRECIO * DIMENSION) as MONTO"),"VVENTA","where MONEDA = 1 AND MONTH(CURRENT_DATE) = MONTH(FECHA)")[0];
													$Dingreso = $Dingreso + $ingreso["MONTO"];
													
													$compra = (array) $query->select(array("SUM((DIMENSION * PRECIO) - (DIFERENCIA)) as MONTO"),"VCOMPRA","where MONEDA = 'DOLARES' AND ELIM = 0 AND MONTH(CURRENT_DATE) = MONTH(FECHA)")[0];
													$Degreso = $Degreso + $compra["MONTO"];
													
													if($Dingreso > 0){$porcentaje = ($Degreso * 100) / $Dingreso;}else{$porcentaje = 0;}

												?>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<h5 class=""> Dolares usados en Compras <i class="fa icon-color-bad"></i> </h5>
												<div class="easy-pie-chart txt-color-darken" data-percent="<?php echo $porcentaje; ?>" data-pie-size="80">
													<span class="percent percent-sign"><?php echo $porcentaje; ?> <i class="fa fa-caret-up"></i></span>
												</div>	
												</div>	
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<span class="easy-pie-title"> Detalle </span>
													<ul class="smaller-stat ">
														<li style="width:50%;display:inline-block;">
															<span style="min-width:70px;text-align:center !important" class="label bg-color-blueDark"><i class="fa fa-caret-right"></i> <?php echo number_format($Degreso,2) ?></span>
														</li>
														<li style="display:inline-block;">
															<span style="min-width:70px;text-align:center !important" class="label bg-color-blueDark "><i class="fa fa-caret-right"></i> <?php echo number_format($Dingreso,2) ?></span>
														</li>
													</ul>
													
												</div>										
											</div>

















										</div>
									</div>

















							</div>

						</div>
						<!-- end widget div -->
					</div>
					</article>
					
					<article class="col-sm-12 col-md-12 col-lg-12" >
						<!-- Grilla POST-IT -->
						<div class="jarviswidget jarviswidget-color-darken" id="POST-IT" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
							<header>
								<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
								<h2>Tablon de Notas</h2>				
							</header>
							<div class="content" style="padding-top:0">
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body">
									<div class="row" style="max-height:75vh;overflow-y:auto">
										<div class="well well-sm">
											<button rel="tooltip" data-original-title="!Crear Sticky!" data-placement="right" type="button" href="ajax/modal/sticky.php?P=S" data-toggle="modal" data-target="#detalle" class="btn btn-success"><i class="fa fa-plus"></i></button>
										</div>
										<div class="col-md-9 smart-form no-padding">
											<header>Notas Publicas</header>
											<ul id="NPUBLICAS" class="tablon">
									
											</ul>
										</div>
										<div class="col-md-3 smart-form no-padding">
											<header>Mis Notas</header>
											<ul id="NPROPIAS" class="tablon">
									
											</ul>
										</div>
									</div>
									
								</div>
							</div>
						</div>
						<!-- Grilla POST-IT -->
					</article>
					<article class="col-sm-12 col-md-8 col-lg-8" >
						<!-- Grilla CALENDAR -->
						<div class="jarviswidget jarviswidget-color-darken" id="CALENDAR" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
							<header>
								<span class="widget-icon"> <i class="fa fa-calendar"></i> </span>
								<h2> Calendario </h2>
								<div class="widget-toolbar">	
								</div>
							</header>
							<div class="content" >
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body" style="padding-bottom:0">
								
									<!-- widget div-->
									<div>
										<div class="widget-body no-padding">
											<!-- content goes here -->
											<div class="well well-sm">
												<a href="ajax/modal/calendario.php?P=S" data-toggle="modal" data-target="#detalle" rel="tooltip" data-original-title="Nuevo Evento" data-placement="right" class="btn btn-success" type="button"><i class="fa fa-plus"></i></a>
												<a style="visibility:hidden" id="oculto" href="ajax/modal/calendario.php?P=S" data-toggle="modal" data-target="#detalle" type="button"></a>
											</div>
											<div class="widget-body-toolbar">
												<div id="calendar-buttons">
													<div class="btn-group">
														<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-prev"><i class="fa fa-chevron-left"></i></a>
														<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-next"><i class="fa fa-chevron-right"></i></a>
													</div>
												</div>
											</div>
											<div id="calendar"></div>
											<!-- end content -->
										</div>
									</div>
									<!-- end widget div -->
								</div>
							</div>
						</div>
						<!-- Grilla CALENDAR -->
					</article>
					<article class="col-sm-12 col-md-4 col-lg-4" >
					<!-- Grilla CALENDAR -->
						<div class="jarviswidget jarviswidget-color-darken" id="NOTAS" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
							<header>
								<span class="widget-icon"> <i class="fa fa-calendar"></i> </span>
								<h2> Simple Notes </h2>
								<div class="widget-toolbar">	
								</div>
							</header>
							<div class="content" >
								<div class="jarviswidget-editbox">	
								</div>
								<div class="widget-body no-padding">
									<form class="smart-form no-padding">
										<fieldset class="no-padding">
											<section class="col col-12 no-padding no-margin">
												<label class="textarea">
													<textarea id="simplenote" onkeyup="simplenotes($(this).val());" rows="20" style="width:100%;overflow-x:hidden;background-image: url('img/test.jpg');">
													
													</textarea>
												</label>
											</section>
										</fieldset>
									</form>
								</div>
							</div>
						</div>
						<!-- Grilla CALENDAR -->
					</article>
				</div>
			</section>
		</div>
	</div>
</div>

<div class="modal fade" id="detalle" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">  
    <div class="modal-dialog">  
        <div class="modal-content"></div>  
    </div>  
</div>

<script>

pageSetUp();

var pagefunction = function() {
	
	notas();
	calendario();
	eventos();
	getnotes();
	$(document).ready(function(){
		window.setInterval(function(){eventos()}, 4000);		
	});
};

loadScript("js/plugin/moment/moment.min.js", function(){
	loadScript("js/plugin/fullcalendar/fullcalendar.min.js", function(){
		loadScript("js/calendario.js", function(){
			loadScript("js/sticky.js", pagefunction);
		});
	});
});

loadScript("js/plugin/morris/raphael.min.js", function(){
		loadScript("js/plugin/morris/morris.min.js", pagemorris);
	});
	
var pagemorris = function() {
	
	Morris.Area({
					element : 'morris-chart',
					data : JSON.parse('<?php echo json_encode($array); ?>'),
					xkey : 'FECHA',
					ykeys : ['DOLARES'],
					labels : ['DOLARES'],
					pointSize : 2,
					hideHover : 'auto'
				});
};




function est()
{
	ART = <?php echo json_encode($query->select(array("ID_ARTICULO,ARTICULO"),"VMETA","WHERE DEFINICION = 'COMPRA' GROUP BY ARTICULO,ID_ARTICULO"))?>;
	$('#btn-metas').text(ART[0]['ARTICULO'])

}
est()



$('.metas-clases:nth-child(1)').css('display','')
var contador=2;
function incrementar()
{
	ART = <?php echo json_encode($query->select(array("ID_ARTICULO,ARTICULO"),"VMETA","WHERE DEFINICION = 'COMPRA' GROUP BY ARTICULO,ID_ARTICULO"))?>;
	if(contador > $('.metas-clases').length ){contador = 1}
	$('.metas-clases').css('display','none')
	$('.metas-clases:nth-child('+contador+')').css('display','')
	rest = contador - 1;
	$('#btn-metas').text(ART[rest]['ARTICULO'])
	contador++;
}






</script>
