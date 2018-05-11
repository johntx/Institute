@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="panel panel-primary">
	<div class="panel-heading">Grupo: {{$group->startclass->career->nombre}} ({{$group->startclass->estado}}) [{{Jenssegers\Date\Date::parse($group->startclass->fecha_inicio)->format('j M Y')}}] Turno:{{$group->turno}}</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-hover table-condensed">
				<thead>
					<th>No</th>
					<th>Nombre</th>
					<th># Asis.</th>
					<th>Estado</th>
					@foreach ($asistencias as $asistencia)
					<th style="position:relative;height:110px;width:50px;">
						<div style="transform:rotate(90deg);position:absolute;top:20px;right:-20px;">{{\Carbon\Carbon::parse($asistencia->fecha)->format('d/m/y')}}
						</div>
						<div style="font-size:10px;transform:rotate(90deg);position:absolute;top:34px;right:-18px;margin:0;width: 100px;height:32px;">{{$asistencia->subject->nombre}}</div><p style="margin: 0;font-size: 12px;">{{strtoupper(\Jenssegers\Date\Date::parse($asistencia->fecha)->format('l')[0])}}{{\Jenssegers\Date\Date::parse($asistencia->fecha)->format('l')[1]}}</p>
					</th>
					@endforeach
				</thead>
				@foreach($inscriptions as $i=>$inscription)
				<tr @if ($inscription->estado == 'Retirado') style="background-color: rgba(255,0,0,0.25);" @endif>
					<td>{{++$i}}</td>
					<td>{{$inscription->people->nombrecompleto()}}</td>
					<td>{{$inscription->asisCont($group->id)}}</td>
					<td>{{$inscription->estado}}</td>
					@foreach ($asistencias as $asistencia)
					@if ($inscription->asistencia($group->id,$asistencia->subject_id,$asistencia->people_id,$asistencia->fecha)) 
					<td style="text-align: right;">✔</td>
					@else
					<td style="text-align: right;">✗</td>
					@endif
					@endforeach
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>
@endsection