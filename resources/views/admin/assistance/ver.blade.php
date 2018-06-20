@extends('layouts.admin')
@section('content')
<div class="panel panel-primary">
	<div class="panel-heading">Grupo: {{$group->startclass->career->nombre}} ({{$group->startclass->estado}}) [{{Jenssegers\Date\Date::parse($group->startclass->fecha_inicio)->format('j M Y')}}] Turno:{{$group->turno}}</div>
	<div class="panel-body">
		<div class="table-responsive vista_reducida">
			<table class="table table-hover table-condensed">
				<thead>
					<th>No</th>
					<th>Nombre</th>
					<th># Asis.</th>
					<th>Estado</th>
					@foreach ($asistencias as $k=>$asistencia)
					<th class="contenedor_fechas">
						<div class="fecha_vertical">{{\Carbon\Carbon::parse($asistencia->fecha)->format('d/m/y')}}
						</div>
						<div class="asignatura_vertical">{{$asistencia->subject->nombre}}</div>
						<p class="dia_inicial">{{strtoupper(\Jenssegers\Date\Date::parse($asistencia->fecha)->format('l')[0])}}{{\Jenssegers\Date\Date::parse($asistencia->fecha)->format('l')[1]}}</p>
					</th>
					<?php $cont[$k]=0; ?>
					@endforeach
				</thead>
				@foreach($inscriptions as $i=>$inscription)
				<tr @if ($inscription->estado == 'Retirado') style="background-color: rgba(255,0,0,0.25);" @endif>
					<td>{{++$i}}</td>
					<td><b><a href="{{url('admin/student/search/'.$inscription->people->id)}}" style="color: #0800AB">{{$inscription->people->nombrecompleto()}}</a></b></td>
					<td>{{$inscription->asisCont()}}</td>
					<td>{{$inscription->estado}}</td>
					@foreach ($asistencias as $k=>$asistencia)
					@if ($inscription->asistencia($asistencia->subject_id,$asistencia->people_id,$asistencia->fecha)) 
					<td class="al_r">✔</td>
					<?php $cont[$k] = $cont[$k]+1; ?>
					@else
					<td class="al_r">✗</td>
					@endif
					@endforeach
				</tr>
				@endforeach
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td><b>Conteo:</b></td>
					@foreach ($asistencias as $k=>$asistencia)
					<td class="al_r">{{$cont[$k]}}</td>
					@endforeach
				</tr>
			</table>
		</div>
	</div>
</div>
<style>
	.vista_reducida *{
		font-size: 14px;
	}
	.vista_reducida td{
		padding: 4px !important;
	}
	.vista_reducida td form{
		margin: 0 !important;
	}
	.al_r{
		text-align: right;
	}
	.contenedor_fechas{position:relative;height:110px;width:50px;}
	.fecha_vertical{transform:rotate(90deg);position:absolute;top:20px;right:-20px;}
	.asignatura_vertical{font-size:10px;transform:rotate(90deg);position:absolute;top:34px;right:-18px;margin:0;width: 100px;height:32px;}
	.dia_inicial{margin: 0;font-size: 12px;}
</style>
@endsection