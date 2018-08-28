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
					<?php $ban = 1;?>
						<th>Hora</th>
						@for ($i = 0; $i < count($classrooms); $i++)
						<th colspan="{{count($classrooms->where('area',$classrooms[$i]->area))}}" @if ($ban>0) style="background-color: #000679;" @endif>{{$classrooms[$i]->area}}</th>
						<?php if (count($classrooms->where('area',$classrooms[$i]->area))>1) {
							$i=$i+count($classrooms->where('area',$classrooms[$i]->area))-1;
						} $ban = $ban*-1; ?> 
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
							<div class="contenedor">
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
								<div uni="{{$hour->id}}" class="cuerpo cubo pie cont_periodo cont_turno" career="{{$hour->group->startclass->career->nombre}}" p="{{$hour->periodos}}">
									<a target="_blank" href="{{ url('admin/tickeo/logPerson/'.$hour->people['id'].'/'.Carbon\Carbon::now()->subMonth()->format('Y-m-d') ) }}">{{$hour->people['nombre']}}</a>
									<div class="turno">
									<?php $code = \Institute\People::find($hour->people['id'])->code;?>
										@foreach (\Institute\Tickeo::join('biometrics','tickeos.biometric_id','=','biometrics.id')->where('biometrics.id',$code)->whereBetween('fecha',array(Carbon\Carbon::now()->format('Y-m-d 00:00:00'),Carbon\Carbon::now()->format('Y-m-d 23:59:59')))->get() as $tickeo)
											<?php if ($tickeo->tipo==0) { echo "Entrada"; }else{ echo "Salida"; } ?><br>{{\Carbon\Carbon::parse($tickeo->fecha)->format('H:i:s')}}
												<br>
										@endforeach
									</div>
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
	</div>
</div>
<div class="col-md-1" id="float_count">
	<span>0</span>
</div>
@endsection
@section('adminjs')
{!!Html::script('js/horario.js')!!}
@endsection
<style>@foreach (\Institute\Career::get() as $career)
	td[career="{{$career->nombre}}"],div[career="{{$career->nombre}}"],div[career="{{$career->nombre}}"] *{
		background-color: {{$career->color}};
		color: {{$career->texto}};
	}@endforeach
</style>