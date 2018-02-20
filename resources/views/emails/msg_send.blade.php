<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
</head>
<body>
	<span>Buenos días <strong>Instituto CIEN</strong> <br><br>
	{{ $msg->message }}
	<br>
	<br>
	Atte: {{ $msg->name }} <br>
	Telf: {{ $msg->phone }} <br>
	Email: {{ $msg->email }}
	</span>
</body>
</html>