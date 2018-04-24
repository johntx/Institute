@extends('layouts.admin')
@section('content')
@include('alerts.succes')
{!! Form::open(['route' => ['admin.assistance.update',\Carbon\Carbon::now()->format('Y-m-d')],'method'=>'put']) !!}
<div class="table-responsive vista_movil">
	<table class="table table-hover table-condensed">
		<thead>
			<th>No</th>
			<th>(Hoy)<br><p style="margin: 0;font-size: 10px;">{{\Carbon\Carbon::now()->format('d/m/y')}}</p></th>
			<th>Nombre</th>
			<th># Asis.</th>
			<th>Estado</th>
			@foreach ($fechas as $fecha)
			<th style="position: relative; height: 70px;"><p style="transform: rotate(90deg); position: absolute; top: 23px; left: -20px;">{{\Carbon\Carbon::parse($fecha->fecha)->format('d/m/y')}}</p></th>
			@endforeach
		</thead>
		@foreach($inscriptions as $i=>$inscription)
		<tr @if ($inscription->estado == 'Retirado') style="background-color: rgba(255,0,0,0.25);" @endif>
			<td>{{++$i}}</td>
			<td>
				<label class="switch">
					<input type="checkbox" name="asistencia[]" class="" value="{{$inscription->id}}" @if ($inscription->asistencia($group_id,$materia_id,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'))) checked @endif>
					<span class="slider round check_asistencia"></span>
				</label>
			</td>
			<td>{{$inscription->people->nombrecompleto()}}</td>
			<td>{{$inscription->asisCont($group_id,$materia_id,Auth::id())}}</td>
			<td>{{$inscription->estado}}</td>
			@foreach ($fechas as $fecha)
			@if ($inscription->asistencia($group_id,$materia_id,Auth::id(),$fecha->fecha)) 
			<td>✔</td>
			@else
			<td>✗</td>
			@endif
			@endforeach
		</tr>
		@endforeach
	</table>
	<input type="hidden" name="group_id" value="{{$group_id}}" id="">
	<input type="hidden" name="materia_id" value="{{$materia_id}}" id="">
</div>
{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
<style>
	.vista_movil *{
		font-size: 12px;
	}
	.vista_movil td{
		padding: 4px !important;
	}
	.vista_movil td form{
		margin: 0 !important;
	}
	.switch{
		margin: 0;
	}
</style>
@endsection