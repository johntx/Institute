@extends('layouts.admin')
@section('content')
<div class="panel-body">
	<ul class="nav nav-tabs" role="tablist">
		@foreach ($semana as $key=>$dia)
		<li tipo="horario" role="presentation" @if ($key==0) class="active" @endif>
			<a href="#{{$dia}}" aria-controls="{{$dia}}" role="tab" data-toggle="tab">{{strtoupper($dia)}}</a>
		</li>
		@endforeach
	</ul>
	<div class="tab-content">
		@foreach ($semana as $key=>$dia)
		<div role="tabpanel" class="tab-pane @if ($key==0) active @endif" id="{{$dia}}">
			<table class="schedule show" tabla="ver">
				<tbody>
					<tr>
						<th>Mañana</th><th colspan="8">PISO 4</th><th colspan="2">PISO 3</th><th class="blue">BLOQUE</th><th class="blue">EXTERIOR</th>
					</tr>
					<tr>
						<th></th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th class="p3">1</th><th class="p3">6</th><th class="blue">2</th><th class="blue"></th>
					</tr>
					@for ($h = 0; $h < 24; $h++)
					<?php
					$horas = $schedule->hours()->where('dia',$dia)->where('hora_inicio',$horario[$h])->get();
					?>
					<tr y="{{$h+1}}" @if ($h%2!=0 && $h<8) borde="si" @elseif ($h%2==0 && $h>12) borde="si" @elseif($h>20 || $h>7 && $h<13) borde="si" @endif h1="{{$horario[$h]}}" h2="{{$horario[$h+1]}}" @if ($h>7 && $h<12) class="h tarde" @endif>
						<td @if ($h<8) tamano="grande" @if ($h%2 == 0) turno="manana" @else turno="man" @endif @elseif ($h<12) turno="medio" @elseif ($h<21)	tamano="grande" @if ($h%2 == 0) turno="tar" @else turno="tarde" @endif @else turno="noche" @endif><div>{{$horario[$h]}}</div></td>
						@for ($i = 1; $i <= 12; $i++)
						@if ($i<=8)
						<td x="{{$i}}" p="P4" a="A{{$i}}">
							@foreach ($horas as $hora)
							@if ($hora->piso=='P4' && $hora->aula=='A'.$i)
							<div class="hour show" size="{{$hora->periodos}}" texto="{{$hora->group->startclass->career->texto}}" asignatura="{{$hora->subject->nombre}}" carrera="{{$hora->subject->nombre}}" fecha="{{$hora->group->startclass->fecha_inicio}}" color="{{$hora->group->startclass->career->color}}" group_id="{{$hora->group->id}}" career_id="{{$hora->group->startclass->career_id}}" subject_id="{{$hora->subject_id}}" style="background-color: {{$hora->group->startclass->career->color}}; color: {{$hora->group->startclass->career->texto}}; ">{{$hora->group->startclass->career->nombre}}
								<select disabled hidden name="people_id[]" class="teacher_select" style="background-color: {{$hora->group->startclass->career->color}}; color: {{$hora->group->startclass->career->texto}}; font-size: 8px; font-style: italic;">
									@if ($hora->people_id==0)
									<option value="null">Nadie</option>
									@else
									<option value="{{$hora->people_id}}" selected>{{$hora->people['nombre']}}</option>
									@endif
								</select>
							</div>
							@endif
							@endforeach
						</td>
						@endif
						@if ($i==9)
						<td x="{{$i}}" p="P3" a="A1" class="droppable p3">
							@foreach ($horas as $hora)
							@if ($hora->piso=='P3' && $hora->aula=='A1')
							<div class="hour" size="{{$hora->periodos}}" texto="{{$hora->group->startclass->career->texto}}" asignatura="{{$hora->subject->nombre}}" carrera="{{$hora->subject->nombre}}" fecha="{{$hora->group->startclass->fecha_inicio}}" color="{{$hora->group->startclass->career->color}}" group_id="{{$hora->group->id}}" career_id="{{$hora->group->startclass->career_id}}" subject_id="{{$hora->subject_id}}" style="background-color: {{$hora->group->startclass->career->color}}; color: {{$hora->group->startclass->career->texto}}; ">{{$hora->group->startclass->career->nombre}}
								<select disabled hidden name="people_id[]" class="teacher_select" style="background-color: {{$hora->group->startclass->career->color}}; color: {{$hora->group->startclass->career->texto}}; font-size: 8px;">
									@if ($hora->people_id==0)
									<option value="null">Nadie</option>
									@else
									<option value="{{$hora->people_id}}" selected>{{$hora->people['nombre']}}</option>
									@endif
								</select>
							</div>
							@endif
							@endforeach
						</td>
						@endif
						@if ($i==10)
						<td x="{{$i}}" p="P3" a="A6" class="droppable p3">
							@foreach ($horas as $hora)
							@if ($hora->piso=='P3' && $hora->aula=='A6')
							<div class="hour" size="{{$hora->periodos}}" texto="{{$hora->group->startclass->career->texto}}" asignatura="{{$hora->subject->nombre}}" carrera="{{$hora->subject->nombre}}" fecha="{{$hora->group->startclass->fecha_inicio}}" color="{{$hora->group->startclass->career->color}}" group_id="{{$hora->group->id}}" career_id="{{$hora->group->startclass->career_id}}" subject_id="{{$hora->subject_id}}" style="background-color: {{$hora->group->startclass->career->color}}; color: {{$hora->group->startclass->career->texto}}; ">{{$hora->group->startclass->career->nombre}}
								<select disabled hidden name="people_id[]" class="teacher_select" style="background-color: {{$hora->group->startclass->career->color}}; color: {{$hora->group->startclass->career->texto}}; font-size: 8px;">
									@if ($hora->people_id==0)
									<option value="null">Nadie</option>
									@else
									<option value="{{$hora->people_id}}" selected>{{$hora->people['nombre']}}</option>
									@endif
								</select>
							</div>
							@endif
							@endforeach
						</td>
						@endif
						@if ($i==11)
						<td x="{{$i}}" p="B2" a="B2" class="droppable">
							@foreach ($horas as $hora)
							@if ($hora->piso=='B2' && $hora->aula=='B2')
							<div class="hour" size="{{$hora->periodos}}" texto="{{$hora->group->startclass->career->texto}}" asignatura="{{$hora->subject->nombre}}" carrera="{{$hora->subject->nombre}}" fecha="{{$hora->group->startclass->fecha_inicio}}" color="{{$hora->group->startclass->career->color}}" group_id="{{$hora->group->id}}" career_id="{{$hora->group->startclass->career_id}}" subject_id="{{$hora->subject_id}}" style="background-color: {{$hora->group->startclass->career->color}}; color: {{$hora->group->startclass->career->texto}}; ">{{$hora->group->startclass->career->nombre}}
								<select disabled hidden name="people_id[]" class="teacher_select" style="background-color: {{$hora->group->startclass->career->color}}; color: {{$hora->group->startclass->career->texto}}; font-size: 8px;">
									@if ($hora->people_id==0)
									<option value="null">Nadie</option>
									@else
									<option value="{{$hora->people_id}}" selected>{{$hora->people['nombre']}}</option>
									@endif
								</select>
							</div>
							@endif
							@endforeach
						</td>
						@endif
						@if ($i==12)
						<td x="{{$i}}" p="ext" a="ext" class="droppable">
							@foreach ($horas as $hora)
							@if ($hora->piso=='ext' && $hora->aula=='ext')
							<div class="hour" size="{{$hora->periodos}}" texto="{{$hora->group->startclass->career->texto}}" asignatura="{{$hora->subject->nombre}}" carrera="{{$hora->subject->nombre}}" fecha="{{$hora->group->startclass->fecha_inicio}}" color="{{$hora->group->startclass->career->color}}" group_id="{{$hora->group->id}}" career_id="{{$hora->group->startclass->career_id}}" subject_id="{{$hora->subject_id}}" style="background-color: {{$hora->group->startclass->career->color}}; color: {{$hora->group->startclass->career->texto}}; ">{{$hora->group->startclass->career->nombre}}
								<select disabled hidden name="people_id[]" class="teacher_select" style="background-color: {{$hora->group->startclass->career->color}}; color: {{$hora->group->startclass->career->texto}}; font-size: 8px;">
									@if ($hora->people_id==0)
									<option value="null">Nadie</option>
									@else
									<option value="{{$hora->people_id}}" selected>{{$hora->people['nombre']}}</option>
									@endif
								</select>
							</div>
							@endif
							@endforeach
						</td>
						@endif
						@endfor
					</tr>
					@endfor
				</tbody>
			</table>
		</div>
		@endforeach
	</div>
</div>
@endsection
@section('adminjs')
{!!Html::script('js/horario.js')!!}
@endsection