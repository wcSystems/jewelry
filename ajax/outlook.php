<div class="inbox-nav-bar no-content-padding">

	<h1 class="page-title txt-color-blueDark hidden-tablet"><i class="fa fa-fw fa-inbox"></i> Mensajeria &nbsp;
		
	</h1>

	<div class="btn-group hidden-desktop visible-tablet">
		<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			Recibidos <i class="fa fa-caret-down"></i>
		</button>
		<ul class="dropdown-menu pull-left">
			<li class="F">
				<a onclick="loadInbox();$(this).parent().addClass('active');" href="javascript:void(0);">Recibidos</a>
			</li>
			<li>
				<a onclick="loadOutbox();$(this).parent().addClass('active');" href="javascript:void(0);">Enviados</a>
			</li>
			<li>
				<a onclick="loadTrashbox();$(this).parent().addClass('active');" href="javascript:void(0);">Papelera</a>
			</li>
			<li class="divider"></li>
			
		</ul>

	</div>

	<div class="inbox-checkbox-triggered">

		<div class="btn-group">
			<a onclick="elim();" href="javascript:void(0);" rel="tooltip" title="" data-placement="right" data-original-title="Mover a la Papelera" class="deletebutton btn btn-default"><strong><i class="fa fa-trash-o fa-lg"></i></strong></a>
		</div>

	</div>

	<a href="javascript:void(0);" onclick="loadNuevo();" id="compose-mail-mini" class="btn btn-primary pull-right hidden-desktop visible-tablet"> <strong><i class="fa fa-file fa-lg"></i></strong> </a>

</div>

<div id="inbox-content" class="inbox-body no-content-padding">

	<div class="inbox-side-bar">

		<a href="javascript:void(0);" onclick="loadNuevo();" class="btn btn-primary btn-block"> <strong>Redactar</strong> </a>

		<h6> Carpetas <a href="javascript:void(0);" rel="tooltip" title="" data-placement="right" data-original-title="Actualizar" class="pull-right txt-color-darken"><i class="fa fa-refresh"></i></a></h6>

		<ul class="inbox-menu-lg">
			<li class="F">
				<a onclick="loadInbox();$(this).parent().addClass('active');" href="javascript:void(0);">Recibidos</a>
			</li>
			<li>
				<a onclick="loadOutbox();$(this).parent().addClass('active');" href="javascript:void(0);">Enviados</a>
			</li>
			<li>
				<a onclick="loadTrashbox();$(this).parent().addClass('active');" href="javascript:void(0);">Papelera</a>
			</li>
		</ul>

		

	</div>

	<div class="table-wrap custom-scroll animated fast fadeInRight" style="min-height:60vh">
		<!-- ajax will fill this area -->
		Cargando...

	</div>


</div>

<script>
	

	pageSetUp();

	// PAGE RELATED SCRIPTS

	// pagefunction
	
	var pagefunction = function() {

		loadInbox();
		$(".F").addClass("active");
		
		$("#compose-mail").click(function() {
			
		});
		
	};
	
	loadScript("js/plugin/delete-table-row/delete-table-row.min.js", pagefunction);
	function loadTrashbox() {
		$(".inbox-menu-lg li").removeClass("active");
		loadURL("ajax/mensajeria/papelera.php", $('#inbox-content > .table-wrap'));
	}
	function loadInbox() {
		$(".inbox-menu-lg li").removeClass("active");
		loadURL("ajax/mensajeria/recibido.php", $('#inbox-content > .table-wrap'));
	}
	function loadOutbox() {
		$(".inbox-menu-lg li").removeClass("active");
		loadURL("ajax/mensajeria/enviado.php", $('#inbox-content > .table-wrap'));
	}
	
	function loadNuevo(){
		$(".inbox-menu-lg li").removeClass("active");
		loadURL("ajax/mensajeria/nuevo.php", $('#inbox-content > .table-wrap'));
	}
	
	
	
</script>
