@extends('layouts.admin')
@section('adminjs')
{!!Html::script('js/score.js')!!}
<link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
<link href="https://cdn.datatables.net/fixedcolumns/3.2.2/css/fixedColumns.dataTables.min.css" rel="stylesheet"/>
@endsection
@section('content')
<br>
<div class="tabla_assistance_ver">
	<table class="table table-hover table-condensed" style="width:100%">
		<thead>
			<th>Nombre</th>
			<th>Asis</th>
			<th>Estado</th>
			@foreach ($asistencias as $k=>$asistencia)
			<th class="contenedor_fechas">
				<div class="fecha_vertical">{{\Carbon\Carbon::parse($asistencia->fecha)->format('d/m/y')}}
				</div>
				<div class="asignatura_vertical">{{$asistencia->subject->nombre}}</div>
				<p class="dia_inicial">{{strtoupper(\Jenssegers\Date\Date::parse($asistencia->fecha)->format('l')[0])}}{{\Jenssegers\Date\Date::parse($asistencia->fecha)->format('l')[1]}}</p>
			</th>
			<?php $cont[$k]=0; ?>
			@endforeach
		</thead>
		<tbody>
			@foreach($inscriptions as $i=>$inscription)
			<tr
			@if ($inscription->estado == 'Retirado')
			style="background-color: #A460B8;"
			@endif @if ($inscription->debit())
			style="background-color: #FF7878;" 
			@elseif ($inscription->debitNext())
			style="background-color: #FFF961;" 
			@else
			style="background-color: #91F47E;" 
			@endif
			>
			<td><b><a href="{{url('admin/student/search/'.$inscription->people->id)}}" style="color: #0800AB">{{$inscription->people->nombrecompleto()}}</a></b></td>
			<td>{{$inscription->asisCont()}}</td>
			<td>{{$inscription->estado}}</td>
			@foreach ($asistencias as $k=>$asistencia)
			@if ($inscription->asistencia($asistencia->subject_id,$asistencia->people_id,$asistencia->fecha)) 
			<td class="al_r">✔</td>
			<?php $cont[$k] = $cont[$k]+1; ?>
			@else
			@if ($asistencia->fecha>=$inscription->fecha_ingreso)
			<td class="al_r">✗</td>
			@else
			<td class="al_r">-</td>
			@endif
			@endif
			@endforeach
		</tr>
		@endforeach
		<tr>
			<td></td>
			<td></td>
			<td><b>Conteo:</b></td>
			@foreach ($asistencias as $k=>$asistencia)
			<td class="al_r">{{$cont[$k]}}</td>
			@endforeach
		</tr>
	</tbody>
</table>
</div>
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
	.contenedor_fechas{position:relative;height:130px;width:50px;}
	.fecha_vertical{transform:rotate(-90deg);width:170px;position: absolute;left:-55px;bottom:110px;height:16px;overflow: hidden; font-size:13px;}
	.asignatura_vertical{transform:rotate(-90deg);width:170px;position: absolute;left:-70px;bottom:110px;height:16px;overflow: hidden; font-size:13px;}
	.dia_inicial{margin: 0;font-size: 12px;}
</style>
@endsection