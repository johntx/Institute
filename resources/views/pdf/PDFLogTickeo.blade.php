<!DOCTYPE html>
<html lang="es" ondragstart="return false">
<!-- oncontextmenu="return false"  onselectstart="return false" -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tickeos</title>
	<link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />
	{!! Html::style('css/pdf_tickeo.css') !!}
</head>
<body>
	<b>{{$tickeos->first()->biometric->nombre}}</b>
	<table>
		<tr>
			<th>Nombre</th>
			<th>Fecha</th>
			<th>tipo</th>
			<th>Día</th>
		</tr>
		@foreach($tickeos as $tickeo)
		<tr>
			<td>{{$tickeo->biometric->nombre}}</td>
			<td>{{$tickeo->fecha}}</td>
			<td>@if ($tickeo->tipo == 0) entrada @else salida @endif</td>
			<td>{{$tickeo->dia}}</td>
		</tr>
		@endforeach
	</table>
</body>
</html>