<div class="panel panel-primary col-xs-9">
	<div id="trash" class="droppable"></div>
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			@foreach ($semana as $key=>$dia)
			<li tipo="horario" role="presentation" @if ($key==0) class="active" @endif>
				<a href="#{{$dia}}" aria-controls="{{$dia}}" role="tab" data-toggle="tab">{{strtoupper($dia)}}</a>
			</li>
			@endforeach
			<li role="presentation">
				<a href="#docentes" aria-controls="docentes" role="tab" data-toggle="tab">DOCENTES</a>
			</li>
		</ul>
		<div class="tab-content">
			@foreach ($semana as $key=>$dia)
			<div role="tabpanel" class="tab-pane table-responsive @if ($key==0) active @endif" id="{{$dia}}">
				<table class="schedule">
					<tbody>
						<tr>
							<th>Hora</th>
							@for ($i = 0; $i < count($classrooms); $i++)
							<th colspan="{{count($classrooms->where('area',$classrooms[$i]->area))}}">{{$classrooms[$i]->area}}</th>
							<?php if (count($classrooms->where('area',$classrooms[$i]->area))>1) {
								$i=$i+count($classrooms->where('area',$classrooms[$i]->area))-1;
							} ?>
							@endfor
						</tr>
						<tr>
							<th></th>
							@foreach ($classrooms as $clam)
							<th>{{$clam->aula}}</th>
							@endforeach
						</tr>
						@foreach ($horario as $h=>$hora)
						<tr h="{{$h}}" @if ($h%2==0 && $h<9) borde="si" @elseif ($h%2!=0 && $h>13) borde="si" @elseif($h>21 || $h>8 && $h<14) borde="si" @endif @if ($h>8 && $h<13) class="h tarde" @endif>
							<td @if ($h<10) tamano="grande" @if ($h%2 != 0) turno="manana" @else turno="man" @endif @elseif ($h<13) turno="medio" @elseif ($h<24) tamano="grande" @if ($h%2 != 0) turno="tar" @else turno="tarde" @endif @else turno="noche" @endif><div>{{$hora}}</div></td>
							@foreach ($classrooms as $x=>$clam)
							<td dia="{{$dia}}" aula='{{$clam->aula}}' piso='{{$clam->piso}}' h='{{$h}}' x='{{$x}}' hora="{{$hora}}">
								<div class="contenedor droppable">
									@foreach ($horas_semana[$dia]->where('hora_inicio',$hora)->where('aula',$clam->aula)->where('piso',$clam->piso) as $hour)
									<div uni="{{$hour->id}}" class="cubo cabeza" p="{{$hour->periodos}}" career="{{$hour->group->startclass->career->nombre}}" fecha="{{Jenssegers\Date\Date::parse($hour->group->startclass->fecha_inicio)->format('j M Y')}}" materia="{{$hour->subject->nombre}}" people="<select class='people'>@if (sizeof($hour->subject->peoples)==0) <option value='null'>Nadie</option>@endif @foreach($hour->subject->peoples as $people) <option value='{{$people->id}}' @if ($people->id == $hour->people_id) selected @endif>{{$people->nombre}}</option> @endforeach </select>" turno="{{$hour->group->turno}}" inscritos="{!!$hour->group->inscritos($hour->group)!!}" people_id="{{$hour->people_id}}" group_id="{{$hour->group_id}}" subject_id="{{$hour->subject_id}}" hora_2="{{$horario[$h+$hour->periodos]}}">{{$hour->group->startclass->career->nombre}}</div>
									@endforeach
									@foreach ($horas_semana[$dia]->where('aula',$clam->aula)->where('piso',$clam->piso) as $hour)
									@if ($hour->h+1 == $h && $h < $hour->h+$hour->periodos-1)
									<div uni="{{$hour->id}}" class="cont_turno cuerpo cubo" career="{{$hour->group->startclass->career->nombre}}" onclick="window.open('{{ url('assistance/ver/'.$hour->group->id ) }}')">{{Jenssegers\Date\Date::parse($hour->group->startclass->fecha_inicio)->format('j M Y')}}<div class="turno">{{$hour->group->turno}}</div><div class="inscritos">{!!$hour->group->inscritos($hour->group)!!}</div></div>
									@endif
									@if ($hour->h+2 == $h && $h < $hour->h+$hour->periodos-1)
									<div uni="{{$hour->id}}" class="cuerpo cubo" career="{{$hour->group->startclass->career->nombre}}">{{$hour->subject->nombre}}</div>
									@endif
									@if ($hour->h+2 < $h && $hour->h+$hour->periodos-1 > $h && $h < $hour->h+$hour->periodos-1)
									<div uni="{{$hour->id}}" class="cuerpo cubo" career="{{$hour->group->startclass->career->nombre}}">&emsp;</div>
									@endif
									@if ($hour->h+$hour->periodos-1 == $h)
									<div uni="{{$hour->id}}" class="cuerpo cubo pie cont_periodo" career="{{$hour->group->startclass->career->nombre}}" p="{{$hour->periodos}}">
										<select name="people_id[]" class="people">
											@if (sizeof($hour->subject->peoples)==0)
											<option value="null">Nadie</option>
											@endif
											@foreach ($hour->subject->peoples as $people)
											<option value="{{$people->id}}" @if ($people->id == $hour->people_id) selected @endif>{{$people->nombre}}</option>
											@endforeach
										</select><select class="periodo">@for ($i = 2; $i < 9; $i++)<option value="{{$i}}" @if ($hour->periodos == $i) selected @endif>{{$i}}</option> @endfor</select>
										<input type="text" class="datos" name="datos[]" value="{{$hour->people_id}}-{{$clam->aula}}-{{$clam->piso}}-{{$horario[$h-$hour->periodos+1]}}-{{$horario[$h+1]}}-{{$dia}}-{{$hour->group_id}}-{{$hour->subject_id}}-{{$h-$hour->periodos+1}}-{{$hour->periodos}}">
									</div>
									@endif
									@endforeach
								</div>
							</td>
							@endforeach
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@endforeach
			<div role="tabpanel" class="tab-pane table-responsive" id="docentes">
				<div class="table-responsive">
					<table class="table table-hover table-condensed">
						<thead>
							<th>Nombre</th>
							<th>Lunes</th>
							<th>Martes</th>
							<th>Miercoles</th>
							<th>Jueves</th>
							<th>Viernes</th>
							<th>Sabado</th>
						</thead>
						@foreach($availables as $available)
						<tbody>
							<td>{{$available->people->nombrecompleto()}}</td>
							<td>{{$available->lunes}}</td>
							<td>{{$available->martes}}</td>
							<td>{{$available->miercoles}}</td>
							<td>{{$available->jueves}}</td>
							<td>{{$available->viernes}}</td>
							<td>{{$available->sabado}}</td>
						</tbody>
						@endforeach
					</table>
				</div>
			</div>
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
		{!! Form::submit('Guardar',['class'=>'btn btn-success']) !!}
	</div>
