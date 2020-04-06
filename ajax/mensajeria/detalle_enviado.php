<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-- ---------------------- --//
include "../../php/API/util.php";
include "../../php/API/query.php";
	
$query = new query();
$util = new util();

$mensaje = (array) $query->select(array("*"),"VENVIADO","where ID = ".$_GET["EMAIL"])[0];


?>
<h2 class="email-open-header">
	<?php echo $mensaje["ASUNTO"]; ?> <span class="label txt-color-white">ENVIADOS</span>
	<a href="javascript:void(0);" rel="tooltip" data-placement="left" data-original-title="Imprimir" class="txt-color-darken pull-right"><i class="fa fa-print"></i></a>	
</h2>

<div class="inbox-info-bar">
	<div class="row">
		<div class="col-sm-9">
			<img src="perfil/<?php echo $mensaje["PERFIL"]; ?>" >
			De <strong>Mi</strong>
			<span class="hidden-mobile">Para <strong><?php echo $mensaje["DNOMBRE"] ?></strong> el <i><?php echo $util->tonormaldate(date("Y-m-d", strtotime($mensaje["FECHA"]))) ?> a las <?php echo date("H:m", strtotime($mensaje["FECHA"])) ?> </i></span> 
		</div>
		<div class="col-sm-3 text-right">
			
			<div class="btn-group text-left">
				<button class="btn btn-primary btn-sm replythis">
					<i class="fa fa-reply"></i> Reenviar
				</button>
				<button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-angle-down"></i>
				</button>
				<ul class="dropdown-menu pull-right">
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

	$(".replythis").click(function(){
		loadURL("ajax/email-reply.html", $('#inbox-content > .table-wrap'));
	})
	
</script>
