<?php if($_GET["DIFERENCIA"] != 0 && $_GET["TAZA"] != 0){$monto = $_GET["MONTO"] - $_GET["CAMBIO"];$cambio = " Y BOLIVARES " . $_GET["DIFERENCIA"];}else{$monto = $_GET["MONTO"];$cambio = "";} ?>
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
				<label>REF #<?php echo $_GET["ID"] ?></label>
			</div>
			<div class="col-md-6 right" style="display:inline-block;width:50%;float:right;text-align:right">
				<label class="right" style=""><?php echo date("d/m/Y"); ?></label>
		
			</div>
			<br><br><br><br>
			<div class="col-md-12">  
			<h3 class="center" style="width:100%;text-align:center">Por <?php echo $_GET["MONEDA"]; ?> <strong><?php echo $monto . $cambio; ?></strong></h3>
			</div>
			<div class="col-md-12">
			<p class="center">He recibido de CLOCK SAN DIEGO C.A. La cantidad de <?php echo $_GET["MONEDA"]; ?> <?php  echo $monto; ?> <?php echo $cambio; ?> POR CONCEPTO DE COMPRA DE <?php echo $_GET["ARTICULO"] ?>, <?php echo $_GET["PESO"] ?> Gramos</p>
			<BR>
			<P class="center">Yo declaro que las prendas vendidas en este acto son de mi propiedad y obtuve por medios licitos y libero de toda responsabilidad al comprador
			en todo caso de cualquier accion judicial en su contra</P>
			</div>
			<br><br><br>
			<div class="col-md-12 " style="text-align:center">
				<label>__________________________________</label>
				<br>
				<br>
				
				<label><?php echo $_GET["CLIENTE"] ?><br><?php echo $_GET["DOC"] ?></label>
			</div>
		</div>


		
		<div class="row" style="border:1px solid black;padding:3%">
			<div class="col-md-6" style="display:inline-block;width:50%;float:left">
				<label>CLOCK SAN DIEGO C.A.</label><br>
				<label>RIF J-29846820-3</label>
				<br><br>
				<label>REF #<?php echo $_GET["ID"] ?></label>
			</div>
			<div class="col-md-6 right" style="display:inline-block;width:50%;float:right;text-align:right">
				<label class="right" style=""><?php echo date("d/m/Y"); ?></label>
		
			</div>
			<br><br><br><br>
			<div class="col-md-12">
			<h3 class="center" style="width:100%;text-align:center">Por <?php echo $_GET["MONEDA"]; ?> <strong><?php echo $monto . $cambio; ?></strong></h3>
			</div>
			<div class="col-md-12">
			<p class="center">He recibido de CLOCK SAN DIEGO C.A. La cantidad de <?php echo $_GET["MONEDA"]; ?> <?php  echo $monto; ?> <?php echo $cambio; ?> POR CONCEPTO DE COMPRA DE <?php echo $_GET["ARTICULO"] ?>, <?php echo $_GET["PESO"] ?> Gramos</p>
			<BR>
			<P class="center">Yo declaro que las prendas vendidas en este acto son de mi propiedad y obtuve por medios licitos y libero de toda responsabilidad al comprador
			en todo caso de cualquier accion judicial en su contra</P>
			</div>
			<br><br><br>
			<div class="col-md-12 " style="text-align:center">
				<label>__________________________________</label>
				<br>
				<br>
				
				<label><?php echo $_GET["CLIENTE"] ?><br><?php echo $_GET["DOC"] ?></label>
			</div>
		</div>
		<script>
		window.print();
		
		</script>
	</body>
</html>
