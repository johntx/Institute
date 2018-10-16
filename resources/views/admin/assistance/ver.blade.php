@extends('layouts.admin')
@section('content')
<div class="tabla-scroll-doble">
	<div class="nombres">
		<div class="header">Nombre</div>
		<div class="body">
			@foreach($inscriptions as $i=>$inscription)
			<div class="{{$inscription->id}}" @if ($inscription->estado=='Retirado') style="background-color:rgba(156,39,176,0.5);" @endif @if ($inscription->debit()) style="background-color:rgba(244,67,54,0.5);" @elseif ($inscription->debitNext()) style="background-color:rgba(255,152,0,0.5);" @else style="background-color:rgba(76,175,80,0.5);" @endif>
				<a target="_blank" href="{{url('admin/student/search/'.$inscription->people->id)}}">{{$inscription->people->nombrecompleto()}}</a>
			</div>
			@endforeach
		</div>
	</div>
	<div class="notas">
		<div class="conte">
			<div class="header">
				@foreach ($asistencias as $k=>$asistencia)
				<div class="modulos">
					<div class="materias">
						<div class="registros {{$asistencia->id}}" style="">
							<div class="fecha_vertical">{{\Carbon\Carbon::parse($asistencia->fecha)->format('d/m/y')}}
							</div>
							<div class="asignatura">{{$asistencia->subject->nombre}}</div>
							<div class="dia_inicial">{{strtoupper(\Jenssegers\Date\Date::parse($asistencia->fecha)->format('l')[0])}}{{\Jenssegers\Date\Date::parse($asistencia->fecha)->format('l')[1]}}</div>
						</div>
					</div>
				</div>
				<?php $cont[$k]=0; ?>
				@endforeach
			</div>
			<div class="body">
				@foreach($inscriptions as $i=>$inscription)
				<div>
					<div class="asis_hover" ins="{{$inscription->id}}">
						@foreach ($asistencias as $k=>$asistencia)
						<div class="body_modulos">
							@if ($inscription->asistencia($asistencia->subject_id,$asistencia->people_id,$asistencia->fecha))
							<div asis="{{$asistencia->id}}" @if ($inscription->estado=='Retirado') style="background-color:rgba(156,39,176,0.4);" @endif @if ($inscription->debit()) style="background-color:rgba(244,67,54,0.4);" @elseif ($inscription->debitNext()) style="background-color:rgba(255,152,0,0.4);" @else style="background-color:rgba(76,175,80,0.4);" @endif>✔</div>
							<?php $cont[$k] = $cont[$k]+1; ?>
							@else
							@if ($asistencia->fecha>=$inscription->fecha_ingreso)
							<div asis="{{$asistencia->id}}" @if ($inscription->estado=='Retirado') style="background-color:rgba(156,39,176,0.4);" @endif @if ($inscription->debit()) style="background-color:rgba(244,67,54,0.4);" @elseif ($inscription->debitNext()) style="background-color:rgba(255,152,0,0.4);" @else style="background-color:rgba(76,175,80,0.4);" @endif>✗</div>
							@else
							<div asis="{{$asistencia->id}}" @if ($inscription->estado=='Retirado') style="background-color:rgba(156,39,176,0.4);" @endif @if ($inscription->debit()) style="background-color:rgba(244,67,54,0.4);" @elseif ($inscription->debitNext()) style="background-color:rgba(255,152,0,0.4);" @else style="background-color:rgba(76,175,80,0.4);" @endif>-</div>
							@endif
							@endif
						</div>
						@endforeach
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection