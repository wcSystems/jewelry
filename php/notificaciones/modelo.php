<?php 


$correo = "
	<li>
		<span >
			<a href=\"index.php#ajax/outlook.php\" class=\"msg\">
				<img src=\"perfil/".$_SESSION["SESION"][0]["PERFIL"]."\" alt=\"\" class=\"air air-top-left margin-top-5\" width=\"40\" height=\"40\" />
				<span style=\"margin-bottom:0\" class=\"from\">".$_SESSION["SESION"][0]["NOMBRE"]." ".$_SESSION["SESION"][0]["APELLIDO"]."<i class=\"icon-paperclip\"></i></span>
				<time>".date("d/m/y H:m")."</time>
				<span style=\"white-space:unset\" class=\"msg-body\">Recibiste un mensaje nuevo en tu buzon: ".$texto." </span>
			</a>
		</span>
	</li>
";

$sticky = "
	<li>
		<span >
			<a href=\"index.php#ajax/inicio.php\" class=\"msg\">
				<img src=\"perfil/".$_SESSION["SESION"][0]["PERFIL"]."\" alt=\"\" class=\"air air-top-left margin-top-5\" width=\"40\" height=\"40\" />
				<span style=\"margin-bottom:0\" class=\"from\">".$_SESSION["SESION"][0]["NOMBRE"]." ".$_SESSION["SESION"][0]["APELLIDO"]."<i class=\"icon-paperclip\"></i></span>
				<time>".date("d/m/y H:m")."</time>
				<span style=\"white-space:unset\" class=\"msg-body\">Ha publicado un nuevo Sticky:<br> ".$texto." </span>
			</a>
		</span>
	</li>
";
$pagina = "
	<li>
		<span >
			<a href=\"index.php#ajax/outlook.php\" class=\"msg\">
				<img src=\"perfil/17nnzv4z4o0getj34134.png\" alt=\"\" class=\"air air-top-left margin-top-5\" width=\"40\" height=\"40\" />
				<span style=\"margin-bottom:0\" class=\"from\">Pagina Web<i class=\"icon-paperclip\"></i></span>
				<time>".date("d/m/y H:m")."</time>
				<span style=\"white-space:unset\" class=\"msg-body\">".$texto." </span>
			</a>
		</span>
	</li>
";





?>
