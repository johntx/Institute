<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
</head>
<body>
	<h2>Hola {{ $user->firstname }}, has solicitado un cambio de contraseña?</h2>
	<p>Si no lo hiciste solo debes ignorar este mensaje.</p>
	<p>Si es así por favor sigue el link para cambiar tu contraseña.</p>
	<p>Para ello simplemente debes hacer click en el siguiente enlace:</p>

	<a href={{ url('/password/reset/'.$token) }}>
		Clic aqui para cambiar tu contraseña.
	</a>
</body>
</html>