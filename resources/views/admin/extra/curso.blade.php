@extends('layouts.admin')
@section('content')
{!! Form::open(['url'=>'extra/filtro']) !!}
<h4>Curso Extra: {{$curso->nombre}}</h4>{!! Form::submit('Filtrar',['class'=>'btn btn-success']) !!}
<div class="table-responsive">
	<table class="table table-hover tablaSearch compact">
		<thead>
			<th></th>
			<th>Nombre</th>
			<th>Carrera</th>
			<th>Grupo</th>
			<th>Fecha Ingreso</th>
			<th>Socabon</th>
			<th>Oasis</th>
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
				<td style="background-color: rgba(0,255,0,0.35);"><input class="check_piscina" insc="{{$inscription->id}}" type="checkbox" style="width: 100%; height: 35px;" value="{{$inscription->id}}" name="socabon[]"></td>
				<td style="background-color: rgba(255,255,0,0.35);"><input class="check_piscina" insc="{{$inscription->id}}" type="checkbox" style="width: 100%; height: 35px;" value="{{$inscription->id}}" name="oasis[]"></td>
				<td style="background-color: rgba(255,0,0,0.35);"><input class="check_piscina" insc="{{$inscription->id}}" type="checkbox" style="width: 100%; height: 35px;" value="{{$inscription->id}}" name="sacaba[]"></td>
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
				<td style="background-color: rgba(0,255,0,0.35);"><input class="check_piscina" insc="{{$inscription->id}}" type="checkbox" style="width: 100%; height: 35px;" value="{{$inscription->id}}" name="socabon[]"></td>
				<td style="background-color: rgba(255,255,0,0.35);"><input class="check_piscina" insc="{{$inscription->id}}" type="checkbox" style="width: 100%; height: 35px;" value="{{$inscription->id}}" name="oasis[]"></td>
				<td style="background-color: rgba(255,0,0,0.35);"><input class="check_piscina" insc="{{$inscription->id}}" type="checkbox" style="width: 100%; height: 35px;" value="{{$inscription->id}}" name="sacaba[]"></td>
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
				<td style="background-color: rgba(0,255,0,0.35);"><input class="check_piscina" insc="{{$inscription->id}}" type="checkbox" style="width: 100%; height: 35px;" value="{{$inscription->id}}" name="socabon[]"></td>
				<td style="background-color: rgba(255,255,0,0.35);"><input class="check_piscina" insc="{{$inscription->id}}" type="checkbox" style="width: 100%; height: 35px;" value="{{$inscription->id}}" name="oasis[]"></td>
				<td style="background-color: rgba(255,0,0,0.35);"><input class="check_piscina" insc="{{$inscription->id}}" type="checkbox" style="width: 100%; height: 35px;" value="{{$inscription->id}}" name="sacaba[]"></td>
			</tr>
			<?php $key++; ?>
			@endif
			@endforeach
		</tbody>
	</table>
</div>
{!! Form::close() !!}
@endsection