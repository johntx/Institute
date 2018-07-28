@extends('layouts.admin')
@section('content')
@foreach ($hours as $h)
<h4>({{Jenssegers\Date\Date::parse($h->group->startclass->fecha_inicio)->format('j M Y')}}) - <b>{{$h->group->startclass->career->nombre}}</b> - {{$h->group->turno}}</h4>
<div class="table-responsive vista_movil">
	<table class="table table-hover table-condensed">
		<thead>
			<th>No</th>
			<th>(Hoy)<br><p style="margin: 0;font-size: 10px;">{{\Carbon\Carbon::now()->format('d/m/y')}}</p></th>
			<th>Nombre</th>
			<th># Asis.</th>
			<th>Estado</th>
			@foreach (\Institute\Assistance::select('assistances.fecha')->where('asistencia',1)->where('group_id',$h->group_id)->where('subject_id',$h->subject_id)->where('people_id',Auth::user()->id)->distinct('fecha')->orderBy('fecha','asc')->get() as $k=>$fecha)
			<th style="position: relative; height: 70px;"><p style="transform: rotate(90deg); position: absolute; top: 23px; left: -20px;">{{\Carbon\Carbon::parse($fecha->fecha)->format('d/m/y')}}</p></th>
			<?php $cont[$k]=0; ?>
			@endforeach
		</thead>
		@foreach(\Institute\Inscription::leftjoin('assistances','assistances.inscription_id','=','inscriptions.id')->join('peoples','inscriptions.people_id','=','peoples.id')->select('inscriptions.*','assistances.asistencia as asistencia')->where('inscriptions.group_id',$h->group_id)->groupBy('inscriptions.id')->orderBy('peoples.nombre','asc')->get() as $i=>$inscription)
		<tr @if ($inscription->estado == 'Retirado') style="background-color: rgba(0,0,80,0.4);" @endif @if ($inscription->debit()) style="background-color: rgba(255,0,0,0.25);"  @elseif ($inscription->debitNext()) style="background-color: rgba(255,255,0,0.25);"  @else style="background-color: rgba(0,255,0,0.25);"  @endif >
			<td>{{++$i}}</td>
			<td>
				{!! Form::open(['url'=>'assistance/assistance_ajax']) !!}
				<label class="switch">
					<input type="checkbox" name="asistencia" class="check_asistencia" value="{{$inscription->id}}" @if ($inscription->asistencia($h->subject_id,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'))) checked @endif>
					<span class="slider round"></span>
				</label>
				<!--Añadido para uso de ajax-->
				<input type="hidden" name="group_id" value="{{$h->group_id}}">
				<input type="hidden" name="materia_id" value="{{$h->subject_id}}">
				<input type="hidden" name="inscription_id" value="{{$inscription->id}}">
				<input type="hidden" name="asistio" @if ($inscription->asistencia($h->subject_id,Auth::id(),\Carbon\Carbon::now()->format('Y-m-d'))) value="si" @else value="no" @endif >
				{!! Form::close() !!}

			</td>
			<td>{{$inscription->people->nombrecompleto()}}</td>
			<td>{{$inscription->myAsisCont($h->subject_id,Auth::id())}}</td>
			<td>{{$inscription->estado}}</td>
			@foreach (\Institute\Assistance::select('assistances.fecha')->where('asistencia',1)->where('group_id',$h->group_id)->where('subject_id',$h->subject_id)->where('people_id',Auth::user()->id)->distinct('fecha')->orderBy('fecha','asc')->get() as $k=>$fecha)
			@if ($inscription->asistencia($h->subject_id,Auth::id(),$fecha->fecha)) 
			<td>✔</td>
			<?php $cont[$k] = $cont[$k]+1; ?>
			@else
			@if ($fecha->fecha>=$inscription->fecha_ingreso)
			<td>✗</td>
			@else
			<td>-</td>
			@endif
			@endif
			@endforeach
		</tr>
		@endforeach
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><b>Conteo:</b></td>
			@foreach (\Institute\Assistance::select('assistances.fecha')->where('asistencia',1)->where('group_id',$h->group_id)->where('subject_id',$h->subject_id)->where('people_id',Auth::user()->id)->distinct('fecha')->orderBy('fecha','asc')->get() as $k=>$fecha)
			<td>{{$cont[$k]}}</td>
			@endforeach
		</tr>
	</table>
</div>
@endforeach
<style>
	.vista_movil *{
		font-size: 12px;
	}
	.vista_movil td{
		padding: 4px !important;
	}
	.vista_movil td form{
		margin: 0 !important;
	}
	.switch{
		margin: 0;
	}
</style>
@endsection