@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover">
		<tr>
			<th>Nombre</th>
			<th>Fecha y Hora</th>
			<th>tipo</th>
			<th>Día</th>
		</tr>
		@foreach($tickeos as $tickeo)
		<tr>
			<td>{{$tickeo->biometric->nombre}}</td>
			<td>{{Jenssegers\Date\Date::parse($tickeo->fecha)->format('j M Y - H:i:s')}}</td>
			<td>@if ($tickeo->tipo == 0) entrada @else salida @endif</td>
			<td>{{$tickeo->dia}}</td>
		</tr>
		@endforeach
	</table>
</div>
@endsection