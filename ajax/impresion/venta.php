<style>
    td{
        border-right: 1px solid #000 !important;
        border-bottom: 1px solid #000 !important;
    }   
    .negrita{
        font-weight: bold !important;
    }
	tr:last-child > td{
		border-bottom: 0px !important;
	}
	table{
		border-spacing: 0px;
	}
</style>
<?php include "../../php/API/query.php";include "../../php/API/util.php";$query = new query();$util = new util();
$temp = (array) $query->select(array("*"),"VVENTA","WHERE ID = (SELECT ID FROM VVENTA ORDER BY ID DESC LIMIT 0,1)");
$id = (array) $query->select(array("ID"),"VVENTA","ORDER BY ID DESC LIMIT 0,1");
$count = (array) $query->select(array("count(ID) as COUNT"),"VVENTA","WHERE ID = (SELECT ID FROM VVENTA ORDER BY ID DESC LIMIT 0,1)");
$sum = (array) $query->select(array("SUM(MONTO) as SUM"),"VVENTA","WHERE ID = (SELECT ID FROM VVENTA ORDER BY ID DESC LIMIT 0,1)");?>
<!DOCTYPE html>
<html lang="en-us">	
	<head>
		<meta charset="utf-8">
		<title>Factura</title>
		<meta name="description" content="">
		<meta name="author" content="Kellian Rea">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<!-- CSS del sistema -->
		<link rel="stylesheet" type="text/css" media="screen" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="../../css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="../../css/estilo.css">
	</head>
	<body class="content">
		<div class="row" style="border:1px solid black;padding:3%">
			<div class="col-md-6" style="display:inline-block;width:50%;float:left">
				<!--label>RIF J-29846820-3</label>
				<br-->
			</div>
			<div class="col-md-6 right" style="display:inline-block;width:50%;float:right;text-align:right">
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<section id="widget-grid" class="">
							<div class="row">
								<article class="col-sm-12 col-md-12 col-lg-12" style="padding:0">
									<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
										<header>
											<!--span class="widget-icon"> <i class="fa fa-edit"></i> </span>
											<h2>Factura de Venta</h2-->				
										</header>
										<div class="content">
											<div class="jarviswidget-editbox">	
											</div>
											<div class="widget-body no-padding">







                                                <table style="border: none !important;" class="table table-condensed table-striped table-bordered table-hover" width="100%">
													<thead>			                
														<tr>
															<th style="border: none !important" class="center">CLOCK SAN DIEGO, C.A.</th>
														</tr>
													</thead>
													<tbody>
                                                        <tr>
															<td style="border: none !important;text-align:center !important">Av. Julio Centeno C.C. San Diego, Nivel Galería III, Local N°. P-2.</td>
														</tr>
														<tr>
															<td style="border: none !important;text-align:center !important">Urb. San Diego - Edo. Carabobo. Telf. 0241 - 414.25.12</td>
														</tr>
														<tr>
															<td style="border: none !important;text-align:left !important">RIF. J-29846820-3</td>
														</tr>
													</tbody>
												</table>

                                               

                                                <table style="margin-bottom:10px;border-radius:5px;border: 1px solid #000 !important" class="table table-condensed table-striped table-bordered table-hover" width="100%">
													<thead>			                
														<tr>
															<td style="border-bottom: 1px solid #000 !important;width:50%;text-align:center !important" ><span class="negrita">FECHA DE EMISIÓN</span> </td>
															<td style="border-bottom: 1px solid #000 !important;width:50%;border-right: 0px !important;text-align:center !important" class="center"><span class="negrita">FACTURA</span></td>
														</tr>
													</thead>
													<tbody>			                
														<tr>
															<td style="border-bottom: 0px !important;text-align:center !important"><?php echo date("d/m/Y"); ?></td>
                                                            <td style="border-right: 0px !important;border-bottom: 0px !important;width:50%;text-align:center !important" class="center"> <?php echo 'N° ' . $id[0]['ID']; ?></td>
														</tr>
													</tbody>
												</table>

                                                <table style="margin-bottom:20px;border-radius:5px;border: 1px solid #000 !important" class="table table-condensed table-striped table-bordered table-hover" width="100%">
													<tbody>			                
														<tr>
															<td style="border-right: 0px !important;" COLSPAN="3" class="center"><span class="negrita">Nombre o Razón Social:</span> <?php echo $temp[0]['CLIENTE'] ?></td>
														</tr>
														<tr>
                                                            <td style="width:30%" class="center"><span class="negrita">Cedula:</span> <?php echo $temp[0]['DOCUMENTO'] ?></td>
                                                            <td style="border-right: 0px !important;width:30%" class="center"><span class="negrita">Telefono:</span>  <?php echo $temp[0]['TELEFONO'] ?></td>
														</tr>
                                                        <tr>
                                                            <td style="border-right: 0px !important;border-bottom: 0px !important;" COLSPAN="2" class="center"><span class="negrita">Domicilio Fiscal:</span>  <?php echo $temp[0]['DIRECCION'] ?></td>
														</tr>
                                                      
                                                       
													</tbody>
												</table>

                                               

												<table style="border: 1px solid #000 !important;border-radius:5px 5px 0px 5px;" class="table table-condensed table-striped table-bordered table-hover" width="100%">
													<thead>			                
														<tr>
															<td style="border-bottom: 1px solid #000 !important;text-align:center !important; width:15%"><span class="negrita">CANTIDAD</span></td>
															<td style="border-bottom: 1px solid #000 !important;text-align:center !important;width:40%"><span class="negrita">CONCEPTO O DESCRIPCIÓN</span></td>
															<td style="border-bottom: 1px solid #000 !important;text-align:center !important;width:21%"><span class="negrita">PRECIO<br>UNITARIO</span></td>
															<td style="border-bottom: 1px solid #000 !important;border-right: 0px !important;text-align:center !important;width:24%"><span class="negrita">IMPORTE TOTAL</span></td>
														</tr>
													</thead>
													<tbody>
														<?php
														foreach ($temp as $key => $value){
															echo '<tr>';
																echo '<td text-align:center !important">'.number_format($temp[$key]['DIMENSION'],2).'</td>';
																echo '<td text-align:center !important">'.$temp[$key]['DESCRIPCION'].'</td>';
																echo '<td text-align:center !important">'.'$ '.number_format($temp[$key]['PRECIO'],2).'</td>';
																echo '<td style="border-right: 0px !important;text-align:center !important; border-right: 0px !important;">'.number_format($temp[$key]['PRECIO']*$temp[$key]['DIMENSION'],2).'</td>';
															echo '</tr>';
														}?>
													</tbody>
												</table>
												<label><span class="negrita" style="font-size:7px;font-family:Lucida Console">ESTA FACTURA VA SIN TACHADURA NI ENMENDADURA</span></label>
                                                <table style="border: 1px solid #000 !important;border-top: 0px !important;border-radius:0px 0px 5px 5px;margin-bottom:10px;float:right;margin-right:1px" class="table table-condensed table-striped table-bordered table-hover" width="45%">
													<tbody>		
														<tr>
                                                            <td style="font-size:13px;width:47%;text-align:center !important;"><span class="negrita">AJUSTES</span></td>
                                                            <td style="border-right: 0px !important;text-align:center !important;"></td>
														</tr>		                
														<tr>
                                                            <td style="font-size:13px;border-bottom: 0px !important;width:47%;text-align:center !important;"><span class="negrita">TOTAL A PAGAR:</span></td>
                                                            <td style="border-bottom: 0px !important;border-right: 0px !important;text-align:center !important;"><?php echo number_format($sum[0]['SUM'],2);?></td>
														</tr>
													</tbody>
												</table>

                                                <br><br><br>

													<div class="col-sm-3" style="float:left;text-align:center">
														<label>_____________________</label>
														<br>
														<label>Recibe Conforme<br>Cliente</label>
													</div>

													<div class="col-sm-3" style="float:left;text-align:center">
														<label>_____________________</label>
														<br>
														<label>Firma y Sello</label>
													</div>
													<br>
													

















											</div>
										</div>
									</div>
								</article>
							</div>
						</section>
					</div>
				</div>
			</div>
			<br><br>
			<!--label>TOTAL DE PIEZAS RETIRADAS: <?php // echo $count[0]['COUNT'] . '<br>'; ?></label>
			<label>TOTAL EN GRAMOS RETIRADOS: <?php // echo number_format($sum[0]['SUM'],2); ?></label-->
		</div>
		
			
		



	
		<script>
		window.print();
		
		</script>
	</body>
</html>
