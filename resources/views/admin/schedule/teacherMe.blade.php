@extends('layouts.admin')
@section('content')
@include('alerts.request')
<div class="panel-body">
	<br>
	<h4>Docente: {{$user->people->nombrecompleto()}}</h4>
	<table class="sch">
		<tbody>
			<tr>
				<th colspan="7">HORARIO</th>
			</tr>
			<tr>
				@foreach ($semana as $dia)
				<th dia="dia">{{strtoupper($dia)}}</th>
				@endforeach
			</tr>
			@foreach ($horario as $key=>$hora)
			<tr h="{{$key+1}}" @if ($key%2!=0 && $key<11) hmas="hmas" @elseif ($key%2==0 && $key>13 && $key<23) hmas="hmas" @endif @if ($key>8 && $key<14 || $key>21)  mid="mid" @endif>
				@foreach ($semana as $x=>$dia)
				@if ($dia == 'hora')
				<td x="{{$x}}"><div>{{$hora}}</div></td>
				@else
				<?php
				$hour = $user->people->hours()->join('schedules','hours.schedule_id','=','schedules.id')->join('subjects','hours.subject_id','=','subjects.id')->join('groups','hours.group_id','=','groups.id')->join('peoples','hours.people_id','=','peoples.id')->join('startclasses','groups.startclass_id','=','startclasses.id')->join('careers','startclasses.career_id','=','careers.id')->select('hours.*','subjects.nombre as asignatura','careers.nombre as carrera','startclasses.fecha_inicio as fecha','peoples.nombre as profesor')->where('schedules.vigente','si')->where('hours.dia',$dia)->where('hours.hora_inicio',$hora)->first();
				?>
				<td x="{{$x}}">
					<div class="sch_hour" hora='{{$hour['id']}}' size="{{$hour['periodos']}}" carrera="<b>{{$hour['asignatura']}}</b>" fecha="" asignatura="{{$hour['carrera']}}" aula="{{$hour['piso']}} {{$hour['aula']}}">{{$hour['asignatura']}}</div>
				</td>
				@endif
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
@section('adminjs')
{!!Html::script('js/horario.js')!!}
@endsection