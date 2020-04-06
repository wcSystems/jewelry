<?PHP
error_reporting(E_ALL);
ini_set('display_errors', '1');
include "../../php/API/query.php";
$query = new query();

$pago = (array) $query->select(array("*"),"VPAGO","where ID = ".$_GET["PAGO"])[0];
$origin = (array) $query->select(array("*"),"PAGO","where ID = ".$_GET["PAGO"])[0];
$contrato = (array) $query->select(array("*"),"VCONTRATO","where CONTRATO = ".$pago["CONTRATO"])[0];
$cliente = (array) $query->select(array("*"),"VCLIENTE","where ID = ".$pago["CLIENTE"])[0];
$moneda = [];
$temp = (array) $query->select(array("*"),"MONEDA");
foreach($temp as $indice => $valor){
    $moneda[$valor["ID"]] = $valor["DESCRIPCION"];
}
$fecha = explode("-",$pago["FECHA"]);
$concepto = ($pago == 1)? "ABONO A CAPITAL":"PAGO DE INTERESES";

$f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
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
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6" style="text-align:left">
                <label style="font-weight:bold">CLOCK REPAIR SAN DIEGO C.A.</label><br>
				<label>RIF J-29846820-3</label><br>
				<label>CONTRATO Nº <?php echo $pago["CONTRATO"]; ?></label>
			</div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <p style="text-align:justify">
                Clock Repair San Diego C.A. cumple con informarle que hemos recibido la cantidad de
                <?php echo $f->format($pago["MONTO"])." ".$moneda[$pago["MONEDA"]]; ?> ($<?php echo $pago["MONTO"] ?>), equivalentes a <?php echo $origin["DIAS_PAGO"] ?> días, por concepto de ​<?php echo $concepto ?>​ , a nombre de:
                <?php echo $contrato["CLIENTE"]; ?>, titular de la cédula de identidad No. V-<?php echo $cliente["DOCUMENTO"]; ?>.

                Recibo que se emite el día <?php echo $fecha[2] ?> del mes <?php echo $fecha[1] ?> del año <?php echo $fecha[0] ?>.
                Firman conforme,
               </p>
                
            </div>
            <div class="col-md-6">
                <p>
                Clock Repair San Diego C.A.<br>
                Rif. J-29846820-3
                </p>
            </div>
            <div class="col-md-6">
                <p>
                Cliente <?php echo $contrato["CLIENTE"]; ?><br>
                C.I. V-<?php echo $cliente["DOCUMENTO"]; ?>
                <br><br><br><br>
                ---------------------------------------------------------------------------------------------------------------------
                <br><br><br><br>
                </p>
            </div>
        </div>
        <div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6" style="text-align:left">
                <label style="font-weight:bold">CLOCK REPAIR SAN DIEGO C.A.</label><br>
				<label>RIF J-29846820-3</label><br>
				<label>CONTRATO Nº <?php echo $pago["CONTRATO"]; ?></label>
			</div>
        </div>
        <div class="row ">
            <div class="col">
                <p style="text-align:justify">
                Clock Repair San Diego C.A. cumple con informarle que hemos recibido la cantidad de
                <?php echo $f->format($pago["MONTO"])." ".$moneda[$pago["MONEDA"]]; ?> ($<?php echo $pago["MONTO"] ?>), equivalentes a <?php echo $origin["DIAS_PAGO"] ?> días, por concepto de ​<?php echo $concepto ?>​ , a nombre de:
                <?php echo $contrato["CLIENTE"]; ?>, titular de la cédula de identidad No. V-<?php echo $cliente["DOCUMENTO"]; ?>.

                Recibo que se emite el día <?php echo $fecha[2] ?> del mes <?php echo $fecha[1] ?> del año <?php echo $fecha[0] ?>.
                Firman conforme,
               </p>
                
            </div>
            <div class="col-md-6">
                <p>
                Clock Repair San Diego C.A.<br>
                Rif. J-29846820-3
                </p>
            </div>
            <div class="col-md-6">
                <p>
                Cliente <?php echo $contrato["CLIENTE"]; ?><br>
                C.I. V-<?php echo $cliente["DOCUMENTO"]; ?>
       
                </p>
            </div>
        </div>
       
		<script>
		window.print();
		</script>
	</body>
</html>