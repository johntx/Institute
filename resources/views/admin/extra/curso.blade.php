@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<h4>Curso Extra: {{$curso->nombre}}</h4>
<div class="table-responsive">
	<table class="table table-hover tablaSearch compact">
		<thead>
			<th></th>
			<th>Nombre</th>
			<th>Carrera</th>
			<th>Grupo</th>
			<th>Fecha Ingreso</th>
			<th>Telefono</th>
		</thead>
		<tbody>
			<?php $key=1; ?>
			@foreach($inscriptions as $inscription)
			@if ($inscription->debit())
			@elseif ($inscription->debitNext())
			@else
			<tr style="background-color: rgba(0,255,0,0.25);" >
				<td>{{$key}}</td>
				<td>{{$inscription->people->nombrecompleto()}}</td>
				<td>{{$inscription->group->startclass->career->nombre}}</td>
				<td>{{$inscription->group->turno}}</td>
				<td>{{ Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->format('j M Y')}}</td>
				<td><a href="https://api.whatsapp.com/send?phone=591{{$inscription->people->telefono}}" target="_blank">{{$inscription->people->telefono}}</a></td>
			</tr>
			<?php $key++; ?>
			@endif
			@endforeach
			@foreach($inscriptions as $inscription)
			@if ($inscription->debitNext())
			<tr style="background-color: rgba(255,255,0,0.25);">
				<td>{{$key}}</td>
				<td>{{$inscription->people->nombrecompleto()}}</td>
				<td>{{$inscription->group->startclass->career->nombre}}</td>
				<td>{{$inscription->group->turno}}</td>
				<td>{{ Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->format('j M Y')}}</td>
				<td><a href="https://api.whatsapp.com/send?phone=591{{$inscription->people->telefono}}" target="_blank">{{$inscription->people->telefono}}</a></td>
			</tr>
			<?php $key++; ?>
			@endif
			@endforeach
			@foreach($inscriptions as $inscription)
			@if ($inscription->debit())
			<tr style="background-color: rgba(255,0,0,0.25);">
				<td>{{$key}}</td>
				<td>{{$inscription->people->nombrecompleto()}}</td>
				<td>{{$inscription->group->startclass->career->nombre}}</td>
				<td>{{$inscription->group->turno}}</td>
				<td>{{ Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->format('j M Y')}}</td>
				<td><a href="https://api.whatsapp.com/send?phone=591{{$inscription->people->telefono}}" target="_blank">{{$inscription->people->telefono}}</a></td>
			</tr>
			<?php $key++; ?>
			@endif
			@endforeach
		</tbody>
	</table>
</div>
@endsection