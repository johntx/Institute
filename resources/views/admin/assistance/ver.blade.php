@extends('layouts.admin')
@section('content')
@include('alerts.succes')
@foreach ($docentes as $docente)
<div class="panel panel-success">
	<div class="panel-heading">Docente: {{$docente->nombrecompleto()}}</div>
	<div class="panel-body">
		@foreach (\Institute\Subject::select('subjects.*')->join('assistances','assistances.subject_id','=','subjects.id')->where('assistances.group_id',$group->id)->groupBy('subjects.id')->get() as $materia)
		<div class="panel panel-primary">
			<div class="panel-heading">Materia: {{$materia->nombre}} <div style="float: right;">Grupo: {{$group->startclass->career->nombre}} {{Jenssegers\Date\Date::parse($group->startclass->fecha_inicio)->format('j M Y')}} {{$group->turno}}</div></div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed">
						<thead>
							<th>No</th>
							<th>(Hoy)<br><p style="margin: 0;font-size: 12px;">{{\Carbon\Carbon::now()->format('d/m/y')}}</p></th>
							<th>Nombre</th>
							<th># Asis.</th>
							<th>Estado</th>
							@foreach (\Institute\Assistance::select('assistances.fecha')->where('asistencia',1)->where('group_id',$group->id)->where('subject_id',$materia->id)->where('people_id',$docente->id)->distinct('fecha')->orderBy('fecha','asc')->get() as $fecha)
							<th style="position: relative; height: 70px;"><p style="transform: rotate(90deg); position: absolute; top: 23px; left: -20px;">{{\Carbon\Carbon::parse($fecha->fecha)->format('d/m/y')}}</p></th>
							@endforeach
						</thead>
						@foreach($inscriptions as $i=>$inscription)
						<tr @if ($inscription->estado == 'Retirado') style="background-color: rgba(255,0,0,0.25);" @endif>
							<td>{{++$i}}</td>
							<td>
								<label class="switch">
									<input type="checkbox" disabled name="asistencia[]" class="" value="{{$inscription->id}}" @if ($inscription->asistencia($group->id,$materia->id,$docente->id,\Carbon\Carbon::now()->format('Y-m-d'))) checked @endif>
									<span class="slider round check_asistencia"></span>
								</label>
							</td>
							<td>{{$inscription->people->nombrecompleto()}}</td>
							<td>{{$inscription->asisCont($group->id,$materia->id,$docente->id)}}</td>
							<td>{{$inscription->estado}}</td>
							@foreach (\Institute\Assistance::select('assistances.fecha')->where('asistencia',1)->where('group_id',$group->id)->where('subject_id',$materia->id)->where('people_id',$docente->id)->distinct('fecha')->orderBy('fecha','asc')->get() as $fecha)
							@if ($inscription->asistencia($group->id,$materia->id,$docente->id,$fecha->fecha)) 
							<td>✔</td>
							@else
							<td>✗</td>
							@endif
							@endforeach
						</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endforeach
@endsection