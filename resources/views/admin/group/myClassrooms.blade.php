@extends('layouts.admin')
@section('content')
<div class="table-responsive vista_movil">
	<table class="table table-hover">
		<thead>
			<th>Hora</th>
			<th style="text-align: center;">Piso - Aula</th>
			<th>Dia</th>
			<th>Materia</th>
			<th>Grupos</th>
			<th>Asistencia</th>
			<th>Notas</th>
		</thead>
		@foreach($hours as $hour)
		<tbody>
			<td>{{$hour->hora_inicio}} - {{$hour->hora_fin}}</td>
			<td style="text-align: center;">{{$hour->piso}} - {{$hour->aula}}</td>
			<td><b>{{$hour->dia}}</b></td>
			<td>{{$hour->subject->nombre}}</td>
			<td>
				@foreach (\Institute\Hour::join('schedules','hours.schedule_id','=','schedules.id')->where('schedules.vigente','si')->where('people_id',$hour->people_id)->where('piso',$hour->piso)->where('aula',$hour->aula)->where('dia',$hour->dia)->get() as $hrs)
					({{Jenssegers\Date\Date::parse($hrs->group->startclass->fecha_inicio)->format('j M Y')}}) - {{$hrs->group->startclass->career->nombre}} <br>
				@endforeach
			</td>
			<td>
				{!!link_to_action('AssistanceController@register', $title = 'Asistencias', $parameters = $hrs->piso.'/'.$hrs->aula.'/'.$hrs->dia, $attributes = ['class'=>'btn btn-success'])!!}
			</td>
			<td>
				{!!link_to_action('ScoreController@register', $title = 'Notas', $parameters = $hrs->piso.'/'.$hrs->aula.'/'.$hrs->dia, $attributes = ['class'=>'btn btn-primary'])!!}
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