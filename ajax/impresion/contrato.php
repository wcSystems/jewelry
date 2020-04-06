<?PHP
error_reporting(E_ALL);
ini_set('display_errors', '1');
include "../../php/API/query.php";
$query = new query();
$cliente = (array) $query->select(array("*"),"VCLIENTE","where ID = ".$_GET["CLIENTE"])[0];
$contrato = (array) $query->select(array("*"),"VCONTRATO","where CONTRATO = ".$_GET["CONTRATO"])[0];
$detalle = (array) $query->select(array("*"),"CONTRATO_PIEZA","where CONTRATO = ".$_GET["CONTRATO"])[0];
$pieza = (array) $query->select(array("*"),"PIEZA","where ID = ".$detalle["PIEZA"])[0];

$T = (array) $query->select(array("SUM(MONTO) as MONTO"),"PAGO","where CONCEPTO = 1 and CONTRATO = ".$_GET["CONTRATO"])[0];
if(!isset($T["MONTO"])){
    $T = 0;
}else{
    $T = $T["MONTO"];
}

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
				<label>CONTRATO Nº <?php echo $_GET["CONTRATO"]; ?></label>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6" style="text-align:right">
                <label> INICIO: <?php echo $_GET["INICIO"]; ?></label><br>
				<label > VENCE: <?php echo $_GET["VENCE"]; ?></label>
			</div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <p style="text-align:justify">
                    Yo, <?php echo $cliente["APELLIDO"]." ".$cliente["NOMBRE"]; ?>, cedula de identidad <?php echo $cliente["DOCUMENTO"]; ?>, de nacionalidad <?php echo $cliente["NACIONALIDAD"] ?>, mayor de edad, de estado civil <?php echo $cliente["CIVIL"] ?>, 
                    de profesion <?php echo $cliente["PROFESION"]; ?>, telefono <?php echo $cliente["TELEFONO"]; ?>, con domicilio en <?php echo $cliente["DIRECCION"] ?> y en el ejercicio pleno de mis derechos declaro que doy en venta: <strong><?php echo $_GET["DESCRIPCION"]." ".$_GET["ARTICULO"]." ".$_GET["PESO"]." ".$contrato["MEDIDA"]; ?></strong> , 
                    con derecho a
                    retracto como lo establece el Artículo 1533 del Código Civil de la República Bolivariana de Venezuela y en
                    conformidad con el Artículo 164 del mismo Código Civil a la firma comercial CLOCK REPAIR SAN DIEGO C.A.,
                    registrada ante la oficina de Registro Mercantil Segundo, Circunscripción Judicial del Estado Carabobo, Bajo el
                    número 70, Tomo 6a, fecha 07 de febrero del año 2001. Declaro que es de mi exclusiva propiedad y que obtuve
                    por compra legal. El precio de esta venta es por la cantidad de <strong><?php echo $f->format(number_format(round(($detalle["PRECIO"] * $pieza["DIMENSION"]) - $T,2),2))." ".$_GET["MONEDA"]; ?></strong> ($ <strong><?php echo number_format(round(($detalle["PRECIO"] * $pieza["DIMENSION"]) - $T,2),2); ?></strong>),
                            
                    los cuales declaro recibir de mano de ​ Clock Repair San Diego C.A. ​ , mediante instrumento
                    bancario y/o en efectivo al momento de la protocolización del documento a mi entera y cabal satisfacción,
                    quedando esta fecha para el inicio del presente contrato. La expresada suma de dinero, devengará el interés
                    mensual de ( <?php echo $contrato["PORCENTAJE"]; ?> % ) equivalente a: <?php echo number_format(round(((($detalle["PRECIO"] * $pieza["DIMENSION"])- $T) * $detalle["PORCENTAJE"]) / 100,2),2)." ".$_GET["MONEDA"]; ?> que pagaré a la firma o a su orden, durante el tiempo
                    acordado de: <?php echo $contrato["DURACION"]; ?> dias continuos. Son Cláusulas especiales para el(la) deudor(a): ​ <strong>PRIMERA​</strong> : Si el deudor
                    quiere hacer el finiquito del contrato antes de los <?php echo $contrato["DURACION"]; ?> días debe cancelar el mes completo de interés en curso
                    junto con el capital adeudado siendo este de: <strong><?php echo $f->format(number_format(round(((($detalle["PRECIO"] * $pieza["DIMENSION"])-$T) + ((($detalle["PRECIO"] * $pieza["DIMENSION"])-$T) * $detalle["PORCENTAJE"]) / 100),2),2))." ".$_GET["MONEDA"]; ?></strong> ($ <strong><?php echo number_format(round(((($detalle["PRECIO"] * $pieza["DIMENSION"])-$T) + ((($detalle["PRECIO"] * $pieza["DIMENSION"])-$T) * $detalle["PORCENTAJE"]) / 100),2),2); ?></strong>),
                    <strong>SEGUNDA</strong>: ​ En
                    cualquier tiempo después de transcurrir 30 días podrá cancelar totalmente la suma adeudada antes del plazo
                    estipulado, si llegase a existir un acuerdo mayor a 30 dias, cumpliendo con los intereses generados hasta el
                    momento de la cancelación ​ <strong>TERCERA</strong>: El deudor podrá renovar el contrato de forma ilimitada siempre que
                    cumpla con los compromisos adquiridos en el presente contrato ​ <strong>CUARTA</strong>: El deudor podrá abonar a capital
                    siempre y cuando esté al día con los intereses ​ <strong>QUINTA</strong>: La falta oportuna de pago de los intereses mensuales le
                    hará perder el beneficio del Retracto ​ <strong>SEXTA</strong>: El no ejercer el derecho de retracto en el tiempo estipulado, la
                    firma compradora puede adquirir irrevocablemente la propiedad de lo vendido (según Artículo 1536 del código
                    civil). ​ <strong>SEPTIMA</strong>: El(la) deudor(a) declara conocer y aceptar las condiciones, términos y coberturas de los riesgos
                    que asume en la presente negociación ​ <strong>OCTAVA</strong>: Correrán por cuenta del deudor todos los gastos que la
                    presente negociación ocasione, hasta su definitiva terminación. Para todos los efectos derivados y en
                    consecuencias de esta negociación queda elegida la Ciudad de Valencia del Estado Carabobo, como domicilio
                    especial y a la jurisdicción de cuyos Tribunales las partes declaran expresamente someterse sin perjuicio de
                    elegir otros de conformidad con la ley.
                    <br><br>
                    Firman conforme,
                </p>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <label>CLOCK REPAIR SAN DIEGO C.A.</label><br>
                <label>RIF J-29846820-3</label>
            </div>
        </div>
        <br><br><br>
        <div class="row">
            <div class="col">
                <label>Cliente: <?php echo $cliente["APELLIDO"]." ".$cliente["NOMBRE"]; ?></label><br>
                <label>C.I. V-<?php echo $cliente["DOCUMENTO"]; ?></label>
            </div>
        </div>
		<script>
		window.print();
		</script>
	</body>
</html>
