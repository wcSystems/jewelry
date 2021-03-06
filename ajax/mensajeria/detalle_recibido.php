<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../../php/API/util.php";
include "../../php/API/query.php";
	
$query = new query();
$util = new util();
$m = (array) $query->select(array("ID"),"BUZON","where EMAIL = ".$_GET["EMAIL"]." and DESTINO = ".$_SESSION["SESION"][0]["ID"])[0];
$query->update(array("VISTO"=>"2"),"BUZON",$m["ID"]);
$mensaje = (array) $query->select(array("*"),"VRECIBIDO","where ID = ".$_GET["EMAIL"])[0];


?>
<h2 class="email-open-header">
	<?php echo $mensaje["ASUNTO"]; ?> <span class="label txt-color-white"><?php echo $mensaje["CARPETA"]; ?></span>
	<a href="javascript:void(0);" rel="tooltip" data-placement="left" data-original-title="Imprimir" class="txt-color-darken pull-right"><i class="fa fa-print"></i></a>	
</h2>

<div class="inbox-info-bar">
	<div class="row">
		<div class="col-sm-9">
			<img src="perfil/<?php echo $mensaje["PERFIL"]; ?>" >
			De <strong><?php echo $mensaje["ONOMBRE"]." ".$mensaje["OAPELLIDO"]; ?></strong>
			<span class="hidden-mobile">Para <strong>Mi</strong> el <i><?php echo $util->tonormaldate(date("Y-m-d", strtotime($mensaje["FECHA"]))) ?> a las <?php echo date("H:m", strtotime($mensaje["FECHA"])) ?> </i></span> 
		</div>
		<div class="col-sm-3 text-right">
			
			<div class="btn-group text-left">
				<button onclick="loadRespuesta();" class="btn btn-primary btn-sm replythis">
					<i class="fa fa-reply"></i> Responder
				</button>
				<button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-angle-down"></i>
				</button>
				<ul class="dropdown-menu pull-right">
					<li>
						<a onclick="loadReenvio();" href="javascript:void(0);" class="replythis"><i class="fa fa-mail-forward"></i> Reenviar</a>
					</li>
					<li>
						<a href="javascript:void(0);"><i class="fa fa-print"></i> Imprimir</a>
					</li>
					<li class="divider"></li>
			
					<li>
						<a href="javascript:void(0);"><i class="fa fa-trash-o"></i> Eliminar</a>
					</li>
				</ul>
			</div>

		</div>
	</div>
</div>

<div class="inbox-message">
	<?php echo $mensaje["CUERPO"]; ?>
</div>

<div class="inbox-download">
	<ul class="inbox-download-list">
		<?php
			$adjunto = (array) $query->select(array("*"),"ADJUNTO","where EMAIL = ".$_GET["EMAIL"]);
			
			$cont = 0;
			foreach($adjunto as $indice => $valor){
			$cont++;
				echo "
					<li>
						<div class='well well-sm'>
							<span>
								<i class='fa fa-file'></i>
							</span>
							<br>
							<strong>".$valor["ARCHIVO"]."</strong> 
							<br>
							<a href='adjunto/".$valor["ARCHIVO"]."' download> Descargar</a>
						</div>
					</li>";
			}
			if($cont == 0){echo "<label>Sin archivos Adjuntos</label>";}
		?>
	</ul>
</div>

<script>

	pageSetUp();
	
	$(".table-wrap [rel=tooltip]").tooltip();

	
	
	function loadRespuesta(){
		loadURL("ajax/mensajeria/respuesta.php?EMAIL=<?php echo $_GET['EMAIL']; ?>", $('#inbox-content > .table-wrap'));
	}
	function loadReenvio(){
		loadURL("ajax/mensajeria/reenvio.php?EMAIL=<?php echo $_GET['EMAIL']; ?>", $('#inbox-content > .table-wrap'));
	}
	
</script>
