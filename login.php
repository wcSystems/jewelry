<!DOCTYPE html>
<html lang="en-us" id="extr-page">
	<head>
		<meta charset="utf-8">
		<title>S.M.A.R.T</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-skins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-rtl.min.css"> 
		<link rel="stylesheet" type="text/css" media="screen" href="css/demo.min.css">
		<link rel="shortcut icon" href="img/iso.png" type="image/x-icon">
		<link rel="icon" href="img/iso.png" type="image/x-icon">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
	</head>
	<body class="animated fadeInDown">
		<header id="header">
			<div id="logo-group">
				<span id="logo"> <img style="width:80%;margin-left:24%; margin-top:-9%;" src="img/logo.png" alt="Rionet" style="width:100%"> </span>
			</div>
		</header>
		<div id="main" role="main">
			<div id="content" class="container">
				<div class="col-xs-12 col-sm-12 col-md-3 col-md-offset-3 col-lg-4 col-lg-offset-4">
					<div class="well no-padding">
						<form id="login-form" class="smart-form client-form">
							<header>Iniciar Sesion</header>
								<fieldset>
									<section>
										<label class="label">Usuario</label>
										<label class="input"> <i class="icon-append fa fa-user"></i>
											<input id="USER" type="TEXT" name="email">
											<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Ingrese su nombre de usuario</b>
										</label>
									</section>
									<section>
										<label class="label">Password</label>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input id="PASS" type="password" name="password">
											<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Ingrese su contraseña</b> 
										</label>
									</section>
								</fieldset>
								<footer>
									<button type="submit" class="btn btn-primary">Ingresar</button>
								</footer>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
		
		</script>
		<script src="js/plugin/pace/pace.min.js"></script>
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script> if (!window.jQuery) { document.write('<script src="js/libs/jquery-3.2.1.min.js"><\/script>');} </script>
	    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script> if (!window.jQuery.ui) { document.write('<script src="js/libs/jquery-ui.min.js"><\/script>');} </script>
		<script src="js/app.config.js"></script>
		<script src="js/bootstrap/bootstrap.min.js"></script>
		<script src="js/plugin/jquery-validate/jquery.validate.min.js"></script>
		<script src="js/plugin/masked-input/jquery.maskedinput.min.js"></script>
		<script src="js/app.min.js"></script>
		<script>
			runAllForms();
			$('#login-form').submit(function(e){
				e.preventDefault();
				$.ajax({
					url:'php/usuario/login.php',
					type:'post',
					data:{USER:$("#USER").val(),PASS:$("#PASS").val()},
					success:function(resp){
						if(resp == "ok"){
							location.href = "index.php#ajax/inicio.php";
						}
					}
				});
			});
			$(function() {
				$("#login-form").validate({
					rules : {
						email : {
							required : true,
						},
						password : {
							required : true,
							minlength : 3,
							maxlength : 20
						}
					},
					messages : {
						email : {
							required : 'Este campo es obligatorio'
						},
						password : {
							required : 'No ingreso su contraseña'
						}
					},
					errorPlacement : function(error, element) {
						error.insertAfter(element.parent());
					}
				});
			});
		</script>
	</body>
</html>
