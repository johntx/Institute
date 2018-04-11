<div class="panel panel-primary col-xs-9">
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
				<table class="schedule">
					<tbody>
						<tr>
							<th>Mañana</th><th colspan="8">PISO 4</th><th colspan="2">PISO 3</th><th class="blue">BLOQUE</th><th class="blue">EXTERIOR</th>
						</tr>
						<tr>
							<th></th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th class="p3">1</th><th class="p3">6</th><th class="blue">2</th><th class="blue"></th>
						</tr>
						@for ($h = 0; $h < 25; $h++)
						<tr y="{{$h+1}}" @if ($h%2==0 && $h<9) borde="si" @elseif ($h%2!=0 && $h>13) borde="si" @elseif($h>21 || $h>8 && $h<14) borde="si" @endif h1="{{$horario[$h]}}" h2="{{$horario[$h+1]}}" @if ($h>8 && $h<13) class="h tarde" @endif>
						<td @if ($h<10) tamano="grande" @if ($h%2 != 0) turno="manana" @else turno="man" @endif @elseif ($h<13) turno="medio" @elseif ($h<22) tamano="grande" @if ($h%2 != 0) turno="tar" @else turno="tarde" @endif @else turno="noche" @endif><div>{{$horario[$h]}}</div></td>
							@for ($i = 1; $i <= 12; $i++)
							@if ($i<=8)
							<td x="{{$i}}" p="P4" a="A{{$i}}" class="droppable"></td>
							@endif
							@if ($i==9)
							<td x="{{$i}}" p="P3" a="A1" class="droppable p3"></td>
							@endif
							@if ($i==10)
							<td x="{{$i}}" p="P3" a="A6" class="droppable p3"></td>
							@endif
							@if ($i==11)
							<td x="{{$i}}" p="B2" a="B2" class="droppable blue"></td>
							@endif
							@if ($i==12)
							<td x="{{$i}}" p="ext" a="ext" class="droppable blue"></td>
							@endif
							@endfor
						</tr>
						@endfor
					</tbody>
				</table>
			</div>
			@endforeach
		</div>
		<br>
		<div class="form-group">
			{!! Form::label('Descripcion') !!}
			{!! Form::text('descripcion',null,['class'=>'form-control','placeholder'=>'Inserte una descripcion', 'maxlength'=>250]) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Vigente') !!}
			{!! Form::select('vigente',['no' => 'no','si' => 'si','anticipado' => 'anticipado'],null,['class'=>'form-control','maxlength'=>10]) !!}
		</div>
		{!! Form::submit('Registar',['class'=>'btn btn-success']) !!}
	</div>
</div>
@foreach ($startclasses as $startclass)
<div class="col-xs-3">
	<div class="panel panel-primary" style="margin-bottom: 5px;">
		<div class="panel-heading" style="padding: 5;">
			{{$startclass->career->nombre}} [{{Jenssegers\Date\Date::parse($startclass->fecha_inicio)->format('j M Y')}}]<button type="button" convocatoria="{{$startclass->id}}" class="btn btn-xs btn_expand">+</button>
		</div>
		<div class="panel-body body_expandible lista_materias" active='no' id="{{$startclass->id}}">
			@foreach ($startclass->groups()->orderBy('turno','asc')->get() as $group)
			<div class="panel panel-success" style="margin-bottom: 5px;">
				<div class="panel-heading" style="padding: 5;">
					{{$group->turno}}
				</div>
				<div class="panel-body" style="padding: 5;">
					@foreach ($group->startclass->career->subjects as $subject)
					<div class="col-xs-6" style="padding: 3;">
						<li class=" droppable">
							<div class="hour matematica" size="4" texto="{{$group->startclass->career->texto}}" asignatura="{{$subject->nombre}}" carrera="{{$group->startclass->career->nombre}}" fecha="{{$group->startclass->fecha_inicio}}" color="{{$group->startclass->career->color}}" group_id="{{$group->id}}" career_id="{{$group->startclass->career->id}}" subject_id="{{$subject->id}}" style="background-color: {{$group->startclass->career->color}}; color: {{$group->startclass->career->texto}}; ">{{$subject->nombre}}
								<select disabled hidden name="people_id[]" class="teacher_select" style="background-color: {{$group->startclass->career->color}}; color: {{$group->startclass->career->texto}}; font-size: 8px; font-style: italic;">
									@if (sizeof($subject->peoples)==0)
									<option value="null">Nadie</option>
									@endif
									@foreach ($subject->peoples as $people)
									<option value="{{$people->id}}">{{$people->nombre}}</option>
									@endforeach
								</select>
							</div>
						</li>
					</div>
					@endforeach
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endforeach