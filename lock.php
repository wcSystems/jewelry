<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en-us" id="lock-page">
	<head>
		<meta charset="utf-8">
		<title> S.M.A.R.T</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-skins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-rtl.min.css"> 
		<link rel="stylesheet" type="text/css" media="screen" href="css/lockscreen.min.css">
		<link rel="shortcut icon" href="img/iso.png" type="image/x-icon">
		<link rel="icon" href="img/iso.png" type="image/x-icon">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
	</head>
	<body>
		<div id="main" role="main">
			<form class="lockscreen animated flipInY" id="login-form" action="php/usuario/unlock.php" >
				<div class="logo">
					<h1 class="semi-bold"><img style="width:19%" src="img/logo.png" alt="" /> </h1>
				</div>
				<div>
					<img src="perfil/<?php echo $_SESSION["SESION"][0]["PERFIL"]; ?>" alt="" width="120" height="120" />
					<div>
						<h1><i class="fa fa-user fa-3x text-muted air air-top-right hidden-mobile"></i><?php echo $_SESSION["SESION"][0]["NOMBRE"]." ".$_SESSION["SESION"][0]["APELLIDO"] ?> <small><i class="fa fa-lock text-muted"></i> &nbsp;Bloqueado</small></h1>
						<p class="text-muted">
							<a href="mailto:<?php echo $_SESSION["SESION"][0]["EMAIL"] ?>"><?php echo $_SESSION["SESION"][0]["EMAIL"] ?></a>
						</p>
						<div class="input-group">
							<input id="pass" class="form-control" name="PASS" type="password" placeholder="Contraseña">
							<div class="input-group-btn">
								<button class="btn btn-primary" type="submit">
									<i class="fa fa-key"></i>
								</button>
							</div>
						</div>
						<p class="no-margin margin-top-5">
							No eres vos? <a href="php/logout.php"> ¡Presiona aqui!</a>
						</p>
					</div>
				</div>
				<p class="font-xs margin-top-5">
					NovoPles (S.M.A.R.T) 2019
				</p>
			</form>
		</div>


		<script>
		
		runAllForms();
		
		</script>
		<!--================================================== -->	
		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script src="js/plugin/pace/pace.min.js"></script>
	    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script> if (!window.jQuery) { document.write('<script src="js/libs/jquery-3.2.1.min.js"><\/script>');} </script>
	    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script> if (!window.jQuery.ui) { document.write('<script src="js/libs/jquery-ui.min.js"><\/script>');} </script>
		<!-- IMPORTANT: APP CONFIG -->
		<script src="js/app.config.js"></script>
		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events 		
		<script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->
		<!-- BOOTSTRAP JS -->		
		<script src="js/bootstrap/bootstrap.min.js"></script>
		<!-- JQUERY VALIDATE -->
		<script src="js/plugin/jquery-validate/jquery.validate.min.js"></script>
		<!-- JQUERY MASKED INPUT -->
		<script src="js/plugin/masked-input/jquery.maskedinput.min.js"></script>
		<!-- MAIN APP JS FILE -->
		<script src="js/app.min.js"></script>
		<script src="js/utilidades.js"></script>
	</body>

</html>
