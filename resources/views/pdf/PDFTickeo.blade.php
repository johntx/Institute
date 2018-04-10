<!DOCTYPE html>
<html lang="es" ondragstart="return false">
<!-- oncontextmenu="return false"  onselectstart="return false" -->
<head>
	<title>Tickeos</title>
	<meta charset="utf-8">
	<meta name = "format-detection" content = "telephone=no" />
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