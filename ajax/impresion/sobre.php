<?PHP
include "../../php/API/query.php";
$query = new query();
$cliente = (array) $query->select(array("*"),"VCLIENTE","where ID = ".$_GET["CLIENTE"])[0];

?>


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
	<body>
		<div style="width:60%;border:1px solid black;margin:3%;padding:2%">
			<LABEL>CLOCK REPAIR SAN DIEGO S.A.</LABEL><BR>
			<label>CONTRATO Nº <?PHP ECHO $_GET["CONTRATO"] ?></label><BR>
			<BR>
			<LABEL><?PHP echo $cliente["APELLIDO"]." ".$cliente["NOMBRE"] ?></LABEL><br>
			<label><?php echo $cliente["DOCUMENTO"] ?></label><br><br><br>
			<label><?php echo $_GET["DESCRIPCION"]?></label><br>
			<label><?php echo $_GET["ARTICULO"]?></label><br>
			<label><?php echo $_GET["PESO"]." GRAMOS"?></label><br>
			<label><?php echo $_GET["VENCE"]?></label>
			
		</div>
		<br>
		
		
		<script>
		window.print();
		
		</script>
	</body>
</html>
