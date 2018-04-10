@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover table-condensed">
	<thead>
		<!--th>Id</th-->
		<th>Nombre</th>
		<th>Fecha</th>
		<th>tipo</th>
		<th>Detalles</th>
		<th>Edit</th>
	</thead>
	@foreach($tickeos as $tickeo)
	<tbody>
		<!--td>{{$tickeo->id}}</td-->
		<td>{{$tickeo->biometric->nombre}}</td>
		<td>{{$tickeo->fecha}}</td>
		<td>@if ($tickeo->tipo == 0) entrada @else salida @endif</td>
		<td>{{$tickeo->detalle}}</td>
	</tbody>
	@endforeach
</table>
</div>
{!!$tickeos->render()!!}
@endsection