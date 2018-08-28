@extends('layouts.admin')
@section('content')
@foreach(Auth::user()->people->inscriptions->where('estado','Inscrito') as $inscription)
<div class="panel panel-primary">
	<div class="panel-heading">Grupo: {{$inscription->group->startclass->career->nombre}} ({{$inscription->group->startclass->estado}}) [{{Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->format('j M Y')}}] Turno:{{$inscription->group->turno}}</div>
	<div class="panel-body">
		<div class="table-responsive vista_reducida">
			<table class="table table-hover table-condensed">
				<tr>
					<thead>
						<th>Nombre</th>
						<th># Asis.</th>
						<th>Estado</th>
						@foreach (\Institute\Assistance::where('asistencia',1)->where('group_id',$inscription->group_id)->groupBy('fecha','subject_id')->orderBy('fecha','asc')->get() as $k=>$asistencia)
						<th class="contenedor_fechas">
							<div class="fecha_vertical">{{\Carbon\Carbon::parse($asistencia->fecha)->format('d/m/y')}}
							</div>
							<div class="asignatura_vertical">{{$asistencia->subject->nombre}}</div>
							<p class="dia_inicial">{{strtoupper(\Jenssegers\Date\Date::parse($asistencia->fecha)->format('l')[0])}}{{\Jenssegers\Date\Date::parse($asistencia->fecha)->format('l')[1]}}</p>
						</th>
						@endforeach
					</thead>
				</tr>
				<tr @if ($inscription->estado == 'Retirado') style="background-color: rgba(0,0,80,0.4);" @endif @if ($inscription->debit()) style="background-color:rgba(255,0,0,0.25);" @elseif ($inscription->debitNext()) style="background-color: rgba(255,255,0,0.25);" @else style="background-color: rgba(0,255,0,0.25);"  @endif>
					<td><b><a href="{{url('admin/student/search/'.$inscription->people_id)}}" style="color: #0800AB">{{$inscription->people->nombrecompleto()}}</a></b></td>
					<td>{{$inscription->asisCont()}}</td>
					<td>{{$inscription->estado}}</td>
					@foreach (\Institute\Assistance::where('asistencia',1)->where('group_id',$inscription->group_id)->groupBy('fecha','subject_id')->orderBy('fecha','asc')->get() as $k=>$asistencia)
					@if ($inscription->asistencia($asistencia->subject_id,$asistencia->people_id,$asistencia->fecha)) 
					<td class="al_r">✔</td>
					@else
					@if ($asistencia->fecha>=$inscription->fecha_ingreso)
					<td class="al_r">✗</td>
					@else
					<td class="al_r">-</td>
					@endif
					@endif
					@endforeach
				</tr>
			</table>
		</div>
	</div>
</div>
@endforeach
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
	.fecha_vertical{transform:rotate(90deg);position:absolute;top:20px;right:-20px;background-color: white;z-index: 100;height: 13px;}
	.asignatura_vertical{font-size:10px;transform:rotate(90deg);position:absolute;top:35px;right:-21px;margin:0;width: 100px;height:32px;}
	.dia_inicial{margin: 0;font-size: 12px;}
</style>
@endsection