<?php include "../../php/API/query.php";include "../../php/API/util.php";$query = new query();$util = new util();
$temp = (array) $query->select(array("*"),"VRETIRO","WHERE ID = (SELECT ID FROM VRETIRO ORDER BY ID DESC LIMIT 0,1)");
$id = (array) $query->select(array("ID"),"VRETIRO","ORDER BY ID DESC LIMIT 0,1");
$count = (array) $query->select(array("count(ID) as COUNT"),"VRETIRO","WHERE ID = (SELECT ID FROM VRETIRO ORDER BY ID DESC LIMIT 0,1)");
$sum = (array) $query->select(array("SUM(DIMENSION) as SUM"),"VRETIRO","WHERE ID = (SELECT ID FROM VRETIRO ORDER BY ID DESC LIMIT 0,1)");?>
<!DOCTYPE html>
<html lang="en-us">	
	<head>
		<meta charset="utf-8">
		<title> S.M.A.R.T </title>
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
				<label>CLOCK SAN DIEGO C.A.</label><br>
				<label>RIF J-29846820-3</label>
				<br><br>
				<label>RETIRO N° <?php echo $id[0]['ID']; ?></label>
			</div>
			<div class="col-md-6 right" style="display:inline-block;width:50%;float:right;text-align:right">
				<label class="right" style=""><?php echo date("d/m/Y"); ?></label>
			</div>
			<br><br><br><br>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<section id="widget-grid" class="">
							<div class="row">
								<article class="col-sm-12 col-md-12 col-lg-12" style="padding:0">
									<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
										<header>
											<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
											<h2>Retiro de Piezas</h2>				
										</header>
										<div class="content">
											<div class="jarviswidget-editbox">	
											</div>
											<div class="widget-body no-padding">
												<table class="table table-condensed table-striped table-bordered table-hover" width="100%">
													<thead>			                
														<tr>
															<th class="center">PIEZA N°</th>
															<th class="center">ARTICULO</th>
															<th style="width:30% !important" class="center">PRECIO PAGADO</th>
															<th class="center">PESO</th>
															<th class="center">MONEDA</th>
															<th class="center">MONTO ENTREGADO</th>
														</tr>
													</thead>
													<tbody>
														<?php
														foreach ($temp as $key => $value){
															echo '<tr>';
																echo '<td style="text-align:center !important">'.$temp[$key]['PIEZA'].'</td>';
																echo '<td style="text-align:center !important">'.$temp[$key]['ARTICULO'].'</td>';
																echo '<td style="text-align:center !important">'.'$ '.number_format($temp[$key]['PRECIO'],2).'</td>';
																echo '<td style="text-align:center !important">'.number_format($temp[$key]['DIMENSION'],2).' '.$temp[$key]['PESO'].'</td>';
																echo '<td style="text-align:center !important">'.$temp[$key]['MONEDA'].'</td>';
																echo '<td style="text-align:center !important">'.number_format($temp[$key]['RESTA'],2).'</td>';
															echo '</tr>';
														}?>
													</tbody>
												</table>
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
			<label>TOTAL DE PIEZAS RETIRADAS: <?php echo $count[0]['COUNT'] . '<br>'; ?></label>
			<label>TOTAL EN GRAMOS RETIRADOS: <?php echo number_format($sum[0]['SUM'],2); ?></label>
		</div>
		
			
		



	
		<script>
		window.print();
		
		</script>
	</body>
</html>
