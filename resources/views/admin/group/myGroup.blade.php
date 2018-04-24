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
				{!!Form::open(['url'=>'assistance/register'])!!}
				<input type="hidden" name="group_id" value="{{$group->id}}" id="">
				<input type="hidden" name="materia_id" value="{{$group->materia_id}}" id="">
				{!! Form::submit('Asistencias',['class'=>'btn btn-xs btn-success']) !!}
				{!! Form::close() !!}
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