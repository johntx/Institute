@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive vista_movil">
	<table class="table table-hover">
		<thead>
			<th>Fecha Inicio</th>
			<th>Carrera</th>
			<th>Turno</th>
			<th>Materia</th>
			<th># Ins</th>
			<th>Lista</th>
		</thead>
		@foreach($groups as $group)
		<tbody>
			<td>{{Jenssegers\Date\Date::parse($group->fecha_inicio)->format('j M Y')}}</td>
			<td>{{$group->carrera}}</td>
			<td>{{$group->turno}}</td>
			<td>{{$group->materia}}</td>
			<td>{{sizeof(\Institute\Group::find($group->id)->inscriptions)}}</td>
			<td>
				{!!link_to_action('AssistanceController@register', $title = 'Asistencias', $parameters = $group->id.'/'.$group->materia_id, $attributes = ['class'=>'btn btn-success'])!!}
			</td>
		</tbody>
		@endforeach
	</table>
</div>
<style>
	.vista_movil *{
		font-size: 11px;
	}
	.vista_movil td{
		padding: 4px !important;
	}
	.vista_movil td form{
		margin: 0 !important;
	}
</style>
@endsection