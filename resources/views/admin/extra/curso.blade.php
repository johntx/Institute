@extends('layouts.admin')
@section('content')
<h4>Curso Extra: {{$curso->nombre}}</h4>
{!!link_to_asset('filtro/curso/extra', $title = 'Filtro',  $attributes = ['class'=>'btn btn-success'])!!}
<div class="table-responsive">
	<table class="table table-hover tablaSearch compact">
		<thead>
			<th></th>
			<th>Nombre</th>
			<th>Carrera</th>
			<th>Grupo</th>
			<th>Fecha Ingreso</th>
			<th>Socabon</th>
			<th>Sacaba</th>
		</thead>
		<tbody>
			<?php $key=1; ?>
			@foreach($inscriptions as $inscription)
			@if ($inscription->debit())
			@elseif ($inscription->debitNext())
			@else
			<tr style="background-color: rgba(0,255,0,0.25);" >
				<td>{{$key}}</td>
				<td><a target="_blank" href="{{url('admin/student/search/'.$inscription->people->id)}}" style="color: #0800AB">{{$inscription->people->nombrecompleto()}}</a></td>
				<td>{{$inscription->group->startclass->career->nombre}}</td>
				<td>{{$inscription->group->turno}}</td>
				<td>{{ Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->format('j M Y')}}</td>
				<td style="text-align: center; background-color: rgba(0,0,255,0.35);">
					{!! Form::open(['url'=>'assistance/assistance_ajax']) !!}
					<input class="check_piscina check_asistencia" insc="{{$inscription->id}}" type="checkbox" value="{{$inscription->id}}" name="socabon[]" @if ($inscription->asistencia_personalizada(7,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'),3)) checked @endif>
					<input type="hidden" name="group_id" value="{{$inscription->group_id}}">
					<input type="hidden" name="materia_id" value="7">
					<input type="hidden" name="inscription_id" value="{{$inscription->id}}">
					<input type="hidden" name="asistio" @if ($inscription->asistencia_personalizada(7,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'),3)) value="si" @else value="no" @endif >
					{!! Form::close() !!}
				</td>
				<td style="text-align: center; background-color: rgba(255,0,0,0.45);">
					{!! Form::open(['url'=>'assistance/assistance_ajax']) !!}
					<input class="check_piscina check_asistencia" insc="{{$inscription->id}}" type="checkbox" value="{{$inscription->id}}" name="sacaba[]" @if ($inscription->asistencia_personalizada(7,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'),2)) checked @endif>
					<input type="hidden" name="group_id" value="{{$inscription->group_id}}">
					<input type="hidden" name="materia_id" value="7">
					<input type="hidden" name="inscription_id" value="{{$inscription->id}}">
					<input type="hidden" name="asistio" @if ($inscription->asistencia_personalizada(7,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'),2)) value="si" @else value="no" @endif >
					{!! Form::close() !!}
				</td>
			</tr>
			<?php $key++; ?>
			@endif
			@endforeach
			@foreach($inscriptions as $inscription)
			@if ($inscription->debitNext())
			<tr style="background-color: rgba(255,255,0,0.25);">
				<td>{{$key}}</td>
				<td><a target="_blank" href="{{url('admin/student/search/'.$inscription->people->id)}}" style="color: #0800AB">{{$inscription->people->nombrecompleto()}}</a></td>
				<td>{{$inscription->group->startclass->career->nombre}}</td>
				<td>{{$inscription->group->turno}}</td>
				<td>{{ Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->format('j M Y')}}</td>
				<td style="text-align: center; background-color: rgba(0,0,255,0.35);">
					{!! Form::open(['url'=>'assistance/assistance_ajax']) !!}
					<input class="check_piscina check_asistencia" insc="{{$inscription->id}}" type="checkbox" value="{{$inscription->id}}" name="socabon[]" @if ($inscription->asistencia_personalizada(7,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'),3)) checked @endif>
					<input type="hidden" name="group_id" value="{{$inscription->group_id}}">
					<input type="hidden" name="materia_id" value="7">
					<input type="hidden" name="inscription_id" value="{{$inscription->id}}">
					<input type="hidden" name="asistio" @if ($inscription->asistencia_personalizada(7,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'),3)) value="si" @else value="no" @endif >
					{!! Form::close() !!}
				</td>
				<td style="text-align: center; background-color: rgba(255,0,0,0.45);">
					{!! Form::open(['url'=>'assistance/assistance_ajax']) !!}
					<input class="check_piscina check_asistencia" insc="{{$inscription->id}}" type="checkbox" value="{{$inscription->id}}" name="sacaba[]" @if ($inscription->asistencia_personalizada(7,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'),2)) checked @endif>
					<input type="hidden" name="group_id" value="{{$inscription->group_id}}">
					<input type="hidden" name="materia_id" value="7">
					<input type="hidden" name="inscription_id" value="{{$inscription->id}}">
					<input type="hidden" name="asistio" @if ($inscription->asistencia_personalizada(7,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'),2)) value="si" @else value="no" @endif >
					{!! Form::close() !!}
				</td>
			</tr>
			<?php $key++; ?>
			@endif
			@endforeach
			@foreach($inscriptions as $inscription)
			@if ($inscription->debit())
			<tr style="background-color: rgba(255,0,0,0.25);">
				<td>{{$key}}</td>
				<td><a target="_blank" href="{{url('admin/student/search/'.$inscription->people->id)}}" style="color: #0800AB">{{$inscription->people->nombrecompleto()}}</a></td>
				<td>{{$inscription->group->startclass->career->nombre}}</td>
				<td>{{$inscription->group->turno}}</td>
				<td>{{ Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->format('j M Y')}}</td>
				<td style="text-align: center; background-color: rgba(0,0,255,0.35);">
					{!! Form::open(['url'=>'assistance/assistance_ajax']) !!}
					<input class="check_piscina check_asistencia" insc="{{$inscription->id}}" type="checkbox" value="{{$inscription->id}}" name="socabon[]" @if ($inscription->asistencia_personalizada(7,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'),3)) checked @endif>
					<input type="hidden" name="group_id" value="{{$inscription->group_id}}">
					<input type="hidden" name="materia_id" value="7">
					<input type="hidden" name="inscription_id" value="{{$inscription->id}}">
					<input type="hidden" name="asistio" @if ($inscription->asistencia_personalizada(7,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'),3)) value="si" @else value="no" @endif >
					{!! Form::close() !!}
				</td>
				<td style="text-align: center; background-color: rgba(255,0,0,0.45);">
					{!! Form::open(['url'=>'assistance/assistance_ajax']) !!}
					<input class="check_piscina check_asistencia" insc="{{$inscription->id}}" type="checkbox" value="{{$inscription->id}}" name="sacaba[]" @if ($inscription->asistencia_personalizada(7,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'),2)) checked @endif>
					<input type="hidden" name="group_id" value="{{$inscription->group_id}}">
					<input type="hidden" name="materia_id" value="7">
					<input type="hidden" name="inscription_id" value="{{$inscription->id}}">
					<input type="hidden" name="asistio" @if ($inscription->asistencia_personalizada(7,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'),2)) value="si" @else value="no" @endif >
					{!! Form::close() !!}
				</td>
			</tr>
			<?php $key++; ?>
			@endif
			@endforeach
		</tbody>
	</table>
</div>
@endsection