</div>
<?php $uni=0; ?>
<div id="cont_rig">
	@foreach ($startclasses as $startclass)
	<div>
		<div class="panel" style="margin-bottom: 5px;">
			<div class="panel-heading" career="{{$startclass->career->nombre}}" style="padding: 5;">
				{{$startclass->career->nombre}} [{{Jenssegers\Date\Date::parse($startclass->fecha_inicio)->format('j M Y')}}]<button type="button" convocatoria="{{$startclass->id}}" class="btn btn-xs btn_expand">+</button>
			</div>
			<div class="panel-body body_expandible lista_materias" active='no' id="{{$startclass->id}}">
				@foreach ($startclass->groups()->orderBy('turno','asc')->get() as $group)
				<div class="panel panel-info" style="margin-bottom: 5px;">
					<div class="panel-heading" style="padding: 5;">
						{{$group->turno}} &nbsp;&nbsp; <b>[</b> {!!$group->inscritos($group)!!} <b>]</b>
					</div>
					<div class="panel-body" style="padding: 5;">
						@foreach ($group->startclass->career->subjects as $subject)
						<div class="col-xs-6" style="padding: 3;">
							<li class="cont_drop">
								<div class="contenedor droppable">
									<div uni="{{++$uni}}" class="cubo cabeza @if(count(\Institute\Hour::where('group_id',$group->id)->where('subject_id',$subject->id)->where('schedule_id',$schedule->id)->get())>0) uso @endif" p="4" career="{{$group->startclass->career->nombre}}" fecha="{{Jenssegers\Date\Date::parse($group->startclass->fecha_inicio)->format('j M Y')}}" materia="{{$subject->nombre}}" people="<select class='people'>@if (sizeof($subject->peoples)==0) <option value='null'>Nadie</option>@endif @foreach ($subject->peoples as $people) <option value='{{$people->id}}'>{{$people->nombre}}</option> @endforeach </select>" turno="{{$group->turno}}" inscritos="{!!$group->inscritos($group)!!}" people_id="{{$subject->peoples->first()['id']}}" group_id="{{$group->id}}" subject_id="{{$subject->id}}" asistencias="{{ url('assistance/ver/'.$group->id ) }}">{{$subject->nombre}}</div>
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
</div>
<style>@foreach (\Institute\Career::get() as $career)
	td[career="{{$career->nombre}}"],div[career="{{$career->nombre}}"],div[career="{{$career->nombre}}"] *{
		background-color: {{$career->color}};
		color: {{$career->texto}};
	}@endforeach
	#page-wrapper{
		padding: 0;
	}
	#trash{
		background-image: url("{!!URL::to('icons/trash.svg')!!}");
	}
</style>